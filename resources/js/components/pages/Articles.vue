<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <section class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-gray-900 mb-4">Articles</h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Explore stories, insights and opportunities built to nurture your academic and professional growth
          </p>
        </div>
      </div>
    </section>

    <!-- Filters -->
    <section class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div class="flex flex-wrap items-center gap-2">
            <button
              @click="selectedCategory = ''"
              :class="selectedCategory === '' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
              class="px-4 py-2 rounded-lg text-sm font-medium transition-colors"
            >
              All Categories
            </button>
            <button
              v-for="category in categories"
              :key="category.id"
              @click="selectedCategory = category.slug"
              :class="selectedCategory === category.slug ? 'text-white' : 'text-gray-700 hover:opacity-80'"
              :style="selectedCategory === category.slug ? 
                { backgroundColor: category.color } : 
                { backgroundColor: category.color + '20', color: category.color }"
              class="px-4 py-2 rounded-lg text-sm font-medium transition-colors"
            >
              {{ category.name }}
            </button>
          </div>

          <div class="flex items-center gap-4">
            <ArticleSearch @search="handleSearch" />

            <select v-model="sortBy" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              <option value="newest">Newest First</option>
              <option value="oldest">Oldest First</option>
              <option value="popular">Most Popular</option>
            </select>
          </div>
        </div>
      </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" v-if="filteredArticles.length">
          <article 
            v-for="article in filteredArticles" 
            :key="article.id"
            class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
          >
            <div class="aspect-w-16 aspect-h-9">
              <img 
                :src="article.featured_image || '/images/placeholder-article.jpg'" 
                :alt="article.title"
                class="w-full h-48 object-cover"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center mb-3">
                <span 
                  class="inline-block px-3 py-1 text-xs font-medium rounded-full"
                  :style="{ backgroundColor: article.category?.color + '20', color: article.category?.color }"
                >
                  {{ article.category?.name }}
                </span>
                <span class="text-gray-500 text-sm ml-3">{{ formatDate(article.published_at) }}</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">{{ article.title }}</h3>
              <p class="text-gray-600 mb-4 line-clamp-3">{{ article.excerpt }}</p>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img 
                    :src="article.author?.avatar || '/images/default-avatar.jpg'" 
                    :alt="article.author?.name"
                    class="w-8 h-8 rounded-full mr-2"
                  />
                  <div>
                    <span class="text-sm text-gray-700 block">{{ article.author?.name }}</span>
                    <span class="text-xs text-gray-500">{{ article.read_time }} min read</span>
                  </div>
                </div>
                <div class="flex space-x-2">
                  <button 
                    @click="viewArticleDetail(article)"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                  >
                    View Detail
                  </button>
                  <router-link 
                    :to="'/articles/' + article.slug"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                  >
                    Read More
                  </router-link>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!-- No articles found -->
        <div v-else-if="!loading" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">No articles found</h3>
          <p class="mt-2 text-gray-500">Try adjusting your search or filter criteria.</p>
        </div>

        <!-- Loading State -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="i in 9" :key="i" class="bg-white rounded-xl shadow-sm overflow-hidden animate-pulse">
            <div class="bg-gray-300 h-48"></div>
            <div class="p-6">
              <div class="h-4 bg-gray-300 rounded mb-3"></div>
              <div class="h-6 bg-gray-300 rounded mb-3"></div>
              <div class="h-4 bg-gray-300 rounded mb-4"></div>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="w-8 h-8 bg-gray-300 rounded-full mr-2"></div>
                  <div>
                    <div class="h-4 bg-gray-300 rounded w-20 mb-1"></div>
                    <div class="h-3 bg-gray-300 rounded w-16"></div>
                  </div>
                </div>
                <div class="h-8 bg-gray-300 rounded w-20"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Load More -->
        <div v-if="!loading && filteredArticles.length > 0 && hasMore" class="text-center mt-12">
          <button 
            @click="loadMore"
            :disabled="loadingMore"
            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg"
          >
            <span v-if="!loadingMore" class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Load More Articles
            </span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading...
            </span>
          </button>
        </div>

        <!-- End of Articles Message -->
        <div v-if="!loading && filteredArticles.length > 0 && !hasMore" class="text-center mt-12">
          <div class="bg-gray-100 rounded-xl py-8 px-6">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">You've reached the end!</h3>
            <p class="text-gray-600">You've seen all available articles. Check back later for more content.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Article Detail Modal -->
    <div v-if="selectedArticle" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <div class="relative">
          <!-- Article Header -->
          <div class="relative h-64 overflow-hidden rounded-t-xl">
            <img 
              :src="selectedArticle.featured_image" 
              :alt="selectedArticle.title"
              class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <button 
              @click="selectedArticle = null"
              class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
            <div class="absolute bottom-6 left-6 right-6">
              <span 
                class="inline-block px-3 py-1 text-xs font-medium rounded-full mb-3"
                :style="{ backgroundColor: selectedArticle.category?.color + '40', color: selectedArticle.category?.color }"
              >
                {{ selectedArticle.category?.name }}
              </span>
              <h2 class="text-3xl font-bold text-white mb-2">{{ selectedArticle.title }}</h2>
              <div class="flex items-center text-white/90">
                <img 
                  :src="selectedArticle.author?.avatar || '/images/default-avatar.jpg'" 
                  :alt="selectedArticle.author?.name"
                  class="w-8 h-8 rounded-full mr-3"
                />
                <span class="mr-4">{{ selectedArticle.author?.name }}</span>
                <span class="mr-4">{{ formatDate(selectedArticle.published_at) }}</span>
                <span>{{ selectedArticle.read_time }} min read</span>
              </div>
            </div>
          </div>

          <!-- Article Content -->
          <div class="p-8">
            <div class="prose max-w-none">
              <p class="text-xl text-gray-600 mb-6 font-light leading-relaxed">{{ selectedArticle.excerpt }}</p>
              
              <!-- Article Stats -->
              <div class="flex items-center justify-between bg-gray-50 rounded-xl p-6 mb-8">
                <div class="flex items-center space-x-6">
                  <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ selectedArticle.views?.toLocaleString() || '0' }}</div>
                    <div class="text-sm text-gray-500">Views</div>
                  </div>
                  <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ selectedArticle.read_time }}</div>
                    <div class="text-sm text-gray-500">Min Read</div>
                  </div>
                  <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ Math.floor(Math.random() * 50) + 10 }}</div>
                    <div class="text-sm text-gray-500">Comments</div>
                  </div>
                </div>
                <div class="flex items-center space-x-2">
                  <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"/>
                    </svg>
                  </button>
                  <button class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                  </button>
                  <button class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Article Content -->
              <div class="space-y-6 text-gray-700 leading-relaxed">
                <p>This comprehensive article explores the various aspects of {{ selectedArticle.title.toLowerCase() }}. Our detailed analysis provides insights that will help you understand the key concepts and practical applications.</p>
                
                <p>Whether you're a student, professional, or simply curious about this topic, this article offers valuable perspectives and actionable advice that you can implement immediately.</p>
                
                <blockquote class="border-l-4 border-blue-500 pl-6 italic text-lg text-gray-600 bg-blue-50 p-4 rounded-r-lg">
                  "{{ selectedArticle.excerpt }}"
                </blockquote>
                
                <p>The research and insights presented here are based on current best practices and expert opinions in the field. We've compiled the most relevant and up-to-date information to ensure you get maximum value from your reading time.</p>
                
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-l-4 border-blue-500">
                  <h3 class="text-xl font-bold text-blue-900 mb-3">Key Takeaways</h3>
                  <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                      <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                      </svg>
                      Understanding the fundamental concepts is essential for success
                    </li>
                    <li class="flex items-start">
                      <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                      </svg>
                      Practical application of these principles yields real results
                    </li>
                    <li class="flex items-start">
                      <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                      </svg>
                      Continuous learning and adaptation are key to long-term success
                    </li>
                  </ul>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex items-center justify-center space-x-4 mt-8 pt-6 border-t">
                <router-link 
                  :to="'/articles/' + selectedArticle.slug"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors"
                >
                  Read Full Article
                </router-link>
                <button 
                  @click="selectedArticle = null"
                  class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-colors"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import ArticleSearch from '../common/ArticleSearch.vue';

