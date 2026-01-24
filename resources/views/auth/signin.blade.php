@extends('layouts.welcome')

@section('title', 'Login')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="min-h-screen flex items-center justify-center bg-gray-200 px-4">
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

        <div class="hidden lg:block relative">
            <img src="{{ asset('images/login-bg.png') }}" alt="Login Illustration" class="w-full h-full object-cover" />
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            </div>
        </div>

        <div class="flex flex-col justify-center px-8 sm:px-12 py-12">
            <div class="text-center">
                <h1 class="text-sm font-semibold text-gray-500 tracking-widest">SIMBA-IT</h1>
                <h2 class="text-3xl font-bold text-gray-800 mt-3">Login</h2>
                <p class="text-sm text-gray-500 mt-2">Welcome back, please login to your account</p>
            </div>

            <form id="loginForm" method="POST" action="{{ route('login.process') }}" class="mt-10 space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" placeholder="you@example.com"
                        class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" placeholder="••••••••"
                        class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                        Remember me
                    </label>
                    <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white py-2.5 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <span id="btnText">Login</span>
                </button>

                <p class="text-center text-sm text-gray-500">
                    Don’t have an account?
                    <a href="{{ url('/register') }}" class="text-indigo-600 hover:underline font-medium">Sign Up</a>
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
        e.preventDefault(); // Stop reload

        // UI Loading State
        submitBtn.disabled = true;
        loadingIcon.classList.remove('hidden');
        btnText.innerText = 'Logging in...';

        // Bersihkan style error lama
        document.querySelectorAll('input').forEach(el => el.classList.remove('border-red-500'));

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
                // --- LOGIN BERHASIL ---
                Swal.fire({
                    icon: 'success',
                    title: 'Welcome Back!',
                    text: result.message,
                    timer: 2000
                }).then(() => {
                    window.location.href = result.redirect_url;
                });

            } else {
                // --- LOGIN GAGAL ---
                submitBtn.disabled = false;
                loadingIcon.classList.add('hidden');
                btnText.innerText = 'Login';

                // Jika error 422 (Validasi input kosong/format salah)
                if (result.errors) {
                    // Merahkan border input yang salah
                    for (const field in result.errors) {
                        const input = document.querySelector(`[name="${field}"]`);
                        if(input) input.classList.add('border-red-500');
                    }
                    Swal.fire({
                        icon: 'warning',
                        title: 'Periksa Input',
                        text: 'Pastikan email dan password sudah diisi dengan benar.',
                    });
                } 
                // Jika error 401 (Password salah / User tidak ditemukan)
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: result.message || 'Email atau password salah.',
                    });
                }
            }

        } catch (error) {
            console.error('Error:', error);
            submitBtn.disabled = false;
            loadingIcon.classList.add('hidden');
            btnText.innerText = 'Login';
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Terjadi kesalahan koneksi, coba lagi nanti.',
            });
        }
    });
</script>
@endsection