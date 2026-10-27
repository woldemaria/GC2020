<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h3 class="text-lg font-semibold text-gray-900">Graduation Portal</h3>
        <p class="text-sm text-gray-500">
          Check your graduation status, apply for graduation, and verify your
          academic records with Addis Ababa University.
        </p>
      </div>
      <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xs font-bold">
        AU
      </div>
    </div>

    <!-- Student Graduation Status -->
    <div class="mb-6 p-5 rounded-xl bg-blue-50 border border-blue-100">
      <div class="flex items-center justify-between mb-4">
        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">
          Graduation Status
        </h4>
        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-700">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
          </span>
          Eligible for Graduation
        </span>
      </div>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
          <p class="text-gray-500">Student ID</p>
          <p class="font-medium text-gray-900">{{ graduationProfile.studentId }}</p>
        </div>
        <div>
          <p class="text-gray-500">Program</p>
          <p class="font-medium text-gray-900">{{ graduationProfile.program }}</p>
        </div>
        <div>
          <p class="text-gray-500">Department</p>
          <p class="font-medium text-gray-900">{{ graduationProfile.department }}</p>
        </div>
        <div>
          <p class="text-gray-500">CGPA</p>
          <p class="font-medium text-gray-900">{{ graduationProfile.cgpa }}</p>
        </div>
        <div>
          <p class="text-gray-500">Credits Completed</p>
          <p class="font-medium text-gray-900">{{ graduationProfile.creditsCompleted }} / {{ graduationProfile.totalCredits }}</p>
        </div>
        <div>
          <p class="text-gray-500">Graduation Date</p>
          <p class="font-medium text-gray-900">{{ graduationProfile.graduationDate }}</p>
        </div>
      </div>
    </div>

    <!-- Graduation Requirements Checklist -->
    <div class="mb-6">
      <h4 class="text-sm font-semibold text-gray-900 mb-4">Graduation Requirements</h4>
      <div class="space-y-3">
        <div
          v-for="(req, index) in graduationRequirements"
          :key="index"
          class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white"
        >
          <input
            v-model="req.completed"
            type="checkbox"
            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            disabled
          />
          <div class="flex-1">
            <p class="text-sm text-gray-900">{{ req.title }}</p>
            <p class="text-xs text-gray-500">{{ req.description }}</p>
          </div>
          <span
            class="px-2 py-0.5 rounded text-xs font-medium"
            :class="req.completed ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
          >
            {{ req.completed ? 'Complete' : 'Pending' }}
          </span>
        </div>
      </div>
    </div>

    <!-- Apply for Graduation -->
    <div class="mb-6 p-5 rounded-xl border-2 border-dashed border-gray-300">
      <h4 class="text-sm font-semibold text-gray-900 mb-3">Apply for Graduation</h4>
      <p class="text-xs text-gray-500 mb-4">
        Submit your graduation application to be reviewed by the Registrar's
        Office.
      </p>
      <div class="space-y-3">
        <div>
          <label class="block text-xs font-medium text-gray-700 mb-1">
            Full Name
          </label>
          <input
            v-model="applicationForm.fullName"
            type="text"
            placeholder="Enter your full name"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
        </div>
        <div>
          <label class="block text-xs font-medium text-gray-700 mb-1">
            Email Address
          </label>
          <input
            v-model="applicationForm.email"
            type="email"
            placeholder="student@aau.edu.et"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
        </div>
        <div>
          <label class="block text-xs font-medium text-gray-700 mb-1">
            Program of Study
          </label>
          <select
            v-model="applicationForm.program"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
            <option value="">Select Program</option>
            <option>Computer Science</option>
            <option>Information Technology</option>
            <option>Business Administration</option>
            <option>Engineering</option>
            <option>Medicine</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-medium text-gray-700 mb-1">
            Expected Graduation Date
          </label>
          <input
            v-model="applicationForm.expectedDate"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
        </div>
        <button
          @click="submitApplication"
          class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          :disabled="submitting"
        >
          {{ submitting ? 'Submitting...' : 'Submit Application' }}
        </button>
      </div>
    </div>

    <!-- Certificate Verification -->
    <div class="mb-6 p-5 rounded-xl border border-gray-200">
      <div class="flex items-center justify-between mb-4">
        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">
          Certificate Verification
        </h4>
        <button
          @click="showVerifyModal = true"
          class="text-xs bg-blue-600 text-white px-2.5 py-1 rounded hover:bg-blue-700 transition-colors"
        >
          Verify Certificate
        </button>
      </div>
      <p class="text-xs text-gray-500">
        Verify the authenticity of your graduation certificate using your
        certificate number.
      </p>
      <div class="mt-4 flex gap-2">
        <span class="px-3 py-1.5 rounded-md bg-gray-100 text-xs text-gray-600">
          Certificate #{{ verificationCode }}
        </span>
        <button
          @click="copyVerificationCode"
          class="px-3 py-1.5 rounded-md border border-gray-300 bg-white text-xs text-gray-700 hover:bg-gray-50 transition-colors"
        >
          Copy Code
        </button>
      </div>
    </div>

    <!-- Graduation Ceremony Details -->
    <div class="p-5 rounded-xl border border-gray-200">
      <h4 class="text-sm font-semibold text-gray-900 mb-3">Upcoming Ceremony</h4>
      <div class="flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-sm font-medium text-gray-900">2025 Graduation Ceremony</p>
          <p class="text-xs text-gray-500">June 15, 2025 · Addis Ababa University Main Campus</p>
        </div>
        <button
          class="text-xs bg-indigo-600 text-white px-2.5 py-1 rounded hover:bg-indigo-700 transition-colors"
        >
          View Details
        </button>
      </div>
    </div>

    <!-- Certificate Verification Modal -->
    <div v-if="showVerifyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-2xl w-full max-w-md max-h-screen overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Verify Certificate</h3>
            <button
              @click="showVerifyModal = false"
              class="text-gray-400 hover:text-gray-600"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Certificate Number
              </label>
              <input
                v-model="verifyForm.certificateNumber"
                type="text"
                placeholder="e.g. AU-GC-2025-00123"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Student ID
              </label>
              <input
                v-model="verifyForm.studentId"
                type="text"
                placeholder="e.g. GC2021001"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>

          <div class="mt-6 flex justify-end gap-3">
            <button
              @click="showVerifyModal = false"
              class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button
              @click="verifyCertificate"
              class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
            >
              Verify
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const graduationProfile = ref({
  studentId: 'GC2021001',
  program: 'Bachelor of Science in Computer Science',
  department: 'Department of Computer Science',
  cgpa: '3.78',
  creditsCompleted: 124,
  totalCredits: 128,
  graduationDate: 'June 15, 2025'
});

