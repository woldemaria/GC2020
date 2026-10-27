<template>
  <div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg">
      <!-- Header -->
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">
              {{ isEditing ? 'Edit Article' : 'Create Article' }}
            </h1>
            <p class="text-gray-600">
              {{ isEditing ? 'Update your article content' : 'Create a new article for your magazine' }}
            </p>
          </div>
          <div class="flex space-x-3">
            <button
              @click="saveDraft"
              :disabled="saving"
              class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
            >
              Save Draft
            </button>
            <button
              @click="publishArticle"
              :disabled="saving"
              class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50"
            >
              {{ form.is_published ? 'Update' : 'Publish' }}
            </button>
          </div>
        </div>
      </div>

      <!-- Form -->
      <form @submit.prevent="saveArticle" class="p-6 space-y-6">
        <!-- Title -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
            Title *
          </label>
          <input
            id="title"
            v-model="form.title"
            type="text"
            required
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter article title..."
          />
          <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title[0] }}</p>
        </div>

        <!-- Slug -->
        <div>
          <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
            Slug
          </label>
          <input
            id="slug"
            v-model="form.slug"
            type="text"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="article-slug (auto-generated if empty)"
          />
          <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
          <p v-if="errors.slug" class="mt-1 text-sm text-red-600">{{ errors.slug[0] }}</p>
        </div>

        <!-- Category and Author -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
              Category *
            </label>
            <select
              id="category"
              v-model="form.category_id"
              required
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
              <option value="">Select Category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            <p v-if="errors.category_id" class="mt-1 text-sm text-red-600">{{ errors.category_id[0] }}</p>
          </div>

          <div>
            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">
              Author *
            </label>
            <select
              id="author"
              v-model="form.author_id"
              required
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
              <option value="">Select Author</option>
              <option v-for="author in authors" :key="author.id" :value="author.id">
                {{ author.name }}
              </option>
            </select>
            <p v-if="errors.author_id" class="mt-1 text-sm text-red-600">{{ errors.author_id[0] }}</p>
          </div>
        </div>

        <!-- Featured Image -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Featured Image
          </label>
          <div class="space-y-3">
            <div v-if="form.featured_image" class="relative inline-block">
              <img
                :src="form.featured_image"
                alt="Featured image"
                class="h-32 w-48 object-cover rounded-lg"
              />
              <button
                @click="form.featured_image = null"
                type="button"
                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
              >
                <XMarkIcon class="h-4 w-4" />
              </button>
            </div>
            
            <FileUpload
              type="article"
              @uploaded="(data) => form.featured_image = data.path"
              accept="image/*"
              class="w-full"
            >
              <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-gray-400 transition-colors cursor-pointer">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-400" />
                <div class="text-center">
                  <p class="mt-2 text-sm text-gray-600">Click to upload featured image</p>
                  <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                </div>
              </div>
            </FileUpload>
          </div>
        </div>

        <!-- Excerpt -->
        <div>
          <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">
            Excerpt
          </label>
          <textarea
            id="excerpt"
            v-model="form.excerpt"
            rows="3"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Brief description of the article..."
          />
          <p class="mt-1 text-sm text-gray-500">{{ form.excerpt?.length || 0 }}/500 characters</p>
          <p v-if="errors.excerpt" class="mt-1 text-sm text-red-600">{{ errors.excerpt[0] }}</p>
        </div>

        <!-- Content -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Content *
          </label>
          <RichTextEditor
            v-model="form.content"
            placeholder="Write your article content..."
            height="400px"
          />
          <p v-if="errors.content" class="mt-1 text-sm text-red-600">{{ errors.content[0] }}</p>
        </div>

        <!-- Gallery Images -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-3">
            Gallery Images
          </label>
          
          <div v-if="form.gallery_images && form.gallery_images.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div
              v-for="(image, index) in form.gallery_images"
              :key="index"
              class="relative"
            >
              <img
                :src="image"
                alt="Gallery image"
                class="w-full h-24 object-cover rounded-lg"
              />
              <button
                @click="removeGalleryImage(index)"
                type="button"
                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
              >
                <XMarkIcon class="h-4 w-4" />
              </button>
            </div>
          </div>

          <FileUpload
            type="gallery"
            multiple
            @uploaded="addGalleryImages"
            accept="image/*"
            class="w-full"
          >
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-gray-400 transition-colors cursor-pointer">
              <PhotoIcon class="mx-auto h-12 w-12 text-gray-400" />
              <div class="text-center">
                <p class="mt-2 text-sm text-gray-600">Click to upload gallery images</p>
                <p class="text-xs text-gray-500">Select multiple images for article gallery</p>
              </div>
            </div>
          </FileUpload>
        </div>

        <!-- Tags -->
        <div>
          <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">
            Tags
          </label>
          <div class="flex flex-wrap gap-2 mb-2">
            <span
              v-for="(tag, index) in form.tags"
              :key="index"
              class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
            >
              {{ tag }}
              <button
                @click="removeTag(index)"
                type="button"
                class="ml-2 text-blue-600 hover:text-blue-800"
              >
                <XMarkIcon class="h-3 w-3" />
              </button>
            </span>
          </div>
          <div class="flex">
            <input
              v-model="newTag"
              @keydown.enter.prevent="addTag"
              type="text"
              placeholder="Add a tag..."
              class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <button
              @click="addTag"
              type="button"
              class="px-4 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-700 rounded-r-md hover:bg-gray-100"
            >
              Add
            </button>
          </div>
        </div>

        <!-- Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-4">
            <div class="flex items-center">
              <input
                id="is_featured"
                v-model="form.is_featured"
                type="checkbox"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
              />
              <label for="is_featured" class="ml-2 text-sm text-gray-700">
                Featured Article
              </label>
            </div>

            <div class="flex items-center">
              <input
                id="is_published"
                v-model="form.is_published"
                type="checkbox"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
              />
              <label for="is_published" class="ml-2 text-sm text-gray-700">
                Published
              </label>
            </div>
          </div>

          <div>
            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
              Publish Date
            </label>
            <input
              id="published_at"
              v-model="form.published_at"
              type="datetime-local"
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
            <p class="mt-1 text-sm text-gray-500">Leave empty to use current time when publishing</p>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, inject, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { PhotoIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import RichTextEditor from './common/RichTextEditor.vue';
import FileUpload from './common/FileUpload.vue';

const route = useRoute();
const router = useRouter();
const showNotification = inject('showNotification');
const showLoading = inject('showLoading');
const hideLoading = inject('hideLoading');

const saving = ref(false);
const categories = ref([]);
const authors = ref([]);
const errors = ref({});
const newTag = ref('');

const isEditing = computed(() => !!route.params.id);

const form = reactive({
  title: '',
  slug: '',
  excerpt: '',
  content: '',
  featured_image: null,
  gallery_images: [],
  category_id: '',
  author_id: '',
  is_featured: false,
  is_published: false,
  published_at: '',
  tags: []
});

const loadFormData = async () => {
  try {
    const response = await fetch('/api/admin/articles/form-data');
    const data = await response.json();
    
    if (data.success) {
      categories.value = data.data.categories;
      authors.value = data.data.authors;
    }
  } catch (error) {
    showNotification('error', 'Error', 'Failed to load form data');
  }
};

const loadArticle = async () => {
  if (!isEditing.value) return;
  
  try {
    showLoading();
    
    const response = await fetch(`/api/admin/articles/${route.params.id}`);
    const data = await response.json();
    
    if (data.success) {
      const article = data.data;
      
      Object.assign(form, {
        title: article.title,
        slug: article.slug,
        excerpt: article.excerpt || '',
        content: article.content,
        featured_image: article.featured_image,
        gallery_images: article.gallery_images || [],
        category_id: article.category_id,
        author_id: article.author_id,
        is_featured: article.is_featured,
        is_published: article.is_published,
        published_at: article.published_at ? article.published_at.slice(0, 16) : '',
        tags: article.tags || []
      });
    }
  } catch (error) {
    showNotification('error', 'Error', 'Failed to load article');
  } finally {
    hideLoading();
  }
};

const saveArticle = async (publish = false) => {
  try {
    saving.value = true;
    showLoading();
    errors.value = {};
    
    const formData = { ...form };
    if (publish) {
      formData.is_published = true;
    }
    
    const url = isEditing.value 
      ? `/api/admin/articles/${route.params.id}`
      : '/api/admin/articles';
    const method = isEditing.value ? 'PUT' : 'POST';
    
    const response = await fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(formData)
    });
    
    const data = await response.json();
    
    if (data.success) {
      showNotification('success', 'Success', data.message);
      if (!isEditing.value) {
        router.push(`/admin/articles/${data.data.id}/edit`);
      }
    } else {
      if (response.status === 422) {
        errors.value = data.errors || {};
        showNotification('error', 'Validation Error', 'Please fix the errors below');
      } else {
        showNotification('error', 'Error', data.message || 'Failed to save article');
      }
    }
  } catch (error) {
    showNotification('error', 'Error', 'Failed to save article');
  } finally {
    saving.value = false;
    hideLoading();
  }
};

const saveDraft = () => {
  saveArticle(false);
};

const publishArticle = () => {
  saveArticle(true);
};

const addGalleryImages = (uploadedFiles) => {
  if (Array.isArray(uploadedFiles)) {
    form.gallery_images.push(...uploadedFiles.map(file => file.path));
  } else {
    form.gallery_images.push(uploadedFiles.path);
  }
};

const removeGalleryImage = (index) => {
  form.gallery_images.splice(index, 1);
};

const addTag = () => {
  const tag = newTag.value.trim();
  if (tag && !form.tags.includes(tag)) {
    form.tags.push(tag);
    newTag.value = '';
  }
};

const removeTag = (index) => {
  form.tags.splice(index, 1);
};

onMounted(() => {
  loadFormData();
  loadArticle();
});
</script>