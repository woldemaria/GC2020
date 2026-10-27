import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import MainApp from "./components/MainApp.vue";
import Home from "./components/pages/Home.vue";
import Articles from "./components/pages/Articles.vue";
import ArticleView from "./components/pages/ArticleView.vue";
import Gallery from "./components/pages/Gallery.vue";
import StudentProfiles from "./components/pages/StudentProfiles.vue";
import About from "./components/pages/About.vue";
import Contact from "./components/pages/Contact.vue";
import Bookmarks from "./components/pages/Bookmarks.vue";
import Departments from "./components/pages/Departments.vue";
import GraduationGallery from "./components/pages/GraduationGallery.vue";
import StudentDashboard from "./components/pages/StudentDashboard.vue";
import CertificateVerification from "./components/pages/CertificateVerification.vue";
import ApplicationForm from "./components/pages/ApplicationForm.vue";
import NewsEvents from "./components/pages/NewsEvents.vue";
import Alumni from "./components/pages/Alumni.vue";
import HelpCenter from "./components/pages/HelpCenter.vue";
import SubmitArticle from "./components/pages/SubmitArticle.vue";
import PersonSearch from "./components/common/PersonSearch.vue";
import PersonProfile from "./components/common/PersonProfile.vue";
import GownCapRequest from "./components/common/GownCapRequest.vue";
import CertificateTranscriptRequest from "./components/common/CertificateTranscriptRequest.vue";
import CeremonyInfo from "./components/common/CeremonyInfo.vue";
import CampusMap from "./components/pages/CampusMap.vue";

// Router setup
const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },
    { path: "/news-events", name: "news-events", component: NewsEvents },
    { path: "/news", name: "news", component: NewsEvents },
    { path: "/events", name: "events", component: NewsEvents },
    { path: "/alumni", name: "alumni", component: Alumni },
    { path: "/departments", name: "departments", component: Departments },
    { path: "/articles", name: "articles", component: Articles },
    {
        path: "/articles/:slug",
        name: "article",
        component: ArticleView,
        props: true,
    },
    {
        path: "/graduation-gallery",
        name: "graduation-gallery",
        component: GraduationGallery,
    },
    { path: "/gallery", name: "gallery", component: Gallery },
    { path: "/students", name: "students", component: StudentProfiles },
    {
        path: "/student-profiles",
        name: "student-profiles",
        component: StudentProfiles,
    },
    {
        path: "/student-dashboard",
        name: "student-dashboard",
        component: StudentDashboard,
    },
    {
        path: "/verify-certificate",
        name: "certificate-verification",
        component: CertificateVerification,
    },
    {
        path: "/verify-certificate/:code",
        name: "certificate-verification-code",
        component: CertificateVerification,
        props: true,
    },
    { path: "/apply", name: "application-form", component: ApplicationForm },
    { path: "/bookmarks", name: "bookmarks", component: Bookmarks },
    { path: "/help-center", name: "help-center", component: HelpCenter },
    {
        path: "/submit-article",
        name: "submit-article",
        component: SubmitArticle,
    },
    { path: "/contact", name: "contact", component: Contact },
    { path: "/people-search", name: "people-search", component: PersonSearch },
    { path: "/person/:id", name: "person-profile", component: PersonProfile, props: true },
    { path: "/gown-cap", name: "gown-cap", component: GownCapRequest },
    { path: "/certificate-transcript", name: "certificate-transcript", component: CertificateTranscriptRequest },
    { path: "/ceremony-info", name: "ceremony-info", component: CeremonyInfo },
    { path: "/campus-map", name: "campus-map", component: CampusMap },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create and mount the Vue application
const FALLBACK_IMAGE = "/images/campus-hero.jpg";
const FALLBACK_AVATAR = "/images/default-avatar.jpg";

const attachImageFallbacks = () => {
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

attachImageFallbacks();

const app = createApp(MainApp);
app.use(router);
app.mount("#app");
