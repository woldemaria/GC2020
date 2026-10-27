<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600 mb-4 shadow-sm">
          <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
          </svg>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">{{ $t('certificate.title') }}</h1>
        <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
          {{ $t('certificate.description') }}
        </p>
      </div>

      <!-- University Info Card -->
      <div class="mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center">
              <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center mr-4 border border-blue-200 shrink-0">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 14 6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">{{ universityInfo?.name || 'GC University' }}</h2>
                <p class="text-sm text-gray-500">{{ universityInfo?.full_name || 'Great College University - Official Verification Portal' }}</p>
              </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-2 gap-x-6 gap-y-2 text-xs md:text-sm text-gray-600 border-t md:border-t-0 pt-3 md:pt-0">
              <div><strong>{{ $t('certificate.established') }}:</strong> {{ universityInfo?.established || '1995' }}</div>
              <div><strong>{{ $t('certificate.location') }}:</strong> {{ universityInfo?.address || 'Addis Ababa, Ethiopia' }}</div>
              <div><strong>{{ $t('certificate.accreditation') }}:</strong> {{ universityInfo?.accreditation || 'Ministry of Education' }}</div>
              <div>
                <strong>{{ $t('certificate.website') }}:</strong>
                <a :href="universityInfo?.website || '#'" target="_blank" class="text-blue-600 hover:underline ml-1">
                  {{ universityInfo?.website || 'gcuniversity.edu.et' }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Verification Section -->
      <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
          <!-- Method Selection Tabs -->
          <div class="grid grid-cols-3 border-b border-gray-200 bg-gray-50/50 p-2 gap-2">
            <button 
              @click="setMethod('qr')"
              :class="['flex items-center justify-center gap-2 py-3 px-3 rounded-xl font-semibold text-sm transition-all', verificationMethod === 'qr' ? 'bg-white text-blue-600 shadow-sm border border-blue-100 ring-2 ring-blue-500/20' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']"
            >
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11a9 9 0 11-18 0 9 9 0 0118 0zm-9 7v1"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h4v4H4zm12 0h4v4h-4zM4 16h4v4H4z"/>
              </svg>
              <span>{{ $t('certificate.scanQR') }}</span>
            </button>

            <button 
              @click="setMethod('manual')"
              :class="['flex items-center justify-center gap-2 py-3 px-3 rounded-xl font-semibold text-sm transition-all', verificationMethod === 'manual' ? 'bg-white text-blue-600 shadow-sm border border-blue-100 ring-2 ring-blue-500/20' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']"
            >
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
              </svg>
              <span>{{ $t('certificate.manualEntry') }}</span>
            </button>

            <button 
              @click="setMethod('search')"
              :class="['flex items-center justify-center gap-2 py-3 px-3 rounded-xl font-semibold text-sm transition-all', verificationMethod === 'search' ? 'bg-white text-blue-600 shadow-sm border border-blue-100 ring-2 ring-blue-500/20' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']"
            >
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <span>{{ $t('certificate.search') }}</span>
            </button>
          </div>

          <div class="p-6 md:p-8">
            <!-- QR Code Scanner Section -->
            <div v-show="verificationMethod === 'qr'">
              <!-- Success notification from scan -->
              <div v-if="scanSuccessMessage" class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center gap-2 text-sm">
                <svg class="w-5 h-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ scanSuccessMessage }}</span>
              </div>

              <!-- Scanner Error -->
              <div v-if="cameraError" class="mb-4 p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                  <p class="font-semibold">{{ $t('certificate.cameraNotice') }}</p>
                  <p class="mt-1 text-amber-700">{{ cameraError }}</p>
                </div>
              </div>

              <!-- Camera Viewfinder Container -->
              <div class="relative bg-slate-900 rounded-2xl overflow-hidden shadow-inner text-white min-h-[320px] flex flex-col items-center justify-center p-4">
                <!-- Live Scanner View -->
                <div id="qr-reader" class="w-full max-w-sm rounded-xl overflow-hidden bg-black" :class="{ 'hidden': !isScanning }"></div>

                <!-- Animated Frame Overlay when scanning -->
                <div v-if="isScanning" class="scanner-laser-line"></div>

                <!-- Idle State: Camera Not Active -->
                <div v-if="!isScanning" class="text-center py-6 px-4 max-w-md">
                  <div class="w-20 h-20 mx-auto rounded-full bg-slate-800/80 border border-slate-700 flex items-center justify-center mb-4 text-blue-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11a9 9 0 11-18 0 9 9 0 0118 0zm-9 7v1"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7V5a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 10v2a2 2 0 01-2 2h-2m-10 0H5a2 2 0 01-2-2v-2"/>
                    </svg>
                  </div>
                  <h3 class="text-lg font-bold text-white mb-1">{{ $t('certificate.readyToScan') }}</h3>
                  <p class="text-sm text-slate-300 mb-6">
                    {{ $t('certificate.qrInstructions') }}
                  </p>
                  <button
                    @click="startCameraScanner"
                    :disabled="isInitializingScanner"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg transition active:scale-95 disabled:opacity-50"
                  >
                    <svg v-if="isInitializingScanner" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ isInitializingScanner ? $t('certificate.openingCamera') : $t('certificate.startScanner') }}</span>
                  </button>
                </div>

                <!-- Active State: Camera Controls Bar -->
                <div v-if="isScanning" class="w-full mt-4 flex items-center justify-between bg-slate-800/90 backdrop-blur rounded-xl px-4 py-2 text-xs">
                  <div class="flex items-center gap-2 text-emerald-400">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="font-medium">{{ $t('certificate.cameraActive') }}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <button
                      v-if="hasMultipleCameras"
                      @click="switchCamera"
                      class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-lg flex items-center gap-1.5 font-medium transition"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                      </svg>
                      <span>{{ $t('certificate.switchCamera') }}</span>
                    </button>
                    <button
                      @click="stopQRScanner"
                      class="px-3 py-1.5 bg-rose-600 hover:bg-rose-500 text-white rounded-lg flex items-center gap-1.5 font-bold transition"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                      <span>{{ $t('certificate.stopScanner') }}</span>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Upload QR Image Alternative Option -->
              <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm">
                <span class="text-gray-500">{{ $t('certificate.haveQRFile') }}</span>
                <input
                  type="file"
                  ref="qrFileInput"
                  accept="image/*"
                  class="hidden"
                  @change="handleFileUploadScan"
                >
                <button
                  type="button"
                  @click="$refs.qrFileInput.click()"
                  :disabled="isFileScanning"
                  class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition disabled:opacity-50"
                >
                  <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <span>{{ isFileScanning ? $t('certificate.readingImage') : $t('certificate.uploadQR') }}</span>
                </button>
              </div>
            </div>

            <!-- Manual Verification Form -->
            <div v-show="verificationMethod === 'manual'" class="space-y-4">
              <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                  {{ $t('certificate.enterCode') }}
                </label>
                <div class="flex flex-col sm:flex-row gap-2">
                  <div class="relative flex-1">
                    <input
                      v-model="verificationCode"
                      type="text"
                      :placeholder="$t('certificate.codePlaceholder')"
                      class="w-full p-3.5 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono uppercase tracking-wider text-base"
                      @keyup.enter="verifyCode('manual_code')"
                    >
                    <button
                      v-if="verificationCode"
                      @click="verificationCode = ''"
                      type="button"
                      class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                    >
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                      </svg>
                    </button>
                  </div>
                  <button
                    @click="verifyCode('manual_code')"
                    :disabled="!verificationCode || isVerifying"
                    class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                  >
                    <svg v-if="isVerifying" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>{{ isVerifying ? $t('certificate.verifying') : $t('certificate.verify') }}</span>
                  </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                  {{ $t('certificate.codeHint') }}
                </p>
              </div>
            </div>

            <!-- Search Form -->
            <div v-show="verificationMethod === 'search'" class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $t('certificate.graduateName') }}
                  </label>
                  <input
                    v-model="searchForm.graduate_name"
                    type="text"
                    placeholder="e.g. Abebe Kebede"
                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $t('certificate.studentId') }}
                  </label>
                  <input
                    v-model="searchForm.student_id"
                    type="text"
                    placeholder="e.g. GC2021001"
                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase"
                  >
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $t('certificate.department') }}
                  </label>
                  <input
                    v-model="searchForm.department"
                    type="text"
                    placeholder="e.g. Computer Science"
                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $t('certificate.graduationYear') }}
                  </label>
                  <input
                    v-model="searchForm.graduation_year"
                    type="number"
                    min="1995"
                    max="2030"
                    placeholder="e.g. 2023"
                    class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                </div>
              </div>
              <button
                @click="searchCertificates"
                :disabled="isSearching"
                class="w-full py-3.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md transition disabled:opacity-50 flex items-center justify-center gap-2"
              >
                <svg v-if="isSearching" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>{{ isSearching ? $t('certificate.searching') : $t('certificate.searchBtn') }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Search Results -->
      <div v-if="searchResults.length > 0" class="max-w-3xl mx-auto mt-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span>{{ $t('certificate.searchResults') }}</span>
            <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">{{ searchResults.length }}</span>
          </h3>
          <div class="divide-y divide-gray-100">
            <div
              v-for="certificate in searchResults"
              :key="certificate.certificate_number"
              class="py-4 first:pt-0 last:pb-0 hover:bg-slate-50/80 p-3 rounded-xl transition cursor-pointer flex items-center justify-between gap-4"
              @click="selectCertificate(certificate)"
            >
              <div>
                <h4 class="font-bold text-gray-900">{{ certificate.graduate_name }}</h4>
                <p class="text-sm text-gray-600">{{ certificate.qualification }} &bull; {{ certificate.department }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $t('certificate.graduated') }}: {{ certificate.graduation_date }}</p>
              </div>
              <div class="text-right shrink-0">
                <span class="font-mono text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md border border-blue-200">
                  {{ certificate.certificate_number }}
                </span>
                <p class="text-xs text-blue-600 font-semibold mt-2 hover:underline">{{ $t('certificate.viewDetails') }} &rarr;</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Verification Result Container -->
      <div id="verification-result-container" v-if="verificationResult" class="max-w-3xl mx-auto mt-8">
        <div :class="['rounded-2xl shadow-xl overflow-hidden border', verificationResult.verified ? 'border-emerald-200 bg-white' : 'border-rose-200 bg-white']">
          
          <!-- Result Banner -->
          <div :class="['p-6 flex items-center gap-4 text-white', verificationResult.verified ? 'bg-gradient-to-r from-emerald-600 to-teal-600' : 'bg-gradient-to-r from-rose-600 to-red-600']">
            <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center shrink-0">
              <svg v-if="verificationResult.verified" class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
              <svg v-else class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </div>
            <div class="flex-1">
              <div class="flex items-center gap-2">
                <h3 class="text-2xl font-black tracking-wide">
                  {{ verificationResult.verified ? $t('certificate.verified') : $t('certificate.invalid') }}
                </h3>
                <span v-if="verificationResult.verified" class="px-2 py-0.5 bg-emerald-700/60 text-white text-xs font-bold rounded-md uppercase tracking-wider">
                  Official Record
                </span>
              </div>
              <p class="text-sm md:text-base text-white/90 mt-1">
                {{ verificationResult.message }}
              </p>
            </div>
          </div>

          <!-- Certificate Verified Body -->
          <div v-if="verificationResult.verified && verificationResult.certificate" class="p-6 md:p-8 space-y-6">
            
            <!-- Academic Validation Pills -->
            <div v-if="verificationResult.validation" class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs">
              <div class="flex items-center gap-1.5 text-emerald-700 font-medium">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>GC Records Match</span>
              </div>
              <div class="flex items-center gap-1.5 text-emerald-700 font-medium">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>GPA Authenticated</span>
              </div>
              <div class="flex items-center gap-1.5 text-emerald-700 font-medium">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Graduation Date Valid</span>
              </div>
              <div class="flex items-center gap-1.5 text-emerald-700 font-medium">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Accredited Program</span>
              </div>
            </div>

            <!-- Main Certificate Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-xl border border-gray-200">
              <div class="space-y-4">
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.graduateName') }}</label>
                  <p class="text-xl font-extrabold text-gray-900">{{ verificationResult.certificate.graduate_name }}</p>
                </div>
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.qualification') }}</label>
                  <p class="text-base font-semibold text-gray-800">{{ verificationResult.certificate.qualification }}</p>
                </div>
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.department') }}</label>
                  <p class="text-base text-gray-800">{{ verificationResult.certificate.department }}</p>
                </div>
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.studentId') }}</label>
                  <p class="font-mono text-base font-medium text-gray-700">{{ verificationResult.certificate.student_id }}</p>
                </div>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.certificateNumber') }}</label>
                  <p class="font-mono text-base font-bold text-blue-600">{{ verificationResult.certificate.certificate_number }}</p>
                </div>
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.graduationDate') }}</label>
                  <p class="text-base font-medium text-gray-800">{{ verificationResult.certificate.graduation_date }}</p>
                </div>
                <div class="flex gap-6">
                  <div v-if="verificationResult.certificate.gpa">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.gpa') }}</label>
                    <p class="text-lg font-bold text-emerald-600">{{ verificationResult.certificate.gpa }} / 4.00</p>
                  </div>
                  <div v-if="verificationResult.certificate.academic_standing || verificationResult.certificate.honors">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.honors') }}</label>
                    <p class="text-sm font-semibold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-200 inline-block">
                      {{ verificationResult.certificate.honors || verificationResult.certificate.academic_standing }}
                    </p>
                  </div>
                </div>
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{ $t('certificate.authorizedBy') }}</label>
                  <p class="text-sm text-gray-700 font-medium">{{ verificationResult.certificate.authorized_by }} ({{ verificationResult.certificate.authorized_title }})</p>
                </div>
              </div>
            </div>

            <!-- Official Verification Stamp & QR Code Display -->
            <div class="p-5 bg-gradient-to-r from-blue-50/80 via-white to-slate-50 rounded-xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-6">
              <div class="space-y-1 text-center sm:text-left">
                <div class="flex items-center justify-center sm:justify-start gap-2 text-blue-800 font-bold">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <span>Official QR Verification Code</span>
                </div>
                <p class="text-xs text-gray-500 max-w-sm">
                  This QR code encodes the verified certificate URL and can be scanned with any smartphone camera in the real world.
                </p>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-xs text-gray-500 pt-2">
                  <span>{{ $t('certificate.verificationCount') }}: <strong>{{ verificationResult.certificate.verification_count }}</strong></span>
                  <span>&bull;</span>
                  <span>Verified: {{ verificationResult.certificate.verification_timestamp }}</span>
                </div>
              </div>

              <!-- QR Code Image -->
              <div class="flex flex-col items-center shrink-0">
                <div class="p-2 bg-white rounded-xl shadow-md border border-gray-200">
                  <img
                    v-if="verificationResult.certificate.qr_code_path"
                    :src="`/storage/${verificationResult.certificate.qr_code_path}`"
                    alt="Official Verification QR Code"
                    class="w-28 h-28 object-contain"
                  >
                  <div v-else class="w-28 h-28 flex items-center justify-center bg-gray-100 text-gray-400 text-xs text-center p-2">
                    QR Available
                  </div>
                </div>
                <span class="text-[10px] font-mono font-bold text-gray-500 mt-1 uppercase">
                  {{ verificationResult.certificate.verification_code }}
                </span>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
              <button
                @click="copyVerificationLink"
                type="button"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl font-semibold text-sm transition"
              >
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <span>{{ copySuccess ? $t('certificate.linkCopied') : $t('certificate.copyLink') }}</span>
              </button>

              <button
                @click="printRecord"
                type="button"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl font-semibold text-sm transition"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>{{ $t('certificate.printCertificate') }}</span>
              </button>

              <button
                @click="resetVerification"
                type="button"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-xl font-semibold text-sm transition"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>{{ $t('certificate.verifyAnother') }}</span>
              </button>
            </div>
          </div>

          <!-- Invalid Certificate Result Body -->
          <div v-else class="p-6 md:p-8 text-center space-y-4">
            <p class="text-gray-600 max-w-md mx-auto">
              {{ $t('certificate.notFoundMessage') }}
            </p>
            <button
              @click="resetVerification"
              type="button"
              class="px-6 py-2.5 bg-gray-800 hover:bg-gray-900 text-white font-semibold rounded-xl transition"
            >
              {{ $t('certificate.tryAgain') }}
            </button>
          </div>
        </div>
      </div>

      <!-- Language Toggle Float -->
      <div class="fixed bottom-5 right-5 z-40">
        <button
          @click="toggleLanguage"
          class="bg-white/95 backdrop-blur text-gray-800 font-bold shadow-lg border border-gray-200 rounded-full px-4 py-2 hover:shadow-xl transition flex items-center gap-2 text-sm"
        >
          <span class="w-2 h-2 rounded-full bg-blue-600"></span>
          <span>{{ currentLanguage === 'en' ? 'አማርኛ' : 'English' }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { Html5Qrcode } from 'html5-qrcode'

export default {
  name: 'CertificateVerification',
  data() {
    return {
      verificationMethod: 'qr',
      verificationCode: '',
      isVerifying: false,
      isSearching: false,
      universityInfo: null,
      verificationResult: null,
      searchResults: [],
      searchForm: {
        graduate_name: '',
        student_id: '',
        department: '',
        graduation_year: ''
      },
      currentLanguage: 'en',
      
      // QR Scanner state
      html5QrCode: null,
      isScanning: false,
      isInitializingScanner: false,
      isFileScanning: false,
      cameraError: null,
      scanSuccessMessage: '',
      hasMultipleCameras: false,
      currentCameraIndex: 0,
      availableCameras: [],
      copySuccess: false,

      translations: {
        en: {
          certificate: {
            title: 'Certificate Verification',
            description: 'Verify the authenticity of GC University certificates and degrees instantly using our real-world QR code scanner, verification code, or graduate search.',
            established: 'Established',
            location: 'Location',
            accreditation: 'Accreditation',
            website: 'Website',
            verifyTitle: 'Verify Certificate',
            manualEntry: 'Manual Code',
            scanQR: 'Scan QR Code',
            search: 'Search Records',
            readyToScan: 'Scan Certificate QR Code',
            startScanner: 'Open Camera Scanner',
            openingCamera: 'Accessing Camera...',
            stopScanner: 'Stop Scanner',
            switchCamera: 'Switch Camera',
            cameraActive: 'Camera Live - Point at QR code',
            haveQRFile: 'Have a photo or screenshot of the QR code?',
            uploadQR: 'Upload QR Image',
            readingImage: 'Scanning image...',
            cameraNotice: 'Camera Note',
            cameraPermissionError: 'Could not access device camera. Please grant camera permission or use the "Upload QR Image" button below.',
            enterCode: 'Enter Verification Code or Certificate Number',
            codePlaceholder: 'e.g. IJPUAUH3LFMO or GC202367568',
            verifying: 'Verifying...',
            verify: 'Verify Certificate',
            codeHint: 'Accepts verification codes, certificate numbers, or pasted verification URLs.',
            qrInstructions: 'Point your camera at the QR code printed on the physical certificate or shown on screen.',
            graduateName: 'Graduate Name',
            studentId: 'Student ID',
            department: 'Department',
            graduationYear: 'Graduation Year',
            searching: 'Searching...',
            searchBtn: 'Search Certificates',
            searchResults: 'Search Results',
            graduated: 'Graduated',
            viewDetails: 'Verify Details',
            verified: 'Official Certificate Verified ✓',
            invalid: 'Certificate Verification Failed ✗',
            details: 'Certificate Details',
            certificateNumber: 'Certificate Number',
            qualification: 'Degree / Qualification',
            program: 'Program',
            graduationDate: 'Graduation Date',
            gpa: 'GPA',
            honors: 'Academic Honors',
            issuedAt: 'Issued Date',
            authorizedBy: 'Authorized Official',
            verificationCount: 'Total Times Verified',
            status: 'Status',
            verifyAnother: 'Verify Another',
            copyLink: 'Copy Verification Link',
            linkCopied: 'Link Copied to Clipboard!',
            printCertificate: 'Print / Save Record',
            notFoundMessage: 'No matching valid certificate was found for this code. Please check the code or scan again.',
            tryAgain: 'Try Again'
          }
        },
        am: {
          certificate: {
            title: 'የምስክር ወረቀት ማረጋገጫ',
            description: 'የጂሲ ዩኒቨርሲቲ ዲፕሎማ እና የምስክር ወረቀት ትክክለኛነት በካሜራ QR ስካነር፣ በማረጋገጫ ኮድ ወይም በተመራቂ መረጃ ያረጋግጡ።',
            established: 'የተመሰረተበት',
            location: 'አድራሻ',
            accreditation: 'እውቅና',
            website: 'ድረ ገጽ',
            verifyTitle: 'ምስክር ወረቀት ማረጋገጫ',
            manualEntry: 'በእጅ ማስገቢያ',
            scanQR: 'QR ኮድ ስካን',
            search: 'መዝገብ መፈለጊያ',
            readyToScan: 'የምስክር ወረቀት QR ኮድ ይቃኙ',
            startScanner: 'ካሜራ ስካነር ጀምር',
            openingCamera: 'ካሜራ በመክፈት ላይ...',
            stopScanner: 'ስካነር አቁም',
            switchCamera: 'ካሜራ ቀይር',
            cameraActive: 'ካሜራ ክፍት ነው - QR ኮዱን ያሳዩ',
            haveQRFile: 'የQR ኮድ ፎቶ ወይም ስክሪንሾት አለዎት?',
            uploadQR: 'የQR ምስል ይጫኑ',
            readingImage: 'ምስሉን በመቃኘት ላይ...',
            cameraNotice: 'የካሜራ ማስታወሻ',
            cameraPermissionError: 'ካሜራውን መክፈት አልተቻለም። እባክዎ የካሜራ ፈቃድ ይስጡ ወይም ከታች ያለውን "የQR ምስል ይጫኑ" ይጠቀሙ።',
            enterCode: 'የማረጋገጫ ኮድ ወይም የምስክር ወረቀት ቁጥር ያስገቡ',
            codePlaceholder: 'ምሳሌ፦ IJPUAUH3LFMO ወይም GC202367568',
            verifying: 'በማረጋገጥ ላይ...',
            verify: 'አረጋግጥ',
            codeHint: 'የማረጋገጫ ኮድ፣ የምስክር ወረቀት ቁጥር ወይም ሊንክ ያስገቡ።',
            qrInstructions: 'ካሜራዎን በምስክር ወረቀቱ ላይ ወዳለው QR ኮድ ያነጣጥሩ።',
            graduateName: 'የተመራቂ ስም',
            studentId: 'የተማሪ መለያ',
            department: 'ክፍል',
            graduationYear: 'የመመረቂያ ዓመት',
            searching: 'በመፈለግ ላይ...',
            searchBtn: 'ምስክር ወረቀቶች ፈልግ',
            searchResults: 'የፍለጋ ውጤቶች',
            graduated: 'ተመርቋል',
            viewDetails: 'ዝርዝር አረጋግጥ',
            verified: 'ትክክለኛ የምስክር ወረቀት ተረጋግጧል ✓',
            invalid: 'የምስክር ወረቀት ማረጋገጥ አልተቻለም ✗',
            details: 'የምስክር ወረቀት ዝርዝሮች',
            certificateNumber: 'የምስክር ወረቀት ቁጥር',
            qualification: 'የትምህርት ደረጃ',
            program: 'ፕሮግራም',
            graduationDate: 'የመመረቂያ ቀን',
            gpa: 'ጂፒኤ (GPA)',
            honors: 'የማዕረግ ክብር',
            issuedAt: 'የተሰጠበት ቀን',
            authorizedBy: 'የፈቀደው ኃላፊ',
            verificationCount: 'የተረጋገጠበት ጊዜ',
            status: 'ሁኔታ',
            verifyAnother: 'ሌላ አረጋግጥ',
            copyLink: 'ሊንኩን ቅዳ',
            linkCopied: 'ሊንኩ ተቀድቷል!',
            printCertificate: 'አትም / መዝግብ',
            notFoundMessage: 'ለዚህ ኮድ ምንም ትክክለኛ የምስክር ወረቀት አልተገኘም። እባክዎ እንደገና ይሞክሩ።',
            tryAgain: 'እንደገና ሞክር'
          }
        }
      }
    }
  },
  computed: {
    $t() {
      return (key) => {
        const keys = key.split('.')
        let value = this.translations[this.currentLanguage]
        for (const k of keys) {
          value = value?.[k]
        }
        return value || key
      }
    }
  },
  watch: {
    verificationMethod(newMethod) {
      if (newMethod !== 'qr') {
        this.stopQRScanner()
      }
    }
  },
  mounted() {
    this.loadUniversityInfo()

    // Support direct real-world QR scans via route param (/verify-certificate/:code) or query (?code=...)
    const routeCode = this.$route.params.code || this.$route.query.code
    if (routeCode) {
      this.verificationCode = this.extractCodeFromScan(routeCode)
      this.verificationMethod = 'manual'
      this.verifyCode('qr_code')
    }
  },
  beforeUnmount() {
    this.stopQRScanner()
  },
  methods: {
    setMethod(method) {
      this.verificationMethod = method
      if (method !== 'qr') {
        this.stopQRScanner()
      }
    },

    async loadUniversityInfo() {
      try {
        const response = await axios.get('/api/v1/university-info')
        if (response.data.success) {
          this.universityInfo = response.data.university
        }
      } catch (error) {
        console.error('Failed to load university info:', error)
      }
    },

    /**
     * Start live camera QR scanner using html5-qrcode
     */
    async startCameraScanner() {
      this.cameraError = null
      this.scanSuccessMessage = ''
      this.isInitializingScanner = true

      try {
        if (!this.html5QrCode) {
          this.html5QrCode = new Html5Qrcode('qr-reader')
        }

        // Enumerate video devices to allow front/back camera toggling
        try {
          const devices = await Html5Qrcode.getCameras()
          if (devices && devices.length > 0) {
            this.availableCameras = devices
            this.hasMultipleCameras = devices.length > 1
          }
        } catch (e) {
          console.warn('Could not list cameras:', e)
        }

        const cameraConfig = this.availableCameras.length > 0
          ? { deviceId: { exact: this.availableCameras[this.currentCameraIndex % this.availableCameras.length].id } }
          : { facingMode: 'environment' }

        const config = {
          fps: 15,
          qrbox: (viewfinderWidth, viewfinderHeight) => {
            const minEdge = Math.min(viewfinderWidth, viewfinderHeight)
            const qrEdge = Math.floor(minEdge * 0.75)
            return { width: Math.max(qrEdge, 200), height: Math.max(qrEdge, 200) }
          },
          aspectRatio: 1.0
        }

        await this.html5QrCode.start(
          cameraConfig,
          config,
          (decodedText) => {
            this.handleScanResult(decodedText)
          },
          () => {
            // Frame scanned without QR match - ignore
          }
        )

        this.isScanning = true
      } catch (err) {
        console.error('Failed to start camera:', err)
        this.cameraError = this.$t('certificate.cameraPermissionError')
        this.isScanning = false
      } finally {
        this.isInitializingScanner = false
      }
    },

    /**
     * Stop camera scanner cleanly
     */
    async stopQRScanner() {
      if (this.html5QrCode && this.isScanning) {
        try {
          await this.html5QrCode.stop()
        } catch (e) {
          console.warn('Error stopping QR scanner:', e)
        }
        this.isScanning = false
      }
    },

    /**
     * Switch between available cameras
     */
    async switchCamera() {
      if (this.availableCameras.length < 2) return
      this.currentCameraIndex = (this.currentCameraIndex + 1) % this.availableCameras.length
      await this.stopQRScanner()
      await this.startCameraScanner()
    },

    /**
     * Handle image file scan (photo/screenshot of certificate QR code)
     */
    async handleFileUploadScan(event) {
      const file = event.target.files?.[0]
      if (!file) return

      this.cameraError = null
      this.isFileScanning = true

      try {
        if (!this.html5QrCode) {
          this.html5QrCode = new Html5Qrcode('qr-reader')
        }

        const decodedText = await this.html5QrCode.scanFile(file, true)
        this.handleScanResult(decodedText)
      } catch (err) {
        console.error('Failed to scan uploaded image:', err)
        this.cameraError = 'Could not find a valid QR code in the uploaded image. Please try a clearer photo or enter the code manually.'
      } finally {
        this.isFileScanning = false
        // Reset file input so user can re-select the same file if needed
        event.target.value = ''
      }
    },

    /**
     * Parse decoded QR text and trigger verification
     */
    async handleScanResult(decodedText) {
      await this.stopQRScanner()
      
      const extracted = this.extractCodeFromScan(decodedText)
      if (!extracted) {
        this.cameraError = 'Scanned QR code content is empty or unrecognized.'
        return
      }

      this.verificationCode = extracted.toUpperCase()
      this.scanSuccessMessage = `QR code recognized: ${this.verificationCode}`

      // Trigger verification
      await this.verifyCode('qr_code')

      // Scroll to result
      this.$nextTick(() => {
        const resultEl = document.getElementById('verification-result-container')
        if (resultEl) {
          resultEl.scrollIntoView({ behavior: 'smooth' })
        }
      })
    },

    /**
     * Intelligent extractor that handles:
     * - Direct code / Certificate number: "IJPUAUH3LFMO", "GC202367568"
     * - Full URL: "http://.../verify-certificate/IJPUAUH3LFMO"
     * - Query URL: "http://...?code=IJPUAUH3LFMO"
     * - JSON payload: {"verification_code":"IJPUAUH3LFMO",...}
     */
    extractCodeFromScan(raw) {
      if (!raw) return ''
      let str = String(raw).trim()

      // Handle JSON payload
      if (str.startsWith('{') && str.endsWith('}')) {
        try {
          const parsed = JSON.parse(str)
          if (parsed.verification_code) return String(parsed.verification_code).trim()
          if (parsed.certificate_number) return String(parsed.certificate_number).trim()
          if (parsed.code) return String(parsed.code).trim()
          if (parsed.verification_url) str = parsed.verification_url
        } catch (e) {
          // not JSON, continue
        }
      }

      // Handle URL format
      try {
        const url = new URL(str, window.location.origin)
        if (url.searchParams.get('code')) {
          return url.searchParams.get('code').trim()
        }
        const segments = url.pathname.split('/').filter(Boolean)
        const last = segments[segments.length - 1]
        if (last && last !== 'verify-certificate') {
          return decodeURIComponent(last).trim()
        }
      } catch (e) {
        // Not a standard URL
      }

      // Regex fallback for url-like paths
      const match = str.match(/verify-certificate\/([a-zA-Z0-9_-]+)/)
      if (match && match[1]) {
        return match[1].trim()
      }

      return str
    },

    /**
     * Verify code with backend API
     */
    async verifyCode(method = 'manual_code') {
      if (!this.verificationCode.trim()) return

      this.isVerifying = true
      this.verificationResult = null

      const cleanCode = this.extractCodeFromScan(this.verificationCode.trim())

      try {
        const response = await axios.post('/api/v1/certificates/verify', {
          code: cleanCode.toUpperCase(),
          method: method
        })

        this.verificationResult = response.data
      } catch (error) {
        if (error.response?.data) {
          this.verificationResult = error.response.data
        } else {
          this.verificationResult = {
            success: false,
            verified: false,
            message: 'Unable to verify certificate. Please check your network connection.'
          }
        }
      } finally {
        this.isVerifying = false
      }
    },

    /**
     * Search certificates by graduate details
     */
    async searchCertificates() {
      this.isSearching = true
      this.searchResults = []

      try {
        const params = Object.fromEntries(
          Object.entries(this.searchForm).filter(([_, value]) => value && String(value).trim())
        )

        const response = await axios.get('/api/v1/certificates/search', { params })

        if (response.data.success) {
          this.searchResults = response.data.certificates || []
        }
      } catch (error) {
        console.error('Search failed:', error)
      } finally {
        this.isSearching = false
      }
    },

    selectCertificate(certificate) {
      this.verificationCode = certificate.certificate_number
      this.verificationMethod = 'manual'
      this.verifyCode('certificate_number')
      this.$nextTick(() => {
        const resultEl = document.getElementById('verification-result-container')
        if (resultEl) {
          resultEl.scrollIntoView({ behavior: 'smooth' })
        }
      })
    },

    resetVerification() {
      this.verificationResult = null
      this.verificationCode = ''
      this.searchResults = []
      this.scanSuccessMessage = ''
      this.cameraError = null
      this.searchForm = {
        graduate_name: '',
        student_id: '',
        department: '',
        graduation_year: ''
      }
    },

    copyVerificationLink() {
      const code = this.verificationResult?.certificate?.verification_code || this.verificationCode
      const url = `${window.location.origin}/verify-certificate/${code}`
      navigator.clipboard.writeText(url).then(() => {
        this.copySuccess = true
        setTimeout(() => {
          this.copySuccess = false
        }, 3000)
      })
    },

    printRecord() {
      window.print()
    },

    toggleLanguage() {
      this.currentLanguage = this.currentLanguage === 'en' ? 'am' : 'en'
    }
  }
}
</script>

<style scoped>
.font-mono {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
}

/* Custom styling for html5-qrcode video element */
:deep(#qr-reader video) {
  border-radius: 0.75rem !important;
  width: 100% !important;
  object-fit: cover !important;
}

:deep(#qr-reader__scan_region) {
  background: transparent !important;
}

:deep(#qr-reader__dashboard) {
  display: none !important;
}

/* Animated scanning laser line */
.scanner-laser-line {
  position: absolute;
  top: 25%;
  left: 20%;
  right: 20%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #38bdf8, #60a5fa, #38bdf8, transparent);
  box-shadow: 0 0 12px #38bdf8;
  animation: scanLaser 2s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
  pointer-events: none;
  z-index: 10;
}

@keyframes scanLaser {
  0% {
    top: 25%;
    opacity: 0.8;
  }
  100% {
    top: 75%;
    opacity: 0.8;
  }
}

@media print {
  body * {
    visibility: hidden;
  }
  #verification-result-container, #verification-result-container * {
    visibility: visible;
  }
  #verification-result-container {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
}
</style>
