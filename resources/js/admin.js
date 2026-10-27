import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";
import AdminApp from "./components/admin/AdminApp.vue";
import Dashboard from "./components/admin/Dashboard.vue";
import ArticleList from "./components/admin/ArticleList.vue";
import ArticleEdit from "./components/admin/ArticleEdit.vue";
import CategoryList from "./components/admin/CategoryList.vue";
import AuthorList from "./components/admin/AuthorList.vue";
import MediaLibrary from "./components/admin/MediaLibrary.vue";
import Settings from "./components/admin/Settings.vue";
import TestUpload from "./components/admin/TestUpload.vue";
import CertificateManagement from "./components/admin/CertificateManagement.vue";
import EnrollmentManagement from "./components/admin/EnrollmentManagement.vue";
import EventManagement from "./components/admin/EventManagement.vue";
import ProgramDownloads from "./components/admin/ProgramDownloads.vue";
import Analytics from "./components/admin/Analytics.vue";
import MarketingAnalytics from "./components/admin/MarketingAnalytics.vue";

// Set up axios
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
}

// Admin routes
const routes = [
    { path: "/admin", redirect: "/admin/dashboard" },
    { path: "/admin/dashboard", name: "dashboard", component: Dashboard },
    { path: "/admin/articles", name: "articles", component: ArticleList },
    {
        path: "/admin/articles/create",
        name: "article-create",
        component: ArticleEdit,
    },
    {
        path: "/admin/articles/:id/edit",
        name: "article-edit",
        component: ArticleEdit,
        props: true,
    },
    { path: "/admin/categories", name: "categories", component: CategoryList },
    { path: "/admin/authors", name: "authors", component: AuthorList },
    {
        path: "/admin/certificates",
        name: "certificates",
        component: CertificateManagement,
    },
    {
        path: "/admin/enrollments",
        name: "enrollments",
        component: EnrollmentManagement,
    },
    { path: "/admin/events", name: "events", component: EventManagement },
    { path: "/admin/analytics", name: "analytics", component: Analytics },
    {
        path: "/admin/marketing",
        name: "marketing",
        component: MarketingAnalytics,
    },
    {
        path: "/admin/downloads",
        name: "downloads",
        component: ProgramDownloads,
    },
    { path: "/admin/media", name: "media", component: MediaLibrary },
    { path: "/admin/test", name: "test", component: TestUpload },
    { path: "/admin/settings", name: "settings", component: Settings },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const token = localStorage.getItem("auth_token");

    if (!to.path.startsWith("/admin")) {
        return next();
    }

    if (!token) {
        window.location.href = "/login";
        return;
    }

    try {
        const { data } = await axios.get("/api/user", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        if (!data || !data.user || !data.user.is_admin) {
            localStorage.removeItem("auth_token");
            window.location.href = "/login";
            return;
        }

        next();
    } catch (error) {
        localStorage.removeItem("auth_token");
        window.location.href = "/login";
    }
});

const FALLBACK_IMAGE = "/images/campus-hero.jpg";
const FALLBACK_AVATAR = "/images/default-avatar.jpg";

const attachAdminImageFallbacks = () => {
    document.addEventListener(
        "error",
        (event) => {
            const target = event.target;

            if (!(target instanceof HTMLImageElement)) {
                return;
            }

            if (target.dataset.fallbackApplied === "true") {
                return;
            }

            const currentSrc = target.getAttribute("src") || "";
            if (!currentSrc || !currentSrc.includes("images.unsplash.com")) {
                return;
            }

            target.dataset.fallbackApplied = "true";

            const fallback = target.alt?.toLowerCase().includes("avatar")
                ? FALLBACK_AVATAR
                : FALLBACK_IMAGE;

            target.src = fallback;
        },
        true,
    );
};

attachAdminImageFallbacks();

// Create and mount the admin app
const app = createApp(AdminApp);
app.use(router);
app.config.globalProperties.$http = axios;
app.mount("#admin-app");
