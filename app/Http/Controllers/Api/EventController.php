<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of published university events.
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category' => 'sometimes|string',
            'upcoming' => 'sometimes|boolean',
            'featured' => 'sometimes|boolean',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid filter parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Event::published();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        if ($request->boolean('upcoming', true)) {
            $query->upcoming();
        }

        $query->orderBy('event_date', 'asc');

        $perPage = $request->integer('per_page', 15);
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Events retrieved successfully',
            'events' => $events->items(),
            'pagination' => [
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'per_page' => $events->perPage(),
                'total' => $events->total(),
                'from' => $events->firstItem(),
                'to' => $events->lastItem(),
            ],
        ]);
    }

    /**
     * Display the specified event.
     */
    public function show(string $slug): JsonResponse
    {
        $event = Event::published()->where('slug', $slug)->first();

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Event retrieved successfully',
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'description' => $event->description,
                'short_description' => $event->short_description,
                'event_date' => $event->event_date,
                'formatted_date' => $event->formatted_date,
                'day_of_week' => $event->day_of_week,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'formatted_time' => $event->formatted_time,
                'location' => $event->location,
                'venue' => $event->venue,
                'image' => $event->image,
                'category' => $event->category,
                'max_attendees' => $event->max_attendees,
                'registered_count' => $event->registered_count,
                'remaining_spots' => $event->remaining_spots,
                'registration_deadline' => $event->registration_deadline,
                'is_featured' => $event->is_featured,
                'is_published' => $event->is_published,
                'is_registration_open' => $event->isRegistrationOpen(),
                'is_past' => $event->isPast(),
                'requirements' => $event->requirements ?? [],
                'highlights' => $event->highlights ?? [],
                'contact_email' => $event->contact_email,
                'contact_phone' => $event->contact_phone,
                'organizer' => $event->organizer,
                'registration_url' => $event->registration_url,
                'created_at' => $event->created_at,
            ],
        ]);
    }

    /**
     * Register a user for an event.
     */
    public function register(Request $request, string $slug): JsonResponse
    {
        $event = Event::published()->where('slug', $slug)->first();

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        if (!$event->isRegistrationOpen()) {
            $reason = !$event->is_published
                ? 'This event is not currently open for registration.'
                : (($event->registration_deadline && \Carbon\Carbon::parse($event->registration_deadline)->isPast())
                    ? 'The registration deadline has passed.'
                    : 'This event has reached maximum capacity.');

            return response()->json([
                'success' => false,
                'message' => $reason,
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:100',
            'student_email' => 'required|email|max:100',
            'student_phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'year_of_study' => 'nullable|string|max:20',
            'dietary_requirements' => 'nullable|string|max:200',
            'emergency_contact' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid registration data',
                'errors' => $validator->errors()
            ], 422);
        }

        // Prevent duplicate registration by email for the same event
        $existing = DB::table('event_registrations')
            ->where('event_id', $event->id)
            ->where('student_email', $request->student_email)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.',
            ], 409);
        }

        try {
            DB::beginTransaction();

            $registrationId = DB::table('event_registrations')->insertGetId([
                'event_id' => $event->id,
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'student_phone' => $request->student_phone,
                'department' => $request->department,
                'year_of_study' => $request->year_of_study,
                'dietary_requirements' => $request->dietary_requirements,
                'emergency_contact' => $request->emergency_contact,
                'registration_status' => 'confirmed',
                'registered_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Event::where('id', $event->id)
                ->increment('registered_count');

            DB::commit();

            $registrationNumber = 'EVT' . str_pad($registrationId, 6, '0', STR_PAD_LEFT);

            return response()->json([
                'success' => true,
                'message' => 'Successfully registered for the event!',
                'registration' => [
                    'id' => $registrationId,
                    'registration_number' => $registrationNumber,
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'status' => 'confirmed',
                    'registered_at' => now()->format('F j, Y g:i A'),
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
