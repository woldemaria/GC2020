<template>
  <div class="bg-[#edf0f3] px-4 pb-14 pt-6 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-[1500px]">
      <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.1fr_1.15fr_0.82fr]">
        
        <!-- ================= LEFT COLUMN ================= -->
        <aside class="space-y-6">
          
          <!-- Hero Announcement Card -->
          <section class="relative overflow-hidden rounded-[28px] bg-[#0a1122] shadow-[0_24px_60px_rgba(15,23,42,0.18)] text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.15),_transparent_34%),linear-gradient(rgba(5,10,20,0.4),rgba(5,10,20,0.7))]"></div>
            <img
              src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80"
              alt="Graduating students celebrating"
              class="absolute inset-0 h-full w-full object-cover opacity-60"
            />
            <div class="relative px-6 pb-6 pt-8 sm:px-8">
              <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.24em] text-[#f6d98c] backdrop-blur-md border border-white/10">
                <span class="w-1.5 h-1.5 rounded-full bg-[#f6d98c] animate-ping"></span>
                <span>Addis Ababa University</span>
              </div>
              
              <h1 class="max-w-[320px] text-3xl font-black leading-[1.05] tracking-[-0.03em] sm:text-[3.25rem]">
                Celebrating<br />
                <span class="text-[#f6d98c]">Your Achievement</span>
              </h1>
              
              <p class="mt-4 max-w-[340px] text-xs sm:text-sm leading-6 text-slate-200">
                Honoring graduates with verified academic distinction, research excellence, and leadership for Ethiopia's future.
              </p>

              <!-- Hero CTA Buttons -->
              <div class="mt-6 flex flex-wrap gap-2.5">
                <router-link
                  to="/student-profiles"
                  class="rounded-xl bg-[#f6d98c] px-4 py-2.5 text-xs sm:text-sm font-bold text-slate-900 shadow-lg shadow-[#f6d98c]/30 transition hover:-translate-y-0.5 hover:bg-[#f9e2a8]"
                >
                  Explore Graduates
                </router-link>
                <router-link
                  to="/verify-certificate"
                  class="rounded-xl border border-white/50 bg-white/10 px-4 py-2.5 text-xs sm:text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/20 flex items-center gap-1.5"
                >
                  <svg class="w-4 h-4 text-[#f6d98c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                  </svg>
                  <span>Verify Degree</span>
                </router-link>
              </div>
            </div>

            <!-- Live Dynamic Graduation Countdown Timer -->
            <div class="relative border-t border-white/10 bg-slate-900/60 px-5 pb-5 pt-4 backdrop-blur-md sm:px-6">
              <div class="mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-300 flex items-center justify-between">
                <span>Next Commencement Ceremony</span>
                <span class="text-[#f6d98c]">Live Countdown</span>
              </div>
              <div class="grid grid-cols-4 gap-2 text-center text-white">
                <div class="rounded-xl bg-white/10 px-2 py-2.5 border border-white/10">
                  <div class="text-xl sm:text-2xl font-black text-[#f6d98c]">{{ countdown.days }}</div>
                  <div class="mt-0.5 text-[9px] uppercase tracking-[0.16em] text-slate-300">Days</div>
                </div>
                <div class="rounded-xl bg-white/10 px-2 py-2.5 border border-white/10">
                  <div class="text-xl sm:text-2xl font-black text-[#f6d98c]">{{ countdown.hours }}</div>
                  <div class="mt-0.5 text-[9px] uppercase tracking-[0.16em] text-slate-300">Hours</div>
                </div>
                <div class="rounded-xl bg-white/10 px-2 py-2.5 border border-white/10">
                  <div class="text-xl sm:text-2xl font-black text-[#f6d98c]">{{ countdown.minutes }}</div>
                  <div class="mt-0.5 text-[9px] uppercase tracking-[0.16em] text-slate-300">Mins</div>
                </div>
                <div class="rounded-xl bg-white/10 px-2 py-2.5 border border-white/10">
                  <div class="text-xl sm:text-2xl font-black text-[#f6d98c]">{{ countdown.seconds }}</div>
                  <div class="mt-0.5 text-[9px] uppercase tracking-[0.16em] text-slate-300">Secs</div>
                </div>
              </div>
            </div>
          </section>

          <!-- Departments Section -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-4 flex items-center justify-between">
              <div>
                <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                  Faculties & Schools
                </div>
                <h2 class="mt-1 text-xl font-bold text-slate-900">
                  Academic Departments
                </h2>
              </div>
              <router-link
                to="/student-profiles"
                class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500 hover:text-blue-600 transition"
              >
                View all &rarr;
              </router-link>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <router-link
                v-for="department in departmentCards"
                :key="department.name"
                to="/student-profiles"
                class="group overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-sm transition hover:shadow-md hover:-translate-y-0.5 hover:border-blue-200"
              >
                <img
                  :src="department.image"
                  :alt="department.name"
                  class="h-20 w-full object-cover transition duration-300 group-hover:scale-105"
                />
                <div class="space-y-1 px-3 pb-3 pt-2">
                  <div class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">
                    {{ department.label }}
                  </div>
                  <h3 class="text-xs font-bold leading-tight text-slate-900 group-hover:text-blue-600">
                    {{ department.name }}
                  </h3>
                </div>
              </router-link>
            </div>
          </section>

          <!-- Featured Programs Section -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-4 flex items-center justify-between">
              <div>
                <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                  Academic Degrees
                </div>
                <h2 class="mt-1 text-xl font-bold text-slate-900">
                  Featured Programs
                </h2>
              </div>
              <router-link
                to="/student-profiles"
                class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500 hover:text-blue-600 transition"
              >
                View all &rarr;
              </router-link>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div
                v-for="program in programCards"
                :key="program.name"
                class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-sm transition hover:border-slate-300"
              >
                <img
                  :src="program.image"
                  :alt="program.name"
                  class="h-24 w-full object-cover"
                />
                <div class="space-y-1 px-3 pb-3 pt-2">
                  <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700">
                    {{ program.type }}
                  </span>
                  <h3 class="text-xs font-bold text-slate-900 leading-snug">
                    {{ program.name }}
                  </h3>
                </div>
              </div>
            </div>
          </section>
        </aside>

        <!-- ================= CENTER MAIN COLUMN ================= -->
        <main class="space-y-6">
          
          <!-- Interactive Certificate Verification Banner Widget -->
          <section class="rounded-[28px] bg-white p-6 shadow-[0_20px_50px_rgba(15,23,42,0.08)] border border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
              <div>
                <div class="flex items-center gap-2">
                  <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                  <span class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">Instant Verification</span>
                </div>
                <h2 class="mt-1 text-2xl font-black text-slate-900">
                  Certificate &amp; Degree Authenticator
                </h2>
              </div>
              <router-link
                to="/verify-certificate"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-xs font-bold transition self-start sm:self-auto border border-blue-200"
              >
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11a9 9 0 11-18 0 9 9 0 0118 0zm-9 7v1"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h4v4H4zm12 0h4v4h-4zM4 16h4v4H4z"/>
                </svg>
                <span>Live Camera QR Scanner &rarr;</span>
              </router-link>
            </div>

            <!-- Quick Code Verification Form -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="flex flex-col sm:flex-row gap-2">
                <input
                  v-model="quickCertCode"
                  type="text"
                  placeholder="Enter Code (e.g. IJPUAUH3LFMO or GC202367568)"
                  class="flex-1 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-mono uppercase text-slate-800 outline-none focus:ring-2 focus:ring-blue-500"
                  @keyup.enter="runQuickVerify"
                />
                <button
                  @click="runQuickVerify"
                  :disabled="isQuickVerifying || !quickCertCode.trim()"
                  class="rounded-xl bg-slate-900 hover:bg-slate-800 px-6 py-3 text-sm font-bold text-white transition disabled:opacity-50 flex items-center justify-center gap-2"
                >
                  <svg v-if="isQuickVerifying" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                  </svg>
                  <span>{{ isQuickVerifying ? 'Checking...' : 'Verify' }}</span>
                </button>
              </div>

              <!-- Quick Verification Result -->
              <div v-if="quickResult" class="mt-4">
                <div v-if="quickResult.verified" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                      </svg>
                    </div>
                    <div>
                      <div class="flex items-center gap-2">
                        <h4 class="font-bold text-emerald-900">{{ quickResult.certificate.graduate_name }}</h4>
                        <span class="text-[10px] font-bold bg-emerald-200 text-emerald-800 px-1.5 py-0.5 rounded">AUTHENTIC</span>
                      </div>
                      <p class="text-xs text-emerald-700 mt-0.5">
                        {{ quickResult.certificate.qualification }} &bull; GPA {{ quickResult.certificate.gpa }}
                      </p>
                      <p class="text-[11px] font-mono text-emerald-600 mt-0.5">
                        #{{ quickResult.certificate.certificate_number }}
                      </p>
                    </div>
                  </div>
                  <router-link
                    :to="`/verify-certificate/${quickResult.certificate.verification_code}`"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-sm transition whitespace-nowrap"
                  >
                    View Official Certificate &rarr;
                  </router-link>
                </div>

                <div v-else class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center justify-between">
                  <span>{{ quickResult.message || 'No active certificate found matching this code.' }}</span>
                  <router-link to="/verify-certificate" class="font-bold underline ml-2">Try QR Scanner &rarr;</router-link>
                </div>
              </div>
            </div>
          </section>

          <!-- Featured Showcase Section -->
          <section class="overflow-hidden rounded-[28px] bg-white shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-3.5">
              <div class="flex items-center gap-3">
                <div class="h-7 w-7 rounded-full bg-[#f6d98c] text-center text-[10px] font-black leading-7 text-slate-900">
                  AAU
                </div>
                <div class="text-[11px] font-bold uppercase tracking-[0.24em] text-slate-500">
                  Commencement Highlights
                </div>
              </div>
              <div class="flex items-center gap-2 text-[10px] font-semibold text-slate-500">
                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-slate-700 font-bold">Class of 2025</span>
              </div>
            </div>

            <div class="p-5">
              <div class="overflow-hidden rounded-[24px] bg-slate-900 relative">
                <img
                  src="https://images.unsplash.com/photo-1562771382-0e0bcf4e2f60?auto=format&fit=crop&w=1200&q=80"
                  alt="Addis Ababa University campus"
                  class="h-52 w-full object-cover opacity-85"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-5">
                  <div class="text-white">
                    <span class="px-2 py-0.5 rounded bg-blue-600 text-[10px] font-bold uppercase tracking-wider">Spotlight</span>
                    <h3 class="text-xl font-bold mt-1">Excellence in Research &amp; Digital Innovation</h3>
                  </div>
                </div>
              </div>

              <!-- University Metric Stat Cards -->
              <div class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-4">
                <div
                  v-for="item in statCards"
                  :key="item.label"
                  class="rounded-2xl border border-slate-100 bg-slate-50 p-3 shadow-sm hover:border-slate-200 transition"
                >
                  <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                    {{ item.label }}
                  </div>
                  <div class="mt-1 text-2xl font-black text-slate-900">
                    {{ item.value }}
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Interactive Graduation Gallery with Live Filters -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
              <div>
                <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                  Campus Moments
                </div>
                <h2 class="mt-1 text-xl font-bold text-slate-900">
                  Graduation Gallery
                </h2>
              </div>
              <!-- Filter Buttons -->
              <div class="flex flex-wrap gap-1 rounded-full bg-slate-100 p-1 text-[10px] font-bold uppercase tracking-[0.1em] text-slate-600">
                <button
                  v-for="filter in ['All', 'Ceremony', 'Campus', 'Innovation']"
                  :key="filter"
                  @click="activeGalleryFilter = filter"
                  :class="['rounded-full px-3 py-1.5 transition', activeGalleryFilter === filter ? 'bg-white text-slate-900 shadow-sm font-black' : 'hover:text-slate-900']"
                >
                  {{ filter }}
                </button>
              </div>
            </div>

            <!-- Filtered Gallery Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
              <div
                v-for="photo in filteredGalleryPhotos"
                :key="photo.title"
                class="group overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 cursor-pointer transition hover:shadow-md"
              >
                <div class="overflow-hidden">
                  <img
                    :src="photo.image"
                    :alt="photo.title"
                    class="h-28 w-full object-cover transition duration-300 group-hover:scale-105"
                  />
                </div>
                <div class="px-2.5 pb-2.5 pt-2">
                  <div class="text-[9px] font-bold uppercase tracking-[0.14em] text-blue-600">
                    {{ photo.tag }}
                  </div>
                  <div class="mt-0.5 text-xs font-bold text-slate-900 truncate">
                    {{ photo.title }}
                  </div>
                </div>
              </div>
            </div>
            
            <div class="mt-4 text-center">
              <router-link
                to="/graduation-gallery"
                class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 uppercase tracking-wider"
              >
                <span>Browse Full Photo Archive</span>
                <span>&rarr;</span>
              </router-link>
            </div>
          </section>

          <!-- Campus Quick Tools Grid -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-4">
              <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                Student &amp; Public Services
              </div>
              <h2 class="mt-1 text-xl font-bold text-slate-900">
                Campus Portal Tools
              </h2>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
              <div
                v-for="quick in quickActions"
                :key="quick.title"
                class="rounded-[22px] border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-sm flex flex-col justify-between"
              >
                <div>
                  <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-[#f6d98c] text-lg text-slate-900 shadow-sm">
                    {{ quick.icon }}
                  </div>
                  <h3 class="text-sm font-bold text-slate-900">
                    {{ quick.title }}
                  </h3>
                  <p class="mt-1 text-xs leading-5 text-slate-600">
                    {{ quick.description }}
                  </p>
                </div>
                <router-link
                  :to="quick.link"
                  class="mt-4 inline-flex items-center justify-between rounded-lg bg-slate-900 px-3 py-2 text-[10px] font-bold uppercase tracking-[0.14em] text-white hover:bg-slate-800 transition"
                >
                  <span>Access</span>
                  <span>&rarr;</span>
                </router-link>
              </div>
            </div>
          </section>

          <!-- Newsletter Subscription Banner -->
          <section class="rounded-[28px] bg-gradient-to-r from-slate-900 via-slate-800 to-[#1d2940] p-6 text-white shadow-xl">
            <div class="max-w-xl">
              <span class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#f6d98c]">
                Official Newsletter
              </span>
              <h3 class="mt-1 text-2xl font-black text-white">
                Stay Connected with AAU
              </h3>
              <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                Receive convocation updates, alumni achievements, graduation schedules, and official announcements.
              </p>

              <form @submit.prevent="handleSubscribe" class="mt-4 flex flex-col sm:flex-row gap-2">
                <input
                  v-model="newsletterEmail"
                  type="email"
                  required
                  placeholder="Enter your email address"
                  class="flex-1 rounded-xl border border-slate-700 bg-white/10 px-4 py-2.5 text-xs sm:text-sm text-white placeholder-slate-400 focus:outline-none focus:border-[#f6d98c]"
                />
                <button
                  type="submit"
                  class="rounded-xl bg-[#f6d98c] px-5 py-2.5 text-xs sm:text-sm font-bold text-slate-900 hover:bg-[#f9e2a8] transition shadow-md"
                >
                  {{ isSubscribed ? 'Subscribed ✓' : 'Subscribe' }}
                </button>
              </form>
              <p v-if="isSubscribed" class="mt-2 text-xs text-emerald-400 font-semibold">
                ✓ Thank you! You have been successfully subscribed to AAU updates.
              </p>
            </div>
          </section>
        </main>

        <!-- ================= RIGHT COLUMN ================= -->
        <aside class="space-y-6">
          
          <!-- Graduate Spotlight Card -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-3 flex items-center justify-between">
              <div>
                <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                  Graduate Spotlight
                </div>
                <h2 class="mt-1 text-xl font-bold text-slate-900">
                  Abebe Kebede
                </h2>
              </div>
              <span class="rounded-full bg-[#f6d98c] px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-900">
                Class 2023
              </span>
            </div>

            <div class="relative rounded-[22px] overflow-hidden mb-3">
              <img
                src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80"
                alt="Graduate portrait"
                class="h-52 w-full object-cover"
              />
              <div class="absolute bottom-2 left-2 right-2 bg-slate-900/80 backdrop-blur-md px-3 py-1.5 rounded-xl text-white text-xs flex justify-between items-center">
                <span class="font-bold">BSc Computer Science</span>
                <span class="text-[#f6d98c] font-bold">GPA 3.85</span>
              </div>
            </div>

            <div class="grid grid-cols-3 gap-2 text-center text-xs">
              <div class="rounded-xl bg-slate-50 p-2 border border-slate-100">
                <div class="text-base font-black text-slate-900">Magna</div>
                <div class="text-[8px] uppercase tracking-wider text-slate-500">Cum Laude</div>
              </div>
              <div class="rounded-xl bg-slate-50 p-2 border border-slate-100">
                <div class="text-base font-black text-slate-900">Verified</div>
                <div class="text-[8px] uppercase tracking-wider text-emerald-600 font-bold">100% Genuine</div>
              </div>
              <div class="rounded-xl bg-slate-50 p-2 border border-slate-100">
                <div class="text-base font-black text-slate-900">IJPUAU</div>
                <div class="text-[8px] uppercase tracking-wider text-slate-500">Code</div>
              </div>
            </div>

            <p class="mt-3 text-xs leading-relaxed text-slate-600">
              Completed research in scalable software architectures and recognized for academic excellence at Addis Ababa University.
            </p>

            <router-link
              to="/verify-certificate/IJPUAUH3LFMO"
              class="mt-3 block text-center w-full py-2 bg-slate-100 hover:bg-blue-50 hover:text-blue-700 text-slate-800 font-bold text-xs rounded-xl transition border border-slate-200"
            >
              Verify This Graduate &rarr;
            </router-link>
          </section>

          <!-- Campus Announcements & Dates -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-4 flex items-center justify-between">
              <div>
                <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                  Key Dates
                </div>
                <h2 class="mt-1 text-xl font-bold text-slate-900">
                  Upcoming Events
                </h2>
              </div>
            </div>

            <div class="space-y-3">
              <article
                v-for="event in upcomingEvents"
                :key="event.title"
                class="rounded-[20px] border border-slate-100 bg-slate-50 p-3.5 hover:border-slate-300 transition"
              >
                <div class="flex items-center justify-between text-xs">
                  <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600">{{ event.date }}</span>
                  <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-800 text-[9px] font-bold uppercase">{{ event.badge }}</span>
                </div>
                <h3 class="text-xs font-bold text-slate-900 mt-1">{{ event.title }}</h3>
                <p class="text-[11px] text-slate-600 mt-1 leading-normal">{{ event.description }}</p>
              </article>
            </div>
          </section>

          <!-- Alumni Testimonials -->
          <section class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
            <div class="mb-3">
              <div class="text-[10px] font-bold uppercase tracking-[0.28em] text-blue-600">
                Alumni Voice
              </div>
              <h2 class="mt-1 text-xl font-bold text-slate-900">
                Success Stories
              </h2>
            </div>

            <div class="space-y-3">
              <div
                v-for="story in alumniStories"
                :key="story.name"
                class="rounded-[20px] border border-slate-100 bg-slate-50 p-3"
              >
                <div class="flex items-center gap-2.5 mb-2">
                  <img
                    :src="story.avatar"
                    :alt="story.name"
                    class="h-9 w-9 rounded-full object-cover border border-slate-200"
                  />
                  <div>
                    <div class="font-bold text-xs text-slate-900">{{ story.name }}</div>
                    <div class="text-[10px] text-slate-500 font-semibold">{{ story.role }}</div>
                  </div>
                </div>
                <p class="text-xs leading-relaxed text-slate-600 italic">
                  “{{ story.message }}”
                </p>
              </div>
            </div>
          </section>
        </aside>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import axios from 'axios'

// Dynamic Countdown Timer to Commencement
const countdown = ref({
  days: 42,
  hours: 14,
  minutes: 28,
  seconds: 35
})

let timerInterval = null

const startCountdown = () => {
  // Target: July 15 of next graduation
  const targetDate = new Date()
  targetDate.setDate(targetDate.getDate() + 45)
  targetDate.setHours(9, 0, 0, 0)

  const update = () => {
    const now = new Date()
    const diff = targetDate.getTime() - now.getTime()

    if (diff > 0) {
      countdown.value.days = Math.floor(diff / (1000 * 60 * 60 * 24))
      countdown.value.hours = Math.floor((diff / (1000 * 60 * 60)) % 24)
      countdown.value.minutes = Math.floor((diff / (1000 * 60)) % 60)
      countdown.value.seconds = Math.floor((diff / 1000) % 60)
    }
  }

  update()
  timerInterval = setInterval(update, 1000)
}

onMounted(() => {
  startCountdown()
})

onUnmounted(() => {
  if (timerInterval) clearInterval(timerInterval)
})

// Quick Certificate Verification
const quickCertCode = ref('IJPUAUH3LFMO')
const isQuickVerifying = ref(false)
const quickResult = ref(null)

const runQuickVerify = async () => {
  if (!quickCertCode.value.trim()) return

  isQuickVerifying.value = true
  quickResult.value = null

  try {
    const response = await axios.post('/api/v1/certificates/verify', {
      code: quickCertCode.value.trim().toUpperCase(),
      method: 'manual_code'
    })
    quickResult.value = response.data
  } catch (error) {
    quickResult.value = error.response?.data || {
      verified: false,
      message: 'Certificate not found. Please verify the code or use the QR Scanner.'
    }
  } finally {
    isQuickVerifying.value = false
  }
}

// Gallery Live Filter
const activeGalleryFilter = ref('All')

const galleryPhotos = [
  {
    title: 'Grand Convocation Ceremony',
    tag: 'Ceremony',
    category: 'Ceremony',
    image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
  },
  {
    title: 'University Main Hall',
    tag: 'Campus',
    category: 'Campus',
    image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
  },
  {
    title: 'Engineering Innovation Lab',
    tag: 'Innovation',
    category: 'Innovation',
    image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80',
  },
  {
    title: 'Class of 2025 Honours',
    tag: 'Ceremony',
    category: 'Ceremony',
    image: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80',
  },
  {
    title: 'Technology Research Showcase',
    tag: 'Innovation',
    category: 'Innovation',
    image: 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=800&q=80',
  },
  {
    title: 'Graduates Outdoor Celebration',
    tag: 'Campus',
    category: 'Campus',
    image: 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
  },
]

const filteredGalleryPhotos = computed(() => {
  if (activeGalleryFilter.value === 'All') return galleryPhotos
  return galleryPhotos.filter(
    (photo) => photo.category.toLowerCase() === activeGalleryFilter.value.toLowerCase()
  )
})

// Newsletter
const newsletterEmail = ref('')
const isSubscribed = ref(false)

const handleSubscribe = () => {
  if (!newsletterEmail.value) return
  isSubscribed.value = true
  newsletterEmail.value = ''
  setTimeout(() => {
    isSubscribed.value = false
  }, 6000)
}

// Department & Program Cards Data
const departmentCards = [
  {
    name: 'Computer Science & IT',
    slug: 'computer-science-it',
    label: 'Faculty',
    image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
  },
  {
    name: 'Engineering & Tech',
    slug: 'engineering',
    label: 'Faculty',
    image: 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
  },
  {
    name: 'Business & Management',
    slug: 'business-management',
    label: 'School',
    image: 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80',
  },
  {
    name: 'Medicine & Health',
    slug: 'medicine-health-sciences',
    label: 'College',
    image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80',
  },
]

const programCards = [
  {
    name: 'BSc Computer Science',
    type: 'Undergraduate',
    image: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80',
  },
  {
    name: 'MSc Software Engineering',
    type: 'Postgraduate',
    image: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
  },
  {
    name: 'BSc Cybersecurity',
    type: 'Undergraduate',
    image: 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=800&q=80',
  },
  {
    name: 'AI & Data Science',
    type: 'Specialization',
    image: 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=800&q=80',
  },
]

const statCards = [
  { label: 'Graduates', value: '12,450+' },
  { label: 'Faculties', value: '10' },
  { label: 'Programs', value: '45+' },
  { label: 'Verified', value: '100%' },
]

const quickActions = [
  {
    title: 'Student Portal',
    description: 'Access student records, graduation status and academic schedule.',
    icon: '🎓',
    link: '/student-dashboard',
  },
  {
    title: 'QR Verification',
    description: 'Instant mobile camera QR verification for degrees and certificates.',
    icon: '🔍',
    link: '/verify-certificate',
  },
  {
    title: 'Gown & Cap Service',
    description: 'Order and reserve your official graduation gown and cap package.',
    icon: '📜',
    link: '/gown-cap',
  },
]

const upcomingEvents = [
  {
    date: 'July 15',
    title: '48th Annual Commencement Ceremony',
    badge: 'Ceremony',
    description: 'Official university-wide graduation convocation at AAU Main Sports Stadium.',
  },
  {
    date: 'July 18',
    title: 'Graduate Career Fair 2026',
    badge: 'Careers',
    description: 'Over 50 leading technology, financial, and engineering employers hiring graduates.',
  },
  {
    date: 'August 02',
    title: 'Alumni Leadership Summit',
    badge: 'Alumni',
    description: 'Networking and mentorship forum connecting recent graduates with industry leaders.',
  },
]

const alumniStories = [
  {
    name: 'Nahom Ayele',
    role: 'Lead Data Engineer',
    avatar: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80',
    message: 'The rigorous curriculum and hands-on laboratory experience at AAU prepared me for global industry challenges.',
  },
  {
    name: 'Mekdes Solomon',
    role: 'Product Designer',
    avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
    message: 'Collaborative projects and supportive professors helped me cultivate leadership and creative confidence.',
  },
]
</script>

<style scoped>
.font-mono {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
}
</style>
