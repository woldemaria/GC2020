<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center mb-6">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
          <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-900">Trending Now</h3>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="space-y-4">
      <div v-for="i in 5" :key="i" class="animate-pulse flex items-start space-x-3">
        <div class="w-16 h-12 bg-gray-300 rounded"></div>
        <div class="flex-1 space-y-2">
          <div class="h-4 bg-gray-300 rounded w-3/4"></div>
          <div class="h-3 bg-gray-300 rounded w-1/2"></div>
        </div>
      </div>
    </div>

    <!-- Trending Articles List -->
    <div v-else-if="articles.length" class="space-y-4">
      <article 
        v-for="(article, index) in articles" 
        :key="article.id"
        class="group"
      >
        <router-link 
          :to="`/articles/${article.slug}`"
          class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors"
        >
          <!-- Trending Number -->
          <div class="flex-shrink-0">
            <span 
              :class="[
                'inline-flex items-center justify-center w-6 h-6 text-sm font-bold rounded',
                index === 0 ? 'bg-yellow-100 text-yellow-800' : 
                index === 1 ? 'bg-gray-100 text-gray-700' : 
                index === 2 ? 'bg-orange-100 text-orange-700' : 
                'bg-blue-100 text-blue-700'
              ]"
            >
              {{ index + 1 }}
            </span>
          </div>

          <!-- Article Image -->
          <div class="flex-shrink-0">
            <img 
              :src="article.featured_image || '/images/placeholder-article.jpg'" 
              :alt="article.title"
              class="w-16 h-12 object-cover rounded"
            />
          </div>

          <!-- Article Info -->
          <div class="flex-1 min-w-0">
            <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
              {{ article.title }}
            </h4>
            <div class="flex items-center text-xs text-gray-500 space-x-2">
              <span>{{ article.views || 0 }} views</span>
              <span>•</span>
              <span>{{ formatDate(article.created_at) }}</span>
            </div>
          </div>

          <!-- Trending Icon -->
          <div class="flex-shrink-0">
            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 6.3-6.29L22 12V6z"/>
            </svg>
          </div>
        </router-link>
      </article>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-8">
      <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-.5" />
      </svg>
      <p class="mt-2 text-sm text-gray-500">No trending articles found</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const articles = ref([]);
const loading = ref(true);

const fetchTrendingArticles = async () => {
  try {
    loading.value = true;
    // Fetch articles sorted by views in descending order
    const response = await fetch('/api/v1/articles?sort=views&order=desc&per_page=5');
    const data = await response.json();
    
    articles.value = data.data || [];
  } catch (error) {
    console.error('Error fetching trending articles:', error);
    // Fallback to mock data
    articles.value = [
      {
        id: 1,
        title: 'How to Prepare for Your First Job After Graduation',
        slug: 'how-to-prepare-first-job-graduation',
        featured_image: '/images/articles/job-preparation.jpg',
        views: 1250,
        created_at: new Date().toISOString()
      },
      {
        id: 2,
        title: 'The Future of Open Source Education',
        slug: 'future-open-source-education',
        featured_image: '/images/articles/open-source.jpg',
        views: 987,
        created_at: new Date().toISOString()
      },
      {
        id: 3,
        title: 'Building a Strong Portfolio: A Student\'s Guide',
        slug: 'building-strong-portfolio-guide',
        featured_image: '/images/articles/portfolio-guide.jpg',
        views: 876,
        created_at: new Date().toISOString()
      }
    ];
  } finally {
    loading.value = false;
  }
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const now = new Date();
  const diffTime = Math.abs(now - date);
  const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
  
  if (diffDays === 0) {
    return 'Today';
  } else if (diffDays === 1) {
    return 'Yesterday';
  } else if (diffDays < 7) {
    return `${diffDays} days ago`;
  } else {
    return date.toLocaleDateString();
  }
};

onMounted(() => {
  fetchTrendingArticles();
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>