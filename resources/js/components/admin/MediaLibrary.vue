<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Media Library</h2>
        <p class="text-gray-600">Upload and manage your media files</p>
      </div>
      
      <div class="flex space-x-3">
        <button
          @click="showUploadModal = true"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700"
        >
          <PlusIcon class="mr-2 h-4 w-4" />
          Upload Files
        </button>
        
        <button
          @click="loadImages"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50"
        >
          <ArrowPathIcon class="mr-2 h-4 w-4" />
          Refresh
        </button>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
      <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
          <select
            v-model="filters.type"
            @change="loadImages"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          >
            <option value="general">All Types</option>
            <option value="article">Articles</option>
            <option value="avatar">Avatars</option>
            <option value="gallery">Gallery</option>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">View</label>
          <select
            v-model="viewMode"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          >
            <option value="grid">Grid</option>
            <option value="list">List</option>
          </select>
        </div>
        
        <div class="sm:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <input
            v-model="searchQuery"
            @input="debouncedSearch"
            type="text"
            placeholder="Search files..."
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
          />
        </div>
      </div>
    </div>

    <!-- Selected Files Actions -->
    <div v-if="selectedFiles.length > 0" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
      <div class="flex items-center justify-between">
        <span class="text-sm text-blue-800">
          {{ selectedFiles.length }} file(s) selected
        </span>
        <div class="flex space-x-2">
          <button
            @click="copySelectedUrls"
            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm"
          >
            Copy URLs
          </button>
          <button
            @click="deleteSelected"
            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm"
          >
            Delete
          </button>
          <button
            @click="selectedFiles = []"
            class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm"
          >
            Clear
          </button>
        </div>
      </div>
    </div>

    <!-- Media Grid/List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <!-- Grid View -->
      <div v-if="viewMode === 'grid'" class="p-6">
        <div v-if="images.length === 0" class="text-center py-12">
          <PhotoIcon class="mx-auto h-12 w-12 text-gray-400" />
          <h3 class="mt-2 text-sm font-medium text-gray-900">No images found</h3>
          <p class="mt-1 text-sm text-gray-500">Upload some images to get started.</p>
        </div>
        
        <div v-else class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
          <div
            v-for="image in filteredImages"
            :key="image.path"
            class="relative group cursor-pointer"
            @click="selectImage(image)"
          >
            <div
              :class="[
                'relative overflow-hidden rounded-lg border-2 transition-all',
                selectedFiles.includes(image.path) 
                  ? 'border-blue-500 ring-2 ring-blue-500 ring-opacity-50' 
                  : 'border-gray-200 hover:border-gray-300'
              ]"
            >
              <img
                :src="image.thumbnail || image.path"
                :alt="image.filename"
                class="w-full h-32 object-cover"
              />
              
              <!-- Overlay -->
              <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 flex items-center justify-center">
                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                  <button
                    @click.stop="copyUrl(image.path)"
                    class="p-2 bg-white rounded-full text-gray-700 hover:text-gray-900 mr-2"
                    title="Copy URL"
                  >
                    <ClipboardDocumentIcon class="h-4 w-4" />
                  </button>
                  <button
                    @click.stop="deleteImage(image)"
                    class="p-2 bg-white rounded-full text-red-600 hover:text-red-700"
                    title="Delete"
                  >
                    <TrashIcon class="h-4 w-4" />
                  </button>
                </div>
              </div>
              
              <!-- Selection Indicator -->
              <div
                v-if="selectedFiles.includes(image.path)"
                class="absolute top-2 right-2 bg-blue-500 text-white rounded-full p-1"
              >
                <CheckIcon class="h-3 w-3" />
              </div>
            </div>
            
            <div class="mt-2">
              <p class="text-sm font-medium text-gray-900 truncate">{{ image.filename }}</p>
              <p class="text-xs text-gray-500">{{ formatFileSize(image.size) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- List View -->
      <div v-if="viewMode === 'list'">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left">
                <input
                  type="checkbox"
                  :checked="selectAll"
                  @change="toggleSelectAll"
                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                />
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                File
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Size
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Uploaded
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="image in filteredImages" :key="image.path" class="hover:bg-gray-50">
              <td class="px-6 py-4">
                <input
                  type="checkbox"
                  :value="image.path"
                  v-model="selectedFiles"
                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                />
              </td>
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <img
                    :src="image.thumbnail || image.path"
                    :alt="image.filename"
                    class="h-10 w-10 rounded object-cover mr-3"
                  />
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ image.filename }}</div>
                    <div class="text-sm text-gray-500">{{ image.path }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatFileSize(image.size) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(image.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                <button
                  @click="copyUrl(image.path)"
                  class="text-blue-600 hover:text-blue-900"
                >
                  Copy URL
                </button>
                <button
                  @click="deleteImage(image)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination.total > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow">
      <div class="flex-1 flex justify-between sm:hidden">
        <button
          @click="previousPage"
          :disabled="pagination.current_page === 1"
          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
        >
          Previous
        </button>
        <button
          @click="nextPage"
          :disabled="pagination.current_page >= pagination.total_pages"
          class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
        >
          Next
        </button>
      </div>
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
          <p class="text-sm text-gray-700">
            Showing {{ images.length }} of {{ pagination.total }} results
          </p>
        </div>
        <div>
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
            <button
              @click="previousPage"
              :disabled="pagination.current_page === 1"
              class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"
            >
              Previous
            </button>
            
            <button
              v-for="page in paginationPages"
              :key="page"
              @click="goToPage(page)"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                page === pagination.current_page
                  ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                  : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
              ]"
            >
              {{ page }}
            </button>
            
            <button
              @click="nextPage"
              :disabled="pagination.current_page >= pagination.total_pages"
              class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"
            >
              Next
            </button>
          </nav>
        </div>
      </div>
    </div>

    <!-- Upload Modal -->
    <div v-if="showUploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-medium text-gray-900">Upload Files</h3>
          <button
            @click="showUploadModal = false"
            class="text-gray-400 hover:text-gray-600"
          >
            <XMarkIcon class="h-6 w-6" />
          </button>
        </div>
        
        <FileUpload
          :type="filters.type"
          multiple
          @uploaded="handleUpload"
          @error="handleUploadError"
          accept="image/*"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, inject } from 'vue';
