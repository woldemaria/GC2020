<template>
    <div class="space-y-5">
        <div
            class="flex flex-col gap-4 rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#6a4db0]"
                >
                    Content library
                </p>
                <h2
                    class="mt-2 text-[26px] font-black tracking-[-0.05em] text-[#1f1f1f]"
                >
                    Articles
                </h2>
                <p class="mt-1 text-sm text-[#5a5a5a]">
                    Manage your magazine articles
                </p>
            </div>
            <router-link
                to="/admin/articles/create"
                class="inline-flex items-center justify-center rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2 text-sm font-semibold text-[#4b2d8d] shadow-sm transition hover:bg-[#ece4ff]"
            >
                <PlusIcon class="mr-2 h-4 w-4" />
                New Article
            </router-link>
        </div>

        <div class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                        >Search</label
                    >
                    <input
                        v-model="filters.search"
                        type="text"
                        placeholder="Search articles..."
                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                    />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                        >Status</label
                    >
                    <select
                        v-model="filters.status"
                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                    >
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                        >Category</label
                    >
                    <select
                        v-model="filters.category_id"
                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                    >
                        <option value="">All Categories</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button
                        @click="loadArticles"
                        class="w-full rounded-md border border-[#c7b9eb] bg-[#f1ebff] px-4 py-2.5 text-sm font-semibold text-[#3d2877] transition hover:bg-[#eae1ff]"
                    >
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <div
            v-if="selectedArticles.length > 0"
            class="rounded-md border border-[#e1d9f7] bg-[#f8f4ff] p-4 shadow-sm"
        >
            <div
                class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <span class="text-sm font-medium text-[#4d2d8a]">
                    {{ selectedArticles.length }} article(s) selected
                </span>
                <div class="flex flex-wrap gap-2">
                    <button
                        @click="bulkAction('publish')"
                        class="rounded-md bg-[#1f9d5a] px-3 py-1.5 text-sm font-medium text-white transition hover:bg-[#18874d]"
                    >
                        Publish
                    </button>
                    <button
                        @click="bulkAction('unpublish')"
                        class="rounded-md bg-[#cf9a2f] px-3 py-1.5 text-sm font-medium text-white transition hover:bg-[#b8821d]"
                    >
                        Unpublish
                    </button>
                    <button
                        @click="bulkAction('delete')"
                        class="rounded-md bg-[#d93d47] px-3 py-1.5 text-sm font-medium text-white transition hover:bg-[#bf2d37]"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <div
            class="overflow-hidden rounded-md border border-[#d9d9d9] bg-white shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#e8e8e8]">
                    <thead class="bg-[#f5f5f5]">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                <input
                                    type="checkbox"
                                    :checked="selectAll"
                                    @change="toggleSelectAll"
                                    class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                />
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Article
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Category
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Author
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Status
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Views
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Date
                            </th>
                            <th
                                class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ededed] bg-white">
                        <tr
                            v-for="article in articles.data"
                            :key="article.id"
                            class="transition hover:bg-[#faf9fd]"
                        >
                            <td class="px-4 py-4">
                                <input
                                    type="checkbox"
                                    :value="article.id"
                                    v-model="selectedArticles"
                                    class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                />
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-11 w-11 overflow-hidden rounded-md bg-[#f3f3f3]"
                                    >
                                        <img
                                            v-if="article.featured_image"
                                            :src="article.featured_image"
                                            :alt="article.title"
                                            class="h-full w-full object-cover"
                                        />
                                        <div
                                            v-else
                                            class="flex h-full w-full items-center justify-center text-[#868686]"
                                        >
                                            <DocumentTextIcon class="h-5 w-5" />
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="truncate text-sm font-semibold text-[#1d1d1d]"
                                        >
                                            {{ article.title }}
                                        </div>
                                        <div
                                            v-if="article.excerpt"
                                            class="mt-1 truncate text-xs text-[#707070]"
                                        >
                                            {{
                                                truncateText(
                                                    article.excerpt,
                                                    50,
                                                )
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"
                                    :style="{
                                        backgroundColor:
                                            article.category.color + '20',
                                        color: article.category.color,
                                    }"
                                >
                                    {{ article.category.name }}
                                </span>
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-[#4b4b4b]"
                            >
                                {{ article.author.name }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span
                                    :class="[
                                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                        article.is_published
                                            ? 'bg-[#e9f8ee] text-[#178652]'
                                            : 'bg-[#f1f1f1] text-[#595959]',
                                    ]"
                                >
                                    {{
                                        article.is_published
                                            ? "Published"
                                            : "Draft"
                                    }}
                                </span>
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-[#5c5c5c]"
                            >
                                {{ article.views || 0 }}
                            </td>
                            <td
                                class="px-4 py-4 whitespace-nowrap text-sm text-[#5c5c5c]"
                            >
                                {{ formatDate(article.created_at) }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <div class="flex flex-wrap items-center gap-2">
                                    <router-link
                                        :to="`/admin/articles/${article.id}/edit`"
                                        class="font-medium text-[#4f2eb2] hover:text-[#3d237a]"
                                        >Edit</router-link
                                    >
                                    <button
                                        @click="togglePublished(article)"
                                        class="font-medium text-[#1a8b59] hover:text-[#116b45]"
                                    >
                                        {{
                                            article.is_published
                                                ? "Unpublish"
                                                : "Publish"
                                        }}
                                    </button>
                                    <button
                                        @click="toggleFeatured(article)"
                                        :class="[
                                            'font-medium',
                                            article.is_featured
                                                ? 'text-[#a96a1a] hover:text-[#7d4a10]'
                                                : 'text-[#575757] hover:text-[#2f2f2f]',
                                        ]"
                                    >
                                        {{
                                            article.is_featured
                                                ? "Unfeature"
                                                : "Feature"
                                        }}
                                    </button>
                                    <button
                                        @click="duplicateArticle(article)"
                                        class="font-medium text-[#5f4bb4] hover:text-[#4a3c8c]"
                                    >
                                        Duplicate
                                    </button>
                                    <button
                                        @click="deleteArticle(article)"
                                        class="font-medium text-[#d93d47] hover:text-[#b82d36]"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div
            v-if="articles.total > 0"
            class="rounded-md border border-[#d9d9d9] bg-white px-4 py-3 shadow-sm sm:px-6"
        >
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <p class="text-sm text-[#5e5e5e]">
                    Showing
                    <span class="font-semibold text-[#1c1c1c]">{{
                        articles.from
                    }}</span>
                    to
                    <span class="font-semibold text-[#1c1c1c]">{{
                        articles.to
                    }}</span>
                    of
                    <span class="font-semibold text-[#1c1c1c]">{{
                        articles.total
                    }}</span>
                    results
                </p>

                <nav class="flex items-center gap-2">
                    <button
                        @click="previousPage"
                        :disabled="articles.current_page === 1"
                        class="rounded-md border border-[#d6d6d6] bg-white px-3 py-2 text-sm font-medium text-[#4f4f4f] transition hover:bg-[#f4f3f6] disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Previous
                    </button>
                    <button
                        v-for="page in paginationPages"
                        :key="page"
                        @click="goToPage(page)"
                        :class="[
                            'rounded-md border px-3 py-2 text-sm font-medium',
                            page === articles.current_page
                                ? 'border-[#7d63c8] bg-[#f2ecff] text-[#46307f]'
                                : 'border-[#d6d6d6] bg-white text-[#4f4f4f] hover:bg-[#f4f3f6]',
                        ]"
                    >
                        {{ page }}
                    </button>
                    <button
                        @click="nextPage"
                        :disabled="articles.current_page >= articles.last_page"
                        class="rounded-md border border-[#d6d6d6] bg-white px-3 py-2 text-sm font-medium text-[#4f4f4f] transition hover:bg-[#f4f3f6] disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Next
                    </button>
                </nav>
            </div>
        </div>

        <div
            v-if="!loading && articles.data && articles.data.length === 0"
            class="rounded-md border border-dashed border-[#d1d1d1] bg-white p-12 text-center shadow-sm"
        >
            <DocumentTextIcon class="mx-auto h-12 w-12 text-[#9d9d9d]" />
            <h3 class="mt-3 text-lg font-semibold text-[#1d1d1d]">
                No articles found
            </h3>
            <p class="mt-2 text-sm text-[#666]">
                Get started by creating a new article.
            </p>
            <div class="mt-6">
                <router-link
                    to="/admin/articles/create"
                    class="inline-flex items-center rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2.5 text-sm font-semibold text-[#4b2d8d] transition hover:bg-[#ece4ff]"
                >
                    <PlusIcon class="mr-2 h-4 w-4" />
                    New Article
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, inject, watch } from "vue";
import { DocumentTextIcon, PlusIcon } from "@heroicons/vue/24/outline";

const showNotification = inject("showNotification");
const showLoading = inject("showLoading");
const hideLoading = inject("hideLoading");

const loading = ref(false);
const articles = ref({ data: [], total: 0, current_page: 1, last_page: 1 });
const categories = ref([]);
const selectedArticles = ref([]);

const filters = ref({
    search: "",
    status: "",
    category_id: "",
    page: 1,
    per_page: 15,
});

const selectAll = computed(() => {
    return (
        articles.value.data.length > 0 &&
        selectedArticles.value.length === articles.value.data.length
    );
});

const paginationPages = computed(() => {
    const current = articles.value.current_page;
    const last = articles.value.last_page;
    const pages = [];

    for (
        let i = Math.max(1, current - 2);
        i <= Math.min(last, current + 2);
        i++
    ) {
        pages.push(i);
    }

    return pages;
});

const loadArticles = async () => {
    try {
        loading.value = true;
        showLoading();

        const params = new URLSearchParams();
        Object.entries(filters.value).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });

        const response = await fetch(`/api/admin/articles?${params}`);
        const data = await response.json();

        articles.value = data;
        selectedArticles.value = [];
    } catch (error) {
        showNotification("error", "Error", "Failed to load articles");
    } finally {
        loading.value = false;
        hideLoading();
    }
};

