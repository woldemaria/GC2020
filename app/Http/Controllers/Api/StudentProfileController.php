<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of student profiles.
     */
    public function index(Request $request): JsonResponse
    {
        $query = StudentProfile::orderBy('name');

        // Filter by major
        if ($request->has('major') && $request->major) {
            $query->where('major', $request->major);
        }

        // Filter by graduation year
        if ($request->has('graduation_year') && $request->graduation_year) {
            $query->where('graduation_year', $request->graduation_year);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured === 'true') {
            $query->where('is_featured', true);
        }

        $profiles = $query->paginate($request->get('per_page', 12));

        return response()->json($profiles);
    }

    /**
     * Display the specified student profile.
     */
    public function show(string $id): JsonResponse
    {
        $profile = StudentProfile::findOrFail($id);
        return response()->json($profile);
    }

    /**
     * Get featured student profiles.
     */
    public function featured(): JsonResponse
    {
        $profiles = StudentProfile::where('is_featured', true)
            ->orderBy('name')
            ->limit(6)
            ->get();

        return response()->json($profiles);
    }

    /**
     * Get unique majors for filtering.
     */
    public function majors(): JsonResponse
    {
        $majors = StudentProfile::distinct()
            ->orderBy('major')
            ->pluck('major')
            ->values();

        return response()->json($majors);
    }

    /**
     * Get unique graduation years for filtering.
     */
    public function graduationYears(): JsonResponse
    {
        $years = StudentProfile::distinct()
            ->orderBy('graduation_year')
            ->pluck('graduation_year')
            ->values();

        return response()->json($years);
    }
}
