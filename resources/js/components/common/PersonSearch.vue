<template>
  <div class="min-h-screen bg-[#f3f4f6]">
    <!-- CallSheet Inspired: Glassy Bottom Search Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-50">
      <div class="backdrop-blur-md bg-white/70 border-t border-gray-200 px-4 pb-4 pt-3 shadow-lg">
        <!-- Person Type Scope Toggle -->
        <div class="flex justify-center mb-3 gap-2">
          <button
            v-for="type in personTypes"
            :key="type.key"
            @click="personType = type.key"
            :class="
              personType === type.key
                ? 'bg-blue-600 text-white px-4 py-1.5 rounded-full text-sm font-medium shadow-sm'
                : 'bg-gray-100 text-gray-600 px-4 py-1.5 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors'
            "
          >
            {{ type.label }}
          </button>
        </div>

        <!-- Search Input -->
        <div class="relative mx-auto max-w-md">
          <svg
            class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />
          </svg>
          <input
            v-model="filters.query"
            @input="debouncedSearch"
            @keydown.enter="performSearch"
            placeholder="Search {{ personTypeLabel }}..."
            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 text-base outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
          />
          <button
            v-if="filters.query"
            @click="filters.query = ''; performSearch()"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>

      <!-- Search History Panel -->
      <div
        v-if="showHistory && personHistory.length > 0"
        class="backdrop-blur-md bg-white/80 border-t border-gray-200 px-4 pb-2 pt-1 shadow-lg"
      >
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
            Recent Searches
          </span>
          <button
            @click="clearHistory"
            class="text-xs text-blue-600 hover:text-blue-800"
          >
            Clear
          </button>
        </div>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="(item, idx) in personHistory"
            :key="idx"
            @click="loadHistoryItem(item)"
            class="px-3 py-1.5 rounded-full border border-gray-200 bg-gray-50 text-sm text-gray-700 font-medium hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 transition-colors whitespace-nowrap"
          >
            {{ item.query }}
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 pt-6 pb-32">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">
              Find People
            </h1>
            <p class="text-sm text-gray-500">
              Search students, faculty, and alumni across the university
            </p>
          </div>
          <button
            @click="clearFilters"
            class="text-sm text-gray-500 hover:text-gray-900 font-medium"
          >
            Clear All
          </button>
        </div>
      </div>

      <!-- Search Form (Glassy Card) -->
      <div class="backdrop-blur-lg bg-white/80 border border-gray-200 rounded-3xl shadow-xl p-6 mb-8">
        <form @submit.prevent="performSearch" class="space-y-5">
          <div class="relative">
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
              Name or Keyword
            </label>
            <input
              v-model="filters.query"
              type="text"
              placeholder="e.g. Abebe, Professor, Dean..."
              class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-gray-900 text-lg outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Department
              </label>
              <select
                v-model="filters.department"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">All Departments</option>
                <option value="computer-science">Computer Science & IT</option>
                <option value="engineering">Engineering</option>
                <option value="medicine">Medicine & Health Sciences</option>
                <option value="business">Business & Management</option>
                <option value="law">Law & Governance</option>
                <option value="social-sciences">Social Sciences & Humanities</option>
                <option value="natural-sciences">Natural Sciences</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Role
              </label>
              <select
                v-model="filters.role"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">All Roles</option>
                <option value="student">Student</option>
                <option value="faculty">Faculty</option>
                <option value="alumni">Alumni</option>
                <option value="staff">Staff</option>
              </select>
            </div>
          </div>

          <button
            type="submit"
            :disabled="searching"
            class="w-full bg-blue-600 text-white py-4 rounded-2xl text-lg font-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-lg hover:shadow-xl transform active:scale-[0.98]"
          >
            <span v-if="searching" class="flex items-center justify-center gap-2">
              <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Searching...
            </span>
            <span v-else>Find People</span>
          </button>
        </form>
      </div>

      <!-- Results -->
      <div v-if="hasSearched && people.length === 0" class="text-center py-12">
        <div class="text-gray-300 text-6xl mb-4">
          <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M43 17v1m0 0v-4m0 0V9m0 0l-8 5-8-5m0 0l8-5m8 5v12m-8-8v12m-4-4h8" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          No people found
        </h3>
        <p class="text-gray-500 text-sm mb-6">
          Try adjusting your search terms or filters.
        </p>
        <button
          @click="clearFilters"
          class="bg-blue-600 text-white px-6 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors"
        >
          Clear Filters
        </button>
      </div>

      <div v-if="hasSearched && people.length > 0">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">
            {{ people.length }} people found
          </h3>
          <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
            {{ personTypeLabel }}
          </span>
        </div>

        <!-- CallSheet Inspired: Person Cards (like cast/crew cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <div
            v-for="person in people"
            :key="person.id"
            class="backdrop-blur-lg bg-white/70 border border-gray-200 rounded-2xl p-4 hover:border-blue-200/50 hover:shadow-lg transition-all cursor-pointer group"
            @click="viewPerson(person)"
          >
            <div class="relative mb-4">
              <img
                :src="person.avatar || '/images/default-avatar.jpg'"
                :alt="person.name"
                class="w-full h-32 object-cover rounded-xl group-hover:scale-105 transition-transform"
              />
              <span
                class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-0.5 rounded-full text-xs font-bold"
              >
                {{ person.role }}
              </span>
            </div>
            <div>
              <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                {{ person.name }}
              </h4>
              <p class="text-xs text-gray-500 mt-1">
                {{ person.department }}
              </p>
              <div class="mt-3 flex items-center gap-1 text-[10px]">
                <span
                  v-for="star in 5"
                  :key="star"
                  class="text-yellow-300"
                >
                  ★
                </span>
                <span class="ml-1 text-gray-400">{{ person.rating }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Person Profile Modal (CallSheet Inspired: Person Details) -->
    <div
      v-if="selectedPerson"
      class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
      <div
        class="fixed inset-0 bg-black/60 backdrop-blur-sm"
        @click="closePersonModal"
      ></div>
      <div
        class="backdrop-blur-2xl bg-white/90 border border-gray-200 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative"
      >
        <button
          @click="closePersonModal"
          class="absolute top-4 right-4 p-2 text-gray-400 hover:text-gray-600 transition-colors"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <div class="p-6">
          <!-- Person Header -->
          <div class="relative mb-6">
            <img
              :src="selectedPerson.avatar || '/images/default-avatar.jpg'"
              :alt="selectedPerson.name"
              class="w-full h-48 object-cover rounded-2xl"
            />
            <div class="absolute bottom-4 left-4 right-4 p-4">
              <div class="flex items-center gap-2">
                <span
                  class="bg-blue-600 text-white px-2.5 py-0.5 rounded-full text-xs font-bold"
                >
                  {{ selectedPerson.role }}
                </span>
                <span
                  v-if="selectedPerson.pinned"
                  class="bg-amber-500 text-white px-2.5 py-0.5 rounded-full text-xs font-bold"
                >
                  Pinned
                </span>
              </div>
              <h2 class="text-2xl font-black text-white mt-2">
                {{ selectedPerson.name }}
              </h2>
              <p class="text-blue-100 text-sm mt-1">
                {{ selectedPerson.department }}
              </p>
            </div>
          </div>

          <!-- Person Details -->
          <div class="space-y-4">
            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
              <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                About
              </h4>
              <p class="text-gray-700 text-sm">
                {{ selectedPerson.bio }}
              </p>
            </div>

            <div class="p-4 rounded-xl border border-gray-200 bg-white">
              <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Contact
              </h4>
              <div class="space-y-2">
                <div class="flex items-center gap-3 text-sm text-gray-700">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <span>{{ selectedPerson.email }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-700">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  <span>{{ selectedPerson.phone }}</span>
                </div>
              </div>
            </div>

            <!-- CallSheet Inspired: "Known For" Departments -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
              <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Known For
              </h4>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="dept in selectedPerson.knownFor"
                  :key="dept"
                  class="px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-xs text-gray-700 font-medium"
                >
                  {{ dept }}
                </span>
              </div>
            </div>

            <!-- CallSheet Inspired: Credits / Achievements -->
            <div class="p-4 rounded-xl border border-gray-200 bg-white">
              <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Achievements
              </h4>
              <div class="space-y-2">
                <div
                  v-for="(achievement, idx) in selectedPerson.achievements"
                  :key="idx"
                  class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100"
                >
                  <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                    {{ idx + 1 }}
                  </div>
                  <p class="text-sm text-gray-700">{{ achievement }}</p>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-3 pt-4">
              <button
                @click="togglePin(selectedPerson)"
                :class="
                  selectedPerson.pinned
                    ? 'bg-amber-500 text-white'
                    : 'bg-white border border-gray-200 text-gray-700'
                "
                class="py-2.5 rounded-xl font-medium hover:opacity-90 transition-colors flex items-center justify-center gap-2"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00.95-.69h4.914c.969 0 1.371-1.24.588-1.81l1.519-4.674z" />
                </svg>
                {{ selectedPerson.pinned ? 'Unpin' : 'Pin' }}
              </button>
              <button
                @click="sharePerson(selectedPerson)"
                class="bg-blue-600 text-white py-2.5 rounded-xl font-medium hover:bg-blue-700 transition-colors"
              >
                Share
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

const emit = defineEmits(['person-select']);

// Person Types (CallSheet Inspired: like searching films/shows/people)
const personTypes = ref([
  { key: 'all', label: 'All' },
  { key: 'student', label: 'Students' },
  { key: 'faculty', label: 'Faculty' },
  { key: 'alumni', label: 'Alumni' },
]);

const personType = ref('all');

const personTypeLabel = computed(() => {
  const type = personTypes.value.find(t => t.key === personType.value);
  return type ? type.label : 'All';
});

// Person Search History
const personHistory = ref([]);
const MAX_HISTORY = 10;

const loadPersonHistory = () => {
  try {
    const stored = localStorage.getItem('callsheet_person_history');
    if (stored) {
      personHistory.value = JSON.parse(stored);
    }
  } catch (e) {
    console.warn('Could not load person history', e);
  }
};

const savePersonHistory = () => {
  try {
    localStorage.setItem('callsheet_person_history', JSON.stringify(personHistory.value));
  } catch (e) {
    console.warn('Could not save person history', e);
  }
};

const addToHistory = (query) => {
  if (!query || !query.trim()) return;
  personHistory.value = personHistory.value.filter(h => h.query !== query.trim());
  personHistory.value.unshift({ query: query.trim(), timestamp: Date.now() });
  if (personHistory.value.length > MAX_HISTORY) {
    personHistory.value = personHistory.value.slice(0, MAX_HISTORY);
  }
  savePersonHistory();
};

const clearHistory = () => {
  personHistory.value = [];
  savePersonHistory();
};

const loadHistoryItem = (item) => {
  filters.value.query = item.query;
  showHistory.value = false;
  performSearch();
};

const showHistory = ref(false);

// Filters
const filters = ref({
  query: '',
  department: '',
  role: ''
});

const searching = ref(false);
const hasSearched = ref(false);
const people = ref([]);
const selectedPerson = ref(null);

// Mock people data (CallSheet Inspired: cast/crew profiles)
const mockPeople = ref([
  {
    id: 1,
    name: 'Dr. Sarah Martinez',
    role: 'Professor',
    department: 'Computer Science & IT',
    email: 'sarah.martinez@aau.edu.et',
    phone: '+251 11 123 4567',
    bio: 'Professor of Computer Science specializing in AI and machine learning. PhD from Stanford University.',
    avatar: '/images/avatars/sarah-martinez.jpg',
    knownFor: ['Machine Learning', 'Data Science', 'AI Ethics'],
    achievements: ['Best Paper Award 2024', 'NSF Grant Recipient', 'IEEE Senior Member'],
    rating: 4.9,
    pinned: true
  },
  {
    id: 2,
    name: 'Abebe Kebede',
    role: 'Student',
    department: 'Computer Science & IT',
    email: 'abebe.kebede@student.aau.edu.et',
    phone: '+251 91 234 5678',
    bio: 'Senior Computer Science student. CGPA 3.82. Interested in software engineering and mobile development.',
    avatar: '/images/avatars/david-chen.jpg',
    knownFor: ['Mobile Apps', 'Web Development', 'Open Source'],
    achievements: ['Dean\'s List 2024', 'Hackathon Winner', 'Google Summer of Code'],
    rating: 4.7,
    pinned: false
  },
  {
    id: 3,
    name: 'Dr. Marcus Johnson',
    role: 'Department Head',
    department: 'Engineering',
    email: 'marcus.johnson@aau.edu.et',
    phone: '+251 11 234 5678',
    bio: 'Head of Engineering Department. 15+ years of experience in civil engineering and infrastructure.',
    avatar: '/images/avatars/marcus-johnson.jpg',
    knownFor: ['Structural Engineering', 'Infrastructure', 'Project Management'],
    achievements: ['Engineering Excellence Award', 'Published Author', 'PE License'],
    rating: 4.8,
    pinned: false
  },
  {
    id: 4,
    name: 'Priya Patel',
    role: 'Student',
    department: 'Medicine & Health Sciences',
    email: 'priya.patel@student.aau.edu.et',
    phone: '+251 92 345 6789',
    bio: 'Medical School student. Focus on public health and community medicine.',
    avatar: '/images/avatars/priya-sharma.jpg',
    knownFor: ['Public Health', 'Community Medicine', 'Research'],
    achievements: ['Research Grant', 'Volunteer Award', 'Clinical Excellence'],
    rating: 4.6,
    pinned: false
  },
  {
    id: 5,
    name: 'Aisha Patel',
    role: 'Alumni',
    department: 'Business & Management',
    email: 'aisha.patel@alumni.aau.edu.et',
    phone: '+251 93 456 7890',
    bio: 'MBA Graduate 2023. Founder of TechStartup Ethiopia. Working in fintech sector.',
    avatar: '/images/avatars/aisha-patel.jpg',
    knownFor: ['Entrepreneurship', 'Fintech', 'Business Strategy'],
    achievements: ['Young Entrepreneur Award', 'Startup Founder', 'MBA Honors'],
    rating: 4.5,
    pinned: true
  },
  {
    id: 6,
    name: 'Dr. Emily Rodriguez',
    role: 'Professor',
    department: 'Natural Sciences',
    email: 'emily.rodriguez@aau.edu.et',
    phone: '+251 11 345 6789',
    bio: 'Professor of Biology. Research focus on biodiversity and conservation.',
    avatar: '/images/avatars/emily-rodriguez.jpg',
    knownFor: ['Biodiversity', 'Conservation', 'Field Research'],
    achievements: ['Conservation Award', 'Field Research Grant', 'Published Research'],
    rating: 4.7,
    pinned: false
  }
]);

const debounceTimer = ref(null);
const debouncedSearch = () => {
  if (debounceTimer.value) clearTimeout(debounceTimer.value);
  debounceTimer.value = setTimeout(() => {
    performSearch();
  }, 400);
};

const performSearch = () => {
  if (filters.value.query && filters.value.query.trim()) {
    addToHistory(filters.value.query);
  }
  searching.value = true;
  hasSearched.value = true;

  setTimeout(() => {
    searching.value = false;
    const query = filters.value.query.toLowerCase();
    const dept = filters.value.department;
    const role = filters.value.role;

    people.value = mockPeople.value.filter(p => {
      const matchesQuery = !query ||
        p.name.toLowerCase().includes(query) ||
        p.department.toLowerCase().includes(query) ||
        p.bio.toLowerCase().includes(query);
      const matchesDept = !dept || p.department.toLowerCase().includes(dept);
      const matchesRole = !role || p.role.toLowerCase() === role;
      return matchesQuery && matchesDept && matchesRole;
    });

    // Apply person type filter
    if (personType.value !== 'all') {
      people.value = people.value.filter(p =>
        p.role.toLowerCase() === personType.value ||
        (personType.value === 'student' && p.role.toLowerCase() === 'student') ||
        (personType.value === 'faculty' && (p.role.toLowerCase() === 'professor' || p.role.toLowerCase() === 'department head')) ||
        (personType.value === 'alumni' && p.role.toLowerCase() === 'alumni')
      );
    }
  }, 500);
};

const viewPerson = (person) => {
  selectedPerson.value = { ...person };
  emit('person-select', person);
};

const closePersonModal = () => {
  selectedPerson.value = null;
};

const togglePin = (person) => {
  person.pinned = !person.pinned;
  emit('pin-toggle', person);
};

const sharePerson = (person) => {
  if (navigator.share) {
    navigator.share({
      title: person.name,
      text: `${person.name} - ${person.department}`,
      url: window.location.origin + '/student-profiles/' + person.id
    });
  } else {
    navigator.clipboard.writeText(window.location.origin + '/student-profiles/' + person.id);
    alert('Person profile link copied to clipboard!');
  }
};

const clearFilters = () => {
  filters.value = { query: '', department: '', role: '' };
  hasSearched.value = false;
  people.value = [];
};

watch(personType, () => {
  if (filters.value.query || hasSearched.value) {
    performSearch();
  }
});

watch(filters, () => {
  if (hasSearched.value) {
    performSearch();
  }
}, { deep: true });

onMounted(() => {
  loadPersonHistory();
  performSearch();
});
</script>