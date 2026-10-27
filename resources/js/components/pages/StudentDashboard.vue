<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <img :src="student.avatar" :alt="student.name" class="w-12 h-12 rounded-full mr-4">
            <div>
              <h1 class="text-2xl font-bold text-gray-900">{{ student.name }}</h1>
              <p class="text-gray-600">{{ student.studentId }} | {{ student.department }}</p>
            </div>
          </div>
          
          <div class="flex items-center space-x-4">
            <button
              @click="showCertificateModal = true"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
            >
              View Certificate
            </button>
            <button
              @click="showProfileModal = true"
              class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
            >
              Profile Settings
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
          <!-- Academic Overview -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Academic Overview</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
              <div class="bg-blue-50 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ student.gpa }}</div>
                <div class="text-sm text-gray-600">Current GPA</div>
              </div>
              <div class="bg-green-50 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ student.creditsCompleted }}</div>
                <div class="text-sm text-gray-600">Credits Completed</div>
              </div>
              <div class="bg-purple-50 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ student.semester }}</div>
                <div class="text-sm text-gray-600">Current Semester</div>
              </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-4">
              <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Degree Progress</span>
                <span>{{ Math.round((student.creditsCompleted / student.totalCreditsRequired) * 100) }}%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div 
                  class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                  :style="{ width: (student.creditsCompleted / student.totalCreditsRequired) * 100 + '%' }"
                ></div>
              </div>
            </div>
          </div>

          <!-- Current Courses -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Current Courses</h2>
            
            <div class="space-y-4">
              <div 
                v-for="course in student.currentCourses" 
                :key="course.id"
                class="border border-gray-200 rounded-lg p-4"
              >
                <div class="flex items-center justify-between mb-2">
                  <h3 class="font-semibold text-gray-900">{{ course.name }}</h3>
                  <span :class="getGradeColor(course.grade)" class="px-2 py-1 rounded text-sm font-medium">
                    {{ course.grade }}
                  </span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600">
                  <span>{{ course.code }} | {{ course.credits }} Credits</span>
                  <span>{{ course.instructor }}</span>
                </div>
                <div class="mt-2">
                  <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Progress</span>
                    <span>{{ course.progress }}%</span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-1">
                    <div 
                      class="bg-green-500 h-1 rounded-full" 
                      :style="{ width: course.progress + '%' }"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Activities -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Activities</h2>
            
            <div class="space-y-4">
              <div 
                v-for="activity in student.recentActivities" 
                :key="activity.id"
                class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg"
              >
                <div :class="['w-10 h-10 rounded-full flex items-center justify-center text-white', activity.colorClass]">
                  <component :is="activity.icon" class="w-5 h-5" />
                </div>
                <div class="flex-1">
                  <h3 class="font-medium text-gray-900">{{ activity.title }}</h3>
                  <p class="text-gray-600 text-sm">{{ activity.description }}</p>
                  <p class="text-gray-500 text-xs mt-1">{{ activity.date }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Quick Stats -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Rank in Class</span>
                <span class="font-semibold text-blue-600">#{{ student.classRank }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Total Students</span>
                <span class="font-semibold text-gray-900">{{ student.totalStudents }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Expected Graduation</span>
                <span class="font-semibold text-green-600">{{ student.expectedGraduation }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-gray-600">Dean's List</span>
                <span class="font-semibold text-yellow-600">{{ student.deansListSemesters }} times</span>
              </div>
            </div>
          </div>

          <!-- Upcoming Events -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Events</h3>
            
            <div class="space-y-3">
              <div 
                v-for="event in upcomingEvents" 
                :key="event.id"
                class="border-l-4 border-blue-500 pl-4 py-2"
              >
                <h4 class="font-medium text-gray-900 text-sm">{{ event.title }}</h4>
                <p class="text-gray-600 text-xs">{{ event.date }}</p>
                <p class="text-gray-500 text-xs">{{ event.location }}</p>
              </div>
            </div>
          </div>

          <!-- Academic Calendar -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Calendar</h3>
            
            <div class="space-y-3">
              <div 
                v-for="item in academicCalendar" 
                :key="item.id"
                class="flex items-center justify-between text-sm"
              >
                <span class="text-gray-600">{{ item.event }}</span>
                <span class="text-blue-600 font-medium">{{ item.date }}</span>
              </div>
            </div>
          </div>

          <!-- Certificate Preview -->
          <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Certificate Preview</h3>
            
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-4 text-center border-2 border-dashed border-blue-300">
              <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 14 6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
              </div>
              <p class="text-blue-800 font-medium mb-2">Digital Certificate</p>
              <p class="text-blue-600 text-sm mb-3">Available upon graduation</p>
              <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                Preview Certificate
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Certificate Preview Modal -->
  <div v-if="showCertificateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-screen overflow-y-auto">
      <div class="p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-xl font-bold text-gray-900">Digital Certificate</h3>
          <button
            @click="showCertificateModal = false"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 text-white rounded-xl p-8 mb-6">
          <div class="flex justify-between items-start mb-6">
            <div>
              <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 14 6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
              </div>
              <h2 class="text-2xl font-bold mb-1">{{ student.name }}</h2>
              <p class="text-blue-200">{{ student.studentId }}</p>
            </div>
            <div class="text-right">
              <div class="text-xs text-blue-200 mb-1">Certificate Number</div>
              <div class="text-xl font-mono font-bold">{{ student.studentId }}</div>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-xs text-blue-200 uppercase">Qualification</p>
              <p class="text-lg font-medium">{{ student.department }}</p>
            </div>
            <div>
              <p class="text-xs text-blue-200 uppercase">Graduation Date</p>
              <p class="text-lg font-medium">{{ student.expectedGraduation }}</p>
            </div>
          </div>

          <p class="mt-4 text-blue-200 text-sm italic">
            This certifies that {{ student.name }} has successfully completed the academic program
            in {{ student.department }} with a GPA of {{ student.gpa }}.
          </p>

          <div class="mt-6 flex justify-between text-xs text-blue-200">
            <div>
              <p>Issued By:</p>
              <p class="font-medium">GC University Registrar</p>
            </div>
            <div>
              <p>Date Issued:</p>
              <p class="font-medium">{{ new Date().toLocaleDateString() }}</p>
            </div>
          </div>
        </div>

        <div class="flex justify-end">
          <button
            @click="showCertificateModal = false"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Profile Settings Modal -->
  <div v-if="showProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-md max-h-screen overflow-y-auto">
      <div class="p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-xl font-bold text-gray-900">Profile Settings</h3>
          <button
            @click="showProfileModal = false"
            class="text-gray-400 hover:text-gray-600"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input
              v-model="profileForm.name"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
            <input
              v-model="profileForm.studentId"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
            <input
              v-model="profileForm.department"
              type="text"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input
              v-model="profileForm.email"
              type="email"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
            <input
              v-model="profileForm.phone"
              type="tel"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
          </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
          <button
            @click="showProfileModal = false"
            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
          >
            Cancel
          </button>
          <button
            @click="saveProfile"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
          >
            Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StudentDashboard',
  data() {
    return {
      showCertificateModal: false,
      showProfileModal: false,
      profileForm: {
        name: '',
        studentId: '',
        department: '',
        email: '',
        phone: ''
      },
      student: {
        name: 'Abebe Kebede',
        studentId: 'GC2021001',
        department: 'Computer Science & IT',
        avatar: '/images/avatars/student-dashboard.jpg',
        gpa: 3.85,
        creditsCompleted: 102,
        totalCreditsRequired: 128,
        semester: '7th',
        classRank: 15,
        totalStudents: 245,
        expectedGraduation: 'June 2025',
        deansListSemesters: 4,
        currentCourses: [
          {
            id: 1,
            name: 'Advanced Software Engineering',
            code: 'CS 401',
            credits: 4,
            instructor: 'Dr. Sarah Johnson',
            grade: 'A-',
            progress: 75
          },
          {
            id: 2,
            name: 'Machine Learning',
            code: 'CS 425',
            credits: 3,
            instructor: 'Prof. Michael Chen',
            grade: 'B+',
            progress: 68
          },
          {
            id: 3,
            name: 'Database Systems',
            code: 'CS 350',
            credits: 3,
            instructor: 'Dr. Emily Rodriguez',
            grade: 'A',
            progress: 82
          },
          {
            id: 4,
            name: 'Computer Networks',
            code: 'CS 380',
            credits: 4,
            instructor: 'Prof. David Wilson',
            grade: 'B',
            progress: 60
          }
        ],
        recentActivities: [
          {
            id: 1,
            title: 'Assignment Submitted',
            description: 'Machine Learning Project - Phase 2 submitted successfully',
            date: '2 hours ago',
            icon: 'DocumentCheckIcon',
            colorClass: 'bg-green-500'
          },
          {
            id: 2,
            title: 'Grade Updated',
            description: 'Database Systems Midterm - Grade: A (95/100)',
            date: '1 day ago',
            icon: 'AcademicCapIcon',
            colorClass: 'bg-blue-500'
          },
          {
            id: 3,
            title: 'New Announcement',
            description: 'CS Department: Career Fair Registration Open',
            date: '3 days ago',
            icon: 'SpeakerWaveIcon',
            colorClass: 'bg-yellow-500'
          },
          {
            id: 4,
            title: 'Course Registered',
            description: 'Successfully registered for Senior Project (CS 499)',
            date: '1 week ago',
            icon: 'BookOpenIcon',
            colorClass: 'bg-purple-500'
          }
        ]
      },
      upcomingEvents: [
        {
          id: 1,
          title: 'CS Department Career Fair',
          date: 'March 25, 2024',
          location: 'Main Auditorium'
        },
        {
          id: 2,
          title: 'Machine Learning Workshop',
          date: 'March 28, 2024',
          location: 'Lab 401'
        },
        {
          id: 3,
          title: 'Senior Project Presentation',
          date: 'April 15, 2024',
          location: 'Conference Hall'
        }
      ],
      academicCalendar: [
        { id: 1, event: 'Midterm Exams', date: 'Apr 1-5' },
        { id: 2, event: 'Spring Break', date: 'Apr 8-12' },
        { id: 3, event: 'Final Exams', date: 'May 20-24' },
        { id: 4, event: 'Graduation', date: 'June 15' }
      ]
    }
  },
  methods: {
    getGradeColor(grade) {
      if (grade.includes('A')) return 'bg-green-100 text-green-800';
      if (grade.includes('B')) return 'bg-blue-100 text-blue-800';
      if (grade.includes('C')) return 'bg-yellow-100 text-yellow-800';
      return 'bg-red-100 text-red-800';
    },
    saveProfile() {
      this.showProfileModal = false;
    }
  }
}
</script>