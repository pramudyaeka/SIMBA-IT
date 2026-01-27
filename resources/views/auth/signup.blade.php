@extends('layouts.welcome')

@section('title', 'Sign Up')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="min-h-screen flex items-center justify-center px-4 py-6 bg-slate-50 font-jakarta">
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-5">

        <div class="hidden lg:block lg:col-span-2 relative bg-indigo-600">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-[-20%] right-[-20%] w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-72 h-72 bg-violet-400 rounded-full blur-3xl"></div>
            </div>
            
            <div class="relative z-10 h-full flex flex-col justify-center p-12 text-white">
                <h2 class="text-4xl font-bold mb-4">Join SIMBA IT Today.</h2>
                <p class="text-indigo-100 text-lg leading-relaxed">Start managing your inventory smarter, faster, and more efficiently.</p>
                
                <div class="mt-12 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span>Real-time Stock Tracking</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span>Automated Reporting</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span>Secure Role Management</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 px-8 sm:px-12 py-12 flex flex-col justify-center">
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-800">Create Account</h2>
                <p class="text-slate-500 mt-2">Please fill in your details to get started.</p>
            </div>

            <form id="registerForm" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">First Name</label>
                        <input type="text" name="first_name" placeholder="John"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" placeholder="Doe"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" placeholder="john@company.com"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" placeholder="081234567890"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Job Position / Role</label>
                    <div class="relative">
                        <select name="role" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer text-slate-700">
                            <option value="" disabled selected>Select your role...</option>
                            <option value="Staff">Staff</option>
                            <option value="Admin Gudang">Admin Gudang</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="IT Support">IT Support</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Full Address</label>
                    <textarea name="address" rows="2" placeholder="Street name, building, unit no..."
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <div class="flex items-start gap-3 mt-2">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" class="size-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                    </div>
                    <label for="terms" class="text-sm text-slate-500 cursor-pointer select-none">
                        I agree to the <a href="#" class="text-indigo-600 font-medium hover:underline">Terms of Service</a> and <a href="#" class="text-indigo-600 font-medium hover:underline">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 hover:shadow-indigo-300 disabled:opacity-70 disabled:cursor-not-allowed mt-4">
                    
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <span id="btnText">Create Account</span>
                </button>

                <p class="text-center text-sm text-slate-500 mt-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</section>

<script>
    const form = document.getElementById('registerForm');
    const btn = document.getElementById('submitBtn');
    const loadingIcon = document.getElementById('loadingIcon');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // UI Loading State
        btn.disabled = true;
        loadingIcon.classList.remove('hidden');
        btnText.innerText = 'Creating Account...';

        // Clear previous error styles
        document.querySelectorAll('.error-msg').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

        const formData = new FormData(form);

        try {
            const response = await fetch("{{ url('/register') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Account Created!',
                    text: result.message || 'You can now login.',
                    confirmButtonColor: '#4F46E5',
                    timer: 2000
                }).then(() => {
                    window.location.href = result.redirect_url;
                });
            } else {
                // Error Validation
                btn.disabled = false;
                loadingIcon.classList.add('hidden');
                btnText.innerText = 'Create Account';

                if (result.errors) {
                    for (const [key, messages] of Object.entries(result.errors)) {
                        const input = document.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-200');
                            
                            // Create Error Text Element
                            const errorSmall = document.createElement('p');
                            errorSmall.className = 'text-red-500 text-xs mt-1 ml-1 font-medium error-msg';
                            errorSmall.innerText = messages[0];
                            
                            // Insert after input's parent div if it's inside a relative container (like select/password)
                            // or directly after input
                            if(input.parentNode.classList.contains('relative')) {
                                input.parentNode.parentNode.appendChild(errorSmall);
                            } else {
                                input.parentNode.appendChild(errorSmall);
                            }
                        }
                    }
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Check your input',
                        text: 'Please fix the highlighted errors.',
                        confirmButtonColor: '#4F46E5'
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: result.message || 'Server error occurred.' });
                }
            }

        } catch (error) {
            console.error(error);
            btn.disabled = false;
            loadingIcon.classList.add('hidden');
            btnText.innerText = 'Create Account';
            Swal.fire({ icon: 'error', title: 'Connection Error', text: 'Please check your internet connection.' });
        }
    });
</script>
@endsection