<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">Graduation Gallery</h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Celebrate our graduates' achievements and memorable moments throughout their academic journey
          </p>
        </div>
      </div>
    </section>

    <!-- Filter Tabs -->
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex overflow-x-auto py-6 space-x-8">
          <button
            v-for="filter in filterOptions"
            :key="filter.key"
            @click="selectedFilter = filter.key"
            :class="selectedFilter === filter.key ? 
              'border-blue-500 text-blue-600' : 
              'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors"
          >
            {{ filter.label }}
          </button>
        </div>
      </div>
    </section>

    <!-- Graduation Year Filter -->
    <section class="bg-gray-50 border-b" v-if="selectedFilter === 'graduation'">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center space-x-4">
          <span class="text-sm font-medium text-gray-700">Graduation Year:</span>
          <div class="flex space-x-2">
            <button
              v-for="year in availableYears"
              :key="year"
              @click="selectedYear = year"
              :class="selectedYear === year ? 
                'bg-blue-600 text-white' : 
                'bg-white text-gray-700 hover:bg-gray-100'"
              class="px-3 py-1 rounded-full text-sm font-medium transition-colors border"
            >
              {{ year }}
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Photo Grid -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6" v-if="filteredPhotos.length">
          <div
            v-for="photo in filteredPhotos"
            :key="photo.id"
            class="break-inside-avoid bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
          >
            <div class="relative cursor-pointer" @click="openLightbox(photo)">
              <img
                :src="photo.image_path"
                :alt="photo.alt_text || photo.title"
                class="w-full h-auto object-cover"
                :style="{ aspectRatio: photo.aspect_ratio || 'auto' }"
              />
              <!-- Graduation Year Badge -->
              <div v-if="photo.graduation_year" class="absolute top-2 right-2">
                <span class="bg-blue-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                  Class of {{ photo.graduation_year }}
                </span>
              </div>
            </div>
            
            <div class="p-4">
              <h3 class="font-semibold text-gray-900 mb-1">{{ photo.title }}</h3>
              <p class="text-gray-600 text-sm mb-2" v-if="photo.description">{{ photo.description }}</p>
              
              <!-- Student Names -->
              <div v-if="photo.student_names && photo.student_names.length" class="mb-3">
                <p class="text-xs text-gray-500 mb-1">Featured Students:</p>
                <div class="flex flex-wrap gap-1">
                  <span 
                    v-for="name in photo.student_names.slice(0, 3)" 
                    :key="name"
                    class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs"
                  >
                    {{ name }}
                  </span>
                  <span v-if="photo.student_names.length > 3" class="text-gray-500 text-xs">
                    +{{ photo.student_names.length - 3 }} more
                  </span>
                </div>
              </div>

              <!-- Motto -->
              <div v-if="photo.motto" class="mb-3 p-2 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                <p class="text-sm italic text-blue-800">"{{ photo.motto }}"</p>
              </div>

              <!-- Department -->
              <div v-if="photo.department" class="mb-3">
                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs font-medium">
                  {{ photo.department }}
                </span>
              </div>

              <!-- Like/Dislike Buttons -->
              <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-4">
                  <button 
                    @click="likePhoto(photo)"
                    :class="photo.user_liked ? 'text-red-500' : 'text-gray-400 hover:text-red-500'"
                    class="flex items-center space-x-1 transition-colors"
                  >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ photo.likes_count || 0 }}</span>
                  </button>
                  
                  <button 
                    @click="dislikePhoto(photo)"
                    :class="photo.user_disliked ? 'text-blue-500' : 'text-gray-400 hover:text-blue-500'"
                    class="flex items-center space-x-1 transition-colors"
                  >
                    <svg class="w-5 h-5 transform rotate-180" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ photo.dislikes_count || 0 }}</span>
                  </button>
                </div>
                
                <button 
                  @click="showComments(photo)"
                  class="flex items-center space-x-1 text-gray-400 hover:text-gray-600 transition-colors"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.255-.949L5 20l1.395-3.72C7.512 15.042 9.201 14 12 14c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8c0 1.537.586 2.939 1.546 4.002z"/>
                  </svg>
                  <span class="text-sm">{{ photo.comments_count || 0 }}</span>
                </button>
              </div>

              <!-- Date and Category -->
              <div class="flex items-center justify-between text-xs text-gray-500">
                <span v-if="photo.taken_at">{{ formatDate(photo.taken_at) }}</span>
                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ photo.category }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-else-if="loading" class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
          <div v-for="i in 12" :key="i" class="break-inside-avoid bg-white rounded-lg shadow-sm overflow-hidden animate-pulse">
            <div class="bg-gray-300 h-48"></div>
            <div class="p-4">
              <div class="h-4 bg-gray-300 rounded mb-2"></div>
              <div class="h-3 bg-gray-300 rounded mb-3"></div>
              <div class="flex items-center justify-between">
                <div class="h-3 bg-gray-300 rounded w-16"></div>
                <div class="h-5 bg-gray-300 rounded w-12"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">No photos found</h3>
          <p class="mt-2 text-gray-500">Check back later for new photos in this category.</p>
        </div>
      </div>
    </section>

    <!-- Lightbox Modal -->
    <div 
      v-if="lightboxPhoto" 
      class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4"
      @click="closeLightbox"
    >
      <div class="max-w-7xl max-h-full flex items-center justify-center">
        <div class="relative">
          <img
            :src="lightboxPhoto.image_path"
            :alt="lightboxPhoto.alt_text || lightboxPhoto.title"
            class="max-w-full max-h-[90vh] object-contain"
          />
          <button
            @click="closeLightbox"
            class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors"
          >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          
          <!-- Navigation Arrows -->
          <button
            v-if="currentPhotoIndex > 0"
            @click.stop="previousPhoto"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors"
          >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          
          <button
            v-if="currentPhotoIndex < filteredPhotos.length - 1"
            @click.stop="nextPhoto"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors"
          >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Photo Info -->
      <div class="absolute bottom-4 left-4 right-4 text-white text-center">
        <h3 class="text-xl font-semibold mb-2">{{ lightboxPhoto.title }}</h3>
        <p class="text-gray-300 mb-2" v-if="lightboxPhoto.description">{{ lightboxPhoto.description }}</p>
        
        <!-- Student Names in Lightbox -->
        <div v-if="lightboxPhoto.student_names && lightboxPhoto.student_names.length" class="mb-2">
          <p class="text-sm text-gray-300 mb-1">Featured: {{ lightboxPhoto.student_names.join(', ') }}</p>
        </div>

        <!-- Motto in Lightbox -->
        <div v-if="lightboxPhoto.motto" class="mb-3 p-3 bg-black/30 backdrop-blur-sm rounded-lg">
          <p class="text-yellow-300 italic">"{{ lightboxPhoto.motto }}"</p>
        </div>

        <div class="flex items-center justify-center space-x-6 text-sm text-gray-400">
          <span v-if="lightboxPhoto.taken_at">{{ formatDate(lightboxPhoto.taken_at) }}</span>
          <span v-if="lightboxPhoto.graduation_year">Class of {{ lightboxPhoto.graduation_year }}</span>
          <span>{{ lightboxPhoto.category }}</span>
          <span>{{ currentPhotoIndex + 1 }} of {{ filteredPhotos.length }}</span>
        </div>

        <!-- Lightbox Actions -->
        <div class="flex items-center justify-center space-x-4 mt-4">
          <button 
            @click.stop="likePhoto(lightboxPhoto)"
            :class="lightboxPhoto.user_liked ? 'text-red-400' : 'text-gray-300 hover:text-red-400'"
            class="flex items-center space-x-1 transition-colors"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
            </svg>
            <span>{{ lightboxPhoto.likes_count || 0 }}</span>
          </button>
          
          <button 
            @click.stop="showComments(lightboxPhoto)"
            class="flex items-center space-x-1 text-gray-300 hover:text-white transition-colors"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a9.863 9.863 0 01-4.255-.949L5 20l1.395-3.72C7.512 15.042 9.201 14 12 14c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8c0 1.537.586 2.939 1.546 4.002z"/>
            </svg>
            <span>{{ lightboxPhoto.comments_count || 0 }}</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Comments Modal -->
    <div v-if="showCommentsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60 p-4" @click="showCommentsModal = false">
      <div class="bg-white rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto" @click.stop>
        <div class="relative">
          <!-- Comments Header -->
          <div class="relative h-48 overflow-hidden rounded-t-xl">
            <img 
              :src="selectedPhotoForComments?.image_path" 
              :alt="selectedPhotoForComments?.title"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <button 
              @click="showCommentsModal = false"
              class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
            <div class="absolute bottom-6 left-6">
              <h2 class="text-2xl font-bold text-white mb-2">{{ selectedPhotoForComments?.title }}</h2>
              <p class="text-gray-200" v-if="selectedPhotoForComments?.student_names">
                {{ selectedPhotoForComments.student_names.join(', ') }}
              </p>
            </div>
          </div>

          <!-- Comments Content -->
          <div class="p-6">
            <!-- Motto Display -->
            <div v-if="selectedPhotoForComments?.motto" class="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
              <p class="text-blue-800 italic font-medium">"{{ selectedPhotoForComments.motto }}"</p>
            </div>

            <!-- Comment Form -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
              <h3 class="text-lg font-semibold text-gray-900 mb-3">Add a Comment</h3>
              <form @submit.prevent="submitComment">
                <div class="mb-3">
                  <input
                    v-model="newComment.author_name"
                    type="text"
                    placeholder="Your name"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                  />
                </div>
                <div class="mb-3">
                  <textarea
                    v-model="newComment.content"
                    placeholder="Share your thoughts about this photo..."
                    rows="3"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                    required
                  ></textarea>
                </div>
                <button
                  type="submit"
                  :disabled="isSubmittingComment"
                  class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  <span v-if="isSubmittingComment">Posting...</span>
                  <span v-else>Post Comment</span>
                </button>
              </form>
            </div>

            <!-- Comments List -->
            <div class="space-y-4">
              <h3 class="text-lg font-semibold text-gray-900">
                Comments ({{ photoComments.length }})
              </h3>
              
              <div v-if="loadingComments" class="text-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                <p class="mt-2 text-gray-600">Loading comments...</p>
              </div>

              <div v-else-if="photoComments.length === 0" class="text-center py-8 text-gray-500">
                <p>No comments yet. Be the first to share your thoughts!</p>
              </div>

              <div v-else class="space-y-4">
                <div 
                  v-for="comment in photoComments" 
                  :key="comment.id"
                  class="bg-gray-50 p-4 rounded-lg"
                >
                  <div class="flex items-start space-x-3">
                    <div class="bg-blue-600 rounded-full w-10 h-10 flex items-center justify-center text-white font-semibold">
                      {{ comment.author_name.charAt(0).toUpperCase() }}
                    </div>
                    <div class="flex-1">
                      <div class="flex items-center space-x-2 mb-1">
                        <h4 class="font-semibold text-gray-900">{{ comment.author_name }}</h4>
                        <span class="text-sm text-gray-500">{{ formatDate(comment.created_at) }}</span>
                      </div>
                      <p class="text-gray-700">{{ comment.content }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const photos = ref([]);
const selectedFilter = ref('all');
const selectedYear = ref('all');
const lightboxPhoto = ref(null);
const currentPhotoIndex = ref(0);
const loading = ref(true);
const showCommentsModal = ref(false);
const selectedPhotoForComments = ref(null);
const photoComments = ref([]);
const loadingComments = ref(false);
const isSubmittingComment = ref(false);
const newComment = ref({
  author_name: '',
  content: ''
});

const filterOptions = [
  { key: 'all', label: 'All Photos' },
  { key: 'graduation', label: 'Graduation' },
  { key: 'campus', label: 'Campus' },
  { key: 'events', label: 'Events' },
  { key: 'student_life', label: 'Student Life' },
  { key: 'facilities', label: 'Facilities' }
];

const availableYears = computed(() => {
  const years = ['all', ...new Set(photos.value
    .filter(photo => photo.graduation_year)
    .map(photo => photo.graduation_year)
    .sort((a, b) => b - a)
  )];
  return years;
});

const filteredPhotos = computed(() => {
  let filtered = photos.value;
  
  // Filter by category/type
  if (selectedFilter.value !== 'all') {
    if (selectedFilter.value === 'graduation') {
      filtered = filtered.filter(photo => photo.graduation_year);
    } else {
      filtered = filtered.filter(photo => photo.category === selectedFilter.value);
    }
  }
  
  // Filter by graduation year
  if (selectedFilter.value === 'graduation' && selectedYear.value !== 'all') {
    filtered = filtered.filter(photo => photo.graduation_year == selectedYear.value);
  }
  
  return filtered;
});

const fetchPhotos = async () => {
  try {
    loading.value = true;
    const response = await fetch('/api/v1/photos');
    if (response.ok) {
      const data = await response.json();
      photos.value = data.data || data; // Handle different response formats
    } else {
      console.error('Failed to fetch photos');
      photos.value = getMockPhotos();
    }
  } catch (error) {
    console.error('Error fetching photos:', error);
    photos.value = getMockPhotos();
  } finally {
    loading.value = false;
  }
};

const getMockPhotos = () => {
  return [
    {
      id: 1,
      title: 'Computer Science Graduation 2024',
      description: 'Proud graduates from the Computer Science department celebrating their achievement.',
      image_path: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=600&h=800&fit=crop&crop=faces',
      alt_text: 'Computer Science graduates',
      category: 'graduation',
      graduation_year: 2024,
      department: 'Computer Science & IT',
      student_names: ['Alice Johnson', 'Bob Chen', 'Sarah Williams', 'Michael Davis'],
      motto: 'Code the future, debug the present',
      taken_at: '2024-06-15',
      likes_count: 45,
      dislikes_count: 2,
      comments_count: 12,
      aspect_ratio: '3/4'
    },
    {
      id: 2,
      title: 'Engineering Excellence 2023',
      description: 'Engineering graduates with their innovative projects.',
      image_path: 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=600&h=700&fit=crop&crop=faces',
      alt_text: 'Engineering graduates',
      category: 'graduation',
      graduation_year: 2023,
      department: 'Engineering',
      student_names: ['Mike Thompson', 'Lisa Rodriguez', 'David Kim', 'Emma Wilson'],
      motto: 'Building tomorrow\'s infrastructure today',
      taken_at: '2023-05-20',
      likes_count: 38,
      dislikes_count: 1,
      comments_count: 8,
      aspect_ratio: '4/5'
    },
    {
      id: 3,
      title: 'Medical School Graduates 2024',
      description: 'Future doctors ready to serve the community.',
      image_path: 'https://images.unsplash.com/photo-1559548331-f9cb98001426?w=500&h=700&fit=crop&crop=faces',
      alt_text: 'Medical graduates',
      category: 'graduation',
      graduation_year: 2024,
      department: 'Medicine & Health Sciences',
      student_names: ['Dr. Amanda Smith', 'Dr. James Wilson', 'Dr. Maria Garcia'],
      motto: 'Healing hands, caring hearts',
      taken_at: '2024-07-10',
      likes_count: 67,
      dislikes_count: 0,
      comments_count: 18,
      aspect_ratio: '2/3'
    },
    {
      id: 4,
      title: 'Business Administration Graduation 2024',
      description: 'Future business leaders ready to make their mark.',
      image_path: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&h=800&fit=crop&crop=faces',
      alt_text: 'Business graduates',
      category: 'graduation',
      graduation_year: 2024,
      department: 'Business & Management',
      student_names: ['John Martinez', 'Rachel Green', 'Alex Turner', 'Sofia Chen'],
      motto: 'Leading with vision, managing with heart',
      taken_at: '2024-06-20',
      likes_count: 52,
      dislikes_count: 3,
      comments_count: 15,
      aspect_ratio: '3/4'
    },
    {
      id: 5,
      title: 'Natural Sciences Graduates 2023',
      description: 'Researchers ready to explore the mysteries of nature.',
      image_path: 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=600&h=700&fit=crop&crop=faces',
      alt_text: 'Science graduates',
      category: 'graduation',
      graduation_year: 2023,
      department: 'Natural Sciences',
      student_names: ['Dr. Elena Vasquez', 'Mark Johnson', 'Priya Patel'],
      motto: 'Discovering truth through science',
      taken_at: '2023-05-15',
      likes_count: 41,
      dislikes_count: 2,
      comments_count: 9,
      aspect_ratio: '4/5'
    },
    {
      id: 6,
      title: 'Campus Life - Library Study Sessions',
      description: 'Students collaborating and studying together in our modern library.',
      image_path: 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&h=600&fit=crop',
      alt_text: 'Students studying in library',
      category: 'student_life',
      department: 'All Departments',
      student_names: ['Various Students'],
      taken_at: '2024-03-15',
      likes_count: 28,
      dislikes_count: 1,
      comments_count: 6,
      aspect_ratio: '4/3'
    },
    {
      id: 7,
      title: 'Campus Events - Sports Day 2024',
      description: 'Annual inter-department sports competition bringing students together.',
      image_path: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop',
      alt_text: 'Students at sports day',
      category: 'events',
      department: 'All Departments',
      student_names: ['Athletes from All Departments'],
      taken_at: '2024-04-10',
      likes_count: 89,
      dislikes_count: 0,
      comments_count: 23,
      aspect_ratio: '16/9'
    },
    {
      id: 8,
      title: 'Modern Science Laboratory',
      description: 'State-of-the-art laboratory facilities for hands-on learning.',
      image_path: 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?w=800&h=600&fit=crop',
      alt_text: 'Modern laboratory facility',
      category: 'facilities',
      department: 'Natural Sciences',
      taken_at: '2024-02-20',
      likes_count: 34,
      dislikes_count: 0,
      comments_count: 7,
      aspect_ratio: '4/3'
    }
  ];
};

const openLightbox = (photo) => {
  lightboxPhoto.value = photo;
  currentPhotoIndex.value = filteredPhotos.value.findIndex(p => p.id === photo.id);
};

const closeLightbox = () => {
  lightboxPhoto.value = null;
  currentPhotoIndex.value = 0;
};

const previousPhoto = () => {
  if (currentPhotoIndex.value > 0) {
    currentPhotoIndex.value--;
    lightboxPhoto.value = filteredPhotos.value[currentPhotoIndex.value];
  }
};

const nextPhoto = () => {
  if (currentPhotoIndex.value < filteredPhotos.value.length - 1) {
    currentPhotoIndex.value++;
    lightboxPhoto.value = filteredPhotos.value[currentPhotoIndex.value];
  }
};

const likePhoto = async (photo) => {
  try {
    const response = await fetch(`/api/v1/photos/${photo.id}/like`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      }
    });
    
    if (response.ok) {
      const data = await response.json();
      photo.likes_count = data.likes_count;
      photo.dislikes_count = data.dislikes_count;
      photo.user_liked = data.user_liked;
      photo.user_disliked = data.user_disliked;
    }
  } catch (error) {
    // Fallback for demo
    if (photo.user_liked) {
      photo.likes_count = Math.max(0, (photo.likes_count || 0) - 1);
      photo.user_liked = false;
    } else {
      photo.likes_count = (photo.likes_count || 0) + 1;
      photo.user_liked = true;
      if (photo.user_disliked) {
        photo.dislikes_count = Math.max(0, (photo.dislikes_count || 0) - 1);
        photo.user_disliked = false;
      }
    }
  }
};

