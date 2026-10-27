<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Login - {{ config('app.name', 'GC Magazine') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#f6d98c] text-sm font-black text-slate-900 shadow-lg">
                    AU
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Addis Ababa University</h1>
                <p class="text-gray-500 mt-2 text-sm uppercase tracking-[0.2em]">Graduate Portal · Admin</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm" method="POST" action="/login">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="admin@gcmagazine.edu"
                    >
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Password"
                    >
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                            <button
                                type="submit"
                                class="w-full bg-slate-900 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
                                id="submitBtn"
                            >
                                Sign In
                            </button>

                            <a href="/" class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-900 hover:underline">
                                ← Back to Magazine
                            </a>
                        </div>
                    </form>

            <!-- Test Credentials -->
            <div class="mt-6 p-4 bg-amber-50 border border-amber-100 rounded-lg">
                <p class="text-sm text-amber-800 font-medium mb-2">Test Credentials:</p>
                <div class="text-xs text-amber-700 space-y-1">
                    <div>Admin: <span class="font-mono">admin@gcmagazine.edu</span> / <span class="font-mono">password</span></div>
                    <div>Editor: <span class="font-mono">editor@gcmagazine.edu</span> / <span class="font-mono">password</span></div>
                </div>
            </div>

            <!-- Error Messages -->
            <div id="errorMessage" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                <p class="text-sm text-red-600"></p>
            </div>

            <!-- Success Messages -->
            <div id="successMessage" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                <p class="text-sm text-green-600"></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            // Hide previous messages
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing In...';

            try {
                const formData = new FormData(this);

                const response = await fetch('/api/login', {
                    method: 'POST',
                    body: JSON.stringify(Object.fromEntries(formData)),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    successMessage.querySelector('p').textContent = data.message;
                    successMessage.classList.remove('hidden');
                    
                    // Store token if provided
                    if (data.token) {
                        localStorage.setItem('auth_token', data.token);
                    }
                    
                    // Redirect after short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/admin';
                    }, 1000);
                } else {
                    errorMessage.querySelector('p').textContent = data.message;
                    errorMessage.classList.remove('hidden');
                }
            } catch (error) {
                errorMessage.querySelector('p').textContent = 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Sign In';
            }
        });
    </script>
</body>
</html>