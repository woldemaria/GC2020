<template>
    <div class="space-y-5">
        <div class="border-b border-[#d9d9d9] bg-[#f5f5f5] pb-4 pt-1">
            <div class="flex items-center justify-between gap-4 pb-2">
                <div>
                    <p
                        class="mb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-[#6b4cb5]"
                    >
                        Operations overview
                    </p>
                    <h1
                        class="text-[28px] font-black leading-none tracking-[-0.05em] text-[#222]"
                    >
                        Welcome to GC University Admin Dashboard
                    </h1>
                </div>
                <div
                    class="rounded-md border border-[#d8d8d8] bg-white px-3 py-2 text-right shadow-sm"
                >
                    <p
                        class="text-[8px] font-bold uppercase tracking-[0.18em] text-[#5f3fa8]"
                    >
                        Live status
                    </p>
                    <p class="mt-1 text-xs font-semibold text-[#222]">
                        System healthy
                    </p>
                </div>
            </div>
            <p class="max-w-3xl text-[13px] text-[#4d4d4d]">
                Manage your university's digital presence with comprehensive
                tools and analytics.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-0 overflow-hidden border border-[#d9d9d9] bg-white"
        >
            <div
                v-for="(item, index) in summaryCards"
                :key="item.label"
                :class="[
                    'flex items-center justify-between border-b border-[#e8e8e8] px-3 py-3',
                    index === summaryCards.length - 1 ? 'border-b-0' : '',
                ]"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-md border border-[#d9cbf6] bg-[#f7f3ff] text-[#5f3fa8]"
                    >
                        <component :is="item.icon" class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-[13px] font-medium text-[#3d3d3d]">
                            {{ item.label }}
                        </p>
                        <p
                            class="mt-1 text-[24px] font-black leading-none tracking-[-0.05em] text-[#222]"
                        >
                            {{ item.value }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[11px] font-medium text-[#5e5e5e]">
                        {{ item.meta }}
                    </p>
                </div>
            </div>
        </div>

        <div class="border border-[#d9d9d9] bg-white p-4">
            <div class="mb-4 flex items-center justify-between">
                <h3
                    class="text-[18px] font-black tracking-[-0.04em] text-[#222]"
                >
                    Performance Overview
                </h3>
                <span
                    class="text-[8px] font-bold uppercase tracking-[0.18em] text-[#5d2d9c]"
                    >Updated</span
                >
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div
                    class="rounded-md border border-[#ece8f6] bg-[#faf8ff] p-3 text-center"
                >
                    <p
                        class="text-[22px] font-black tracking-[-0.05em] text-[#4f2db1]"
                    >
                        {{ formatNumber(stats.totalViews) }}
                    </p>
                    <p
                        class="mt-2 text-[10px] font-bold uppercase tracking-[0.18em] text-[#4d4d4d]"
                    >
                        Total Views
                    </p>
                </div>
                <div
                    class="rounded-md border border-[#ece8f6] bg-[#faf8ff] p-3 text-center"
                >
                    <p
                        class="text-[22px] font-black tracking-[-0.05em] text-[#4f2db1]"
                    >
                        {{ stats.avgViews || 0 }}
                    </p>
                    <p
                        class="mt-2 text-[10px] font-bold uppercase tracking-[0.18em] text-[#4d4d4d]"
                    >
                        Avg. per Article
                    </p>
                </div>
                <div
                    class="rounded-md border border-[#ece8f6] bg-[#faf8ff] p-3 text-center"
                >
                    <p
                        class="text-[22px] font-black tracking-[-0.05em] text-[#4f2db1]"
                    >
                        {{ stats.totalPhotos || 0 }}
                    </p>
                    <p
                        class="mt-2 text-[10px] font-bold uppercase tracking-[0.18em] text-[#4d4d4d]"
                    >
                        Gallery Photos
                    </p>
                </div>
                <div
                    class="rounded-md border border-[#ece8f6] bg-[#faf8ff] p-3 text-center"
                >
                    <p
                        class="text-[22px] font-black tracking-[-0.05em] text-[#4f2db1]"
                    >
                        {{ stats.storageUsedFormatted || "0 MB" }}
                    </p>
                    <p
                        class="mt-2 text-[10px] font-bold uppercase tracking-[0.18em] text-[#4d4d4d]"
                    >
                        Storage Used
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import {
    DocumentTextIcon,
    UsersIcon,
    AcademicCapIcon,
    ShieldCheckIcon,
    PlusIcon,
    ClipboardDocumentListIcon,
    ArrowDownTrayIcon,
    ChartBarIcon,
    CheckCircleIcon,
    CloudIcon,
    CogIcon,
} from "@heroicons/vue/24/outline";

const router = useRouter();

const stats = ref({});
const recentArticles = ref([]);
const recentEnrollments = ref([]);
const loading = ref(true);

const summaryCards = computed(() => [
    {
        label: "Total Articles",
        value: stats.value.totalArticles || 0,
        meta: `${stats.value.thisMonthArticles || 0} this month`,
        icon: DocumentTextIcon,
    },
    {
        label: "Course Enrollments",
        value: stats.value.totalEnrollments || 0,
        meta: `${stats.value.pendingEnrollments || 0} pending`,
        icon: AcademicCapIcon,
    },
    {
        label: "Total Users",
        value: stats.value.totalUsers || 0,
        meta: `${stats.value.thisMonthUsers || 0} new this month`,
        icon: UsersIcon,
    },
    {
        label: "Certificates Issued",
        value: stats.value.totalCertificates || 0,
        meta: "Active verification",
        icon: ShieldCheckIcon,
    },
]);

const fetchDashboardData = async () => {
    try {
        loading.value = true;
        const response = await fetch("/api/admin/dashboard/stats");
        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                stats.value = data.data.stats;
                recentArticles.value = data.data.recentArticles || [];
                recentEnrollments.value = data.data.recentEnrollments || [];
            }
        }
    } catch (error) {
        console.error("Failed to fetch dashboard data:", error);
    } finally {
        loading.value = false;
    }
};

const formatNumber = (num) => {
    if (!num) return "0";
    return new Intl.NumberFormat().format(num);
};

const createArticle = () => {
    router.push("/admin/articles/create");
};

const manageEnrollments = () => {
    router.push("/admin/enrollments");
};

const downloadPrograms = () => {
    router.push("/admin/downloads");
};

const viewAnalytics = () => {
    router.push("/admin/analytics");
};

onMounted(() => {
    fetchDashboardData();
});
</script>
