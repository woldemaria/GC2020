<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <!-- Comments Header -->
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-xl font-bold text-gray-900">
        Comments ({{ commentCount }})
      </h3>
    </div>

    <!-- Comment Form -->
    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
      <h4 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h4>
      <form @submit.prevent="submitComment">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="author_name" class="block text-sm font-medium text-gray-700 mb-1">
              Name *
            </label>
            <input
              id="author_name"
              v-model="form.author_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Your name"
            />
          </div>
          <div>
            <label for="author_email" class="block text-sm font-medium text-gray-700 mb-1">
              Email *
            </label>
            <input
              id="author_email"
              v-model="form.author_email"
              type="email"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="your@email.com"
            />
          </div>
        </div>
        
        <div class="mb-4">
          <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
            Comment *
          </label>
          <textarea
            id="content"
            v-model="form.content"
            required
            rows="4"
            maxlength="1000"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Write your comment here..."
          ></textarea>
          <p class="text-xs text-gray-500 mt-1">
            {{ form.content.length }}/1000 characters
          </p>
        </div>
        
        <button
          type="submit"
          :disabled="submitting"
          class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        >
          <span v-if="submitting">
            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Submitting...
          </span>
          <span v-else>Post Comment</span>
        </button>
      </form>
      
      <!-- Success/Error Messages -->
      <div v-if="message" :class="[
        'mt-4 p-3 rounded-lg text-sm',
        messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
      ]">
        {{ message }}
      </div>
    </div>

    <!-- Comments List -->
    <div v-if="loading" class="space-y-4">
      <!-- Loading skeletons -->
      <div v-for="i in 3" :key="i" class="animate-pulse">
        <div class="flex space-x-3">
          <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
          <div class="flex-1 space-y-2">
            <div class="h-4 bg-gray-300 rounded w-1/4"></div>
            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            <div class="h-4 bg-gray-300 rounded w-1/2"></div>
          </div>
        </div>
      </div>
    </div>

    <div v-else-if="comments.length === 0" class="text-center py-8 text-gray-500">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
      </svg>
      <p class="mt-4 text-lg">No comments yet</p>
      <p class="text-sm">Be the first to share your thoughts!</p>
    </div>

    <div v-else class="space-y-6">
      <div 
        v-for="comment in comments" 
        :key="comment.id"
        class="flex space-x-3 p-4 rounded-lg hover:bg-gray-50 transition-colors"
      >
        <!-- Avatar -->
        <div class="flex-shrink-0">
          <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
            <span class="text-white font-medium text-sm">
              {{ comment.author_name.charAt(0).toUpperCase() }}
            </span>
          </div>
        </div>
        
        <!-- Comment Content -->
        <div class="flex-1">
          <div class="flex items-center space-x-2 mb-1">
            <h4 class="font-medium text-gray-900">{{ comment.author_name }}</h4>
            <span class="text-sm text-gray-500">•</span>
            <time class="text-sm text-gray-500" :datetime="comment.created_at">
              {{ formatDate(comment.created_at) }}
            </time>
          </div>
          <p class="text-gray-700 leading-relaxed">{{ comment.content }}</p>
        </div>
      </div>
      
      <!-- Load More Button -->
      <div v-if="hasMoreComments" class="text-center">
        <button
          @click="loadMore"
          :disabled="loadingMore"
          class="px-4 py-2 text-blue-600 hover:text-blue-800 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ loadingMore ? 'Loading...' : 'Load More Comments' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
  articleId: {
    type: Number,
    required: true
  }
});

const comments = ref([]);
const commentCount = ref(0);
const loading = ref(true);
const submitting = ref(false);
const loadingMore = ref(false);
const message = ref('');
const messageType = ref('success');
const currentPage = ref(1);
const totalPages = ref(1);

const form = ref({
  author_name: '',
  author_email: '',
  content: ''
});

const hasMoreComments = computed(() => currentPage.value < totalPages.value);

const loadComments = async (page = 1) => {
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/comments?page=${page}`);
    const data = await response.json();
    
    if (page === 1) {
      comments.value = data.data;
    } else {
      comments.value.push(...data.data);
    }
    
    currentPage.value = data.current_page;
    totalPages.value = data.last_page;
    
  } catch (error) {
    console.error('Error loading comments:', error);
  }
};

const loadCommentCount = async () => {
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/comments/count`);
    const data = await response.json();
    commentCount.value = data.count;
  } catch (error) {
    console.error('Error loading comment count:', error);
  }
};

const submitComment = async () => {
  submitting.value = true;
  message.value = '';
  
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/comments`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(form.value)
    });
    
    const data = await response.json();
    
    if (data.success) {
      message.value = data.message;
      messageType.value = 'success';
      form.value = { author_name: '', author_email: '', content: '' };
    } else {
      message.value = data.message || 'Failed to submit comment';
      messageType.value = 'error';
    }
    
  } catch (error) {
    console.error('Error submitting comment:', error);
    message.value = 'An error occurred. Please try again.';
    messageType.value = 'error';
  } finally {
    submitting.value = false;
  }
};

const loadMore = async () => {
  loadingMore.value = true;
  await loadComments(currentPage.value + 1);
  loadingMore.value = false;
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const now = new Date();
  const diff = now - date;
  const hours = Math.floor(diff / (1000 * 60 * 60));
  const days = Math.floor(diff / (1000 * 60 * 60 * 24));
  
  if (days > 7) {
    return date.toLocaleDateString();
  } else if (days > 0) {
    return `${days} day${days > 1 ? 's' : ''} ago`;
  } else if (hours > 0) {
    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
  } else {
    return 'Just now';
  }
};

onMounted(async () => {
  loading.value = true;
  await Promise.all([
    loadComments(),
    loadCommentCount()
  ]);
  loading.value = false;
});
</script>