const dislikePhoto = async (photo) => {
  try {
    const response = await fetch(`/api/v1/photos/${photo.id}/dislike`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      }
    });
    
    if (response.ok) {
      const data = await response.json();
      photo.likes_count = data.likes_count;
      photo.dislikes_count = data.dislikes_count;
      photo.user_liked = data.user_liked;
      photo.user_disliked = data.user_disliked;
    }
  } catch (error) {
    // Fallback for demo
    if (photo.user_disliked) {
      photo.dislikes_count = Math.max(0, (photo.dislikes_count || 0) - 1);
      photo.user_disliked = false;
    } else {
      photo.dislikes_count = (photo.dislikes_count || 0) + 1;
      photo.user_disliked = true;
      if (photo.user_liked) {
        photo.likes_count = Math.max(0, (photo.likes_count || 0) - 1);
        photo.user_liked = false;
      }
    }
  }
};

const showComments = async (photo) => {
  selectedPhotoForComments.value = photo;
  showCommentsModal.value = true;
  await fetchComments(photo.id);
};

const fetchComments = async (photoId) => {
  try {
    loadingComments.value = true;
    const response = await fetch(`/api/v1/photos/${photoId}/comments`);
    if (response.ok) {
      const data = await response.json();
      photoComments.value = data.data || [];
    } else {
      // Mock comments for demo
      photoComments.value = [
        {
          id: 1,
          author_name: 'Alex Johnson',
          content: 'Such an inspiring moment! Congratulations to all graduates.',
          created_at: '2024-06-16T10:30:00Z'
        },
        {
          id: 2,
          author_name: 'Maria Santos',
          content: 'Beautiful ceremony. Proud of our university!',
          created_at: '2024-06-16T11:15:00Z'
        }
      ];
    }
  } catch (error) {
    console.error('Error fetching comments:', error);
    photoComments.value = [];
  } finally {
    loadingComments.value = false;
  }
};

