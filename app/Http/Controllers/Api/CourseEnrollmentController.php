<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CourseEnrollmentController extends Controller
{
    /**
     * Store a new course enrollment
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:100',
            'student_email' => 'required|email|max:100',
            'student_phone' => 'nullable|string|max:20',
            'student_id' => 'nullable|string|max:20',
            'course_name' => 'required|string|max:200',
            'department' => 'required|string|max:100',
            'program_type' => 'required|string|in:Undergraduate,Graduate,Professional',
            'motivation' => 'nullable|string|max:1000',
            'prerequisites_met' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if student already enrolled in this course
            $existingEnrollment = CourseEnrollment::where('student_email', $request->student_email)
                ->where('course_name', $request->course_name)
                ->first();

            if ($existingEnrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already enrolled or have a pending application for this course',
                    'enrollment_status' => $existingEnrollment->status
                ], 409);
            }

            $enrollment = CourseEnrollment::create([
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'student_phone' => $request->student_phone,
                'student_id' => $request->student_id,
                'course_name' => $request->course_name,
                'department' => $request->department,
                'program_type' => $request->program_type,
                'motivation' => $request->motivation,
                'prerequisites_met' => $request->prerequisites_met,
                'status' => 'pending',
                'enrolled_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Course enrollment application submitted successfully!',
                'enrollment' => [
                    'id' => $enrollment->id,
                    'course_name' => $enrollment->course_name,
                    'department' => $enrollment->department,
                    'status' => $enrollment->status,
                    'enrolled_at' => $enrollment->enrolled_at->format('F j, Y'),
                    'application_number' => 'ENR' . str_pad($enrollment->id, 6, '0', STR_PAD_LEFT)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your enrollment'
            ], 500);
        }
    }

    /**
     * Get enrollment status by email and course
     */
    public function getStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'student_email' => 'required|email',
            'course_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        $enrollment = CourseEnrollment::where('student_email', $request->student_email)
            ->where('course_name', $request->course_name)
            ->first();

        if (!$enrollment) {
            return response()->json([
                'success' => false,
                'message' => 'No enrollment found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'enrollment' => [
                'id' => $enrollment->id,
                'course_name' => $enrollment->course_name,
                'department' => $enrollment->department,
                'status' => $enrollment->status,
                'status_label' => $enrollment->status_label,
                'enrolled_at' => $enrollment->enrolled_at->format('F j, Y'),
                'approved_at' => $enrollment->approved_at?->format('F j, Y'),
                'application_number' => 'ENR' . str_pad($enrollment->id, 6, '0', STR_PAD_LEFT),
                'admin_notes' => $enrollment->admin_notes
            ]
        ]);
    }

    /**
     * Get student's enrollments by email
     */
    public function getByEmail($email): JsonResponse
    {
        $enrollments = CourseEnrollment::where('student_email', $email)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'enrollments' => $enrollments->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'course_name' => $enrollment->course_name,
                    'department' => $enrollment->department,
                    'program_type' => $enrollment->program_type,
                    'status' => $enrollment->status,
                    'status_label' => $enrollment->status_label,
                    'status_color' => $enrollment->status_color,
                    'enrolled_at' => $enrollment->enrolled_at->format('F j, Y'),
                    'approved_at' => $enrollment->approved_at?->format('F j, Y'),
                    'application_number' => 'ENR' . str_pad($enrollment->id, 6, '0', STR_PAD_LEFT)
                ];
            })
        ]);
    }

    /**
     * Admin: list all enrollments with filters and pagination
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $query = CourseEnrollment::query()->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', 'like', '%' . $request->department . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('student_email', 'like', "%{$search}%")
                    ->orWhere('course_name', 'like', "%{$search}%");
            });
        }

        $enrollments = $query->paginate($request->get('per_page', 15));

        return response()->json(array_merge(
            $enrollments->toArray(),
            ['success' => true]
        ));
    }

    /**
     * Admin: update enrollment status
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $enrollment = CourseEnrollment::findOrFail($id);

        $updateData = [
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $enrollment->admin_notes,
        ];

        if ($validated['status'] === 'approved') {
            $updateData['approved_at'] = now();
        }

        $enrollment->update($updateData);

        return response()->json([
            'success' => true,
            'message' => "Enrollment #{$id} marked as {$validated['status']}.",
            'enrollment' => $enrollment->fresh(),
        ]);
    }

    /**
     * Admin: bulk actions on enrollments
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $ids = $validated['ids'];
        $action = $validated['action'];

        $count = match ($action) {
            'approve' => CourseEnrollment::whereIn('id', $ids)->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]),
            'reject' => CourseEnrollment::whereIn('id', $ids)->update(['status' => 'rejected']),
            'delete' => CourseEnrollment::whereIn('id', $ids)->delete(),
            default => 0,
        };

        return response()->json([
            'success' => true,
            'message' => ucfirst($action) . " applied to {$count} enrollments.",
        ]);
    }
}
