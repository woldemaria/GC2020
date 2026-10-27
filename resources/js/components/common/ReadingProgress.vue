<template>
  <div
    v-if="showProgress"
    class="fixed top-0 left-0 right-0 z-50 h-1 bg-gray-200"
  >
    <div
      class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-300 ease-out"
      :style="{ width: progress + '%' }"
    ></div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const progress = ref(0);
const showProgress = ref(false);

const calculateProgress = () => {
  const scrollTop = window.pageYOffset;
  const docHeight = document.documentElement.scrollHeight - window.innerHeight;
  
  if (docHeight <= 0) {
    progress.value = 0;
    showProgress.value = false;
    return;
  }
  
  const scrollPercent = (scrollTop / docHeight) * 100;
  progress.value = Math.min(100, Math.max(0, scrollPercent));
  
  // Only show progress bar when user has scrolled past the header
  showProgress.value = scrollTop > 100;
};

onMounted(() => {
  window.addEventListener('scroll', calculateProgress, { passive: true });
  calculateProgress(); // Initial calculation
});

onUnmounted(() => {
  window.removeEventListener('scroll', calculateProgress);
});
</script>