const graduationRequirements = ref([
  { title: 'Complete Required Coursework', description: 'All core and elective courses completed with passing grades', completed: true },
  { title: 'Minimum CGPA Requirement', description: 'Maintain a cumulative GPA of 2.0 or higher', completed: true },
  { title: 'Senior Project / Thesis', description: 'Capstone project approved and submitted', completed: true },
  { title: 'Clear All Financial Obligations', description: 'Tuition and library fees paid in full', completed: false },
  { title: 'Graduation Application Submitted', description: 'Official graduation application on file with Registrar', completed: false },
  { title: 'Attend Graduation Rehearsal', description: 'Mandatory rehearsal before ceremony day', completed: false }
]);

const applicationForm = ref({
  fullName: '',
  email: '',
  program: '',
  expectedDate: ''
});

const submitting = ref(false);

const verificationCode = ref('AU-GC-2025-00123');

const showVerifyModal = ref(false);

const verifyForm = ref({
  certificateNumber: '',
  studentId: ''
});

const submitApplication = async () => {
  submitting.value = true;
  // Simulate API call
  await new Promise(resolve => setTimeout(resolve, 1500));
  submitting.value = false;
  alert('Graduation application submitted successfully!');
};

const copyVerificationCode = () => {
  navigator.clipboard.writeText(verificationCode.value);
  alert('Certificate code copied to clipboard!');
};

const verifyCertificate = async () => {
  // Simulate verification
  alert('Certificate verified successfully!');
  showVerifyModal.value = false;
};
</script>