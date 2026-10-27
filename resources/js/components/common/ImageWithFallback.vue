<template>
  <img
    :src="currentSrc"
    :alt="alt"
    :class="className"
    @error="handleError"
    @load="handleLoad"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  src: {
    type: String,
    required: true
  },
  fallback: {
    type: String,
    default: '/images/placeholder-article.jpg'
  },
  alt: {
    type: String,
    default: ''
  },
  className: {
    type: String,
    default: ''
  }
});

const currentSrc = ref(props.src);
const hasError = ref(false);

const handleError = () => {
  if (!hasError.value) {
    hasError.value = true;
    currentSrc.value = props.fallback;
  }
};

const handleLoad = () => {
  // Image loaded successfully
};

onMounted(() => {
  currentSrc.value = props.src;
});
</script>