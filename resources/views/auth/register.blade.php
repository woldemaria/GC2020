<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Registration - {{ config('app.name', 'Addis Ababa University Graduate Portal') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 min-h-screen text-slate-800 flex flex-col justify-between p-4 sm:p-6">
    <!-- Top Nav / Back Link -->
    <header class="w-full max-w-4xl mx-auto flex items-center justify-between py-4">
        <a href="/" class="flex items-center gap-3 text-white/90 hover:text-white transition group">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#f6d98c] text-[12px] font-black text-slate-900 shadow-md group-hover:scale-105 transition-transform">
                AU
            </div>
            <div>
                <div class="text-sm font-bold tracking-wide">Addis Ababa University</div>
                <div class="text-[10px] uppercase tracking-[0.2em] text-[#f6d98c]">Graduate Portal</div>
            </div>
        </a>

        <div class="flex items-center gap-3">
            <a href="/login" class="text-xs font-semibold uppercase tracking-wider text-white/80 hover:text-white px-3 py-1.5 rounded-full border border-white/20 hover:border-white/40 transition">
                Sign In
            </a>
            <a href="/verify-certificate" class="text-xs font-semibold uppercase tracking-wider text-slate-900 bg-[#f6d98c] hover:bg-amber-300 px-3.5 py-1.5 rounded-full shadow-sm transition">
                Verify Certificate
            </a>
        </div>
    </header>

    <!-- Main Registration Container -->
    <main class="w-full max-w-lg mx-auto my-auto">
        <div class="bg-white rounded-3xl shadow-2xl border border-white/20 p-6 sm:p-8 overflow-hidden backdrop-blur-sm relative">
            
            <!-- University Header Banner -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 font-black text-base shadow-sm mb-3">
                    አአዩ
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Student Registration</h1>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mt-1 font-semibold">
                    {{ $settings['academic_term'] ?? 'Academic Year 2026/2027' }}
                </p>

                <!-- Dynamic Status Pill -->
                <div id="statusPill" class="mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold {{ ($settings['is_open'] ?? true) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    <span class="h-2 w-2 rounded-full {{ ($settings['is_open'] ?? true) ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                    <span id="statusPillText">{{ ($settings['is_open'] ?? true) ? 'Registration Open' : 'Registration Closed by Administration' }}</span>
                </div>
            </div>

            <!-- CLOSED NOTICE CARD (shown when registration is closed) -->
            <div id="closedNoticeCard" class="{{ ($settings['is_open'] ?? true) ? 'hidden' : '' }} space-y-5">
                <div class="rounded-2xl border border-rose-200 bg-gradient-to-b from-rose-50/80 to-white p-5 text-center shadow-sm">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 text-rose-600 mb-3">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>

                    <h2 id="closedTitle" class="text-lg font-bold text-slate-900">
                        {{ $settings['closed_title'] ?? 'Registration Currently Closed' }}
                    </h2>
                    
                    <p id="closedMessage" class="mt-2 text-sm text-slate-600 leading-relaxed">
                        {{ $settings['closed_message'] ?? 'Online registration for the Addis Ababa University Graduate Portal is currently closed by the university administration. Please check back later or contact the Office of the Registrar.' }}
                    </p>

                    @if(!empty($settings['reopening_date']))
                    <div class="mt-4 inline-flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-800 border border-amber-200">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Expected Reopening: <strong id="reopeningDate">{{ $settings['reopening_date'] }}</strong></span>
                    </div>
                    @endif
                </div>

                <!-- Contact & Support Info -->
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 text-xs text-slate-600 space-y-2">
                    <div class="font-bold uppercase tracking-wider text-slate-800">Need Assistance?</div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Registrar: <a href="mailto:{{ $settings['contact_email'] ?? 'registrar@aau.edu.et' }}" class="text-blue-600 font-semibold hover:underline">{{ $settings['contact_email'] ?? 'registrar@aau.edu.et' }}</a></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>Phone: <span class="font-semibold text-slate-800">{{ $settings['contact_phone'] ?? '+251 11 123 9700' }}</span></span>
                    </div>
                </div>

                <!-- Alternative Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <a href="/login" class="flex items-center justify-center gap-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white py-3 px-4 text-xs font-bold transition shadow-sm">
                        <span>Sign In to Existing Account</span>
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="/verify-certificate" class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 py-3 px-4 text-xs font-bold transition">
                        <span>Verify Certificate</span>
                    </a>
                </div>
            </div>

            <!-- REGISTRATION FORM (shown when registration is open) -->
            <form id="registerForm" class="{{ ($settings['is_open'] ?? true) ? '' : 'hidden' }} space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Full Name <span class="text-rose-500">*</span>
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        required
                        autofocus
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-1 focus:ring-slate-900"
                        placeholder="Abebe Kebede"
                    >
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Email Address <span class="text-rose-500">*</span>
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-1 focus:ring-slate-900"
                        placeholder="student@aau.edu.et"
                    >
                </div>

                <!-- Department / Program -->
                <div>
                    <label for="department" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Department / School
                    </label>
                    <select
                        id="department"
                        name="department"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-1 focus:ring-slate-900"
                    >
                        <option value="Computer Science & IT">Computer Science & IT</option>
                        <option value="Engineering">Engineering & Technology</option>
                        <option value="Business & Management">Business & Economics</option>
                        <option value="Medicine & Health Sciences">Health Sciences</option>
                        <option value="Law & Governance">School of Law</option>
                        <option value="Social Sciences">Social Sciences & Humanities</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Password <span class="text-rose-500">*</span>
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            minlength="6"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-1 focus:ring-slate-900"
                            placeholder="Min. 6 chars"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Confirm <span class="text-rose-500">*</span>
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            minlength="6"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-900 focus:bg-white focus:ring-1 focus:ring-slate-900"
                            placeholder="Confirm password"
                        >
                    </div>
                </div>

                <!-- Terms Notice -->
                <p class="text-[11px] text-slate-500 leading-normal">
                    By submitting registration, you agree to Addis Ababa University's portal policies and student data protection standards.
                </p>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
                        id="submitBtn"
                    >
                        Complete Registration
                    </button>

                    <div class="flex items-center justify-between mt-4 text-xs text-slate-500">
                        <span>Already registered? <a href="/login" class="text-slate-900 font-bold hover:underline">Sign In</a></span>
                        <a href="/apply" class="hover:underline">Degree Application</a>
                    </div>
                </div>
            </form>

            <!-- Error Messages Container -->
            <div id="errorMessage" class="hidden mt-4 p-4 bg-rose-50 border border-rose-200 rounded-xl">
                <div class="flex items-start gap-2">
                    <svg class="h-4 w-4 text-rose-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs text-rose-700 font-medium"></p>
                </div>
            </div>

            <!-- Success Messages Container -->
            <div id="successMessage" class="hidden mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                <div class="flex items-start gap-2">
                    <svg class="h-4 w-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-xs text-emerald-800 font-medium"></p>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-4xl mx-auto text-center py-4 text-xs text-white/50">
        &copy; {{ date('Y') }} Addis Ababa University. Office of Academic Registrar · All Rights Reserved.
    </footer>

    <script>
        // Check dynamic status from server on mount
        async function checkLiveStatus() {
            try {
                const res = await fetch('/api/v1/registration-status');
                if (res.ok) {
                    const data = await res.json();
                    applyRegistrationStatus(data.is_open, data.settings);
                }
            } catch (e) {
                console.warn('Could not fetch dynamic registration status', e);
            }
        }

        function applyRegistrationStatus(isOpen, settings) {
            const form = document.getElementById('registerForm');
            const notice = document.getElementById('closedNoticeCard');
            const pill = document.getElementById('statusPill');
            const pillText = document.getElementById('statusPillText');

            if (isOpen) {
                form.classList.remove('hidden');
                notice.classList.add('hidden');
                pill.className = 'mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
                pill.querySelector('span:first-child').className = 'h-2 w-2 rounded-full bg-emerald-500 animate-pulse';
                pillText.textContent = 'Registration Open';
            } else {
                form.classList.add('hidden');
                notice.classList.remove('hidden');
                pill.className = 'mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200';
                pill.querySelector('span:first-child').className = 'h-2 w-2 rounded-full bg-rose-500';
                pillText.textContent = 'Registration Closed by Administration';

                if (settings) {
                    if (settings.closed_title) document.getElementById('closedTitle').textContent = settings.closed_title;
                    if (settings.closed_message) document.getElementById('closedMessage').textContent = settings.closed_message;
                    if (settings.reopening_date && document.getElementById('reopeningDate')) {
                        document.getElementById('reopeningDate').textContent = settings.reopening_date;
                    }
                }
            }
        }

        // Handle Registration Form Submission
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');

            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing Registration...';

            try {
                const formData = new FormData(this);
                const payload = Object.fromEntries(formData);

                const response = await fetch('/api/register', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (response.status === 403 && data.is_closed) {
                    // Registration was closed by admin
                    applyRegistrationStatus(false, data.settings);
                    return;
                }

                if (response.ok && data.success) {
                    successMessage.querySelector('p').textContent = data.message || 'Registration successful! Redirecting to portal...';
                    successMessage.classList.remove('hidden');

                    if (data.token) {
                        localStorage.setItem('auth_token', data.token);
                    }

                    setTimeout(() => {
                        window.location.href = data.redirect || '/';
                    }, 1200);
                } else {
                    const msg = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Registration failed.');
                    errorMessage.querySelector('p').textContent = msg;
                    errorMessage.classList.remove('hidden');
                }
            } catch (err) {
                errorMessage.querySelector('p').textContent = 'A connection error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Complete Registration';
            }
        });

        // Run live check
        checkLiveStatus();
    </script>
</body>
</html>