const loadCategories = async () => {
    try {
        const response = await fetch("/api/admin/articles/form-data");
        const data = await response.json();

        if (data.success) {
            categories.value = data.data.categories;
        }
    } catch (error) {
        console.error("Failed to load categories:", error);
    }
};

const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedArticles.value = [];
    } else {
        selectedArticles.value = articles.value.data.map(
            (article) => article.id,
        );
    }
};

const togglePublished = async (article) => {
    try {
        const response = await fetch(
            `/api/admin/articles/${article.id}/toggle-published`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            },
        );

        const data = await response.json();

        if (data.success) {
            article.is_published = !article.is_published;
            showNotification("success", "Success", data.message);
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to update article status");
    }
};

const toggleFeatured = async (article) => {
    try {
        const response = await fetch(
            `/api/admin/articles/${article.id}/toggle-featured`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            },
        );

        const data = await response.json();

        if (data.success) {
            article.is_featured = !article.is_featured;
            showNotification("success", "Success", data.message);
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to update featured status");
    }
};

const duplicateArticle = async (article) => {
    try {
        showLoading();

        const response = await fetch(
            `/api/admin/articles/${article.id}/duplicate`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            },
        );

        const data = await response.json();

        if (data.success) {
            showNotification(
                "success",
                "Success",
                "Article duplicated successfully",
            );
            loadArticles();
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to duplicate article");
    } finally {
        hideLoading();
    }
};

