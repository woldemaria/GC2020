<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateVerification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateManagementController extends Controller
{
    /**
     * List all certificates with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $query = Certificate::with(['verifications' => function ($q) {
            $q->latest()->limit(5);
        }]);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', 'LIKE', '%' . $request->department . '%');
        }

        if ($request->filled('graduation_year')) {
            $query->byGraduationYear($request->graduation_year);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('graduate_name', 'LIKE', "%{$search}%")
                  ->orWhere('certificate_number', 'LIKE', "%{$search}%")
                  ->orWhere('student_id', 'LIKE', "%{$search}%");
            });
        }

        $certificates = $query->latest()
            ->paginate($request->get('per_page', 15));

        return response()->json($certificates);
    }

    /**
     * Create a new certificate
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'graduate_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
            'qualification' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'graduation_date' => 'required|date',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'honors' => 'nullable|string|max:100',
            'certificate_type' => 'required|in:diploma,degree,masters,phd,certificate',
            'language' => 'required|in:english,amharic,both',
            'additional_notes' => 'nullable|string|max:1000',
            'authorized_by' => 'required|string|max:255',
            'authorized_title' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:today'
        ]);

        try {
            // Generate unique identifiers
            $validated['certificate_number'] = Certificate::generateCertificateNumber(
                date('Y', strtotime($validated['graduation_date']))
            );
            $validated['verification_code'] = Certificate::generateVerificationCode();
            $validated['issued_at'] = now();

            $certificate = Certificate::create($validated);

            // Generate QR Code
            $this->generateQrCode($certificate);

            return response()->json([
                'success' => true,
                'message' => 'Certificate created successfully',
                'certificate' => $certificate
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific certificate
     */
    public function show(Certificate $certificate): JsonResponse
    {
        $certificate->load('verifications');
        
        return response()->json([
            'success' => true,
            'certificate' => $certificate,
            'verification_stats' => CertificateVerification::getStats($certificate->id)
        ]);
    }

    /**
     * Update certificate
     */
    public function update(Request $request, Certificate $certificate): JsonResponse
    {
        $validated = $request->validate([
            'graduate_name' => 'string|max:255',
            'qualification' => 'string|max:255',
            'department' => 'string|max:255',
            'program' => 'string|max:255',
            'graduation_date' => 'date',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'honors' => 'nullable|string|max:100',
            'additional_notes' => 'nullable|string|max:1000',
            'authorized_by' => 'string|max:255',
            'authorized_title' => 'string|max:255',
            'expires_at' => 'nullable|date|after:today',
            'status' => 'in:active,revoked,expired'
        ]);

        try {
            $certificate->update($validated);

            // Regenerate QR code if important details changed
            if (array_intersect_key($validated, array_flip([
                'graduate_name', 'qualification', 'graduation_date'
            ]))) {
                $this->generateQrCode($certificate);
            }

            return response()->json([
                'success' => true,
                'message' => 'Certificate updated successfully',
                'certificate' => $certificate->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete certificate
     */
    public function destroy(Certificate $certificate): JsonResponse
    {
        try {
            // Delete QR code file if exists
            if ($certificate->qr_code_path && Storage::exists($certificate->qr_code_path)) {
                Storage::delete($certificate->qr_code_path);
            }

            $certificate->delete();

            return response()->json([
                'success' => true,
                'message' => 'Certificate deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk operations
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:revoke,activate,delete',
            'certificate_ids' => 'required|array|min:1',
            'certificate_ids.*' => 'exists:certificates,id'
        ]);

        try {
            $certificates = Certificate::whereIn('id', $validated['certificate_ids']);
            $count = $certificates->count();

            switch ($validated['action']) {
                case 'revoke':
                    $certificates->update(['status' => 'revoked']);
                    $message = "Successfully revoked {$count} certificates";
                    break;

                case 'activate':
                    $certificates->update(['status' => 'active']);
                    $message = "Successfully activated {$count} certificates";
                    break;

                case 'delete':
                    // Delete QR codes
                    foreach ($certificates->get() as $cert) {
                        if ($cert->qr_code_path && Storage::exists($cert->qr_code_path)) {
                            Storage::delete($cert->qr_code_path);
                        }
                    }
                    $certificates->delete();
                    $message = "Successfully deleted {$count} certificates";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get certificate statistics
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_certificates' => Certificate::count(),
            'active_certificates' => Certificate::where('status', 'active')->count(),
            'revoked_certificates' => Certificate::where('status', 'revoked')->count(),
            'expired_certificates' => Certificate::where('status', 'expired')->count(),
            'total_verifications' => CertificateVerification::count(),
            'verifications_today' => CertificateVerification::whereDate('verified_at', today())->count(),
            'verifications_this_week' => CertificateVerification::where('verified_at', '>=', now()->subWeek())->count(),
            'by_department' => Certificate::selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->pluck('count', 'department'),
            'by_type' => Certificate::selectRaw('certificate_type, COUNT(*) as count')
                ->groupBy('certificate_type')
                ->pluck('count', 'certificate_type'),
            'recent_verifications' => CertificateVerification::with('certificate:id,graduate_name,certificate_number')
                ->latest('verified_at')
                ->limit(10)
                ->get()
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Generate QR code for certificate
     */
    private function generateQrCode(Certificate $certificate): void
    {
        $certificate->generateQrCode();
    }
}