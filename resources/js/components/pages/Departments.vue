<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 text-white py-16">
      <div class="absolute inset-0 bg-black/30"></div>
      <div class="relative container mx-auto px-4">
        <div class="text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Departments</h1>
          <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Discover academic excellence across our diverse range of departments. 
            We offer cutting-edge programs that shape future leaders.
          </p>
        </div>
      </div>
    </section>

    <!-- Departments Grid -->
    <section class="py-16">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="department in departments" 
            :key="department.id"
            :id="departmentSlug(department)"
            @click="selectDepartment(department)"
            class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer overflow-hidden group scroll-mt-24"
          >
            <!-- Department Image -->
            <div class="relative h-48 overflow-hidden">
              <img 
                :src="department.image" 
                :alt="department.name"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
              <div class="absolute bottom-4 left-4">
                <div :class="['w-12 h-12 rounded-lg flex items-center justify-center', department.colorClass]">
                  <component :is="department.icon" class="w-6 h-6 text-white" />
                </div>
              </div>
            </div>

            <!-- Department Info -->
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ department.name }}</h3>
              <p class="text-gray-600 mb-4">{{ department.description }}</p>
              
              <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-medium text-blue-600">{{ department.programs }} Programs</span>
                <span class="text-sm text-gray-500">{{ department.students }} Students</span>
              </div>

              <div class="flex flex-wrap gap-2 mb-4">
                <span 
                  v-for="program in department.topPrograms" 
                  :key="program"
                  class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full"
                >
                  {{ program }}
                </span>
              </div>

              <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                View Details
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Programs -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Academic Programs</h2>
          <p class="text-xl text-gray-600">Explore our most popular and innovative programs</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div 
            v-for="program in featuredPrograms" 
            :key="program.id"
            class="bg-gradient-to-br from-white to-gray-50 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow"
          >
            <div :class="['w-12 h-12 rounded-lg flex items-center justify-center mb-4', program.colorClass]">
              <component :is="program.icon" class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ program.name }}</h3>
            <p class="text-gray-600 text-sm mb-3">{{ program.description }}</p>
            <div class="flex items-center justify-between text-sm">
              <span class="text-blue-600 font-medium">{{ program.duration }}</span>
              <span class="text-gray-500">{{ program.type }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Department Statistics -->
    <section class="py-16 bg-blue-900 text-white">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div>
            <div class="text-4xl font-bold text-yellow-300 mb-2">12</div>
            <div class="text-blue-200">Departments</div>
          </div>
          <div>
            <div class="text-4xl font-bold text-yellow-300 mb-2">50+</div>
            <div class="text-blue-200">Programs</div>
          </div>
          <div>
            <div class="text-4xl font-bold text-yellow-300 mb-2">15,000+</div>
            <div class="text-blue-200">Students</div>
          </div>
          <div>
            <div class="text-4xl font-bold text-yellow-300 mb-2">800+</div>
            <div class="text-blue-200">Faculty</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Department Modal -->
    <div v-if="selectedDepartment" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl max-w-6xl w-full max-h-screen overflow-y-auto">
        <div class="relative">
          <!-- Modal Header with Group Graduation Image -->
          <div class="relative h-80 overflow-hidden rounded-t-xl">
            <img 
              :src="selectedDepartment.graduationImage" 
              :alt="selectedDepartment.name + ' Graduation'"
              class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <button 
              @click="selectedDepartment = null"
              class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
            <div class="absolute bottom-6 left-6">
              <h2 class="text-4xl font-bold text-white mb-2">{{ selectedDepartment.name }}</h2>
              <p class="text-blue-100 text-lg">{{ selectedDepartment.fullDescription }}</p>
              <div class="mt-4 flex items-center text-golden-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-bold">{{ selectedDepartment.graduationYear }} Graduates</span>
              </div>
            </div>
          </div>

          <!-- Modal Content -->
          <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
              <!-- Academic Programs Section -->
              <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8">
                <div class="flex items-center mb-6">
                  <div class="bg-blue-600 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                  </div>
                  <h3 class="text-3xl font-bold text-blue-900">Academic Programs</h3>
                </div>
                
                <div class="space-y-6">
                  <div 
                    v-for="program in selectedDepartment.allPrograms" 
                    :key="program.name"
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow border-l-4 border-blue-500"
                  >
                    <div class="flex justify-between items-start mb-3">
                      <h4 class="text-xl font-bold text-gray-900">{{ program.name }}</h4>
                      <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ program.type }}
                      </span>
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">{{ program.description }}</p>
                    <div class="flex items-center justify-between">
                      <div class="flex items-center text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">{{ program.duration }}</span>
                      </div>
                      <button 
                        @click="showProgramDetails(program)"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium"
                      >
                        Learn More
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Department Information Section -->
              <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8">
                <div class="flex items-center mb-6">
                  <div class="bg-indigo-600 rounded-lg p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h10M7 11h4m6 0h2M7 15h10"/>
                    </svg>
                  </div>
                  <h3 class="text-3xl font-bold text-indigo-900">Department Information</h3>
                </div>

                <div class="space-y-6">
                  <!-- Department Head -->
                  <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-indigo-500">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                      <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      Department Head
                    </h4>
                    <p class="text-gray-700 font-semibold text-lg">{{ selectedDepartment.head }}</p>
                  </div>
                  
                  <!-- Contact Information -->
                  <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                      <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                      </svg>
                      Contact Information
                    </h4>
                    <div class="space-y-3">
                      <div class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-gray-700">{{ selectedDepartment.contact.email }}</span>
                      </div>
                      <div class="flex items-center">
                        <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-gray-700">{{ selectedDepartment.contact.phone }}</span>
                      </div>
                    </div>
                  </div>

                  <!-- Department Statistics -->
                  <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-purple-500">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                      <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                      </svg>
                      Department Statistics
                    </h4>
                    <div class="grid grid-cols-3 gap-4 text-center">
                      <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ selectedDepartment.programs }}</div>
                        <div class="text-sm text-gray-600">Programs</div>
                      </div>
                      <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ selectedDepartment.students.toLocaleString() }}</div>
                        <div class="text-sm text-gray-600">Students</div>
                      </div>
                      <div class="bg-purple-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600">{{ selectedDepartment.faculty }}</div>
                        <div class="text-sm text-gray-600">Faculty</div>
                      </div>
                    </div>
                  </div>

                  <!-- Department Facilities -->
                  <div class="bg-white rounded-xl p-6 shadow-md border-l-4 border-yellow-500">
                    <h4 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                      <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h10M7 11h4m6 0h2M7 15h10"/>
                      </svg>
                      Key Facilities
                    </h4>
                    <div class="space-y-2">
                      <div 
                        v-for="facility in selectedDepartment.facilities" 
                        :key="facility"
                        class="flex items-center text-gray-700"
                      >
                        <svg class="w-3 h-3 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm">{{ facility }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Program Details Modal -->
    <div v-if="selectedProgram" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60 p-4">
      <div class="bg-white rounded-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <div class="relative">
          <!-- Program Header -->
          <div class="relative h-64 overflow-hidden rounded-t-xl">
            <img 
              :src="selectedProgram.image" 
              :alt="selectedProgram.name"
              class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <button 
              @click="selectedProgram = null"
              class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
            <div class="absolute bottom-6 left-6">
              <h2 class="text-3xl font-bold text-white mb-2">{{ selectedProgram.name }}</h2>
              <div class="flex items-center space-x-4">
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-white font-medium">
                  {{ selectedProgram.type }}
                </span>
                <span class="text-golden-300 font-semibold">{{ selectedProgram.duration }}</span>
              </div>
            </div>
          </div>

          <!-- Program Content -->
          <div class="p-8">
            <!-- Like/Dislike Section -->
            <div class="flex items-center justify-between mb-8 bg-gray-50 rounded-xl p-6">
              <div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Rate this Program</h3>
                <p class="text-gray-600">Help future students by rating this program</p>
              </div>
              <div class="flex items-center space-x-4">
                <button 
                  @click="likeProgram(selectedProgram)"
                  :class="selectedProgram.userLiked ? 'bg-green-500 text-white' : 'bg-white border-2 border-green-500 text-green-500 hover:bg-green-500 hover:text-white'"
                  class="flex items-center px-4 py-2 rounded-lg transition-all duration-300"
                >
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                  </svg>
                  {{ selectedProgram.likes }}
                </button>
                <button 
                  @click="dislikeProgram(selectedProgram)"
                  :class="selectedProgram.userDisliked ? 'bg-red-500 text-white' : 'bg-white border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white'"
                  class="flex items-center px-4 py-2 rounded-lg transition-all duration-300"
                >
                  <svg class="w-5 h-5 mr-2 transform rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                  </svg>
                  {{ selectedProgram.dislikes }}
                </button>
              </div>
            </div>

            <!-- Program Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Program Overview</h3>
                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ selectedProgram.details }}</p>
                
                <h4 class="text-xl font-bold text-gray-900 mb-4">Key Features</h4>
                <ul class="space-y-2">
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700">Hands-on practical experience</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700">Industry partnerships and internships</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700">Modern facilities and equipment</span>
                  </li>
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700">Expert faculty and mentorship</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Curriculum</h3>
                <div class="space-y-3">
                  <div 
                    v-for="course in selectedProgram.curriculum" 
                    :key="course"
                    class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500 hover:bg-blue-100 transition-colors cursor-pointer group"
                    @click="showCourseModal(course)"
                  >
                    <div class="flex items-center justify-between">
                      <h4 class="font-semibold text-blue-900 hover:text-blue-700 group-hover:text-blue-700">{{ course }}</h4>
                      <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="text-xs bg-blue-200 text-blue-800 px-2 py-1 rounded-full">
                          Click for Details
                        </span>
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                      </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2 opacity-70 group-hover:opacity-100 transition-opacity">
                      {{ getCoursePreview(course) }}
                    </p>
                  </div>
                </div>

                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                  <h4 class="text-lg font-bold text-gray-900 mb-3">Ready to Apply?</h4>
                  <p class="text-gray-600 mb-4">Join our next intake and start your journey in {{ selectedProgram.name }}</p>
                  <button 
                    @click="applyForProgram(selectedProgram)"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold"
                  >
                    Apply Now
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Course Details Modal -->
  <div v-if="selectedCourse" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-70 p-4">
    <div class="bg-white rounded-xl max-w-3xl w-full max-h-screen overflow-y-auto">
      <div class="relative">
        <!-- Course Header -->
        <div class="relative h-48 overflow-hidden rounded-t-xl">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700"></div>
          <button 
            @click="selectedCourse = null"
            class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <div class="absolute bottom-6 left-6 right-6">
            <h2 class="text-3xl font-bold text-white mb-2">{{ selectedCourse.name }}</h2>
            <div class="flex items-center space-x-4 text-white/90">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ selectedCourse.credits }} Credits
              </span>
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ selectedCourse.level }}
              </span>
            </div>
          </div>
        </div>

        <!-- Course Content -->
        <div class="p-8">
          <!-- Course Description -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Course Description</h3>
            <p class="text-gray-700 leading-relaxed text-lg">{{ selectedCourse.description }}</p>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Course Information -->
            <div class="space-y-6">
              <!-- Prerequisites -->
              <div class="bg-yellow-50 rounded-lg p-6 border-l-4 border-yellow-400">
                <h4 class="font-bold text-yellow-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                  </svg>
                  Prerequisites
                </h4>
                <p class="text-yellow-800">{{ selectedCourse.prerequisites }}</p>
              </div>

              <!-- Learning Objectives -->
              <div class="bg-green-50 rounded-lg p-6 border-l-4 border-green-400">
                <h4 class="font-bold text-green-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Learning Objectives
                </h4>
                <ul class="space-y-2 text-green-800">
                  <li v-for="objective in selectedCourse.objectives" :key="objective" class="flex items-start">
                    <span class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    {{ objective }}
                  </li>
                </ul>
              </div>

              <!-- Assessment Methods -->
              <div class="bg-purple-50 rounded-lg p-6 border-l-4 border-purple-400">
                <h4 class="font-bold text-purple-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                  </svg>
                  Assessment Methods
                </h4>
                <div class="space-y-2 text-purple-800">
                  <div v-for="assessment in selectedCourse.assessments" :key="assessment.type" class="flex justify-between">
                    <span>{{ assessment.type }}</span>
                    <span class="font-semibold">{{ assessment.weight }}%</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Course Details -->
            <div class="space-y-6">
              <!-- Course Outline -->
              <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-400">
                <h4 class="font-bold text-blue-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  Course Outline & Resources
                </h4>
                <div class="space-y-3 text-blue-800">
                  <div v-for="(topic, index) in selectedCourse.topics" :key="topic" class="flex items-start justify-between">
                    <div class="flex items-start flex-1">
                      <span class="bg-blue-200 text-blue-900 text-xs font-bold px-2 py-1 rounded-full mr-3 mt-0.5">
                        {{ index + 1 }}
                      </span>
                      <span class="flex-1">{{ topic }}</span>
                    </div>
                    <div class="relative ml-4">
                      <button 
                        @click="toggleTopicLinks(index)"
                        class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg text-xs font-medium transition-colors flex items-center"
                      >
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        Links
                        <svg class="w-3 h-3 ml-1 transition-transform" :class="{ 'rotate-180': topicLinksOpen === index }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                      </button>
                      
                      <!-- Dropdown Links -->
                      <div v-if="topicLinksOpen === index" class="absolute right-0 top-8 bg-white rounded-lg shadow-xl border z-10 w-64 max-h-48 overflow-y-auto">
                        <div class="p-3">
                          <h5 class="font-semibold text-gray-900 mb-2 text-sm">{{ topic }} Resources:</h5>
                          <div class="space-y-2">
                            <a 
                              v-for="link in getTopicLinks(topic)" 
                              :key="link.title"
                              :href="link.url" 
                              target="_blank"
                              class="flex items-center p-2 hover:bg-gray-50 rounded text-xs text-gray-700 hover:text-blue-600 transition-colors"
                            >
                              <svg class="w-3 h-3 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                              </svg>
                              <div>
                                <div class="font-medium">{{ link.title }}</div>
                                <div class="text-gray-500">{{ link.description }}</div>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Required Resources -->
              <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-gray-400">
                <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                  </svg>
                  Required Resources
                </h4>
                <ul class="space-y-2 text-gray-700">
                  <li v-for="resource in selectedCourse.resources" :key="resource" class="flex items-start">
                    <svg class="w-4 h-4 text-gray-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    {{ resource }}
                  </li>
                </ul>
              </div>

              <!-- Course Information -->
              <div class="bg-indigo-50 rounded-lg p-6 border-l-4 border-indigo-400">
                <h4 class="font-bold text-indigo-900 mb-3 flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Course Information
                </h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-indigo-800">
                  <div>
                    <p><span class="font-semibold">Instructor:</span> {{ selectedCourse.instructor }}</p>
                    <p><span class="font-semibold">Format:</span> {{ selectedCourse.format }}</p>
                  </div>
                  <div>
                    <p><span class="font-semibold">Duration:</span> {{ selectedCourse.duration }}</p>
                    <p><span class="font-semibold">Schedule:</span> {{ selectedCourse.schedule }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center justify-center space-x-4 mt-8 pt-6 border-t">
            <button 
              @click="enrollInCourse(selectedCourse)"
              class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Enroll in Course
            </button>
            <button 
              @click="viewSyllabus(selectedCourse)"
              class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors flex items-center"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              View Syllabus
            </button>
            <button 
              @click="selectedCourse = null"
              class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Course Enrollment Modal -->
  <div v-if="showEnrollmentForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-70 p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto">
      <div class="relative">
        <!-- Header -->
        <div class="relative h-32 overflow-hidden rounded-t-xl">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-indigo-700"></div>
          <button 
            @click="closeEnrollmentForm"
            class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <div class="absolute bottom-6 left-6">
            <h2 class="text-2xl font-bold text-white mb-2">Course Enrollment</h2>
            <p class="text-blue-100">{{ enrollmentData.course_name }}</p>
          </div>
        </div>

        <!-- Enrollment Form -->
        <div class="p-8">
          <!-- Success/Error Message -->
          <div v-if="enrollmentStatus" class="mb-6">
            <div :class="['p-4 rounded-lg', enrollmentStatus.success ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200']">
              <div class="flex items-start">
                <svg v-if="enrollmentStatus.success" class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg v-else class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <div>
                  <p :class="enrollmentStatus.success ? 'text-green-800' : 'text-red-800'">{{ enrollmentStatus.message }}</p>
                  <div v-if="enrollmentStatus.enrollment" class="mt-2 text-sm text-green-700">
                    <p><strong>Application Number:</strong> {{ enrollmentStatus.enrollment.application_number }}</p>
                    <p><strong>Status:</strong> {{ enrollmentStatus.enrollment.status }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form @submit.prevent="submitEnrollment" v-if="!enrollmentStatus?.success">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Student Information -->
              <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900">Student Information</h3>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                  <input
                    v-model="enrollmentData.student_name"
                    type="text"
                    required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your full name"
                  >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                  <input
                    v-model="enrollmentData.student_email"
                    type="email"
                    required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your email"
                  >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                  <input
                    v-model="enrollmentData.student_phone"
                    type="tel"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your phone number"
                  >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Student ID (if applicable)</label>
                  <input
                    v-model="enrollmentData.student_id"
                    type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your student ID"
                  >
                </div>
              </div>

              <!-- Course Information -->
              <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900">Course Information</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                  <p class="font-semibold">{{ enrollmentData.course_name }}</p>
                  <p class="text-sm text-gray-600">{{ enrollmentData.department }}</p>
                  <p class="text-sm text-gray-600">{{ enrollmentData.program_type }} Program</p>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Motivation</label>
                  <textarea
                    v-model="enrollmentData.motivation"
                    rows="4"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Why do you want to enroll in this course? (Optional)"
                  ></textarea>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex items-center justify-end space-x-4">
              <button
                type="button"
                @click="closeEnrollmentForm"
                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isEnrolling"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
              >
                <span v-if="isEnrolling">Submitting...</span>
                <span v-else>Submit Enrollment</span>
              </button>
            </div>
          </form>

          <div v-else class="text-center mt-6">
            <button
              @click="closeEnrollmentForm"
              class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Syllabus Modal -->
  <div v-if="showSyllabusModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-70 p-4">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-screen overflow-y-auto">
      <div class="relative">
        <!-- Header -->
        <div class="relative h-32 overflow-hidden rounded-t-xl">
          <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-emerald-700"></div>
          <button 
            @click="closeSyllabusModal"
            class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <div class="absolute bottom-6 left-6">
            <h2 class="text-2xl font-bold text-white mb-2">Course Syllabus</h2>
            <p class="text-green-100" v-if="currentSyllabus">{{ currentSyllabus.full_course_name }}</p>
          </div>
        </div>

        <!-- Syllabus Content -->
        <div class="p-8">
          <div v-if="isSyllabusLoading" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading syllabus...</p>
          </div>

          <div v-else-if="currentSyllabus" class="space-y-8">
            <!-- Course Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900">Course Information</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                  <p><strong>Course:</strong> {{ currentSyllabus.full_course_name }}</p>
                  <p><strong>Department:</strong> {{ currentSyllabus.department }}</p>
                  <p><strong>Credits:</strong> {{ currentSyllabus.credits }}</p>
                  <p><strong>Instructor:</strong> {{ currentSyllabus.instructor }}</p>
                  <p v-if="currentSyllabus.schedule"><strong>Schedule:</strong> {{ currentSyllabus.schedule }}</p>
                  <p v-if="currentSyllabus.location"><strong>Location:</strong> {{ currentSyllabus.location }}</p>
                </div>
              </div>

              <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900">Academic Details</h3>
                <div class="bg-blue-50 p-4 rounded-lg space-y-2">
                  <p><strong>Semester:</strong> {{ currentSyllabus.semester }} {{ currentSyllabus.academic_year }}</p>
                  <p><strong>Program Type:</strong> {{ currentSyllabus.program_type }}</p>
                  <p v-if="currentSyllabus.office_hours"><strong>Office Hours:</strong> {{ currentSyllabus.office_hours }}</p>
                  <div v-if="currentSyllabus.prerequisites?.length">
                    <strong>Prerequisites:</strong>
                    <ul class="list-disc list-inside mt-1">
                      <li v-for="prereq in currentSyllabus.prerequisites" :key="prereq" class="text-sm">{{ prereq }}</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Course Description -->
            <div>
              <h3 class="text-xl font-bold text-gray-900 mb-4">Course Description</h3>
              <p class="text-gray-700 leading-relaxed">{{ currentSyllabus.course_description }}</p>
            </div>

            <!-- Learning Objectives -->
            <div v-if="currentSyllabus.learning_objectives?.length">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Learning Objectives</h3>
              <ul class="space-y-2">
                <li v-for="objective in currentSyllabus.learning_objectives" :key="objective" class="flex items-start">
                  <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <span class="text-gray-700">{{ objective }}</span>
                </li>
              </ul>
            </div>

            <!-- Course Outline -->
            <div v-if="currentSyllabus.course_outline?.length">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Course Outline</h3>
              <div class="space-y-3">
                <div 
                  v-for="(item, index) in currentSyllabus.course_outline" 
                  :key="index"
                  class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500"
                >
                  <p class="text-gray-800">{{ item }}</p>
                </div>
              </div>
            </div>

            <!-- Assessment Methods -->
            <div v-if="currentSyllabus.assessment_methods?.length">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Assessment Methods</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div 
                  v-for="assessment in currentSyllabus.assessment_methods" 
                  :key="assessment.type"
                  class="bg-purple-50 p-4 rounded-lg border border-purple-200"
                >
                  <div class="flex justify-between items-center mb-2">
                    <h4 class="font-semibold text-purple-900">{{ assessment.type }}</h4>
                    <span class="bg-purple-200 text-purple-800 px-2 py-1 rounded-full text-sm font-bold">
                      {{ assessment.weight }}%
                    </span>
                  </div>
                  <p class="text-purple-700 text-sm">{{ assessment.description }}</p>
                </div>
              </div>
            </div>

            <!-- Required Textbooks -->
            <div v-if="currentSyllabus.required_textbooks?.length">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Required Textbooks</h3>
              <ul class="space-y-2">
                <li v-for="book in currentSyllabus.required_textbooks" :key="book" class="flex items-start">
                  <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                  </svg>
                  <span class="text-gray-700">{{ book }}</span>
                </li>
              </ul>
            </div>

            <!-- Policies -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div v-if="currentSyllabus.attendance_policy">
                <h4 class="text-lg font-bold text-gray-900 mb-3">Attendance Policy</h4>
                <p class="text-gray-700 text-sm bg-yellow-50 p-4 rounded-lg border border-yellow-200">{{ currentSyllabus.attendance_policy }}</p>
              </div>
              <div v-if="currentSyllabus.late_policy">
                <h4 class="text-lg font-bold text-gray-900 mb-3">Late Assignment Policy</h4>
                <p class="text-gray-700 text-sm bg-red-50 p-4 rounded-lg border border-red-200">{{ currentSyllabus.late_policy }}</p>
              </div>
            </div>

            <!-- Academic Integrity -->
            <div v-if="currentSyllabus.academic_integrity">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Academic Integrity</h3>
              <p class="text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-200">{{ currentSyllabus.academic_integrity }}</p>
            </div>

            <!-- Download Section -->
            <div class="text-center pt-6 border-t">
              <div class="flex items-center justify-center space-x-4">
                <button 
                  @click="downloadSyllabus"
                  class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  Download PDF Syllabus
                </button>
                
                <button 
                  @click="printSyllabus"
                  class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                  </svg>
                  Print Syllabus
                </button>
              </div>
            </div>
          </div>

          <div v-else class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-600">No syllabus available for this course</p>
          </div>

          <div class="text-center mt-8 pt-6 border-t">
            <button
              @click="closeSyllabusModal"
              class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Departments',
  data() {
    return {
      selectedDepartment: null,
      selectedProgram: null,
      selectedCourse: null,
      topicLinksOpen: null,
      showEnrollmentForm: false,
      showSyllabusModal: false,
      enrollmentData: {
        student_name: '',
        student_email: '',
        student_phone: '',
        student_id: '',
        motivation: '',
        prerequisites_met: []
      },
      currentSyllabus: null,
      enrollmentStatus: null,
      isEnrolling: false,
      isSyllabusLoading: false,
      departments: [
        {
          id: 1,
          name: 'Computer Science & IT',
          description: 'Building the next generation of innovators through cutting-edge technology and research.',
          image: '/images/departments/computer-science.jpg',
          graduationImage: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&h=600&fit=crop&crop=faces',
          graduationYear: '2024',
          colorClass: 'bg-blue-600',
          icon: 'ComputerDesktopIcon',
          programs: 8,
          students: 2468,
          faculty: 45,
          topPrograms: ['Computer Science', 'Software Engineering', 'Data Science'],
          fullDescription: 'Our Computer Science & IT department is at the forefront of technological innovation, preparing students for careers in software development, artificial intelligence, cybersecurity, and data science.',
          head: 'Dr. Sarah Johnson',
          contact: {
            email: 'cs@gcuniversity.edu.et',
            phone: '+251-11-123-4567'
          },
          allPrograms: [
            { 
              name: 'BSc Computer Science', 
              description: 'Core computer science fundamentals', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=400&h=300&fit=crop',
              likes: 145,
              dislikes: 12,
              details: 'Comprehensive program covering programming, algorithms, data structures, software engineering, and computer systems. Students gain hands-on experience with modern programming languages and development tools.',
              curriculum: ['Programming Fundamentals', 'Data Structures & Algorithms', 'Software Engineering', 'Database Systems', 'Computer Networks', 'Artificial Intelligence']
            },
            { 
              name: 'BSc Software Engineering', 
              description: 'Software development and engineering', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=300&fit=crop',
              likes: 132,
              dislikes: 8,
              details: 'Focus on systematic approach to software development, project management, and quality assurance. Prepares students for careers in software industry.',
              curriculum: ['Software Design Patterns', 'Project Management', 'Quality Assurance', 'Agile Development', 'Mobile App Development', 'Web Technologies']
            },
            { 
              name: 'BSc Information Systems', 
              description: 'Business and technology integration', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop',
              likes: 98,
              dislikes: 5,
              details: 'Bridge between business and technology, focusing on how information systems support business operations and decision-making.',
              curriculum: ['Business Analysis', 'System Design', 'Database Management', 'Enterprise Systems', 'IT Management', 'Business Intelligence']
            },
            { 
              name: 'MSc Computer Science', 
              description: 'Advanced computing research', 
              duration: '2 years', 
              type: 'Graduate',
              image: 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=300&fit=crop',
              likes: 87,
              dislikes: 3,
              details: 'Research-oriented program for advanced study in computer science with thesis component. Specialization areas include AI, machine learning, and cybersecurity.',
              curriculum: ['Advanced Algorithms', 'Machine Learning', 'Research Methodology', 'Thesis Work', 'Advanced Database Systems', 'Distributed Systems']
            },
            { 
              name: 'MSc Data Science', 
              description: 'Big data and analytics', 
              duration: '2 years', 
              type: 'Graduate',
              image: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=300&fit=crop',
              likes: 156,
              dislikes: 7,
              details: 'Interdisciplinary program combining statistics, computer science, and domain expertise to extract insights from large datasets.',
              curriculum: ['Statistical Analysis', 'Big Data Technologies', 'Machine Learning', 'Data Visualization', 'Predictive Analytics', 'Ethics in Data Science']
            },
            { 
              name: 'MSc Artificial Intelligence', 
              description: 'AI and machine learning', 
              duration: '2 years', 
              type: 'Graduate',
              image: 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=400&h=300&fit=crop',
              likes: 201,
              dislikes: 11,
              details: 'Cutting-edge program in artificial intelligence, covering deep learning, natural language processing, and robotics.',
              curriculum: ['Deep Learning', 'Natural Language Processing', 'Computer Vision', 'Robotics', 'Neural Networks', 'AI Ethics']
            }
          ],
          facilities: ['Computer Labs with 200+ Workstations', 'AI Research Center', 'Software Development Lab', 'Networking Lab', 'Server Room & Data Center', 'Innovation Hub']
        },
        {
          id: 2,
          name: 'Engineering',
          description: 'Innovative engineering solutions for modern challenges through hands-on learning and research.',
          image: '/images/departments/engineering.jpg',
          graduationImage: 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=1200&h=600&fit=crop&crop=faces',
          graduationYear: '2024',
          colorClass: 'bg-red-600',
          icon: 'CogIcon',
          programs: 12,
          students: 1856,
          faculty: 38,
          topPrograms: ['Civil Engineering', 'Mechanical Engineering', 'Electrical Engineering'],
          fullDescription: 'The Engineering department offers comprehensive programs designed to tackle real-world challenges through innovative design, sustainable practices, and cutting-edge technology.',
          head: 'Prof. Michael Brown',
          contact: {
            email: 'engineering@gcuniversity.edu.et',
            phone: '+251-11-123-4568'
          },
          allPrograms: [
            { 
              name: 'BSc Civil Engineering', 
              description: 'Infrastructure and construction', 
              duration: '5 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1581833971358-2c8b550f87b3?w=400&h=300&fit=crop',
              likes: 189,
              dislikes: 14,
              details: 'Comprehensive engineering program focusing on the design, construction, and maintenance of infrastructure projects including roads, bridges, buildings, and water systems.',
              curriculum: ['Structural Analysis', 'Geotechnical Engineering', 'Transportation Engineering', 'Water Resources', 'Construction Management', 'Environmental Engineering']
            },
            { 
              name: 'BSc Mechanical Engineering', 
              description: 'Mechanical systems and design', 
              duration: '5 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1581092162384-8987c1d64926?w=400&h=300&fit=crop',
              likes: 156,
              dislikes: 9,
              details: 'Study of mechanical systems, thermodynamics, and manufacturing processes. Prepare for careers in automotive, aerospace, and manufacturing industries.',
              curriculum: ['Thermodynamics', 'Fluid Mechanics', 'Machine Design', 'Manufacturing Processes', 'Control Systems', 'Materials Science']
            },
            { 
              name: 'BSc Electrical Engineering', 
              description: 'Electrical systems and power', 
              duration: '5 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=300&fit=crop',
              likes: 203,
              dislikes: 11,
              details: 'Focus on electrical power systems, electronics, and telecommunications. Essential for power generation, transmission, and distribution systems.',
              curriculum: ['Circuit Analysis', 'Power Systems', 'Electronics', 'Digital Signal Processing', 'Control Systems', 'Renewable Energy']
            },
            { 
              name: 'BSc Chemical Engineering', 
              description: 'Chemical processes and materials', 
              duration: '5 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=400&h=300&fit=crop',
              likes: 134,
              dislikes: 7,
              details: 'Apply chemistry and physics principles to transform raw materials into useful products. Work in pharmaceuticals, petrochemicals, and food processing.',
              curriculum: ['Process Engineering', 'Chemical Kinetics', 'Mass Transfer', 'Heat Transfer', 'Process Control', 'Environmental Engineering']
            }
          ],
          facilities: ['Engineering Design Studios', 'Materials Testing Lab', 'Mechanical Workshop', 'Electrical Power Lab', 'CAD/CAM Laboratory', 'Prototype Development Center']
        },
        {
          id: 3,
          name: 'Business & Management',
          description: 'Developing future business leaders with comprehensive management and entrepreneurial skills.',
          image: '/images/departments/business.jpg',
          graduationImage: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1200&h=600&fit=crop&crop=faces',
          graduationYear: '2024',
          colorClass: 'bg-green-600',
          icon: 'BriefcaseIcon',
          programs: 6,
          students: 3240,
          faculty: 42,
          topPrograms: ['Business Administration', 'Marketing', 'Accounting'],
          fullDescription: 'Our Business & Management department prepares students for leadership roles in the global business environment through innovative curriculum and practical experience.',
          head: 'Dr. Emily Davis',
          contact: {
            email: 'business@gcuniversity.edu.et',
            phone: '+251-11-123-4569'
          },
          allPrograms: [
            { 
              name: 'BSc Business Administration', 
              description: 'General business management', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=400&h=300&fit=crop',
              likes: 167,
              dislikes: 6,
              details: 'Comprehensive business education covering management, finance, marketing, and operations. Prepare for leadership roles in various industries.',
              curriculum: ['Strategic Management', 'Financial Analysis', 'Marketing Management', 'Operations Management', 'Human Resources', 'Business Ethics']
            },
            { 
              name: 'BSc Marketing', 
              description: 'Marketing and sales strategies', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop',
              likes: 145,
              dislikes: 8,
              details: 'Focus on consumer behavior, brand management, and digital marketing strategies. Essential skills for the modern marketing landscape.',
              curriculum: ['Consumer Behavior', 'Brand Management', 'Digital Marketing', 'Sales Management', 'Market Research', 'Advertising']
            },
            { 
              name: 'BSc Accounting', 
              description: 'Financial accounting and auditing', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400&h=300&fit=crop',
              likes: 123,
              dislikes: 4,
              details: 'Master financial reporting, auditing, and tax preparation. Essential for careers in public accounting, corporate finance, and consulting.',
              curriculum: ['Financial Accounting', 'Cost Accounting', 'Auditing', 'Taxation', 'Financial Analysis', 'Forensic Accounting']
            },
            { 
              name: 'MBA', 
              description: 'Master of Business Administration', 
              duration: '2 years', 
              type: 'Graduate',
              image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop',
              likes: 289,
              dislikes: 13,
              details: 'Advanced business education for experienced professionals. Focus on strategic leadership, innovation, and global business management.',
              curriculum: ['Strategic Leadership', 'Corporate Finance', 'Global Business', 'Innovation Management', 'Executive Decision Making', 'Business Analytics']
            }
          ],
          facilities: ['Business Simulation Lab', 'Trading Floor', 'Conference Rooms', 'Entrepreneurship Center', 'Case Study Rooms', 'Executive Training Center']
        },
        {
          id: 4,
          name: 'Medicine & Health Sciences',
          description: 'Training healthcare professionals to improve community health and medical care.',
          image: '/images/departments/medicine.jpg',
          graduationImage: 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=1200&h=600&fit=crop&crop=faces',
          graduationYear: '2024',
          colorClass: 'bg-red-500',
          icon: 'HeartIcon',
          programs: 9,
          students: 1680,
          faculty: 55,
          topPrograms: ['Medicine', 'Nursing', 'Pharmacy'],
          fullDescription: 'The Medicine & Health Sciences department is committed to excellence in medical education, research, and healthcare delivery.',
          head: 'Dr. James Wilson',
          contact: {
            email: 'medicine@gcuniversity.edu.et',
            phone: '+251-11-123-4570'
          },
          allPrograms: [
            { 
              name: 'Doctor of Medicine', 
              description: 'General medicine degree', 
              duration: '6 years', 
              type: 'Professional',
              image: 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=400&h=300&fit=crop',
              likes: 312,
              dislikes: 18,
              details: 'Comprehensive medical education combining theoretical knowledge with extensive clinical practice. Prepare for residency and medical specialization.',
              curriculum: ['Anatomy & Physiology', 'Pathology', 'Pharmacology', 'Internal Medicine', 'Surgery', 'Clinical Rotations']
            },
            { 
              name: 'BSc Nursing', 
              description: 'Professional nursing education', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop',
              likes: 178,
              dislikes: 5,
              details: 'Comprehensive nursing program focusing on patient care, health promotion, and evidence-based practice across various healthcare settings.',
              curriculum: ['Nursing Fundamentals', 'Medical-Surgical Nursing', 'Pediatric Nursing', 'Mental Health Nursing', 'Community Health', 'Nursing Research']
            },
            { 
              name: 'BSc Pharmacy', 
              description: 'Pharmaceutical sciences', 
              duration: '5 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1585435557343-3b092031d886?w=400&h=300&fit=crop',
              likes: 198,
              dislikes: 12,
              details: 'Study of drug development, pharmacology, and pharmaceutical care. Essential for careers in hospital pharmacy, research, and drug development.',
              curriculum: ['Pharmacology', 'Medicinal Chemistry', 'Pharmaceutics', 'Clinical Pharmacy', 'Drug Development', 'Pharmacy Practice']
            }
          ],
          facilities: ['Teaching Hospital', 'Anatomy Lab', 'Simulation Center', 'Pharmacy Lab', 'Medical Library', 'Clinical Skills Lab']
        },
        {
          id: 5,
          name: 'Natural Sciences',
          description: 'Exploring the natural world through research in biology, chemistry, physics, and mathematics.',
          image: '/images/departments/sciences.jpg',
          graduationImage: 'https://images.unsplash.com/photo-1559548331-f9cb98001426?w=1200&h=600&fit=crop&crop=faces',
          graduationYear: '2024',
          colorClass: 'bg-yellow-600',
          icon: 'BeakerIcon',
          programs: 7,
          students: 1420,
          faculty: 35,
          topPrograms: ['Biology', 'Chemistry', 'Physics'],
          fullDescription: 'Our Natural Sciences department offers rigorous programs that prepare students for careers in research, education, and industry.',
          head: 'Prof. Lisa Anderson',
          contact: {
            email: 'sciences@gcuniversity.edu.et',
            phone: '+251-11-123-4571'
          },
          allPrograms: [
            { 
              name: 'BSc Biology', 
              description: 'Life sciences and research', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1559548331-f9cb98001426?w=400&h=300&fit=crop',
              likes: 142,
              dislikes: 7,
              details: 'Comprehensive study of living organisms and biological processes. Excellent foundation for medical school, research, and biotechnology careers.',
              curriculum: ['Cell Biology', 'Genetics', 'Ecology', 'Molecular Biology', 'Biotechnology', 'Research Methods']
            },
            { 
              name: 'BSc Chemistry', 
              description: 'Chemical sciences', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=400&h=300&fit=crop',
              likes: 118,
              dislikes: 9,
              details: 'Study of matter, its properties, and chemical reactions. Essential for careers in pharmaceuticals, materials science, and chemical research.',
              curriculum: ['Organic Chemistry', 'Inorganic Chemistry', 'Physical Chemistry', 'Analytical Chemistry', 'Spectroscopy', 'Laboratory Techniques']
            },
            { 
              name: 'BSc Physics', 
              description: 'Physical sciences and research', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1636466497217-26a8cbeaf0aa?w=400&h=300&fit=crop',
              likes: 95,
              dislikes: 6,
              details: 'Fundamental study of matter, energy, and their interactions. Excellent preparation for engineering, research, and technology careers.',
              curriculum: ['Classical Mechanics', 'Electromagnetism', 'Quantum Physics', 'Thermodynamics', 'Optics', 'Experimental Physics']
            }
          ],
          facilities: ['Biology Research Labs', 'Chemistry Laboratory', 'Physics Lab', 'Greenhouse', 'Observatory', 'Research Equipment Center']
        },
        {
          id: 6,
          name: 'Social Sciences',
          description: 'Understanding society and human behavior through psychology, sociology, and political science.',
          image: '/images/departments/social-sciences.jpg',
          graduationImage: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=1200&h=600&fit=crop&crop=faces',
          graduationYear: '2024',
          colorClass: 'bg-indigo-600',
          icon: 'UsersIcon',
          programs: 5,
          students: 1890,
          faculty: 28,
          topPrograms: ['Psychology', 'Sociology', 'Political Science'],
          fullDescription: 'The Social Sciences department examines human behavior, society, and political systems through interdisciplinary approaches.',
          head: 'Dr. Robert Taylor',
          contact: {
            email: 'social@gcuniversity.edu.et',
            phone: '+251-11-123-4572'
          },
          allPrograms: [
            { 
              name: 'BSc Psychology', 
              description: 'Human behavior and mental processes', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=300&fit=crop',
              likes: 167,
              dislikes: 8,
              details: 'Scientific study of human behavior and mental processes. Excellent foundation for careers in counseling, research, and human resources.',
              curriculum: ['Cognitive Psychology', 'Social Psychology', 'Abnormal Psychology', 'Research Methods', 'Statistics', 'Counseling Techniques']
            },
            { 
              name: 'BSc Sociology', 
              description: 'Society and social relationships', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=400&h=300&fit=crop',
              likes: 129,
              dislikes: 11,
              details: 'Study of society, social institutions, and social relationships. Prepare for careers in social work, public policy, and community development.',
              curriculum: ['Social Theory', 'Research Methods', 'Social Inequality', 'Urban Sociology', 'Criminology', 'Social Policy']
            },
            { 
              name: 'BSc Political Science', 
              description: 'Politics and governance', 
              duration: '4 years', 
              type: 'Undergraduate',
              image: 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=400&h=300&fit=crop',
              likes: 156,
              dislikes: 14,
              details: 'Study of political systems, government, and international relations. Excellent preparation for careers in law, diplomacy, and public service.',
              curriculum: ['Political Theory', 'Comparative Politics', 'International Relations', 'Public Policy', 'Constitutional Law', 'Political Economy']
            }
          ],
          facilities: ['Psychology Lab', 'Research Center', 'Interview Rooms', 'Data Analysis Lab', 'Community Outreach Center', 'Social Research Hub']
        }
      ],
      featuredPrograms: [
        {
          id: 1,
          name: 'BSc Computer Science',
          description: 'Comprehensive program covering programming, algorithms, and software development.',
          duration: '4 years',
          type: 'Undergraduate',
          colorClass: 'bg-blue-600',
          icon: 'ComputerDesktopIcon'
        },
        {
          id: 2,
          name: 'Doctor of Medicine',
          description: 'Professional medical degree with clinical training and research opportunities.',
          duration: '6 years',
          type: 'Professional',
          colorClass: 'bg-red-500',
          icon: 'HeartIcon'
        },
        {
          id: 3,
          name: 'BSc Civil Engineering',
          description: 'Infrastructure design, construction management, and sustainable development.',
          duration: '5 years',
          type: 'Undergraduate',
          colorClass: 'bg-orange-600',
          icon: 'BuildingOffice2Icon'
        },
        {
          id: 4,
          name: 'MBA',
          description: 'Advanced business administration with leadership and strategic management focus.',
          duration: '2 years',
          type: 'Graduate',
          colorClass: 'bg-green-600',
          icon: 'BriefcaseIcon'
        }
      ]
    }
  },
  mounted() {
    this.scrollToDepartmentHash();
  },
  methods: {
    departmentSlug(department) {
      return department.name
        .toLowerCase()
        .replace(/&/g, 'and')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    },
    scrollToDepartmentHash() {
      const hash = this.$route.hash;
      if (!hash) return;
      this.$nextTick(() => {
        const el = document.querySelector(hash);
        if (el) {
          el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    },
    selectDepartment(department) {
      this.selectedDepartment = department;
    },
    showProgramDetails(program) {
      this.selectedProgram = program;
    },
    applyForProgram(program) {
      // Store program data and redirect to application form
      localStorage.setItem('selectedProgram', JSON.stringify(program));
      this.$router.push('/apply');
    },
    getCoursePreview(courseName) {
      const courseDetails = this.getCourseDetails(courseName);
      return courseDetails.description.split('.')[0] + '.';
    },
    showCourseModal(courseName) {
      const courseDetails = this.getCourseDetails(courseName);
      this.selectedCourse = {
        name: courseName,
        ...courseDetails
      };
    },
    getCourseDetails(course) {
      // Enhanced course details with comprehensive information
      const courseDetails = {
        // Computer Science Courses
        'Programming Fundamentals': {
          description: 'Introduction to programming concepts using modern languages like Python and Java. Students learn fundamental programming constructs, problem-solving techniques, and software development best practices.',
          prerequisites: 'Basic Mathematics',
          credits: 4,
          level: 'Undergraduate',
          instructor: 'Dr. Sarah Johnson',
          format: 'Lecture + Lab',
          duration: '15 weeks',
          schedule: 'Mon/Wed/Fri 9:00-10:30 AM',
          objectives: [
            'Master fundamental programming concepts and syntax',
            'Develop problem-solving skills using algorithmic thinking',
            'Understand object-oriented programming principles',
            'Build small to medium-sized software applications'
          ],
          topics: [
            'Variables, Data Types, and Operators',
            'Control Structures (Loops, Conditionals)',
            'Functions and Modular Programming',
            'Arrays and Data Structures',
            'Object-Oriented Programming Basics',
            'File I/O and Exception Handling',
            'Software Testing and Debugging',
            'Final Project Development'
          ],
          assessments: [
            { type: 'Programming Assignments', weight: 40 },
            { type: 'Midterm Exam', weight: 25 },
            { type: 'Final Project', weight: 25 },
            { type: 'Class Participation', weight: 10 }
          ],
          resources: [
            'Official Python/Java Documentation',
            'Online Coding Platform (Repl.it/CodeHS)',
            'Programming Textbooks',
            'Lab Computer Access',
            'Tutor Sessions (Twice Weekly)'
          ]
        },
        'Data Structures & Algorithms': {
          description: 'Essential data structures and algorithmic problem-solving techniques. Covers implementation and analysis of fundamental algorithms with focus on efficiency and optimization.',
          prerequisites: 'Programming Fundamentals',
          credits: 4,
          level: 'Undergraduate',
          instructor: 'Prof. Michael Chen',
          format: 'Lecture + Programming Lab',
          duration: '15 weeks',
          schedule: 'Tue/Thu 2:00-3:30 PM',
          objectives: [
            'Implement and analyze fundamental data structures',
            'Design efficient algorithms for complex problems',
            'Understand time and space complexity analysis',
            'Apply algorithms to real-world programming challenges'
          ],
          topics: [
            'Algorithm Analysis and Big O Notation',
            'Arrays, Linked Lists, and Dynamic Arrays',
            'Stacks, Queues, and Deques',
            'Trees: Binary Trees, BST, AVL Trees',
            'Hash Tables and Hash Functions',
            'Graph Algorithms: BFS, DFS, Shortest Path',
            'Sorting Algorithms: QuickSort, MergeSort, HeapSort',
            'Advanced Topics: Dynamic Programming'
          ],
          assessments: [
            { type: 'Programming Projects', weight: 45 },
            { type: 'Written Exams', weight: 35 },
            { type: 'Algorithm Design Competition', weight: 15 },
            { type: 'Peer Code Reviews', weight: 5 }
          ],
          resources: [
            'Algorithm Visualization Tools',
            'Competitive Programming Platforms',
            'Data Structures Textbook',
            'Online Judge Systems',
            'Algorithm Design Workshops'
          ]
        }
      };
      
      return courseDetails[course] || {
        description: 'Comprehensive course covering essential topics in this subject area with both theoretical foundations and practical applications.',
        prerequisites: 'Consult with academic advisor for specific prerequisites',
        credits: 3,
        level: 'Undergraduate',
        instructor: 'Faculty Member',
        format: 'Lecture + Tutorial',
        duration: '15 weeks',
        schedule: 'To be determined',
        objectives: [
          'Understand core concepts and principles',
          'Apply knowledge to practical problems',
          'Develop critical thinking skills',
          'Prepare for advanced coursework'
        ],
        topics: [
          'Introduction and Fundamentals',
          'Core Concepts and Theories',
          'Practical Applications',
          'Advanced Topics',
          'Review and Assessment'
        ],
        assessments: [
          { type: 'Assignments', weight: 30 },
          { type: 'Midterm Exam', weight: 30 },
          { type: 'Final Exam', weight: 30 },
          { type: 'Participation', weight: 10 }
        ],
        resources: [
          'Course Textbook',
          'Online Learning Materials',
          'Library Resources',
          'Laboratory Access',
          'Office Hours with Instructor'
        ]
      };
    },
    likeProgram(program) {
      if (program.userDisliked) {
        program.dislikes--;
        program.userDisliked = false;
      }
      
      if (program.userLiked) {
        program.likes--;
        program.userLiked = false;
      } else {
        program.likes++;
        program.userLiked = true;
      }
    },
    dislikeProgram(program) {
      if (program.userLiked) {
        program.likes--;
        program.userLiked = false;
      }
      
      if (program.userDisliked) {
        program.dislikes--;
        program.userDisliked = false;
      } else {
        program.dislikes++;
        program.userDisliked = true;
      }
    },
    
    toggleTopicLinks(index) {
      // Toggle dropdown for specific topic
      if (this.topicLinksOpen === index) {
        this.topicLinksOpen = null;
      } else {
        this.topicLinksOpen = index;
      }
    },
    
    getTopicLinks(topicName) {
      // Return real educational links for each topic
      const topicLinksMap = {
        // Computer Science Links
        'Variables, Data Types, and Operators': [
          {
            title: 'Python Variables Guide',
            description: 'Official Python documentation on variables',
            url: 'https://docs.python.org/3/tutorial/introduction.html#using-python-as-a-calculator'
          },
          {
            title: 'Java Data Types Tutorial',
            description: 'Oracle Java tutorials on primitive data types',
            url: 'https://docs.oracle.com/javase/tutorial/java/nutsandbolts/datatypes.html'
          },
          {
            title: 'MDN JavaScript Operators',
            description: 'Comprehensive guide to JavaScript operators',
            url: 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Expressions_and_Operators'
          }
        ],
        'Control Structures (Loops, Conditionals)': [
          {
            title: 'Python Control Flow',
            description: 'Official Python tutorial on control structures',
            url: 'https://docs.python.org/3/tutorial/controlflow.html'
          },
          {
            title: 'Java Control Statements',
            description: 'Oracle tutorial on Java control statements',
            url: 'https://docs.oracle.com/javase/tutorial/java/nutsandbolts/flow.html'
          },
          {
            title: 'C++ Loops and Conditionals',
            description: 'GeeksforGeeks guide to C++ control structures',
            url: 'https://www.geeksforgeeks.org/decision-making-c-c-else-nested-else/'
          }
        ],
        'Functions and Modular Programming': [
          {
            title: 'Python Functions',
            description: 'Complete guide to Python functions',
            url: 'https://docs.python.org/3/tutorial/controlflow.html#defining-functions'
          },
          {
            title: 'Java Methods',
            description: 'Oracle tutorial on Java methods',
            url: 'https://docs.oracle.com/javase/tutorial/java/javaOO/methods.html'
          },
          {
            title: 'Modular Programming Best Practices',
            description: 'Software engineering principles',
            url: 'https://en.wikipedia.org/wiki/Modular_programming'
          }
        ],
        'Arrays and Data Structures': [
          {
            title: 'Python Lists and Tuples',
            description: 'Python data structures documentation',
            url: 'https://docs.python.org/3/tutorial/datastructures.html'
          },
          {
            title: 'Java Arrays Tutorial',
            description: 'Oracle Java arrays tutorial',
            url: 'https://docs.oracle.com/javase/tutorial/java/nutsandbolts/arrays.html'
          },
          {
            title: 'Data Structures Visualization',
            description: 'Interactive data structure visualizations',
            url: 'https://visualgo.net/en'
          }
        ],
        'Object-Oriented Programming Basics': [
          {
            title: 'Java OOP Concepts',
            description: 'Oracle tutorial on object-oriented programming',
            url: 'https://docs.oracle.com/javase/tutorial/java/concepts/'
          },
          {
            title: 'Python Classes',
            description: 'Python classes and objects tutorial',
            url: 'https://docs.python.org/3/tutorial/classes.html'
          },
          {
            title: 'OOP Design Patterns',
            description: 'Common object-oriented design patterns',
            url: 'https://refactoring.guru/design-patterns'
          }
        ],
        'File I/O and Exception Handling': [
          {
            title: 'Python File Handling',
            description: 'Reading and writing files in Python',
            url: 'https://docs.python.org/3/tutorial/inputoutput.html#reading-and-writing-files'
          },
          {
            title: 'Java Exception Handling',
            description: 'Oracle tutorial on Java exceptions',
            url: 'https://docs.oracle.com/javase/tutorial/essential/exceptions/'
          },
          {
            title: 'Error Handling Best Practices',
            description: 'Software engineering error handling',
            url: 'https://stackoverflow.blog/2020/12/14/best-practices-for-error-handling/'
          }
        ],
        
        // Algorithm and Data Structure Links
        'Algorithm Analysis and Big O Notation': [
          {
            title: 'Big O Notation Guide',
            description: 'Comprehensive guide to algorithm complexity',
            url: 'https://www.khanacademy.org/computing/computer-science/algorithms/asymptotic-notation/a/big-o-notation'
          },
          {
            title: 'Time Complexity Analysis',
            description: 'MIT OpenCourseWare on algorithm analysis',
            url: 'https://ocw.mit.edu/courses/electrical-engineering-and-computer-science/'
          },
          {
            title: 'Big O Cheat Sheet',
            description: 'Quick reference for common algorithms',
            url: 'https://www.bigocheatsheet.com/'
          }
        ],
        'Stacks, Queues, and Deques': [
          {
            title: 'Stack Data Structure',
            description: 'GeeksforGeeks stack implementation',
            url: 'https://www.geeksforgeeks.org/stack-data-structure/'
          },
          {
            title: 'Queue Implementation',
            description: 'Comprehensive queue tutorial',
            url: 'https://www.geeksforgeeks.org/queue-data-structure/'
          },
          {
            title: 'Interactive Stack/Queue Visualizer',
            description: 'Visual learning tool for data structures',
            url: 'https://visualgo.net/en/list'
          }
        ],
        
        // Engineering Links  
        'Structural Analysis': [
          {
            title: 'Structural Analysis Fundamentals',
            description: 'MIT OpenCourseWare structural engineering',
            url: 'https://ocw.mit.edu/courses/civil-and-environmental-engineering/'
          },
          {
            title: 'Steel Structure Design',
            description: 'AISC steel construction manual resources',
            url: 'https://www.aisc.org/education/'
          },
          {
            title: 'Concrete Design Guidelines',
            description: 'ACI concrete design standards',
            url: 'https://www.concrete.org/education.aspx'
          }
        ],
        'Thermodynamics': [
          {
            title: 'Engineering Thermodynamics',
            description: 'MIT thermodynamics course materials',
            url: 'https://ocw.mit.edu/courses/mechanical-engineering/'
          },
          {
            title: 'NIST Thermodynamic Data',
            description: 'Official thermodynamic property data',
            url: 'https://webbook.nist.gov/chemistry/thermo-data/'
          },
          {
            title: 'Heat Transfer Basics',
            description: 'Fundamentals of heat transfer',
            url: 'https://web.stanford.edu/class/me200c/'
          }
        ],
        
        // Business Links
        'Strategic Management': [
          {
            title: 'Harvard Business Review',
            description: 'Strategic management articles and case studies',
            url: 'https://hbr.org/topic/strategy'
          },
          {
            title: 'McKinsey Strategy Insights',
            description: 'Global consulting firm strategy resources',
            url: 'https://www.mckinsey.com/business-functions/strategy-and-corporate-finance'
          },
          {
            title: 'Porter\'s Five Forces',
            description: 'Strategic analysis framework',
            url: 'https://www.investopedia.com/terms/p/porter.asp'
          }
        ],
        'Financial Analysis': [
          {
            title: 'CFA Institute Resources',
            description: 'Professional financial analysis standards',
            url: 'https://www.cfainstitute.org/en/membership/professional-development'
          },
          {
            title: 'SEC Financial Statements Guide',
            description: 'How to read financial statements',
            url: 'https://www.sec.gov/investor/pubs/begfinstmtguide.htm'
          },
          {
            title: 'Financial Modeling Best Practices',
            description: 'Excel financial modeling techniques',
            url: 'https://www.wallstreetprep.com/knowledge/financial-modeling/'
          }
        ],
        
        // Medical Links
        'Anatomy & Physiology': [
          {
            title: 'Khan Academy Anatomy',
            description: 'Free anatomy and physiology courses',
            url: 'https://www.khanacademy.org/science/health-and-medicine/human-anatomy-and-physiology'
          },
          {
            title: 'National Library of Medicine',
            description: 'Medical reference and research database',
            url: 'https://www.nlm.nih.gov/medlineplus/anatomyandphysiology.html'
          },
          {
            title: 'Interactive Anatomy Atlas',
            description: '3D anatomy visualization tool',
            url: 'https://www.zygotebody.com/'
          }
        ],
        'Pharmacology': [
          {
            title: 'FDA Drug Information',
            description: 'Official drug approval and safety information',
            url: 'https://www.fda.gov/drugs'
          },
          {
            title: 'PubMed Pharmacology',
            description: 'Pharmacology research database',
            url: 'https://pubmed.ncbi.nlm.nih.gov/'
          },
          {
            title: 'Pharmacokinetics Tutorial',
            description: 'Drug absorption and metabolism',
            url: 'https://www.pharmpress.com/'
          }
        ],
        
        // Science Links
        'Cell Biology': [
          {
            title: 'Nature Cell Biology',
            description: 'Leading cell biology research journal',
            url: 'https://www.nature.com/ncb/'
          },
          {
            title: 'Cell Biology Interactive',
            description: 'Virtual cell biology laboratory',
            url: 'https://www.cellsalive.com/'
          },
          {
            title: 'NCBI Cell Biology Resources',
            description: 'National Center for Biotechnology Information',
            url: 'https://www.ncbi.nlm.nih.gov/books/NBK9831/'
          }
        ],
        'Organic Chemistry': [
          {
            title: 'Khan Academy Organic Chemistry',
            description: 'Free organic chemistry tutorials',
            url: 'https://www.khanacademy.org/science/organic-chemistry'
          },
          {
            title: 'ChemSpider Database',
            description: 'Chemical structure database',
            url: 'http://www.chemspider.com/'
          },
          {
            title: 'Organic Reaction Mechanisms',
            description: 'Comprehensive reaction database',
            url: 'https://www.organic-chemistry.org/'
          }
        ],
        
        // Social Science Links
        'Cognitive Psychology': [
          {
            title: 'APA Psychology Resources',
            description: 'American Psychological Association materials',
            url: 'https://www.apa.org/science/about/psa/2011/05/cognitive-psychology'
          },
          {
            title: 'Cognitive Science Society',
            description: 'Research and publications in cognitive science',
            url: 'https://cognitivesciencesociety.org/'
          },
          {
            title: 'Stanford Psychology Labs',
            description: 'Current cognitive psychology research',
            url: 'https://psychology.stanford.edu/'
          }
        ],
        'Political Theory': [
          {
            title: 'Stanford Encyclopedia of Philosophy',
            description: 'Comprehensive political philosophy resource',
            url: 'https://plato.stanford.edu/entries/political-philosophy/'
          },
          {
            title: 'American Political Science Association',
            description: 'Professional political science resources',
            url: 'https://www.apsanet.org/'
          },
          {
            title: 'Political Theory Journal',
            description: 'Academic journal on political theory',
            url: 'https://journals.sagepub.com/home/ptx'
          }
        ]
      };

      // Return links for the topic, or default links if topic not found
      return topicLinksMap[topicName] || [
        {
          title: 'Wikipedia Reference',
          description: 'General information about ' + topicName,
          url: 'https://en.wikipedia.org/wiki/' + encodeURIComponent(topicName.replace(/\s+/g, '_'))
        },
        {
          title: 'Khan Academy',
          description: 'Free educational content',
          url: 'https://www.khanacademy.org/search?page_search_query=' + encodeURIComponent(topicName)
        },
        {
          title: 'MIT OpenCourseWare',
          description: 'Free MIT course materials',
          url: 'https://ocw.mit.edu/search/?q=' + encodeURIComponent(topicName)
        },
        {
          title: 'Coursera Courses',
          description: 'Online courses and specializations',
          url: 'https://www.coursera.org/search?query=' + encodeURIComponent(topicName)
        }
      ];
    },
    
    enrollInCourse(course) {
      // Reset enrollment data with random email to avoid duplicates
      const randomId = Math.floor(Math.random() * 10000);
      this.enrollmentData = {
        student_name: '',
        student_email: `student${randomId}@example.com`, // Pre-fill with unique email
        student_phone: '',
        student_id: '',
        course_name: course.name,
        department: this.selectedDepartment.name,
        program_type: course.type,
        motivation: '',
        prerequisites_met: []
      };
      
      this.enrollmentStatus = null; // Reset any previous status
      this.showEnrollmentForm = true;
    },
    
    async submitEnrollment() {
      this.isEnrolling = true;
      this.enrollmentStatus = null; // Clear previous status
      
      try {
        const response = await fetch('/api/v1/course-enrollments', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(this.enrollmentData)
        });
        
        const data = await response.json();
        
        if (data.success) {
          this.enrollmentStatus = {
            success: true,
            message: data.message,
            enrollment: data.enrollment
          };
          
          // Reset form
          this.enrollmentData = {
            student_name: '',
            student_email: '',
            student_phone: '',
            student_id: '',
            motivation: '',
            prerequisites_met: []
          };
        } else {
          this.enrollmentStatus = {
            success: false,
            message: data.message || 'Enrollment failed. Please try again.',
            errors: data.errors
          };
        }
      } catch (error) {
        console.error('Enrollment error:', error);
        this.enrollmentStatus = {
          success: false,
          message: 'Network error. Please check your connection and try again.',
          errors: null
        };
      } finally {
        this.isEnrolling = false;
      }
    },
    
    async viewSyllabus(course) {
      this.isSyllabusLoading = true;
      this.showSyllabusModal = true;
      
      try {
        const response = await fetch(`/api/v1/syllabus?course_name=${encodeURIComponent(course.name)}&department=${encodeURIComponent(this.selectedDepartment.name)}`);
        
        if (response.ok) {
          const data = await response.json();
          if (data.success) {
            this.currentSyllabus = data.syllabus;
          }
        } else {
          console.error('Failed to load syllabus:', response.statusText);
          this.currentSyllabus = null;
        }
      } catch (error) {
        console.error('Failed to load syllabus:', error);
        this.currentSyllabus = null;
      } finally {
        this.isSyllabusLoading = false;
      }
    },
    
    async downloadSyllabus() {
      if (!this.currentSyllabus) return;
      
      try {
        // Generate PDF syllabus
        const response = await fetch('/api/v1/syllabus/download', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          },
          body: JSON.stringify({
            course_name: this.currentSyllabus.course_name,
            department: this.currentSyllabus.department
          })
        });
        
        if (response.ok) {
          const blob = await response.blob();
          const url = window.URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = `${this.currentSyllabus.course_code}_Syllabus.pdf`;
          document.body.appendChild(a);
          a.click();
          window.URL.revokeObjectURL(url);
          document.body.removeChild(a);
        } else {
          alert('Failed to download syllabus. Please try again.');
        }
      } catch (error) {
        console.error('Download error:', error);
        alert('Failed to download syllabus. Please try again.');
      }
    },
    
    printSyllabus() {
      if (!this.currentSyllabus) return;
      
      // Create a new window with the syllabus content
      const printWindow = window.open('', '_blank');
      printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
          <title>${this.currentSyllabus.full_course_name} - Syllabus</title>
          <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
            .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
            .section { margin-bottom: 25px; }
            .section h3 { color: #2563eb; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
            .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
            .info-item { padding: 10px; background: #f8f9fa; border-radius: 5px; }
            ul { padding-left: 20px; }
            li { margin-bottom: 8px; }
            @media print { body { margin: 20px; } }
          </style>
        </head>
        <body>
          <div class="header">
            <h1>GC University</h1>
            <h2>${this.currentSyllabus.full_course_name}</h2>
            <p><strong>Department:</strong> ${this.currentSyllabus.department}</p>
          </div>
          
          <div class="info-grid">
            <div class="info-item">
              <strong>Instructor:</strong> ${this.currentSyllabus.instructor}<br>
              <strong>Email:</strong> ${this.currentSyllabus.instructor_email}<br>
              <strong>Credits:</strong> ${this.currentSyllabus.credits}
            </div>
            <div class="info-item">
              <strong>Semester:</strong> ${this.currentSyllabus.semester} ${this.currentSyllabus.academic_year}<br>
              <strong>Program:</strong> ${this.currentSyllabus.program_type}<br>
              <strong>Schedule:</strong> ${this.currentSyllabus.schedule || 'TBA'}
            </div>
          </div>
          
          <div class="section">
            <h3>Course Description</h3>
            <p>${this.currentSyllabus.course_description}</p>
          </div>
          
          ${this.currentSyllabus.learning_objectives ? `
            <div class="section">
              <h3>Learning Objectives</h3>
              <ul>
                ${this.currentSyllabus.learning_objectives.map(obj => `<li>${obj}</li>`).join('')}
              </ul>
            </div>
          ` : ''}
          
          ${this.currentSyllabus.course_outline ? `
            <div class="section">
              <h3>Course Outline</h3>
              <ul>
                ${this.currentSyllabus.course_outline.map(item => `<li>${item}</li>`).join('')}
              </ul>
            </div>
          ` : ''}
          
          ${this.currentSyllabus.assessment_methods ? `
            <div class="section">
              <h3>Assessment Methods</h3>
              <ul>
                ${this.currentSyllabus.assessment_methods.map(assessment => 
                  `<li><strong>${assessment.type} (${assessment.weight}%):</strong> ${assessment.description}</li>`
                ).join('')}
              </ul>
            </div>
          ` : ''}
          
          ${this.currentSyllabus.required_textbooks ? `
            <div class="section">
              <h3>Required Textbooks</h3>
              <ul>
                ${this.currentSyllabus.required_textbooks.map(book => `<li>${book}</li>`).join('')}
              </ul>
            </div>
          ` : ''}
          
          <div class="section">
            <h3>Policies</h3>
            <p><strong>Attendance:</strong> ${this.currentSyllabus.attendance_policy}</p>
            <p><strong>Late Policy:</strong> ${this.currentSyllabus.late_policy}</p>
            <p><strong>Academic Integrity:</strong> ${this.currentSyllabus.academic_integrity}</p>
          </div>
          
        </body>
        </html>
      `);
      printWindow.document.close();
      printWindow.print();
    },

    closeSyllabusModal() {
      this.showSyllabusModal = false;
      this.currentSyllabus = null;
    },
    
    closeEnrollmentForm() {
      this.showEnrollmentForm = false;
      this.enrollmentStatus = null;
    }
  }
}
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>