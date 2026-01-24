@extends('layouts.welcome')

@section('title', 'Sign Up')

@section('content')

<section class="min-h-screen flex items-center justify-center px-4 py-2">
    <div class="w-full max-w-6xl bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

        <div class="hidden lg:block relative">
            <img src="{{ asset('images/signup-bg.png') }}" alt="Signup Illustration" class="w-full h-full object-cover" />
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            </div>
        </div>

        <div class="px-8 sm:px-12 py-12 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-800">Sign Up</h2>
            <p class="text-sm text-gray-500 mt-4">Please fill in the information below</p>

            <form id="registerForm" method="POST" action="{{ url('/register') }}" class="mt-8 space-y-2">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="mt-1 w-full rounded-lg border @error('first_name') border-red-500 @else border-gray-300 @enderror px-3 py-2 focus:ring focus:ring-indigo-200 transition">
                        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="mt-1 w-full rounded-lg border @error('last_name') border-red-500 @else border-gray-300 @enderror px-3 py-2 focus:ring focus:ring-indigo-200 transition">
                        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 w-full rounded-lg border @error('email') border-red-500 @else border-gray-300 @enderror px-3 py-2 focus:ring focus:ring-indigo-200 transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="mt-1 w-full rounded-lg border @error('phone') border-red-500 @else border-gray-300 @enderror px-3 py-2 focus:ring focus:ring-indigo-200 transition">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password"
                        class="mt-1 w-full rounded-lg border @error('password') border-red-500 @else border-gray-300 @enderror px-3 py-2 focus:ring focus:ring-indigo-200 transition">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring focus:ring-indigo-200 transition">
                </div>

                <div class="flex items-start gap-2 text-sm text-gray-600">
                    <input type="checkbox" required class="mt-1 cursor-pointer">
                    <span>
                        I agree to the <a href="#" class="text-indigo-600 hover:underline">Terms</a> & Privacy Policy
                    </span>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    
                    <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <span id="btnText">Create Account</span>
                </button>

                <p class="text-sm text-center text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 font-medium hover:underline">Login</a>
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
        // 1. STOP Reload Halaman
        e.preventDefault();

        // 2. Tampilkan Loading UI
        btn.disabled = true;
        loadingIcon.classList.remove('hidden');
        btnText.innerText = 'Processing...';

        // Bersihkan pesan error sebelumnya (jika ada)
        document.querySelectorAll('.error-msg').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

        // 3. Siapkan Data
        const formData = new FormData(form);

        try {
            // 4. Kirim Request via FETCH (AJAX)
            const response = await fetch("{{ url('/register') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json' // Penting agar Laravel tahu ini request AJAX
                },
                body: formData
            });

            const result = await response.json();

            // 5. Cek Hasil
            if (response.ok) {
                // --- SUKSES ---
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: result.message,
                    timer: 2000 
                }).then(() => {
                    // Redirect manual via JS
                    window.location.href = result.redirect_url;
                });

            } else {
                // --- ERROR VALIDASI (422) ---
                btn.disabled = false;
                loadingIcon.classList.add('hidden');
                btnText.innerText = 'Create Account';

                if (result.errors) {
                    // Loop error dan tampilkan di bawah input masing-masing
                    for (const [key, messages] of Object.entries(result.errors)) {
                        const input = document.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.classList.add('border-red-500');
                            const errorSmall = document.createElement('p');
                            errorSmall.className = 'text-red-500 text-xs mt-1 error-msg';
                            errorSmall.innerText = messages[0];
                            input.parentNode.appendChild(errorSmall);
                        }
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silakan perbaiki input yang merah.',
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server.' });
                }
            }

        } catch (error) {
            // --- ERROR JARINGAN / SERVER ---
            console.error(error);
            btn.disabled = false;
            loadingIcon.classList.add('hidden');
            btnText.innerText = 'Create Account';
            Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server.' });
        }
    });
</script>
@endsection