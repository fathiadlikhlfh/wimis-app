<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-green-50 to-emerald-100 px-4">

        <div class="w-full max-w-md">

            <!-- Brand -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-black text-gray-800 tracking-tight">
                    WIMIS
                </h1>

                <p class="text-gray-500 mt-2 text-sm">
                    Create your account
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white/80 backdrop-blur-xl border border-white shadow-2xl rounded-3xl p-8">

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Full Name
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 transition"
                        >

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="Masukkan email"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 transition"
                        >

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Masukkan password"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 transition"
                        >

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">
                            Confirm Password
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Konfirmasi password"
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 transition"
                        >

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-700 to-emerald-600 hover:from-green-800 hover:to-emerald-700 text-white font-bold py-3 rounded-2xl transition duration-300 shadow-lg hover:shadow-xl"
                    >
                        Create Account
                    </button>

                    <!-- Login -->
                    <div class="text-center text-sm text-gray-500 pt-2">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                           class="text-green-700 font-semibold hover:text-green-900">
                            Login
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} WIMIS — Warsi Information Management System
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>