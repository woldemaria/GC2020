<template>
  <div class="space-y-6">
    <!-- Email Campaign Header -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Email Marketing</h1>
          <p class="text-gray-600">Create and manage promotional email campaigns</p>
        </div>
        <button 
          @click="createCampaign"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium"
        >
          New Campaign
        </button>
      </div>

      <!-- Quick Stats -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gray-50 rounded-lg p-4 text-center">
          <p class="text-2xl font-bold text-blue-600">5,672</p>
          <p class="text-sm text-gray-600">Total Subscribers</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
          <p class="text-2xl font-bold text-green-600">89.3%</p>
          <p class="text-sm text-gray-600">Average Open Rate</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
          <p class="text-2xl font-bold text-purple-600">12.7%</p>
          <p class="text-sm text-gray-600">Click-through Rate</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 text-center">
          <p class="text-2xl font-bold text-orange-600">247</p>
          <p class="text-sm text-gray-600">New This Week</p>
        </div>
      </div>
    </div>

    <!-- Email Templates -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Email Templates</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Welcome Email Template -->
          <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Welcome to GC University</h3>
              <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Active</span>
            </div>
            <div class="bg-gray-50 rounded-md p-3 mb-3 text-sm">
              <div class="font-medium text-blue-600">Welcome aboard!</div>
              <div class="text-gray-600 mt-1">Thank you for joining the GC University community...</div>
            </div>
            <div class="flex justify-between items-center text-sm text-gray-500">
              <span>91% Open Rate</span>
              <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
                <button class="text-gray-600 hover:text-gray-800">Preview</button>
              </div>
            </div>
          </div>

          <!-- Course Registration Template -->
          <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Course Registration Open</h3>
              <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Active</span>
            </div>
            <div class="bg-gray-50 rounded-md p-3 mb-3 text-sm">
              <div class="font-medium text-blue-600">🎓 Registration Now Open</div>
              <div class="text-gray-600 mt-1">Spring 2027 course registration is now available...</div>
            </div>
            <div class="flex justify-between items-center text-sm text-gray-500">
              <span>87% Open Rate</span>
              <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
                <button class="text-gray-600 hover:text-gray-800">Preview</button>
              </div>
            </div>
          </div>

          <!-- Event Invitation Template -->
          <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Graduation Ceremony</h3>
              <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Active</span>
            </div>
            <div class="bg-gray-50 rounded-md p-3 mb-3 text-sm">
              <div class="font-medium text-blue-600">🎓 You're Invited!</div>
              <div class="text-gray-600 mt-1">Join us for the graduation ceremony on July 26, 2025...</div>
            </div>
            <div class="flex justify-between items-center text-sm text-gray-500">
              <span>94% Open Rate</span>
              <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
                <button class="text-gray-600 hover:text-gray-800">Preview</button>
              </div>
            </div>
          </div>

          <!-- Newsletter Template -->
          <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Monthly Newsletter</h3>
              <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Active</span>
            </div>
            <div class="bg-gray-50 rounded-md p-3 mb-3 text-sm">
              <div class="font-medium text-blue-600">📰 GC University News</div>
              <div class="text-gray-600 mt-1">Stay updated with the latest news and achievements...</div>
            </div>
            <div class="flex justify-between items-center text-sm text-gray-500">
              <span>86% Open Rate</span>
              <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
                <button class="text-gray-600 hover:text-gray-800">Preview</button>
              </div>
            </div>
          </div>

          <!-- Alumni Update Template -->
          <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Alumni Network</h3>
              <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">Active</span>
            </div>
            <div class="bg-gray-50 rounded-md p-3 mb-3 text-sm">
              <div class="font-medium text-blue-600">🌟 Alumni Spotlight</div>
              <div class="text-gray-600 mt-1">Celebrating our successful graduates and their achievements...</div>
            </div>
            <div class="flex justify-between items-center text-sm text-gray-500">
              <span>82% Open Rate</span>
              <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
                <button class="text-gray-600 hover:text-gray-800">Preview</button>
              </div>
            </div>
          </div>

          <!-- Certificate Reminder Template -->
          <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Certificate Available</h3>
              <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Active</span>
            </div>
            <div class="bg-gray-50 rounded-md p-3 mb-3 text-sm">
              <div class="font-medium text-blue-600">📜 Your Certificate is Ready</div>
              <div class="text-gray-600 mt-1">Congratulations! Your certificate is now available for download...</div>
            </div>
            <div class="flex justify-between items-center text-sm text-gray-500">
              <span>95% Open Rate</span>
              <div class="space-x-2">
                <button class="text-blue-600 hover:text-blue-800">Edit</button>
                <button class="text-gray-600 hover:text-gray-800">Preview</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Campaigns -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Campaigns</h2>
        <div class="space-y-4">
          <div 
            v-for="campaign in recentCampaigns"
            :key="campaign.id"
            class="border border-gray-200 rounded-lg p-4"
          >
            <div class="flex items-center justify-between mb-2">
              <div>
                <h3 class="font-medium text-gray-900">{{ campaign.subject }}</h3>
                <p class="text-sm text-gray-600">{{ campaign.template }}</p>
              </div>
              <span 
                :class="[
                  'px-3 py-1 text-xs font-medium rounded-full',
                  campaign.status === 'sent' ? 'bg-green-100 text-green-800' :
                  campaign.status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                  campaign.status === 'draft' ? 'bg-gray-100 text-gray-800' :
                  'bg-red-100 text-red-800'
                ]"
              >
                {{ campaign.status }}
              </span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
              <div>
                <p class="text-gray-500">Recipients</p>
                <p class="font-medium">{{ campaign.recipients }}</p>
              </div>
              <div>
                <p class="text-gray-500">Open Rate</p>
                <p class="font-medium">{{ campaign.openRate }}%</p>
              </div>
              <div>
                <p class="text-gray-500">Click Rate</p>
                <p class="font-medium">{{ campaign.clickRate }}%</p>
              </div>
              <div>
                <p class="text-gray-500">Sent Date</p>
                <p class="font-medium">{{ campaign.sentDate }}</p>
              </div>
              <div class="flex space-x-2">
                <button class="text-blue-600 hover:text-blue-800">View</button>
                <button class="text-gray-600 hover:text-gray-800">Duplicate</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Subscriber Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Subscriber Growth -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Subscriber Growth</h3>
        <div class="space-y-3">
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">This Month</span>
            <span class="font-medium text-green-600">+247 subscribers</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Last Month</span>
            <span class="font-medium text-blue-600">+189 subscribers</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Unsubscribes</span>
            <span class="font-medium text-red-600">-23 this month</span>
          </div>
          <div class="pt-3 border-t">
            <div class="flex justify-between items-center">
              <span class="text-sm font-medium text-gray-900">Net Growth</span>
              <span class="font-bold text-green-600">+224 this month</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Top Performing Content -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Performing Content</h3>
        <div class="space-y-3">
          <div class="flex justify-between items-center">
            <div>
              <p class="font-medium text-gray-900">Graduation Announcement</p>
              <p class="text-sm text-gray-500">Event invitation</p>
            </div>
            <span class="font-medium text-green-600">94% open</span>
          </div>
          <div class="flex justify-between items-center">
            <div>
              <p class="font-medium text-gray-900">Course Registration</p>
              <p class="text-sm text-gray-500">Academic information</p>
            </div>
            <span class="font-medium text-blue-600">87% open</span>
          </div>
          <div class="flex justify-between items-center">
            <div>
              <p class="font-medium text-gray-900">Welcome Message</p>
              <p class="text-sm text-gray-500">New subscriber</p>
            </div>
            <span class="font-medium text-purple-600">91% open</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const recentCampaigns = ref([
  {
    id: 1,
    subject: 'Graduation Ceremony 2025 - You\'re Invited!',
    template: 'Event Invitation',
    status: 'sent',
    recipients: '5,672',
    openRate: '94',
    clickRate: '23',
    sentDate: 'Oct 14, 2026'
  },
  {
    id: 2,
    subject: 'Spring 2027 Course Registration Now Open',
    template: 'Course Registration',
    status: 'sent',
    recipients: '4,891',
    openRate: '87',
    clickRate: '18',
    sentDate: 'Oct 12, 2026'
  },
  {
    id: 3,
    subject: 'Monthly Newsletter - October 2026',
    template: 'Newsletter',
    status: 'scheduled',
    recipients: '5,672',
    openRate: '-',
    clickRate: '-',
    sentDate: 'Oct 20, 2026'
  },
  {
    id: 4,
    subject: 'Welcome to GC University Community',
    template: 'Welcome Email',
    status: 'sent',
    recipients: '247',
    openRate: '91',
    clickRate: '15',
    sentDate: 'Oct 13, 2026'
  }
])

const createCampaign = () => {
  console.log('Creating new email campaign...')
}
</script>