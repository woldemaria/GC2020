<template>
  <div class="space-y-6">
    <!-- Social Media Overview -->
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Social Media Manager</h1>
          <p class="text-gray-600">Schedule posts and manage social media presence</p>
        </div>
        <button 
          @click="createPost"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium"
        >
          New Post
        </button>
      </div>

      <!-- Account Status -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-blue-50 rounded-lg p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-medium text-blue-900">Facebook</h3>
            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
          </div>
          <p class="text-2xl font-bold text-blue-600 mb-1">2,547</p>
          <p class="text-sm text-blue-700">Followers</p>
          <p class="text-xs text-blue-600 mt-2">+12% this month</p>
        </div>

        <div class="bg-sky-50 rounded-lg p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-medium text-sky-900">Twitter</h3>
            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
          </div>
          <p class="text-2xl font-bold text-sky-600 mb-1">1,892</p>
          <p class="text-sm text-sky-700">Followers</p>
          <p class="text-xs text-sky-600 mt-2">+8% this month</p>
        </div>

        <div class="bg-pink-50 rounded-lg p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-medium text-pink-900">Instagram</h3>
            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
          </div>
          <p class="text-2xl font-bold text-pink-600 mb-1">3,451</p>
          <p class="text-sm text-pink-700">Followers</p>
          <p class="text-xs text-pink-600 mt-2">+18% this month</p>
        </div>

        <div class="bg-indigo-50 rounded-lg p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="font-medium text-indigo-900">LinkedIn</h3>
            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
          </div>
          <p class="text-2xl font-bold text-indigo-600 mb-1">967</p>
          <p class="text-sm text-indigo-700">Connections</p>
          <p class="text-xs text-indigo-600 mt-2">+15% this month</p>
        </div>
      </div>
    </div>

    <!-- Scheduled Posts -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-gray-900">Scheduled Posts</h2>
          <div class="flex space-x-2">
            <select class="border border-gray-300 rounded-md px-3 py-2 text-sm">
              <option value="all">All Platforms</option>
              <option value="facebook">Facebook</option>
              <option value="twitter">Twitter</option>
              <option value="instagram">Instagram</option>
              <option value="linkedin">LinkedIn</option>
            </select>
          </div>
        </div>

        <div class="space-y-4">
          <div 
            v-for="post in scheduledPosts"
            :key="post.id"
            class="border border-gray-200 rounded-lg p-4"
          >
            <div class="flex items-start space-x-4">
              <!-- Post Preview -->
              <div class="flex-shrink-0">
                <img 
                  v-if="post.image"
                  :src="post.image" 
                  :alt="post.title"
                  class="w-16 h-16 object-cover rounded-lg"
                />
                <div v-else class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
              </div>

              <!-- Post Content -->
              <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2 mb-2">
                  <h3 class="font-medium text-gray-900">{{ post.title }}</h3>
                  <span 
                    v-for="platform in post.platforms"
                    :key="platform"
                    :class="[
                      'px-2 py-1 text-xs font-medium rounded-full',
                      platform === 'facebook' ? 'bg-blue-100 text-blue-800' :
                      platform === 'twitter' ? 'bg-sky-100 text-sky-800' :
                      platform === 'instagram' ? 'bg-pink-100 text-pink-800' :
                      platform === 'linkedin' ? 'bg-indigo-100 text-indigo-800' :
                      'bg-gray-100 text-gray-800'
                    ]"
                  >
                    {{ platform }}
                  </span>
                </div>
                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ post.content }}</p>
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ post.scheduledFor }}
                  </div>
                  <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ post.author }}
                  </div>
                  <span 
                    :class="[
                      'px-2 py-1 text-xs font-medium rounded-full',
                      post.status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                      post.status === 'published' ? 'bg-green-100 text-green-800' :
                      'bg-yellow-100 text-yellow-800'
                    ]"
                  >
                    {{ post.status }}
                  </span>
                </div>
              </div>

              <!-- Actions -->
              <div class="flex-shrink-0">
                <div class="flex items-center space-x-2">
                  <button 
                    @click="editPost(post)"
                    class="text-gray-400 hover:text-gray-600"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button 
                    @click="duplicatePost(post)"
                    class="text-gray-400 hover:text-gray-600"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                  </button>
                  <button 
                    @click="deletePost(post)"
                    class="text-red-400 hover:text-red-600"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Calendar -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-gray-900">Content Calendar</h2>
          <div class="flex items-center space-x-2">
            <button class="px-3 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50">
              Week
            </button>
            <button class="px-3 py-2 text-sm bg-blue-600 text-white rounded-md">
              Month
            </button>
          </div>
        </div>
        
        <!-- Simple Calendar Grid -->
        <div class="grid grid-cols-7 gap-1">
          <!-- Calendar Header -->
          <div v-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']" 
               :key="day"
               class="p-2 text-center text-sm font-medium text-gray-500 border-b">
            {{ day }}
          </div>
          
          <!-- Calendar Days -->
          <div v-for="date in calendarDays" 
               :key="date.date"
               :class="[
                 'min-h-24 p-2 border-b border-r',
                 date.isCurrentMonth ? 'bg-white' : 'bg-gray-50',
                 date.isToday ? 'bg-blue-50' : ''
               ]">
            <div class="text-sm font-medium text-gray-900 mb-1">{{ date.day }}</div>
            <div class="space-y-1">
              <div 
                v-for="post in date.posts" 
                :key="post.id"
                :class="[
                  'text-xs px-1 py-0.5 rounded truncate',
                  'bg-blue-100 text-blue-800'
                ]"
              >
                {{ post.title }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Analytics Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Engagement Metrics -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Engagement Metrics</h3>
        <div class="space-y-4">
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Average Engagement Rate</span>
            <span class="font-medium text-green-600">7.8%</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Total Likes</span>
            <span class="font-medium">2,547</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Total Comments</span>
            <span class="font-medium">892</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-600">Total Shares</span>
            <span class="font-medium">1,205</span>
          </div>
        </div>
      </div>

      <!-- Best Performing Posts -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Best Performing Posts</h3>
        <div class="space-y-4">
          <div class="border-l-4 border-green-400 pl-4">
            <p class="font-medium text-gray-900">Graduation Ceremony Announcement</p>
            <p class="text-sm text-gray-600">456 likes • 89 comments • 123 shares</p>
          </div>
          <div class="border-l-4 border-blue-400 pl-4">
            <p class="font-medium text-gray-900">New AI Program Launch</p>
            <p class="text-sm text-gray-600">387 likes • 67 comments • 98 shares</p>
          </div>
          <div class="border-l-4 border-purple-400 pl-4">
            <p class="font-medium text-gray-900">Student Achievement Spotlight</p>
            <p class="text-sm text-gray-600">324 likes • 45 comments • 76 shares</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'

const scheduledPosts = ref([
  {
    id: 1,
    title: 'Graduation Ceremony 2025 Registration Open',
    content: '🎓 Exciting news! Registration for our Graduation Ceremony 2025 is now open. Join us on July 26, 2025, for this momentous celebration. Register now to secure your spot! #GCUniversity #Graduation2025',
    image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
    platforms: ['facebook', 'twitter', 'instagram', 'linkedin'],
    scheduledFor: 'Oct 16, 2026 at 10:00 AM',
    author: 'Marketing Team',
    status: 'scheduled'
  },
  {
    id: 2,
    title: 'Spring 2027 Course Registration Now Open',
    content: '📚 Spring 2027 course registration is now live! Explore our new AI & Data Science programs and secure your academic future. Don\'t miss out on early bird discounts. #CourseRegistration #Spring2027',
    image: 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
    platforms: ['facebook', 'linkedin'],
    scheduledFor: 'Oct 17, 2026 at 2:00 PM',
    author: 'Academic Office',
    status: 'scheduled'
  },
  {
    id: 3,
    title: 'Student Achievement Spotlight',
    content: '🌟 Congratulations to Priya Sharma for winning the National AI Competition! Our students continue to excel and make us proud. #StudentSuccess #AICompetition #ProudMoments',
    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80',
    platforms: ['instagram', 'facebook', 'twitter'],
    scheduledFor: 'Oct 18, 2026 at 11:30 AM',
    author: 'Student Affairs',
    status: 'scheduled'
  },
  {
    id: 4,
    title: 'Alumni Network Expansion',
    content: '🤝 Join our growing global alumni network of 50,000+ graduates. Connect, network, and grow with fellow GC University alumni worldwide. #Alumni #Networking #GCCommunity',
    image: null,
    platforms: ['linkedin', 'facebook'],
    scheduledFor: 'Oct 19, 2026 at 9:00 AM',
    author: 'Alumni Relations',
    status: 'draft'
  }
])

// Generate calendar days (simplified)
const calendarDays = computed(() => {
  const days = []
  const today = new Date()
  const currentMonth = today.getMonth()
  const currentYear = today.getFullYear()
  
  // Generate 35 days (5 weeks) starting from first Sunday of the month
  for (let i = 1; i <= 35; i++) {
    const date = new Date(currentYear, currentMonth, i - 6) // Adjust for calendar grid
    const isCurrentMonth = date.getMonth() === currentMonth
    const isToday = date.toDateString() === today.toDateString()
    
    // Sample posts for demonstration
    const posts = i % 7 === 0 ? [
      { id: i, title: 'Weekly Update' }
    ] : i % 5 === 0 ? [
      { id: i, title: 'Student Feature' }
    ] : []
    
    days.push({
      date: date.toISOString().split('T')[0],
      day: date.getDate(),
      isCurrentMonth,
      isToday,
      posts
    })
  }
  
  return days
})

const createPost = () => {
  console.log('Creating new social media post...')
}

const editPost = (post) => {
  console.log('Editing post:', post.title)
}

const duplicatePost = (post) => {
  console.log('Duplicating post:', post.title)
}

const deletePost = (post) => {
  console.log('Deleting post:', post.title)
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>