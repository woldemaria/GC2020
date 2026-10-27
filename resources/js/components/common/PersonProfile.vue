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
            @click="goSearch"
            class="flex flex-col items-center gap-1 p-2"
            :class="currentTab === 'search' ? 'text-blue-600' : 'text-gray-400'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="text-[10px] font-medium">Search</span>
          </button>
          <button
            @click="goProfile"
            class="flex flex-col items-center gap-1 p-2"
            :class="currentTab === 'profile' ? 'text-blue-600' : 'text-gray-400'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] font-medium">Profile</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Person Profile Header (CallSheet Inspired: Large hero with pinned badge) -->
    <div class="relative h-64 overflow-hidden">
      <img
        :src="person.avatar || '/images/default-avatar.jpg'"
        :alt="person.name"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
      <div class="absolute bottom-0 left-0 right-0 p-6">
        <div class="flex items-center gap-2 mb-2">
          <span
            class="bg-blue-600 text-white px-2.5 py-0.5 rounded-full text-xs font-bold"
          >
            {{ person.role }}
          </span>
          <span
            v-if="person.pinned"
            class="bg-amber-500 text-white px-2.5 py-0.5 rounded-full text-xs font-bold"
          >
            Pinned
          </span>
        </div>
        <h1 class="text-3xl font-black text-white tracking-tight">
          {{ person.name }}
        </h1>
        <p class="text-blue-100 text-sm mt-1">
          {{ person.department }} · Addis Ababa University
        </p>
      </div>
    </div>

    <!-- CallSheet Inspired: Quick Access Links (like JustWatch, Wikipedia links) -->
    <div class="backdrop-blur-lg bg-white/80 border-b border-gray-200 px-4 pb-3 pt-3 sticky top-0 z-40">
      <div class="flex gap-2 overflow-x-auto">
        <button
          class="flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-700 text-sm font-medium hover:bg-blue-50 hover:border-blue-200 transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
          Contact
        </button>
        <button
          class="flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-700 text-sm font-medium hover:bg-blue-50 hover:border-blue-200 transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          Website
        </button>
        <button
          @click="sharePerson"
          class="flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-gray-700 text-sm font-medium hover:bg-blue-50 hover:border-blue-200 transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
          </svg>
          Share
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 pt-6 pb-24">
      <!-- About Section -->
      <section class="mb-8">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            About
          </h2>
          <p class="text-gray-700 text-sm leading-relaxed">
            {{ person.bio }}
          </p>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="mb-8">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Contact Information
          </h2>
          <div class="space-y-3">
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Email</p>
                <p class="text-sm text-gray-500">{{ person.email }}</p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">Phone</p>
                <p class="text-sm text-gray-500">{{ person.phone }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- CallSheet Inspired: Known For (like filmography highlights) -->
      <section class="mb-8">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Known For
          </h2>
          <div class="flex flex-wrap gap-3">
            <span
              v-for="dept in person.knownFor"
              :key="dept"
              class="px-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-sm text-gray-700 font-medium hover:bg-blue-50 hover:border-blue-200 transition-colors"
            >
              {{ dept }}
            </span>
          </div>
        </div>
      </section>

      <!-- Achievements Section -->
      <section class="mb-8">
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Achievements
          </h2>
          <div class="space-y-3">
            <div
              v-for="(achievement, idx) in person.achievements"
              :key="idx"
              class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100"
            >
              <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                {{ idx + 1 }}
              </div>
              <p class="text-sm text-gray-700">{{ achievement }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- CallSheet Inspired: Credits / Filmography Equivalent -->
      <section>
        <div class="p-6 rounded-2xl border border-gray-200 bg-white">
          <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">
            Academic Credits
          </h2>
          <div class="space-y-3">
            <div
              v-for="credit in person.credits"
              :key="credit.id"
              class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-colors"
            >
              <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                {{ credit.icon }}
              </div>
              <div class="flex-1">
                <h4 class="text-sm font-semibold text-gray-900">{{ credit.title }}</h4>
                <p class="text-xs text-gray-500">{{ credit.subtitle }}</p>
              </div>
              <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                {{ credit.year }}
              </span>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

// Person data (CallSheet Inspired: detailed person profile)
const person = ref({
  id: 1,
  name: 'Dr. Sarah Martinez',
  role: 'Professor',
  department: 'Computer Science & IT',
  email: 'sarah.martinez@aau.edu.et',
  phone: '+251 11 123 4567',
  bio: 'Professor of Computer Science specializing in AI and machine learning. PhD from Stanford University. 10+ years of teaching and research experience.',
  avatar: '/images/avatars/sarah-martinez.jpg',
  knownFor: ['Machine Learning', 'Data Science', 'AI Ethics', 'Computer Vision'],
  achievements: [
    'Best Paper Award 2024 - NeurIPS',
    'NSF Grant Recipient - AI Research',
    'IEEE Senior Member',
    'University Teaching Excellence Award'
  ],
  credits: [
    { id: 1, title: 'Introduction to AI', subtitle: 'CS 301 · Undergraduate', icon: '🎓', year: '2024' },
    { id: 2, title: 'Machine Learning Lab', subtitle: 'CS 450 · Graduate', icon: '🔬', year: '2024' },
    { id: 3, title: 'Neural Networks', subtitle: 'CS 320 · Undergraduate', icon: '🧠', year: '2023' },
    { id: 4, title: 'AI Ethics Seminar', subtitle: 'CS 400 · Graduate', icon: '⚖️', year: '2023' }
  ],
  rating: 4.9,
  pinned: true
});

const currentTab = ref('profile');

const goHome = () => {
  router.push('/');
};

const goSearch = () => {
  router.push('/');
};

const goProfile = () => {
  // Already on profile
};

const sharePerson = () => {
  if (navigator.share) {
    navigator.share({
      title: person.value.name,
      text: `${person.value.name} - ${person.value.department}`,
      url: window.location.origin + '/person/' + person.value.id
    });
  } else {
    navigator.clipboard.writeText(window.location.origin + '/person/' + person.value.id);
    alert('Profile link copied to clipboard!');
  }
};

// Load person from route params if available
onMounted(() => {
  const personId = route.params.id;
  if (personId) {
    // In a real app, fetch from API: /api/v1/student-profiles/${personId}
    console.log('Loading person:', personId);
  }
});
</script>