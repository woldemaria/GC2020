<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
          <h1 class="text-5xl font-bold mb-6">About GC University</h1>
          <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Established in 1995, GC University has been at the forefront of higher education in Ethiopia, 
            nurturing minds and shaping the future leaders of our nation.
          </p>
          <div class="mt-6 flex flex-wrap items-center justify-center gap-4 text-sm">
            <span class="rounded-full bg-white/10 px-4 py-2 backdrop-blur-sm">
              Accreditation: Ministry of Education, Ethiopia
            </span>
            <a
              href="https://gcuniversity.edu.et"
              target="_blank"
              rel="noopener noreferrer"
              class="rounded-full bg-white/10 px-4 py-2 backdrop-blur-sm text-[#f6d98c] hover:bg-white/20 transition"
            >
              https://gcuniversity.edu.et
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 border-l-4 border-blue-500">
            <h2 class="text-3xl font-bold text-blue-900 mb-6 flex items-center">
              <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
              Our Mission
            </h2>
            <p class="text-gray-700 text-lg leading-relaxed">
              To provide world-class education that empowers students with knowledge, skills, and values 
              necessary to excel in their chosen fields and contribute meaningfully to society. We are 
              committed to fostering innovation, critical thinking, and ethical leadership.
            </p>
          </div>
          
          <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border-l-4 border-green-500">
            <h2 class="text-3xl font-bold text-green-900 mb-6 flex items-center">
              <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              Our Vision
            </h2>
            <p class="text-gray-700 text-lg leading-relaxed">
              To be a leading center of academic excellence in Africa, recognized globally for producing 
              graduates who drive innovation, promote sustainable development, and lead positive change 
              in their communities and beyond.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Statistics -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">By the Numbers</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="text-4xl font-bold text-blue-600 mb-2">15,000+</div>
            <div class="text-gray-600">Active Students</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold text-green-600 mb-2">800+</div>
            <div class="text-gray-600">Faculty Members</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold text-purple-600 mb-2">50,000+</div>
            <div class="text-gray-600">Alumni Worldwide</div>
          </div>
          <div class="text-center">
            <div class="text-4xl font-bold text-orange-600 mb-2">95%</div>
            <div class="text-gray-600">Employment Rate</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Leadership -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Leadership Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="leader in leadership" :key="leader.id" class="text-center">
            <div class="relative mb-6">
              <img :src="leader.photo" :alt="leader.name" class="w-48 h-48 rounded-full mx-auto object-cover shadow-lg">
              <div class="absolute inset-0 w-48 h-48 rounded-full mx-auto border-4 border-blue-200"></div>
            </div>
            <h3 class="text-xl font-bold text-gray-900">{{ leader.name }}</h3>
            <p class="text-blue-600 font-medium mb-3">{{ leader.position }}</p>
            <p class="text-gray-600 text-sm">{{ leader.bio }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Campus Life -->
    <section class="py-16 bg-blue-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Campus Life</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="facility in facilities" :key="facility.id" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <img :src="facility.image" :alt="facility.name" class="w-full h-48 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-2">{{ facility.name }}</h3>
              <p class="text-gray-600">{{ facility.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- History Timeline -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Journey</h2>
        <div class="relative">
          <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-blue-200"></div>
          <div v-for="(milestone, index) in timeline" :key="milestone.year" 
               :class="['relative flex items-center justify-between mb-8', index % 2 === 0 ? 'flex-row' : 'flex-row-reverse']">
            <div class="w-5/12"></div>
            <div class="absolute left-1/2 transform -translate-x-1/2 w-8 h-8 bg-blue-600 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
              <div class="w-2 h-2 bg-white rounded-full"></div>
            </div>
            <div class="w-5/12">
              <div :class="['bg-gray-50 p-6 rounded-lg shadow-md', index % 2 === 0 ? 'text-right' : 'text-left']">
                <div class="text-2xl font-bold text-blue-600 mb-2">{{ milestone.year }}</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ milestone.title }}</h3>
                <p class="text-gray-600">{{ milestone.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Values -->
    <section class="py-16 bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="value in values" :key="value.id" class="text-center">
            <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <component :is="value.icon" class="w-8 h-8 text-white" />
            </div>
            <h3 class="text-xl font-bold mb-3">{{ value.name }}</h3>
            <p class="text-gray-300">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const leadership = ref([
  {
    id: 1,
    name: 'Dr. Abraham Tadesse',
    position: 'University President',
    photo: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face',
    bio: 'Leading GC University with over 20 years of experience in higher education and academic administration.'
  },
  {
    id: 2,
    name: 'Prof. Rahel Mekonnen',
    position: 'Vice President Academic Affairs',
    photo: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=300&fit=crop&crop=face',
    bio: 'Oversees all academic programs and curriculum development with expertise in educational innovation.'
  },
  {
    id: 3,
    name: 'Dr. Solomon Bekele',
    position: 'Dean of Students',
    photo: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face',
    bio: 'Dedicated to student success and campus life enhancement, ensuring holistic student development.'
  }
])

const facilities = ref([
  {
    id: 1,
    name: 'Modern Library',
    image: 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop',
    description: 'State-of-the-art library with digital resources, study spaces, and research facilities.'
  },
  {
    id: 2,
    name: 'Science Laboratories',
    image: 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?w=600&h=400&fit=crop',
    description: 'Fully equipped laboratories for hands-on learning and cutting-edge research.'
  },
  {
    id: 3,
    name: 'Sports Complex',
    image: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=400&fit=crop',
    description: 'Complete sports facilities including gymnasium, courts, and fitness center.'
  }
])

const timeline = ref([
  {
    year: '1995',
    title: 'Foundation',
    description: 'GC University was established with a vision to provide quality higher education in Ethiopia.'
  },
  {
    year: '2000',
    title: 'First Graduation',
    description: 'Celebrated our first graduation ceremony with 150 proud graduates across 5 departments.'
  },
  {
    year: '2005',
    title: 'Campus Expansion',
    description: 'Major campus expansion including new academic buildings and student facilities.'
  },
  {
    year: '2010',
    title: 'Research Excellence',
    description: 'Established research centers and began significant contribution to academic research.'
  },
  {
    year: '2015',
    title: 'International Recognition',
    description: 'Received international accreditation and established partnerships with global universities.'
  },
  {
    year: '2020',
    title: 'Digital Transformation',
    description: 'Implemented comprehensive digital learning platforms and smart campus technologies.'
  },
  {
    year: '2025',
    title: '30th Anniversary',
    description: 'Celebrating three decades of academic excellence and community impact.'
  }
])

const values = ref([
  {
    id: 1,
    name: 'Excellence',
    description: 'Pursuing the highest standards in education, research, and service.',
    icon: 'StarIcon'
  },
  {
    id: 2,
    name: 'Integrity',
    description: 'Upholding honesty, transparency, and ethical conduct in all endeavors.',
    icon: 'ShieldCheckIcon'
  },
  {
    id: 3,
    name: 'Innovation',
    description: 'Embracing creativity and new ideas to solve complex challenges.',
    icon: 'LightBulbIcon'
  },
  {
    id: 4,
    name: 'Community',
    description: 'Building strong relationships and serving our local and global communities.',
    icon: 'UsersIcon'
  }
])
</script>