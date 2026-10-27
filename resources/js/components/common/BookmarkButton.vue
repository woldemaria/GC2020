<template>
  <button
    @click="toggleBookmark"
    :disabled="loading"
    :class="[
      'flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-colors duration-200',
      isBookmarked 
        ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' 
        : 'bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200',
      loading ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
    ]"
    :title="isBookmarked ? 'Remove bookmark' : 'Add bookmark'"
  >
    <svg 
      :class="['w-5 h-5', isBookmarked ? 'text-yellow-600' : 'text-gray-500']" 
      :fill="isBookmarked ? 'currentColor' : 'none'" 
      stroke="currentColor" 
      viewBox="0 0 24 24"
    >
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
    </svg>
    <span v-if="showText">
      {{ isBookmarked ? 'Bookmarked' : 'Bookmark' }}
    </span>
    
    <!-- Loading spinner -->
    <svg 
      v-if="loading" 
      class="w-4 h-4 animate-spin text-gray-500" 
      xmlns="http://www.w3.org/2000/svg" 
      fill="none" 
      viewBox="0 0 24 24"
    >
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
  </button>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  articleId: {
    type: Number,
    required: true
  },
  showText: {
    type: Boolean,
    default: true
  }
});

const isBookmarked = ref(false);
const loading = ref(false);

const checkBookmarkStatus = async () => {
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/bookmark/status`);
    const data = await response.json();
    isBookmarked.value = data.bookmarked;
  } catch (error) {
    console.error('Error checking bookmark status:', error);
  }
};

const toggleBookmark = async () => {
  loading.value = true;
  
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/bookmark`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    
    const data = await response.json();
    
    if (data.success) {
      isBookmarked.value = data.bookmarked;
      // Show toast notification (you can implement this)
      showNotification(data.message);
    }
    
  } catch (error) {
    console.error('Error toggling bookmark:', error);
    showNotification('Failed to update bookmark. Please try again.', 'error');
  } finally {
    loading.value = false;
  }
};

const showNotification = (message, type = 'success') => {
  // Simple notification - you can replace with a proper toast library
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

onMounted(() => {
  checkBookmarkStatus();
});
</script>