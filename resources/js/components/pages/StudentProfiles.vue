<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Header -->
    <section class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
          <h1 class="text-5xl font-black mb-6 text-golden-300">Our Amazing Students</h1>
          <p class="text-2xl text-white/90 max-w-4xl mx-auto font-light">
            Meet our brilliant students - their stories, achievements, and dreams that inspire us all
          </p>
        </div>
      </div>
    </section>

    <!-- Class Photos Section -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-4xl font-bold text-gray-900 mb-4">Class of 2024 - Our Graduating Family</h2>
          <p class="text-xl text-gray-600">United in learning, bonded by friendship, destined for greatness</p>
        </div>
        
        <!-- Class Group Photos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
          <!-- Computer Science Class -->
          <div class="relative group overflow-hidden rounded-3xl shadow-2xl">
            <img 
              src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&crop=faces"
              alt="Computer Science Class of 2024"
              class="w-full h-96 object-cover group-hover:scale-110 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
              <h3 class="text-2xl font-bold mb-2">Computer Science Class 2024</h3>
              <p class="text-lg opacity-90">24 brilliant minds ready to code the future</p>
              <div class="flex items-center mt-3">
                <svg class="w-5 h-5 text-golden-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span class="text-golden-300 font-semibold">24 Students</span>
              </div>
            </div>
          </div>

          <!-- Engineering Class -->
          <div class="relative group overflow-hidden rounded-3xl shadow-2xl">
            <img 
              src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800&h=600&fit=crop&crop=faces"
              alt="Engineering Class of 2024"
              class="w-full h-96 object-cover group-hover:scale-110 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-green-900/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
              <h3 class="text-2xl font-bold mb-2">Engineering Class 2024</h3>
              <p class="text-lg opacity-90">Engineers building tomorrow's world</p>
              <div class="flex items-center mt-3">
                <svg class="w-5 h-5 text-golden-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span class="text-golden-300 font-semibold">18 Students</span>
              </div>
            </div>
          </div>

          <!-- Business Class -->
          <div class="relative group overflow-hidden rounded-3xl shadow-2xl">
            <img 
              src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&h=600&fit=crop&crop=faces"
              alt="Business Class of 2024"
              class="w-full h-96 object-cover group-hover:scale-110 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
              <h3 class="text-2xl font-bold mb-2">Business Administration 2024</h3>
              <p class="text-lg opacity-90">Future leaders and entrepreneurs</p>
              <div class="flex items-center mt-3">
                <svg class="w-5 h-5 text-golden-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span class="text-golden-300 font-semibold">32 Students</span>
              </div>
            </div>
          </div>

          <!-- Mixed Graduation Ceremony -->
          <div class="relative group overflow-hidden rounded-3xl shadow-2xl">
            <img 
              src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&h=600&fit=crop&crop=faces"
              alt="Graduation Ceremony 2024"
              class="w-full h-96 object-cover group-hover:scale-110 transition-transform duration-700"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
              <h3 class="text-2xl font-bold mb-2">Graduation Ceremony 2024</h3>
              <p class="text-lg opacity-90">A celebration of achievements and dreams</p>
              <div class="flex items-center mt-3">
                <svg class="w-5 h-5 text-golden-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span class="text-golden-300 font-semibold">156 Graduates</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Filters -->
    <section class="bg-gradient-to-r from-blue-100 to-indigo-100 border-b-2 border-golden-300">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-wrap items-center justify-between gap-6">
          <div class="flex flex-wrap items-center gap-3">
            <button
              @click="selectedMajor = ''"
              :class="selectedMajor === '' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-xl scale-105' : 'bg-white text-gray-700 hover:bg-blue-50 shadow-md'"
              class="px-6 py-3 rounded-xl text-lg font-bold transition-all duration-300 border-2 border-blue-200"
            >
              All Majors
            </button>
            <button
              v-for="major in majors"
              :key="major"
              @click="selectedMajor = major"
              :class="selectedMajor === major ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-xl scale-105' : 'bg-white text-gray-700 hover:bg-blue-50 shadow-md'"
              class="px-6 py-3 rounded-xl text-lg font-bold transition-all duration-300 border-2 border-blue-200"
            >
              {{ major }}
            </button>
          </div>

          <div class="flex items-center gap-6">
            <select v-model="selectedYear" class="border-2 border-blue-200 bg-white rounded-xl px-6 py-3 text-lg font-semibold focus:ring-4 focus:ring-blue-300 focus:border-blue-500 shadow-md">
              <option value="">All Years</option>
              <option value="2024">Class of 2024</option>
              <option value="2025">Class of 2025</option>
              <option value="2026">Class of 2026</option>
              <option value="2027">Class of 2027</option>
            </select>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Profiles -->
    <section class="py-16" v-if="featuredProfiles.length">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
          <h2 class="text-xl font-medium text-gray-900 mb-2">Featured Student Stars</h2>
          <p class="text-base text-gray-600">Outstanding achievers who inspire us all</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <div 
            v-for="profile in featuredProfiles" 
            :key="profile.id"
            class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:scale-102 border border-gray-200"
          >
            <div class="md:flex h-full">
              <div class="md:w-56 md:flex-shrink-0 relative">
                <img 
                  :src="profile.unsplash_photo || profile.avatar || getUnsplashPhoto(profile.major)" 
                  :alt="profile.name"
                  class="w-full h-64 md:h-full object-cover"
                  loading="lazy"
                />
                <!-- Heart Overlay -->
                <div class="absolute top-3 right-3 bg-red-500 p-2 rounded-full shadow-md animate-pulse">
                  <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                  </svg>
                </div>
                <!-- Featured Badge -->
                <div class="absolute top-3 left-3 bg-gradient-to-r from-golden-400 to-yellow-500 px-3 py-1 rounded-full shadow-md">
                  <span class="text-blue-900 font-bold text-xs">⭐ FEATURED</span>
                </div>
              </div>
              <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                  <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xl font-bold text-gray-900">{{ profile.name }}</h3>
                    <div class="flex items-center text-golden-500">
                      <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <span class="font-semibold text-sm">{{ profile.gpa }}</span>
                    </div>
                  </div>
                  <p class="text-blue-600 font-semibold mb-2">{{ profile.major }} • Class of {{ profile.graduation_year }}</p>
                  
                  <!-- Student Motto with Heart -->
                  <div class="bg-gradient-to-r from-pink-50 to-red-50 p-4 rounded-2xl mb-6 border-l-4 border-red-400">
                    <div class="flex items-start">
                      <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                      </svg>
                      <div>
                        <p class="text-sm text-gray-500 font-medium">Personal Motto:</p>
                        <p class="text-gray-800 font-medium italic">"{{ profile.motto || getRandomMotto() }}"</p>
                      </div>
                    </div>
                  </div>
                  
                  <p class="text-gray-700 mb-6 leading-relaxed">{{ profile.bio }}</p>
                </div>

                <!-- Bottom Section -->
                <div>
                  <!-- Like/Dislike and Comments -->
                  <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center justify-between mb-4">
                      <div class="flex items-center space-x-4">
                        <button 
                          @click="likeProfile(profile)"
                          :class="profile.userLiked ? 'bg-red-500 text-white' : 'bg-white border-2 border-red-400 text-red-500 hover:bg-red-500 hover:text-white'"
                          class="flex items-center px-3 py-2 rounded-lg transition-all duration-300"
                        >
                          <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                          </svg>
                          {{ profile.likes || 0 }}
                        </button>
                        <button 
                          @click="dislikeProfile(profile)"
                          :class="profile.userDisliked ? 'bg-gray-500 text-white' : 'bg-white border-2 border-gray-400 text-gray-500 hover:bg-gray-500 hover:text-white'"
                          class="flex items-center px-3 py-2 rounded-lg transition-all duration-300"
                        >
                          <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 113 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.057 2H5.641a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                          </svg>
                          {{ profile.dislikes || 0 }}
                        </button>
                      </div>
                      <button 
                        @click="toggleComments(profile.id)"
                        class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                      >
                        {{ profile.showComments ? 'Hide Comments' : 'Show Comments' }} ({{ profile.comments?.length || 0 }})
                      </button>
                    </div>
                    
                    <!-- Comments Section -->
                    <div v-if="profile.showComments" class="space-y-3">
                      <div class="flex space-x-3">
                        <textarea 
                          v-model="profile.newComment"
                          placeholder="Add a comment about this student..."
                          class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                          rows="2"
                        ></textarea>
                        <button 
                          @click="addComment(profile)"
                          :disabled="!profile.newComment?.trim()"
                          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                          Post
                        </button>
                      </div>
                      
                      <!-- Display Comments -->
                      <div v-if="profile.comments && profile.comments.length" class="space-y-2 max-h-32 overflow-y-auto">
                        <div 
                          v-for="comment in profile.comments" 
                          :key="comment.id"
                          class="bg-white p-3 rounded border text-sm"
                        >
                          <div class="flex items-center justify-between mb-1">
                            <span class="font-medium text-gray-900">{{ comment.author }}</span>
                            <span class="text-xs text-gray-500">{{ comment.date }}</span>
                          </div>
                          <p class="text-gray-700">{{ comment.text }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Achievements -->
                  <div v-if="profile.achievements && profile.achievements.length" class="mb-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                      <svg class="w-5 h-5 text-golden-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      Key Achievements
                    </h4>
                    <div class="flex flex-wrap gap-2">
                      <span 
                        v-for="achievement in profile.achievements.slice(0, 4)" 
                        :key="achievement"
                        class="bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 px-3 py-2 rounded-xl text-sm font-medium border border-green-200"
                      >
                        🏆 {{ achievement }}
                      </span>
                      <span 
                        v-if="profile.achievements.length > 4"
                        class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600 px-3 py-2 rounded-xl text-sm font-medium"
                      >
                        +{{ profile.achievements.length - 4 }} more
                      </span>
                    </div>
                  </div>

                  <!-- Social Links -->
                  <div v-if="profile.social_links" class="flex space-x-4">
                    <a 
                      v-for="(link, platform) in profile.social_links" 
                      :key="platform"
                      :href="link"
                      target="_blank"
                      class="text-gray-400 hover:text-blue-600 transition-colors transform hover:scale-110"
                    >
                      <span class="sr-only">{{ platform }}</span>
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path v-if="platform === 'linkedin'" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        <path v-else-if="platform === 'github'" d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        <path v-else-if="platform === 'twitter'" d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- All Profiles Grid -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-blue-50 border-t-4 border-golden-300">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
          <h2 class="text-xl font-medium text-gray-900 mb-2">All Our Amazing Students</h2>
          <p class="text-base text-gray-600">Every student has a unique story and inspiring journey</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" v-if="filteredProfiles.length">
          <div 
            v-for="profile in filteredProfiles" 
            :key="profile.id"
            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:scale-102 border border-gray-100 hover:border-blue-200"
          >
            <div class="relative">
              <img 
                :src="profile.unsplash_photo || profile.avatar || getUnsplashPhoto(profile.major)" 
                :alt="profile.name"
                class="w-full h-48 object-cover"
                loading="lazy"
              />
              <!-- Heart Overlay -->
              <div class="absolute top-3 right-3 bg-red-500 p-1.5 rounded-full shadow-md animate-pulse">
                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
              </div>
              <!-- GPA Badge -->
              <div v-if="profile.gpa" class="absolute top-3 left-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-2 py-1 rounded-full shadow-md">
                <span class="text-xs font-bold">GPA: {{ profile.gpa }}</span>
              </div>
            </div>
            
            <div class="p-5 text-center">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ profile.name }}</h3>
              <p class="text-blue-600 font-semibold text-sm mb-1">{{ profile.major }}</p>
              <p class="text-gray-500 text-sm mb-4">Class of {{ profile.graduation_year }}</p>
              
              <!-- Student Motto with Heart -->
              <div class="bg-gradient-to-r from-pink-50 to-red-50 p-3 rounded-xl mb-4 border-l-4 border-red-400">
                <div class="flex items-center justify-center mb-2">
                  <svg class="w-4 h-4 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                  </svg>
                  <span class="text-xs text-gray-500 font-medium">Personal Motto</span>
                </div>
                <p class="text-gray-800 text-sm font-medium italic">"{{ profile.motto || getRandomMotto() }}"</p>
              </div>
              
              <p class="text-gray-700 text-sm line-clamp-3 mb-4 leading-relaxed">{{ profile.bio }}</p>
              
              <!-- Quick stats -->
              <div class="grid grid-cols-3 gap-3 text-center mb-4">
                <div class="bg-blue-50 p-2 rounded-lg">
                  <div class="text-lg font-bold text-blue-600">{{ profile.achievements?.length || 0 }}</div>
                  <div class="text-xs text-gray-500">Awards</div>
                </div>
                <div class="bg-green-50 p-2 rounded-lg">
                  <div class="text-lg font-bold text-green-600">{{ profile.interests?.length || 0 }}</div>
                  <div class="text-xs text-gray-500">Interests</div>
                </div>
                <div class="bg-purple-50 p-2 rounded-lg">
                  <div class="text-lg font-bold text-purple-600">{{ profile.graduation_year }}</div>
                  <div class="text-xs text-gray-500">Class</div>
                </div>
              </div>
              
              <!-- Social Links -->
              <div v-if="profile.social_links" class="flex justify-center space-x-3 mb-4">
                <a 
                  v-for="(link, platform) in profile.social_links" 
                  :key="platform"
                  :href="link"
                  target="_blank"
                  class="text-gray-400 hover:text-blue-600 transition-colors transform hover:scale-110"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path v-if="platform === 'linkedin'" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    <path v-else-if="platform === 'github'" d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    <path v-else-if="platform === 'twitter'" d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                  </svg>
                </a>
              </div>

              <!-- Like/Dislike and Comments -->
              <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex items-center justify-between mb-3">
                  <div class="flex items-center space-x-2">
                    <button 
                      @click="likeProfile(profile)"
                      :class="profile.userLiked ? 'bg-red-500 text-white' : 'bg-white border border-red-400 text-red-500 hover:bg-red-500 hover:text-white'"
                      class="flex items-center px-2 py-1 rounded text-xs transition-all duration-300"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                      </svg>
                      {{ profile.likes || 0 }}
                    </button>
                    <button 
                      @click="dislikeProfile(profile)"
                      :class="profile.userDisliked ? 'bg-gray-500 text-white' : 'bg-white border border-gray-400 text-gray-500 hover:bg-gray-500 hover:text-white'"
                      class="flex items-center px-2 py-1 rounded text-xs transition-all duration-300"
                    >
                      <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 113 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.057 2H5.641a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                      </svg>
                      {{ profile.dislikes || 0 }}
                    </button>
                  </div>
                  <button 
                    @click="toggleComments(profile.id)"
                    class="text-blue-600 hover:text-blue-700 text-xs font-medium"
                  >
                    {{ profile.showComments ? 'Hide' : 'Comments' }} ({{ profile.comments?.length || 0 }})
                  </button>
                </div>
                
                <!-- Comments Section -->
                <div v-if="profile.showComments" class="space-y-2">
                  <div class="flex space-x-2">
                    <textarea 
                      v-model="profile.newComment"
                      placeholder="Add a comment..."
                      class="flex-1 px-2 py-1 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 resize-none"
                      rows="2"
                    ></textarea>
                    <button 
                      @click="addComment(profile)"
                      :disabled="!profile.newComment?.trim()"
                      class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700 transition-colors disabled:opacity-50"
                    >
                      Post
                    </button>
                  </div>
                  
                  <!-- Display Comments -->
                  <div v-if="profile.comments && profile.comments.length" class="space-y-1 max-h-24 overflow-y-auto">
                    <div 
                      v-for="comment in profile.comments" 
                      :key="comment.id"
                      class="bg-white p-2 rounded border text-xs"
                    >
                      <div class="flex items-center justify-between mb-1">
                        <span class="font-medium text-gray-900">{{ comment.author }}</span>
                        <span class="text-xs text-gray-500">{{ comment.date }}</span>
                      </div>
                      <p class="text-gray-700">{{ comment.text }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-else-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div v-for="i in 8" :key="i" class="bg-white rounded-xl shadow-sm overflow-hidden animate-pulse">
            <div class="p-6 text-center">
              <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>
              <div class="h-4 bg-gray-300 rounded mb-2"></div>
              <div class="h-3 bg-gray-300 rounded mb-2"></div>
              <div class="h-3 bg-gray-300 rounded mb-4"></div>
              <div class="h-12 bg-gray-300 rounded mb-4"></div>
              <div class="grid grid-cols-2 gap-4">
                <div class="h-6 bg-gray-300 rounded"></div>
                <div class="h-6 bg-gray-300 rounded"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- No profiles found -->
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
          </svg>
          <h3 class="mt-4 text-lg font-medium text-gray-900">No students found</h3>
          <p class="mt-2 text-gray-500">Try adjusting your filter criteria.</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';

const profiles = ref([]);
const selectedMajor = ref('');
const selectedYear = ref('');
const loading = ref(true);

const majors = ['Computer Science', 'Business Administration', 'Engineering', 'Psychology', 'Biology', 'Art & Design'];

// Random mottos for students
const studentMottos = [
  "Dream big, work hard, stay humble",
  "Every day is a chance to learn something new",
  "Success is not final, failure is not fatal",
  "Be the change you wish to see",
  "Innovation distinguishes leaders from followers",
  "The future belongs to those who believe in their dreams",
  "Excellence is not a skill, it's an attitude",
  "Education is the passport to the future",
  "Believe in yourself and all that you are",
  "Hard work beats talent when talent doesn't work hard",
  "Your only limit is your mind",
  "Great things never come from comfort zones",
  "The best investment you can make is in yourself",
  "Knowledge is power, wisdom is knowing how to use it",
  "Success starts with self-discipline",
  "Turn your wounds into wisdom",
  "Be fearless in the pursuit of what sets your soul on fire",
  "The expert in anything was once a beginner",
  "Your potential is endless",
  "Life is what happens when you're busy making plans",
];

const featuredProfiles = computed(() => {
  return profiles.value.filter(profile => profile.is_featured);
});

const filteredProfiles = computed(() => {
  // Server-side filtering is now handled by the API
  // Just separate featured from non-featured here
  return profiles.value.filter(profile => !profile.is_featured);
});

// Function to get Unsplash photo based on major
const getUnsplashPhoto = (major) => {
  const photoMap = {
    'Computer Science': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
    'Business Administration': 'https://images.unsplash.com/photo-1494790108755-2616b612b494?w=400&h=400&fit=crop&crop=face',
    'Engineering': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
    'Psychology': 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=400&fit=crop&crop=face',
    'Biology': 'https://images.unsplash.com/photo-1559548331-f9cb98001426?w=400&h=400&fit=crop&crop=face',
    'Art & Design': 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face'
  };
  
  return photoMap[major] || 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face';
};

// Function to get random motto
const getRandomMotto = () => {
  return studentMottos[Math.floor(Math.random() * studentMottos.length)];
};

const fetchProfiles = async () => {
  try {
    loading.value = true;
    
    // Build query parameters
    const params = new URLSearchParams();
    if (selectedMajor.value) {
      params.append('major', selectedMajor.value);
    }
    if (selectedYear.value) {
      params.append('graduation_year', selectedYear.value);
    }
    
    const url = `/api/v1/student-profiles${params.toString() ? '?' + params.toString() : ''}`;
    const response = await fetch(url);
    
    if (response.ok) {
      const data = await response.json();
      // Add Unsplash photos and mottos to profiles
      profiles.value = data.data.map(profile => ({
        ...profile,
        unsplash_photo: getUnsplashPhoto(profile.major),
        motto: profile.motto || getRandomMotto(),
        likes: profile.likes || Math.floor(Math.random() * 200) + 50,
        dislikes: profile.dislikes || Math.floor(Math.random() * 20) + 1,
        comments: profile.comments || [],
        showComments: false,
        newComment: '',
        userLiked: false,
        userDisliked: false
      }));
    } else {
      console.error('Failed to fetch student profiles');
      profiles.value = getMockProfiles();
    }
  } catch (error) {
    console.error('Error fetching student profiles:', error);
    profiles.value = getMockProfiles();
  } finally {
    loading.value = false;
  }
};

const getMockProfiles = () => {
  return [
    {
      id: 1,
      name: 'Sarah Martinez',
      student_id: 'GC2024001',
      email: 'sarah.martinez@gcuni.edu',
      avatar: '/images/avatars/sarah-martinez.jpg',
      unsplash_photo: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
      bio: 'Passionate software developer with a focus on machine learning and artificial intelligence. Currently working on my thesis about neural networks in educational technology.',
      major: 'Computer Science',
      graduation_year: '2024',
      gpa: '3.9',
      motto: 'Innovation distinguishes leaders from followers',
      likes: 245,
      dislikes: 12,
      comments: [
        { id: 1, author: 'John Doe', text: 'Amazing work on the AI project!', date: '2024-10-10' },
        { id: 2, author: 'Jane Smith', text: 'Great presentation skills', date: '2024-10-12' }
      ],
      achievements: ['Dean\'s List', 'Outstanding Student Award', 'Hackathon Winner', 'Research Publication'],
      interests: ['Machine Learning', 'Web Development', 'Photography', 'Rock Climbing'],
      social_links: {
        linkedin: 'https://linkedin.com/in/sarahmartinez',
        github: 'https://github.com/sarahmartinez',
        twitter: 'https://twitter.com/sarahmartinez'
      },
      is_featured: true
    },
    {
      id: 2,
      name: 'Marcus Johnson',
      student_id: 'GC2025002',
      email: 'marcus.johnson@gcuni.edu',
      avatar: '/images/avatars/marcus-johnson.jpg',
      unsplash_photo: 'https://images.unsplash.com/photo-1494790108755-2616b612b494?w=400&h=400&fit=crop&crop=face',
      bio: 'Entrepreneurship enthusiast and business strategy student. Founded two successful student organizations and currently developing a startup focused on sustainable campus solutions.',
      major: 'Business Administration',
      graduation_year: '2025',
      gpa: '3.7',
      motto: 'Be the change you wish to see in the world',
      likes: 198,
      dislikes: 8,
      comments: [
        { id: 1, author: 'Alice Brown', text: 'Love your entrepreneurial spirit!', date: '2024-10-11' }
      ],
      achievements: ['Student Government President', 'Entrepreneurship Competition Winner', 'Leadership Excellence Award'],
      interests: ['Entrepreneurship', 'Sustainability', 'Public Speaking', 'Basketball'],
      social_links: {
        linkedin: 'https://linkedin.com/in/marcusjohnson',
        twitter: 'https://twitter.com/marcusjohnson'
      },
      is_featured: true
    }
  ].map(profile => ({
    ...profile,
    motto: profile.motto || getRandomMotto(),
    showComments: false,
    newComment: '',
    userLiked: false,
    userDisliked: false
  }));
};

// Add watchers to refetch data when filters change
watch([selectedMajor, selectedYear], () => {
  fetchProfiles();
});

// Methods for like/dislike and comments functionality
const likeProfile = (profile) => {
  if (profile.userDisliked) {
    profile.dislikes = (profile.dislikes || 0) - 1;
    profile.userDisliked = false;
  }
  
  if (profile.userLiked) {
    profile.likes = (profile.likes || 0) - 1;
    profile.userLiked = false;
  } else {
    profile.likes = (profile.likes || 0) + 1;
    profile.userLiked = true;
  }
};

const dislikeProfile = (profile) => {
  if (profile.userLiked) {
    profile.likes = (profile.likes || 0) - 1;
    profile.userLiked = false;
  }
  
  if (profile.userDisliked) {
    profile.dislikes = (profile.dislikes || 0) - 1;
    profile.userDisliked = false;
  } else {
    profile.dislikes = (profile.dislikes || 0) + 1;
    profile.userDisliked = true;
  }
};

const toggleComments = (profileId) => {
  const profile = profiles.value.find(p => p.id === profileId);
  if (profile) {
    profile.showComments = !profile.showComments;
  }
};

const addComment = (profile) => {
  if (!profile.newComment?.trim()) return;
  
  if (!profile.comments) {
    profile.comments = [];
  }
  
  const comment = {
    id: Date.now(),
    author: 'Anonymous User', // In real app, this would be current user
    text: profile.newComment.trim(),
    date: new Date().toLocaleDateString()
  };
  
  profile.comments.unshift(comment);
  profile.newComment = '';
};

onMounted(() => {
  fetchProfiles();
});
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Custom golden colors for university branding */
.bg-golden-400 {
  background-color: #FCD34D;
}

.bg-golden-200 {
  background-color: #FEF3C7;
}

.text-golden-300 {
  color: #FDE68A;
}

.text-golden-400 {
  color: #FCD34D;
}

.text-golden-500 {
  color: #F59E0B;
}

.hover\:text-golden-300:hover {
  color: #FDE68A;
}

.hover\:from-golden-300:hover {
  background-image: linear-gradient(to right, #FDE68A, #F59E0B);
}

.hover\:to-yellow-400:hover {
  background-image: linear-gradient(to right, #FCD34D, #F59E0B);
}

.from-golden-400 {
  background-image: linear-gradient(to right, #FCD34D, #F59E0B);
}

.to-yellow-500 {
  background-image: linear-gradient(to right, #FCD34D, #F59E0B);
}

.border-golden-200 {
  border-color: #FEF3C7;
}

.border-golden-300 {
  border-color: #FCD34D;
}

.hover\:scale-102:hover {
  transform: scale(1.02);
}

.shadow-3xl {
  box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Animation for heart pulse */
@keyframes heartPulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.1); }
}

.animate-heart-pulse {
  animation: heartPulse 2s infinite;
}
</style>