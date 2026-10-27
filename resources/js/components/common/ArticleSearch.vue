<template>
  <div class="relative max-w-md">
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
      </div>
      <input
        v-model="searchQuery"
        type="search"
        placeholder="Search articles..."
        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
        @input="handleSearch"
        @keyup.enter="performSearch"
      />
    </div>
    
    <!-- Search Suggestions/Results -->
    <div v-if="showSuggestions && suggestions.length > 0" class="absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg border border-gray-200">
      <ul class="py-1">
        <li 
          v-for="suggestion in suggestions" 
          :key="suggestion.id"
          @click="selectSuggestion(suggestion)"
          class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
        >
          <div class="font-medium">{{ suggestion.title }}</div>
          <div class="text-gray-500 text-xs">{{ suggestion.category?.name }}</div>
        </li>
      </ul>
      <div class="border-t border-gray-200 px-4 py-2">
        <button 
          @click="performSearch"
          class="text-sm text-blue-600 hover:text-blue-800 font-medium"
        >
          See all results for "{{ searchQuery }}"
        </button>
      </div>
    </div>
    
    <!-- Loading indicator -->
    <div v-if="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
      <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const searchQuery = ref('');
const suggestions = ref([]);
const showSuggestions = ref(false);
const loading = ref(false);
let searchTimeout = null;

const props = defineProps({
  placeholder: {
    type: String,
    default: 'Search articles...'
  }
});

const emit = defineEmits(['search']);

const handleSearch = () => {
  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }
  
  if (searchQuery.value.length < 2) {
    showSuggestions.value = false;
    return;
  }
  
  searchTimeout = setTimeout(() => {
    fetchSuggestions();
  }, 300);
};

const fetchSuggestions = async () => {
  if (!searchQuery.value || searchQuery.value.length < 2) return;
  
  loading.value = true;
  
  try {
    const response = await fetch(`/api/v1/articles?search=${encodeURIComponent(searchQuery.value)}&per_page=5`);
    const data = await response.json();
    
    suggestions.value = data.data || [];
    showSuggestions.value = suggestions.value.length > 0;
    
  } catch (error) {
    console.error('Search suggestions error:', error);
    suggestions.value = [];
    showSuggestions.value = false;
  } finally {
    loading.value = false;
  }
};

const selectSuggestion = (article) => {
  showSuggestions.value = false;
  router.push(`/articles/${article.slug}`);
};

const performSearch = () => {
  showSuggestions.value = false;
  if (searchQuery.value.trim()) {
    emit('search', searchQuery.value.trim());
    // Navigate to articles page with search query
    router.push(`/articles?search=${encodeURIComponent(searchQuery.value.trim())}`);
  }
};

// Close suggestions when clicking outside
document.addEventListener('click', (e) => {
  if (!e.target.closest('.relative')) {
    showSuggestions.value = false;
  }
});
</script>