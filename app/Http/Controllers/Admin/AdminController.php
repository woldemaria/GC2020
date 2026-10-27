<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use App\Models\Photo;
use App\Models\StudentProfile;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Admin dashboard main page
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats(): JsonResponse
    {
        // Calculate comprehensive stats
        $totalArticles = Article::count();
        $publishedArticles = Article::where('is_published', true)->count();
        $totalViews = Article::sum('views') ?: 0;
        $avgViews = $totalArticles > 0 ? round($totalViews / $totalArticles) : 0;
        
        // New comprehensive stats
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        $totalStudents = StudentProfile::count();
        $totalPhotos = Photo::count();
        $totalEnrollments = \DB::table('course_enrollments')->count();
        $pendingEnrollments = \DB::table('course_enrollments')->where('status', 'pending')->count();
        $totalCertificates = \DB::table('certificates')->count();
        
        // Monthly stats
        $thisMonthArticles = Article::whereMonth('created_at', now()->month)->count();
        $thisMonthEnrollments = \DB::table('course_enrollments')->whereMonth('created_at', now()->month)->count();
        $thisMonthUsers = User::whereMonth('created_at', now()->month)->count();
        
        // Storage usage
        $storageUsed = $this->calculateStorageUsage();
        
        $stats = [
            // Content Stats
            'totalArticles' => $totalArticles,
            'publishedArticles' => $publishedArticles,
            'totalViews' => $totalViews,
            'avgViews' => $avgViews,
            'thisMonthArticles' => $thisMonthArticles,
            
            // User Stats  
            'totalUsers' => $totalUsers,
            'adminUsers' => $adminUsers,
            'totalStudents' => $totalStudents,
            'thisMonthUsers' => $thisMonthUsers,
            
            // Academic Stats
            'totalEnrollments' => $totalEnrollments,
            'pendingEnrollments' => $pendingEnrollments,
            'thisMonthEnrollments' => $thisMonthEnrollments,
            'totalCertificates' => $totalCertificates,
            
            // Media Stats
            'totalPhotos' => $totalPhotos,
            'storageUsed' => $storageUsed,
            'storageUsedFormatted' => $this->formatBytes($storageUsed),
            
            // System Stats
            'categories' => Category::count(),
            'authors' => Author::count(),
            'activeAuthors' => Author::where('is_active', true)->count()
        ];

        // Recent activities for dashboard
        $recentArticles = Article::with(['category', 'author'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'is_published' => $article->is_published,
                    'featured_image' => $article->featured_image,
                    'views' => $article->views ?? 0,
                    'created_at' => $article->created_at->format('M j, Y'),
                    'category' => [
                        'name' => $article->category->name,
                        'color' => $article->category->color ?? '#3B82F6'
                    ]
                ];
            });

        $recentEnrollments = \DB::table('course_enrollments')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'student_name' => $enrollment->student_name,
                    'course_name' => $enrollment->course_name,
                    'department' => $enrollment->department,
                    'status' => $enrollment->status,
                    'created_at' => \Carbon\Carbon::parse($enrollment->created_at)->format('M j, Y')
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recentArticles' => $recentArticles,
                'recentEnrollments' => $recentEnrollments
            ]
        ]);
    }

    /**
     * Calculate storage usage
     */
    private function calculateStorageUsage(): int
    {
        $storagePath = storage_path('app/public');
        $size = 0;
        
        if (is_dir($storagePath)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($storagePath, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            
            foreach ($iterator as $file) {
                $size += $file->getSize();
            }
        }
        
        return $size;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $size, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Get system information
     */
    public function getSystemInfo(): JsonResponse
    {
        $info = [
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug'),
            'timezone' => config('app.timezone'),
            'storage_path' => storage_path(),
            'public_path' => public_path(),
            'database' => [
                'connection' => config('database.default'),
                'database' => config('database.connections.' . config('database.default') . '.database'),
            ],
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
        ];

        return response()->json([
            'success' => true,
            'data' => $info
        ]);
    }

    /**
     * Clear application cache
     */
    public function clearCache(): JsonResponse
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data
     */
    public function exportData(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:articles,categories,authors,photos,students',
            'format' => 'required|in:json,csv'
        ]);

        try {
            $type = $request->type;
            $format = $request->format;

            $data = $this->getExportData($type);
            $filename = $type . '_export_' . date('Y-m-d_H-i-s') . '.' . $format;

            if ($format === 'json') {
                $content = json_encode($data, JSON_PRETTY_PRINT);
                $mimeType = 'application/json';
            } else {
                $content = $this->convertToCsv($data);
                $mimeType = 'text/csv';
            }

            return response($content)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for export
     */
    private function getExportData(string $type): array
    {
        switch ($type) {
            case 'articles':
                return Article::with(['category', 'author'])
                    ->get()
                    ->toArray();
                    
            case 'categories':
                return Category::withCount('articles')
                    ->get()
                    ->toArray();
                    
            case 'authors':
                return Author::withCount('articles')
                    ->get()
                    ->toArray();
                    
            case 'photos':
                return Photo::all()->toArray();
                
            case 'students':
                return StudentProfile::all()->toArray();
                
            default:
                return [];
        }
    }

    /**
     * Convert array to CSV format
     */
    private function convertToCsv(array $data): string
    {
        if (empty($data)) {
            return '';
        }

        $output = fopen('php://temp', 'r+');
        
        // Write header
        fputcsv($output, array_keys($data[0]));
        
        // Write data rows
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }

    /**
     * Generate and download program brochures
     */
    public function downloadProgramBrochure(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'department' => 'required|string',
            'program' => 'required|string',
            'format' => 'in:pdf,html|nullable'
        ]);

        $department = $request->department;
        $program = $request->program;
        $format = $request->format ?? 'html';

        try {
            $brochureContent = $this->generateProgramBrochure($department, $program);
            $filename = str_replace(' ', '_', $department . '_' . $program . '_Brochure.' . $format);

            return response($brochureContent, 200, [
                'Content-Type' => $format === 'pdf' ? 'application/pdf' : 'text/html',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate brochure: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download graduation ceremony program (simplified version)
     */
    public function downloadGraduationProgram(): \Illuminate\Http\Response
    {
        try {
            $graduationProgram = $this->generateGraduationProgram();
            
            return response($graduationProgram, 200, [
                'Content-Type' => 'text/html',
                'Content-Disposition' => 'attachment; filename="GC_University_Graduation_Program_2025.html"'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate graduation program: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register for university events
     */
    public function registerForEvent(Request $request): JsonResponse
    {
        $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'student_name' => 'required|string|max:100',
            'student_email' => 'required|email|max:100',
            'student_phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'year_of_study' => 'nullable|string|max:20',
            'dietary_requirements' => 'nullable|string|max:200',
            'emergency_contact' => 'nullable|string|max:100'
        ]);

        $event = Event::find($request->event_id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }

        if (!$event->isRegistrationOpen()) {
            $reason = (!$event->is_published)
                ? 'This event is not currently open for registration.'
                : (($event->registration_deadline && \Carbon\Carbon::parse($event->registration_deadline)->isPast())
                    ? 'The registration deadline has passed.'
                    : 'This event has reached maximum capacity.');

            return response()->json([
                'success' => false,
                'message' => $reason
            ], 400);
        }

        // Prevent duplicate registration by email for the same event
        $existing = \DB::table('event_registrations')
            ->where('event_id', $event->id)
            ->where('student_email', $request->student_email)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.'
            ], 409);
        }

        try {
            \DB::beginTransaction();

            $registration = \DB::table('event_registrations')->insertGetId([
                'event_id' => $event->id,
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'student_phone' => $request->student_phone,
                'department' => $request->department,
                'year_of_study' => $request->year_of_study,
                'dietary_requirements' => $request->dietary_requirements,
                'emergency_contact' => $request->emergency_contact,
                'registration_status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $event->increment('registered_count');

            \DB::commit();

            $registrationNumber = 'EVT' . str_pad($registration, 6, '0', STR_PAD_LEFT);

            return response()->json([
                'success' => true,
                'message' => 'Successfully registered for the event!',
                'registration' => [
                    'id' => $registration,
                    'registration_number' => $registrationNumber,
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                    'status' => 'confirmed',
                    'registered_at' => now()->format('F j, Y g:i A')
                ]
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available university events
     */
    public function getEvents(): JsonResponse
    {
        try {
            $events = Event::published()
                ->orderBy('event_date', 'asc')
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'slug' => $event->slug,
                        'description' => $event->description,
                        'date' => $event->event_date,
                        'time' => $event->formatted_time,
                        'location' => $event->location,
                        'venue' => $event->venue,
                        'image' => $event->image,
                        'category' => $event->category,
                        'max_attendees' => $event->max_attendees,
                        'registered_count' => $event->registered_count,
                        'registration_deadline' => $event->registration_deadline,
                        'requirements' => $event->requirements ?? [],
                        'is_registration_open' => $event->isRegistrationOpen(),
                        'is_past' => $event->isPast(),
                        'created_at' => $event->created_at,
                    ];
                });

            return response()->json([
                'success' => true,
                'events' => $events
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get events: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate program brochure content
     */
    private function generateProgramBrochure(string $department, string $program): string
    {
        $brochureData = $this->getProgramBrochureData($department, $program);
        
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . $brochureData['title'] . ' - Program Brochure</title>
            <style>
                body { font-family: "Segoe UI", Arial, sans-serif; line-height: 1.6; margin: 0; padding: 40px; color: #333; }
                .header { text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; margin: -40px -40px 40px -40px; }
                .header h1 { margin: 0; font-size: 36px; font-weight: bold; }
                .header h2 { margin: 10px 0 0 0; font-size: 24px; font-weight: 300; }
                .section { margin-bottom: 35px; }
                .section h3 { color: #667eea; font-size: 22px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 20px; }
                .highlight-box { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 12px; margin: 25px 0; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin: 25px 0; }
                .info-card { background: #f8fafc; padding: 20px; border-radius: 10px; border-left: 5px solid #667eea; }
                .stats-row { display: flex; justify-content: space-around; background: #f1f5f9; padding: 25px; border-radius: 10px; margin: 25px 0; }
                .stat-item { text-align: center; }
                .stat-number { font-size: 28px; font-weight: bold; color: #667eea; }
                .stat-label { font-size: 14px; color: #64748b; margin-top: 5px; }
                ul { padding-left: 25px; }
                li { margin-bottom: 10px; }
                .footer { text-align: center; margin-top: 50px; padding-top: 30px; border-top: 2px solid #e5e7eb; color: #64748b; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🎓 GC University</h1>
                <h2>' . $brochureData['title'] . '</h2>
                <p>' . $brochureData['subtitle'] . '</p>
            </div>
            
            <div class="highlight-box">
                <h3>🌟 Program Highlights</h3>
                <p>' . $brochureData['description'] . '</p>
            </div>
            
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-number">' . $brochureData['duration'] . '</div>
                    <div class="stat-label">Program Duration</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">' . $brochureData['credits'] . '</div>
                    <div class="stat-label">Total Credits</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">' . $brochureData['employment_rate'] . '</div>
                    <div class="stat-label">Employment Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">' . $brochureData['average_salary'] . '</div>
                    <div class="stat-label">Average Starting Salary</div>
                </div>
            </div>
            
            <div class="info-grid">
                <div class="info-card">
                    <h4>🎯 Career Opportunities</h4>
                    <ul>
                        ' . implode('', array_map(function($career) { return "<li>$career</li>"; }, $brochureData['careers'])) . '
                    </ul>
                </div>
                <div class="info-card">
                    <h4>🏆 Key Skills Developed</h4>
                    <ul>
                        ' . implode('', array_map(function($skill) { return "<li>$skill</li>"; }, $brochureData['skills'])) . '
                    </ul>
                </div>
            </div>
            
            <div class="section">
                <h3>📚 Curriculum Overview</h3>
                <ul>
                    ' . implode('', array_map(function($subject) { return "<li>$subject</li>"; }, $brochureData['curriculum'])) . '
                </ul>
            </div>
            
            <div class="section">
                <h3>📋 Admission Requirements</h3>
                <ul>
                    ' . implode('', array_map(function($req) { return "<li>$req</li>"; }, $brochureData['requirements'])) . '
                </ul>
            </div>
            
            <div class="highlight-box">
                <h3>📞 Ready to Apply?</h3>
                <p>Contact our admissions office for more information and application assistance.</p>
                <p><strong>Email:</strong> admissions@gcuniversity.edu.et | <strong>Phone:</strong> +251-11-123-4567</p>
            </div>
            
            <div class="footer">
                <p>Generated on ' . date('F j, Y') . ' | GC University Academic Affairs</p>
                <p><strong>Visit us:</strong> www.gcuniversity.edu.et | Follow us on social media</p>
            </div>
        </body>
        </html>';
    }

    /**
     * Get program brochure data
     */
    private function getProgramBrochureData(string $department, string $program): array
    {
        $brochures = [
            'Computer Science' => [
                'BSc Computer Science' => [
                    'title' => 'Bachelor of Science in Computer Science',
                    'subtitle' => 'Shape the Future of Technology',
                    'description' => 'Our Computer Science program combines theoretical foundations with hands-on experience in software development, artificial intelligence, and system design. Graduates are prepared for careers in technology companies, research institutions, and startups.',
                    'duration' => '4 Years',
                    'credits' => '120',
                    'employment_rate' => '95%',
                    'average_salary' => '$65,000',
                    'careers' => [
                        'Software Developer',
                        'Data Scientist',
                        'AI/ML Engineer',
                        'Systems Analyst',
                        'Cybersecurity Specialist',
                        'Product Manager'
                    ],
                    'skills' => [
                        'Programming Languages (Python, Java, C++)',
                        'Data Structures & Algorithms',
                        'Database Design & Management',
                        'Web Development',
                        'Mobile App Development',
                        'Machine Learning & AI'
                    ],
                    'curriculum' => [
                        'Programming Fundamentals',
                        'Data Structures & Algorithms',
                        'Computer Systems Architecture',
                        'Database Systems',
                        'Software Engineering',
                        'Operating Systems',
                        'Computer Networks',
                        'Artificial Intelligence',
                        'Cybersecurity',
                        'Capstone Project'
                    ],
                    'requirements' => [
                        'High School Diploma with strong math background',
                        'Minimum GPA of 3.0',
                        'SAT Math score of 600+ (or equivalent)',
                        'English proficiency (TOEFL 80+ for international students)',
                        'Letter of recommendation',
                        'Personal statement'
                    ]
                ]
            ]
        ];

        return $brochures[$department][$program] ?? [
            'title' => $program,
            'subtitle' => 'Excellence in ' . $department,
            'description' => 'Comprehensive program designed to prepare students for success in their chosen field.',
            'duration' => '4 Years',
            'credits' => '120',
            'employment_rate' => '90%',
            'average_salary' => '$50,000',
            'careers' => ['Industry Professional', 'Researcher', 'Consultant', 'Manager'],
            'skills' => ['Critical Thinking', 'Problem Solving', 'Communication', 'Leadership'],
            'curriculum' => ['Core Subjects', 'Specialized Courses', 'Practical Training', 'Final Project'],
            'requirements' => ['High School Diploma', 'Minimum GPA Requirements', 'English Proficiency', 'Application Materials']
        ];
    }
    public function getSystemStatus(): JsonResponse
    {
        try {
            $status = [
                'database' => [
                    'status' => 'connected',
                    'driver' => config('database.default'),
                    'tables_count' => \DB::select("SELECT COUNT(*) as count FROM sqlite_master WHERE type='table'")[0]->count ?? 0
                ],
                'storage' => [
                    'status' => 'available',
                    'symlink_exists' => is_link(public_path('storage')),
                    'writable' => is_writable(storage_path('app/public')),
                    'free_space' => disk_free_space(storage_path()) ?: 0
                ],
                'cache' => [
                    'status' => 'active',
                    'driver' => config('cache.default'),
                ],
                'environment' => [
                    'app_env' => config('app.env'),
                    'app_debug' => config('app.debug'),
                    'laravel_version' => app()->version(),
                    'php_version' => PHP_VERSION
                ],
                'uploads' => [
                    'max_file_size' => ini_get('upload_max_filesize'),
                    'max_post_size' => ini_get('post_max_size'),
                    'memory_limit' => ini_get('memory_limit'),
                    'directories_exist' => [
                        'articles' => is_dir(storage_path('app/public/images/articles')),
                        'avatars' => is_dir(storage_path('app/public/images/avatars')),
                        'gallery' => is_dir(storage_path('app/public/images/gallery')),
                        'uploads' => is_dir(storage_path('app/public/images/uploads'))
                    ]
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get system status: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Create a new university event
     */
    public function createEvent(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:events',
            'description' => 'required|string',
            'short_description' => 'sometimes|string|max:500',
            'event_date' => 'required|date|after:today',
            'start_time' => 'required|string',
            'end_time' => 'sometimes|string',
            'location' => 'required|string|max:255',
            'venue' => 'sometimes|string|max:255',
            'image' => 'sometimes|url',
            'category' => 'sometimes|string|max:50',
            'max_attendees' => 'sometimes|integer|min:1',
            'registration_deadline' => 'sometimes|date',
            'is_featured' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
            'requirements' => 'sometimes|array',
            'highlights' => 'sometimes|array',
            'contact_email' => 'sometimes|email|max:255',
            'contact_phone' => 'sometimes|string|max:50',
            'organizer' => 'sometimes|string|max:255'
        ]);

        try {
            $event = Event::create(array_merge($request->all(), [
                'requirements' => $request->input('requirements', []),
                'highlights' => $request->input('highlights', []),
                'created_by' => Auth::id()
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get event registrations for admin
     */
    public function getEventRegistrations(): JsonResponse
    {
        try {
            $registrations = \DB::table('event_registrations')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($registration) {
                    return [
                        'id' => $registration->id,
                        'event_id' => $registration->event_id,
                        'student_name' => $registration->student_name,
                        'student_email' => $registration->student_email,
                        'student_phone' => $registration->student_phone,
                        'department' => $registration->department,
                        'year_of_study' => $registration->year_of_study,
                        'registration_status' => $registration->registration_status,
                        'registration_number' => 'EVT' . str_pad($registration->id, 6, '0', STR_PAD_LEFT),
                        'created_at' => \Carbon\Carbon::parse($registration->created_at)->format('M j, Y g:i A')
                    ];
                });

            return response()->json([
                'success' => true,
                'registrations' => $registrations
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get event registrations: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateGraduationProgram(): string
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>GC University Graduation Ceremony 2025 - Official Program</title>
            <style>
                body { font-family: "Times New Roman", serif; line-height: 1.8; margin: 0; padding: 30px; color: #2c3e50; }
                .header { text-align: center; background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%); color: white; padding: 50px; margin: -30px -30px 40px -30px; }
                .header h1 { margin: 0; font-size: 42px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
                .header h2 { margin: 15px 0 5px 0; font-size: 28px; font-weight: 300; }
                .header .date { font-size: 18px; margin-top: 10px; color: #ffd700; }
                .section { margin-bottom: 40px; page-break-inside: avoid; }
                .section h3 { color: #1e3a8a; font-size: 24px; border-bottom: 3px solid #ffd700; padding-bottom: 8px; margin-bottom: 20px; }
                .schedule-item { display: flex; justify-content: space-between; padding: 15px 20px; margin: 8px 0; background: #f8fafc; border-radius: 8px; border-left: 5px solid #1e3a8a; }
                .schedule-time { font-weight: bold; color: #1e3a8a; min-width: 140px; }
                .schedule-event { flex-1; }
                .important { background: linear-gradient(135deg, #fef3c7 0%, #fbbf24 100%); padding: 25px; border-radius: 12px; border-left: 6px solid #f59e0b; margin: 25px 0; }
                .important h4 { margin-top: 0; color: #92400e; }
                .speaker-info { background: #ede9fe; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 5px solid #8b5cf6; }
                .speaker-name { font-size: 20px; font-weight: bold; color: #5b21b6; }
                .speaker-title { color: #7c3aed; font-style: italic; }
                .contact-info { background: #f0f9ff; padding: 20px; border-radius: 10px; border-left: 5px solid #0ea5e9; }
                .footer { text-align: center; margin-top: 60px; padding-top: 30px; border-top: 2px solid #e5e7eb; color: #6b7280; font-size: 14px; }
                .ceremonial-border { border: 3px solid #ffd700; padding: 20px; margin: 20px 0; border-radius: 10px; background: linear-gradient(135deg, #fefbf3 0%, #fef3c7 100%); }
                .honors { color: #dc2626; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🎓 GC UNIVERSITY</h1>
                <h2>GRADUATION CEREMONY 2025</h2>
                <div class="date">July 26, 2025 • Main Campus Auditorium, Addis Ababa</div>
                <p style="margin-top: 20px; font-size: 16px;">Celebrating Excellence in Higher Education</p>
            </div>
            
            <div class="ceremonial-border">
                <h3 style="text-align: center; margin: 0; color: #1e3a8a;">COMMENCEMENT EXERCISES</h3>
                <p style="text-align: center; margin: 5px 0 0 0; font-style: italic;">Conferring of Degrees and Awards</p>
            </div>
            
            <div class="section">
                <h3>📅 CEREMONY SCHEDULE</h3>
                <div class="schedule-item">
                    <div class="schedule-time">9:00 AM - 9:30 AM</div>
                    <div class="schedule-event">Registration & Academic Procession Assembly</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">9:30 AM - 10:00 AM</div>
                    <div class="schedule-event">Graduates Seating & Family Welcome</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">10:00 AM - 10:15 AM</div>
                    <div class="schedule-event">Opening Ceremony & National Anthem</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">10:15 AM - 10:30 AM</div>
                    <div class="schedule-event">University President\'s Welcome Address</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">10:30 AM - 11:30 AM</div>
                    <div class="schedule-event"><span class="honors">Degree Conferment Ceremony</span></div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">11:30 AM - 12:00 PM</div>
                    <div class="schedule-event">Keynote Address by Distinguished Guest</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">12:00 PM - 12:30 PM</div>
                    <div class="schedule-event">Awards & Special Recognition</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">12:30 PM - 1:00 PM</div>
                    <div class="schedule-event">Closing Remarks & Academic Recessional</div>
                </div>
                <div class="schedule-item">
                    <div class="schedule-time">1:00 PM - 2:30 PM</div>
                    <div class="schedule-event">Reception & Photography Session</div>
                </div>
            </div>

            <div class="section">
                <h3>🎤 DISTINGUISHED KEYNOTE SPEAKER</h3>
                <div class="speaker-info">
                    <div class="speaker-name">Dr. Amina Hassan</div>
                    <div class="speaker-title">CEO, African Innovation Hub & Former UN Science Advisor</div>
                    <p style="margin-top: 15px;"><strong>Address Topic:</strong> "Innovation and Leadership in the Digital Age: Preparing Africa\'s Next Generation for Global Challenges"</p>
                    <p><strong>Biography:</strong> Dr. Hassan is a renowned technology leader and advocate for African innovation. She has over 15 years of experience in technology policy and has advised governments across Africa on digital transformation strategies.</p>
                </div>
            </div>

            <div class="section">
                <h3>🏆 GRADUATION STATISTICS - CLASS OF 2025</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
                    <div style="background: #f0f9ff; padding: 20px; border-radius: 10px; text-align: center; border-left: 5px solid #0ea5e9;">
                        <div style="font-size: 28px; font-weight: bold; color: #0369a1;">1,250</div>
                        <div style="color: #075985;">Total Graduates</div>
                    </div>
                    <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; text-align: center; border-left: 5px solid #22c55e;">
                        <div style="font-size: 28px; font-weight: bold; color: #15803d;">95%</div>
                        <div style="color: #166534;">Employment Rate</div>
                    </div>
                </div>
                
                <h4 style="color: #1e3a8a; margin-top: 25px;">Graduates by Department:</h4>
                <ul style="column-count: 2; column-gap: 40px;">
                    <li>Computer Science & IT: 245 graduates</li>
                    <li>Engineering: 198 graduates</li>
                    <li>Business & Management: 186 graduates</li>
                    <li>Medicine & Health Sciences: 156 graduates</li>
                    <li>Natural Sciences: 134 graduates</li>
                    <li>Social Sciences: 119 graduates</li>
                    <li>Arts & Humanities: 98 graduates</li>
                    <li>Agriculture: 78 graduates</li>
                    <li>Education: 65 graduates</li>
                    <li>Law: 45 graduates</li>
                </ul>
            </div>

            <div class="important">
                <h4>⚠️ IMPORTANT CEREMONY INFORMATION</h4>
                <ul>
                    <li><strong>Arrival Time:</strong> All graduates must arrive by 9:00 AM for registration and robing</li>
                    <li><strong>Academic Dress:</strong> Full academic regalia is mandatory (cap, gown, hood)</li>
                    <li><strong>Family Seating:</strong> Each graduate receives 4 guest tickets. Additional seating not guaranteed</li>
                    <li><strong>Photography:</strong> Professional photography services available on-site</li>
                    <li><strong>Parking:</strong> Available at Sports Complex (5-minute walk to auditorium)</li>
                    <li><strong>Weather Contingency:</strong> Ceremony will proceed as scheduled regardless of weather</li>
                    <li><strong>Accessibility:</strong> Special accommodations available - contact registry office</li>
                    <li><strong>Live Stream:</strong> Ceremony will be broadcast live on university website</li>
                </ul>
            </div>

            <div class="section">
                <h3>🎖️ SPECIAL AWARDS & RECOGNITION</h3>
                <p><strong>Academic Excellence Awards will be presented to:</strong></p>
                <ul>
                    <li><span class="honors">Summa Cum Laude:</span> GPA 3.8 and above (89 graduates)</li>
                    <li><span class="honors">Magna Cum Laude:</span> GPA 3.5 - 3.79 (156 graduates)</li>
                    <li><span class="honors">Cum Laude:</span> GPA 3.2 - 3.49 (234 graduates)</li>
                    <li><strong>Valedictorian:</strong> Sarah Johnson (Computer Science) - GPA 4.0</li>
                    <li><strong>Salutatorian:</strong> Michael Chen (Business Administration) - GPA 3.98</li>
                </ul>
                
                <p><strong>Special Recognition:</strong></p>
                <ul>
                    <li>Outstanding Research Award</li>
                    <li>Community Service Excellence Award</li>
                    <li>Innovation in Technology Award</li>
                    <li>Leadership Excellence Award</li>
                    <li>International Student Achievement Award</li>
                </ul>
            </div>

            <div class="contact-info">
                <h4 style="margin-top: 0; color: #0369a1;">📞 CEREMONY CONTACTS & INFORMATION</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p><strong>Registry Office:</strong><br>
                        Phone: +251-11-123-4567<br>
                        Email: graduation@gcuniversity.edu.et</p>
                        
                        <p><strong>Emergency Contact:</strong><br>
                        Phone: +251-11-123-4590<br>
                        Available during ceremony</p>
                    </div>
                    <div>
                        <p><strong>Parking & Transportation:</strong><br>
                        Phone: +251-11-123-4575<br>
                        Campus shuttle available</p>
                        
                        <p><strong>Photography Services:</strong><br>
                        Phone: +251-11-123-4580<br>
                        On-site professional photos</p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3>🌟 MESSAGE FROM THE UNIVERSITY PRESIDENT</h3>
                <div style="background: #f8fafc; padding: 25px; border-radius: 10px; border-left: 5px solid #1e3a8a; font-style: italic;">
                    <p>"Dear Class of 2025, today marks not just the end of your academic journey at GC University, but the beginning of your impact on our world. You have demonstrated resilience, excellence, and dedication throughout your studies. As you step forward into your careers and future endeavors, carry with you the values of integrity, innovation, and service that define our university community."</p>
                    <p style="text-align: right; margin-top: 20px; font-style: normal;"><strong>- Dr. Abraham Tadesse</strong><br>President, GC University</p>
                </div>
            </div>

            <div class="footer">
                <p><strong>GC University - Established 1995</strong></p>
                <p>Addis Ababa, Ethiopia | +251-11-123-4567 | www.gcuniversity.edu.et</p>
                <p>Official Graduation Program - Generated on ' . date('F j, Y \a\t g:i A') . '</p>
                <p style="margin-top: 20px; font-style: italic;">"Excellence in Education, Innovation in Research, Service to Society"</p>
            </div>
        </body>
        </html>';
    }

    /**
     * Get marketing analytics data
     */
    public function getMarketingAnalytics(): JsonResponse
    {
        try {
            $analytics = [
                'campaignMetrics' => [
                    'totalCampaigns' => 12,
                    'activeCampaigns' => 4,
                    'totalImpressions' => 124657,
                    'totalClicks' => 7843,
                    'avgCTR' => 6.3,
                    'totalConversions' => 567,
                    'conversionRate' => 7.2
                ],
                'emailMarketing' => [
                    'totalSubscribers' => 5672,
                    'newSubscribersThisMonth' => 247,
                    'avgOpenRate' => 89.3,
                    'avgClickRate' => 12.7,
                    'campaignsSent' => 8,
                    'bounceRate' => 2.1
                ],
                'socialMedia' => [
                    'facebook' => ['followers' => 2547, 'engagement' => 8.4, 'growth' => 12],
                    'twitter' => ['followers' => 1892, 'engagement' => 6.7, 'growth' => 8],
                    'instagram' => ['followers' => 3451, 'engagement' => 12.3, 'growth' => 18],
                    'linkedin' => ['followers' => 967, 'engagement' => 9.8, 'growth' => 15]
                ],
                'topPerformingContent' => [
                    ['title' => 'Graduation Ceremony Announcement', 'type' => 'event', 'engagement' => 94.2],
                    ['title' => 'New AI Program Launch', 'type' => 'academic', 'engagement' => 87.6],
                    ['title' => 'Student Achievement Spotlight', 'type' => 'news', 'engagement' => 82.3],
                    ['title' => 'Alumni Network Expansion', 'type' => 'community', 'engagement' => 78.9]
                ],
                'recentCampaigns' => [
                    [
                        'id' => 1,
                        'name' => 'Graduation Ceremony 2025',
                        'type' => 'event',
                        'status' => 'active',
                        'impressions' => 45321,
                        'clicks' => 2847,
                        'ctr' => 6.3,
                        'budget' => 5000,
                        'spent' => 3240,
                        'startDate' => '2026-10-01',
                        'endDate' => '2026-12-31'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Spring 2027 Enrollment',
                        'type' => 'enrollment',
                        'status' => 'active',
                        'impressions' => 32156,
                        'clicks' => 1967,
                        'ctr' => 6.1,
                        'budget' => 8000,
                        'spent' => 4560,
                        'startDate' => '2026-09-15',
                        'endDate' => '2027-01-31'
                    ]
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $analytics
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get marketing analytics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create marketing campaign
     */
    public function createMarketingCampaign(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:event,enrollment,news,community',
            'description' => 'required|string|max:500',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|string',
            'platforms' => 'required|array',
            'content' => 'required|string'
        ]);

        try {
            // In a real app, this would save to database
            $campaignId = rand(1000, 9999);
            
            return response()->json([
                'success' => true,
                'message' => 'Marketing campaign created successfully!',
                'campaign' => [
                    'id' => $campaignId,
                    'name' => $request->name,
                    'type' => $request->type,
                    'status' => 'draft',
                    'created_at' => now()->format('F j, Y g:i A')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create campaign: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get email marketing templates
     */
    public function getEmailTemplates(): JsonResponse
    {
        $templates = [
            [
                'id' => 1,
                'name' => 'Welcome Email',
                'subject' => 'Welcome to GC University Community!',
                'type' => 'welcome',
                'openRate' => 91,
                'content' => 'Welcome aboard! Thank you for joining the GC University community...',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Course Registration',
                'subject' => 'Spring 2027 Course Registration Now Open',
                'type' => 'academic',
                'openRate' => 87,
                'content' => '🎓 Registration Now Open - Spring 2027 course registration is now available...',
                'status' => 'active'
            ],
            [
                'id' => 3,
                'name' => 'Event Invitation',
                'subject' => 'Graduation Ceremony 2025 - You\'re Invited!',
                'type' => 'event',
                'openRate' => 94,
                'content' => '🎓 You\'re Invited! - Join us for the graduation ceremony on July 26, 2025...',
                'status' => 'active'
            ],
            [
                'id' => 4,
                'name' => 'Newsletter',
                'subject' => 'GC University Monthly Newsletter',
                'type' => 'newsletter',
                'openRate' => 86,
                'content' => '📰 GC University News - Stay updated with the latest news and achievements...',
                'status' => 'active'
            ]
        ];

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }

    /**
     * Send marketing email campaign
     */
    public function sendEmailCampaign(Request $request): JsonResponse
    {
        $request->validate([
            'template_id' => 'required|integer',
            'subject' => 'required|string|max:200',
            'recipient_groups' => 'required|array',
            'schedule_date' => 'nullable|date'
        ]);

        try {
            // In a real app, this would queue the email sending job
            $campaignId = rand(10000, 99999);
            $recipientCount = count($request->recipient_groups) * 1000; // Mock calculation
            
            return response()->json([
                'success' => true,
                'message' => 'Email campaign scheduled successfully!',
                'campaign' => [
                    'id' => $campaignId,
                    'subject' => $request->subject,
                    'recipients' => $recipientCount,
                    'status' => $request->schedule_date ? 'scheduled' : 'sending',
                    'scheduled_for' => $request->schedule_date
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send campaign: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get registration settings for admin panel
     */
    public function getRegistrationSettings(): JsonResponse
    {
        $settings = \App\Services\RegistrationSettingService::getSettings();
        $totalRegistered = \App\Models\User::count();

        return response()->json([
            'success' => true,
            'settings' => $settings,
            'stats' => [
                'total_users' => $totalRegistered,
                'is_open' => \App\Services\RegistrationSettingService::isOpen(),
            ],
        ]);
    }

    /**
     * Update registration permission and configuration
     */
    public function updateRegistrationSettings(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'is_open' => 'sometimes|boolean',
            'status' => 'sometimes|string|in:open,closed',
            'academic_term' => 'sometimes|string|max:150',
            'closed_title' => 'sometimes|string|max:200',
            'closed_message' => 'sometimes|string|max:1000',
            'reopening_date' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:100',
            'contact_phone' => 'nullable|string|max:50',
            'announcement' => 'nullable|string|max:500',
        ]);

        $userName = auth()->check() ? auth()->user()->name : 'Administrator';
        $updated = \App\Services\RegistrationSettingService::updateSettings($validated, $userName);

        return response()->json([
            'success' => true,
            'message' => $updated['is_open'] 
                ? 'Registration has been opened successfully for applicants.' 
                : 'Registration has been closed. Public registration is now disabled.',
            'settings' => $updated,
            'is_open' => $updated['is_open'],
        ]);
    }
}
