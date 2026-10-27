<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Header -->
    <section class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 text-white py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Application Form</h1>
        <p class="text-xl text-blue-100">
          Start your journey with us - Apply for your preferred program
        </p>
      </div>
    </section>

    <!-- Application Form -->
    <section class="py-12">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-8">
          <!-- Program Info -->
          <div v-if="selectedProgram" class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8 border-l-4 border-blue-500">
            <div class="flex items-center">
              <img :src="selectedProgram.image" :alt="selectedProgram.name" class="w-16 h-16 rounded-lg mr-4 object-cover">
              <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ selectedProgram.name }}</h2>
                <p class="text-gray-600">{{ selectedProgram.duration }} • {{ selectedProgram.type }}</p>
              </div>
            </div>
          </div>

          <form @submit.prevent="submitApplication" class="space-y-8">
            <!-- Personal Information -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Information
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                  <input 
                    v-model="form.firstName" 
                    type="text" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                  <input 
                    v-model="form.lastName" 
                    type="text" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                  <input 
                    v-model="form.email" 
                    type="email" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                  <input 
                    v-model="form.phone" 
                    type="tel" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                  <input 
                    v-model="form.dateOfBirth" 
                    type="date" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Nationality *</label>
                  <select 
                    v-model="form.nationality" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="">Select Nationality</option>
                    <option value="Ethiopian">Ethiopian</option>
                    <option value="Kenyan">Kenyan</option>
                    <option value="Ugandan">Ugandan</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Academic Background -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Academic Background
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">High School Name *</label>
                  <input 
                    v-model="form.highSchool" 
                    type="text" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Graduation Year *</label>
                  <select 
                    v-model="form.graduationYear" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="">Select Year</option>
                    <option v-for="year in graduationYears" :key="year" :value="year">{{ year }}</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">GPA/Grade *</label>
                  <input 
                    v-model="form.gpa" 
                    type="text" 
                    required 
                    placeholder="e.g., 3.8 or A"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Start Date *</label>
                  <select 
                    v-model="form.startDate" 
                    required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="">Select Semester</option>
                    <option value="Fall 2024">Fall 2024</option>
                    <option value="Spring 2025">Spring 2025</option>
                    <option value="Summer 2025">Summer 2025</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Documents Upload -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Required Documents
              </h3>
              <div class="space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <div class="mt-4">
                    <label for="transcripts" class="cursor-pointer">
                      <span class="mt-2 block text-sm font-medium text-gray-900">Upload High School Transcripts</span>
                      <span class="text-gray-500">PDF, JPG, PNG up to 10MB</span>
                    </label>
                    <input id="transcripts" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                  </div>
                </div>
              </div>
            </div>

            <!-- Personal Statement -->
            <div class="bg-gray-50 rounded-xl p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Personal Statement
              </h3>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Why do you want to study this program? (500 words max) *</label>
                <textarea 
                  v-model="form.personalStatement" 
                  required 
                  rows="6" 
                  maxlength="3000"
                  placeholder="Tell us about your goals, motivations, and why you're interested in this program..."
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
                <div class="text-right text-sm text-gray-500 mt-2">
                  {{ form.personalStatement?.length || 0 }}/3000 characters
                </div>
              </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
              <router-link 
                to="/departments" 
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold transition-colors"
              >
                Back to Departments
              </router-link>
              <button 
                type="submit" 
                :disabled="submitting"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 disabled:opacity-50 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg"
              >
                <span v-if="!submitting">Submit Application</span>
                <span v-else class="flex items-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Submitting...
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const selectedProgram = ref(null);
const submitting = ref(false);

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  dateOfBirth: '',
  nationality: '',
  highSchool: '',
  graduationYear: '',
  gpa: '',
  startDate: '',
  personalStatement: ''
});

const graduationYears = computed(() => {
  const currentYear = new Date().getFullYear();
  return Array.from({ length: 10 }, (_, i) => currentYear - i);
});

const submitApplication = async () => {
  submitting.value = true;
  
  // Simulate form submission
  setTimeout(() => {
    alert('Application submitted successfully! We will contact you soon.');
    submitting.value = false;
    // Reset form or redirect
  }, 2000);
};

onMounted(() => {
  // Get program info from route params, query parameters, or localStorage
  const programData = route.params.program || 
                      route.query.program || 
                      localStorage.getItem('selectedProgram');
  
  if (programData) {
    selectedProgram.value = typeof programData === 'string' ? JSON.parse(programData) : programData;
  }
  
  // Also check for URL parameters if passed from departments page
  if (route.query.programName) {
    selectedProgram.value = {
      name: route.query.programName,
      type: route.query.programType || 'Undergraduate',
      duration: route.query.programDuration || '4 years',
      image: route.query.programImage || 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop'
    };
  }
});
</script>

<style scoped>
.hover\:scale-105:hover {
  transform: scale(1.05);
}
</style>