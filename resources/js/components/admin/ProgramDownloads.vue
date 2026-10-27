<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Program Downloads</h1>
        <p class="text-gray-600">Generate and manage program brochures and academic materials</p>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold mb-2">Program Brochures</h3>
            <p class="text-blue-100">Generate comprehensive program information</p>
          </div>
          <DocumentTextIcon class="h-12 w-12 opacity-80" />
        </div>
        <button
          @click="showBrochureGenerator = true"
          class="mt-4 bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition-colors w-full font-medium"
        >
          Generate Brochure
        </button>
      </div>

      <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold mb-2">Admission Guides</h3>
            <p class="text-green-100">Create admission requirement documents</p>
          </div>
          <AcademicCapIcon class="h-12 w-12 opacity-80" />
        </div>
        <button
          @click="generateAdmissionGuide"
          class="mt-4 bg-white text-green-600 px-4 py-2 rounded-md hover:bg-green-50 transition-colors w-full font-medium"
        >
          Generate Guide
        </button>
      </div>

      <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold mb-2">Course Catalogs</h3>
            <p class="text-purple-100">Comprehensive course listings and descriptions</p>
          </div>
          <BookOpenIcon class="h-12 w-12 opacity-80" />
        </div>
        <button
          @click="generateCourseCatalog"
          class="mt-4 bg-white text-purple-600 px-4 py-2 rounded-md hover:bg-purple-50 transition-colors w-full font-medium"
        >
          Generate Catalog
        </button>
      </div>
    </div>

    <!-- Download Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <ArrowDownTrayIcon class="h-8 w-8 text-blue-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Total Downloads</p>
            <p class="text-2xl font-semibold text-gray-900">{{ downloadStats.total }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <DocumentTextIcon class="h-8 w-8 text-green-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Brochures Generated</p>
            <p class="text-2xl font-semibold text-gray-900">{{ downloadStats.brochures }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <CalendarDaysIcon class="h-8 w-8 text-yellow-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">This Month</p>
            <p class="text-2xl font-semibold text-gray-900">{{ downloadStats.thisMonth }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <ChartBarSquareIcon class="h-8 w-8 text-indigo-500" />
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-500">Popular Program</p>
            <p class="text-sm font-semibold text-gray-900">Computer Science</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Available Programs -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Academic Programs</h3>
      </div>
      
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div 
            v-for="program in academicPrograms" 
            :key="program.id"
            class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer"
            @click="selectProgram(program)"
          >
            <div class="flex items-center justify-between mb-3">
              <h4 class="font-semibold text-gray-900">{{ program.name }}</h4>
              <span :class="['px-2 py-1 text-xs rounded-full', program.colorClass]">
                {{ program.type }}
              </span>
            </div>
            <p class="text-sm text-gray-600 mb-3">{{ program.department }}</p>
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-500">Duration: {{ program.duration }}</span>
              <button
                @click.stop="generateProgramBrochure(program)"
                class="text-blue-600 hover:text-blue-800 font-medium"
              >
                Generate
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Brochure Generator Modal -->
    <div v-if="showBrochureGenerator" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Program Brochure Generator</h3>
            <button
              @click="showBrochureGenerator = false"
              class="text-gray-400 hover:text-gray-600"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>
          
          <form @submit.prevent="generateBrochure" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select
                  v-model="brochureForm.department"
                  required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Select Department</option>
                  <option value="Computer Science & IT">Computer Science & IT</option>
                  <option value="Engineering">Engineering</option>
                  <option value="Business & Management">Business & Management</option>
                  <option value="Medicine & Health Sciences">Medicine & Health Sciences</option>
                  <option value="Natural Sciences">Natural Sciences</option>
                  <option value="Social Sciences">Social Sciences</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select
                  v-model="brochureForm.program"
                  required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Select Program</option>
                  <option v-for="program in filteredPrograms" :key="program" :value="program">
                    {{ program }}
                  </option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
              <div class="flex space-x-4">
                <label class="flex items-center">
                  <input v-model="brochureForm.format" type="radio" value="html" class="mr-2">
                  <span class="text-sm">HTML</span>
                </label>
                <label class="flex items-center">
                  <input v-model="brochureForm.format" type="radio" value="pdf" class="mr-2">
                  <span class="text-sm">PDF</span>
                </label>
              </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
              <button
                type="button"
                @click="showBrochureGenerator = false"
                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isGenerating"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition-colors"
              >
                <span v-if="isGenerating">Generating...</span>
                <span v-else>Generate Brochure</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Recent Downloads -->
    <div class="bg-white shadow rounded-lg">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Recent Downloads</h3>
      </div>
      
      <div class="p-6">
        <div class="space-y-3">
          <div 
            v-for="download in recentDownloads" 
            :key="download.id"
            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
          >
            <div class="flex items-center">
              <DocumentTextIcon class="h-8 w-8 text-blue-500 mr-3" />
              <div>
                <div class="font-medium text-gray-900">{{ download.title }}</div>
                <div class="text-sm text-gray-500">{{ download.department }} • {{ download.format.toUpperCase() }}</div>
              </div>
            </div>
            <div class="flex items-center space-x-3">
              <span class="text-sm text-gray-500">{{ download.downloadCount }} downloads</span>
              <span class="text-sm text-gray-400">{{ formatDate(download.createdAt) }}</span>
              <button
                @click="redownload(download)"
                class="text-blue-600 hover:text-blue-800"
              >
                <ArrowDownTrayIcon class="h-4 w-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import {
  DocumentTextIcon,
  AcademicCapIcon,
  BookOpenIcon,
  ArrowDownTrayIcon,
  CalendarDaysIcon,
  ChartBarSquareIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline';

const showBrochureGenerator = ref(false);
const isGenerating = ref(false);
const brochureForm = ref({
  department: '',
  program: '',
  format: 'html'
});

const downloadStats = ref({
  total: 1247,
  brochures: 456,
  thisMonth: 89
});

const academicPrograms = ref([
  {
    id: 1,
    name: 'BSc Computer Science',
    department: 'Computer Science & IT',
    duration: '4 years',
    type: 'Undergraduate',
    colorClass: 'bg-blue-100 text-blue-800'
  },
  {
    id: 2,
    name: 'MSc Computer Science',
    department: 'Computer Science & IT',
    duration: '2 years',
    type: 'Graduate',
    colorClass: 'bg-purple-100 text-purple-800'
  },
  {
    id: 3,
    name: 'BSc Civil Engineering',
    department: 'Engineering',
    duration: '5 years',
    type: 'Undergraduate',
    colorClass: 'bg-blue-100 text-blue-800'
  },
  {
    id: 4,
    name: 'MBA',
    department: 'Business & Management',
    duration: '2 years',
    type: 'Graduate',
    colorClass: 'bg-purple-100 text-purple-800'
  },
  {
    id: 5,
    name: 'Doctor of Medicine',
    department: 'Medicine & Health Sciences',
    duration: '6 years',
    type: 'Professional',
    colorClass: 'bg-red-100 text-red-800'
  },
  {
    id: 6,
    name: 'BSc Biology',
    department: 'Natural Sciences',
    duration: '4 years',
    type: 'Undergraduate',
    colorClass: 'bg-blue-100 text-blue-800'
  }
]);

const recentDownloads = ref([
  {
    id: 1,
    title: 'Computer Science Program Brochure',
    department: 'Computer Science & IT',
    format: 'pdf',
    downloadCount: 45,
    createdAt: '2024-10-12T10:30:00Z'
  },
  {
    id: 2,
    title: 'Engineering Admission Guide',
    department: 'Engineering',
    format: 'html',
    downloadCount: 32,
    createdAt: '2024-10-11T14:15:00Z'
  },
  {
    id: 3,
    title: 'Business Programs Catalog',
    department: 'Business & Management',
    format: 'pdf',
    downloadCount: 28,
    createdAt: '2024-10-10T09:45:00Z'
  }
]);

const programsByDepartment = {
  'Computer Science & IT': ['BSc Computer Science', 'MSc Computer Science', 'BSc Information Systems', 'BSc Software Engineering'],
  'Engineering': ['BSc Civil Engineering', 'BSc Mechanical Engineering', 'BSc Electrical Engineering', 'BSc Chemical Engineering'],
  'Business & Management': ['BSc Business Administration', 'MBA', 'BSc Marketing', 'BSc Accounting'],
  'Medicine & Health Sciences': ['Doctor of Medicine', 'BSc Nursing', 'BSc Pharmacy', 'BSc Public Health'],
  'Natural Sciences': ['BSc Biology', 'BSc Chemistry', 'BSc Physics', 'BSc Mathematics'],
  'Social Sciences': ['BSc Psychology', 'BSc Sociology', 'BSc Political Science', 'BSc Economics']
};

const filteredPrograms = computed(() => {
  return brochureForm.value.department ? programsByDepartment[brochureForm.value.department] || [] : [];
});

const selectProgram = (program) => {
  brochureForm.value.department = program.department;
  brochureForm.value.program = program.name;
  showBrochureGenerator.value = true;
};

const generateProgramBrochure = async (program) => {
  try {
    const response = await fetch('/api/admin/programs/download-brochure', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({
        department: program.department,
        program: program.name,
        format: 'html'
      })
    });

    if (response.ok) {
      const blob = await response.blob();
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `${program.name.replace(/\s+/g, '_')}_Brochure.html`;
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
      document.body.removeChild(a);
    } else {
      alert('Failed to generate brochure. Please try again.');
    }
  } catch (error) {
    console.error('Error generating brochure:', error);
    alert('Failed to generate brochure. Please try again.');
  }
};

const generateBrochure = async () => {
  if (!brochureForm.value.department || !brochureForm.value.program) {
    alert('Please select both department and program.');
    return;
  }

  isGenerating.value = true;
  
  try {
    const response = await fetch('/api/admin/programs/download-brochure', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(brochureForm.value)
    });

    if (response.ok) {
      const blob = await response.blob();
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `${brochureForm.value.program.replace(/\s+/g, '_')}_Brochure.${brochureForm.value.format === 'pdf' ? 'pdf' : 'html'}`;
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
      document.body.removeChild(a);
      
      showBrochureGenerator.value = false;
      
      // Reset form
      brochureForm.value = {
        department: '',
        program: '',
        format: 'html'
      };
    } else {
      alert('Failed to generate brochure. Please try again.');
    }
  } catch (error) {
    console.error('Error generating brochure:', error);
    alert('Failed to generate brochure. Please try again.');
  } finally {
    isGenerating.value = false;
  }
};

const generateAdmissionGuide = async () => {
  try {
    const response = await fetch('/api/admin/programs/download-brochure', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({
        department: 'Admissions',
        program: 'Undergraduate Admission Guide',
        format: 'html'
      })
    });

    if (response.ok) {
      const blob = await response.blob();
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'Admission_Guide.html';
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
      document.body.removeChild(a);
    } else {
      alert('Failed to generate admission guide. Please try again.');
    }
  } catch (error) {
    console.error('Error generating admission guide:', error);
    alert('Failed to generate admission guide. Please try again.');
  }
};

const generateCourseCatalog = async () => {
  try {
    const response = await fetch('/api/admin/programs/download-brochure', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify({
        department: 'Academic Affairs',
        program: 'Course Catalog',
        format: 'html'
      })
    });

    if (response.ok) {
      const blob = await response.blob();
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'Course_Catalog.html';
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
      document.body.removeChild(a);
    } else {
      alert('Failed to generate course catalog. Please try again.');
    }
  } catch (error) {
    console.error('Error generating course catalog:', error);
    alert('Failed to generate course catalog. Please try again.');
  }
};

const redownload = (download) => {
  // Mock redownload functionality
  alert(`Redownloading ${download.title}...`);
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

onMounted(() => {
  // Load any necessary data
});
</script>