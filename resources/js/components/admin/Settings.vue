<template>
    <div class="space-y-5">
        <div class="rounded-md border border-[#d9d9d9] bg-white p-4 shadow-sm">
            <p
                class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#6a4db0]"
            >
                System configuration
            </p>
            <h2
                class="mt-2 text-[26px] font-black tracking-[-0.05em] text-[#1f1f1f]"
            >
                Settings
            </h2>
            <p class="mt-1 text-sm text-[#5a5a5a]">
                Configure your magazine admin panel
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
            <div class="lg:col-span-1">
                <nav
                    class="space-y-2 rounded-md border border-[#d9d9d9] bg-white p-3 shadow-sm"
                >
                    <button
                        v-for="section in sections"
                        :key="section.id"
                        @click="activeSection = section.id"
                        :class="[
                            'flex w-full items-center rounded-md px-3 py-2.5 text-left text-sm font-medium transition',
                            activeSection === section.id
                                ? 'bg-[#f1ebff] text-[#4b2d8d] ring-1 ring-[#d7caef]'
                                : 'text-[#565656] hover:bg-[#f5f5f5] hover:text-[#1d1d1d]',
                        ]"
                    >
                        <component :is="section.icon" class="mr-2 h-4 w-4" />
                        {{ section.name }}
                    </button>
                </nav>
            </div>

            <div class="lg:col-span-2">
                <div
                    class="rounded-md border border-[#d9d9d9] bg-white p-5 shadow-sm"
                >
                    <!-- Registration Permissions Section -->
                    <div v-if="activeSection === 'registration'" class="space-y-6">
                        <div class="border-b border-[#e8e8e8] pb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-[#1d1d1d]">
                                        Student Registration & Admissions Permissions
                                    </h3>
                                    <p class="mt-1 text-xs text-[#555]">
                                        Permit or close online registration across the Addis Ababa University Graduate Portal as necessary.
                                    </p>
                                </div>
                                <a
                                    href="/signup"
                                    target="_blank"
                                    class="inline-flex items-center gap-1.5 rounded-md border border-[#d8d8d8] bg-white px-3 py-1.5 text-xs font-semibold text-[#333] hover:bg-[#f5f5f5] transition"
                                >
                                    <span>Preview /signup</span>
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Big Permission Toggle Card -->
                        <div
                            :class="[
                                'rounded-xl border p-5 transition-all',
                                settings.registrationIsOpen
                                    ? 'border-emerald-200 bg-emerald-50/70'
                                    : 'border-rose-200 bg-rose-50/70',
                            ]"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <div
                                        :class="[
                                            'mt-0.5 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg shadow-sm',
                                            settings.registrationIsOpen
                                                ? 'bg-emerald-600 text-white'
                                                : 'bg-rose-600 text-white',
                                        ]"
                                    >
                                        <svg v-if="settings.registrationIsOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-base font-bold text-[#111]">
                                                {{ settings.registrationIsOpen ? 'Registration is currently OPEN' : 'Registration is currently CLOSED' }}
                                            </h4>
                                            <span
                                                :class="[
                                                    'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider',
                                                    settings.registrationIsOpen ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'
                                                ]"
                                            >
                                                {{ settings.registrationIsOpen ? 'Active' : 'Locked' }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-xs text-[#555]">
                                            {{
                                                settings.registrationIsOpen
                                                    ? 'Prospective graduates and applicants can freely submit new registrations on /signup.'
                                                    : 'Public registrations are strictly blocked by the backend and replaced with the custom notice on /signup.'
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    @click="settings.registrationIsOpen = !settings.registrationIsOpen"
                                    :class="[
                                        'px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-1.5',
                                        settings.registrationIsOpen
                                            ? 'bg-rose-600 hover:bg-rose-700 text-white'
                                            : 'bg-emerald-600 hover:bg-emerald-700 text-white',
                                    ]"
                                >
                                    <span>{{ settings.registrationIsOpen ? 'Close Registration Now' : 'Open Registration Now' }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Form Details -->
                        <div class="space-y-4">
                            <div>
                                <label for="academicTerm" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#4d4d4d]">
                                    Current Academic Term / Intake
                                </label>
                                <input
                                    id="academicTerm"
                                    v-model="settings.academicTerm"
                                    type="text"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="Academic Year 2026/2027"
                                />
                            </div>

                            <div>
                                <label for="closedTitle" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#4d4d4d]">
                                    Closed Notice Heading
                                </label>
                                <input
                                    id="closedTitle"
                                    v-model="settings.closedTitle"
                                    type="text"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="Registration Currently Closed"
                                />
                            </div>

                            <div>
                                <label for="closedMessage" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#4d4d4d]">
                                    Notice Message to Applicants (Shown when closed)
                                </label>
                                <textarea
                                    id="closedMessage"
                                    v-model="settings.closedMessage"
                                    rows="3"
                                    class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    placeholder="Explain the reason or instructions for applicants..."
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="reopeningDate" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#4d4d4d]">
                                        Expected Reopening Date
                                    </label>
                                    <input
                                        id="reopeningDate"
                                        v-model="settings.reopeningDate"
                                        type="text"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                        placeholder="November 2026 / To be announced"
                                    />
                                </div>

                                <div>
                                    <label for="regContactEmail" class="mb-1 block text-xs font-bold uppercase tracking-wider text-[#4d4d4d]">
                                        Registrar Support Email
                                    </label>
                                    <input
                                        id="regContactEmail"
                                        v-model="settings.contactEmail"
                                        type="email"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                        placeholder="registrar@aau.edu.et"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'general'" class="space-y-6">
                        <div>
                            <h3
                                class="mb-4 text-lg font-semibold text-[#1d1d1d]"
                            >
                                General Settings
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        for="siteName"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Site Name</label
                                    >
                                    <input
                                        id="siteName"
                                        v-model="settings.siteName"
                                        type="text"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                        placeholder="GC Magazine"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="siteDescription"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Site Description</label
                                    >
                                    <textarea
                                        id="siteDescription"
                                        v-model="settings.siteDescription"
                                        rows="3"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                        placeholder="Your university magazine description..."
                                    />
                                </div>

                                <div>
                                    <label
                                        for="adminEmail"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Admin Email</label
                                    >
                                    <input
                                        id="adminEmail"
                                        v-model="settings.adminEmail"
                                        type="email"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                        placeholder="admin@gcmagazine.edu"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="timezone"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Timezone</label
                                    >
                                    <select
                                        id="timezone"
                                        v-model="settings.timezone"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    >
                                        <option value="UTC">UTC</option>
                                        <option value="America/New_York">
                                            Eastern Time
                                        </option>
                                        <option value="America/Chicago">
                                            Central Time
                                        </option>
                                        <option value="America/Denver">
                                            Mountain Time
                                        </option>
                                        <option value="America/Los_Angeles">
                                            Pacific Time
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'content'" class="space-y-6">
                        <div>
                            <h3
                                class="mb-4 text-lg font-semibold text-[#1d1d1d]"
                            >
                                Content Settings
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        for="articlesPerPage"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Articles per Page</label
                                    >
                                    <input
                                        id="articlesPerPage"
                                        v-model="settings.articlesPerPage"
                                        type="number"
                                        min="1"
                                        max="50"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    />
                                </div>

                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="autoPublish"
                                        v-model="settings.autoPublish"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Auto-publish articles after creation
                                </label>

                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="moderateComments"
                                        v-model="settings.moderateComments"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Moderate comments before publishing
                                </label>

                                <div>
                                    <label
                                        for="excerptLength"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Auto-generated Excerpt Length
                                        (words)</label
                                    >
                                    <input
                                        id="excerptLength"
                                        v-model="settings.excerptLength"
                                        type="number"
                                        min="10"
                                        max="100"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'media'" class="space-y-6">
                        <div>
                            <h3
                                class="mb-4 text-lg font-semibold text-[#1d1d1d]"
                            >
                                Media Settings
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label
                                        for="maxUploadSize"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Maximum Upload Size (MB)</label
                                    >
                                    <input
                                        id="maxUploadSize"
                                        v-model="settings.maxUploadSize"
                                        type="number"
                                        min="1"
                                        max="100"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="allowedFormats"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Allowed Image Formats</label
                                    >
                                    <div class="grid grid-cols-2 gap-2">
                                        <label
                                            v-for="format in imageFormats"
                                            :key="format"
                                            class="flex items-center gap-2 rounded-md bg-[#f7f7f7] px-3 py-2 text-sm text-[#4d4d4d]"
                                        >
                                            <input
                                                v-model="
                                                    settings.allowedFormats
                                                "
                                                :value="format"
                                                type="checkbox"
                                                class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                            />
                                            {{ format.toUpperCase() }}
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        for="imageQuality"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Image Compression Quality (%)</label
                                    >
                                    <input
                                        id="imageQuality"
                                        v-model="settings.imageQuality"
                                        type="range"
                                        min="50"
                                        max="100"
                                        step="5"
                                        class="w-full accent-[#5d3fb0]"
                                    />
                                    <div class="mt-2 text-sm text-[#666]">
                                        {{ settings.imageQuality }}%
                                    </div>
                                </div>

                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="generateThumbnails"
                                        v-model="settings.generateThumbnails"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Generate thumbnails automatically
                                </label>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'security'" class="space-y-6">
                        <div>
                            <h3
                                class="mb-4 text-lg font-semibold text-[#1d1d1d]"
                            >
                                Security Settings
                            </h3>

                            <div class="space-y-4">
                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="requireAuth"
                                        v-model="settings.requireAuth"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Require authentication for admin panel
                                </label>

                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="enableTwoFactor"
                                        v-model="settings.enableTwoFactor"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Enable two-factor authentication
                                </label>

                                <div>
                                    <label
                                        for="sessionTimeout"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Session Timeout (minutes)</label
                                    >
                                    <input
                                        id="sessionTimeout"
                                        v-model="settings.sessionTimeout"
                                        type="number"
                                        min="15"
                                        max="1440"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    />
                                </div>

                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="logAdminActions"
                                        v-model="settings.logAdminActions"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Log admin actions for audit trail
                                </label>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeSection === 'backup'" class="space-y-6">
                        <div>
                            <h3
                                class="mb-4 text-lg font-semibold text-[#1d1d1d]"
                            >
                                Backup & Maintenance
                            </h3>

                            <div class="space-y-4">
                                <label
                                    class="flex items-center gap-3 rounded-md bg-[#f7f7f7] p-3 text-sm text-[#4d4d4d]"
                                >
                                    <input
                                        id="autoBackup"
                                        v-model="settings.autoBackup"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-[#cfcfcf] text-[#5d3fb0] focus:ring-[#b9a7e6]"
                                    />
                                    Enable automatic backups
                                </label>

                                <div>
                                    <label
                                        for="backupFrequency"
                                        class="mb-1 block text-sm font-medium text-[#4d4d4d]"
                                        >Backup Frequency</label
                                    >
                                    <select
                                        id="backupFrequency"
                                        v-model="settings.backupFrequency"
                                        class="w-full rounded-md border border-[#d7d7d7] bg-[#f7f7f7] px-3 py-2.5 text-sm text-[#1b1b1b] outline-none transition focus:border-[#9d88d8] focus:bg-white"
                                    >
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>

                                <div
                                    class="rounded-md border border-[#e3e3e3] bg-[#f8f8f8] p-4"
                                >
                                    <h4
                                        class="mb-3 text-sm font-semibold text-[#1d1d1d]"
                                    >
                                        System Actions
                                    </h4>
                                    <div class="flex flex-wrap gap-3">
                                        <button
                                            @click="clearCache"
                                            :disabled="loading"
                                            class="rounded-md border border-[#d5d5d5] bg-white px-4 py-2 text-sm font-semibold text-[#4d4d4d] transition hover:bg-[#f5f5f5] disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Clear Cache
                                        </button>
                                        <button
                                            @click="optimizeDatabase"
                                            :disabled="loading"
                                            class="rounded-md border border-[#d5d5d5] bg-white px-4 py-2 text-sm font-semibold text-[#4d4d4d] transition hover:bg-[#f5f5f5] disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Optimize Database
                                        </button>
                                        <button
                                            @click="createBackup"
                                            :disabled="loading"
                                            class="rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2 text-sm font-semibold text-[#4b2d8d] transition hover:bg-[#ece4ff] disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Create Backup Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-6 flex justify-end gap-3 border-t border-[#e8e8e8] pt-4"
                    >
                        <button
                            @click="resetSettings"
                            :disabled="saving"
                            class="rounded-md border border-[#d5d5d5] bg-white px-4 py-2.5 text-sm font-semibold text-[#4f4f4f] transition hover:bg-[#f5f5f5] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Reset
                        </button>
                        <button
                            @click="saveSettings"
                            :disabled="saving"
                            class="rounded-md border border-[#d4c7f4] bg-[#f5f0ff] px-4 py-2.5 text-sm font-semibold text-[#4b2d8d] transition hover:bg-[#ece4ff] disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{ saving ? "Saving..." : "Save Settings" }}
                        </button>
                        <button
                            @click="logout"
                            class="rounded-md border border-[#e5e7eb] bg-white px-4 py-2.5 text-sm font-semibold text-[#dc2626] transition hover:bg-[#fef2f2] hover:text-[#b91c1c]"
                        >
                            <ArrowRightOnRectangleIcon class="h-4 w-4 mr-2" />
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, inject } from "vue";
import {
    CogIcon,
    DocumentTextIcon,
    PhotoIcon,
    ShieldCheckIcon,
    CircleStackIcon,
    AcademicCapIcon,
    ArrowRightOnRectangleIcon
} from "@heroicons/vue/24/outline";

const showNotification = inject("showNotification");
const showLoading = inject("showLoading");
const hideLoading = inject("hideLoading");

const logout = async () => {
    if (!confirm("Are you sure you want to logout?")) return;
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
        // ignore
    }
    localStorage.removeItem("auth_token");
    window.location.href = "/login";
};

const activeSection = ref("general");
const saving = ref(false);
const loading = ref(false);

const sections = [
    { id: "registration", name: "Registration Permissions", icon: AcademicCapIcon },
    { id: "general", name: "General", icon: CogIcon },
    { id: "content", name: "Content", icon: DocumentTextIcon },
    { id: "media", name: "Media", icon: PhotoIcon },
    { id: "security", name: "Security", icon: ShieldCheckIcon },
    { id: "backup", name: "Backup", icon: CircleStackIcon },
];

const imageFormats = ["jpg", "jpeg", "png", "gif", "webp", "svg"];

const settings = reactive({
    // Registration Permissions
    registrationIsOpen: true,
    academicTerm: "Academic Year 2026/2027",
    closedTitle: "Registration Currently Closed",
    closedMessage: "Online registration for the Addis Ababa University Graduate Portal is currently closed by the university administration. Please check back later or contact the Office of the Registrar.",
    reopeningDate: "To be announced by Academic Affairs",
    contactEmail: "registrar@aau.edu.et",
    contactPhone: "+251 11 123 9700",
    announcement: "Welcome to Addis Ababa University Graduate Registration Portal.",

    // General
    siteName: "GC Magazine",
    siteDescription: "Your university magazine",
    adminEmail: "admin@gcmagazine.edu",
    timezone: "UTC",

    // Content
    articlesPerPage: 12,
    autoPublish: false,
    moderateComments: true,
    excerptLength: 30,

    // Media
    maxUploadSize: 10,
    allowedFormats: ["jpg", "jpeg", "png", "gif"],
    imageQuality: 85,
    generateThumbnails: true,

    // Security
    requireAuth: true,
    enableTwoFactor: false,
    sessionTimeout: 120,
    logAdminActions: true,

    // Backup
    autoBackup: true,
    backupFrequency: "weekly",
});

const defaultSettings = { ...settings };

const loadSettings = async () => {
    try {
        const token = localStorage.getItem("auth_token");
        const res = await fetch("/api/admin/settings/registration", {
            headers: {
                "Accept": "application/json",
                ...(token ? { "Authorization": `Bearer ${token}` } : {})
            }
        });
        if (res.ok) {
            const data = await res.json();
            if (data.settings) {
                settings.registrationIsOpen = !!data.settings.is_open;
                if (data.settings.academic_term) settings.academicTerm = data.settings.academic_term;
                if (data.settings.closed_title) settings.closedTitle = data.settings.closed_title;
                if (data.settings.closed_message) settings.closedMessage = data.settings.closed_message;
                if (data.settings.reopening_date) settings.reopeningDate = data.settings.reopening_date;
                if (data.settings.contact_email) settings.contactEmail = data.settings.contact_email;
                if (data.settings.contact_phone) settings.contactPhone = data.settings.contact_phone;
                if (data.settings.announcement) settings.announcement = data.settings.announcement;
            }
        }
        if (showNotification) {
            showNotification("info", "Settings", "Settings loaded successfully");
        }
    } catch (error) {
        if (showNotification) {
            showNotification("error", "Error", "Failed to load settings");
        }
    }
};

const saveSettings = async () => {
    try {
        saving.value = true;
        if (showLoading) showLoading();

        const token = localStorage.getItem("auth_token");
        const payload = {
            is_open: settings.registrationIsOpen,
            status: settings.registrationIsOpen ? "open" : "closed",
            academic_term: settings.academicTerm,
            closed_title: settings.closedTitle,
            closed_message: settings.closedMessage,
            reopening_date: settings.reopeningDate,
            contact_email: settings.contactEmail,
            contact_phone: settings.contactPhone,
            announcement: settings.announcement,
        };

        const res = await fetch("/api/admin/settings/registration", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                ...(token ? { "Authorization": `Bearer ${token}` } : {})
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();
        if (res.ok && data.success) {
            if (showNotification) {
                showNotification("success", "Success", data.message || "Registration settings saved successfully");
            }
        } else {
            throw new Error(data.message || "Failed to save settings");
        }
    } catch (error) {
        if (showNotification) {
            showNotification("error", "Error", error.message || "Failed to save settings");
        }
    } finally {
        saving.value = false;
        if (hideLoading) hideLoading();
    }
};

const resetSettings = () => {
    if (
        confirm(
            "Are you sure you want to reset all settings to default values?",
        )
    ) {
        Object.assign(settings, defaultSettings);
        showNotification("info", "Reset", "Settings reset to default values");
    }
};

const clearCache = async () => {
    try {
        loading.value = true;
        showLoading();

        // Mock cache clearing - replace with actual API call
        await new Promise((resolve) => setTimeout(resolve, 2000));

        showNotification("success", "Success", "Cache cleared successfully");
    } catch (error) {
        showNotification("error", "Error", "Failed to clear cache");
    } finally {
        loading.value = false;
        hideLoading();
    }
};

const optimizeDatabase = async () => {
    try {
        loading.value = true;
        showLoading();

        // Mock database optimization - replace with actual API call
        await new Promise((resolve) => setTimeout(resolve, 3000));

        showNotification(
            "success",
            "Success",
            "Database optimized successfully",
        );
    } catch (error) {
        showNotification("error", "Error", "Failed to optimize database");
    } finally {
        loading.value = false;
        hideLoading();
    }
};

const createBackup = async () => {
    try {
        loading.value = true;
        showLoading();

        // Mock backup creation - replace with actual API call
        await new Promise((resolve) => setTimeout(resolve, 5000));

        showNotification("success", "Success", "Backup created successfully");
    } catch (error) {
        showNotification("error", "Error", "Failed to create backup");
    } finally {
        loading.value = false;
        hideLoading();
    }
};

onMounted(() => {
    loadSettings();
});
</script>
