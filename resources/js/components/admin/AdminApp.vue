<template>
    <div class="flex h-screen bg-[#efefef] text-[#1d1d1d] antialiased">
        <aside class="w-[232px] border-r border-[#d8d8d8] bg-[#f7f7f8]">
            <div class="flex h-full flex-col">
                <div
                    class="flex items-center gap-3 border-b border-[#d9d9d9] px-3 pb-3 pt-4"
                >
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-md border border-[#7a59be] bg-[#f3eeff] text-base font-black text-[#6140a8]"
                    >
                        GC
                    </div>
                    <div>
                        <h1
                            class="text-[22px] font-black leading-none tracking-[-0.05em] text-[#2c2c2c]"
                        >
                            GC Magazine
                        </h1>
                        <p
                            class="mt-1 text-[9px] font-bold uppercase tracking-[0.18em] text-[#6a4db0]"
                        >
                            Admin Portal
                        </p>
                    </div>
                </div>

                <nav class="flex-1 space-y-1 px-2.5 py-3">
                    <router-link
                        v-for="item in navigation"
                        :key="item.name"
                        :to="item.to"
                        class="group flex items-center gap-3 rounded-md px-2.5 py-2 transition-all duration-200"
                        :class="
                            $route.name === item.name
                                ? 'bg-[#f1ecff] text-[#4f2eb2] ring-1 ring-[#7f5cc9]/15'
                                : 'text-[#3f3f3f] hover:bg-[#f1f1f3] hover:text-[#1f1f1f]'
                        "
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-md border border-[#d7caef] bg-[#f8f5ff] text-[#5f3fa8]"
                            :class="
                                $route.name === item.name ? 'shadow-sm' : ''
                            "
                        >
                            <component :is="item.icon" class="h-4 w-4" />
                        </div>
                        <span
                            class="text-[14px] font-medium tracking-[-0.02em]"
                            >{{ item.label }}</span
                        >
                    </router-link>
                </nav>

                <div class="border-t border-[#d9d9d9] p-3">
                    <div
                        class="flex items-center gap-3 rounded-md border border-[#e1e1e1] bg-white px-2.5 py-2.5 shadow-sm"
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#ede6ff] text-xs font-bold text-[#5f3fa8]"
                        >
                            A
                        </div>
                        <div class="min-w-0 leading-tight">
                            <p
                                class="truncate text-[13px] font-semibold text-[#2a2a2a]"
                            >
                                Admin User
                            </p>
                            <p class="truncate text-[11px] text-[#666]">
                                admin@gcmagazine.edu
                            </p>
                        </div>
                        <button
                            @click="logout"
                            class="ml-auto p-1 text-[#666] hover:text-[#dc2626] hover:bg-[#fef2f2] rounded-md transition-colors"
                            title="Logout"
                        >
                            <ArrowRightOnRectangleIcon class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex flex-1 flex-col overflow-hidden">
            <header class="border-b border-[#d9d9d9] bg-[#f5f5f5] px-5 py-3.5">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <h2
                            class="text-[26px] font-black tracking-[-0.06em] text-[#2a2a2a]"
                        >
                            {{ getPageTitle() }}
                        </h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <button
                            class="relative rounded-md border border-[#d7d7d7] bg-white p-2 text-[#5942a2] shadow-sm"
                        >
                            <BellIcon class="h-4 w-4" />
                            <span
                                class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"
                            ></span>
                        </button>
                    </div>
                </div>
                <p class="mt-1 text-[12px] text-[#4f4f4f]">
                    {{ getPageDescription() }}
                </p>
            </header>

            <main class="flex-1 overflow-y-auto bg-[#f2f2f2] p-5">
                <div class="mx-auto max-w-[1360px]">
                    <router-view />
                </div>
            </main>
        </div>

        <div
            v-if="loading"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm"
        >
            <div
                class="flex items-center gap-3 rounded-2xl bg-white px-5 py-4 shadow-xl"
            >
                <div
                    class="h-6 w-6 animate-spin rounded-full border-2 border-blue-500 border-t-transparent"
                ></div>
                <span class="text-sm font-medium text-slate-700"
                    >Loading...</span
                >
            </div>
        </div>

        <div
            v-if="notification.show"
            :class="[
                'fixed right-4 top-4 z-50 w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-4 shadow-xl transition-all duration-300',
                notification.show
                    ? 'translate-x-0 opacity-100'
                    : 'translate-x-5 opacity-0',
            ]"
        >
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <CheckCircleIcon
                        v-if="notification.type === 'success'"
                        class="h-6 w-6 text-green-500"
                    />
                    <ExclamationTriangleIcon
                        v-else-if="notification.type === 'warning'"
                        class="h-6 w-6 text-yellow-500"
                    />
                    <XCircleIcon
                        v-else-if="notification.type === 'error'"
                        class="h-6 w-6 text-red-500"
                    />
                    <InformationCircleIcon
                        v-else
                        class="h-6 w-6 text-blue-500"
                    />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-900">
                        {{ notification.title }}
                    </p>
                    <p class="mt-1 text-sm text-slate-600">
                        {{ notification.message }}
                    </p>
                </div>
                <button
                    @click="hideNotification"
                    class="text-slate-400 transition hover:text-slate-600"
                >
                    <XMarkIcon class="h-5 w-5" />
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, provide } from "vue";
import { useRoute } from "vue-router";
import {
    HomeIcon,
    DocumentTextIcon,
    PhotoIcon,
    UsersIcon,
    FolderIcon,
    CogIcon,
    WrenchScrewdriverIcon,
    BellIcon,
    CheckCircleIcon,
    ExclamationTriangleIcon,
    XCircleIcon,
    InformationCircleIcon,
    XMarkIcon,
    AcademicCapIcon,
    CalendarDaysIcon,
    ClipboardDocumentListIcon,
    ArrowDownTrayIcon,
    ChartBarIcon,
    ArrowRightOnRectangleIcon
} from "@heroicons/vue/24/outline";

