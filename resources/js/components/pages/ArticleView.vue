<template>
  <!-- Reading Progress Bar -->
  <ReadingProgress />
  
  <div class="min-h-screen bg-gray-50" v-if="article">
    <!-- Article Header -->
    <section class="relative bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
          <span 
            class="inline-block px-4 py-2 text-sm font-medium rounded-full mb-4"
            :style="{ backgroundColor: article.category?.color + '20', color: article.category?.color }"
          >
            {{ article.category?.name }}
          </span>
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">{{ article.title }}</h1>
          <p class="text-xl text-gray-600 mb-8">{{ article.excerpt }}</p>
          
          <div class="flex items-center justify-center space-x-6 text-gray-500">
            <div class="flex items-center">
              <img 
                :src="article.author?.avatar || '/images/default-avatar.jpg'" 
                :alt="article.author?.name"
                class="w-12 h-12 rounded-full mr-3"
              />
              <div class="text-left">
                <div class="font-medium text-gray-900">{{ article.author?.name }}</div>
                <div class="text-sm text-gray-500">{{ article.author?.position }}</div>
              </div>
            </div>
            <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
            <div class="text-sm">
              <div>{{ formatDate(article.published_at) }}</div>
              <div class="text-gray-400">{{ article.read_time }} min read</div>
            </div>
            <div class="hidden sm:block w-px h-8 bg-gray-300"></div>
            <div class="text-sm">
              <div>{{ article.views }} views</div>
            </div>
          </div>
        </div>

        <!-- Featured Image -->
        <div class="aspect-w-16 aspect-h-9 mb-12" v-if="article.featured_image">
          <img 
            :src="article.featured_image" 
            :alt="article.title"
            class="w-full h-96 object-cover rounded-xl"
          />
        </div>
      </div>
    </section>

    <!-- Article Content -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
          <!-- Main Content -->
          <div class="lg:col-span-3">
            <div class="prose prose-lg max-w-none">
              <div v-html="article.content"></div>
            </div>

            <!-- Article Gallery -->
            <div v-if="article.gallery_images && article.gallery_images.length" class="mt-12">
              <h3 class="text-2xl font-semibold text-gray-900 mb-6">Gallery</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                  v-for="(image, index) in article.gallery_images" 
                  :key="index"
                  class="aspect-w-16 aspect-h-9 cursor-pointer"
                  @click="openGallery(index)"
                >
                  <img 
                    :src="image.url" 
                    :alt="image.caption || `Gallery image ${index + 1}`"
                    class="w-full h-48 object-cover rounded-lg hover:opacity-90 transition-opacity"
                  />
                </div>
              </div>
            </div>

            <!-- Tags -->
            <div v-if="article.tags && article.tags.length" class="mt-12 pt-8 border-t">
              <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-600">Tags:</span>
                <span 
                  v-for="tag in article.tags" 
                  :key="tag"
                  class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm"
                >
                  {{ tag }}
                </span>
              </div>
            </div>

            <!-- Article Actions -->
            <div class="mt-12 pt-8 border-t">
              <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- Social Share -->
                <SocialShare 
                  :title="article.title" 
                  :description="article.excerpt" 
                  :url="currentUrl" 
                />
                
                <!-- Bookmark Button -->
                <BookmarkButton :article-id="article.id" />
              </div>
            </div>

            <!-- Article Rating -->
            <div class="mt-8">
              <ArticleRating :article-id="article.id" />
            </div>
          </div>

          <!-- Sidebar -->
          <div class="lg:col-span-1">
            <!-- Table of Contents -->
            <TableOfContents 
              :content-selector="'.prose'"
              :reading-time="article.read_time"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Author Bio -->
    <section class="py-12 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-50 rounded-xl p-8">
          <h3 class="text-xl font-semibold text-gray-900 mb-6">About the Author</h3>
          <div class="flex items-start space-x-6">
            <img 
              :src="article.author?.avatar || '/images/default-avatar.jpg'" 
              :alt="article.author?.name"
              class="w-20 h-20 rounded-full"
            />
            <div class="flex-1">
              <h4 class="text-lg font-medium text-gray-900">{{ article.author?.name }}</h4>
              <p class="text-gray-600 mb-2">{{ article.author?.position }}</p>
              <p class="text-gray-700">{{ article.author?.bio }}</p>
              <div v-if="article.author?.social_links" class="flex space-x-4 mt-4">
                <a 
                  v-for="(link, platform) in article.author.social_links" 
                  :key="platform"
                  :href="link"
                  target="_blank"
                  class="text-gray-400 hover:text-gray-600 transition-colors"
                >
                  {{ platform }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Related Articles -->
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-semibold text-gray-900 mb-8">Related Articles</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" v-if="relatedArticles.length">
          <article 
            v-for="relatedArticle in relatedArticles" 
            :key="relatedArticle.id"
            class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
          >
            <div class="aspect-w-16 aspect-h-9">
              <img 
                :src="relatedArticle.featured_image || '/images/placeholder-article.jpg'" 
                :alt="relatedArticle.title"
                class="w-full h-48 object-cover"
              />
            </div>
            <div class="p-6">
              <div class="flex items-center mb-2">
                <span 
                  class="inline-block px-3 py-1 text-xs font-medium rounded-full"
                  :style="{ backgroundColor: relatedArticle.category?.color + '20', color: relatedArticle.category?.color }"
                >
                  {{ relatedArticle.category?.name }}
                </span>
                <span class="text-gray-500 text-sm ml-3">{{ formatDate(relatedArticle.published_at) }}</span>
              </div>
              <h4 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ relatedArticle.title }}</h4>
              <p class="text-gray-600 mb-4 line-clamp-2">{{ relatedArticle.excerpt }}</p>
              <router-link 
                :to="'/articles/' + relatedArticle.slug"
                class="text-blue-600 hover:text-blue-800 font-medium text-sm"
              >
                Read More →
              </router-link>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Comments Section -->
    <section class="py-12">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <CommentSection :article-id="article.id" />
      </div>
    </section>

    <!-- Related Articles -->
    <section v-if="relatedArticles.length" class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <article 
            v-for="related in relatedArticles" 
            :key="related.id"
            class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
          >
            <router-link :to="`/articles/${related.slug}`">
              <img 
                :src="related.featured_image || '/images/placeholder-article.jpg'" 
                :alt="related.title"
                class="w-full h-48 object-cover"
              />
              <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                  {{ related.title }}
                </h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ related.excerpt }}</p>
                <div class="flex items-center justify-between text-sm text-gray-500">
                  <span>{{ related.author?.name }}</span>
                  <span>{{ related.read_time }} min read</span>
                </div>
              </div>
            </router-link>
          </article>
        </div>
      </div>
    </section>
  </div>

  <!-- Loading State -->
  <div v-else class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="text-center">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
      <p class="text-gray-600">Loading article...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import SocialShare from '../common/SocialShare.vue';
