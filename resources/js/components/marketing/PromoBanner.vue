<template>
  <div v-if="currentBanner && !isBannerDismissed" class="relative">
    <!-- Announcement Banner -->
    <div 
      :class="[
        'text-white py-3 px-4 text-center relative overflow-hidden',
        currentBanner.type === 'urgent' ? 'bg-gradient-to-r from-red-600 to-red-700' :
        currentBanner.type === 'event' ? 'bg-gradient-to-r from-purple-600 to-blue-600' :
        currentBanner.type === 'news' ? 'bg-gradient-to-r from-green-600 to-blue-600' :
        'bg-gradient-to-r from-blue-600 to-indigo-600'
      ]"
    >
      <!-- Animated Background -->
      <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/40 to-white/0 transform -skew-x-12 animate-shimmer"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex-1 flex items-center justify-center text-sm lg:text-base">
          <!-- Icon -->
          <div class="mr-3 flex-shrink-0">
            <component 
              :is="currentBanner.icon" 
              class="w-5 h-5 animate-pulse"
              v-if="currentBanner.icon"
            />
            <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
          </div>
          
          <!-- Content -->
          <div class="flex items-center flex-wrap justify-center">
            <span class="font-medium mr-2">{{ currentBanner.title }}</span>
            <span class="hidden sm:inline">{{ currentBanner.description }}</span>
            
            <!-- Call-to-Action -->
            <router-link 
              v-if="currentBanner.ctaLink"
              :to="currentBanner.ctaLink"
              class="ml-3 bg-white/20 hover:bg-white/30 px-3 py-1 rounded-full text-sm font-semibold transition-all duration-200 backdrop-blur-sm border border-white/30"
            >
              {{ currentBanner.ctaText || 'Learn More' }} →
            </router-link>
          </div>
        </div>
        
        <!-- Dismiss Button -->
        <button
          @click="dismissBanner"
          class="ml-4 p-1 hover:bg-white/20 rounded-full transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>
    
    <!-- Progress Bar for Time-Limited Offers -->
    <div v-if="currentBanner.deadline" class="bg-white/20 h-1">
      <div 
        :class="[
          'h-full transition-all duration-1000 ease-linear',
          currentBanner.type === 'urgent' ? 'bg-yellow-300' : 'bg-white'
        ]"
        :style="{ width: timeProgress + '%' }"
      ></div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const isBannerDismissed = ref(false)
const currentTime = ref(new Date())

// Marketing banners configuration
const banners = [
  {
    id: 'graduation-2025',
    type: 'event',
    title: '🎓 Graduation Ceremony 2025',
    description: 'July 26, 2025 - Register now for the biggest celebration of the year!',
    ctaText: 'Register Now',
    ctaLink: '/',
    priority: 1,
    active: true,
    deadline: new Date('2025-07-26')
  },
  {
    id: 'application-deadline',
    type: 'urgent',
    title: '⚠️ Application Deadline Extended',
    description: 'Spring 2027 applications extended to November 30, 2026',
    ctaText: 'Apply Now',
    ctaLink: '/apply',
    priority: 2,
    active: true,
    deadline: new Date('2026-11-30')
  },
  {
    id: 'new-programs',
    type: 'news',
    title: '🚀 New AI & Data Science Programs',
    description: 'Cutting-edge programs now available for 2027 intake',
    ctaText: 'Explore Programs',
    ctaLink: '/departments',
    priority: 3,
    active: true
  },
  {
    id: 'alumni-network',
    type: 'info',
    title: '🌟 Join Our Global Alumni Network',
    description: '50,000+ graduates worldwide - Connect, network, and grow',
    ctaText: 'Join Network',
    ctaLink: '/alumni',
    priority: 4,
    active: true
  }
]

const currentBanner = computed(() => {
  // Get the highest priority active banner
  const activeBanners = banners
    .filter(banner => banner.active)
    .sort((a, b) => a.priority - b.priority)
  
  return activeBanners[0] || null
})

const timeProgress = computed(() => {
  if (!currentBanner.value?.deadline) return 0
  
  const now = currentTime.value.getTime()
  const deadline = currentBanner.value.deadline.getTime()
  const start = new Date('2026-10-15').getTime() // Campaign start date
  
  if (now >= deadline) return 100
  if (now <= start) return 0
  
  const total = deadline - start
  const elapsed = now - start
  
  return Math.min(100, Math.max(0, (elapsed / total) * 100))
})

const dismissBanner = () => {
  isBannerDismissed.value = true
  // Store in localStorage to remember dismissal
  if (currentBanner.value) {
    localStorage.setItem(`banner-dismissed-${currentBanner.value.id}`, 'true')
  }
}

onMounted(() => {
  // Check if banner was previously dismissed
  if (currentBanner.value) {
    const dismissed = localStorage.getItem(`banner-dismissed-${currentBanner.value.id}`)
    if (dismissed === 'true') {
      isBannerDismissed.value = true
    }
  }
  
  // Update time every minute for deadline tracking
  setInterval(() => {
    currentTime.value = new Date()
  }, 60000)
})
</script>

<style scoped>
@keyframes shimmer {
  0% { transform: translateX(-100%) skewX(-12deg); }
  100% { transform: translateX(200%) skewX(-12deg); }
}

.animate-shimmer {
  animation: shimmer 3s infinite linear;
}
</style>