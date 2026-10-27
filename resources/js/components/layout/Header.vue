<template>
    <nav
        class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur-sm"
    >
        <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-8">
            <div class="flex h-[72px] items-center justify-between gap-6">
                <router-link to="/" class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-[#f6d98c] text-[11px] font-black text-slate-900 shadow-sm"
                    >
                        AU
                    </div>
                    <div>
                        <div
                            class="text-[14px] font-bold leading-none tracking-wide text-slate-900"
                        >
                            {{ t("brand") }}
                        </div>
                        <div
                            class="mt-1 text-[10px] uppercase tracking-[0.2em] text-slate-500"
                        >
                            {{ t("portal") }}
                        </div>
                    </div>
                </router-link>

                <div class="hidden items-center gap-6 lg:flex">
                    <router-link
                        v-for="item in navigation"
                        :key="item.name"
                        :to="item.to"
                        class="text-[12px] font-medium uppercase tracking-[0.12em] text-slate-600 transition hover:text-slate-900"
                    >
                        {{ t("nav." + item.name) }}
                    </router-link>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        @click="toggleLanguage"
                        :title="
                            currentLanguage === 'en'
                                ? 'በአማርኛ ቀይር'
                                : 'Switch to English'
                        "
                        class="rounded-full border border-slate-200 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-600 hover:bg-slate-100 transition"
                    >
                        {{ currentLanguage === "en" ? "EN" : "አማ" }}
                    </button>
                    <router-link
                        to="/apply"
                        :title="t('applyTitle')"
                        class="rounded-full bg-slate-900 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-white hover:bg-slate-700 transition"
                    >
                        ACT
                    </router-link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from "vue";

const translations = {
    en: {
        brand: "Addis Ababa University",
        portal: "Graduate Portal",
        applyTitle: "Apply — start your application",
        nav: {
            home: "Home",
            departments: "Departments",
            about: "Programs",
            gallery: "Gallery",
            articles: "Community",
            alumni: "Alumni",
            campusMap: "Campus Map",
        },
    },
    am: {
        brand: "አዲስ አበባ ዩኒቨርሲቲ",
        portal: "የምረቃ መግቢያ",
        applyTitle: "አመልክት — ማመልከቻዎን ይጀምሩ",
        nav: {
            home: "መነሻ",
            departments: "ክፍሎች",
            about: "ፕሮግራሞች",
            gallery: "ጋለሪ",
            articles: "ማህበረሰብ",
            alumni: "ተመራቂዎች",
            campusMap: "የግቢ ካርታ",
        },
    },
};

const currentLanguage = ref(
    localStorage.getItem("site-language") === "am" ? "am" : "en",
);

const toggleLanguage = () => {
    currentLanguage.value = currentLanguage.value === "en" ? "am" : "en";
    localStorage.setItem("site-language", currentLanguage.value);
};

const t = computed(() => (key) => {
    const keys = key.split(".");
    let value = translations[currentLanguage.value];
    for (const k of keys) {
        value = value?.[k];
    }
    return value || key;
});

const navigation = [
    { name: "home", to: "/" },
    { name: "departments", to: "/departments" },
    { name: "about", to: "/about" },
    { name: "gallery", to: "/gallery" },
    { name: "articles", to: "/articles" },
    { name: "alumni", to: "/alumni" },
    { name: "campusMap", to: "/campus-map" },
];
</script>
