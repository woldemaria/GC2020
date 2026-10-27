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
            @click="goCeremony"
            class="flex flex-col items-center gap-1 p-2"
            :class="currentTab === 'ceremony' ? 'text-blue-600' : 'text-gray-400'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-[10px] font-medium">Ceremony</span>
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
          <h1 class="text-lg font-black text-gray-900">Graduation Ceremony</h1>
          <p class="text-xs text-gray-500">Class of 2025 · Addis Ababa University</p>
        </div>
      </div>
    </div>

    <main class="max-w-3xl mx-auto px-4 pt-6 pb-24">
      <!-- Countdown Timer (CallSheet Inspired: Prominent, glassy) -->
      <section class="mb-6">
        <div class="p-6 rounded-3xl border border-blue-200 bg-gradient-to-br from-blue-50 to-indigo-100 shadow-lg relative overflow-hidden">
          <div class="absolute top-0 left-0 w-full h-full bg-[url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80')] opacity-10 pointer-events-none"></div>
          <div class="relative z-10">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-blue-700 mb-3">
              Time Until Graduation
            </h2>
            <div class="flex justify-center gap-3 mb-4">
              <div class="text-center">
                <div class="text-3xl font-black text-blue-900">{{ countdown.days }}</div>
                <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Days</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-black text-blue-900">{{ countdown.hours }}</div>
                <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Hours</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-black text-blue-900">{{ countdown.minutes }}</div>
                <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Min</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-black text-blue-900">{{ countdown.seconds }}</div>
                <div class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Sec</div>
              </div>
            </div>
            <p class="text-sm text-blue-800 font-medium text-center">
              {{ ceremonyDate }} at {{ ceremonyTime }}
            </p>
          </div>
        </div>
      </section>

      <!-- Ceremony Details -->
      <section class="mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Venue Info -->
          <div class="p-6 rounded-2xl border border-gray-200 bg-white">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
              Venue
            </h2>
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900">Addis Ababa University Main Campus</p>
                  <p class="text-sm text-gray-600">Graduation Square, Arat Kilo</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900">June 15, 2025</p>
                  <p class="text-sm text-gray-600">9:00 AM - 4:00 PM EAT</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 3a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1V3zM4 16a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM16 3a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1V3zM16 16a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900">Class of 2025</p>
                  <p class="text-sm text-gray-600">All Colleges & Departments</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Map Section -->
          <div class="p-6 rounded-2xl border border-gray-200 bg-white h-full">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
              Campus Map
            </h2>
            <div class="aspect-video bg-gray-100 rounded-xl overflow-hidden relative">
              <!-- Map placeholder with location marker -->
              <img
                src="https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=800&q=80"
                alt="Campus Map"
                class="w-full h-full object-cover opacity-60"
              />
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="relative">
                  <div class="w-10 h-10 bg-red-500 rounded-full shadow-lg flex items-center justify-center animate-ping"></div>
                  <div class="w-5 h-5 bg-red-600 rounded-full absolute top-2 left-2 flex items-center justify-center text-white text-xs font-bold">
                    YOU
                  </div>
                </div>
                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-medium text-gray-700 shadow-sm">
                  Graduation Square
                </div>
              </div>
            </div>
            <p class="mt-3 text-xs text-gray-500 text-center">
              Ceremony held at Graduation Square, Main Campus
            </p>
          </div>
        </div>
      </section>

      <!-- Schedule -->
      <section class="mb-6">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Ceremony Schedule
          </h2>
          <div class="space-y-3">
            <div
              v-for="(item, idx) in schedule"
              :key="idx"
              class="flex items-center gap-4 p-3 rounded-xl border border-gray-100 bg-gray-50"
            >
              <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                {{ idx + 1 }}
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <span class="text-xs font-medium text-gray-900">{{ item.time }}</span>
                  <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">{{ item.type }}</span>
                </div>
                <p class="text-sm text-gray-700 truncate">{{ item.title }}</p>
              </div>
              <div class="text-xs text-gray-500 font-medium">{{ item.location }}</div>
            </div>
          </div>
        </div>
      </section>

      <!-- Important Notes -->
      <section class="mb-6">
        <div class="p-6 rounded-2xl border border-amber-200 bg-amber-50">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-amber-700 mb-3">
            Important Information
          </h2>
          <ul class="space-y-2 text-sm text-amber-800">
            <li class="flex items-start gap-2">
              <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Guests must arrive 30 minutes before the ceremony start time.
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Academic regalia (gown and cap) is required for all graduates.
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Photography is permitted from designated areas only.
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Contact the Registrar's Office for accessibility accommodations.
            </li>
          </ul>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const currentTab = ref('ceremony');

const goHome = () => router.push('/');
const goCeremony = () => router.push('/ceremony-info');
const goGownCap = () => router.push('/gown-cap');
const goBack = () => router.back();

// Ceremony details
const ceremonyDate = ref('June 15, 2025');
const ceremonyTime = ref('9:00 AM EAT');

// Countdown timer
const ceremonyTarget = new Date('June 15, 2025 09:00:00 EAT').getTime();
const countdown = ref({ days: 0, hours: 0, minutes: 0, seconds: 0 });

const updateCountdown = () => {
  const now = new Date().getTime();
  const distance = ceremonyTarget - now;

  if (distance < 0) {
    countdown.value = { days: 0, hours: 0, minutes: 0, seconds: 0 };
    return;
  }

  countdown.value = {
    days: Math.floor(distance / (1000 * 60 * 60 * 24)),
    hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
    minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
    seconds: Math.floor((distance % (1000 * 60)) / 1000)
  };
};

const schedule = ref([
  { time: '8:00 AM', type: 'Doors Open', title: 'Graduate and guest check-in', location: 'Main Gate' },
  { time: '9:00 AM', type: 'Processional', title: 'Faculty and graduate procession', location: 'Graduation Square' },
  { time: '9:30 AM', type: 'Opening', title: 'National anthem and welcome address', location: 'Main Stage' },
  { time: '10:00 AM', type: 'Keynote', title: 'Guest speaker address', location: 'Main Stage' },
  { time: '11:00 AM', type: 'Conferral', title: 'Degree conferral by college', location: 'Main Stage' },
  { time: '1:00 PM', type: 'Recessional', title: 'Graduate recessional', location: 'Graduation Square' },
  { time: '2:00 PM', type: 'Reception', title: 'Photo reception and celebration', location: 'Alumni Garden' }
]);

onMounted(() => {
  updateCountdown();
  const interval = setInterval(updateCountdown, 1000);
  onUnmounted(() => clearInterval(interval));
});
</script>