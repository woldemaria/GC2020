<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate;
use Carbon\Carbon;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certificates = [
            [
                'graduate_name' => 'Abebe Kebede',
                'student_id' => 'GC2021001',
                'qualification' => 'Bachelor of Science in Computer Science',
                'department' => 'Computer Science & IT',
                'program' => 'Computer Science',
                'graduation_date' => '2023-07-15',
                'gpa' => 3.85,
                'honors' => 'Magna Cum Laude',
                'certificate_type' => 'degree',
                'language' => 'both',
                'authorized_by' => 'Dr. Girma Teshome',
                'authorized_title' => 'Dean of Engineering',
                'issued_at' => Carbon::parse('2023-07-20'),
            ],
            [
                'graduate_name' => 'Meron Tadesse',
                'student_id' => 'GC2021002',
                'qualification' => 'Bachelor of Business Administration',
                'department' => 'Business & Management',
                'program' => 'Business Administration',
                'graduation_date' => '2023-07-15',
                'gpa' => 3.72,
                'honors' => 'Cum Laude',
                'certificate_type' => 'degree',
                'language' => 'english',
                'authorized_by' => 'Prof. Sarah Johnson',
                'authorized_title' => 'Dean of Business',
                'issued_at' => Carbon::parse('2023-07-20'),
            ],
            [
                'graduate_name' => 'Daniel Haile',
                'student_id' => 'GC2020003',
                'qualification' => 'Bachelor of Engineering in Civil Engineering',
                'department' => 'Engineering',
                'program' => 'Civil Engineering',
                'graduation_date' => '2022-12-10',
                'gpa' => 3.91,
                'honors' => 'Summa Cum Laude',
                'certificate_type' => 'degree',
                'language' => 'english',
                'authorized_by' => 'Dr. Michael Brown',
                'authorized_title' => 'Head of Engineering Department',
                'issued_at' => Carbon::parse('2022-12-15'),
            ],
            [
                'graduate_name' => 'Hanan Mohammed',
                'student_id' => 'GC2021004',
                'qualification' => 'Bachelor of Arts in Psychology',
                'department' => 'Psychology',
                'program' => 'Clinical Psychology',
                'graduation_date' => '2023-07-15',
                'gpa' => 3.68,
                'certificate_type' => 'degree',
                'language' => 'both',
                'authorized_by' => 'Dr. Almaz Tesfaye',
                'authorized_title' => 'Department Head',
                'issued_at' => Carbon::parse('2023-07-20'),
            ],
            [
                'graduate_name' => 'Samuel Worku',
                'student_id' => 'GC2020005',
                'qualification' => 'Bachelor of Science in Biology',
                'department' => 'Biology',
                'program' => 'Molecular Biology',
                'graduation_date' => '2022-12-10',
                'gpa' => 3.79,
                'honors' => 'Cum Laude',
                'certificate_type' => 'degree',
                'language' => 'english',
                'authorized_by' => 'Prof. David Wilson',
                'authorized_title' => 'Dean of Sciences',
                'issued_at' => Carbon::parse('2022-12-15'),
            ],
            [
                'graduate_name' => 'Bethlehem Tekle',
                'student_id' => 'GC2021006',
                'qualification' => 'Bachelor of Fine Arts',
                'department' => 'Art & Design',
                'program' => 'Graphic Design',
                'graduation_date' => '2023-07-15',
                'gpa' => 3.94,
                'honors' => 'Summa Cum Laude',
                'certificate_type' => 'degree',
                'language' => 'both',
                'authorized_by' => 'Prof. Emily Davis',
                'authorized_title' => 'Head of Arts Department',
                'issued_at' => Carbon::parse('2023-07-20'),
            ],
            [
                'graduate_name' => 'Yohannes Alemayehu',
                'student_id' => 'GC2019007',
                'qualification' => 'Master of Science in Computer Science',
                'department' => 'Computer Science & IT',
                'program' => 'Artificial Intelligence',
                'graduation_date' => '2021-12-15',
                'gpa' => 3.88,
                'honors' => 'Magna Cum Laude',
                'certificate_type' => 'masters',
                'language' => 'english',
                'authorized_by' => 'Dr. Girma Teshome',
                'authorized_title' => 'Dean of Engineering',
                'issued_at' => Carbon::parse('2021-12-20'),
            ],
            [
                'graduate_name' => 'Rahel Gebre',
                'student_id' => 'GC2022008',
                'qualification' => 'Certificate in Digital Marketing',
                'department' => 'Business & Management',
                'program' => 'Digital Marketing',
                'graduation_date' => '2024-03-30',
                'gpa' => 3.56,
                'certificate_type' => 'certificate',
                'language' => 'english',
                'authorized_by' => 'Prof. Sarah Johnson',
                'authorized_title' => 'Dean of Business',
                'issued_at' => Carbon::parse('2024-04-05'),
            ],
            [
                'graduate_name' => 'Tekle Berhe',
                'student_id' => 'GC2018009',
                'qualification' => 'Doctor of Philosophy in Engineering',
                'department' => 'Engineering',
                'program' => 'Mechanical Engineering',
                'graduation_date' => '2022-05-20',
                'gpa' => 3.95,
                'honors' => 'Summa Cum Laude',
                'certificate_type' => 'phd',
                'language' => 'english',
                'authorized_by' => 'Dr. Michael Brown',
                'authorized_title' => 'Head of Engineering Department',
                'issued_at' => Carbon::parse('2022-05-25'),
                'additional_notes' => 'Dissertation: Advanced Materials in Sustainable Engineering',
            ],
            [
                'graduate_name' => 'Selamawit Negash',
                'student_id' => 'GC2020010',
                'qualification' => 'Bachelor of Science in Nursing',
                'department' => 'Health Sciences',
                'program' => 'Nursing',
                'graduation_date' => '2023-12-15',
                'gpa' => 3.82,
                'honors' => 'Magna Cum Laude',
                'certificate_type' => 'degree',
                'language' => 'both',
                'authorized_by' => 'Dr. Helen Thomas',
                'authorized_title' => 'Dean of Health Sciences',
                'issued_at' => Carbon::parse('2023-12-20'),
            ]
        ];

        foreach ($certificates as $certData) {
            // Generate unique certificate number and verification code
            $certData['certificate_number'] = Certificate::generateCertificateNumber(
                date('Y', strtotime($certData['graduation_date']))
            );
            $certData['verification_code'] = Certificate::generateVerificationCode();
            
            // Set university info
            $certData['university_name'] = 'GC University';
            $certData['university_address'] = 'Addis Ababa, Ethiopia';
            
            // Set status
            $certData['status'] = 'active';
            
            Certificate::create($certData);
        }

        // Create some verification records for testing
        $certificates = Certificate::all();
        foreach ($certificates as $certificate) {
            // Simulate some verifications
            $verificationCount = rand(1, 15);
            
            for ($i = 0; $i < $verificationCount; $i++) {
                $certificate->verifications()->create([
                    'verifier_ip' => '192.168.1.' . rand(1, 254),
                    'verifier_user_agent' => 'Mozilla/5.0 (Test Browser)',
                    'verification_method' => ['qr_code', 'manual_code', 'certificate_number'][rand(0, 2)],
                    'verified_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))
                ]);
            }
            
            // Update verification count
            $certificate->update([
                'verification_count' => $verificationCount,
                'last_verified_at' => $certificate->verifications()->latest('verified_at')->first()->verified_at ?? null
            ]);
        }
    }
}