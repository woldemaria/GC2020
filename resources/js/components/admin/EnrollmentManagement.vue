<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Course Enrollments</h1>
        <p class="text-gray-600">Manage student course enrollment applications</p>
      </div>
      
      <div class="flex items-center space-x-3">
        <!-- Filters -->
        <select
          v-model="selectedStatus"
          @change="filterEnrollments"
          class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        >
          <option value="">All Status</option>
          <option value="pending">Pending</option>
          <option value="approved">Approved</option>
          <option value="rejected">Rejected</option>
        </select>
        
        <select
          v-model="selectedDepartment"
          @change="filterEnrollments"
          class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
        >
          <option value="">All Departments</option>
          <option value="Computer Science & IT">Computer Science & IT</option>
          <option value="Engineering">Engineering</option>
          <option value="Business & Management">Business & Management</option>
          <option value="Medicine & Health Sciences">Medicine & Health Sciences</option>
          <option value="Natural Sciences">Natural Sciences</option>
          <option value="Social Sciences">Social Sciences</option>
        </select>
        
        <button
          @click="exportEnrollments"
          class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
        >
          <ArrowDownTrayIcon class="h-4 w-4 mr-2" />
          Export
        </button>
      </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <ClipboardDocumentListIcon class="h-8 w-8 text-blue-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Applications</p>
            <p class="text-2xl font-semibold text-gray-900">{{ enrollmentStats.total || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <ClockIcon class="h-8 w-8 text-yellow-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Pending Review</p>
            <p class="text-2xl font-semibold text-gray-900">{{ enrollmentStats.pending || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <CheckCircleIcon class="h-8 w-8 text-green-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Approved</p>
            <p class="text-2xl font-semibold text-gray-900">{{ enrollmentStats.approved || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <XCircleIcon class="h-8 w-8 text-red-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">This Month</p>
            <p class="text-2xl font-semibold text-gray-900">{{ enrollmentStats.thisMonth || 0 }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Enrollments Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Enrollment Applications</h3>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Student
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Course & Department
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Application Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-if="loading">
              <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                <div class="flex items-center justify-center">
                  <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                  <span class="ml-2">Loading enrollments...</span>
                </div>
              </td>
            </tr>
            
            <tr v-else-if="filteredEnrollments.length === 0">
              <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                No enrollment applications found.
              </td>
            </tr>
            
            <tr v-for="enrollment in filteredEnrollments" :key="enrollment.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ enrollment.student_name }}</div>
                  <div class="text-sm text-gray-500">{{ enrollment.student_email }}</div>
                  <div class="text-xs text-gray-400" v-if="enrollment.student_phone">{{ enrollment.student_phone }}</div>
                </div>
              </td>
              
              <td class="px-6 py-4">
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ enrollment.course_name }}</div>
                  <div class="text-sm text-gray-500">{{ enrollment.department }}</div>
                  <div class="text-xs text-gray-400">{{ enrollment.program_type }}</div>
                </div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ enrollment.created_at }}
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  :class="[
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                    enrollment.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    enrollment.status === 'approved' ? 'bg-green-100 text-green-800' :
                    enrollment.status === 'rejected' ? 'bg-red-100 text-red-800' :
                    'bg-gray-100 text-gray-800'
                  ]"
                >
                  {{ enrollment.status.charAt(0).toUpperCase() + enrollment.status.slice(1) }}
                </span>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-2">
                  <button
                    @click="viewEnrollment(enrollment)"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    View
                  </button>
                  
                  <button
                    v-if="enrollment.status === 'pending'"
                    @click="approveEnrollment(enrollment)"
                    class="text-green-600 hover:text-green-900"
                  >
                    Approve
                  </button>
                  
                  <button
                    v-if="enrollment.status === 'pending'"
                    @click="rejectEnrollment(enrollment)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Reject
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Enrollment Detail Modal -->
    <div v-if="selectedEnrollment" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Enrollment Application Details</h3>
            <button
              @click="selectedEnrollment = null"
              class="text-gray-400 hover:text-gray-600"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <h4 class="text-sm font-medium text-gray-900 mb-2">Student Information</h4>
              <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                <p><strong>Name:</strong> {{ selectedEnrollment.student_name }}</p>
                <p><strong>Email:</strong> {{ selectedEnrollment.student_email }}</p>
                <p v-if="selectedEnrollment.student_phone"><strong>Phone:</strong> {{ selectedEnrollment.student_phone }}</p>
                <p v-if="selectedEnrollment.student_id"><strong>Student ID:</strong> {{ selectedEnrollment.student_id }}</p>
              </div>
            </div>
            
            <div>
              <h4 class="text-sm font-medium text-gray-900 mb-2">Course Information</h4>
              <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                <p><strong>Course:</strong> {{ selectedEnrollment.course_name }}</p>
                <p><strong>Department:</strong> {{ selectedEnrollment.department }}</p>
                <p><strong>Program Type:</strong> {{ selectedEnrollment.program_type }}</p>
                <p><strong>Application Number:</strong> ENR{{ String(selectedEnrollment.id).padStart(6, '0') }}</p>
              </div>
            </div>
          </div>
          
          <div v-if="selectedEnrollment.motivation" class="mb-6">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Motivation</h4>
            <div class="bg-gray-50 p-4 rounded-lg">
              <p class="text-sm">{{ selectedEnrollment.motivation }}</p>
            </div>
          </div>
          
          <div class="flex items-center justify-end space-x-3">
            <button
              @click="selectedEnrollment = null"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Close
            </button>
            
            <button
              v-if="selectedEnrollment.status === 'pending'"
              @click="rejectEnrollment(selectedEnrollment)"
              class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700"
            >
              Reject
            </button>
            
            <button
              v-if="selectedEnrollment.status === 'pending'"
              @click="approveEnrollment(selectedEnrollment)"
              class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700"
            >
              Approve
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import {
  ClipboardDocumentListIcon,
  ClockIcon,
  CheckCircleIcon,
  XCircleIcon,
  ArrowDownTrayIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline';

const enrollments = ref([]);
const selectedEnrollment = ref(null);
const selectedStatus = ref('');
const selectedDepartment = ref('');
const loading = ref(true);

const enrollmentStats = computed(() => {
  const stats = {
    total: enrollments.value.length,
    pending: enrollments.value.filter(e => e.status === 'pending').length,
    approved: enrollments.value.filter(e => e.status === 'approved').length,
    rejected: enrollments.value.filter(e => e.status === 'rejected').length,
    thisMonth: enrollments.value.filter(e => {
      const enrollmentDate = new Date(e.created_at);
      const now = new Date();
      return enrollmentDate.getMonth() === now.getMonth() && 
             enrollmentDate.getFullYear() === now.getFullYear();
    }).length
  };
  return stats;
});

const filteredEnrollments = computed(() => {
  let filtered = enrollments.value;
  
  if (selectedStatus.value) {
    filtered = filtered.filter(e => e.status === selectedStatus.value);
  }
  
  if (selectedDepartment.value) {
    filtered = filtered.filter(e => e.department === selectedDepartment.value);
  }
  
  return filtered;
});

const fetchEnrollments = async () => {
  try {
    loading.value = true;
    // Mock data for demonstration
    enrollments.value = [
      {
        id: 1,
        student_name: 'John Smith',
        student_email: 'john.smith@example.com',
        student_phone: '+251-911-123456',
        student_id: 'STU001',
        course_name: 'BSc Computer Science',
        department: 'Computer Science & IT',
        program_type: 'Undergraduate',
        status: 'pending',
        motivation: 'I am passionate about technology and want to build innovative software solutions.',
        created_at: '2024-10-10'
      },
      {
        id: 2,
        student_name: 'Jane Doe',
        student_email: 'jane.doe@example.com',
        course_name: 'Data Structures & Algorithms',
        department: 'Computer Science & IT',
        program_type: 'Undergraduate',
        status: 'approved',
        motivation: 'I want to improve my programming skills and understand algorithms better.',
        created_at: '2024-10-08'
      },
      {
        id: 3,
        student_name: 'Alice Johnson',
        student_email: 'alice.johnson@example.com',
        course_name: 'Programming Fundamentals',
        department: 'Computer Science & IT',
        program_type: 'Undergraduate',
        status: 'pending',
        created_at: '2024-10-12'
      }
    ];
  } catch (error) {
    console.error('Failed to fetch enrollments:', error);
  } finally {
    loading.value = false;
  }
};

const viewEnrollment = (enrollment) => {
  selectedEnrollment.value = enrollment;
};

const approveEnrollment = async (enrollment) => {
  try {
    // Mock approval
    enrollment.status = 'approved';
    selectedEnrollment.value = null;
    alert(`Enrollment for ${enrollment.student_name} has been approved!`);
  } catch (error) {
    console.error('Failed to approve enrollment:', error);
  }
};

const rejectEnrollment = async (enrollment) => {
  try {
    // Mock rejection
    enrollment.status = 'rejected';
    selectedEnrollment.value = null;
    alert(`Enrollment for ${enrollment.student_name} has been rejected.`);
  } catch (error) {
    console.error('Failed to reject enrollment:', error);
  }
};

const exportEnrollments = () => {
  // Mock export functionality
  const csvContent = "data:text/csv;charset=utf-8," + 
    "Student Name,Email,Course,Department,Status,Application Date\n" +
    filteredEnrollments.value.map(e => 
      `${e.student_name},${e.student_email},${e.course_name},${e.department},${e.status},${e.created_at}`
    ).join("\n");
  
  const encodedUri = encodeURI(csvContent);
  const link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "enrollments.csv");
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const filterEnrollments = () => {
  // Filtering is handled by computed property
};

onMounted(() => {
  fetchEnrollments();
});
</script>