import BookmarkButton from '../common/BookmarkButton.vue';
import CommentSection from '../common/CommentSection.vue';
import ReadingProgress from '../common/ReadingProgress.vue';
import TableOfContents from '../common/TableOfContents.vue';
import ArticleRating from '../common/ArticleRating.vue';

const route = useRoute();
const relatedArticles = ref([]);
const article = ref(null);

const currentUrl = computed(() => {
  return window.location.href;
});

const props = defineProps({
  slug: {
    type: String,
    required: true
  }
});

const fetchArticle = async (slug) => {
  try {
    const response = await fetch(`/api/v1/articles/${slug}`);
    if (response.ok) {
      article.value = await response.json();
    } else {
      console.error('Failed to fetch article');
      // Keep mock data as fallback for demo
      const mockArticles = {
        'how-to-prepare-first-job-graduation': {
          id: 1,
          title: 'How to Prepare for Your First Job After Graduation',
          slug: 'how-to-prepare-first-job-graduation',
          excerpt: 'Graduating from university is a huge milestone, but it also means it\'s time to face the real world. Here are essential tips to prepare for your career journey.',
          content: `
            <p>Graduating from university is an exciting milestone, but it can also feel overwhelming as you prepare to enter the professional world. Here's a comprehensive guide to help you navigate this transition successfully.</p>
            
            <h2>1. Build a Strong Resume</h2>
            <p>Your resume is your first impression with potential employers. Make sure it highlights your education, internships, projects, and any relevant experience. Focus on achievements rather than just job duties.</p>
            
            <h2>2. Develop Your Professional Network</h2>
            <p>Networking is crucial in today's job market. Attend career fairs, join professional associations, and connect with alumni from your university. Don't forget to maintain relationships with professors who can serve as references.</p>
            
            <h2>3. Practice Your Interview Skills</h2>
            <p>Prepare for common interview questions and practice your responses. Research the companies you're interested in and be ready to explain why you want to work there specifically.</p>
            
            <h2>4. Consider Your Career Goals</h2>
            <p>Take time to reflect on what you want from your career. Are you looking for rapid advancement, work-life balance, or the opportunity to make a social impact? Understanding your priorities will help you make better job choices.</p>
            
            <p>Remember, your first job doesn't have to be perfect. It's a stepping stone to building your career and gaining valuable experience. Stay positive, be persistent, and don't be afraid to ask for help along the way.</p>
          `,
          featured_image: '/images/articles/job-preparation.jpg',
          published_at: '2024-03-15',
          views: 1250,
          read_time: 5,
          tags: ['Career', 'Graduation', 'Job Search', 'Professional Development'],
          category: { name: 'Career Advice', color: '#EF4444' },
          author: { 
            name: 'Sarah Johnson', 
            avatar: '/images/avatars/sarah.jpg',
            position: 'Student',
            bio: 'Computer Science major with a passion for web development and artificial intelligence. Currently working on my thesis about machine learning applications in education.',
            social_links: {
              twitter: 'https://twitter.com/sarahjohnson',
              linkedin: 'https://linkedin.com/in/sarahjohnson'
            }
          }
        }
      };
      article.value = mockArticles[slug] || null;
    }
  } catch (error) {
    console.error('Error fetching article:', error);
    article.value = null;
  }
};

