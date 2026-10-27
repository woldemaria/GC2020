<template>
  <div class="space-y-6">
    <!-- Marketing Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
              </svg>
            </div>
          </div>
          <div class="ml-5 w-0 flex-1">
            <dl>
              <dt class="text-sm font-medium text-gray-500 truncate">Campaign Clicks</dt>
              <dd class="text-lg font-medium text-gray-900">{{ marketingStats.campaignClicks }}</dd>
            </dl>
          </div>
        </div>
        <div class="mt-3">
          <div class="text-sm">
            <span class="text-green-600 font-medium">+12%</span>
            <span class="text-gray-500">vs last week</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
              <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/>
              </svg>
            </div>
          </div>
          <div class="ml-5 w-0 flex-1">
            <dl>
              <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
              <dd class="text-lg font-medium text-gray-900">{{ marketingStats.conversionRate }}%</dd>
            </dl>
          </div>
        </div>
        <div class="mt-3">
          <div class="text-sm">
            <span class="text-green-600 font-medium">+3.2%</span>
            <span class="text-gray-500">vs last month</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
              <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
              </svg>
            </div>
          </div>
          <div class="ml-5 w-0 flex-1">
            <dl>
              <dt class="text-sm font-medium text-gray-500 truncate">Email Signups</dt>
              <dd class="text-lg font-medium text-gray-900">{{ marketingStats.emailSignups }}</dd>
            </dl>
          </div>
        </div>
        <div class="mt-3">
          <div class="text-sm">
            <span class="text-green-600 font-medium">+18%</span>
            <span class="text-gray-500">vs last week</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-orange-100 rounded-md flex items-center justify-center">
              <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
              </svg>
            </div>
          </div>
          <div class="ml-5 w-0 flex-1">
            <dl>
              <dt class="text-sm font-medium text-gray-500 truncate">Social Shares</dt>
              <dd class="text-lg font-medium text-gray-900">{{ marketingStats.socialShares }}</dd>
            </dl>
          </div>
        </div>
        <div class="mt-3">
          <div class="text-sm">
            <span class="text-green-600 font-medium">+25%</span>
            <span class="text-gray-500">vs last week</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Campaign Performance Chart -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Campaign Performance</h3>
        <div class="h-80 flex items-center justify-center bg-gray-50 rounded-lg">
          <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="mt-2 text-sm text-gray-500">Campaign analytics chart would be displayed here</p>
            <p class="text-xs text-gray-400">Integration with Chart.js or similar library needed</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Campaigns -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-medium text-gray-900">Active Marketing Campaigns</h3>
          <button 
            @click="showCreateCampaign = true"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            New Campaign
          </button>
        </div>
        
        <div class="space-y-4">
          <div 
            v-for="campaign in activeCampaigns"
            :key="campaign.id"
            class="border border-gray-200 rounded-lg p-4"
          >
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div 
                    :class="[
                      'w-3 h-3 rounded-full',
                      campaign.status === 'active' ? 'bg-green-400' :
                      campaign.status === 'paused' ? 'bg-yellow-400' : 'bg-red-400'
                    ]"
                  ></div>
                  <h4 class="text-sm font-medium text-gray-900">{{ campaign.name }}</h4>
                  <span 
                    :class="[
                      'px-2 py-1 text-xs font-medium rounded-full',
                      campaign.type === 'event' ? 'bg-purple-100 text-purple-800' :
                      campaign.type === 'enrollment' ? 'bg-blue-100 text-blue-800' :
                      'bg-green-100 text-green-800'
                    ]"
                  >
                    {{ campaign.type }}
                  </span>
                </div>
                <p class="mt-1 text-sm text-gray-500">{{ campaign.description }}</p>
                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                  <span>{{ campaign.impressions }} impressions</span>
                  <span>{{ campaign.clicks }} clicks</span>
                  <span>CTR: {{ campaign.ctr }}%</span>
                </div>
              </div>
              <div class="ml-4 flex items-center space-x-2">
                <button 
                  @click="editCampaign(campaign)"
                  class="text-gray-400 hover:text-gray-600"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                </button>
                <button 
                  @click="toggleCampaign(campaign)"
                  :class="[
                    'text-sm px-3 py-1 rounded-md font-medium',
                    campaign.status === 'active' 
                      ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' 
                      : 'bg-green-100 text-green-800 hover:bg-green-200'
                  ]"
                >
                  {{ campaign.status === 'active' ? 'Pause' : 'Resume' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Marketing Tools -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Email Marketing -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Email Marketing</h3>
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-900">Newsletter Subscribers</p>
              <p class="text-sm text-gray-500">{{ marketingStats.newsletterSubscribers }} active subscribers</p>
            </div>
            <button
              @click="sendEmailCampaign"
              class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium"
            >
              Send Campaign
            </button>
          </div>
          <div class="border-t pt-4">
            <p class="text-sm font-medium text-gray-900 mb-2">Recent Campaigns</p>
            <div class="space-y-2">
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Graduation Announcement</span>
                <span class="text-gray-500">87% open rate</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Course Registration Reminder</span>
                <span class="text-gray-500">92% open rate</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Engagement</h3>
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-3 bg-blue-50 rounded-lg">
              <p class="text-lg font-semibold text-blue-600">2,547</p>
              <p class="text-sm text-gray-600">Facebook Followers</p>
            </div>
            <div class="text-center p-3 bg-sky-50 rounded-lg">
              <p class="text-lg font-semibold text-sky-600">1,892</p>
              <p class="text-sm text-gray-600">Twitter Followers</p>
            </div>
            <div class="text-center p-3 bg-pink-50 rounded-lg">
              <p class="text-lg font-semibold text-pink-600">3,451</p>
              <p class="text-sm text-gray-600">Instagram Followers</p>
            </div>
            <div class="text-center p-3 bg-indigo-50 rounded-lg">
              <p class="text-lg font-semibold text-indigo-600">967</p>
              <p class="text-sm text-gray-600">LinkedIn Connections</p>
            </div>
          </div>
          <button
            @click="schedulePost"
            class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Schedule Post
          </button>
        </div>
      </div>
    </div>

    <!-- Create Campaign Modal -->
    <div v-if="showCreateCampaign" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-md w-full max-h-screen overflow-y-auto">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Create Marketing Campaign</h3>
            <button
              @click="showCreateCampaign = false"
              class="text-gray-400 hover:text-gray-600"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
          
          <form @submit.prevent="createCampaign" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Campaign Name</label>
              <input v-model="campaignForm.name" type="text" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select v-model="campaignForm.type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                  <option value="event">Event</option>
                  <option value="enrollment">Enrollment</option>
                  <option value="news">News</option>
                  <option value="community">Community</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Budget</label>
                <input v-model="campaignForm.budget" type="number" required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input v-model="campaignForm.start_date" type="date" required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input v-model="campaignForm.end_date" type="date" required
                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Target Audience</label>
              <input v-model="campaignForm.target_audience" type="text" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Platforms</label>
              <div class="grid grid-cols-2 gap-2">
                <label v-for="(p, idx) in ['facebook', 'twitter', 'instagram', 'linkedin']" :key="idx" class="flex items-center gap-2">
                  <input type="checkbox" :value="p" @change="updatePlatforms(p, $event.target.checked)" class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                  <span class="text-sm">{{ p }}</span>
                </label>
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
              <textarea v-model="campaignForm.content" rows="4" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4">
              <button type="button" @click="showCreateCampaign = false"
                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Cancel
              </button>
              <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Create Campaign
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const marketingStats = reactive({
  campaignClicks: '12,547',
  conversionRate: '8.4',
  emailSignups: '834',
  socialShares: '1,205',
  newsletterSubscribers: '5,672'
})

const activeCampaigns = ref([
  {
    id: 1,
    name: 'Graduation Ceremony 2025',
    type: 'event',
    status: 'active',
    description: 'Promoting graduation ceremony registration and attendance',
    impressions: '45,321',
    clicks: '2,847',
    ctr: '6.3'
  },
  {
    id: 2,
    name: 'Spring 2027 Enrollment',
    type: 'enrollment',
    status: 'active',
    description: 'Driving applications for upcoming semester',
    impressions: '32,156',
    clicks: '1,967',
    ctr: '6.1'
  },
  {
    id: 3,
    name: 'Alumni Network Expansion',
    type: 'community',
    status: 'paused',
    description: 'Growing alumni engagement and networking',
    impressions: '18,543',
    clicks: '892',
    ctr: '4.8'
  },
  {
    id: 4,
    name: 'AI & Data Science Programs',
    type: 'enrollment',
    status: 'active',
    description: 'Promoting new technology programs',
    impressions: '28,734',
    clicks: '2,341',
    ctr: '8.2'
  }
])

const showCreateCampaign = ref(false)
const campaignForm = reactive({
  name: '',
  type: 'event',
  description: '',
  budget: '',
  start_date: '',
  end_date: '',
  target_audience: '',
  platforms: [],
  content: ''
})

const createCampaign = async () => {
  if (!campaignForm.name || !campaignForm.description || !campaignForm.budget || !campaignForm.start_date || !campaignForm.end_date || !campaignForm.target_audience || campaignForm.platforms.length === 0 || !campaignForm.content) {
    alert('Please fill in all required fields.');
    return;
  }

  try {
    const response = await fetch('/api/admin/marketing/campaigns', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(campaignForm)
    });

    const data = await response.json();

    if (data.success) {
      activeCampaigns.value.push({
        id: data.campaign.id,
        name: campaignForm.name,
        type: campaignForm.type,
        status: 'draft',
        description: campaignForm.description,
        impressions: '0',
        clicks: '0',
        ctr: '0'
      });
      showCreateCampaign.value = false;
      Object.assign(campaignForm, {
        name: '', type: 'event', description: '', budget: '', start_date: '', end_date: '',
        target_audience: '', platforms: [], content: ''
      });
      showNotification('success', 'Success', 'Marketing campaign created successfully!');
    } else {
      alert(data.message || 'Failed to create campaign');
    }
  } catch (error) {
    console.error('Error creating campaign:', error);
    alert('Failed to create campaign. Please try again.');
  }
};

const editCampaign = (campaign) => {
  campaignForm.name = campaign.name
  campaignForm.type = campaign.type
  campaignForm.description = campaign.description
  showNotification('info', 'Edit Campaign', 'Edit campaign form would open here')
}

const toggleCampaign = (campaign) => {
  campaign.status = campaign.status === 'active' ? 'paused' : 'active'
}

const sendEmailCampaign = async () => {
  const templateId = prompt('Enter template ID (1-4):')
  if (!templateId) return

  const subject = prompt('Enter email subject:')
  if (!subject) return

  try {
    const response = await fetch('/api/admin/marketing/email-campaigns', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        template_id: parseInt(templateId),
        subject: subject,
        recipient_groups: ['all_students', 'alumni'],
        schedule_date: null
      })
    });

    const data = await response.json();

    if (data.success) {
      showNotification('success', 'Success', 'Email campaign scheduled successfully!');
    } else {
      alert(data.message || 'Failed to send campaign');
    }
  } catch (error) {
    console.error('Error sending campaign:', error);
    alert('Failed to send campaign. Please try again.');
  }
};

const schedulePost = () => {
  showNotification('info', 'Schedule Post', 'Social media post scheduling would open here');
}

const showNotification = (type, title, message) => {
  // Dispatch notification event to parent AdminApp
  const event = new CustomEvent('notification', { 
    detail: { type, title, message },
    bubbles: true 
  });
  window.dispatchEvent(event);
};

const updatePlatforms = (platform, checked) => {
  if (checked) {
    if (!campaignForm.platforms.includes(platform)) {
      campaignForm.platforms.push(platform);
    }
  } else {
    campaignForm.platforms = campaignForm.platforms.filter(p => p !== platform);
  }
};

onMounted(() => {
  console.log('Marketing Analytics loaded')
})
</script>