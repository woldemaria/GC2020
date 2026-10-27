<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">News & Events</h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Stay updated with the latest happenings, announcements, and upcoming events at GC University
          </p>
        </div>
      </div>
    </section>

    <!-- Filter Tabs -->
    <section class="bg-white border-b sticky top-0 z-40">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex overflow-x-auto py-4 space-x-8">
          <button
            v-for="tab in filterTabs"
            :key="tab.key"
            @click="activeTab = tab.key"
            :class="[
              'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors',
              activeTab === tab.key 
                ? 'border-blue-500 text-blue-600' 
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            <span class="flex items-center">
              <component :is="tab.icon" class="w-5 h-5 mr-2" />
              {{ tab.label }}
            </span>
          </button>
        </div>
      </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
          <!-- Latest News -->
          <div v-if="activeTab === 'news' || activeTab === 'all'">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Latest News</h2>
            <div class="space-y-6">
              <article 
                v-for="article in filteredNews" 
                :key="article.id"
                class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden"
              >
                <div class="md:flex">
                  <div class="md:w-64 md:flex-shrink-0">
                    <img :src="article.image" :alt="article.title" class="w-full h-48 md:h-full object-cover">
                  </div>
                  <div class="p-6 flex-1">
                    <div class="flex items-center justify-between mb-2">
                      <span class="inline-block px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                        {{ article.category }}
                      </span>
                      <span class="text-sm text-gray-500">{{ formatDate(article.date) }}</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600 cursor-pointer">
                      {{ article.title }}
                    </h3>
                    <p class="text-gray-600 mb-4">{{ article.excerpt }}</p>
                    <div class="flex items-center justify-between">
                      <span class="text-sm text-gray-500">{{ article.author }}</span>
                      <button class="text-blue-600 hover:text-blue-800 font-medium">Read More →</button>
                    </div>
                  </div>
                </div>
              </article>
            </div>
          </div>

          <!-- Upcoming Events -->
          <div v-if="activeTab === 'events' || activeTab === 'all'" :class="activeTab === 'all' ? 'mt-12' : ''">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Upcoming Events</h2>
            <div class="grid gap-6">
              <div 
                v-for="event in filteredEvents" 
                :key="event.id"
                class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden"
              >
                <div class="relative">
                  <img :src="event.image" :alt="event.title" class="w-full h-48 object-cover">
                  <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-lg font-bold">
                    {{ event.month }} {{ event.day }}
                  </div>
                </div>
                <div class="p-6">
                  <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-gray-600">{{ event.date }} at {{ event.time }}</span>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ event.title }}</h3>
                  <p class="text-gray-600 mb-4">{{ event.description }}</p>
                  <div class="flex items-center justify-between">
                    <div class="flex items-center">
                      <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      </svg>
                      <span class="text-sm text-gray-600">{{ event.location }}</span>
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                      Register
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Announcements -->
          <div v-if="activeTab === 'announcements' || activeTab === 'all'" :class="activeTab === 'all' ? 'mt-12' : ''">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Important Announcements</h2>
            <div class="space-y-4">
              <div 
                v-for="announcement in announcements" 
                :key="announcement.id"
                class="bg-white rounded-lg shadow-sm p-6 border-l-4"
                :class="announcement.priority === 'high' ? 'border-red-500' : announcement.priority === 'medium' ? 'border-yellow-500' : 'border-blue-500'"
              >
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <div class="flex items-center mb-2">
                      <span 
                        class="inline-block px-2 py-1 text-xs font-bold rounded-full"
                        :class="announcement.priority === 'high' ? 'bg-red-100 text-red-800' : announcement.priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'"
                      >
                        {{ announcement.priority.toUpperCase() }}
                      </span>
                      <span class="ml-2 text-sm text-gray-500">{{ formatDate(announcement.date) }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ announcement.title }}</h3>
                    <p class="text-gray-600">{{ announcement.content }}</p>
                  </div>
                  <svg class="w-6 h-6 text-gray-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
          <!-- Quick Links -->
          <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
            <div class="space-y-3">
              <a v-for="link in quickLinks" :key="link.name" :href="link.url" class="flex items-center text-blue-600 hover:text-blue-800">
                <component :is="link.icon" class="w-5 h-5 mr-3" />
                {{ link.name }}
              </a>
            </div>
          </div>

          <!-- Event Calendar Widget -->
          <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Calendar</h3>
            <div class="text-center">
              <div class="bg-blue-600 text-white rounded-t-lg py-2 px-4 font-bold">
                {{ currentMonth }} {{ currentYear }}
              </div>
              <div class="border border-t-0 rounded-b-lg p-4">
                <div class="grid grid-cols-7 gap-1 text-sm">
                  <div v-for="day in ['S', 'M', 'T', 'W', 'T', 'F', 'S']" :key="day" class="font-semibold text-gray-600 p-2">
                    {{ day }}
                  </div>
                  <div v-for="date in calendarDates" :key="date" 
                       :class="['p-2 cursor-pointer hover:bg-blue-100 rounded', 
                               hasEvent(date) ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700']">
                    {{ date }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Newsletter Subscription -->
          <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
            <h3 class="text-lg font-semibold mb-4">Stay Updated</h3>
            <p class="text-blue-100 mb-4">Subscribe to our newsletter for the latest news and events.</p>
            <div class="flex">
              <input 
                type="email" 
                placeholder="Your email" 
                class="flex-1 px-3 py-2 rounded-l-md text-gray-900 focus:outline-none"
              >
              <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-r-md font-medium transition-colors">
                Subscribe
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('all')

const filterTabs = [
  { key: 'all', label: 'All', icon: 'ViewGridIcon' },
  { key: 'news', label: 'News', icon: 'NewspaperIcon' },
  { key: 'events', label: 'Events', icon: 'CalendarIcon' },
  { key: 'announcements', label: 'Announcements', icon: 'SpeakerphoneIcon' }
]

const newsArticles = ref([
  {
    id: 1,
    title: 'GC University Launches New AI Research Center',
    excerpt: 'The university inaugurates state-of-the-art artificial intelligence research facility to advance technological innovation.',
    image: 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=600&h=400&fit=crop',
    category: 'Research',
    author: 'Dr. Sarah Johnson',
    date: '2026-10-12'
  },
  {
    id: 2,
    title: 'Student Exchange Program Expands to 15 Countries',
    excerpt: 'GC University students can now participate in exchange programs across Europe, Asia, and the Americas.',
    image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&h=400&fit=crop',
    category: 'International',
    author: 'Prof. Michael Chen',
    date: '2026-10-10'
  },
  {
    id: 3,
    title: 'Campus Sustainability Initiative Wins National Award',
    excerpt: 'Our green campus project receives recognition for outstanding environmental conservation efforts.',
    image: 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&h=400&fit=crop',
    category: 'Environment',
    author: 'Dr. Elena Rodriguez',
    date: '2026-10-08'
  }
])

const events = ref([
  {
    id: 1,
    title: 'Annual Science Fair 2026',
    description: 'Showcase of innovative student research projects across all scientific disciplines.',
    image: 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=600&h=400&fit=crop',
    date: 'November 15, 2026',
    time: '9:00 AM - 5:00 PM',
    location: 'Main Auditorium',
    month: 'NOV',
    day: '15'
  },
  {
    id: 2,
    title: 'Career Fair 2026',
    description: 'Connect with leading employers and explore career opportunities in various industries.',
    image: 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=600&h=400&fit=crop',
    date: 'November 25, 2026',
    time: '10:00 AM - 4:00 PM',
    location: 'Sports Complex',
    month: 'NOV',
    day: '25'
  },
  {
    id: 3,
    title: 'Cultural Heritage Festival',
    description: 'Celebration of Ethiopian culture with traditional music, dance, and cuisine.',
    image: 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&h=400&fit=crop',
    date: 'December 5, 2026',
    time: '6:00 PM - 10:00 PM',
    location: 'Campus Grounds',
    month: 'DEC',
    day: '05'
  }
])

const announcements = ref([
  {
    id: 1,
    title: 'Registration Deadline Extension',
    content: 'The registration deadline for Spring 2027 semester has been extended to November 30, 2026.',
    priority: 'high',
    date: '2026-10-15'
  },
  {
    id: 2,
    title: 'Library Hours During Finals Week',
    content: 'The library will be open 24/7 during finals week (December 10-17) to support student studies.',
    priority: 'medium',
    date: '2026-10-14'
  },
  {
    id: 3,
    title: 'New Parking Regulations',
    content: 'Updated parking regulations will take effect November 1. Please review the new guidelines.',
    priority: 'low',
    date: '2026-10-13'
  }
])

const quickLinks = ref([
  { name: 'Academic Calendar', url: '#', icon: 'CalendarIcon' },
  { name: 'Student Portal', url: '#', icon: 'UserIcon' },
  { name: 'Library Resources', url: '#', icon: 'BookOpenIcon' },
  { name: 'Course Catalog', url: '#', icon: 'AcademicCapIcon' },
  { name: 'Campus Map', url: '#', icon: 'MapIcon' }
])

const currentMonth = ref('October')
const currentYear = ref(2026)
const calendarDates = ref([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31])

const filteredNews = computed(() => {
  return activeTab.value === 'all' || activeTab.value === 'news' ? newsArticles.value : []
})

const filteredEvents = computed(() => {
  return activeTab.value === 'all' || activeTab.value === 'events' ? events.value : []
})

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(dateString).toLocaleDateString('en-US', options)
}

const hasEvent = (date) => {
  // Simple logic to highlight dates with events
  return [15, 25, 5].includes(date)
}
</script>