<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WIMIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-green-50 overflow-hidden relative">

    {{-- Background Blur --}}
    <div class="absolute top-[-100px] left-[-100px] w-[350px] h-[350px] bg-green-200/40 rounded-full blur-3xl"></div>

    <div class="absolute bottom-[-120px] right-[-120px] w-[420px] h-[420px] bg-emerald-100/50 rounded-full blur-3xl"></div>

    {{-- Navbar --}}
    <header class="relative z-10">

        <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-black tracking-tight text-gray-900">
                    WIMIS
                </h1>

                <p class="text-sm text-gray-500">
                    Warsi Management Information System
                </p>
            </div>

            <div class="flex items-center gap-3">

                @auth

                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2.5 rounded-2xl bg-green-800 hover:bg-green-900 transition-all duration-300 text-white text-sm font-semibold shadow-lg shadow-green-900/20">
                        Dashboard
                    </a>

                @else

                    <a href="{{ route('login') }}"
                       class="px-5 py-2.5 rounded-2xl border border-gray-300 bg-white/70 backdrop-blur hover:border-green-700 hover:text-green-800 transition-all duration-300 text-sm font-medium">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 rounded-2xl bg-green-800 hover:bg-green-900 transition-all duration-300 text-white text-sm font-semibold shadow-lg shadow-green-900/20">
                        Register
                    </a>

                @endauth

            </div>

        </div>

    </header>

    {{-- Hero --}}
    <main class="relative z-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="min-h-[75vh] flex flex-col items-center justify-center text-center">

                <div class="bg-white/60 backdrop-blur-xl border border-white rounded-full px-5 py-2 text-sm text-green-800 font-medium shadow-sm mb-7">
                    Enterprise Internal Platform
                </div>

                <h1 class="text-6xl md:text-7xl font-black tracking-tight text-gray-900 leading-none mb-6">
                    WIMIS
                </h1>

                <p class="max-w-2xl text-lg md:text-xl leading-relaxed text-gray-600 mb-10">
                    Warsi Management Information System
                </p>

                @guest
                <div class="flex items-center gap-4">

                    <a href="{{ route('login') }}"
                       class="px-7 py-3.5 rounded-2xl bg-green-800 hover:bg-green-900 transition-all duration-300 text-white font-semibold shadow-xl shadow-green-900/20">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-7 py-3.5 rounded-2xl bg-white/70 backdrop-blur border border-gray-300 hover:border-green-700 hover:text-green-800 transition-all duration-300 font-semibold">
                        Register
                    </a>

                </div>
                @endguest

            </div>

        </div>

    </main>

    {{-- Footer --}}
    <footer class="relative z-10">

        <div class="max-w-7xl mx-auto px-6 py-6">

            <p class="text-sm text-gray-500 text-center">
                © {{ date('Y') }} WIMIS — Warsi Management Information System
            </p>

        </div>

    </footer>

</body>
</html>