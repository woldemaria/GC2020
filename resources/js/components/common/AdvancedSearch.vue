<template>
  <div class="min-h-screen bg-[#f3f4f6]">
    <!-- CallSheet Inspired: Glassy Bottom Search Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-50">
      <div class="backdrop-blur-md bg-white/70 border-t border-gray-200 px-4 pb-4 pt-3 shadow-lg">
        <!-- Search Scope Toggle -->
        <div class="flex justify-center mb-3 gap-2">
          <button
            v-for="scope in searchScopes"
            :key="scope.key"
            @click="searchScope = scope.key"
            :class="
              searchScope === scope.key
                ? 'bg-blue-600 text-white px-4 py-1.5 rounded-full text-sm font-medium shadow-sm'
                : 'bg-gray-100 text-gray-600 px-4 py-1.5 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors'
            "
          >
            {{ scope.label }}
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
            placeholder="Search {{ searchScopeLabel }}..."
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

        <!-- Quick Action: Swap Scope -->
        <button
          @click="swapScope"
          class="absolute right-4 top-4 p-2 text-gray-400 hover:text-gray-600 transition-colors"
          title="Swap search scope"
        >
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 16V4m0 0L3 8m4-4l4 4m4-8V12m0 0l4 4m-4-4l-4-4"
            />
          </svg>
        </button>
      </div>

      <!-- CallSheet Inspired: Search History Panel -->
      <div
        v-if="showHistory && searchHistory.length > 0"
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
            v-for="(item, idx) in searchHistory"
            :key="idx"
            @click="loadHistoryItem(item)"
            class="px-3 py-1.5 rounded-full border border-gray-200 bg-gray-50 text-sm text-gray-700 font-medium hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700 transition-colors whitespace-nowrap"
          >
            {{ item.query }}
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content: Glassy Search Card -->
    <main class="max-w-3xl mx-auto px-4 pt-6 pb-32">
      <div
        class="backdrop-blur-lg bg-white/80 border border-gray-200 rounded-3xl shadow-xl p-6"
      >
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
          <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">
              Advanced Search
            </h1>
            <p class="text-sm text-gray-500">
              Find articles, people, and programs across the university
            </p>
          </div>
          <button
            @click="clearFilters"
            class="text-sm text-gray-500 hover:text-gray-900 font-medium transition-colors"
          >
            Clear All
          </button>
        </div>

        <!-- Search Form -->
        <form @submit.prevent="performSearch" class="space-y-5">
          <!-- Query Field (prominent, CallSheet style) -->
          <div class="relative">
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
              What are you looking for?
            </label>
            <input
              v-model="filters.query"
              type="text"
              placeholder="e.g. Computer Science, admission, graduation..."
              class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-gray-900 text-lg outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            />
          </div>

          <!-- Search Scope / Category -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Category
              </label>
              <select
                v-model="filters.category"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">All Categories</option>
                <option
                  v-for="category in categories"
                  :key="category.id"
                  :value="category.slug"
                >
                  {{ category.name }}
                </option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Author / Person
              </label>
              <select
                v-model="filters.author"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">All People</option>
                <option
                  v-for="author in authors"
                  :key="author.id"
                  :value="author.id"
                >
                  {{ author.name }}
                </option>
              </select>
            </div>
          </div>

          <!-- Date Range -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                From
              </label>
              <input
                v-model="filters.fromDate"
                type="date"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                To
              </label>
              <input
                v-model="filters.toDate"
                type="date"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              />
            </div>
          </div>

          <!-- Subject / Department -->
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
              Subject / Department
            </label>
            <select
              v-model="filters.subject"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="">All Subjects</option>
              <option value="computer-science">Computer Science & IT</option>
              <option value="engineering">Engineering</option>
              <option value="medicine">Medicine & Health Sciences</option>
              <option value="business">Business & Management</option>
              <option value="law">Law & Governance</option>
              <option value="social-sciences">Social Sciences & Humanities</option>
              <option value="natural-sciences">Natural Sciences</option>
            </select>
          </div>

          <!-- Difficulty / Level -->
          <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
              Level
            </label>
            <select
              v-model="filters.difficulty"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="">Any Level</option>
              <option value="undergraduate">Undergraduate</option>
              <option value="graduate">Graduate</option>
              <option value="postgraduate">Postgraduate</option>
            </select>
          </div>

          <!-- Sort -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">
                Sort By
              </label>
              <select
                v-model="filters.sortBy"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="popular">Most Popular</option>
                <option value="rating">Highest Rated</option>
              </select>
            </div>
            <div>
              <label class="flex items-center">
                <input
                  v-model="filters.featuredOnly"
                  type="checkbox"
                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                />
                <span class="ml-2 text-xs font-medium text-gray-700">
                  Featured only
                </span>
              </label>
            </div>
          </div>

          <!-- Primary Action Button -->
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
            <span v-else>Search {{ searchScopeLabel }}</span>
          </button>
        </form>

        <!-- Active Filters -->
        <div
          v-if="activeFiltersCount > 0"
          class="mt-6 pt-4 border-t border-gray-200"
        >
          <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
              Active Filters
            </span>
            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
              {{ activeFiltersCount }}
            </span>
          </div>
          <div class="flex flex-wrap gap-2">
            <span
              v-for="(filter, key) in activeFilters"
              :key="key"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100"
            >
              {{ filter }}
              <button
                @click="removeFilter(key)"
                class="text-blue-500 hover:text-blue-700"
              >
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </span>
          </div>
        </div>
      </div>

      <!-- Search Results Placeholder -->
      <div v-if="hasSearched && results.length === 0" class="mt-8">
        <div
          class="backdrop-blur-lg bg-white/80 border border-gray-200 rounded-3xl shadow-xl p-12 text-center"
        >
          <div class="text-gray-300 text-4xl mb-4">
            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            No results found
          </h3>
          <p class="text-gray-500 text-sm mb-6">
            Try adjusting your filters or search terms.
          </p>
          <button
            @click="clearFilters"
            class="bg-blue-600 text-white px-6 py-2 rounded-xl text-sm font-medium hover:bg-blue-700 transition-colors"
          >
            Clear Filters
          </button>
        </div>
      </div>

      <!-- Search Results -->
      <div v-if="hasSearched && results.length > 0" class="mt-8">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">
            {{ results.length }} results
          </h3>
          <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
            {{ searchScopeLabel }}
          </span>
        </div>
        <div class="space-y-3">
          <div
            v-for="result in results"
            :key="result.id"
            class="backdrop-blur-lg bg-white/70 border border-gray-200 rounded-2xl p-4 hover:border-blue-200/50 transition-all cursor-pointer group"
          >
            <div class="flex items-start gap-3">
              <div
                class="flex-shrink-0 h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 font-bold"
              >
                {{ result.type === 'person' ? 'P' : 'A' }}
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                  {{ result.title }}
                </h4>
                <p class="text-xs text-gray-500 mt-1 truncate">
                  {{ result.subtitle }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';

const emit = defineEmits(['search']);

// CallSheet Inspired: Search Scopes (like searching films/shows/people)
const searchScopes = ref([
  { key: 'articles', label: 'Articles' },
  { key: 'people', label: 'People' },
  { key: 'all', label: 'All' },
]);

const searchScope = ref('all');

const searchScopeLabel = computed(() => {
  const scope = searchScopes.value.find(s => s.key === searchScope.value);
  return scope ? scope.label : 'All';
});

// CallSheet Inspired: Search History
const searchHistory = ref([]);
const MAX_HISTORY = 10;

const loadSearchHistory = () => {
  try {
    const stored = localStorage.getItem('callsheet_search_history');
    if (stored) {
      searchHistory.value = JSON.parse(stored);
    }
  } catch (e) {
    console.warn('Could not load search history', e);
  }
};

const saveSearchHistory = () => {
  try {
    localStorage.setItem('callsheet_search_history', JSON.stringify(searchHistory.value));
  } catch (e) {
    console.warn('Could not save search history', e);
  }
};

const addToHistory = (query) => {
  if (!query || !query.trim()) return;
  searchHistory.value = searchHistory.value.filter(h => h.query !== query.trim());
  searchHistory.value.unshift({ query: query.trim(), timestamp: Date.now() });
  if (searchHistory.value.length > MAX_HISTORY) {
    searchHistory.value = searchHistory.value.slice(0, MAX_HISTORY);
  }
  saveSearchHistory();
};

const clearHistory = () => {
  searchHistory.value = [];
  saveSearchHistory();
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
  category: '',
  author: '',
  fromDate: '',
  toDate: '',
  readingTime: '',
  featuredOnly: false,
  sortBy: 'newest',
  subject: '',
  difficulty: '',
  topicTag: '',
  knowledgeType: '',
  referenceType: ''
});

