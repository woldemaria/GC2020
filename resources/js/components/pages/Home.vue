<template>
    <div class="bg-[#edf0f3] px-4 pb-12 pt-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-[1500px]">
            <div
                class="grid grid-cols-1 gap-6 xl:grid-cols-[1.1fr_1.15fr_0.82fr]"
            >
                <aside class="space-y-6">
                    <section
                        class="relative overflow-hidden rounded-[28px] bg-[#0a1122] shadow-[0_24px_60px_rgba(15,23,42,0.18)]"
                    >
                        <div
                            class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.15),_transparent_34%),linear-gradient(rgba(5,10,20,0.35),rgba(5,10,20,0.65))]"
                        ></div>
                        <img
                            src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80"
                            alt="Graduating student"
                            class="absolute inset-0 h-full w-full object-cover opacity-70"
                        />
                        <div class="relative px-6 pb-5 pt-8 sm:px-8">
                            <div
                                class="mb-5 text-[10px] font-semibold uppercase tracking-[0.32em] text-slate-200"
                            >
                                Addis Ababa University
                            </div>
                            <h1
                                class="max-w-[280px] text-4xl font-black leading-[0.96] tracking-[-0.04em] text-white sm:text-[3.5rem]"
                            >
                                Celebrating<br />
                                <span class="text-[#f6d98c]"
                                    >Your Achievement</span
                                >
                            </h1>
                            <p
                                class="mt-5 max-w-[350px] text-sm leading-6 text-slate-200"
                            >
                                Your hard work, dedication and perseverance have
                                brought you this far. We are proud to celebrate
                                your success and look forward to your bright
                                future.
                            </p>

                            <div class="mt-7 flex flex-wrap gap-3">
                                <router-link
                                    to="/student-profiles"
                                    class="rounded-xl bg-[#f6d98c] px-5 py-3 text-sm font-bold text-slate-900 shadow-lg shadow-[#f6d98c]/30 transition hover:-translate-y-0.5 hover:bg-[#f9e2a8]"
                                >
                                    Explore Graduates
                                </router-link>
                                <a
                                    href="https://www.youtube.com/results?search_query=addis+ababa+university+graduation"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="rounded-xl border border-white/50 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/20"
                                >
                                    Watch Video
                                </a>
                            </div>
                        </div>

                        <div
                            class="relative border-t border-white/10 bg-slate-900/40 px-5 pb-5 pt-4 backdrop-blur-sm sm:px-6"
                        >
                            <div
                                class="grid grid-cols-4 gap-2 text-center text-white"
                            >
                                <div class="rounded-xl bg-white/10 px-2 py-3">
                                    <div
                                        class="text-2xl font-black text-[#f6d98c]"
                                    >
                                        85
                                    </div>
                                    <div
                                        class="mt-1 text-[9px] uppercase tracking-[0.18em] text-slate-300"
                                    >
                                        Hours
                                    </div>
                                </div>
                                <div class="rounded-xl bg-white/10 px-2 py-3">
                                    <div
                                        class="text-2xl font-black text-[#f6d98c]"
                                    >
                                        12
                                    </div>
                                    <div
                                        class="mt-1 text-[9px] uppercase tracking-[0.18em] text-slate-300"
                                    >
                                        Months
                                    </div>
                                </div>
                                <div class="rounded-xl bg-white/10 px-2 py-3">
                                    <div
                                        class="text-2xl font-black text-[#f6d98c]"
                                    >
                                        34
                                    </div>
                                    <div
                                        class="mt-1 text-[9px] uppercase tracking-[0.18em] text-slate-300"
                                    >
                                        Days
                                    </div>
                                </div>
                                <div class="rounded-xl bg-white/10 px-2 py-3">
                                    <div
                                        class="text-2xl font-black text-[#f6d98c]"
                                    >
                                        20
                                    </div>
                                    <div
                                        class="mt-1 text-[9px] uppercase tracking-[0.18em] text-slate-300"
                                    >
                                        Seconds
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Our Departments
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Explore Our Departments
                                </h2>
                            </div>
                            <button
                                class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"
                            >
                                View all
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <router-link
                                v-for="department in departmentCards"
                                :key="department.name"
                                :to="`/departments#${department.slug}`"
                                class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-sm transition hover:shadow-md hover:-translate-y-0.5"
                            >
                                <img
                                    :src="department.image"
                                    :alt="department.name"
                                    class="h-20 w-full object-cover"
                                />
                                <div class="space-y-2 px-3 pb-3 pt-2">
                                    <div
                                        class="text-[11px] font-semibold text-slate-500"
                                    >
                                        {{ department.label }}
                                    </div>
                                    <h3
                                        class="text-sm font-bold leading-snug text-slate-900"
                                    >
                                        {{ department.name }}
                                    </h3>
                                </div>
                            </router-link>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Programs
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Featured Academic Programs
                                </h2>
                            </div>
                            <button
                                class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500"
                            >
                                View all
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div
                                v-for="program in programCards"
                                :key="program.name"
                                class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50 shadow-sm"
                            >
                                <img
                                    :src="program.image"
                                    :alt="program.name"
                                    class="h-28 w-full object-cover"
                                />
                                <div class="space-y-1 px-3 pb-3 pt-2">
                                    <div
                                        class="text-[11px] font-semibold uppercase tracking-[0.1em] text-slate-500"
                                    >
                                        {{ program.type }}
                                    </div>
                                    <h3
                                        class="text-sm font-bold text-slate-900"
                                    >
                                        {{ program.name }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </section>
                </aside>

                <main class="space-y-6">
                    <section
                        class="overflow-hidden rounded-[28px] bg-white shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div
                            class="flex items-center justify-between border-b border-slate-200 px-5 py-4"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-[#f6d98c] text-center text-[10px] font-black leading-8 text-slate-900"
                                >
                                    AAU
                                </div>
                                <div
                                    class="text-[12px] font-semibold uppercase tracking-[0.24em] text-slate-500"
                                >
                                    Home / Departments / Programs
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                            >
                                <span>2025</span>
                                <span
                                    class="rounded-full bg-slate-100 px-2 py-1 text-slate-700"
                                    >EN</span
                                >
                            </div>
                        </div>

                        <div class="p-5">
                            <div
                                class="overflow-hidden rounded-[24px] bg-slate-900"
                            >
                                <img
                                    src="https://images.unsplash.com/photo-1562771382-0e0bcf4e2f60?auto=format&fit=crop&w=1200&q=80"
                                    alt="Addis Ababa University campus"
                                    class="h-56 w-full object-cover opacity-80"
                                />
                            </div>

                            <div
                                class="mt-4 flex items-start justify-between gap-4"
                            >
                                <div>
                                    <div
                                        class="text-[10px] font-semibold uppercase tracking-[0.24em] text-slate-400"
                                    >
                                        Department
                                    </div>
                                    <h2
                                        class="mt-2 text-3xl font-black tracking-[-0.04em] text-slate-900"
                                    >
                                        Computer Science & IT
                                    </h2>
                                    <p
                                        class="mt-2 max-w-md text-sm leading-6 text-slate-600"
                                    >
                                        Building the next generation of
                                        innovators through quality education,
                                        research and practical learning for
                                        digital transformation.
                                    </p>
                                </div>
                                <div
                                    class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-right shadow-sm"
                                >
                                    <div
                                        class="text-[10px] uppercase tracking-[0.18em] text-slate-500"
                                    >
                                        Total Graduates
                                    </div>
                                    <div
                                        class="mt-2 text-2xl font-black text-slate-900"
                                    >
                                        12,458
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-5 grid grid-cols-2 gap-3 md:grid-cols-4"
                            >
                                <div
                                    v-for="item in statCards"
                                    :key="item.label"
                                    class="rounded-2xl border border-slate-200 bg-slate-50 p-3 shadow-sm"
                                >
                                    <div
                                        class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                                    >
                                        {{ item.label }}
                                    </div>
                                    <div
                                        class="mt-2 text-xl font-black text-slate-900"
                                    >
                                        {{ item.value }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Gallery
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Graduation Gallery
                                </h2>
                            </div>
                            <div
                                class="flex gap-2 rounded-full bg-slate-100 p-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500"
                            >
                                <button
                                    class="rounded-full bg-white px-3 py-2 text-slate-800 shadow-sm"
                                >
                                    All
                                </button>
                                <button class="rounded-full px-3 py-2">
                                    Departments
                                </button>
                                <button class="rounded-full px-3 py-2">
                                    Programs
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div
                                v-for="photo in galleryPhotos"
                                :key="photo.title"
                                class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50"
                            >
                                <img
                                    :src="photo.image"
                                    :alt="photo.title"
                                    class="h-28 w-full object-cover"
                                />
                                <div class="px-2.5 pb-2.5 pt-2">
                                    <div
                                        class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500"
                                    >
                                        {{ photo.tag }}
                                    </div>
                                    <div
                                        class="mt-1 text-xs font-bold text-slate-900"
                                    >
                                        {{ photo.title }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Quick access
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Campus Tools
                                </h2>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                            <div
                                v-for="quick in quickActions"
                                :key="quick.title"
                                class="rounded-[22px] border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-sm"
                            >
                                <div
                                    class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-[#f6d98c] text-lg text-slate-900"
                                >
                                    {{ quick.icon }}
                                </div>
                                <h3 class="text-base font-bold text-slate-900">
                                    {{ quick.title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-slate-600"
                                >
                                    {{ quick.description }}
                                </p>
                                <router-link
                                    :to="quick.link"
                                    class="mt-4 inline-flex rounded-lg bg-slate-900 px-3 py-2 text-[11px] font-bold uppercase tracking-[0.14em] text-white"
                                >
                                    Open
                                </router-link>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Latest updates
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Campus Updates
                                </h2>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <article
                                v-for="update in updates"
                                :key="update.title"
                                class="rounded-[22px] border border-slate-200 bg-slate-50 p-4"
                            >
                                <div
                                    class="mb-2 flex items-center justify-between gap-3"
                                >
                                    <span
                                        class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                                    >
                                        {{ update.tag }}
                                    </span>
                                    <span class="text-xs text-slate-500">{{
                                        update.date
                                    }}</span>
                                </div>
                                <h3 class="text-base font-bold text-slate-900">
                                    {{ update.title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-slate-600"
                                >
                                    {{ update.summary }}
                                </p>
                            </article>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Why choose us
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    A future built on opportunity
                                </h2>
                            </div>
                        </div>

                        <div class="grid gap-3 md:grid-cols-3">
                            <div
                                v-for="reason in whyChooseUs"
                                :key="reason.title"
                                class="rounded-[22px] border border-slate-200 bg-slate-50 p-4"
                            >
                                <div
                                    class="mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-[#f6d98c] text-lg text-slate-900"
                                >
                                    {{ reason.icon }}
                                </div>
                                <h3 class="text-base font-bold text-slate-900">
                                    {{ reason.title }}
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-slate-600"
                                >
                                    {{ reason.description }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Events & scholarships
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Upcoming opportunities
                                </h2>
                            </div>
                        </div>

                        <div class="grid gap-3 lg:grid-cols-[1.2fr_0.8fr]">
                            <div class="space-y-3">
                                <article
                                    v-for="event in upcomingEvents"
                                    :key="event.title"
                                    class="rounded-[22px] border border-slate-200 bg-slate-50 p-4"
                                >
                                    <div
                                        class="flex items-start justify-between gap-4"
                                    >
                                        <div>
                                            <div
                                                class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                                            >
                                                {{ event.date }}
                                            </div>
                                            <h3
                                                class="mt-2 text-base font-bold text-slate-900"
                                            >
                                                {{ event.title }}
                                            </h3>
                                        </div>
                                        <span
                                            class="rounded-full bg-[#f6d98c] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-900"
                                        >
                                            {{ event.badge }}
                                        </span>
                                    </div>
                                    <p
                                        class="mt-2 text-sm leading-6 text-slate-600"
                                    >
                                        {{ event.description }}
                                    </p>
                                </article>
                            </div>

                            <div
                                class="rounded-[24px] border border-slate-200 bg-slate-50 p-4"
                            >
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500"
                                >
                                    Scholarship spotlight
                                </div>
                                <h3
                                    class="mt-2 text-xl font-black text-slate-900"
                                >
                                    Excellence Award
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-slate-600"
                                >
                                    Merit-based funding for high-achieving
                                    students in STEM, business, and health
                                    sciences.
                                </p>
                                <div
                                    class="mt-4 rounded-2xl bg-slate-900 p-3 text-white"
                                >
                                    <div
                                        class="text-[10px] uppercase tracking-[0.18em] text-slate-300"
                                    >
                                        Award value
                                    </div>
                                    <div class="mt-2 text-2xl font-black">
                                        $8,000
                                    </div>
                                </div>
                                <router-link
                                    to="/apply"
                                    class="mt-4 inline-flex rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white"
                                >
                                    Learn More
                                </router-link>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-gradient-to-r from-slate-900 via-slate-800 to-[#1d2940] p-5 text-white shadow-[0_20px_50px_rgba(15,23,42,0.12)]"
                    >
                        <div class="grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-300"
                                >
                                    Stay connected
                                </div>
                                <h2 class="mt-2 text-2xl font-bold text-white">
                                    Subscribe for campus updates
                                </h2>
                                <p
                                    class="mt-2 text-sm leading-6 text-slate-300"
                                >
                                    Get admission news, event reminders, and
                                    student success stories delivered to your
                                    inbox.
                                </p>

                                <div
                                    class="mt-4 flex flex-col gap-3 sm:flex-row"
                                >
                                    <input
                                        type="email"
                                        placeholder="Your email address"
                                        class="w-full rounded-xl border border-slate-600 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-slate-400 focus:border-[#f6d98c]"
                                    />
                                    <button
                                        class="rounded-xl bg-[#f6d98c] px-5 py-3 text-sm font-bold text-slate-900"
                                    >
                                        Join Now
                                    </button>
                                </div>
                            </div>

                            <div
                                class="rounded-[24px] border border-white/10 bg-white/5 p-4"
                            >
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-300"
                                >
                                    Admissions
                                </div>
                                <h3 class="mt-2 text-xl font-black text-white">
                                    Start your application
                                </h3>
                                <p
                                    class="mt-2 text-sm leading-6 text-slate-300"
                                >
                                    Explore our programs and begin your future
                                    with one of Ethiopia’s leading universities.
                                </p>
                                <router-link
                                    to="/apply"
                                    class="mt-4 inline-flex rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-900"
                                >
                                    Apply Today
                                </router-link>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Testimonials
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    What students say
                                </h2>
                            </div>
                        </div>

                        <div class="grid gap-3 md:grid-cols-3">
                            <div
                                v-for="testimonial in testimonials"
                                :key="testimonial.name"
                                class="rounded-[22px] border border-slate-200 bg-slate-50 p-4"
                            >
                                <div class="mb-3 flex items-center gap-3">
                                    <img
                                        :src="testimonial.avatar"
                                        :alt="testimonial.name"
                                        class="h-11 w-11 rounded-full object-cover"
                                    />
                                    <div>
                                        <div class="font-bold text-slate-900">
                                            {{ testimonial.name }}
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            {{ testimonial.program }}
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm leading-6 text-slate-600">
                                    “{{ testimonial.quote }}”
                                </p>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Verification
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Certificate Verification
                                </h2>
                            </div>
                        </div>

                        <div
                            class="rounded-[24px] border border-slate-200 bg-slate-50 p-4"
                        >
                            <div class="grid grid-cols-[1fr_auto] gap-4">
                                <div>
                                    <label
                                        class="block text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                                        >Enter certificate code</label
                                    >
                                    <input
                                        value="AU-2025-1845"
                                        class="mt-3 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 outline-none"
                                    />
                                </div>
                                <div class="flex items-end">
                                    <button
                                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white"
                                    >
                                        Verify
                                    </button>
                                </div>
                            </div>

                            <div
                                class="mt-4 flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-3"
                            >
                                <div
                                    class="flex h-24 w-24 items-center justify-center rounded-xl bg-slate-100"
                                >
                                    <div class="grid grid-cols-3 gap-1">
                                        <span
                                            v-for="n in 9"
                                            :key="n"
                                            class="h-2 w-2 rounded-sm bg-slate-900"
                                        ></span>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500"
                                    >
                                        Verification status
                                    </div>
                                    <div
                                        class="mt-2 text-lg font-black text-slate-900"
                                    >
                                        Certificate Verified
                                    </div>
                                    <div class="mt-1 text-sm text-slate-600">
                                        Student ID: 78412 • Cumulative GPA 3.82
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                <aside class="space-y-6">
                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div
                                class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                            >
                                Department
                            </div>
                            <span
                                class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-emerald-700"
                                >Active</span
                            >
                        </div>

                        <h2
                            class="text-3xl font-black tracking-[-0.04em] text-slate-900"
                        >
                            Computer Science &amp; IT
                        </h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            The Department of Computer Science &amp; IT offers
                            world-class education, hands-on practice and strong
                            research preparation for students pursuing
                            future-focused careers in technology and innovation.
                        </p>

                        <div class="mt-5 space-y-3 text-sm text-slate-700">
                            <div
                                class="flex items-center justify-between border-b border-slate-200 pb-2"
                            >
                                <span>Undergraduate</span>
                                <span class="font-bold text-slate-900"
                                    >8,274</span
                                >
                            </div>
                            <div
                                class="flex items-center justify-between border-b border-slate-200 pb-2"
                            >
                                <span>Postgraduate</span>
                                <span class="font-bold text-slate-900"
                                    >2,346</span
                                >
                            </div>
                            <div
                                class="flex items-center justify-between border-b border-slate-200 pb-2"
                            >
                                <span>Research Labs</span>
                                <span class="font-bold text-slate-900">14</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Industry Partners</span>
                                <span class="font-bold text-slate-900">36</span>
                            </div>
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <div
                                    class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                                >
                                    Graduate
                                </div>
                                <h2
                                    class="mt-2 text-2xl font-bold text-slate-900"
                                >
                                    Biniam Tefaye
                                </h2>
                            </div>
                            <div
                                class="rounded-full bg-[#f6d98c] px-2 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-900"
                            >
                                Class 2025
                            </div>
                        </div>

                        <img
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80"
                            alt="Graduate portrait"
                            class="h-60 w-full rounded-[24px] object-cover"
                        />

                        <div class="mt-4 grid grid-cols-4 gap-2 text-center">
                            <div class="rounded-xl bg-slate-50 p-2">
                                <div class="text-xl font-black text-slate-900">
                                    14
                                </div>
                                <div
                                    class="text-[9px] uppercase tracking-[0.14em] text-slate-500"
                                >
                                    Projects
                                </div>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-2">
                                <div class="text-xl font-black text-slate-900">
                                    48
                                </div>
                                <div
                                    class="text-[9px] uppercase tracking-[0.14em] text-slate-500"
                                >
                                    Awards
                                </div>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-2">
                                <div class="text-xl font-black text-slate-900">
                                    12,458
                                </div>
                                <div
                                    class="text-[9px] uppercase tracking-[0.14em] text-slate-500"
                                >
                                    Students
                                </div>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-2">
                                <div class="text-xl font-black text-slate-900">
                                    3.92
                                </div>
                                <div
                                    class="text-[9px] uppercase tracking-[0.14em] text-slate-500"
                                >
                                    GPA
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-sm leading-6 text-slate-600">
                            Biniam Tefaye graduated with a Bachelor of Science
                            in Computer Science and a strong interest in
                            software engineering and AI-driven civic innovation.
                        </div>
                    </section>

                    <section
                        class="rounded-[28px] bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)]"
                    >
                        <div class="mb-4">
                            <div
                                class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                            >
                                Alumni voice
                            </div>
                            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                Success stories
                            </h2>
                        </div>

                        <div class="space-y-3">
                            <div
                                v-for="story in alumniStories"
                                :key="story.name"
                                class="rounded-[20px] border border-slate-200 bg-slate-50 p-3"
                            >
                                <div class="mb-2 flex items-center gap-3">
                                    <img
                                        :src="story.avatar"
                                        :alt="story.name"
                                        class="h-10 w-10 rounded-full object-cover"
                                    />
                                    <div>
                                        <div class="font-bold text-slate-900">
                                            {{ story.name }}
                                        </div>
                                        <div
                                            class="text-[10px] uppercase tracking-[0.18em] text-slate-500"
                                        >
                                            {{ story.role }}
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm leading-6 text-slate-600">
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
const departmentCards = [
    {
        name: "Computer Science & IT",
        slug: "computer-science-it",
        label: "Department",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80",
    },
    {
        name: "Engineering",
        slug: "engineering",
        label: "Department",
        image: "https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80",
    },
    {
        name: "Business & Management",
        slug: "business-management",
        label: "Department",
        image: "https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80",
    },
    {
        name: "Medicine & Health Sciences",
        slug: "medicine-health-sciences",
        label: "Department",
        image: "https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80",
    },
];

const programCards = [
    {
        name: "BSc Computer Science",
        type: "Undergraduate",
        image: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80",
    },
    {
        name: "MSc Software Engineering",
        type: "Graduate",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80",
    },
    {
        name: "BSc Cybersecurity",
        type: "Undergraduate",
        image: "https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=800&q=80",
    },
    {
        name: "AI & Data Science",
        type: "Future Skills",
        image: "https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=800&q=80",
    },
];

const statCards = [
    { label: "Students", value: "6,234" },
    { label: "Programs", value: "18" },
    { label: "Faculty", value: "320" },
    { label: "Research", value: "78" },
];

const galleryPhotos = [
    {
        title: "Convocation",
        tag: "Ceremony",
        image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80",
    },
    {
        title: "Campus Life",
        tag: "Campus",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80",
    },
    {
        title: "Leadership",
        tag: "Students",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80",
    },
    {
        title: "Research",
        tag: "Innovation",
        image: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80",
    },
    {
        title: "Graduates",
        tag: "Class",
        image: "https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80",
    },
    {
        title: "Awards",
        tag: "Recognition",
        image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80",
    },
];

const quickActions = [
    {
        title: "Student Portal",
        description:
            "Access student resources, alumni updates and academic support tools.",
        icon: "🎓",
        link: "/student-dashboard",
    },
    {
        title: "Apply Now",
        description:
            "Start your application for admission and program enrolment.",
        icon: "📄",
        link: "/apply",
    },
    {
        title: "Alumni Network",
        description:
            "Reconnect with graduates, mentors and industry professionals.",
        icon: "🤝",
        link: "/alumni",
    },
];

const updates = [
    {
        tag: "Admissions",
        date: "May 12",
        title: "2025 intake applications now open",
        summary:
            "Submit your application before the final deadline and access scholarship guidance.",
    },
    {
        tag: "Research",
        date: "May 10",
        title: "New AI and data science lab launched",
        summary:
            "Students can now work on applied AI projects in partnership with industry leaders.",
    },
    {
        tag: "Events",
        date: "May 06",
        title: "Career fair brings 40 employers to campus",
        summary:
            "Meet employers, explore internship opportunities and connect with mentors.",
    },
];

const whyChooseUs = [
    {
        icon: "🎯",
        title: "Industry-ready education",
        description:
            "Hands-on learning and applied projects prepare students for real-world careers from day one.",
    },
    {
        icon: "🌍",
        title: "Global perspective",
        description:
            "Collaborative learning, exchange opportunities, and research partnerships broaden student impact.",
    },
    {
        icon: "💡",
        title: "Supportive community",
        description:
            "Students benefit from mentors, clubs, leadership programs, and strong alumni networks.",
    },
];

const upcomingEvents = [
    {
        date: "June 08",
        title: "Innovation Expo 2026",
        badge: "Open",
        description:
            "Explore student projects, startup pitches, and research showcases from across the university.",
    },
    {
        date: "June 14",
        title: "Career Mentorship Forum",
        badge: "Live",
        description:
            "Meet employers and alumni for guidance on internships, graduate paths, and professional growth.",
    },
    {
        date: "June 22",
        title: "Leadership and Entrepreneurship Bootcamp",
        badge: "New",
        description:
            "Learn practical strategies for building ventures, communities, and impact-driven teams.",
    },
];

const testimonials = [
    {
        name: "Selam Bekele",
        program: "Computer Science",
        avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?auto=format&fit=crop&w=200&q=80",
        quote: "The practical learning culture and industry-focused teaching prepared me for real-world work from day one.",
    },
    {
        name: "Daniel Mulu",
        program: "Software Engineering",
        avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80",
        quote: "I gained both the technical skills and leadership confidence I needed to build my own startup.",
    },
    {
        name: "Abigail Tesfaye",
        program: "Business Management",
        avatar: "https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=200&q=80",
        quote: "The university gave me a strong foundation and a network of mentors that changed my career path.",
    },
];

const alumniStories = [
    {
        name: "Nahom Ayele",
        role: "Data Analyst",
        avatar: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=200&q=80",
        message:
            "My professors encouraged research and problem solving, which made me confident in the job market.",
    },
    {
        name: "Mekdes Solomon",
        role: "Product Designer",
        avatar: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80",
        message:
            "The creative and collaborative environment helped me grow into a designer with global ambition.",
    },
    {
        name: "Tewodros Haile",
        role: "Systems Engineer",
        avatar: "https://images.unsplash.com/photo-1504593811423-6dd665756598?auto=format&fit=crop&w=200&q=80",
        message:
            "The university bridged theory and practice, giving me the confidence to solve complex engineering problems.",
    },
];
</script>
