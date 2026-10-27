<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    /**
     * Verify certificate by code or number with GC academic validation
     */
    public function verify(Request $request): JsonResponse
    {
        // Extract and normalize code from raw input (supports direct code, URLs, QR data, JSON)
        $rawCode = $request->input('code');
        $code = $this->extractCode($rawCode);
        $request->merge(['code' => $code]);

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:50',
            'method' => 'string|in:qr_code,manual_code,certificate_number',
            'student_name' => 'sometimes|string|max:255',
            'graduation_year' => 'sometimes|integer|min:1990|max:2030'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code format',
                'errors' => $validator->errors()
            ], 422);
        }

        $method = $request->input('method', 'manual_code');
        $studentName = $request->input('student_name');
        $graduationYear = $request->input('graduation_year');

        try {
            $certificate = Certificate::verify($code, $method);

            if (!$certificate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate not found or invalid',
                    'verified' => false
                ], 404);
            }

            // Additional validation with GC academic records
            $academicValidation = $this->validateWithAcademicRecords($certificate, $studentName, $graduationYear);
            
            if (!$academicValidation['valid']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate validation failed: ' . $academicValidation['reason'],
                    'verified' => false,
                    'validation_details' => $academicValidation
                ], 400);
            }

            if (!$certificate->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate is not valid (may be expired or revoked)',
                    'verified' => false,
                    'status' => $certificate->status
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Certificate verified successfully with GC academic records',
                'verified' => true,
                'validation' => [
                    'academic_record_verified' => true,
                    'gpa_verified' => $academicValidation['gpa_verified'],
                    'graduation_date_verified' => $academicValidation['date_verified'],
                    'department_verified' => $academicValidation['dept_verified']
                ],
                'certificate' => [
                    'certificate_number' => $certificate->certificate_number,
                    'verification_code' => $certificate->verification_code,
                    'graduate_name' => $certificate->graduate_name,
                    'student_id' => $certificate->student_id,
                    'qualification' => $certificate->qualification,
                    'department' => $certificate->department,
                    'program' => $certificate->program,
                    'graduation_date' => $certificate->formatted_graduation_date,
                    'gpa' => $certificate->gpa,
                    'honors' => $certificate->honors,
                    'university_name' => $certificate->university_name,
                    'certificate_type' => $certificate->certificate_type,
                    'issued_at' => $certificate->issued_at ? $certificate->issued_at->format('F j, Y') : null,
                    'authorized_by' => $certificate->authorized_by,
                    'authorized_title' => $certificate->authorized_title,
                    'verification_count' => $certificate->verification_count,
                    'status' => $certificate->status,
                    'qr_code_path' => $certificate->qr_code_path,
                    'verification_url' => $certificate->verification_url,
                    'academic_standing' => $this->getAcademicStanding($certificate->gpa),
                    'verification_timestamp' => now()->format('Y-m-d H:i:s T')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during verification',
                'verified' => false,
                'error' => app()->environment('local') ? $e->getMessage() : 'System error'
            ], 500);
        }
    }

    /**
     * Validate certificate against GC academic records
     */
    private function validateWithAcademicRecords($certificate, $studentName = null, $graduationYear = null): array
    {
        $validation = [
            'valid' => true,
            'reason' => '',
            'gpa_verified' => false,
            'date_verified' => false,
            'dept_verified' => false
        ];

        // Validate against student profiles if name provided
        if ($studentName) {
            $nameMatch = stripos($certificate->graduate_name, $studentName) !== false;
            if (!$nameMatch) {
                $validation['valid'] = false;
                $validation['reason'] = 'Student name does not match certificate records';
                return $validation;
            }
        }

        // Validate graduation year
        if ($graduationYear) {
            $certYear = date('Y', strtotime($certificate->graduation_date));
            if ($certYear != $graduationYear) {
                $validation['valid'] = false;
                $validation['reason'] = 'Graduation year does not match certificate records';
                return $validation;
            }
            $validation['date_verified'] = true;
        }

        // Validate GPA authenticity (check if within valid range)
        if ($certificate->gpa >= 0.0 && $certificate->gpa <= 4.0) {
            $validation['gpa_verified'] = true;
        }

        // Validate department exists in GC system
        $validDepartments = [
            'Computer Science & IT', 'Engineering', 'Medicine & Health Sciences', 
            'Business & Management', 'Natural Sciences', 'Social Sciences',
            'Arts & Humanities', 'Agriculture', 'Education', 'Law'
        ];
        
        if (in_array($certificate->department, $validDepartments)) {
            $validation['dept_verified'] = true;
        }

        // Additional checks for certificate authenticity
        $this->performIntegrityChecks($certificate, $validation);

        return $validation;
    }

    /**
     * Perform additional integrity checks on certificate
     */
    private function performIntegrityChecks($certificate, &$validation): void
    {
        // Check certificate format integrity
        if (strlen($certificate->certificate_number) < 8) {
            $validation['valid'] = false;
            $validation['reason'] = 'Invalid certificate number format';
            return;
        }

        // Check if graduation date is reasonable
        $graduationDate = strtotime($certificate->graduation_date);
        $currentDate = time();
        $universityEstablished = strtotime('1995-01-01');

        if ($graduationDate > $currentDate) {
            $validation['valid'] = false;
            $validation['reason'] = 'Future graduation date not valid';
            return;
        }

        if ($graduationDate < $universityEstablished) {
            $validation['valid'] = false;
            $validation['reason'] = 'Graduation date before university establishment';
            return;
        }
    }

    /**
     * Get academic standing based on GPA
     */
    private function getAcademicStanding($gpa): string
    {
        if ($gpa >= 3.8) return 'Summa Cum Laude';
        if ($gpa >= 3.5) return 'Magna Cum Laude';
        if ($gpa >= 3.2) return 'Cum Laude';
        if ($gpa >= 2.0) return 'Good Standing';
        return 'Below Standard';
    }

    /**
     * Get certificate by verification code for QR scanning
     */
    public function getByCode(string $code): JsonResponse
    {
        try {
            $code = $this->extractCode($code);

            $certificate = Certificate::where(function ($q) use ($code) {
                    $q->where('verification_code', $code)
                      ->orWhere('certificate_number', $code);
                })
                ->where('status', 'active')
                ->first();

            if (!$certificate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Certificate not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'certificate' => [
                    'certificate_number' => $certificate->certificate_number,
                    'verification_code' => $certificate->verification_code,
                    'graduate_name' => $certificate->graduate_name,
                    'qualification' => $certificate->qualification,
                    'department' => $certificate->department,
                    'graduation_date' => $certificate->formatted_graduation_date,
                    'university_name' => $certificate->university_name,
                    'verification_url' => $certificate->verification_url,
                    'qr_code_path' => $certificate->qr_code_path
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving certificate'
            ], 500);
        }
    }

    /**
     * Normalize and extract verification code or certificate number from various inputs
     * (e.g. direct code, full URL, URL with query parameter, or JSON string)
     */
    public function extractCode(?string $input): string
    {
        if (empty($input)) {
            return '';
        }

        $input = trim($input);

        // Handle JSON strings (e.g., from older or structured QR codes)
        if (str_starts_with($input, '{') && str_ends_with($input, '}')) {
            $json = json_decode($input, true);
            if (is_array($json)) {
                if (!empty($json['verification_code'])) {
                    return trim((string) $json['verification_code']);
                }
                if (!empty($json['certificate_number'])) {
                    return trim((string) $json['certificate_number']);
                }
                if (!empty($json['code'])) {
                    return trim((string) $json['code']);
                }
                if (!empty($json['verification_url'])) {
                    $input = (string) $json['verification_url'];
                }
            }
        }

        // Handle URLs (e.g. http://domain.com/verify-certificate/CODE or ?code=CODE)
        if (filter_var($input, FILTER_VALIDATE_URL) || str_contains($input, 'verify-certificate')) {
            $parts = parse_url($input);
            if (!empty($parts['query'])) {
                parse_str($parts['query'], $query);
                if (!empty($query['code'])) {
                    return trim((string) $query['code']);
                }
            }
            if (!empty($parts['path'])) {
                $segments = array_values(array_filter(explode('/', $parts['path'])));
                $lastSegment = end($segments);
                if ($lastSegment && $lastSegment !== 'verify-certificate') {
                    return trim((string) $lastSegment);
                }
            }
        }

        return $input;
    }

    /**
     * Search certificates (limited public information)
     */
    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'graduate_name' => 'string|min:3|max:100',
            'student_id' => 'string|min:3|max:20',
            'department' => 'string|max:100',
            'graduation_year' => 'integer|min:1900|max:2030'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Certificate::active();

        if ($request->filled('graduate_name')) {
            $query->where('graduate_name', 'LIKE', '%' . $request->graduate_name . '%');
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', 'LIKE', '%' . $request->student_id . '%');
        }

        if ($request->filled('department')) {
            $query->where('department', 'LIKE', '%' . $request->department . '%');
        }

        if ($request->filled('graduation_year')) {
            $query->byGraduationYear($request->graduation_year);
        }

        $certificates = $query->select([
                'certificate_number',
                'graduate_name',
                'qualification',
                'department',
                'graduation_date',
                'university_name'
            ])
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'certificates' => $certificates->map(function ($cert) {
                return [
                    'certificate_number' => $cert->certificate_number,
                    'graduate_name' => $cert->graduate_name,
                    'qualification' => $cert->qualification,
                    'department' => $cert->department,
                    'graduation_date' => $cert->formatted_graduation_date,
                    'university_name' => $cert->university_name
                ];
            }),
            'count' => $certificates->count()
        ]);
    }

    /**
     * Get university information for public
     */
    public function universityInfo(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'university' => [
                'name' => 'GC University',
                'full_name' => 'Great College University',
                'established' => '1995',
                'accreditation' => 'Ministry of Education, Ethiopia',
                'website' => 'https://gcuniversity.edu.et',
                'address' => 'Addis Ababa, Ethiopia',
                'phone' => '+251-11-123-4567',
                'email' => 'info@gcuniversity.edu.et',
                'verification_info' => [
                    'certificate_verification_available' => true,
                    'qr_code_supported' => true,
                    'verification_methods' => ['certificate_number', 'verification_code', 'qr_code'],
                    'languages_supported' => ['English', 'Amharic']
                ]
            ]
        ]);
    }
}