const categories = ref([]);
const authors = ref([]);
const searching = ref(false);
const hasSearched = ref(false);
const results = ref([]);

const topicTags = ref([
  'algorithms',
  'data-structures',
  'web-development',
  'database',
  'programming',
  'computer-science',
  'mathematics',
  'history',
  'literature',
  'biology'
]);

const learningPaths = ref([
  { title: 'Introduction to Programming', description: 'Learn the basics of coding', progress: 75 },
  { title: 'Data Structures & Algorithms', description: 'Master arrays, trees, graphs', progress: 45 },
  { title: 'Web Development Fundamentals', description: 'HTML, CSS, JavaScript essentials', progress: 30 },
  { title: 'Database Systems', description: 'SQL and database design', progress: 15 }
]);

const practiceTopics = ref([
  'Arrays', 'Strings', 'Linked Lists', 'Trees', 'Graphs',
  'Sorting', 'Searching', 'Dynamic Programming'
]);

const selectedPracticeTopics = ref([]);

// Debounce for bottom search bar
const debounceTimer = ref(null);
const debouncedSearch = () => {
  if (debounceTimer.value) clearTimeout(debounceTimer.value);
  debounceTimer.value = setTimeout(() => {
    performSearch();
  }, 400);
};

const activeFiltersCount = computed(() => {
  let count = 0;
  if (filters.value.query) count++;
  if (filters.value.category) count++;
  if (filters.value.author) count++;
  if (filters.value.fromDate) count++;
  if (filters.value.toDate) count++;
  if (filters.value.readingTime) count++;
  if (filters.value.featuredOnly) count++;
  if (filters.value.sortBy !== 'newest') count++;
  if (filters.value.subject) count++;
  if (filters.value.difficulty) count++;
  if (filters.value.topicTag) count++;
  if (filters.value.referenceType) count++;
  if (selectedPracticeTopics.value.length) count++;
  return count;
});

