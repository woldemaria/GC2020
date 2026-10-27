<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <section
            class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-5xl font-bold mb-6">Alumni Network</h1>
                    <p class="text-xl text-purple-100 max-w-3xl mx-auto mb-8">
                        Join a global community of 50,000+ GC University
                        graduates making impact across industries worldwide
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button
                            type="button"
                            @click="handleAlumniAction('join')"
                            class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 px-8 py-3 rounded-lg font-semibold transition-colors"
                        >
                            Join Alumni Network
                        </button>
                        <button
                            type="button"
                            @click="handleAlumniAction('profile')"
                            class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-900 transition-all"
                        >
                            Update Your Profile
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-purple-600 mb-2">
                            50,000+
                        </div>
                        <div class="text-gray-600">Global Alumni</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2">
                            120+
                        </div>
                        <div class="text-gray-600">Countries</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600 mb-2">
                            85%
                        </div>
                        <div class="text-gray-600">Leadership Roles</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-orange-600 mb-2">
                            95%
                        </div>
                        <div class="text-gray-600">Job Placement</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Alumni -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Distinguished Alumni
                    </h2>
                    <p class="text-xl text-gray-600">
                        Celebrating our graduates who are making a difference
                        worldwide
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="alumnus in featuredAlumni"
                        :key="alumnus.id"
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group"
                    >
                        <div class="relative h-64 overflow-hidden">
                            <img
                                :src="alumnus.photo"
                                :alt="alumnus.name"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"
                            ></div>
                            <div
                                class="absolute bottom-4 left-4 right-4 text-white"
                            >
                                <h3 class="text-xl font-bold mb-1">
                                    {{ alumnus.name }}
                                </h3>
                                <p class="text-sm text-blue-200">
                                    {{ alumnus.degree }} •
                                    {{ alumnus.graduationYear }}
                                </p>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-4">
                                <h4
                                    class="text-lg font-semibold text-gray-900 mb-1"
                                >
                                    {{ alumnus.position }}
                                </h4>
                                <p class="text-purple-600 font-medium">
                                    {{ alumnus.company }}
                                </p>
                                <p class="text-gray-600 text-sm mt-1">
                                    {{ alumnus.location }}
                                </p>
                            </div>

                            <p class="text-gray-700 text-sm mb-4 line-clamp-3">
                                {{ alumnus.achievement }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex space-x-3">
                                    <a
                                        v-if="alumnus.linkedin"
                                        :href="alumnus.linkedin"
                                        target="_blank"
                                        class="text-gray-400 hover:text-blue-600 transition-colors"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
                                            />
                                        </svg>
                                    </a>
                                    <a
                                        v-if="alumnus.website"
                                        :href="alumnus.website"
                                        target="_blank"
                                        class="text-gray-400 hover:text-green-600 transition-colors"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                            />
                                        </svg>
                                    </a>
                                </div>
                                <span class="text-xs text-gray-500">{{
                                    alumnus.industry
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Success Stories -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                    Success Stories
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div
                        v-for="story in successStories"
                        :key="story.id"
                        class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-8 border-l-4 border-purple-500"
                    >
                        <div class="flex items-start mb-6">
                            <img
                                :src="story.photo"
                                :alt="story.name"
                                class="w-16 h-16 rounded-full object-cover mr-4"
                            />
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ story.name }}
                                </h3>
                                <p class="text-purple-600 font-medium">
                                    {{ story.title }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ story.degree }} • {{ story.year }}
                                </p>
                            </div>
                        </div>
                        <blockquote class="text-gray-700 italic mb-4">
                            "{{ story.quote }}"
                        </blockquote>
                        <p class="text-sm text-gray-600">{{ story.impact }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alumni by Industry -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                    Alumni by Industry
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div
                        v-for="industry in industries"
                        :key="industry.name"
                        class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow cursor-pointer"
                    >
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4"
                        >
                            <component
                                :is="industry.icon"
                                class="w-8 h-8 text-white"
                            />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ industry.name }}
                        </h3>
                        <p class="text-3xl font-bold text-purple-600">
                            {{ industry.count }}%
                        </p>
                        <p class="text-sm text-gray-600">of alumni</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alumni Events -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Upcoming Alumni Events
                    </h2>
                    <p class="text-xl text-gray-600">
                        Connect, network, and give back to the GC community
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="event in alumniEvents"
                        :key="event.id"
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
                    >
                        <div class="relative h-48">
                            <img
                                :src="event.image"
                                :alt="event.title"
                                class="w-full h-full object-cover"
                            />
                            <div
                                class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-lg"
                            >
                                {{ event.date }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3
                                class="text-xl font-semibold text-gray-900 mb-2"
                            >
                                {{ event.title }}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ event.description }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <p>{{ event.time }}</p>
                                    <p>{{ event.location }}</p>
                                </div>
                                <button
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                                >
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Giving Back -->
        <section class="py-16 bg-purple-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
                >
                    <div>
                        <h2 class="text-4xl font-bold mb-6">
                            Give Back to Your Alma Mater
                        </h2>
                        <p class="text-purple-100 text-lg mb-8">
                            Support current students through mentorship,
                            scholarships, and career guidance. Your success
                            story can inspire and help shape the next generation
                            of leaders.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button
                                class="bg-yellow-500 hover:bg-yellow-600 text-purple-900 px-6 py-3 rounded-lg font-semibold transition-colors"
                            >
                                Donate Now
                            </button>
                            <button
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-900 transition-all"
                            >
                                Become a Mentor
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <img
                            src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=500&h=600&fit=crop"
                            alt="Alumni giving back"
                            class="rounded-2xl shadow-2xl"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from "vue";

