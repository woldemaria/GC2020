<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">My Bookmarks</h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Articles you've saved for later reading
          </p>
        </div>
      </div>
    </section>

    <!-- Bookmarks Content -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Loading State -->
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="i in 6" :key="i" class="bg-white rounded-lg shadow-sm overflow-hidden animate-pulse">
            <div class="w-full h-48 bg-gray-300"></div>
            <div class="p-6">
              <div class="h-4 bg-gray-300 rounded mb-2"></div>
              <div class="h-4 bg-gray-300 rounded w-3/4 mb-4"></div>
              <div class="flex justify-between">
                <div class="h-3 bg-gray-300 rounded w-1/4"></div>
                <div class="h-3 bg-gray-300 rounded w-1/4"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else-if="bookmarks.length === 0" class="text-center py-16">
          <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
          </svg>
          <h3 class="text-xl font-medium text-gray-900 mb-2">No bookmarks yet</h3>
          <p class="text-gray-500 mb-6">Start bookmarking articles to save them for later reading.</p>
          <router-link
            to="/articles"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          >
            Browse Articles
          </router-link>
        </div>

        <!-- Bookmarks Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <article 
            v-for="bookmark in bookmarks" 
            :key="bookmark.id"
            class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
          >
            <div class="relative">
              <router-link :to="`/articles/${bookmark.article.slug}`">
                <img 
                  :src="bookmark.article.featured_image || '/images/placeholder-article.jpg'" 
                  :alt="bookmark.article.title"
                  class="w-full h-48 object-cover"
                />
              </router-link>
              
              <!-- Remove bookmark button -->
              <button
                @click="removeBookmark(bookmark.id)"
                class="absolute top-2 right-2 p-2 bg-white/90 hover:bg-white rounded-full shadow-sm transition-colors"
                title="Remove bookmark"
              >
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
            
            <div class="p-6">
              <!-- Category -->
              <div v-if="bookmark.article.category" class="mb-2">
                <span 
                  class="inline-block px-2 py-1 text-xs font-medium rounded"
                  :style="{ backgroundColor: bookmark.article.category.color + '20', color: bookmark.article.category.color }"
                >
                  {{ bookmark.article.category.name }}
                </span>
              </div>
              
              <!-- Title & Excerpt -->
              <router-link :to="`/articles/${bookmark.article.slug}`">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors line-clamp-2">
                  {{ bookmark.article.title }}
                </h3>
              </router-link>
              <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ bookmark.article.excerpt }}</p>
              
              <!-- Meta Info -->
              <div class="flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center">
                  <span>{{ bookmark.article.author?.name }}</span>
                </div>
                <div class="flex items-center space-x-2">
                  <span>{{ formatDate(bookmark.created_at) }}</span>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!-- Load More Button -->
        <div v-if="hasMore" class="text-center mt-12">
          <button
            @click="loadMore"
            :disabled="loadingMore"
            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            {{ loadingMore ? 'Loading...' : 'Load More' }}
          </button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const bookmarks = ref([]);
const loading = ref(true);
const loadingMore = ref(false);
const currentPage = ref(1);
const totalPages = ref(1);
const hasMore = ref(false);

const fetchBookmarks = async (page = 1) => {
  try {
    const response = await fetch(`/api/v1/bookmarks?page=${page}`);
    const data = await response.json();
    
    if (page === 1) {
      bookmarks.value = data.data;
    } else {
      bookmarks.value.push(...data.data);
    }
    
    currentPage.value = data.current_page;
    totalPages.value = data.last_page;
    hasMore.value = currentPage.value < totalPages.value;
    
  } catch (error) {
    console.error('Error fetching bookmarks:', error);
  }
};

const removeBookmark = async (bookmarkId) => {
  try {
    const response = await fetch(`/api/v1/bookmarks/${bookmarkId}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    
    const data = await response.json();
    
    if (data.success) {
      // Remove from local state
      bookmarks.value = bookmarks.value.filter(bookmark => bookmark.id !== bookmarkId);
      showNotification('Bookmark removed successfully!');
    }
    
  } catch (error) {
    console.error('Error removing bookmark:', error);
    showNotification('Failed to remove bookmark. Please try again.', 'error');
  }
};

const loadMore = async () => {
  loadingMore.value = true;
  await fetchBookmarks(currentPage.value + 1);
  loadingMore.value = false;
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const now = new Date();
  const diff = now - date;
  const hours = Math.floor(diff / (1000 * 60 * 60));
  const days = Math.floor(diff / (1000 * 60 * 60 * 24));
  
  if (days > 7) {
    return `Saved ${date.toLocaleDateString()}`;
  } else if (days > 0) {
    return `Saved ${days} day${days > 1 ? 's' : ''} ago`;
  } else if (hours > 0) {
    return `Saved ${hours} hour${hours > 1 ? 's' : ''} ago`;
  } else {
    return 'Saved recently';
  }
};

const showNotification = (message, type = 'success') => {
  const notification = document.createElement('div');
  notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-opacity duration-300`;
  notification.textContent = message;
  
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.style.opacity = '0';
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
};

onMounted(async () => {
  loading.value = true;
  await fetchBookmarks();
  loading.value = false;
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