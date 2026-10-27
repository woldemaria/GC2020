<template>
  <div class="min-h-screen bg-[#f3f4f6]">
    <!-- CallSheet Inspired: Glassy Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 z-50">
      <div class="backdrop-blur-md bg-white/70 border-t border-gray-200 px-4 pb-4 pt-3 shadow-lg">
        <div class="flex justify-around">
          <button
            @click="goHome"
            class="flex flex-col items-center gap-1 p-2"
            :class="currentTab === 'home' ? 'text-blue-600' : 'text-gray-400'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] font-medium">Home</span>
          </button>
          <button
            @click="goGownCap"
            class="flex flex-col items-center gap-1 p-2"
            :class="currentTab === 'gowncap' ? 'text-blue-600' : 'text-gray-400'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253" />
            </svg>
            <span class="text-[10px] font-medium">Gown & Cap</span>
          </button>
          <button
            @click="goCertTranscript"
            class="flex flex-col items-center gap-1 p-2"
            :class="currentTab === 'certtranscript' ? 'text-blue-600' : 'text-gray-400'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-[10px] font-medium">Certificate</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Header -->
    <div class="backdrop-blur-lg bg-white/80 border-b border-gray-200 px-4 pb-3 pt-3 sticky top-0 z-40">
      <div class="flex items-center justify-between">
        <button
          @click="goBack"
          class="flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-700 text-sm font-medium hover:bg-blue-50 hover:border-blue-200 transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Back
        </button>
        <div>
          <h1 class="text-lg font-black text-gray-900">Gown & Cap Request</h1>
          <p class="text-xs text-gray-500">Order your graduation regalia</p>
        </div>
      </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 pt-6 pb-24">
      <!-- Student Info -->
      <section class="mb-6">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Student Information
          </h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Student ID</label>
              <input
                v-model="form.studentId"
                type="text"
                placeholder="e.g. GC2021001"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
              <input
                v-model="form.fullName"
                type="text"
                placeholder="e.g. Abebe Kebede"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Department</label>
              <select
                v-model="form.department"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Select Department</option>
                <option>Computer Science & IT</option>
                <option>Engineering</option>
                <option>Medicine & Health Sciences</option>
                <option>Business & Management</option>
                <option>Law & Governance</option>
                <option>Social Sciences & Humanities</option>
                <option>Natural Sciences</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Program</label>
              <input
                v-model="form.program"
                type="text"
                placeholder="e.g. BSc Computer Science"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
          </div>
        </div>
      </section>

      <!-- Gown & Cap Size Selection -->
      <section class="mb-6">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Regalia Size Selection
          </h2>
          <p class="text-sm text-gray-600 mb-4">
            Select your gown and cap size. If unsure, refer to the size chart below.
          </p>

          <!-- Gown Size -->
          <div class="mb-5">
            <label class="block text-xs font-medium text-gray-700 mb-2">Gown Size</label>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
              <button
                v-for="size in gownSizes"
                :key="size"
                @click="form.gownSize = size"
                :class="[
                  'px-3 py-2 rounded-xl border text-sm font-medium transition-colors',
                  form.gownSize === size
                    ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                    : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-blue-50 hover:border-blue-200'
                ]"
              >
                {{ size }}
              </button>
            </div>
          </div>

          <!-- Cap Size -->
          <div class="mb-5">
            <label class="block text-xs font-medium text-gray-700 mb-2">Cap Size</label>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
              <button
                v-for="size in capSizes"
                :key="size"
                @click="form.capSize = size"
                :class="[
                  'px-3 py-2 rounded-xl border text-sm font-medium transition-colors',
                  form.capSize === size
                    ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                    : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-blue-50 hover:border-blue-200'
                ]"
              >
                {{ size }}
              </button>
            </div>
          </div>

          <!-- Size Chart -->
          <div class="pt-4 border-t border-gray-100">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
              Size Chart
            </h3>
            <div class="overflow-x-auto">
              <table class="w-full text-sm border-collapse">
                <thead>
                  <tr class="border-b border-gray-200">
                    <th class="pb-2 text-left text-xs font-semibold text-gray-500">Size</th>
                    <th class="pb-2 text-left text-xs font-semibold text-gray-500">Height</th>
                    <th class="pb-2 text-left text-xs font-semibold text-gray-500">Weight</th>
                    <th class="pb-2 text-left text-xs font-semibold text-gray-500">Chest</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-700 font-medium">S</td>
                    <td class="py-2 text-gray-600">5'0" - 5'4"</td>
                    <td class="py-2 text-gray-600">100-140 lbs</td>
                    <td class="py-2 text-gray-600">34-36"</td>
                  </tr>
                  <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-700 font-medium">M</td>
                    <td class="py-2 text-gray-600">5'4" - 5'8"</td>
                    <td class="py-2 text-gray-600">140-180 lbs</td>
                    <td class="py-2 text-gray-600">38-40"</td>
                  </tr>
                  <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-700 font-medium">L</td>
                    <td class="py-2 text-gray-600">5'8" - 6'0"</td>
                    <td class="py-2 text-gray-600">180-220 lbs</td>
                    <td class="py-2 text-gray-600">42-44"</td>
                  </tr>
                  <tr class="border-b border-gray-100">
                    <td class="py-2 text-gray-700 font-medium">XL</td>
                    <td class="py-2 text-gray-600">6'0" - 6'4"</td>
                    <td class="py-2 text-gray-600">220-260 lbs</td>
                    <td class="py-2 text-gray-600">46-48"</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>

      <!-- Pickup Details -->
      <section class="mb-6">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Pickup Details
          </h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Pickup Date</label>
              <input
                v-model="form.pickupDate"
                type="date"
                min="2026-06-01"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Pickup Time</label>
              <select
                v-model="form.pickupTime"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="09:00">9:00 AM - 11:00 AM</option>
                <option value="11:00">11:00 AM - 1:00 PM</option>
                <option value="13:00">1:00 PM - 3:00 PM</option>
                <option value="15:00">3:00 PM - 5:00 PM</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Pickup Location</label>
              <select
                v-model="form.pickupLocation"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="registrar">Registrar's Office - Main Building</option>
                <option value="bookstore">University Bookstore - North Campus</option>
                <option value="dean">Dean of Students Office - Admin Building</option>
              </select>
            </div>
            <div class="col-span-2">
              <label class="block text-xs font-medium text-gray-700 mb-1">Additional Notes</label>
              <textarea
                v-model="form.notes"
                rows="2"
                placeholder="Any special instructions..."
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              ></textarea>
            </div>
          </div>
        </div>
      </section>

      <!-- Submit Button -->
      <button
        @click="submitRequest"
        :disabled="submitting || !isFormValid"
        class="w-full bg-blue-600 text-white py-4 rounded-2xl text-lg font-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-lg hover:shadow-xl transform active:scale-[0.98]"
      >
        <span v-if="submitting" class="flex items-center justify-center gap-2">
          <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Submitting...
        </span>
        <span v-else>Submit Gown & Cap Request</span>
      </button>

      <!-- Confirmation Modal -->
      <div v-if="showConfirmation" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showConfirmation = false"></div>
        <div class="backdrop-blur-2xl bg-white/90 border border-gray-200 rounded-3xl shadow-2xl max-w-md w-full p-6 text-center relative">
          <button
            @click="showConfirmation = false"
            class="absolute top-4 right-4 p-2 text-gray-400 hover:text-gray-600 transition-colors"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h2 class="text-xl font-black text-gray-900 mb-2">Request Submitted</h2>
          <p class="text-gray-600 text-sm mb-6">
            Your gown and cap request has been submitted successfully.
          </p>
          <div class="p-4 rounded-xl border border-green-100 bg-green-50 mb-6">
            <p class="text-xs font-semibold text-green-800 mb-1">Request Number</p>
            <p class="text-sm font-mono text-green-700">{{ confirmationNumber }}</p>
          </div>
          <button
            @click="showConfirmation = false"
            class="bg-blue-600 text-white px-6 py-2 rounded-xl font-medium hover:bg-blue-700 transition-colors"
          >
            Done
          </button>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const currentTab = ref('gowncap');

