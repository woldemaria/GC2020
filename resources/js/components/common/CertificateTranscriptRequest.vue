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
          <h1 class="text-lg font-black text-gray-900">Certificate & Transcript</h1>
          <p class="text-xs text-gray-500">Request and track your academic documents</p>
        </div>
      </div>
    </div>

    <main class="max-w-2xl mx-auto px-4 pt-6 pb-24">
      <!-- Request Type Selection -->
      <section class="mb-6">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Select Document Type
          </h2>
          <div class="grid grid-cols-2 gap-3">
            <button
              v-for="doc in documentTypes"
              :key="doc.id"
              @click="selectDocument(doc)"
              :class="[
                'p-4 rounded-xl border text-center transition-colors cursor-pointer',
                selectedDoc?.id === doc.id
                  ? 'bg-blue-50 border-blue-200 text-blue-700 shadow-sm'
                  : 'bg-white border-gray-200 text-gray-700 hover:bg-blue-50 hover:border-blue-200'
              ]"
            >
              <div class="w-10 h-10 rounded-lg flex items-center justify-center mx-auto mb-2"
                :class="selectedDoc?.id === doc.id ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-400'"
              >
                {{ doc.icon }}
              </div>
              <div class="text-sm font-semibold text-gray-900">{{ doc.name }}</div>
              <div class="text-xs text-gray-500">{{ doc.description }}</div>
            </button>
          </div>
        </div>
      </section>

      <!-- Request Form -->
      <section v-if="selectedDoc" class="mb-6">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Request Details
          </h2>
          <form @submit.prevent="submitRequest" class="space-y-4">
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Student ID</label>
              <input
                v-model="form.studentId"
                type="text"
                placeholder="e.g. GC2021001"
                required
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Full Name</label>
              <input
                v-model="form.fullName"
                type="text"
                placeholder="e.g. Abebe Kebede"
                required
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Document Type</label>
              <input
                :value="selectedDoc.name"
                readonly
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-100 text-gray-700"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Delivery Method</label>
              <select
                v-model="form.deliveryMethod"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="pickup">Pickup at Registrar's Office</option>
                <option value="mail">Mail to Address</option>
                <option value="download">Digital Download</option>
              </select>
            </div>
            <div v-if="form.deliveryMethod === 'mail'" class="space-y-2">
              <label class="block text-xs font-medium text-gray-700 mb-1">Mailing Address</label>
              <textarea
                v-model="form.mailingAddress"
                rows="2"
                placeholder="Enter your mailing address"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Purpose</label>
              <select
                v-model="form.purpose"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="employment">Employment</option>
                <option value="further-studies">Further Studies</option>
                <option value="personal">Personal Records</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">Number of Copies</label>
              <input
                v-model="form.copies"
                type="number"
                min="1"
                max="10"
                value="1"
                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>

            <button
              type="submit"
              :disabled="submitting"
              class="w-full bg-blue-600 text-white py-3 rounded-xl text-lg font-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-lg hover:shadow-xl"
            >
              <span v-if="submitting" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
              </span>
              <span v-else>Request Document</span>
            </button>
          </form>
        </div>
      </section>

      <!-- Request History / Tracking -->
      <section v-if="requests.length > 0">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500">
              Request History & Tracking
            </h2>
            <button
              @click="refreshTracking"
              class="text-xs text-blue-600 hover:text-blue-800 font-medium"
            >
              <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Refresh
            </button>
          </div>
          <div class="space-y-3">
            <div
              v-for="req in requests"
              :key="req.id"
              class="p-3 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-between"
            >
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <span class="text-xs font-semibold text-gray-900">{{ req.documentType }}</span>
                  <span
                    :class="[
                      'px-2 py-0.5 rounded text-xs font-medium',
                      req.status === 'completed'
                        ? 'bg-green-100 text-green-700'
                        : req.status === 'processing'
                        ? 'bg-blue-100 text-blue-700'
                        : 'bg-yellow-100 text-yellow-700'
                    ]"
                  >
                    {{ req.status }}
                  </span>
                </div>
                <div class="text-sm text-gray-600 truncate">
                  Request #{{ req.trackingNumber }} · {{ req.requestedDate }}
                </div>
              </div>
              <div class="flex items-center gap-3">
                <button
                  @click="downloadDocument(req)"
                  v-if="req.status === 'completed'"
                  class="px-3 py-1.5 rounded-md border border-gray-200 bg-white text-sm text-blue-600 font-medium hover:bg-blue-50 transition-colors"
                >
                  <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                  Download
                </button>
                <button
                  @click="copyTracking(req)"
                  class="px-3 py-1.5 rounded-md border border-gray-200 bg-white text-sm text-gray-600 font-medium hover:bg-gray-50 transition-colors"
                >
                  <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l-4-4m4 4l4-4" />
                  </svg>
                  Track
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

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
          <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.002 12.002 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <h2 class="text-xl font-black text-gray-900 mb-2">Request Submitted</h2>
          <p class="text-gray-600 text-sm mb-6">
            Your {{ selectedDoc?.name }} request has been submitted.
          </p>
          <div class="p-4 rounded-xl border border-blue-100 bg-blue-50 mb-6">
            <p class="text-xs font-semibold text-blue-800 mb-1">Tracking Number</p>
            <p class="text-sm font-mono text-blue-700">{{ confirmationNumber }}</p>
          </div>
          <div class="flex gap-2">
            <button
              @click="copyTrackingNumber"
              class="flex-1 bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium hover:bg-gray-50 transition-colors"
            >
              Copy Tracking
            </button>
            <button
              @click="showConfirmation = false"
              class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition-colors"
            >
              Done
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const currentTab = ref('certtranscript');

