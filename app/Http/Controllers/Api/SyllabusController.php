<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SyllabusController extends Controller
{
    /**
     * Get syllabus by course name and department
     */
    public function show(Request $request): JsonResponse
    {
        $courseName = $request->query('course_name');
        $department = $request->query('department');

        if (!$courseName) {
            return response()->json([
                'success' => false,
                'message' => 'Course name is required'
            ], 422);
        }

        $syllabus = Syllabus::active()
            ->where('course_name', $courseName)
            ->when($department, function ($query, $department) {
                return $query->where('department', $department);
            })
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->first();

        if (!$syllabus) {
            // Return a generic syllabus structure if none found
            return $this->getGenericSyllabus($courseName, $department);
        }

        return response()->json([
            'success' => true,
            'syllabus' => [
                'course_name' => $syllabus->course_name,
                'course_code' => $syllabus->course_code,
                'full_course_name' => $syllabus->full_course_name,
                'department' => $syllabus->department,
                'program_type' => $syllabus->program_type,
                'credits' => $syllabus->credits,
                'instructor' => $syllabus->instructor,
                'instructor_email' => $syllabus->instructor_email,
                'course_description' => $syllabus->course_description,
                'learning_objectives' => $syllabus->learning_objectives,
                'course_outline' => $syllabus->course_outline,
                'assessment_methods' => $syllabus->assessment_methods,
                'required_textbooks' => $syllabus->required_textbooks,
                'recommended_readings' => $syllabus->recommended_readings,
                'prerequisites' => $syllabus->prerequisites,
                'attendance_policy' => $syllabus->attendance_policy,
                'grading_scale' => $syllabus->grading_scale,
                'late_policy' => $syllabus->late_policy,
                'academic_integrity' => $syllabus->academic_integrity,
                'semester' => $syllabus->semester,
                'academic_year' => $syllabus->academic_year,
                'schedule' => $syllabus->schedule,
                'location' => $syllabus->location,
                'office_hours' => $syllabus->office_hours,
                'download_url' => $syllabus->syllabus_download_url,
                'total_assessment_weight' => $syllabus->total_assessment_weight
            ]
        ]);
    }

    /**
     * Get generic syllabus when specific one not found
     */
    private function getGenericSyllabus($courseName, $department): JsonResponse
    {
        // Generate a comprehensive generic syllabus based on course name patterns
        $syllabusData = $this->generateSyllabusData($courseName, $department);

        return response()->json([
            'success' => true,
            'syllabus' => $syllabusData,
            'is_generic' => true,
            'message' => 'Generic syllabus provided. Specific syllabus may vary by semester.'
        ]);
    }

    /**
     * Generate syllabus data based on course name patterns
     */
    private function generateSyllabusData($courseName, $department)
    {
        $courseData = $this->getCoursePatterns();
        
        // Find matching course pattern
        $matchedCourse = null;
        foreach ($courseData as $pattern => $data) {
            if (stripos($courseName, $pattern) !== false) {
                $matchedCourse = $data;
                break;
            }
        }

        // Default to generic if no pattern matches
        if (!$matchedCourse) {
            $matchedCourse = $courseData['default'];
        }

        return [
            'course_name' => $courseName,
            'course_code' => $this->generateCourseCode($courseName, $department),
            'full_course_name' => $this->generateCourseCode($courseName, $department) . ' - ' . $courseName,
            'department' => $department ?: 'General Studies',
            'program_type' => $this->determineProgramType($courseName),
            'credits' => $matchedCourse['credits'],
            'instructor' => $matchedCourse['instructor'],
            'instructor_email' => $matchedCourse['instructor_email'],
            'course_description' => str_replace('{course_name}', $courseName, $matchedCourse['course_description']),
            'learning_objectives' => $matchedCourse['learning_objectives'],
            'course_outline' => $matchedCourse['course_outline'],
            'assessment_methods' => $matchedCourse['assessment_methods'],
            'required_textbooks' => $matchedCourse['required_textbooks'],
            'recommended_readings' => $matchedCourse['recommended_readings'],
            'prerequisites' => $matchedCourse['prerequisites'],
            'attendance_policy' => $matchedCourse['attendance_policy'] ?? 'Regular attendance is expected.',
            'grading_scale' => $matchedCourse['grading_scale'] ?? 'Standard university grading scale applies.',
            'late_policy' => $matchedCourse['late_policy'] ?? 'Late assignments will be penalized.',
            'academic_integrity' => $matchedCourse['academic_integrity'] ?? 'Academic integrity policies must be followed.',
            'semester' => 'Fall',
            'academic_year' => date('Y'),
            'schedule' => $matchedCourse['schedule'],
            'location' => 'To be announced',
            'office_hours' => $matchedCourse['office_hours'],
            'download_url' => null,
            'total_assessment_weight' => 100
        ];
    }

    /**
     * Get course patterns and their associated data
     */
    private function getCoursePatterns(): array
    {
        return [
            'Programming' => [
                'credits' => 4,
                'instructor' => 'Dr. Sarah Johnson',
                'instructor_email' => 'sarah.johnson@gcuniversity.edu.et',
                'course_description' => 'This course introduces students to fundamental programming concepts and practices in {course_name}. Students will learn problem-solving techniques, algorithm design, and software development methodologies.',
                'learning_objectives' => [
                    'Master fundamental programming concepts and syntax',
                    'Develop problem-solving skills using computational thinking',
                    'Understand software development best practices',
                    'Build and debug small to medium-sized programs',
                    'Apply object-oriented programming principles'
                ],
                'course_outline' => [
                    'Week 1-2: Introduction to Programming and Development Environment',
                    'Week 3-4: Variables, Data Types, and Basic Operations',
                    'Week 5-6: Control Structures (Conditionals and Loops)',
                    'Week 7-8: Functions and Modular Programming',
                    'Week 9-10: Arrays and Data Structures',
                    'Week 11-12: Object-Oriented Programming Basics',
                    'Week 13-14: File I/O and Exception Handling',
                    'Week 15: Final Project Development and Presentation'
                ],
                'assessment_methods' => [
                    ['type' => 'Programming Assignments', 'weight' => 40, 'description' => 'Weekly coding assignments'],
                    ['type' => 'Midterm Exam', 'weight' => 25, 'description' => 'Written and practical exam'],
                    ['type' => 'Final Project', 'weight' => 25, 'description' => 'Comprehensive programming project'],
                    ['type' => 'Class Participation', 'weight' => 10, 'description' => 'Attendance and engagement']
                ],
                'required_textbooks' => [
                    'Introduction to Programming with Python by John Zelle',
                    'Clean Code by Robert C. Martin'
                ],
                'recommended_readings' => [
                    'The Pragmatic Programmer by David Thomas',
                    'Code Complete by Steve McConnell'
                ],
                'prerequisites' => ['Basic Mathematics', 'Computer Literacy'],
                'attendance_policy' => 'Regular attendance is required. More than 3 unexcused absences may result in course failure.',
                'grading_scale' => 'A: 90-100%, B: 80-89%, C: 70-79%, D: 60-69%, F: Below 60%',
                'late_policy' => 'Late assignments will be penalized 10% per day. No assignments accepted more than 3 days late.',
                'academic_integrity' => 'All code must be your own work. Collaboration on assignments is not permitted without explicit permission.',
                'office_hours' => 'Tuesday/Thursday 2:00-4:00 PM or by appointment',
                'schedule' => 'Monday/Wednesday/Friday 9:00-10:30 AM'
            ],
            'Data Structures' => [
                'credits' => 4,
                'instructor' => 'Prof. Michael Chen',
                'instructor_email' => 'michael.chen@gcuniversity.edu.et',
                'course_description' => 'Advanced study of data structures and algorithms essential for efficient programming. Covers implementation and analysis of fundamental data structures with emphasis on algorithmic complexity.',
                'learning_objectives' => [
                    'Implement and analyze fundamental data structures',
                    'Design efficient algorithms for complex problems',
                    'Understand time and space complexity analysis',
                    'Apply appropriate data structures to solve real-world problems',
                    'Optimize code performance through proper data structure selection'
                ],
                'course_outline' => [
                    'Week 1-2: Algorithm Analysis and Big O Notation',
                    'Week 3-4: Arrays and Dynamic Arrays',
                    'Week 5-6: Linked Lists and Variations',
                    'Week 7-8: Stacks, Queues, and Deques',
                    'Week 9-10: Trees and Binary Search Trees',
                    'Week 11-12: Hash Tables and Hash Functions',
                    'Week 13-14: Graph Algorithms and Traversal',
                    'Week 15: Advanced Topics and Review'
                ],
                'assessment_methods' => [
                    ['type' => 'Programming Projects', 'weight' => 45, 'description' => 'Implementation projects'],
                    ['type' => 'Written Exams', 'weight' => 35, 'description' => 'Theory and analysis exams'],
                    ['type' => 'Algorithm Design Competition', 'weight' => 15, 'description' => 'Competitive programming'],
                    ['type' => 'Peer Code Reviews', 'weight' => 5, 'description' => 'Code quality assessment']
                ],
                'required_textbooks' => [
                    'Introduction to Algorithms by Thomas H. Cormen',
                    'Data Structures and Algorithms in Java by Robert Lafore'
                ],
                'recommended_readings' => [
                    'Algorithm Design Manual by Steven Skiena',
                    'Programming Pearls by Jon Bentley'
                ],
                'prerequisites' => ['Programming Fundamentals', 'Discrete Mathematics'],
                'attendance_policy' => 'Attendance is mandatory for all practical sessions. Theory lectures strongly recommended.',
                'grading_scale' => 'A: 90-100%, B: 80-89%, C: 70-79%, D: 60-69%, F: Below 60%',
                'late_policy' => 'Programming projects have strict deadlines. Late submissions result in automatic grade reduction.',
                'academic_integrity' => 'Individual work required. Code sharing or copying will result in course failure.',
                'office_hours' => 'Wednesday/Friday 1:00-3:00 PM or by appointment',
                'schedule' => 'Tuesday/Thursday 2:00-3:30 PM'
            ],
            'default' => [
                'credits' => 3,
                'instructor' => 'Faculty Member',
                'instructor_email' => 'faculty@gcuniversity.edu.et',
                'course_description' => 'This course provides comprehensive coverage of {course_name} with emphasis on theoretical foundations and practical applications. Students will engage in both individual and collaborative learning experiences.',
                'learning_objectives' => [
                    'Understand core concepts and principles',
                    'Apply theoretical knowledge to practical problems',
                    'Develop critical thinking and analytical skills',
                    'Communicate ideas effectively in written and oral formats',
                    'Demonstrate competency in subject-specific skills'
                ],
                'course_outline' => [
                    'Week 1-2: Course Introduction and Foundational Concepts',
                    'Week 3-4: Core Theory and Principles',
                    'Week 5-6: Practical Applications and Case Studies',
                    'Week 7-8: Midterm Assessment and Review',
                    'Week 9-10: Advanced Topics and Methodologies',
                    'Week 11-12: Research and Analysis Techniques',
                    'Week 13-14: Synthesis and Integration',
                    'Week 15: Final Presentations and Assessment'
                ],
                'assessment_methods' => [
                    ['type' => 'Assignments', 'weight' => 30, 'description' => 'Regular coursework and homework'],
                    ['type' => 'Midterm Exam', 'weight' => 30, 'description' => 'Comprehensive midterm examination'],
                    ['type' => 'Final Exam/Project', 'weight' => 30, 'description' => 'Final assessment or capstone project'],
                    ['type' => 'Participation', 'weight' => 10, 'description' => 'Class attendance and engagement']
                ],
                'required_textbooks' => [
                    'Course-specific textbook (TBA)',
                    'Supplementary course materials'
                ],
                'recommended_readings' => [
                    'Additional readings as assigned',
                    'Academic journals in the field'
                ],
                'prerequisites' => ['Consult with academic advisor'],
                'attendance_policy' => 'Regular attendance is expected and will be monitored.',
                'grading_scale' => 'Standard university grading scale applies (A: 90-100%, B: 80-89%, C: 70-79%, D: 60-69%, F: Below 60%)',
                'late_policy' => 'Late assignments will be penalized according to university policy.',
                'academic_integrity' => 'All work must be original and follow university academic integrity policies.',
                'office_hours' => 'By appointment - contact instructor to schedule',
                'schedule' => 'To be determined'
            ]
        ];
    }

    /**
     * Generate and download PDF syllabus
     */
    public function downloadPdf(Request $request)
    {
        $courseName = $request->input('course_name');
        $department = $request->input('department');

        if (!$courseName) {
            return response()->json([
                'success' => false,
                'message' => 'Course name is required'
            ], 422);
        }

        // Get syllabus data
        $syllabus = Syllabus::active()
            ->where('course_name', $courseName)
            ->when($department, function ($query, $department) {
                return $query->where('department', $department);
            })
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->first();

        if (!$syllabus) {
            $syllabusData = $this->generateSyllabusData($courseName, $department);
        } else {
            $syllabusData = [
                'course_name' => $syllabus->course_name,
                'course_code' => $syllabus->course_code,
                'full_course_name' => $syllabus->full_course_name,
                'department' => $syllabus->department,
                'instructor' => $syllabus->instructor,
                'instructor_email' => $syllabus->instructor_email,
                'course_description' => $syllabus->course_description,
                'learning_objectives' => $syllabus->learning_objectives,
                'course_outline' => $syllabus->course_outline,
                'assessment_methods' => $syllabus->assessment_methods,
                'required_textbooks' => $syllabus->required_textbooks,
                'prerequisites' => $syllabus->prerequisites,
                'attendance_policy' => $syllabus->attendance_policy,
                'academic_integrity' => $syllabus->academic_integrity,
                'credits' => $syllabus->credits,
                'semester' => $syllabus->semester,
                'academic_year' => $syllabus->academic_year
            ];
        }

        // Generate PDF content
        $html = $this->generatePdfContent($syllabusData);
        
        // For now, return a simple PDF-like response
        // In production, you would use a PDF library like DomPDF or TCPDF
        return response($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . ($syllabusData['course_code'] ?? 'syllabus') . '_syllabus.html"'
        ]);
    }

    /**
     * Generate PDF content as HTML
     */
    private function generatePdfContent(array $syllabus): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . ($syllabus['full_course_name'] ?? 'Course Syllabus') . '</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; color: #333; }
                .header { text-align: center; border-bottom: 3px solid #2563eb; padding-bottom: 20px; margin-bottom: 30px; }
                .header h1 { color: #2563eb; margin: 0; font-size: 28px; }
                .header h2 { color: #1e40af; margin: 10px 0; font-size: 22px; }
                .section { margin-bottom: 25px; page-break-inside: avoid; }
                .section h3 { color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px; margin-bottom: 15px; font-size: 18px; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
                .info-item { padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #3b82f6; }
                .info-item strong { color: #1e40af; }
                ul { padding-left: 25px; }
                li { margin-bottom: 10px; }
                .assessment-item { background: #fef3c7; padding: 10px; border-radius: 6px; margin-bottom: 8px; }
                .footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb; color: #6b7280; }
                @media print { 
                    body { margin: 20px; } 
                    .section { page-break-inside: avoid; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🎓 GC University</h1>
                <h2>' . ($syllabus['full_course_name'] ?? 'Course Syllabus') . '</h2>
                <p><strong>Department of ' . ($syllabus['department'] ?? 'Academic Studies') . '</strong></p>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <strong>📚 Course Code:</strong> ' . ($syllabus['course_code'] ?? 'N/A') . '<br>
                    <strong>👨‍🏫 Instructor:</strong> ' . ($syllabus['instructor'] ?? 'TBA') . '<br>
                    <strong>📧 Email:</strong> ' . ($syllabus['instructor_email'] ?? 'TBA') . '<br>
                    <strong>⭐ Credits:</strong> ' . ($syllabus['credits'] ?? 'N/A') . '
                </div>
                <div class="info-item">
                    <strong>📅 Semester:</strong> ' . ($syllabus['semester'] ?? 'TBA') . ' ' . ($syllabus['academic_year'] ?? date('Y')) . '<br>
                    <strong>🎯 Program Level:</strong> ' . ($syllabus['program_type'] ?? 'Undergraduate') . '<br>
                    <strong>⏰ Schedule:</strong> ' . ($syllabus['schedule'] ?? 'TBA') . '<br>
                    <strong>📍 Location:</strong> ' . ($syllabus['location'] ?? 'TBA') . '
                </div>
            </div>
            
            <div class="section">
                <h3>📖 Course Description</h3>
                <p>' . ($syllabus['course_description'] ?? 'Course description to be provided.') . '</p>
            </div>
            
            ' . (isset($syllabus['learning_objectives']) ? '
            <div class="section">
                <h3>🎯 Learning Objectives</h3>
                <ul>
                    ' . implode('', array_map(function($obj) { return "<li>$obj</li>"; }, $syllabus['learning_objectives'])) . '
                </ul>
            </div>
            ' : '') . '
            
            ' . (isset($syllabus['course_outline']) ? '
            <div class="section">
                <h3>📋 Course Outline</h3>
                <ul>
                    ' . implode('', array_map(function($item) { return "<li>$item</li>"; }, $syllabus['course_outline'])) . '
                </ul>
            </div>
            ' : '') . '
            
            ' . (isset($syllabus['assessment_methods']) ? '
            <div class="section">
                <h3>📊 Assessment Methods</h3>
                ' . implode('', array_map(function($assessment) { 
                    return "<div class=\"assessment-item\"><strong>" . $assessment['type'] . " (" . $assessment['weight'] . "%):</strong> " . $assessment['description'] . "</div>"; 
                }, $syllabus['assessment_methods'])) . '
            </div>
            ' : '') . '
            
            ' . (isset($syllabus['required_textbooks']) ? '
            <div class="section">
                <h3>📚 Required Textbooks</h3>
                <ul>
                    ' . implode('', array_map(function($book) { return "<li>$book</li>"; }, $syllabus['required_textbooks'])) . '
                </ul>
            </div>
            ' : '') . '
            
            <div class="section">
                <h3>📋 Course Policies</h3>
                <div class="info-item">
                    <strong>🎯 Attendance Policy:</strong><br>
                    ' . ($syllabus['attendance_policy'] ?? 'Regular attendance is expected.') . '
                </div><br>
                <div class="info-item">
                    <strong>⏰ Late Assignment Policy:</strong><br>
                    ' . ($syllabus['late_policy'] ?? 'Late assignments may be penalized.') . '
                </div><br>
                <div class="info-item">
                    <strong>🔒 Academic Integrity:</strong><br>
                    ' . ($syllabus['academic_integrity'] ?? 'Academic integrity is required at all times.') . '
                </div>
            </div>
            
            <div class="footer">
                <p>📞 <strong>Office Hours:</strong> ' . ($syllabus['office_hours'] ?? 'By appointment') . '</p>
                <p>Generated on ' . date('F j, Y') . ' | GC University Academic Affairs</p>
            </div>
        </body>
        </html>';
    }

    private function generateCourseCode($courseName, $department): string
    {
        $deptCode = match(strtolower($department ?: '')) {
            'computer science & it', 'computer science' => 'CS',
            'engineering' => 'ENGR',
            'business & management', 'business' => 'BUS',
            'medicine & health sciences', 'medicine' => 'MED',
            'natural sciences', 'sciences' => 'SCI',
            'social sciences' => 'SOC',
            default => 'GEN'
        };

        $number = rand(100, 499); // Generate random course number
        return $deptCode . $number;
    }

    private function determineProgramType($courseName): string
    {
        if (stripos($courseName, 'MSc') !== false || stripos($courseName, 'Master') !== false || stripos($courseName, 'MBA') !== false) {
            return 'Graduate';
        } elseif (stripos($courseName, 'Doctor') !== false || stripos($courseName, 'MD') !== false) {
            return 'Professional';
        }
        return 'Undergraduate';
    }
}