const fetchRelatedArticles = async () => {
  try {
    if (article.value) {
      const response = await fetch(`/api/v1/articles/${article.value.slug}/related`);
      if (response.ok) {
        relatedArticles.value = await response.json();
      } else {
        // Mock related articles as fallback
        relatedArticles.value = [
          {
            id: 4,
            title: 'Building a Strong Portfolio: A Student\'s Guide',
            slug: 'building-strong-portfolio-guide',
            excerpt: 'Learn how to create an impressive portfolio that showcases your skills and stands out to potential employers.',
            featured_image: '/images/articles/portfolio-guide.jpg',
            published_at: '2024-03-08',
            category: { name: 'Career Advice', color: '#EF4444' }
          }
        ];
      }
    }
  } catch (error) {
    console.error('Error fetching related articles:', error);
  }
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

const openGallery = (index) => {
  // Implement gallery modal functionality
  console.log('Open gallery at index:', index);
};

const loadArticleData = async (slug) => {
  if (!slug) return;
  await fetchArticle(slug);
  await fetchRelatedArticles();
};

watch(
  () => props.slug || route.params.slug,
  (newSlug) => {
    if (newSlug) {
      loadArticleData(newSlug);
    }
  }
);

onMounted(() => {
  loadArticleData(props.slug || route.params.slug);
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
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

.prose {
  color: #374151;
  line-height: 1.75;
}

.prose h2 {
  color: #111827;
  font-weight: 700;
  font-size: 1.5em;
  margin-top: 2em;
  margin-bottom: 1em;
  line-height: 1.3333333;
}

.prose p {
  margin-top: 1.25em;
  margin-bottom: 1.25em;
}

.prose strong {
  color: #111827;
  font-weight: 600;
}
</style>