const deleteArticle = async (article) => {
    if (!confirm(`Are you sure you want to delete "${article.title}"?`)) {
        return;
    }

    try {
        showLoading();

        const response = await fetch(`/api/admin/articles/${article.id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
        });

        const data = await response.json();

        if (data.success) {
            showNotification(
                "success",
                "Success",
                "Article deleted successfully",
            );
            loadArticles();
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to delete article");
    } finally {
        hideLoading();
    }
};

const bulkAction = async (action) => {
    const actionText = action === "delete" ? "delete" : action;
    if (
        !confirm(
            `Are you sure you want to ${actionText} ${selectedArticles.value.length} article(s)?`,
        )
    ) {
        return;
    }

    try {
        showLoading();

        const response = await fetch("/api/admin/articles/bulk-action", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({
                action: action,
                ids: selectedArticles.value,
            }),
        });

        const data = await response.json();

        if (data.success) {
            showNotification("success", "Success", data.message);
            loadArticles();
        }
    } catch (error) {
        showNotification("error", "Error", `Failed to ${actionText} articles`);
    } finally {
        hideLoading();
    }
};

const previousPage = () => {
    if (filters.value.page > 1) {
        filters.value.page--;
        loadArticles();
    }
};

const nextPage = () => {
    if (filters.value.page < articles.value.last_page) {
        filters.value.page++;
        loadArticles();
    }
};

const goToPage = (page) => {
    filters.value.page = page;
    loadArticles();
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

const truncateText = (text, length) => {
    return text.length > length ? text.substring(0, length) + "..." : text;
};

// Watch for filter changes
watch(
    () => [
        filters.value.search,
        filters.value.status,
        filters.value.category_id,
    ],
    () => {
        filters.value.page = 1;
    },
    { debounce: 500 },
);

onMounted(() => {
    loadArticles();
    loadCategories();
});
</script>