import {
  PlusIcon,
  ArrowPathIcon,
  PhotoIcon,
  ClipboardDocumentIcon,
  TrashIcon,
  CheckIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline';
import FileUpload from './common/FileUpload.vue';

const showNotification = inject('showNotification');
const showLoading = inject('showLoading');
const hideLoading = inject('hideLoading');

const loading = ref(false);
const images = ref([]);
const selectedFiles = ref([]);
const searchQuery = ref('');
const viewMode = ref('grid');
const showUploadModal = ref(false);

const filters = ref({
  type: 'general',
  page: 1,
  per_page: 20
});

const pagination = ref({
  current_page: 1,
  total: 0,
  total_pages: 1
});

const selectAll = computed(() => {
  return images.value.length > 0 && selectedFiles.value.length === images.value.length;
});

const filteredImages = computed(() => {
  if (!searchQuery.value) return images.value;
  
  const query = searchQuery.value.toLowerCase();
  return images.value.filter(image => 
    image.filename.toLowerCase().includes(query)
  );
});

const paginationPages = computed(() => {
  const current = pagination.value.current_page;
  const last = pagination.value.total_pages;
  const pages = [];
  
  for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
    pages.push(i);
  }
  
  return pages;
});

const loadImages = async () => {
  try {
    loading.value = true;
    showLoading();
    
    const params = new URLSearchParams();
    Object.entries(filters.value).forEach(([key, value]) => {
      if (value) params.append(key, value);
    });
    
    const response = await fetch(`/api/admin/media/list?${params}`);
    const data = await response.json();
    
    if (data.success) {
      images.value = data.data;
      pagination.value = data.pagination;
    }
  } catch (error) {
    showNotification('error', 'Error', 'Failed to load images');
  } finally {
    loading.value = false;
    hideLoading();
  }
};

const selectImage = (image) => {
  const index = selectedFiles.value.indexOf(image.path);
  if (index > -1) {
    selectedFiles.value.splice(index, 1);
  } else {
    selectedFiles.value.push(image.path);
  }
};

const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedFiles.value = [];
  } else {
    selectedFiles.value = images.value.map(image => image.path);
  }
};

const copyUrl = async (path) => {
  const fullUrl = window.location.origin + path;
  try {
    await navigator.clipboard.writeText(fullUrl);
    showNotification('success', 'Copied', 'Image URL copied to clipboard');
  } catch (error) {
    showNotification('error', 'Error', 'Failed to copy URL');
  }
};

const copySelectedUrls = async () => {
  const urls = selectedFiles.value.map(path => window.location.origin + path).join('\n');
  try {
    await navigator.clipboard.writeText(urls);
    showNotification('success', 'Copied', `${selectedFiles.value.length} URLs copied to clipboard`);
  } catch (error) {
    showNotification('error', 'Error', 'Failed to copy URLs');
  }
};

const getCsrfToken = () => {
  const meta = document.head.querySelector('meta[name="csrf-token"]');
  return meta ? meta.content : '';
};

const deleteImage = async (image) => {
  if (!confirm(`Are you sure you want to delete "${image.filename}"?`)) {
    return;
  }
  
  try {
    showLoading();
    
    const response = await fetch('/api/admin/media/delete', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken()
      },
      body: JSON.stringify({ path: image.path })
    });
    
    const data = await response.json();
    
    if (data.success) {
      showNotification('success', 'Success', 'Image deleted successfully');
      loadImages();
    }
  } catch (error) {
    showNotification('error', 'Error', 'Failed to delete image');
  } finally {
    hideLoading();
  }
};

const deleteSelected = async () => {
  if (!confirm(`Are you sure you want to delete ${selectedFiles.value.length} file(s)?`)) {
    return;
  }
  
  try {
    showLoading();
    
    const promises = selectedFiles.value.map(path => 
      fetch('/api/admin/media/delete', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({ path })
      })
    );
    
    await Promise.all(promises);
    
    showNotification('success', 'Success', `${selectedFiles.value.length} files deleted successfully`);
    selectedFiles.value = [];
    loadImages();
  } catch (error) {
    showNotification('error', 'Error', 'Failed to delete files');
  } finally {
    hideLoading();
  }
};

const handleUpload = (uploadedFiles) => {
  showNotification('success', 'Success', `${Array.isArray(uploadedFiles) ? uploadedFiles.length : 1} file(s) uploaded successfully`);
  showUploadModal.value = false;
  loadImages();
};

const handleUploadError = (error) => {
  showNotification('error', 'Upload Error', error);
};

const previousPage = () => {
  if (filters.value.page > 1) {
    filters.value.page--;
    loadImages();
  }
};

const nextPage = () => {
  if (filters.value.page < pagination.value.total_pages) {
    filters.value.page++;
    loadImages();
  }
};

const goToPage = (page) => {
  filters.value.page = page;
  loadImages();
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString();
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

// Debounced search
let searchTimeout;
const debouncedSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    // Search is handled by computed property
  }, 300);
};

onMounted(() => {
  loadImages();
});
</script>