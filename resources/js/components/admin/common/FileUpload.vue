<template>
  <div
    @click="triggerFileInput"
    @drop="handleDrop"
    @dragover.prevent="dragOver = true"
    @dragenter.prevent="dragOver = true"
    @dragleave.prevent="dragOver = false"
    :class="[
      'file-upload-area',
      { 'uploading': uploading, 'drag-over': dragOver }
    ]"
  >
    <input
      ref="fileInput"
      type="file"
      :accept="accept"
      :multiple="multiple"
      @change="handleFileSelect"
      class="hidden"
    />
    
    <slot v-if="!uploading">
      <div class="text-center p-6">
        <CloudArrowUpIcon class="mx-auto h-12 w-12 text-gray-400" />
        <div class="mt-2">
          <p class="text-sm text-gray-600">
            {{ multiple ? 'Drop files here or click to select' : 'Drop file here or click to select' }}
          </p>
          <p class="text-xs text-gray-500 mt-1">{{ accept || 'All file types' }}</p>
        </div>
      </div>
    </slot>
    
    <div v-if="uploading" class="text-center p-6">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
      <p class="mt-2 text-sm text-gray-600">
        Uploading {{ multiple && selectedFiles.length > 1 ? `${selectedFiles.length} files` : 'file' }}...
      </p>
      <div v-if="uploadProgress > 0" class="mt-2 bg-gray-200 rounded-full h-2">
        <div
          class="bg-blue-600 h-2 rounded-full transition-all duration-300"
          :style="{ width: uploadProgress + '%' }"
        ></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import { CloudArrowUpIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  type: {
    type: String,
    default: 'general',
    validator: (value) => ['article', 'avatar', 'gallery', 'general'].includes(value)
  },
  accept: {
    type: String,
    default: ''
  },
  multiple: {
    type: Boolean,
    default: false
  },
  maxSize: {
    type: Number,
    default: 10 * 1024 * 1024 // 10MB
  },
  maxFiles: {
    type: Number,
    default: 10
  }
});

const emit = defineEmits(['uploaded', 'error']);

const fileInput = ref(null);
const uploading = ref(false);
const dragOver = ref(false);
const uploadProgress = ref(0);
const selectedFiles = ref([]);

const triggerFileInput = () => {
  if (!uploading.value) {
    fileInput.value.click();
  }
};

const handleFileSelect = (event) => {
  const files = Array.from(event.target.files);
  if (files.length > 0) {
    uploadFiles(files);
  }
};

const handleDrop = (event) => {
  dragOver.value = false;
  event.preventDefault();
  
  const files = Array.from(event.dataTransfer.files);
  
  // Filter only image files if accept prop is set to images
  const imageFiles = files.filter(file => {
    if (props.accept && props.accept.includes('image')) {
      return file.type.startsWith('image/');
    }
    return true;
  });
  
  if (imageFiles.length === 0) {
    emit('error', 'Please drop valid image files');
    return;
  }
  
  if (imageFiles.length > 0) {
    uploadFiles(imageFiles);
  }
};

const validateFiles = (files) => {
  const errors = [];
  
  // Check file count
  if (props.multiple && files.length > props.maxFiles) {
    errors.push(`Maximum ${props.maxFiles} files allowed`);
    return errors;
  }
  
  // Check individual files
  files.forEach((file, index) => {
    // Check file size
    if (file.size > props.maxSize) {
      errors.push(`File ${index + 1}: Size exceeds ${formatFileSize(props.maxSize)} limit`);
    }
    
    // Check file type if accept is specified
    if (props.accept && !isFileTypeAccepted(file, props.accept)) {
      errors.push(`File ${index + 1}: File type not allowed`);
    }
  });
  
  return errors;
};

const isFileTypeAccepted = (file, accept) => {
  if (!accept) return true;
  
  const acceptedTypes = accept.split(',').map(type => type.trim());
  
  return acceptedTypes.some(type => {
    if (type.startsWith('.')) {
      // File extension
      return file.name.toLowerCase().endsWith(type.toLowerCase());
    } else if (type.includes('/*')) {
      // MIME type wildcard
      const [mainType] = type.split('/');
      return file.type.startsWith(mainType + '/');
    } else {
      // Exact MIME type
      return file.type === type;
    }
  });
};

const uploadFiles = async (files) => {
  // Validate files
  const validationErrors = validateFiles(files);
  if (validationErrors.length > 0) {
    emit('error', validationErrors.join(', '));
    return;
  }
  
  uploading.value = true;
  uploadProgress.value = 0;
  selectedFiles.value = files;
  
  try {
    if (props.multiple) {
      await uploadMultipleFiles(files);
    } else {
      await uploadSingleFile(files[0]);
    }
  } catch (error) {
    emit('error', error.message || 'Upload failed');
  } finally {
    uploading.value = false;
    uploadProgress.value = 0;
    selectedFiles.value = [];
    
    // Clear file input
    if (fileInput.value) {
      fileInput.value.value = '';
    }
  }
};

const getCsrfToken = () => {
  const meta = document.head.querySelector('meta[name="csrf-token"]');
  return meta ? meta.content : '';
};

const uploadSingleFile = async (file) => {
  const formData = new FormData();
  formData.append('image', file);
  formData.append('type', props.type);
  
  try {
    const response = await fetch('/api/admin/media/upload', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': getCsrfToken()
      }
    });
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
    if (data.success) {
      emit('uploaded', data.data);
    } else {
      throw new Error(data.message || 'Upload failed');
    }
  } catch (error) {
    console.error('Upload error:', error);
    throw new Error(error.message || 'Network error during upload');
  }
};

const uploadMultipleFiles = async (files) => {
  const formData = new FormData();
  files.forEach(file => {
    formData.append('images[]', file);
  });
  formData.append('type', props.type);
  
  try {
    const response = await fetch('/api/admin/media/upload-multiple', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': getCsrfToken()
      }
    });
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
    if (data.success) {
      emit('uploaded', data.data);
      if (data.errors && data.errors.length > 0) {
        emit('error', 'Some files failed: ' + data.errors.join(', '));
      }
    } else {
      throw new Error(data.message || 'Upload failed');
    }
  } catch (error) {
    console.error('Multiple upload error:', error);
    throw new Error(error.message || 'Network error during upload');
  }
};

const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};
</script>

<style scoped>
.file-upload-area {
  cursor: pointer;
  border: 2px dashed #d1d5db;
  border-radius: 0.5rem;
  transition: border-color 0.15s ease-in-out, background-color 0.15s ease-in-out;
}

.file-upload-area:hover {
  border-color: #9ca3af;
}

.file-upload-area.drag-over {
  border-color: #3b82f6;
  background-color: #eff6ff;
}

.file-upload-area.uploading {
  cursor: not-allowed;
  background-color: #f9fafb;
}
</style>