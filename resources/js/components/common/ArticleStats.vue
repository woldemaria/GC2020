<template>
  <div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Article Statistics</h3>

    <!-- Loading State -->
    <div v-if="loading" class="animate-pulse space-y-4">
      <div class="h-4 bg-gray-300 rounded w-3/4"></div>
      <div class="h-20 bg-gray-300 rounded"></div>
      <div class="h-4 bg-gray-300 rounded w-1/2"></div>
    </div>

    <!-- Statistics Grid -->
    <div v-else class="space-y-6">
      <!-- Main Stats -->
      <div class="grid grid-cols-2 gap-4">
        <div class="text-center">
          <div class="text-2xl font-bold text-blue-600">{{ stats.totalViews.toLocaleString() }}</div>
          <div class="text-sm text-gray-500">Total Views</div>
        </div>
        <div class="text-center">
          <div class="text-2xl font-bold text-green-600">{{ stats.avgRating }}</div>
          <div class="text-sm text-gray-500">Avg Rating</div>
        </div>
      </div>

      <!-- Reading Stats -->
      <div class="border-t pt-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-gray-700">Reading Time</span>
          <span class="text-sm text-gray-500">{{ stats.readingTime }} min</span>
        </div>
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-gray-700">Comments</span>
          <span class="text-sm text-gray-500">{{ stats.commentsCount }}</span>
        </div>
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-gray-700">Bookmarks</span>
          <span class="text-sm text-gray-500">{{ stats.bookmarksCount }}</span>
        </div>
      </div>

      <!-- Engagement Rate -->
      <div class="border-t pt-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-gray-700">Engagement Rate</span>
          <span class="text-sm text-gray-500">{{ stats.engagementRate }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div
            :style="{ width: stats.engagementRate + '%' }"
            class="bg-blue-600 h-2 rounded-full transition-all duration-300"
          ></div>
        </div>
      </div>

      <!-- Views Trend (Simple representation) -->
      <div class="border-t pt-4">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-gray-700">Views Trend</span>
          <span class="text-sm text-gray-500">Last 7 days</span>
        </div>
        <div class="flex items-end space-x-1 h-12">
          <div
            v-for="(day, index) in stats.viewsTrend"
            :key="index"
            :style="{ height: (day / Math.max(...stats.viewsTrend) * 100) + '%' }"
            class="flex-1 bg-blue-200 rounded-t transition-all duration-300 hover:bg-blue-300"
            :title="`Day ${index + 1}: ${day} views`"
          ></div>
        </div>
      </div>

      <!-- Popular Times -->
      <div class="border-t pt-4">
        <span class="text-sm font-medium text-gray-700 block mb-2">Most Active Hours</span>
        <div class="grid grid-cols-4 gap-2 text-xs">
          <div
            v-for="hour in stats.popularHours"
            :key="hour.hour"
            class="text-center p-2 bg-gray-100 rounded"
          >
            <div class="font-medium">{{ hour.hour }}:00</div>
            <div class="text-gray-500">{{ hour.views }}</div>
          </div>
        </div>
      </div>

      <!-- Share Stats -->
      <div class="border-t pt-4">
        <span class="text-sm font-medium text-gray-700 block mb-3">Social Shares</span>
        <div class="space-y-2">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
              </svg>
              <span class="text-sm">Twitter</span>
            </div>
            <span class="text-sm text-gray-500">{{ stats.shares.twitter }}</span>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <svg class="w-4 h-4 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
              <span class="text-sm">Facebook</span>
            </div>
            <span class="text-sm text-gray-500">{{ stats.shares.facebook }}</span>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <svg class="w-4 h-4 text-blue-700 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
              <span class="text-sm">LinkedIn</span>
            </div>
            <span class="text-sm text-gray-500">{{ stats.shares.linkedin }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
  articleId: {
    type: Number,
    required: true
  }
});

const stats = ref({
  totalViews: 0,
  avgRating: 0,
  readingTime: 0,
  commentsCount: 0,
  bookmarksCount: 0,
  engagementRate: 0,
  viewsTrend: [15, 22, 18, 28, 35, 42, 38],
  popularHours: [
    { hour: 9, views: 45 },
    { hour: 14, views: 62 },
    { hour: 18, views: 38 },
    { hour: 21, views: 55 }
  ],
  shares: {
    twitter: 0,
    facebook: 0,
    linkedin: 0
  }
});

const loading = ref(true);

const fetchArticleStats = async () => {
  try {
    loading.value = true;
    
    // Fetch multiple API endpoints
    const [ratingResponse, commentsResponse] = await Promise.all([
      fetch(`/api/v1/articles/${props.articleId}/rating/stats`),
      fetch(`/api/v1/articles/${props.articleId}/comments/count`)
    ]);
    
    const ratingData = await ratingResponse.json();
    const commentsData = await commentsResponse.json();
    
    // Mock some additional stats (in real implementation, these would come from tracking)
    stats.value = {
      totalViews: Math.floor(Math.random() * 2000) + 500,
      avgRating: ratingData.stats?.average || 0,
      readingTime: Math.floor(Math.random() * 10) + 3,
      commentsCount: commentsData.count || 0,
      bookmarksCount: Math.floor(Math.random() * 50) + 10,
      engagementRate: Math.floor(Math.random() * 40) + 20,
      viewsTrend: Array.from({ length: 7 }, () => Math.floor(Math.random() * 50) + 10),
      popularHours: [
        { hour: 9, views: Math.floor(Math.random() * 50) + 20 },
        { hour: 14, views: Math.floor(Math.random() * 80) + 40 },
        { hour: 18, views: Math.floor(Math.random() * 60) + 30 },
        { hour: 21, views: Math.floor(Math.random() * 70) + 35 }
      ],
      shares: {
        twitter: Math.floor(Math.random() * 25) + 5,
        facebook: Math.floor(Math.random() * 40) + 10,
        linkedin: Math.floor(Math.random() * 15) + 3
      }
    };
    
  } catch (error) {
    console.error('Error fetching article stats:', error);
    // Keep default mock data
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchArticleStats();
});
</script>
</template>