const articles = ref([]);
const allArticles = ref([]);
const categories = ref([]);
const selectedCategory = ref('');
const searchQuery = ref('');
const sortBy = ref('newest');
const loading = ref(true);
const loadingMore = ref(false);
const hasMore = ref(true);
const currentPage = ref(1);
const articlesPerPage = 6;
const selectedArticle = ref(null);

const filteredArticles = computed(() => {
  let filtered = [...allArticles.value];

  // Filter by category
  if (selectedCategory.value) {
    filtered = filtered.filter(article => 
      article.category?.slug === selectedCategory.value
    );
  }

  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(article =>
      article.title.toLowerCase().includes(query) ||
      article.excerpt.toLowerCase().includes(query) ||
      article.author?.name.toLowerCase().includes(query)
    );
  }

  // Sort articles
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'oldest':
        return new Date(a.published_at) - new Date(b.published_at);
      case 'popular':
        return (b.views || 0) - (a.views || 0);
      case 'newest':
      default:
        return new Date(b.published_at) - new Date(a.published_at);
    }
  });

  // Apply pagination
  const totalArticles = filtered.length;
  const displayedCount = currentPage.value * articlesPerPage;
  hasMore.value = displayedCount < totalArticles;
  
  return filtered.slice(0, displayedCount);
});

