<template>
    <div class="space-y-5">
        <div
            class="flex flex-col gap-4 rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#6a4db0]"
                >
                    Content setup
                </p>
                <h2
                    class="mt-2 text-[26px] font-black tracking-[-0.05em] text-[#1f1f1f]"
                >
                    Categories
                </h2>
                <p class="mt-1 text-sm text-[#5a5a5a]">
                    Manage article categories
                </p>
            </div>
            <button
                @click="showCreateModal = true"
                class="inline-flex items-center justify-center rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2 text-sm font-semibold text-[#4b2d8d] shadow-sm transition hover:bg-[#ece4ff]"
            >
                <PlusIcon class="mr-2 h-4 w-4" />
                New Category
            </button>
        </div>

        <div class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                        >Search</label
                    >
                    <input
                        v-model="filters.search"
                        @input="debouncedSearch"
                        type="text"
                        placeholder="Search categories..."
                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                    />
                </div>
                <button
                    @click="loadCategories"
                    class="rounded-md border border-[#c7b9eb] bg-[#f1ebff] px-4 py-2.5 text-sm font-semibold text-[#3d2877] transition hover:bg-[#eae1ff]"
                >
                    Search
                </button>
            </div>
        </div>

        <div
            class="overflow-hidden rounded-md border border-[#d9d9d9] bg-white shadow-sm"
        >
            <div
                v-if="categories.data && categories.data.length > 0"
                class="p-4"
            >
                <div
                    class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3"
                >
                    <div
                        v-for="category in categories.data"
                        :key="category.id"
                        class="rounded-md border border-[#e3e3e3] bg-[#fafafa] p-4 transition hover:border-[#d6c9f5] hover:shadow-sm"
                    >
                        <div
                            class="mb-3 flex items-start justify-between gap-3"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-4 w-4 rounded-full"
                                    :style="{ backgroundColor: category.color }"
                                ></div>
                                <h3
                                    class="text-lg font-semibold text-[#1d1d1d]"
                                >
                                    {{ category.name }}
                                </h3>
                            </div>
                            <span
                                :class="[
                                    'inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.18em]',
                                    category.is_active
                                        ? 'bg-[#eafaf0] text-[#178652]'
                                        : 'bg-[#efefef] text-[#4e4e4e]',
                                ]"
                            >
                                {{ category.is_active ? "Active" : "Inactive" }}
                            </span>
                        </div>

                        <p class="mb-4 text-sm text-[#5b5b5b]">
                            {{ category.description || "No description" }}
                        </p>

                        <div
                            class="mb-4 flex items-center justify-between text-[10px] font-medium uppercase tracking-[0.16em] text-[#6a6a6a]"
                        >
                            <span>{{ category.articles_count }} articles</span>
                            <span>{{ category.slug }}</span>
                        </div>

                        <div class="flex gap-2">
                            <button
                                @click="editCategory(category)"
                                class="flex-1 rounded-md border border-[#d7caef] bg-[#f5f0ff] px-3 py-2 text-sm font-semibold text-[#4b2d8d] transition hover:bg-[#ece4ff]"
                            >
                                Edit
                            </button>
                            <button
                                @click="toggleActive(category)"
                                :class="[
                                    'flex-1 rounded-md px-3 py-2 text-sm font-semibold text-white transition',
                                    category.is_active
                                        ? 'bg-[#cd9a2f] hover:bg-[#b8821d]'
                                        : 'bg-[#1f9d5a] hover:bg-[#18874d]',
                                ]"
                            >
                                {{
                                    category.is_active
                                        ? "Deactivate"
                                        : "Activate"
                                }}
                            </button>
                            <button
                                @click="deleteCategory(category)"
                                :disabled="category.articles_count > 0"
                                class="rounded-md bg-[#d93d47] px-3 py-2 text-sm font-semibold text-white transition hover:bg-[#bf2d37] disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="!loading" class="p-12 text-center">
                <FolderIcon class="mx-auto h-12 w-12 text-[#9d9d9d]" />
                <h3 class="mt-3 text-lg font-semibold text-[#1d1d1d]">
                    No categories found
                </h3>
                <p class="mt-2 text-sm text-[#666]">
                    Get started by creating a new category.
                </p>
            </div>
        </div>

        <div
            v-if="showCreateModal || showEditModal"
            class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-slate-900/40 p-4 backdrop-blur-sm"
        >
            <div
                class="relative mt-10 w-full max-w-xl rounded-md bg-white p-5 shadow-2xl"
            >
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-[#1d1d1d]">
                        {{
                            showEditModal ? "Edit Category" : "Create Category"
                        }}
                    </h3>
                    <button
                        @click="closeModal"
                        class="rounded-md p-1.5 text-[#7a7a7a] transition hover:bg-[#f3f3f3] hover:text-[#2d2d2d]"
                    >
                        <XMarkIcon class="h-5 w-5" />
                    </button>
                </div>

                <form @submit.prevent="saveCategory" class="space-y-4">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Name *</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                            placeholder="Category name"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Slug</label
                        >
                        <input
                            v-model="form.slug"
                            type="text"
                            class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                            placeholder="category-slug (auto-generated if empty)"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Description</label
                        >
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                            placeholder="Brief description of the category"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Color *</label
                        >
                        <div class="flex items-center gap-3">
                            <input
                                v-model="form.color"
                                type="color"
                                required
                                class="h-11 w-20 cursor-pointer rounded-md border border-[#d7d7d7] bg-white"
                            />
                            <input
                                v-model="form.color"
                                type="text"
                                pattern="^#[a-fA-F0-9]{6}$"
                                class="flex-1 rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                placeholder="#000000"
                            />
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            id="is_active"
                            class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                        />
                        <label for="is_active" class="text-sm text-[#4b4b4b]"
                            >Active</label
                        >
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button
                            type="button"
                            @click="closeModal"
                            class="rounded-md border border-[#d5d5d5] bg-white px-4 py-2.5 text-sm font-semibold text-[#4f4f4f] transition hover:bg-[#f5f5f5]"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            :disabled="saving"
                            class="rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2.5 text-sm font-semibold text-[#4b2d8d] transition hover:bg-[#ece4ff] disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{
                                saving
                                    ? "Saving..."
                                    : showEditModal
                                      ? "Update"
                                      : "Create"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, inject } from "vue";
