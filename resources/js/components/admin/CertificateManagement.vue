<template>
  <div class="certificate-management">
    <!-- Header -->
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-2">Certificate Management</h2>
      <p class="text-gray-600">Manage university certificates and verification system</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <h3 class="text-sm font-medium text-gray-500">Total Certificates</h3>
        <p class="text-2xl font-bold text-gray-900">{{ stats.total_certificates || 0 }}</p>
      </div>
      <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <h3 class="text-sm font-medium text-gray-500">Active</h3>
        <p class="text-2xl font-bold text-green-600">{{ stats.active_certificates || 0 }}</p>
      </div>
      <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
        <h3 class="text-sm font-medium text-gray-500">Verifications Today</h3>
        <p class="text-2xl font-bold text-yellow-600">{{ stats.verifications_today || 0 }}</p>
      </div>
      <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
        <h3 class="text-sm font-medium text-gray-500">Total Verifications</h3>
        <p class="text-2xl font-bold text-purple-600">{{ stats.total_verifications || 0 }}</p>
      </div>
    </div>

    <!-- Actions Bar -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
      <div class="flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center space-x-4">
          <button
            @click="showCreateForm = true"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Certificate
          </button>
          
          <select v-model="filters.status" @change="loadCertificates" class="border border-gray-300 rounded-md px-3 py-2">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="revoked">Revoked</option>
            <option value="expired">Expired</option>
          </select>

          <input
            v-model="filters.search"
            @input="debounceSearch"
            placeholder="Search certificates..."
            class="border border-gray-300 rounded-md px-3 py-2 w-64"
          >
        </div>

        <div class="flex items-center space-x-2" v-if="selectedCertificates.length > 0">
          <span class="text-sm text-gray-600">{{ selectedCertificates.length }} selected</span>
          <button
            @click="bulkAction('activate')"
            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700"
          >
            Activate
          </button>
          <button
            @click="bulkAction('revoke')"
            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700"
          >
            Revoke
          </button>
          <button
            @click="bulkAction('delete')"
            class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <!-- Certificates Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                <input
                  type="checkbox"
                  @change="toggleSelectAll"
                  :checked="allSelected"
                  class="rounded border-gray-300"
                >
              </th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Certificate</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Graduate</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verifications</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="certificate in certificates" :key="certificate.id" class="hover:bg-gray-50">
              <td class="px-4 py-3">
                <input
                  type="checkbox"
                  :value="certificate.id"
                  v-model="selectedCertificates"
                  class="rounded border-gray-300"
                >
              </td>
              <td class="px-4 py-3">
                <div>
                  <p class="text-sm font-medium text-gray-900 font-mono">{{ certificate.certificate_number }}</p>
                  <p class="text-xs text-gray-500">{{ certificate.qualification }}</p>
                </div>
              </td>
              <td class="px-4 py-3">
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ certificate.graduate_name }}</p>
                  <p class="text-xs text-gray-500">ID: {{ certificate.student_id }}</p>
                </div>
              </td>
              <td class="px-4 py-3">
                <p class="text-sm text-gray-900">{{ certificate.department }}</p>
                <p class="text-xs text-gray-500">{{ certificate.program }}</p>
              </td>
              <td class="px-4 py-3">
                <span :class="getStatusClass(certificate.status)" class="px-2 py-1 text-xs rounded-full">
                  {{ certificate.status }}
                </span>
              </td>
              <td class="px-4 py-3">
                <p class="text-sm text-gray-900">{{ certificate.verification_count }}</p>
                <p class="text-xs text-gray-500" v-if="certificate.last_verified_at">
                  Last: {{ formatDate(certificate.last_verified_at) }}
                </p>
              </td>
              <td class="px-4 py-3">
                <div class="flex space-x-2">
                  <button
                    @click="viewCertificate(certificate)"
                    class="text-blue-600 hover:text-blue-800 text-sm"
                  >
                    View
                  </button>
                  <button
                    @click="editCertificate(certificate)"
                    class="text-green-600 hover:text-green-800 text-sm"
                  >
                    Edit
                  </button>
                  <button
                    @click="deleteCertificate(certificate)"
                    class="text-red-600 hover:text-red-800 text-sm"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="bg-gray-50 px-4 py-3 flex items-center justify-between" v-if="pagination.total > 0">
        <div class="text-sm text-gray-700">
          Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
        </div>
        <div class="flex space-x-2">
          <button
            @click="goToPage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            class="px-3 py-1 border border-gray-300 rounded text-sm disabled:opacity-50"
          >
            Previous
          </button>
          <button
            @click="goToPage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="px-3 py-1 border border-gray-300 rounded text-sm disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showCreateForm || editingCertificate" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">
            {{ editingCertificate ? 'Edit Certificate' : 'Create New Certificate' }}
          </h3>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="saveCertificate" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Graduate Name *</label>
              <input
                v-model="form.graduate_name"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Student ID *</label>
              <input
                v-model="form.student_id"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Qualification *</label>
              <input
                v-model="form.qualification"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Department *</label>
              <input
                v-model="form.department"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Program *</label>
              <input
                v-model="form.program"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Certificate Type *</label>
              <select
                v-model="form.certificate_type"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="">Select Type</option>
                <option value="diploma">Diploma</option>
                <option value="degree">Degree</option>
                <option value="masters">Masters</option>
                <option value="phd">PhD</option>
                <option value="certificate">Certificate</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Graduation Date *</label>
              <input
                v-model="form.graduation_date"
                type="date"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">GPA</label>
              <input
                v-model="form.gpa"
                type="number"
                step="0.01"
                min="0"
                max="4"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Honors</label>
              <input
                v-model="form.honors"
                type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Language *</label>
              <select
                v-model="form.language"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
                <option value="english">English</option>
                <option value="amharic">Amharic</option>
                <option value="both">Both</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Authorized By *</label>
              <input
                v-model="form.authorized_by"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Authorized Title *</label>
              <input
                v-model="form.authorized_title"
                type="text"
                required
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700">Additional Notes</label>
              <textarea
                v-model="form.additional_notes"
                rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
              ></textarea>
            </div>
          </div>

          <div class="flex justify-end space-x-4 pt-4">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="isSubmitting"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50"
            >
              <span v-if="isSubmitting">Saving...</span>
              <span v-else>{{ editingCertificate ? 'Update' : 'Create' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- View Modal -->
    <div v-if="viewingCertificate" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Certificate Details</h3>
          <button @click="viewingCertificate = null" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div v-if="viewingCertificate" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-500">Certificate Number</label>
              <p class="text-lg font-mono">{{ viewingCertificate.certificate_number }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Verification Code</label>
              <p class="text-lg font-mono">{{ viewingCertificate.verification_code }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Graduate Name</label>
              <p class="text-lg">{{ viewingCertificate.graduate_name }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Department</label>
              <p class="text-lg">{{ viewingCertificate.department }}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-500">Status</label>
              <span :class="getStatusClass(viewingCertificate.status)" class="px-2 py-1 text-sm rounded-full">
                {{ viewingCertificate.status }}
              </span>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-500">Verification Count</label>
              <p class="text-lg">{{ viewingCertificate.verification_count }}</p>
            </div>
            <div v-if="viewingCertificate.qr_code_path" class="space-y-2">
              <label class="block text-sm font-medium text-gray-500">QR Code (Scan to Verify)</label>
              <div class="flex items-center gap-3">
                <img :src="`/storage/${viewingCertificate.qr_code_path}`" alt="QR Code" class="w-32 h-32 border p-1 rounded bg-white shadow-sm">
                <div class="space-y-2">
                  <a
                    :href="`/verify-certificate/${viewingCertificate.verification_code}`"
                    target="_blank"
                    class="block text-xs text-blue-600 hover:underline font-semibold"
                  >
                    Open Public Verification &rarr;
                  </a>
                  <a
                    :href="`/storage/${viewingCertificate.qr_code_path}`"
                    :download="`qr-${viewingCertificate.verification_code}.svg`"
                    class="inline-block px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded"
                  >
                    Download QR Code
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'CertificateManagement',
  data() {
    return {
      certificates: [],
      stats: {},
      pagination: {},
      selectedCertificates: [],
      filters: {
        status: '',
        search: '',
        page: 1
      },
      showCreateForm: false,
      editingCertificate: null,
      viewingCertificate: null,
      isSubmitting: false,
      searchTimeout: null,
      form: {
        graduate_name: '',
        student_id: '',
        qualification: '',
        department: '',
        program: '',
        graduation_date: '',
        gpa: '',
        honors: '',
        certificate_type: '',
        language: 'english',
        additional_notes: '',
        authorized_by: '',
        authorized_title: ''
      }
    }
  },
  computed: {
    allSelected() {
      return this.certificates.length > 0 && this.selectedCertificates.length === this.certificates.length
    }
  },
  mounted() {
    this.loadCertificates()
    this.loadStats()
  },
  methods: {
    async loadCertificates() {
      try {
        const params = {
          page: this.filters.page,
          status: this.filters.status,
          search: this.filters.search
        }
        
        const response = await axios.get('/api/admin/certificates', { params })
        this.certificates = response.data.data
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          from: response.data.from,
          to: response.data.to,
          total: response.data.total
        }
      } catch (error) {
        console.error('Failed to load certificates:', error)
      }
    },

    async loadStats() {
      try {
        const response = await axios.get('/api/admin/certificates-stats')
        if (response.data.success) {
          this.stats = response.data.stats
        }
      } catch (error) {
        console.error('Failed to load stats:', error)
      }
    },

    debounceSearch() {
      clearTimeout(this.searchTimeout)
      this.searchTimeout = setTimeout(() => {
        this.filters.page = 1
        this.loadCertificates()
      }, 500)
    },

    goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.filters.page = page
        this.loadCertificates()
      }
    },

    toggleSelectAll() {
      if (this.allSelected) {
        this.selectedCertificates = []
      } else {
        this.selectedCertificates = this.certificates.map(cert => cert.id)
      }
    },

    async bulkAction(action) {
      if (!confirm(`Are you sure you want to ${action} ${this.selectedCertificates.length} certificates?`)) {
        return
      }

      try {
        await axios.post('/api/admin/certificates/bulk-action', {
          action,
          certificate_ids: this.selectedCertificates
        })
        
        this.selectedCertificates = []
        this.loadCertificates()
        this.loadStats()
      } catch (error) {
        console.error('Bulk action failed:', error)
        alert('Failed to perform bulk action')
      }
    },

    viewCertificate(certificate) {
      this.viewingCertificate = certificate
    },

    editCertificate(certificate) {
      this.editingCertificate = certificate
      Object.keys(this.form).forEach(key => {
        this.form[key] = certificate[key] || ''
      })
    },

    async deleteCertificate(certificate) {
      if (!confirm(`Are you sure you want to delete certificate ${certificate.certificate_number}?`)) {
        return
      }

      try {
        await axios.delete(`/api/admin/certificates/${certificate.id}`)
        this.loadCertificates()
        this.loadStats()
      } catch (error) {
        console.error('Failed to delete certificate:', error)
        alert('Failed to delete certificate')
      }
    },

    async saveCertificate() {
      this.isSubmitting = true
      
      try {
        if (this.editingCertificate) {
          await axios.put(`/api/admin/certificates/${this.editingCertificate.id}`, this.form)
        } else {
          await axios.post('/api/admin/certificates', this.form)
        }
        
        this.closeModal()
        this.loadCertificates()
        this.loadStats()
      } catch (error) {
        console.error('Failed to save certificate:', error)
        alert('Failed to save certificate')
      } finally {
        this.isSubmitting = false
      }
    },

    closeModal() {
      this.showCreateForm = false
      this.editingCertificate = null
      this.resetForm()
    },

    resetForm() {
      Object.keys(this.form).forEach(key => {
        this.form[key] = key === 'language' ? 'english' : ''
      })
    },

    getStatusClass(status) {
      const classes = {
        active: 'bg-green-100 text-green-800',
        revoked: 'bg-red-100 text-red-800',
        expired: 'bg-yellow-100 text-yellow-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },

    formatDate(date) {
      return new Date(date).toLocaleDateString()
    }
  }
}
</script>