const goHome = () => router.push('/');
const goGownCap = () => router.push('/gown-cap');
const goCertTranscript = () => router.push('/certificate-transcript');
const goBack = () => router.back();

// Form state
const form = ref({
  studentId: '',
  fullName: '',
  department: '',
  program: '',
  gownSize: '',
  capSize: '',
  pickupDate: '',
  pickupTime: '',
  pickupLocation: '',
  notes: ''
});

const gownSizes = ref(['S', 'M', 'L', 'XL']);
const capSizes = ref(['S', 'M', 'L', 'XL']);

const submitting = ref(false);
const showConfirmation = ref(false);
const confirmationNumber = ref('');

const isFormValid = computed(() => {
  const f = form.value;
  return Boolean(
    f.studentId &&
    f.fullName &&
    f.department &&
    f.program &&
    f.gownSize &&
    f.capSize &&
    f.pickupDate &&
    f.pickupTime &&
    f.pickupLocation
  );
});

const submitRequest = async () => {
  if (!isFormValid.value) return;
  submitting.value = true;

  // Simulate API call
  await new Promise(resolve => setTimeout(resolve, 1500));

  confirmationNumber.value = 'GC-' + Date.now().toString().slice(-6);
  submitting.value = false;
  showConfirmation.value = true;
};
</script>