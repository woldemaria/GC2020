<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rate this Article</h3>
    
    <!-- Rating Display -->
    <div class="flex items-center space-x-4 mb-6">
      <div class="flex items-center">
        <div class="flex space-x-1">
          <button
            v-for="star in 5"
            :key="star"
            @click="submitRating(star)"
            @mouseover="hoverRating = star"
            @mouseleave="hoverRating = 0"
            :disabled="submitting"
            class="focus:outline-none transition-colors duration-150"
          >
            <svg
              :class="[
                'w-8 h-8 transition-colors duration-150',
                (hoverRating >= star || (!hoverRating && userRating >= star))
                  ? 'text-yellow-400' 
                  : 'text-gray-300 hover:text-yellow-400'
              ]"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          </button>
        </div>
        
        <div class="ml-3 text-sm text-gray-600">
          {{ userRating ? `You rated: ${userRating}/5` : 'Click to rate' }}
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="animate-pulse">
      <div class="h-4 bg-gray-300 rounded w-1/3 mb-2"></div>
      <div class="h-2 bg-gray-300 rounded w-full mb-1"></div>
      <div class="h-2 bg-gray-300 rounded w-3/4"></div>
    </div>

    <!-- Rating Statistics -->
    <div v-else-if="stats.count > 0" class="space-y-3">
      <div class="flex items-center space-x-3">
        <div class="flex items-center">
          <span class="text-2xl font-bold text-gray-900">{{ stats.average }}</span>
          <div class="flex ml-2">
            <svg
              v-for="star in 5"
              :key="star"
              :class="[
                'w-5 h-5',
                star <= Math.round(stats.average) ? 'text-yellow-400' : 'text-gray-300'
              ]"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          </div>
        </div>
        <div class="text-sm text-gray-600">
          Based on {{ stats.count }} {{ stats.count === 1 ? 'rating' : 'ratings' }}
        </div>
      </div>

      <!-- Rating Distribution -->
      <div class="space-y-2">
        <div
          v-for="(count, rating) in stats.distribution"
          :key="rating"
          class="flex items-center space-x-3 text-sm"
        >
          <span class="w-8 text-gray-600">{{ rating }}★</span>
          <div class="flex-1 bg-gray-200 rounded-full h-2">
            <div
              :style="{ width: stats.count > 0 ? (count / stats.count * 100) + '%' : '0%' }"
              class="bg-yellow-400 h-2 rounded-full transition-all duration-300"
            ></div>
          </div>
          <span class="w-8 text-gray-500 text-right">{{ count }}</span>
        </div>
      </div>
    </div>

    <!-- No Ratings Yet -->
    <div v-else class="text-center text-gray-500 text-sm">
      Be the first to rate this article!
    </div>

    <!-- Success Message -->
    <div v-if="message" :class="[
      'mt-4 p-3 rounded-lg text-sm',
      messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
    ]">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  articleId: {
    type: Number,
    required: true
  }
});

const userRating = ref(0);
const hoverRating = ref(0);
const stats = ref({
  average: 0,
  count: 0,
  distribution: { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 }
});
const loading = ref(true);
const submitting = ref(false);
const message = ref('');
const messageType = ref('success');

const fetchRatingStats = async () => {
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/rating/stats`);
    const data = await response.json();
    
    if (data.success) {
      stats.value = data.stats;
    }
  } catch (error) {
    console.error('Error fetching rating stats:', error);
  }
};

const fetchUserRating = async () => {
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/rating/user`);
    const data = await response.json();
    
    userRating.value = data.rating || 0;
  } catch (error) {
    console.error('Error fetching user rating:', error);
  }
};

const submitRating = async (rating) => {
  if (submitting.value) return;
  
  submitting.value = true;
  message.value = '';
  
  try {
    const response = await fetch(`/api/v1/articles/${props.articleId}/rating`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({ rating })
    });
    
    const data = await response.json();
    
    if (data.success) {
      userRating.value = rating;
      stats.value = data.stats;
      message.value = data.message;
      messageType.value = 'success';
      
      // Clear message after 3 seconds
      setTimeout(() => {
        message.value = '';
      }, 3000);
    } else {
      message.value = data.message || 'Failed to submit rating';
      messageType.value = 'error';
    }
  } catch (error) {
    console.error('Error submitting rating:', error);
    message.value = 'An error occurred. Please try again.';
    messageType.value = 'error';
  } finally {
    submitting.value = false;
  }
};

onMounted(async () => {
  loading.value = true;
  await Promise.all([
    fetchRatingStats(),
    fetchUserRating()
  ]);
  loading.value = false;
});
</script>