const fetchArticles = async () => {
  try {
    loading.value = true;
    const response = await fetch('/api/v1/articles');
    if (response.ok) {
      const data = await response.json();
      allArticles.value = data.data; // Laravel pagination response format
    } else {
      console.error('Failed to fetch articles');
      // Keep mock data as fallback
      allArticles.value = getExtendedMockArticles();
    }
  } catch (error) {
    console.error('Error fetching articles:', error);
    allArticles.value = getExtendedMockArticles();
  } finally {
    loading.value = false;
  }
};

const fetchCategories = async () => {
  try {
    const response = await fetch('/api/v1/categories');
    if (response.ok) {
      categories.value = await response.json();
    } else {
      console.error('Failed to fetch categories');
      categories.value = getMockCategories();
    }
  } catch (error) {
    console.error('Error fetching categories:', error);
    categories.value = getMockCategories();
  }
};

const getExtendedMockArticles = () => {
  return [
    {
      id: 1,
      title: 'How to Prepare for Your First Job After Graduation',
      slug: 'how-to-prepare-first-job-graduation',
      excerpt: 'Graduating from university is a huge milestone, but it also means it\'s time to face the real world. Here are essential tips to prepare for your career journey.',
      featured_image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&h=400&fit=crop',
      published_at: '2024-03-15',
      views: 1250,
      read_time: 5,
      category: { id: 5, name: 'Career Advice', slug: 'career-advice', color: '#EF4444' },
      author: { name: 'Sarah Johnson', avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b494?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 2,
      title: 'The Future of Open Source Education',
      slug: 'future-open-source-education',
      excerpt: 'Exploring how open source technologies are revolutionizing the way we learn and teach in universities worldwide.',
      featured_image: 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=600&h=400&fit=crop',
      published_at: '2024-03-12',
      views: 890,
      read_time: 7,
      category: { id: 4, name: 'Technology', slug: 'technology', color: '#8B5CF6' },
      author: { name: 'Michael Chen', avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 3,
      title: 'Class of 2024: Dreams and Achievements',
      slug: 'class-2024-dreams-achievements',
      excerpt: 'Meet the outstanding graduates of 2024 and discover their inspiring stories of academic success and future aspirations.',
      featured_image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&h=400&fit=crop',
      published_at: '2024-03-10',
      views: 2100,
      read_time: 8,
      category: { id: 2, name: 'Student Stories', slug: 'student-stories', color: '#10B981' },
      author: { name: 'Dr. Emily Rodriguez', avatar: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 4,
      title: 'Mastering Time Management as a Student',
      slug: 'mastering-time-management-student',
      excerpt: 'Learn effective strategies to balance your academic workload, social life, and personal development.',
      featured_image: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop',
      published_at: '2024-03-08',
      views: 1450,
      read_time: 6,
      category: { id: 1, name: 'Academic Life', slug: 'academic-life', color: '#3B82F6' },
      author: { name: 'Alex Thompson', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 5,
      title: 'Innovation in Campus Sustainability',
      slug: 'innovation-campus-sustainability',
      excerpt: 'How our university is leading the way in environmental conservation and sustainable practices.',
      featured_image: 'https://images.unsplash.com/photo-1559548331-f9cb98001426?w=600&h=400&fit=crop',
      published_at: '2024-03-05',
      views: 780,
      read_time: 5,
      category: { id: 3, name: 'Campus Events', slug: 'campus-events', color: '#F59E0B' },
      author: { name: 'Green Team', avatar: 'https://images.unsplash.com/photo-1559548331-f9cb98001426?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 6,
      title: 'Alumni Spotlight: From Student to CEO',
      slug: 'alumni-spotlight-student-to-ceo',
      excerpt: 'Follow the inspiring journey of our alumnus who built a successful tech startup after graduation.',
      featured_image: 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop',
      published_at: '2024-03-02',
      views: 1890,
      read_time: 9,
      category: { id: 6, name: 'Alumni Success', slug: 'alumni-success', color: '#06B6D4' },
      author: { name: 'Alumni Office', avatar: 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 7,
      title: 'Research Excellence in Artificial Intelligence',
      slug: 'research-excellence-artificial-intelligence',
      excerpt: 'Discover groundbreaking AI research happening right here on our campus and its global impact.',
      featured_image: 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=600&h=400&fit=crop',
      published_at: '2024-02-28',
      views: 1120,
      read_time: 7,
      category: { id: 4, name: 'Technology', slug: 'technology', color: '#8B5CF6' },
      author: { name: 'Research Team', avatar: 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 8,
      title: 'Building Study Groups That Actually Work',
      slug: 'building-study-groups-that-work',
      excerpt: 'Tips and strategies for creating effective study groups that boost everyone\'s academic performance.',
      featured_image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop',
      published_at: '2024-02-25',
      views: 950,
      read_time: 4,
      category: { id: 1, name: 'Academic Life', slug: 'academic-life', color: '#3B82F6' },
      author: { name: 'Study Hub', avatar: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 9,
      title: 'International Exchange Programs: A World of Opportunities',
      slug: 'international-exchange-programs-opportunities',
      excerpt: 'Explore how our exchange programs open doors to global experiences and cultural understanding.',
      featured_image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=600&h=400&fit=crop',
      published_at: '2024-02-22',
      views: 1340,
      read_time: 6,
      category: { id: 2, name: 'Student Stories', slug: 'student-stories', color: '#10B981' },
      author: { name: 'International Office', avatar: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 10,
      title: 'Mental Health and Wellness on Campus',
      slug: 'mental-health-wellness-campus',
      excerpt: 'Understanding the importance of mental health and the resources available to support student wellbeing.',
      featured_image: 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=600&h=400&fit=crop',
      published_at: '2024-02-20',
      views: 1680,
      read_time: 8,
      category: { id: 1, name: 'Academic Life', slug: 'academic-life', color: '#3B82F6' },
      author: { name: 'Wellness Center', avatar: 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 11,
      title: 'Entrepreneurship Incubator Success Stories',
      slug: 'entrepreneurship-incubator-success-stories',
      excerpt: 'Meet the student entrepreneurs who turned their innovative ideas into successful businesses.',
      featured_image: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&h=400&fit=crop',
      published_at: '2024-02-18',
      views: 1230,
      read_time: 7,
      category: { id: 5, name: 'Career Advice', slug: 'career-advice', color: '#EF4444' },
      author: { name: 'Incubator Team', avatar: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=100&h=100&fit=crop&crop=face' }
    },
    {
      id: 12,
      title: 'The Science Behind Breakthrough Discoveries',
      slug: 'science-behind-breakthrough-discoveries',
      excerpt: 'Exploring cutting-edge research in our science departments and their potential real-world applications.',
      featured_image: 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=600&h=400&fit=crop',
      published_at: '2024-02-15',
      views: 890,
      read_time: 9,
      category: { id: 4, name: 'Technology', slug: 'technology', color: '#8B5CF6' },
      author: { name: 'Science Faculty', avatar: 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=100&h=100&fit=crop&crop=face' }
    }
  ];
};

const getMockCategories = () => {
  return [
    { id: 1, name: 'Academic Life', slug: 'academic-life', color: '#3B82F6' },
    { id: 2, name: 'Student Stories', slug: 'student-stories', color: '#10B981' },
    { id: 3, name: 'Campus Events', slug: 'campus-events', color: '#F59E0B' },
    { id: 4, name: 'Technology', slug: 'technology', color: '#8B5CF6' },
    { id: 5, name: 'Career Advice', slug: 'career-advice', color: '#EF4444' },
    { id: 6, name: 'Alumni Success', slug: 'alumni-success', color: '#06B6D4' }
  ];
};

const loadMore = async () => {
  if (!hasMore.value || loadingMore.value) return;
  
  loadingMore.value = true;
  
  // Simulate API call delay
  setTimeout(() => {
    currentPage.value++;
    loadingMore.value = false;
  }, 500);
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

const handleSearch = (query) => {
  searchQuery.value = query;
  currentPage.value = 1; // Reset pagination when searching
};

const viewArticleDetail = (article) => {
  selectedArticle.value = article;
};

// Reset pagination when filters change
watch([selectedCategory, sortBy], () => {
  currentPage.value = 1;
});

onMounted(() => {
  fetchArticles();
  fetchCategories();
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.aspect-w-16 {
  position: relative;
  padding-bottom: 56.25%;
}

.aspect-w-16 img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>