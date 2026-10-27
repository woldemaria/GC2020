<template>
    <div class="space-y-5">
        <div
            class="flex flex-col gap-4 rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#6a4db0]"
                >
                    Analytics
                </p>
                <h1
                    class="mt-2 text-[26px] font-black tracking-[-0.05em] text-[#1f1f1f]"
                >
                    Analytics & Reports
                </h1>
                <p class="mt-1 text-sm text-[#5a5a5a]">
                    Comprehensive analytics and performance metrics
                </p>
            </div>

            <div class="flex items-center gap-3">
                <select
                    v-model="selectedTimeRange"
                    @change="updateAnalytics"
                    class="rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                >
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 3 months</option>
                    <option value="365">Last year</option>
                </select>

                <button
                    @click="exportReport"
                    class="inline-flex items-center rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2 text-sm font-semibold text-[#4b2d8d] transition hover:bg-[#ece4ff]"
                >
                    <ArrowDownTrayIcon class="mr-2 h-4 w-4" />
                    Export Report
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div
                class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#5a5a5a]">
                            Total Users
                        </p>
                        <p
                            class="mt-2 text-[28px] font-black tracking-[-0.05em] text-[#1d1d1d]"
                        >
                            {{ formatNumber(analytics.totalUsers) }}
                        </p>
                        <p
                            :class="[
                                'text-sm',
                                analytics.userGrowth >= 0
                                    ? 'text-[#178652]'
                                    : 'text-[#d93d47]',
                            ]"
                        >
                            {{ analytics.userGrowth >= 0 ? "+" : ""
                            }}{{ analytics.userGrowth }}% vs last period
                        </p>
                    </div>
                    <UsersIcon class="h-10 w-10 text-[#5d3fb0]" />
                </div>
            </div>

            <div
                class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#5a5a5a]">
                            Page Views
                        </p>
                        <p
                            class="mt-2 text-[28px] font-black tracking-[-0.05em] text-[#1d1d1d]"
                        >
                            {{ formatNumber(analytics.pageViews) }}
                        </p>
                        <p
                            :class="[
                                'text-sm',
                                analytics.viewsGrowth >= 0
                                    ? 'text-[#178652]'
                                    : 'text-[#d93d47]',
                            ]"
                        >
                            {{ analytics.viewsGrowth >= 0 ? "+" : ""
                            }}{{ analytics.viewsGrowth }}% vs last period
                        </p>
                    </div>
                    <EyeIcon class="h-10 w-10 text-[#2e9d6b]" />
                </div>
            </div>

            <div
                class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#5a5a5a]">
                            Course Enrollments
                        </p>
                        <p
                            class="mt-2 text-[28px] font-black tracking-[-0.05em] text-[#1d1d1d]"
                        >
                            {{ formatNumber(analytics.enrollments) }}
                        </p>
                        <p
                            :class="[
                                'text-sm',
                                analytics.enrollmentGrowth >= 0
                                    ? 'text-[#178652]'
                                    : 'text-[#d93d47]',
                            ]"
                        >
                            {{ analytics.enrollmentGrowth >= 0 ? "+" : ""
                            }}{{ analytics.enrollmentGrowth }}% vs last period
                        </p>
                    </div>
                    <AcademicCapIcon class="h-10 w-10 text-[#7057bf]" />
                </div>
            </div>

            <div
                class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#5a5a5a]">
                            Avg Session Duration
                        </p>
                        <p
                            class="mt-2 text-[28px] font-black tracking-[-0.05em] text-[#1d1d1d]"
                        >
                            {{ analytics.avgSessionDuration }}
                        </p>
                        <p
                            :class="[
                                'text-sm',
                                analytics.sessionGrowth >= 0
                                    ? 'text-[#178652]'
                                    : 'text-[#d93d47]',
                            ]"
                        >
                            {{ analytics.sessionGrowth >= 0 ? "+" : ""
                            }}{{ analytics.sessionGrowth }}% vs last period
                        </p>
                    </div>
                    <ClockIcon class="h-10 w-10 text-[#d89a2c]" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div
                class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm"
            >
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#1d1d1d]">
                        Website Traffic
                    </h3>
                    <div class="flex gap-2">
                        <button
                            v-for="period in ['Daily', 'Weekly', 'Monthly']"
                            :key="period"
                            @click="chartPeriod = period"
                            :class="[
                                'px-3 py-1 text-sm rounded-md transition-colors',
                                chartPeriod === period
                                    ? 'bg-[#f1ebff] text-[#4b2d8d]'
                                    : 'bg-[#f4f4f4] text-[#5d5d5d] hover:bg-[#efefef]',
                            ]"
                        >
                            {{ period }}
                        </button>
                    </div>
                </div>
                <div
                    class="flex h-64 items-center justify-center rounded-md bg-[#f8f8f8]"
                >
                    <div class="text-center text-[#666]">
                        <ChartBarIcon class="mx-auto mb-2 h-12 w-12" />
                        <p>Traffic Chart Visualization</p>
                        <p class="text-sm">Chart library integration needed</p>
                    </div>
                </div>
            </div>

            <div
                class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm"
            >
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#1d1d1d]">
                        User Engagement
                    </h3>
                    <select
                        v-model="engagementMetric"
                        class="rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-2 py-1.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                    >
                        <option value="bounce_rate">Bounce Rate</option>
                        <option value="pages_per_session">
                            Pages per Session
                        </option>
                        <option value="session_duration">
                            Session Duration
                        </option>
                    </select>
                </div>
                <div
                    class="flex h-64 items-center justify-center rounded-md bg-[#f8f8f8]"
                >
                    <div class="text-center text-[#666]">
                        <PresentationChartLineIcon
                            class="mx-auto mb-2 h-12 w-12"
                        />
                        <p>Engagement Chart Visualization</p>
                        <p class="text-sm">Chart library integration needed</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="rounded-md border border-[#d9d9d9] bg-white shadow-sm">
                <div class="border-b border-[#e8e8e8] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#1d1d1d]">
                        Top Articles
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-3">
                        <div
                            v-for="(article, index) in analytics.topArticles"
                            :key="article.id"
                            class="flex items-center justify-between rounded-md bg-[#f8f8f8] p-3"
                        >
                            <div class="flex items-center">
                                <div
                                    :class="[
                                        'mr-3 flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold text-white',
                                        index === 0
                                            ? 'bg-[#d9b64d]'
                                            : index === 1
                                              ? 'bg-[#8a8a8a]'
                                              : index === 2
                                                ? 'bg-[#cd7c4d]'
                                                : 'bg-[#5d3fb0]',
                                    ]"
                                >
                                    {{ index + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-[#1d1d1d]">
                                        {{ article.title }}
                                    </p>
                                    <p class="text-sm text-[#666]">
                                        {{ article.category }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-[#1d1d1d]">
                                    {{ formatNumber(article.views) }}
                                </p>
                                <p class="text-sm text-[#666]">views</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-md border border-[#d9d9d9] bg-white shadow-sm">
                <div class="border-b border-[#e8e8e8] px-5 py-4">
                    <h3 class="text-lg font-semibold text-[#1d1d1d]">
                        Department Interest
                    </h3>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        <div
                            v-for="department in analytics.departmentInterest"
                            :key="department.name"
                            class="flex items-center justify-between"
                        >
                            <div class="flex items-center">
                                <div
                                    :class="[
                                        'mr-3 h-4 w-4 rounded-full',
                                        department.colorClass,
                                    ]"
                                ></div>
                                <span class="font-medium text-[#1d1d1d]">{{
                                    department.name
                                }}</span>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="mr-3 h-2 w-32 overflow-hidden rounded-full bg-[#ececec]"
                                >
                                    <div
                                        :class="[
                                            'h-full rounded-full',
                                            department.colorClass,
                                        ]"
                                        :style="{
                                            width: `${department.percentage}%`,
                                        }"
                                    ></div>
                                </div>
                                <span
                                    class="text-sm font-semibold text-[#1d1d1d]"
                                    >{{ department.percentage }}%</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import {
    UsersIcon,
    EyeIcon,
    AcademicCapIcon,
    ClockIcon,
    ChartBarIcon,
    PresentationChartLineIcon,
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/outline";

const selectedTimeRange = ref("30");
const chartPeriod = ref("Daily");
const engagementMetric = ref("bounce_rate");

const analytics = reactive({
    totalUsers: 15420,
    userGrowth: 12.5,
    pageViews: 89750,
    viewsGrowth: 8.3,
    enrollments: 1340,
    enrollmentGrowth: 15.7,
    avgSessionDuration: "4m 32s",
    sessionGrowth: -2.1,

    topArticles: [
        {
            id: 1,
            title: "Getting Started with Programming",
            category: "Computer Science",
            views: 12540,
        },
        {
            id: 2,
            title: "University Life and Study Tips",
            category: "Student Life",
            views: 9830,
        },
        {
            id: 3,
            title: "Engineering Career Paths",
            category: "Engineering",
            views: 8420,
        },
        {
            id: 4,
            title: "Medical School Preparation",
            category: "Medicine",
            views: 7650,
        },
        {
            id: 5,
            title: "Business Innovation Trends",
            category: "Business",
            views: 6890,
        },
    ],

    departmentInterest: [
        {
            name: "Computer Science & IT",
            percentage: 28,
            colorClass: "bg-blue-500",
        },
        { name: "Engineering", percentage: 22, colorClass: "bg-green-500" },
        { name: "Medicine & Health", percentage: 18, colorClass: "bg-red-500" },
        {
            name: "Business & Management",
            percentage: 15,
            colorClass: "bg-purple-500",
        },
        {
            name: "Natural Sciences",
            percentage: 10,
            colorClass: "bg-yellow-500",
        },
        { name: "Social Sciences", percentage: 7, colorClass: "bg-indigo-500" },
    ],

    demographics: {
        students: 45,
        faculty: 15,
        alumni: 25,
        visitors: 15,
    },

    devices: {
        desktop: 42,
        mobile: 48,
        tablet: 10,
    },

    topLocations: [
        { country: "Ethiopia", percentage: 78 },
        { country: "Kenya", percentage: 8 },
        { country: "Sudan", percentage: 5 },
        { country: "Uganda", percentage: 4 },
        { country: "Tanzania", percentage: 3 },
        { country: "Others", percentage: 2 },
    ],

    performance: {
        loadTime: 2.3,
        uptime: 99.8,
        errorRate: 0.2,
    },
});

const formatNumber = (num) => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + "M";
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + "K";
    }
    return num.toString();
};

const updateAnalytics = () => {
    // Mock function to update analytics based on time range
    console.log("Updating analytics for time range:", selectedTimeRange.value);

    // In a real application, this would fetch new data from the API
    // For now, we'll just simulate some changes
    const multiplier =
        selectedTimeRange.value === "7"
            ? 0.3
            : selectedTimeRange.value === "30"
              ? 1
              : selectedTimeRange.value === "90"
                ? 2.5
                : 8;

    analytics.pageViews = Math.floor(89750 * multiplier);
    analytics.enrollments = Math.floor(1340 * multiplier);
};

const exportReport = () => {
    // Mock export functionality
    const reportData = {
        period: `${selectedTimeRange.value} days`,
        generated: new Date().toISOString(),
        metrics: {
            totalUsers: analytics.totalUsers,
            pageViews: analytics.pageViews,
            enrollments: analytics.enrollments,
            avgSessionDuration: analytics.avgSessionDuration,
        },
        topArticles: analytics.topArticles,
        departmentInterest: analytics.departmentInterest,
    };

    const blob = new Blob([JSON.stringify(reportData, null, 2)], {
        type: "application/json",
    });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `analytics-report-${new Date().toISOString().split("T")[0]}.json`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
};

onMounted(() => {
    // Initialize analytics data
    updateAnalytics();
});
</script>
