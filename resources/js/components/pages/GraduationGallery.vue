<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 text-white py-16">
      <div class="absolute inset-0 bg-black/20"></div>
      <div class="relative container mx-auto px-4">
        <div class="text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Graduation Gallery</h1>
          <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Celebrate the achievements of our graduates. Browse through memorable moments 
            from graduation ceremonies and academic celebrations.
          </p>
        </div>
      </div>
    </section>

    <!-- Filter Tabs -->
    <section class="py-8 bg-white border-b">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-center gap-4">
          <button
            v-for="filter in filters"
            :key="filter.key"
            @click="currentFilter = filter.key"
            :class="[
              'px-6 py-3 rounded-lg font-medium transition-all',
              currentFilter === filter.key
                ? 'bg-blue-600 text-white shadow-lg'
                : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
            ]"
          >
            {{ filter.label }}
          </button>
        </div>
      </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-12">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div
            v-for="photo in filteredPhotos"
            :key="photo.id"
            @click="openModal(photo)"
            class="relative bg-white rounded-lg shadow-md overflow-hidden cursor-pointer group hover:shadow-xl transition-all duration-300"
          >
            <div class="aspect-square overflow-hidden">
              <img
                :src="photo.image"
                :alt="photo.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
              >
            </div>
            
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-4 left-4 right-4">
                <h3 class="text-white font-semibold text-lg mb-1">{{ photo.title }}</h3>
                <p class="text-blue-200 text-sm">{{ photo.ceremony }}</p>
                <div class="flex items-center justify-between mt-2">
                  <span class="text-yellow-300 text-sm">{{ photo.date }}</span>
                  <span class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 text-xs text-white">
                    {{ photo.category }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Photo Modal -->
    <div v-if="selectedPhoto" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 p-4">
      <div class="max-w-4xl w-full max-h-full flex items-center justify-center relative">
        <!-- Close Button -->
        <button
          @click="closeModal"
          class="absolute top-4 right-4 bg-white/10 backdrop-blur-sm rounded-full w-12 h-12 flex items-center justify-center text-white hover:bg-white/20 transition-colors z-10"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

        <!-- Photo Content -->
        <div class="bg-white rounded-lg max-w-full max-h-full overflow-hidden shadow-2xl">
          <img
            :src="selectedPhoto.image"
            :alt="selectedPhoto.title"
            class="w-full h-auto max-h-[70vh] object-contain"
          >
          
          <!-- Photo Info -->
          <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
              <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ selectedPhoto.title }}</h2>
                <p class="text-lg text-blue-600 font-medium">{{ selectedPhoto.ceremony }}</p>
              </div>
              <div class="text-right">
                <p class="text-gray-600">{{ selectedPhoto.date }}</p>
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mt-1">
                  {{ selectedPhoto.category }}
                </span>
              </div>
            </div>
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
              <p class="text-sm text-gray-500">{{ selectedPhoto.description }}</p>
              <router-link
                v-if="selectedPhoto.departmentSlug"
                :to="`/departments#${selectedPhoto.departmentSlug}`"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors flex-shrink-0"
              >
                View {{ selectedPhoto.departmentName }} Department
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/** @typedef {import('./graduationPhotos').Photo} Photo */
import { photos, filterPhotos } from './graduationPhotos';

export default {
  name: 'GraduationGallery',
  data() {
    return {
      /** @type {string} */
      currentFilter: 'all',
      /** @type {Photo | null} */
      selectedPhoto: null,
      /** @type {{key: string, label: string}[]} */
      filters: [
        { key: 'all', label: 'All Categories' },
        { key: 'ceremony', label: 'All Ceremonies' },
        { key: 'department', label: 'Departments' },
        { key: '2024', label: '2024 Graduation' },
        { key: '2023', label: '2023 Graduation' },
        { key: 'awards', label: 'Award Ceremonies' }
      ],
      /** @type {Photo[]} */
      photos
    }
  },
  computed: {
    /** @returns {Photo[]} */
    filteredPhotos() {
      return filterPhotos(this.photos, this.currentFilter);
    }
  },
  methods: {
    /**
     * @param {Photo} photo
     */
    openModal(photo) {
      this.selectedPhoto = photo;
      document.addEventListener('keydown', this.handleKeydown);
      document.body.style.overflow = 'hidden';
    },
    closeModal() {
      this.selectedPhoto = null;
      document.removeEventListener('keydown', this.handleKeydown);
      document.body.style.overflow = '';
    },
    /**
     * @param {KeyboardEvent} event
     */
    handleKeydown(event) {
      if (event.key === 'Escape') {
        this.closeModal();
      }
    }
  }
}
</script>