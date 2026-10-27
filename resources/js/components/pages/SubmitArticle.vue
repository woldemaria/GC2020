<template>
    <div class="min-h-screen bg-[#edf0f3] px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">
            <section
                class="relative overflow-hidden rounded-[28px] bg-[#0a1122] shadow-[0_24px_60px_rgba(15,23,42,0.18)]"
            >
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.15),_transparent_28%),linear-gradient(135deg,rgba(10,17,34,0.95),rgba(42,41,84,0.9))]"
                ></div>
                <div class="relative px-6 py-10 sm:px-8 lg:px-10">
                    <div class="max-w-2xl">
                        <div
                            class="mb-4 text-[10px] font-semibold uppercase tracking-[0.32em] text-slate-200"
                        >
                            Magazine
                        </div>
                        <h1
                            class="text-4xl font-black tracking-[-0.05em] text-white sm:text-5xl"
                        >
                            Submit Article
                        </h1>
                        <p class="mt-4 text-base leading-7 text-slate-200">
                            Share your story, student experience, or research
                            with the GC Magazine editorial team.
                        </p>
                    </div>
                </div>
            </section>

            <section
                class="mt-8 rounded-[28px] border border-slate-200 bg-white p-6 shadow-[0_20px_40px_rgba(15,23,42,0.06)] sm:p-8"
            >
                <div
                    class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between"
                >
                    <div>
                        <div
                            class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-400"
                        >
                            Submission
                        </div>
                        <h2
                            class="mt-2 text-2xl font-black tracking-[-0.04em] text-slate-900"
                        >
                            Article details
                        </h2>
                    </div>
                    <p class="text-sm text-slate-500">
                        We review every submission within 3–5 business days.
                    </p>
                </div>

                <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700"
                                >Full Name *</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                        </div>
                        <div>
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700"
                                >Email Address *</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700"
                                >Category *</label
                            >
                            <select
                                v-model="form.category"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            >
                                <option value="">Select a category</option>
                                <option value="student-story">
                                    Student story
                                </option>
                                <option value="research">
                                    Research & innovation
                                </option>
                                <option value="campus-life">Campus life</option>
                                <option value="alumni">Alumni spotlight</option>
                                <option value="opinion">Opinion</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700"
                                >Article Title *</label
                            >
                            <input
                                v-model="form.title"
                                type="text"
                                required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            class="mb-2 block text-sm font-semibold text-slate-700"
                            >Short Summary *</label
                        >
                        <textarea
                            v-model="form.summary"
                            rows="4"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Briefly describe the story or idea you want to share."
                        ></textarea>
                    </div>

                    <div>
                        <label
                            class="mb-2 block text-sm font-semibold text-slate-700"
                            >Submission Notes</label
                        >
                        <textarea
                            v-model="form.notes"
                            rows="5"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                            placeholder="Add references, images, or any additional context for the editorial team."
                        ></textarea>
                    </div>

                    <div
                        class="flex flex-col gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <p class="text-sm text-slate-500">* Required fields</p>
                        <button
                            type="submit"
                            :disabled="isSubmitting"
                            class="inline-flex items-center justify-center rounded-xl bg-[#f6d98c] px-5 py-3 text-sm font-bold text-slate-900 shadow-lg shadow-[#f6d98c]/25 transition hover:-translate-y-0.5 hover:bg-[#f9e2a8] disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{
                                isSubmitting
                                    ? "Submitting..."
                                    : "Submit Article"
                            }}
                        </button>
                    </div>
                </form>

                <div
                    v-if="submitted"
                    class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800"
                >
                    Your article submission has been received. The editorial
                    team will review it and contact you via email.
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";

const isSubmitting = ref(false);
const submitted = ref(false);

const form = reactive({
    name: "",
    email: "",
    category: "",
    title: "",
    summary: "",
    notes: "",
});

const submitForm = () => {
    isSubmitting.value = true;

    setTimeout(() => {
        isSubmitting.value = false;
        submitted.value = true;
        Object.keys(form).forEach((key) => {
            form[key] = "";
        });
    }, 600);
};
</script>
