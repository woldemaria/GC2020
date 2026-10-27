<template>
    <div class="min-h-screen bg-[#edf0f3] px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl">
            <section
                class="relative overflow-hidden rounded-[28px] bg-[#0a1122] shadow-[0_24px_60px_rgba(15,23,42,0.18)]"
            >
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_30%),linear-gradient(135deg,rgba(10,17,34,0.9),rgba(56,36,94,0.88))]"
                ></div>
                <div class="relative px-6 py-10 sm:px-8 lg:px-10">
                    <div
                        class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between"
                    >
                        <div class="max-w-2xl">
                            <div
                                class="mb-4 text-[10px] font-semibold uppercase tracking-[0.32em] text-slate-200"
                            >
                                Support
                            </div>
                            <h1
                                class="text-4xl font-black tracking-[-0.05em] text-white sm:text-5xl"
                            >
                                Help Center
                            </h1>
                            <p class="mt-4 text-base leading-7 text-slate-200">
                                Get answers, support, and guidance for
                                admissions, verification, student services, and
                                magazine submissions.
                            </p>
                        </div>
                        <router-link
                            to="/contact"
                            class="inline-flex items-center justify-center rounded-xl bg-[#f6d98c] px-5 py-3 text-sm font-bold text-slate-900 shadow-lg shadow-[#f6d98c]/25 transition hover:-translate-y-0.5 hover:bg-[#f9e2a8]"
                        >
                            Contact the team
                        </router-link>
                    </div>
                </div>
            </section>

            <section class="mt-8 grid gap-5 md:grid-cols-3">
                <div
                    v-for="card in supportCards"
                    :key="card.title"
                    class="rounded-[24px] border border-slate-200 bg-white p-6 shadow-[0_20px_40px_rgba(15,23,42,0.06)]"
                >
                    <div
                        class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl"
                        :class="card.iconBg"
                    >
                        <component
                            :is="card.icon"
                            class="h-6 w-6"
                            :class="card.iconColor"
                        />
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">
                        {{ card.title }}
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        {{ card.description }}
                    </p>
                </div>
            </section>

            <section class="mt-8 grid gap-8 lg:grid-cols-[1.3fr_0.7fr]">
                <div
                    class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_20px_40px_rgba(15,23,42,0.06)]"
                >
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <div
                                class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                            >
                                Support
                            </div>
                            <h2
                                class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-900"
                            >
                                Frequently asked questions
                            </h2>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div
                            v-for="item in faqs"
                            :key="item.question"
                            class="rounded-2xl border border-slate-200 bg-slate-50 p-4"
                        >
                            <h3 class="text-base font-bold text-slate-900">
                                {{ item.question }}
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                {{ item.answer }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_20px_40px_rgba(15,23,42,0.06)]"
                >
                    <div
                        class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                    >
                        Direct help
                    </div>
                    <h2
                        class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-900"
                    >
                        Need direct help?
                    </h2>

                    <div class="mt-6 space-y-5 text-sm text-slate-700">
                        <div class="rounded-2xl bg-slate-50 p-3">
                            <div
                                class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                            >
                                Email
                            </div>
                            <a
                                href="mailto:info@gcuniversity.edu.et"
                                class="mt-2 inline-block text-base font-semibold text-blue-600 hover:underline"
                                >info@gcuniversity.edu.et</a
                            >
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3">
                            <div
                                class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                            >
                                Phone
                            </div>
                            <p
                                class="mt-2 text-base font-semibold text-slate-900"
                            >
                                +251-11-123-4567
                            </p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3">
                            <div
                                class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500"
                            >
                                Office hours
                            </div>
                            <p
                                class="mt-2 text-base font-semibold text-slate-900"
                            >
                                Mon - Fri, 8:00 AM - 5:00 PM
                            </p>
                        </div>
                    </div>

                    <router-link
                        to="/contact"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800"
                    >
                        Contact the team
                    </router-link>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import {
    AcademicCapIcon,
    ChatBubbleLeftRightIcon,
    ClipboardDocumentListIcon,
} from "@heroicons/vue/24/outline";

const supportCards = ref([
    {
        title: "FAQs",
        description:
            "Find quick answers about admissions, verification, student services, and campus support.",
        icon: AcademicCapIcon,
        iconBg: "bg-blue-100",
        iconColor: "text-blue-600",
    },
    {
        title: "Submit a ticket",
        description:
            "Ask for academic, admissions, or portal support and our team will respond promptly.",
        icon: ChatBubbleLeftRightIcon,
        iconBg: "bg-emerald-100",
        iconColor: "text-emerald-600",
    },
    {
        title: "Contact support",
        description:
            "Reach the admissions and student support desk for direct guidance and follow-up.",
        icon: ClipboardDocumentListIcon,
        iconBg: "bg-violet-100",
        iconColor: "text-violet-600",
    },
]);

const faqs = ref([
    {
        question: "How do I verify a certificate?",
        answer: "Visit the certificate verification page and enter the unique code provided by your program office or the registrar.",
    },
    {
        question: "Can I submit an article to the magazine?",
        answer: "Yes. Use the Submit Article page to send your story, insight, profile, or feature idea for editorial review.",
    },
    {
        question: "How can I request admission information?",
        answer: "Use the contact form or call the admissions office. Our team will guide you through the process and required documents.",
    },
    {
        question: "Where can I find student resources?",
        answer: "You can access departmental information, campus updates, and student stories through the main website navigation.",
    },
]);
</script>