import { PlusIcon, FolderIcon, XMarkIcon } from "@heroicons/vue/24/outline";

const showNotification = inject("showNotification");
const showLoading = inject("showLoading");
const hideLoading = inject("hideLoading");

const loading = ref(false);
const saving = ref(false);
const categories = ref({ data: [], total: 0 });
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editingCategory = ref(null);

const filters = ref({
    search: "",
    page: 1,
    per_page: 15,
});

const form = reactive({
    name: "",
    slug: "",
    description: "",
    color: "#3b82f6",
    is_active: true,
});

const loadCategories = async () => {
    try {
        loading.value = true;
        showLoading();

        const params = new URLSearchParams();
        Object.entries(filters.value).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });

        const response = await fetch(`/api/admin/categories?${params}`);
        const data = await response.json();

        categories.value = data;
    } catch (error) {
        showNotification("error", "Error", "Failed to load categories");
    } finally {
        loading.value = false;
        hideLoading();
    }
};

const saveCategory = async () => {
    try {
        saving.value = true;

        const url = showEditModal.value
            ? `/api/admin/categories/${editingCategory.value.id}`
            : "/api/admin/categories";
        const method = showEditModal.value ? "PUT" : "POST";

        const response = await fetch(url, {
            method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify(form),
        });

        const data = await response.json();

        if (data.success) {
            showNotification("success", "Success", data.message);
            closeModal();
            loadCategories();
        } else {
            showNotification(
                "error",
                "Error",
                data.message || "Failed to save category",
            );
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to save category");
    } finally {
        saving.value = false;
    }
};

const editCategory = (category) => {
    editingCategory.value = category;
    Object.assign(form, {
        name: category.name,
        slug: category.slug,
        description: category.description || "",
        color: category.color,
        is_active: category.is_active,
    });
    showEditModal.value = true;
};

const deleteCategory = async (category) => {
    if (!confirm(`Are you sure you want to delete "${category.name}"?`)) {
        return;
    }

    try {
        showLoading();

        const response = await fetch(`/api/admin/categories/${category.id}`, {
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
                "Category deleted successfully",
            );
            loadCategories();
        } else {
            showNotification("error", "Error", data.message);
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to delete category");
    } finally {
        hideLoading();
    }
};

const toggleActive = async (category) => {
    try {
        const response = await fetch(
            `/api/admin/categories/${category.id}/toggle-active`,
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
            category.is_active = !category.is_active;
            showNotification("success", "Success", data.message);
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to update category status");
    }
};

const closeModal = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
    editingCategory.value = null;
    Object.assign(form, {
        name: "",
        slug: "",
        description: "",
        color: "#3b82f6",
        is_active: true,
    });
};

// Debounced search
let searchTimeout;
const debouncedSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filters.value.page = 1;
        loadCategories();
    }, 500);
};

onMounted(() => {
    loadCategories();
});
</script>
