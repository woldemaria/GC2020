<template>
  <div class="space-y-6">
    <!-- Header -->
    <div>
      <h2 class="text-2xl font-bold text-gray-900">Upload Test</h2>
      <p class="text-gray-600">Test the file upload and editing functionality</p>
    </div>

    <!-- File Upload Test -->
    <div class="bg-white shadow rounded-lg p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">File Upload Test</h3>
      
      <div class="space-y-4">
        <FileUpload
          type="article"
          @uploaded="handleUpload"
          @error="handleError"
          accept="image/*"
        >
          <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
            <PhotoIcon class="mx-auto h-12 w-12 text-gray-400" />
            <div class="mt-4">
              <p class="text-lg font-medium text-gray-600">Drop images here or click to select</p>
              <p class="text-sm text-gray-500 mt-2">Supports JPG, PNG, GIF up to 10MB</p>
            </div>
          </div>
        </FileUpload>
        
        <!-- Upload Results -->
        <div v-if="uploadedFiles.length > 0" class="mt-6">
          <h4 class="text-md font-medium text-gray-900 mb-3">Uploaded Files:</h4>
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div
              v-for="file in uploadedFiles"
              :key="file.filename"
              class="border rounded-lg p-2"
            >
              <img
                :src="file.path"
                :alt="file.filename"
                class="w-full h-32 object-cover rounded mb-2"
              />
              <p class="text-xs text-gray-600 truncate">{{ file.filename }}</p>
              <p class="text-xs text-gray-500">{{ formatFileSize(file.file_size) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Rich Text Editor Test -->
    <div class="bg-white shadow rounded-lg p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Rich Text Editor Test</h3>
      
      <RichTextEditor
        v-model="editorContent"
        placeholder="Start typing or insert images..."
        height="300px"
        @change="handleEditorChange"
      />
      
      <div class="mt-4">
        <h4 class="text-md font-medium text-gray-900 mb-2">Editor Content:</h4>
        <pre class="bg-gray-100 p-3 rounded text-sm overflow-auto max-h-40">{{ editorContent || 'No content yet...' }}</pre>
      </div>
    </div>

    <!-- API Test -->
    <div class="bg-white shadow rounded-lg p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">API Connection Test</h3>
      
      <div class="space-y-4">
        <div class="flex space-x-4">
          <button
            @click="testDashboardAPI"
            :disabled="testing"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md disabled:opacity-50"
          >
            {{ testing ? 'Testing...' : 'Test Dashboard API' }}
          </button>
          
          <button
            @click="testMediaAPI"
            :disabled="testing"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md disabled:opacity-50"
          >
            {{ testing ? 'Testing...' : 'Test Media API' }}
          </button>
          
          <button
            @click="testSystemStatus"
            :disabled="testing"
            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md disabled:opacity-50"
          >
            {{ testing ? 'Testing...' : 'Test System Status' }}
          </button>
        </div>
        
        <div v-if="apiResults.length > 0" class="mt-4">
          <h4 class="text-md font-medium text-gray-900 mb-2">API Test Results:</h4>
          <div class="space-y-2">
            <div
              v-for="result in apiResults"
              :key="result.id"
              :class="[
                'p-3 rounded-lg text-sm',
                result.success ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'
              ]"
            >
              <div class="flex justify-between items-start">
                <div>
                  <p class="font-medium">{{ result.endpoint }}</p>
                  <p :class="result.success ? 'text-green-700' : 'text-red-700'">
                    {{ result.message }}
                  </p>
                </div>
                <span :class="result.success ? 'text-green-600' : 'text-red-600'">
                  {{ result.success ? '✓' : '✗' }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Status -->
    <div class="bg-white shadow rounded-lg p-6">
      <h3 class="text-lg font-medium text-gray-900 mb-4">System Status</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="flex items-center">
          <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
          <div>
            <p class="text-sm font-medium text-gray-900">Laravel Server</p>
            <p class="text-xs text-gray-500">Running on :8000</p>
          </div>
        </div>
        
        <div class="flex items-center">
          <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
          <div>
            <p class="text-sm font-medium text-gray-900">Vite Dev Server</p>
            <p class="text-xs text-gray-500">Hot Module Reload</p>
          </div>
        </div>
        
        <div class="flex items-center">
          <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
          <div>
            <p class="text-sm font-medium text-gray-900">Storage</p>
            <p class="text-xs text-gray-500">Symlink Active</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue';
import { PhotoIcon } from '@heroicons/vue/24/outline';
import FileUpload from './common/FileUpload.vue';
import RichTextEditor from './common/RichTextEditor.vue';

const showNotification = inject('showNotification');

const uploadedFiles = ref([]);
const editorContent = ref('');
const testing = ref(false);
const apiResults = ref([]);

const handleUpload = (data) => {
  if (Array.isArray(data)) {
    uploadedFiles.value.push(...data);
  } else {
    uploadedFiles.value.push(data);
  }
  showNotification('success', 'Upload Successful', 'File uploaded and processed successfully!');
};

const handleError = (error) => {
  showNotification('error', 'Upload Error', error);
};

const handleEditorChange = (content) => {
  console.log('Editor content changed:', content);
};

const testDashboardAPI = async () => {
  testing.value = true;
  try {
    const response = await fetch('/api/admin/dashboard/stats');
    const data = await response.json();
    
    apiResults.value.push({
      id: Date.now(),
      endpoint: 'GET /api/admin/dashboard/stats',
      success: data.success,
      message: data.success ? 'Dashboard stats loaded successfully' : data.message
    });
  } catch (error) {
    apiResults.value.push({
      id: Date.now(),
      endpoint: 'GET /api/admin/dashboard/stats',
      success: false,
      message: `Error: ${error.message}`
    });
  } finally {
    testing.value = false;
  }
};

const testMediaAPI = async () => {
  testing.value = true;
  try {
    const response = await fetch('/api/admin/media/list?type=article&per_page=5');
    const data = await response.json();
    
    apiResults.value.push({
      id: Date.now(),
      endpoint: 'GET /api/admin/media/list',
      success: data.success,
      message: data.success ? `Found ${data.data.length} media files` : data.message
    });
  } catch (error) {
    apiResults.value.push({
      id: Date.now(),
      endpoint: 'GET /api/admin/media/list',
      success: false,
      message: `Error: ${error.message}`
    });
  } finally {
    testing.value = false;
  }
};

const testSystemStatus = async () => {
  testing.value = true;
  try {
    const response = await fetch('/api/admin/system-status');
    const data = await response.json();
    
    apiResults.value.push({
      id: Date.now(),
      endpoint: 'GET /api/admin/system-status',
      success: data.success,
      message: data.success ? 'System status check completed' : data.message
    });

    if (data.success && data.data) {
      // Add individual status checks
      Object.entries(data.data).forEach(([key, status]) => {
        let message = `${key.charAt(0).toUpperCase() + key.slice(1)}: `;
        if (typeof status === 'object' && status.status) {
          message += status.status;
        } else {
          message += 'OK';
        }
        
        apiResults.value.push({
          id: Date.now() + Math.random(),
          endpoint: `System ${key}`,
          success: true,
          message: message
        });
      });
    }
  } catch (error) {
    apiResults.value.push({
      id: Date.now(),
      endpoint: 'GET /api/admin/system-status',
      success: false,
      message: `Error: ${error.message}`
    });
  } finally {
    testing.value = false;
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