const activeFilters = computed(() => {
  const active = {};
  if (filters.value.query) active.query = `"${filters.value.query}"`;
  if (filters.value.category) {
    const category = categories.value.find(c => c.slug === filters.value.category);
    active.category = category?.name || filters.value.category;
  }
  if (filters.value.author) {
    const author = authors.value.find(a => a.id == filters.value.author);
    active.author = author?.name || filters.value.author;
  }
  if (filters.value.fromDate) active.fromDate = `From: ${filters.value.fromDate}`;
  if (filters.value.toDate) active.toDate = `To: ${filters.value.toDate}`;
  if (filters.value.readingTime) active.readingTime = getReadingTimeLabel(filters.value.readingTime);
  if (filters.value.featuredOnly) active.featuredOnly = 'Featured Only';
  if (filters.value.sortBy !== 'newest') active.sortBy = getSortLabel(filters.value.sortBy);
  if (filters.value.subject) active.subject = filters.value.subject;
  if (filters.value.difficulty) active.difficulty = filters.value.difficulty;
  if (filters.value.topicTag) active.topicTag = filters.value.topicTag;
  if (filters.value.knowledgeType) active.knowledgeType = filters.value.knowledgeType;
  if (filters.value.referenceType) active.referenceType = filters.value.referenceType;
  if (selectedPracticeTopics.value.length) active.practiceTopics = selectedPracticeTopics.value.join(', ');
  return active;
});

const getReadingTimeLabel = (value) => {
  const labels = { quick: 'Quick Read', medium: 'Medium', long: 'Long Read' };
  return labels[value] || value;
};