const handleAlumniAction = async (action) => {
    const token = localStorage.getItem("auth_token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const response = await fetch("/api/user", {
            headers: {
                Authorization: `Bearer ${token}`,
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        const data = await response.json();

        if (!response.ok || !data || !data.user) {
            localStorage.removeItem("auth_token");
            window.location.href = "/login";
            return;
        }

        if (action === "join") {
            window.location.href = "/admin";
            return;
        }

        if (action === "profile") {
            window.location.href = "/student-dashboard";
            return;
        }
    } catch (error) {
        localStorage.removeItem("auth_token");
        window.location.href = "/login";
    }
};

const featuredAlumni = ref([
    {
        id: 1,
        name: "Dr. Hanan Ahmed",
        degree: "PhD Computer Science",
        graduationYear: "2018",
        position: "Chief Technology Officer",
        company: "Microsoft Africa",
        location: "Lagos, Nigeria",
        photo: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=400&h=400&fit=crop&crop=face",
        achievement:
            "Leading digital transformation initiatives across Africa, impacting over 100 million users.",
        industry: "Technology",
        linkedin: "https://linkedin.com/in/hananahmned",
        website: "https://microsoft.com",
    },
    {
        id: 2,
        name: "Samuel Teshome",
        degree: "MBA Business Administration",
        graduationYear: "2016",
        position: "CEO & Founder",
        company: "EthioTech Solutions",
        location: "Addis Ababa, Ethiopia",
        photo: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face",
        achievement:
            "Built Ethiopia's largest fintech company, serving 2 million customers nationwide.",
        industry: "Fintech",
        linkedin: "https://linkedin.com/in/samuelteshome",
        website: "https://ethiotech.com",
    },
    {
        id: 3,
        name: "Dr. Fatima Al-Rashid",
        degree: "MD Medicine",
        graduationYear: "2015",
        position: "Director of Global Health",
        company: "World Health Organization",
        location: "Geneva, Switzerland",
        photo: "https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400&h=400&fit=crop&crop=face",
        achievement:
            "Leading WHO's response to health crises across Africa and the Middle East.",
        industry: "Healthcare",
        linkedin: "https://linkedin.com/in/fatimaalrashid",
        website: "https://who.int",
    },
    {
        id: 4,
        name: "James Kinyanjui",
        degree: "BS Engineering",
        graduationYear: "2017",
        position: "Senior Software Engineer",
        company: "Google",
        location: "Mountain View, USA",
        photo: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face",
        achievement:
            "Developed machine learning algorithms used by billions of users worldwide.",
        industry: "Technology",
        linkedin: "https://linkedin.com/in/jameskinyanjui",
        website: "https://google.com",
    },
    {
        id: 5,
        name: "Aisha Mohamed",
        degree: "BS Environmental Science",
        graduationYear: "2019",
        position: "Climate Change Specialist",
        company: "United Nations",
        location: "Nairobi, Kenya",
        photo: "https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=400&fit=crop&crop=face",
        achievement:
            "Leading climate adaptation projects across East Africa, benefiting 10 million people.",
        industry: "Environment",
        linkedin: "https://linkedin.com/in/aishamohamed",
        website: "https://un.org",
    },
    {
        id: 6,
        name: "David Assefa",
        degree: "BS Agriculture",
        graduationYear: "2014",
        position: "Founder & CEO",
        company: "AgriInnovate Ethiopia",
        location: "Bahir Dar, Ethiopia",
        photo: "https://images.unsplash.com/photo-1566492031773-4f4e44671d66?w=400&h=400&fit=crop&crop=face",
        achievement:
            "Revolutionizing Ethiopian agriculture with smart farming technologies.",
        industry: "Agriculture",
        linkedin: "https://linkedin.com/in/davidassefa",
        website: "https://agriinnovate.et",
    },
]);

const successStories = ref([
    {
        id: 1,
        name: "Dr. Rahel Tadesse",
        title: "Minister of Education, Ethiopia",
        degree: "PhD Education Policy",
        year: "2010",
        photo: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face",
        quote: "GC University gave me the foundation to think critically about educational challenges and develop innovative solutions.",
        impact: "Reformed Ethiopia's national curriculum, impacting 20 million students nationwide.",
    },
    {
        id: 2,
        name: "Michael Tekle",
        title: "Olympic Gold Medalist & Sports Ambassador",
        degree: "BS Sports Science",
        year: "2012",
        photo: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face",
        quote: "The discipline and scientific approach I learned at GC University was crucial to my Olympic success.",
        impact: "First Ethiopian to win gold in swimming, now mentoring young athletes across Africa.",
    },
]);

const industries = ref([
    { name: "Technology", count: 28, icon: "ComputerDesktopIcon" },
    { name: "Healthcare", count: 22, icon: "HeartIcon" },
    { name: "Finance", count: 18, icon: "BanknotesIcon" },
    { name: "Education", count: 15, icon: "AcademicCapIcon" },
    { name: "Engineering", count: 12, icon: "CogIcon" },
    { name: "Government", count: 8, icon: "BuildingLibraryIcon" },
    { name: "Non-Profit", count: 7, icon: "HandHeartIcon" },
    { name: "Media", count: 5, icon: "TvIcon" },
]);

const alumniEvents = ref([
    {
        id: 1,
        title: "Annual Alumni Gala 2026",
        description:
            "Join us for an evening of networking, awards, and celebration.",
        image: "https://images.unsplash.com/photo-1511795409834-432f7b1728e5?w=600&h=400&fit=crop",
        date: "Dec 15",
        time: "7:00 PM - 11:00 PM",
        location: "Addis Ababa Hilton",
    },
    {
        id: 2,
        title: "Tech Alumni Meetup",
        description:
            "Connect with fellow tech professionals and discuss industry trends.",
        image: "https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=600&h=400&fit=crop",
        date: "Nov 20",
        time: "6:00 PM - 9:00 PM",
        location: "Virtual Event",
    },
    {
        id: 3,
        title: "Mentorship Program Launch",
        description:
            "Learn how to become a mentor to current students and recent graduates.",
        image: "https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=600&h=400&fit=crop",
        date: "Nov 30",
        time: "2:00 PM - 4:00 PM",
        location: "GC University Campus",
    },
]);
</script>