const submitComment = async () => {
  if (!newComment.value.author_name.trim() || !newComment.value.content.trim()) {
    return;
  }
  
  try {
    isSubmittingComment.value = true;
    
    const response = await fetch(`/api/v1/photos/${selectedPhotoForComments.value.id}/comments`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
      },
      body: JSON.stringify(newComment.value)
    });
    
    if (response.ok) {
      const data = await response.json();
      photoComments.value.unshift(data.comment);
      selectedPhotoForComments.value.comments_count = (selectedPhotoForComments.value.comments_count || 0) + 1;
      
      // Reset form
      newComment.value = { author_name: '', content: '' };
    } else {
      // Mock success for demo
      const mockComment = {
        id: Date.now(),
        author_name: newComment.value.author_name,
        content: newComment.value.content,
        created_at: new Date().toISOString()
      };
      photoComments.value.unshift(mockComment);
      selectedPhotoForComments.value.comments_count = (selectedPhotoForComments.value.comments_count || 0) + 1;
      
      // Reset form
      newComment.value = { author_name: '', content: '' };
    }
  } catch (error) {
    console.error('Error submitting comment:', error);
  } finally {
    isSubmittingComment.value = false;
  }
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

// Keyboard navigation
const handleKeydown = (event) => {
  if (lightboxPhoto.value) {
    if (event.key === 'Escape') {
      closeLightbox();
    } else if (event.key === 'ArrowLeft') {
      previousPhoto();
    } else if (event.key === 'ArrowRight') {
      nextPhoto();
    }
  }
  if (showCommentsModal.value && event.key === 'Escape') {
    showCommentsModal.value = false;
  }
};

onMounted(() => {
  fetchPhotos();
  window.addEventListener('keydown', handleKeydown);
});
</script>

<style scoped>
/* Custom masonry layout for better photo display */
.columns-1 {
  column-count: 1;
}

@media (min-width: 640px) {
  .columns-2 {
    column-count: 2;
  }
}

@media (min-width: 1024px) {
  .columns-3 {
    column-count: 3;
  }
}

@media (min-width: 1280px) {
  .columns-4 {
    column-count: 4;
  }
}

.break-inside-avoid {
  break-inside: avoid;
}
</style>