const getSortLabel = (value) => {
  const labels = {
    newest: 'Newest First', oldest: 'Oldest First',
    popular: 'Most Popular', rating: 'Highest Rated', title: 'Title A-Z'
  };
  return labels[value] || value;
};

const fetchCategories = async () => {
  try {
    const response = await fetch('/api/v1/categories');
    categories.value = await response.json();
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
};

const fetchAuthors = async () => {
  try {
    const response = await fetch('/api/v1/authors');
    const data = await response.json();
    authors.value = Array.isArray(data) ? data : (data.data || []);
  } catch (error) {
    console.error('Error fetching authors:', error);
  }
};

const performSearch = () => {
  if (filters.value.query && filters.value.query.trim()) {
    addToHistory(filters.value.query);
  }
  searching.value = true;
  hasSearched.value = true;
  emit('search', { ...filters.value, practiceTopics: [...selectedPracticeTopics.value], scope: searchScope.value });
  setTimeout(() => {
    searching.value = false;
    // Mock results for demo
    results.value = generateMockResults();
  }, 600);
};

const generateMockResults = () => {
  const mock = [];
  if (filters.value.query) {
    mock.push({
      id: 1,
      title: `Result for "${filters.value.query}"`,
      subtitle: 'Article · Computer Science Department',
      type: 'article'
    });
    mock.push({
      id: 2,
      title: 'Related Person Profile',
      subtitle: 'Faculty · Department Head',
      type: 'person'
    });
  }
  return mock;
};

const socialLogin = (provider) => {
  const authUrls = {
    facebook: 'https://www.facebook.com/login',
    google: 'https://accounts.google.com/signin',
    twitter: 'https://twitter.com/login',
    github: 'https://github.com/login',
    linkedin: 'https://www.linkedin.com/login',
    email: '/login'
  };
  const url = authUrls[provider];
  if (url.startsWith('http')) {
    window.open(url, '_blank');
  } else {
    window.location.href = url;
  }
};

const clearFilters = () => {
  filters.value = {
    query: '', category: '', author: '', fromDate: '', toDate: '',
    readingTime: '', featuredOnly: false, sortBy: 'newest', subject: '',
    difficulty: '', topicTag: '', knowledgeType: '', referenceType: ''
  };
  selectedPracticeTopics.value = [];
  hasSearched.value = false;
  results.value = [];
  performSearch();
};

const removeFilter = (filterKey) => {
  switch (filterKey) {
    case 'query': filters.value.query = ''; break;
    case 'category': filters.value.category = ''; break;
    case 'author': filters.value.author = ''; break;
    case 'fromDate': filters.value.fromDate = ''; break;
    case 'toDate': filters.value.toDate = ''; break;
    case 'readingTime': filters.value.readingTime = ''; break;
    case 'featuredOnly': filters.value.featuredOnly = false; break;
    case 'sortBy': filters.value.sortBy = 'newest'; break;
    case 'subject': filters.value.subject = ''; break;
    case 'difficulty': filters.value.difficulty = ''; break;
    case 'topicTag': filters.value.topicTag = ''; break;
    case 'knowledgeType': filters.value.knowledgeType = ''; break;
    case 'referenceType': filters.value.referenceType = ''; break;
    case 'practiceTopics': selectedPracticeTopics.value = []; break;
    default:
      if (selectedPracticeTopics.value.includes(filterKey)) {
        selectedPracticeTopics.value = selectedPracticeTopics.value.filter(t => t !== filterKey);
      }
      break;
  }
  performSearch();
};

const togglePracticeTopic = (topic) => {
  if (selectedPracticeTopics.value.includes(topic)) {
    selectedPracticeTopics.value = selectedPracticeTopics.value.filter(t => t !== topic);
  } else {
    selectedPracticeTopics.value.push(topic);
  }
  performSearch();
};

const swapScope = () => {
  const currentIndex = searchScopes.value.findIndex(s => s.key === searchScope.value);
  const nextIndex = (currentIndex + 1) % searchScopes.value.length;
  searchScope.value = searchScopes.value[nextIndex].key;
};

watch(searchScope, () => {
  if (filters.value.query) {
    performSearch();
  }
});

onMounted(() => {
  fetchCategories();
  fetchAuthors();
  loadSearchHistory();
});
</script>