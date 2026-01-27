@extends('layouts.welcome')

@section('title', 'Sign In to SIMBA IT')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="min-h-screen flex items-center justify-center bg-slate-50 p-4 sm:p-6 lg:p-8 font-jakarta">
    
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-5 min-h-[600px]">

        <div class="hidden lg:flex lg:col-span-2 relative bg-indigo-600 flex-col justify-between p-12 text-white overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-[-20%] right-[-20%] w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-72 h-72 bg-violet-500 rounded-full blur-3xl opacity-50"></div>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-8">
                    <div class="size-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">SIMBA IT</span>
                </div>
                <h2 class="text-4xl font-bold leading-tight mb-4">Manage Your Inventory Efficiently.</h2>
                <p class="text-indigo-100 text-lg">Streamline your stock tracking and reporting with our modern platform.</p>
            </div>

            <div class="relative z-10 text-sm text-indigo-200">
                © {{ date('Y') }} SIMBA IT System. All rights reserved.
            </div>
        </div>

        <div class="lg:col-span-3 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <div class="size-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-slate-800">SIMBA IT</span>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Welcome Back!</h3>
                <p class="text-slate-500">Please sign in to access your dashboard.</p>
            </div>

            <form id="loginForm" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" placeholder="name@company.com" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:underline">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" placeholder="••••••••" required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-slate-600 cursor-pointer select-none">Remember me</label>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full flex justify-center items-center py-3 px-4 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/30 transition-all font-semibold shadow-lg shadow-indigo-200 hover:shadow-indigo-300 disabled:opacity-70 disabled:cursor-not-allowed">
                    
                    <svg id="loadingIcon" class="hidden animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <span id="btnText">Sign In</span>
                </button>

                <p class="text-center text-sm text-slate-500 mt-6">
                    Don’t have an account yet? 
                    <a href="{{ url('/register') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 hover:underline transition">Create Account</a>
                </p>
            </form>
        </div>
    </div>
</section>

<script>
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingIcon = document.getElementById('loadingIcon');
    const btnText = document.getElementById('btnText');

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        // UI Loading State
        submitBtn.disabled = true;
        loadingIcon.classList.remove('hidden');
        btnText.innerText = 'Signing In...';

        // Clear previous error styles
        document.querySelectorAll('input').forEach(el => el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-200'));

        const formData = new FormData(loginForm);

        try {
            const response = await fetch("{{ route('login.process') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                // Success
                Swal.fire({
                    icon: 'success',
                    title: 'Welcome Back!',
                    text: 'Redirecting to dashboard...',
                    timer: 1500,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,0,0.4)`
                }).then(() => {
                    window.location.href = result.redirect_url;
                });

            } else {
                // Error Handling
                submitBtn.disabled = false;
                loadingIcon.classList.add('hidden');
                btnText.innerText = 'Sign In';

                // Validation Errors (422)
                if (result.errors) {
                    for (const field in result.errors) {
                        const input = document.querySelector(`[name="${field}"]`);
                        if(input) {
                            input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
                            // Optional: Shake animation or show text below input
                        }
                    }
                    Swal.fire({
                        icon: 'warning',
                        title: 'Check your input',
                        text: 'Please verify your email and password.',
                        confirmButtonColor: '#4F46E5'
                    });
                } 
                // Auth Error (401)
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Authentication Failed',
                        text: result.message || 'Invalid credentials provided.',
                        confirmButtonColor: '#E11D48'
                    });
                }
            }

        } catch (error) {
            console.error('Error:', error);
            submitBtn.disabled = false;
            loadingIcon.classList.add('hidden');
            btnText.innerText = 'Sign In';
            Swal.fire({
                icon: 'error',
                title: 'Connection Error',
                text: 'Something went wrong. Please try again later.',
            });
        }
    });
</script>
@endsection