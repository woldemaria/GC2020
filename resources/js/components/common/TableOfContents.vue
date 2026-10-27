<template>
  <div 
    v-if="headings.length > 0"
    class="sticky top-24 bg-white rounded-lg shadow-sm border p-6 max-h-96 overflow-y-auto"
  >
    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
      <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
      </svg>
      Table of Contents
    </h3>
    
    <nav class="space-y-2">
      <a
        v-for="(heading, index) in headings"
        :key="index"
        :href="'#' + heading.id"
        @click.prevent="scrollToHeading(heading.id)"
        :class="[
          'block text-sm transition-colors duration-200 hover:text-blue-600',
          activeHeading === heading.id ? 'text-blue-600 font-medium' : 'text-gray-600',
          heading.level === 1 ? 'font-medium' : '',
          heading.level === 2 ? 'pl-4' : '',
          heading.level === 3 ? 'pl-8' : '',
          heading.level >= 4 ? 'pl-12' : ''
        ]"
      >
        {{ heading.text }}
      </a>
    </nav>

    <!-- Reading Time Estimate -->
    <div v-if="readingTime" class="mt-6 pt-4 border-t border-gray-200">
      <div class="flex items-center text-sm text-gray-500">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ readingTime }} min read
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';

const props = defineProps({
  contentSelector: {
    type: String,
    default: '.prose'
  },
  readingTime: {
    type: Number,
    default: null
  }
});

const headings = ref([]);
const activeHeading = ref('');

const generateTableOfContents = async () => {
  await nextTick();
  
  const contentElement = document.querySelector(props.contentSelector);
  if (!contentElement) return;

  const headingElements = contentElement.querySelectorAll('h1, h2, h3, h4, h5, h6');
  
  headings.value = Array.from(headingElements).map((heading, index) => {
    // Generate ID if it doesn't exist
    if (!heading.id) {
      heading.id = `heading-${index}-${heading.textContent.toLowerCase().replace(/[^a-z0-9]+/g, '-')}`;
    }
    
    return {
      id: heading.id,
      text: heading.textContent.trim(),
      level: parseInt(heading.tagName[1]),
      element: heading
    };
  });
};

const scrollToHeading = (headingId) => {
  const element = document.getElementById(headingId);
  if (element) {
    const offset = 100; // Account for sticky header
    const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
    window.scrollTo({
      top: elementPosition - offset,
      behavior: 'smooth'
    });
  }
};

const updateActiveHeading = () => {
  const scrollY = window.scrollY;
  let current = '';

  for (const heading of headings.value) {
    const element = heading.element;
    if (element && element.offsetTop <= scrollY + 150) {
      current = heading.id;
    }
  }

  activeHeading.value = current;
};

onMounted(() => {
  generateTableOfContents();
  window.addEventListener('scroll', updateActiveHeading, { passive: true });
  updateActiveHeading();
});

onUnmounted(() => {
  window.removeEventListener('scroll', updateActiveHeading);
});

// Expose method for manual updates
defineExpose({
  generateTableOfContents
});
</script>