const route = useRoute();

const loading = ref(false);
const notification = reactive({
    show: false,
    type: "info",
    title: "",
    message: "",
});

const logout = async () => {
    try {
        const token = localStorage.getItem("auth_token");
        await fetch("/api/logout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: token ? `Bearer ${token}` : ""
            }
        });
    } catch (e) {
        // ignore errors
    }
    localStorage.removeItem("auth_token");
    window.location.href = "/login";
};

const navigation = [
    {
        name: "dashboard",
        label: "Dashboard",
        to: "/admin/dashboard",
        icon: HomeIcon,
    },
    {
        name: "articles",
        label: "Articles",
        to: "/admin/articles",
        icon: DocumentTextIcon,
    },
    {
        name: "categories",
        label: "Categories",
        to: "/admin/categories",
        icon: FolderIcon,
    },
    {
        name: "authors",
        label: "Authors",
        to: "/admin/authors",
        icon: UsersIcon,
    },
    {
        name: "certificates",
        label: "Certificates",
        to: "/admin/certificates",
        icon: AcademicCapIcon,
    },
    {
        name: "enrollments",
        label: "Course Enrollments",
        to: "/admin/enrollments",
        icon: ClipboardDocumentListIcon,
    },
    {
        name: "events",
        label: "Events & Registration",
        to: "/admin/events",
        icon: CalendarDaysIcon,
    },
    {
        name: "analytics",
        label: "Analytics",
        to: "/admin/analytics",
        icon: ChartBarIcon,
    },
    {
        name: "marketing",
        label: "Marketing & Campaigns",
        to: "/admin/marketing",
        icon: ChartBarIcon,
    },
    {
        name: "downloads",
        label: "Program Downloads",
        to: "/admin/downloads",
        icon: ArrowDownTrayIcon,
    },
    {
        name: "media",
        label: "Media Library",
        to: "/admin/media",
        icon: PhotoIcon,
    },
    {
        name: "test",
        label: "Upload Test",
        to: "/admin/test",
        icon: WrenchScrewdriverIcon,
    },
    {
        name: "settings",
        label: "Settings",
        to: "/admin/settings",
        icon: CogIcon,
    },
];

const showNotification = (type, title, message) => {
    notification.type = type;
    notification.title = title;
    notification.message = message;
    notification.show = true;

    setTimeout(() => {
        hideNotification();
    }, 5000);
};

const hideNotification = () => {
    notification.show = false;
};

const showLoading = () => {
    loading.value = true;
};

const hideLoading = () => {
    loading.value = false;
};

const getPageTitle = () => {
    const titles = {
        dashboard: "Dashboard",
        articles: "Articles",
        "article-create": "Create Article",
        "article-edit": "Edit Article",
        categories: "Categories",
        authors: "Authors",
        certificates: "Certificates",
        enrollments: "Course Enrollments",
        events: "Events & Registration",
        analytics: "Analytics & Reports",
        marketing: "Marketing & Campaigns",
        downloads: "Program Downloads",
        media: "Media Library",
        test: "Upload Test",
        settings: "Settings",
    };
    return titles[route.name] || "Admin";
};

const getPageDescription = () => {
    const descriptions = {
        dashboard: "Welcome to the GC University admin panel",
        articles: "Manage your magazine articles",
        "article-create": "Create a new article",
        "article-edit": "Edit article content",
        categories: "Manage article categories",
        authors: "Manage article authors",
        certificates: "Manage university certificates and verification system",
        enrollments: "Manage course enrollment applications",
        events: "Manage university events and student registrations",
        analytics: "View detailed analytics and generate reports",
        marketing: "Manage marketing campaigns and promotional activities",
        downloads: "Generate and manage program brochures",
        media: "Upload and manage media files",
        test: "Test file upload and editing functionality",
        settings: "Configure application settings",
    };
    return descriptions[route.name] || "";
};

provide("showNotification", showNotification);
provide("showLoading", showLoading);
provide("hideLoading", hideLoading);
</script>
