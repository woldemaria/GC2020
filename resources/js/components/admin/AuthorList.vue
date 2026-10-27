<template>
    <div class="space-y-5">
        <div
            class="flex flex-col gap-4 rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <p
                    class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#6a4db0]"
                >
                    Content team
                </p>
                <h2
                    class="mt-2 text-[26px] font-black tracking-[-0.05em] text-[#1f1f1f]"
                >
                    Authors
                </h2>
                <p class="mt-1 text-sm text-[#5a5a5a]">
                    Manage article authors
                </p>
            </div>
            <button
                @click="showCreateModal = true"
                class="inline-flex items-center justify-center rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2 text-sm font-semibold text-[#4b2d8d] shadow-sm transition hover:bg-[#ece4ff]"
            >
                <PlusIcon class="mr-2 h-4 w-4" />
                New Author
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
                        placeholder="Search authors..."
                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                    />
                </div>
                <button
                    @click="loadAuthors"
                    class="rounded-md border border-[#c7b9eb] bg-[#f1ebff] px-4 py-2.5 text-sm font-semibold text-[#3d2877] transition hover:bg-[#eae1ff]"
                >
                    Search
                </button>
            </div>
        </div>

        <div
            class="overflow-hidden rounded-md border border-[#d9d9d9] bg-white shadow-sm"
        >
            <div v-if="authors.data && authors.data.length > 0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#e8e8e8]">
                        <thead class="bg-[#f5f5f5]">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                                >
                                    Author
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                                >
                                    Position
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                                >
                                    Articles
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-[0.18em] text-[#5e5e5e]"
                                >
                                    Status
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
                                v-for="author in authors.data"
                                :key="author.id"
                                class="transition hover:bg-[#faf9fd]"
                            >
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            <img
                                                v-if="author.avatar"
                                                :src="author.avatar"
                                                :alt="author.name"
                                                class="h-12 w-12 rounded-full object-cover ring-2 ring-[#efe9ff]"
                                            />
                                            <div
                                                v-else
                                                class="flex h-12 w-12 items-center justify-center rounded-full bg-[#f0ebff] text-[#5d3fb0]"
                                            >
                                                <UserIcon class="h-6 w-6" />
                                            </div>
                                        </div>
                                        <div class="min-w-0">
                                            <div
                                                class="truncate text-sm font-semibold text-[#1d1d1d]"
                                            >
                                                {{ author.name }}
                                            </div>
                                            <div
                                                class="truncate text-xs text-[#707070]"
                                            >
                                                {{ author.email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-4 py-4 whitespace-nowrap text-sm text-[#4b4b4b]"
                                >
                                    {{ author.position }}
                                </td>
                                <td
                                    class="px-4 py-4 whitespace-nowrap text-sm text-[#5c5c5c]"
                                >
                                    {{ author.articles_count || 0 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span
                                        :class="[
                                            'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                            author.is_active
                                                ? 'bg-[#eafaf0] text-[#178652]'
                                                : 'bg-[#f1f1f1] text-[#595959]',
                                        ]"
                                    >
                                        {{
                                            author.is_active
                                                ? "Active"
                                                : "Inactive"
                                        }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <div
                                        class="flex flex-wrap items-center gap-3"
                                    >
                                        <button
                                            @click="editAuthor(author)"
                                            class="font-medium text-[#4f2eb2] hover:text-[#3d237a]"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="toggleActive(author)"
                                            :class="[
                                                'font-medium',
                                                author.is_active
                                                    ? 'text-[#a96a1a] hover:text-[#7d4a10]'
                                                    : 'text-[#1a8b59] hover:text-[#116b45]',
                                            ]"
                                        >
                                            {{
                                                author.is_active
                                                    ? "Deactivate"
                                                    : "Activate"
                                            }}
                                        </button>
                                        <button
                                            @click="deleteAuthor(author)"
                                            :disabled="
                                                author.articles_count > 0
                                            "
                                            class="font-medium text-[#d93d47] hover:text-[#b82d36] disabled:cursor-not-allowed disabled:opacity-50"
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

            <div v-else-if="!loading" class="py-12 text-center">
                <UserIcon class="mx-auto h-12 w-12 text-[#9d9d9d]" />
                <h3 class="mt-3 text-lg font-semibold text-[#1d1d1d]">
                    No authors found
                </h3>
                <p class="mt-2 text-sm text-[#666]">
                    Get started by creating a new author.
                </p>
            </div>
        </div>

        <div
            v-if="showCreateModal || showEditModal"
            class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-slate-900/40 p-4 backdrop-blur-sm"
        >
            <div
                class="relative mt-10 w-full max-w-2xl rounded-md bg-white p-5 shadow-2xl"
            >
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-[#1d1d1d]">
                        {{ showEditModal ? "Edit Author" : "Create Author" }}
                    </h3>
                    <button
                        @click="closeModal"
                        class="rounded-md p-1.5 text-[#7a7a7a] transition hover:bg-[#f3f3f3] hover:text-[#2d2d2d]"
                    >
                        <XMarkIcon class="h-5 w-5" />
                    </button>
                </div>

                <form @submit.prevent="saveAuthor" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
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
                                placeholder="Author's full name"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                                >Email *</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                placeholder="author@example.com"
                            />
                        </div>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Position *</label
                        >
                        <input
                            v-model="form.position"
                            type="text"
                            required
                            class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                            placeholder="e.g., Senior Writer, Editor, Student Reporter"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Avatar URL</label
                        >
                        <input
                            v-model="form.avatar"
                            type="url"
                            class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                            placeholder="https://example.com/avatar.jpg"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-[#4b4b4b]"
                            >Bio</label
                        >
                        <textarea
                            v-model="form.bio"
                            rows="4"
                            class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                            placeholder="Brief biography of the author"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-3 block text-sm font-medium text-[#4b4b4b]"
                            >Social Links</label
                        >
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs text-[#666]"
                                    >Facebook</label
                                >
                                <input
                                    v-model="form.social_links.facebook"
                                    type="url"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="https://facebook.com/username"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-[#666]"
                                    >Twitter</label
                                >
                                <input
                                    v-model="form.social_links.twitter"
                                    type="url"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="https://twitter.com/username"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-[#666]"
                                    >LinkedIn</label
                                >
                                <input
                                    v-model="form.social_links.linkedin"
                                    type="url"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="https://linkedin.com/in/username"
                                />
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-[#666]"
                                    >Instagram</label
                                >
                                <input
                                    v-model="form.social_links.instagram"
                                    type="url"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="https://instagram.com/username"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input
                            v-model="form.is_active"
                            type="checkbox"
                            id="author_is_active"
                            class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                        />
                        <label
                            for="author_is_active"
                            class="text-sm text-[#4b4b4b]"
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
import { PlusIcon, UserIcon, XMarkIcon } from "@heroicons/vue/24/outline";

const showNotification = inject("showNotification");
const showLoading = inject("showLoading");
const hideLoading = inject("hideLoading");

const loading = ref(false);
const saving = ref(false);
const authors = ref({ data: [], total: 0 });
const showCreateModal = ref(false);
const showEditModal = ref(false);
const editingAuthor = ref(null);

const filters = ref({
    search: "",
    page: 1,
    per_page: 15,
});

const form = reactive({
    name: "",
    email: "",
    position: "",
    bio: "",
    avatar: "",
    social_links: {
        facebook: "",
        twitter: "",
        linkedin: "",
        instagram: "",
    },
    is_active: true,
});

const loadAuthors = async () => {
    try {
        loading.value = true;
        showLoading();

        const params = new URLSearchParams();
        Object.entries(filters.value).forEach(([key, value]) => {
            if (value) params.append(key, value);
        });

        const response = await fetch(`/api/admin/authors?${params}`);
        const data = await response.json();

        authors.value = data;
    } catch (error) {
        showNotification("error", "Error", "Failed to load authors");
    } finally {
        loading.value = false;
        hideLoading();
    }
};

const saveAuthor = async () => {
    try {
        saving.value = true;

        const url = showEditModal.value
            ? `/api/admin/authors/${editingAuthor.value.id}`
            : "/api/admin/authors";
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
            loadAuthors();
        } else {
            showNotification(
                "error",
                "Error",
                data.message || "Failed to save author",
            );
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to save author");
    } finally {
        saving.value = false;
    }
};

const editAuthor = (author) => {
    editingAuthor.value = author;
    Object.assign(form, {
        name: author.name,
        email: author.email,
        position: author.position,
        bio: author.bio || "",
        avatar: author.avatar || "",
        social_links: author.social_links
            ? JSON.parse(author.social_links)
            : {
                  facebook: "",
                  twitter: "",
                  linkedin: "",
                  instagram: "",
              },
        is_active: author.is_active,
    });
    showEditModal.value = true;
};

const deleteAuthor = async (author) => {
    if (!confirm(`Are you sure you want to delete "${author.name}"?`)) {
        return;
    }

    try {
        showLoading();

        const response = await fetch(`/api/admin/authors/${author.id}`, {
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
                "Author deleted successfully",
            );
            loadAuthors();
        } else {
            showNotification("error", "Error", data.message);
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to delete author");
    } finally {
        hideLoading();
    }
};

const toggleActive = async (author) => {
    try {
        const response = await fetch(
            `/api/admin/authors/${author.id}/toggle-active`,
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
            author.is_active = !author.is_active;
            showNotification("success", "Success", data.message);
        }
    } catch (error) {
        showNotification("error", "Error", "Failed to update author status");
    }
};

const closeModal = () => {
    showCreateModal.value = false;
    showEditModal.value = false;
    editingAuthor.value = null;
    Object.assign(form, {
        name: "",
        email: "",
        position: "",
        bio: "",
        avatar: "",
        social_links: {
            facebook: "",
            twitter: "",
            linkedin: "",
            instagram: "",
        },
        is_active: true,
    });
};

// Debounced search
let searchTimeout;
const debouncedSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filters.value.page = 1;
        loadAuthors();
    }, 500);
};

onMounted(() => {
    loadAuthors();
});
</script>