const goHome = () => router.push('/');
const goGownCap = () => router.push('/gown-cap');
const goCertTranscript = () => router.push('/certificate-transcript');
const goBack = () => router.back();

// Document types
const documentTypes = ref([
  { id: 'diploma', name: 'Diploma Certificate', icon: '🎓', description: 'Official graduation diploma' },
  { id: 'transcript', name: 'Academic Transcript', icon: '📄', description: 'Complete academic record' },
  { id: 'both', name: 'Diploma + Transcript', icon: '🎓📄', description: 'Both diploma and transcript' }
]);

const selectedDoc = ref(null);
const selectDocument = (doc) => {
  selectedDoc.value = doc;
};

// Form state
const form = ref({
  studentId: '',
  fullName: '',
  deliveryMethod: 'pickup',
  mailingAddress: '',
  purpose: 'employment',
  copies: '1'
});

// Request history with tracking
const requests = ref([
  {
    id: 1,
    documentType: 'Academic Transcript',
    trackingNumber: 'GC-TR-2025-00142',
    status: 'completed',
    requestedDate: 'May 15, 2026',
    downloadUrl: '#'
  },
  {
    id: 2,
    documentType: 'Diploma Certificate',
    trackingNumber: 'GC-DP-2025-00138',
    status: 'processing',
    requestedDate: 'May 10, 2026',
    downloadUrl: null
  }
]);

const submitting = ref(false);
const showConfirmation = ref(false);
const confirmationNumber = ref('');

const submitRequest = async () => {
  if (!form.value.studentId || !form.value.fullName || !selectedDoc.value) return;
  submitting.value = true;

  // Simulate API call
  await new Promise(resolve => setTimeout(resolve, 1500));

  const trackingNumber = 'GC-' + selectedDoc.value.id.toUpperCase() + '-' + Date.now().toString().slice(-6);
  confirmationNumber.value = trackingNumber;

  requests.value.unshift({
    id: Date.now(),
    documentType: selectedDoc.value.name,
    trackingNumber,
    status: 'processing',
    requestedDate: new Date().toLocaleDateString(),
    downloadUrl: null
  });

  submitting.value = false;
  showConfirmation.value = true;
};

const downloadDocument = (req) => {
  if (req.downloadUrl && req.downloadUrl !== '#') {
    window.open(req.downloadUrl, '_blank');
  } else {
    alert('Document is being prepared. Please check back later for download.');
  }
};

const copyTracking = (req) => {
  navigator.clipboard.writeText(req.trackingNumber);
  alert('Tracking number ' + req.trackingNumber + ' copied to clipboard!');
};

const copyTrackingNumber = () => {
  navigator.clipboard.writeText(confirmationNumber.value);
  alert('Tracking number ' + confirmationNumber.value + ' copied to clipboard!');
};

const refreshTracking = () => {
  // Simulate refresh
  alert('Tracking information refreshed!');
};
</script>