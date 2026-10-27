<template>
  <section class="bg-blue-600 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-white mb-4">
          Stay Updated with Our Newsletter
        </h2>
        <p class="text-blue-100 mb-8">
          Get the latest articles, student stories, and campus news delivered straight to your inbox.
        </p>
        
        <form @submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
          <input
            v-model="email"
            type="email"
            required
            placeholder="Enter your email address"
            class="flex-1 px-4 py-3 rounded-lg text-gray-900 placeholder-gray-500 border-0 focus:ring-2 focus:ring-white focus:outline-none"
            :disabled="loading || subscribed"
          />
          <button
            type="submit"
            :disabled="loading || subscribed"
            class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <span v-if="loading">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Subscribing...
            </span>
            <span v-else-if="subscribed">✓ Subscribed</span>
            <span v-else>Subscribe</span>
          </button>
        </form>
        
        <!-- Success Message -->
        <div v-if="message" :class="[
          'mt-4 p-3 rounded-lg text-sm',
          messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        ]">
          {{ message }}
        </div>
        
        <p class="text-blue-200 text-xs mt-4">
          We respect your privacy. Unsubscribe at any time.
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const email = ref('');
const loading = ref(false);
const subscribed = ref(false);
const message = ref('');
const messageType = ref('success');

const subscribe = async () => {
  if (!email.value) return;
  
  loading.value = true;
  message.value = '';
  
  try {
    const response = await fetch('/api/v1/newsletter/subscribe', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        email: email.value
      })
    });
    
    const data = await response.json();
    
    if (data.success) {
      subscribed.value = true;
      message.value = data.message;
      messageType.value = 'success';
      email.value = '';
    } else {
      message.value = data.message || 'Subscription failed. Please try again.';
      messageType.value = 'error';
    }
    
  } catch (error) {
    console.error('Newsletter subscription error:', error);
    message.value = 'An error occurred. Please try again later.';
    messageType.value = 'error';
  } finally {
    loading.value = false;
  }
};
</script>