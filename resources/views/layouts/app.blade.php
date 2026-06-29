<!DOCTYPE html>
<html lang="id">
<!-- <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head> -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased overflow-hidden">

@php
    $currentUrl = url()->current();
@endphp

<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

<!-- Mobile Overlay -->
<div 
    x-show="sidebarOpen"
    x-transition.opacity
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/40 z-40 lg:hidden">
</div>

<!-- Sidebar WIMIS -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static z-50 w-72 h-screen bg-gradient-to-b from-white to-gray-50 border-r border-gray-200 p-4 overflow-y-auto shadow-2xl transition-all duration-300 transform lg:translate-x-0"
        x-data="{ 
            search: '',
            menuData: [

                // =========================================================
                // BERANDA
                // =========================================================
                {
                    name: 'Beranda',
                    children: [

                        {
                            name: 'Home',
                            url: '{{ route('dashboard') }}'
                        },

                        {
                            name: 'Vacancy',
                            url: '{{ route('vacancy') }}'
                        }

                    ]
                },

                // =========================================================
                // MY DATA
                // =========================================================
                {
                    name: 'My Data',
                    children: [

                        {
                            name: 'Usulan B1',
                            url: '{{ route('mydata.usulan.b1') }}'
                        },

                        {
                            name: 'Timesheet B3',
                            url: '{{ route('mydata.timesheet') }}'
                        }

                    ]
                },

                // =========================================================
                // FORMULIR
                // =========================================================
                {
                    name: 'Formulir',
                    children: [

                        {
                            name: 'Usulan B1',
                            url: '{{ route('formulir.b1') }}'
                        },

                        {
                            name: 'Timesheet B3',
                            url: '{{ route('formulir.timesheet') }}'
                        }

                    ]
                },

                // =========================================================
                // APPROVAL
                // =========================================================
                @if(auth()->user()->role === 'coordinator')
                {
                    name: 'Approval',
                    children: [

                        {
                            name: 'Usulan B1',
                            url: '{{ route('approval.usulan') }}'
                        },

                        {
                            name: 'Timesheet B3',
                            url: '{{ route('approval.timesheet') }}'
                        }

                    ]
                },
                @endif

                // =========================================================
                // DATA KM
                // =========================================================
                {
                    name: 'DataKM',
                    children: [

                        {
                            name: 'Semua Dokumen',
                            url: '{{ route('datakm.index') }}'
                        },

                        {
                            name: 'Dokumen Riset',
                            url: '{{ route('datakm.index', ['kategori' => 'Riset']) }}'
                        },

                        {
                            name: 'Laporan',
                            url: '{{ route('datakm.index', ['kategori' => 'Laporan']) }}'
                        },

                        {
                            name: '+ Tambah Data',
                            url: '{{ route('datakm.create') }}'
                        }

                    ]
                }

            ],

            get results() {
                let flat = [];
                const search = (items, path = '') => {
                    items.forEach(i => {
                        let p = path ? path + ' > ' + i.name : i.name;

                        if (i.children) search(i.children, p);

                        else if (
                            i.name.toLowerCase().includes(this.search.toLowerCase())
                        ) {
                            flat.push({
                                name: i.name,
                                path: p,
                                url: i.url || '#'
                            });
                        }
                    });
                };

                if (this.search.length < 2) return [];

                search(this.menuData);

                return flat;
            }
        }">

        <a href="{{ route('dashboard') }}"
        class="flex items-center gap-4 px-4 py-4 mb-6 rounded-3xl bg-gradient-to-r from-green-700 via-green-600 to-emerald-500 text-white shadow-xl hover:scale-[1.02] transition-all duration-300">

            <!-- Logo -->
            <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center overflow-hidden border border-white/20 shadow-inner">

                <img 
                    src="{{ asset('images/Logo_KKI-WARSI.jpg') }}" 
                    alt="Logo WARSI"
                    class="w-10 h-10 object-contain">

            </div>

            <!-- Text -->
            <div class="leading-tight">
                <h1 class="text-xl font-extrabold tracking-wide">
                    WIMIS
                </h1>

                <p class="text-[11px] text-green-100">
                    WARSI System
                </p>
            </div>

        </a>

        <!-- Search -->
        <div class="relative mb-6">

            <input 
                type="text"
                x-model="search"
                placeholder="Cari menu..."
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white shadow-sm text-sm focus:ring-2 focus:ring-green-500 outline-none transition-all">

            <!-- Result -->
            <div 
                x-show="results.length > 0"
                class="absolute z-50 mt-2 w-full bg-white border rounded-2xl shadow-2xl overflow-hidden max-h-72 overflow-y-auto">

                <template x-for="res in results" :key="res.path">

                    <a :href="res.url"
                    class="block px-4 py-3 hover:bg-green-50 border-b transition">

                        <div class="font-semibold text-sm text-green-800"
                            x-text="res.name">
                        </div>

                        <div class="text-[11px] text-gray-500 mt-1"
                            x-text="res.path">
                        </div>

                    </a>

                </template>
            </div>
        </div>

        <!-- Menu -->
        <nav class="space-y-2">

            <template x-for="menu in menuData" :key="menu.name">

                <div x-data="{ open: false }"
                    class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    <!-- Main Menu -->
                    <button 
                        @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-3 hover:bg-green-50 transition-all">

                        <span class="font-semibold text-sm text-gray-700"
                            x-text="menu.name">
                        </span>

                        <span class="text-green-700 text-xs font-bold"
                            x-text="open ? '−' : '+'">
                        </span>
                    </button>

                    <!-- Children -->
                    <div x-show="open"
                        x-collapse
                        class="px-3 pb-3">

                        <template x-for="sub in (menu.children || [])" :key="sub.name">

                            <div x-data="{ subOpen: false }" class="mb-1">

                                <!-- Sub with children -->
                                <template x-if="sub.children">

                                    <button
                                        @click.stop="subOpen = !subOpen"
                                        class="w-full flex justify-between items-center px-3 py-2 rounded-xl hover:bg-gray-50 transition">

                                        <span class="text-sm text-gray-600"
                                            x-text="sub.name">
                                        </span>

                                        <span class="text-[10px] text-gray-400"
                                            x-text="subOpen ? '−' : '+'">
                                        </span>

                                    </button>

                                </template>

                                <!-- Sub no children -->
                                <template x-if="!sub.children">

                                    <a 
                                        :href="sub.url || '#'"
                                        class="block px-3 py-2 rounded-xl text-sm transition font-medium"
                                        :class="{
                                            'bg-green-100 text-green-700 border border-green-200':
                                                sub.url === '{{ $currentUrl }}',

                                            'text-gray-600 hover:bg-green-50 hover:text-green-700':
                                                sub.url !== '{{ $currentUrl }}'
                                        }"
                                        x-text="sub.name">
                                    </a>

                                </template>

                                <!-- Child -->
                                <div x-show="subOpen"
                                    x-collapse
                                    class="pl-4 mt-1 space-y-1">

                                    <template x-for="child in (sub.children || [])" :key="child.name">

                                        <a 
                                            :href="child.url || '#'"
                                            class="block px-3 py-2 rounded-lg text-[12px] transition font-medium"
                                            :class="{
                                                'bg-green-100 text-green-700 border border-green-200':
                                                    child.url === '{{ $currentUrl }}',

                                                'text-gray-500 hover:bg-green-50 hover:text-green-700':
                                                    child.url !== '{{ $currentUrl }}'
                                            }"
                                            x-text="child.name">
                                        </a>                                    

                                    </template>

                                </div>

                            </div>

                        </template>

                    </div>

                </div>

            </template>

        </nav>

        <!-- Logout -->
        <form method="POST"
            action="{{ route('logout') }}"
            class="mt-8">

            @csrf

            <button type="submit"
                class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-3 rounded-2xl transition-all duration-300 border border-red-100">

                Logout

            </button>

        </form>

    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white px-4 lg:px-8 py-4 border-b shadow-sm">

            <div class="flex items-center justify-between gap-3">

                <!-- LEFT -->
                <div class="flex items-center gap-3">

                    <!-- Mobile Menu -->
                    <button 
                        @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-gray-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>

                    </button>

                    <!-- Title -->
                    <div>
                        <h2 class="font-bold text-gray-800 text-sm lg:text-lg">
                            @yield('title', 'WIMIS KKI WARSI')
                        </h2>

                        <p class="text-[11px] text-gray-400 hidden lg:block">
                            Management Information System
                        </p>
                    </div>

                </div>

                <!-- RIGHT -->
                <div class="flex items-center gap-3 lg:gap-5">

                    @php
                        $unreadCount = auth()->user()
                            ->unreadNotifications()
                            ->count();

                        $latestNotifications = auth()->user()
                            ->notifications()
                            ->latest()
                            ->take(10)
                            ->get();
                    @endphp

                    <!-- Notification -->
                    <div x-data="{ open: false }" class="relative flex-shrink-0">

                        <!-- BUTTON -->
                        <button 
                            @click="open = !open"
                            class="relative p-2 rounded-full hover:bg-gray-100 transition">

                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-6 w-6 text-gray-600" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor">

                                <path stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    stroke-width="2" 
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11
                                    a6.002 6.002 0 00-4-5.659V5
                                    a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159
                                    c0 .538-.214 1.055-.595 1.436L4 17h5m6 0
                                    v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>

                            @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px]
                                        min-w-[20px] h-5 px-1 flex items-center justify-center rounded-full font-bold">
                                {{ $unreadCount }}
                            </span>
                            @endif

                        </button>

                        <!-- DROPDOWN -->
                        <div 
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 mt-3 w-[360px] max-w-[90vw]
                                    bg-white rounded-2xl shadow-2xl border
                                    overflow-hidden z-50">

                            <!-- HEADER -->
                            <div class="px-4 py-3 border-b bg-gray-50 flex justify-between items-center">

                                <h3 class="font-bold text-gray-700">
                                    Notifications
                                </h3>

                                @if($unreadCount > 0)
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full font-bold">
                                    {{ $unreadCount }} Baru
                                </span>
                                @endif

                            </div>

                            <!-- LIST -->
                            <div class="max-h-[450px] overflow-y-auto">

                                @forelse($latestNotifications as $notif)

                                <a href="{{ route('notifications.read', $notif->id) }}"
                                class="block px-4 py-4 border-b hover:bg-green-50 transition
                                {{ is_null($notif->read_at) ? 'bg-yellow-50' : 'bg-white' }}">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="flex-1">

                                            <!-- TITLE -->
                                            @if(isset($notif->data['title']))
                                            <div class="font-bold text-sm text-gray-800">
                                                {{ $notif->data['title'] }}
                                            </div>
                                            @endif

                                            <!-- MESSAGE -->
                                            <div class="text-sm text-gray-600 mt-1 leading-relaxed">
                                                {{ $notif->data['message'] }}
                                            </div>

                                            <!-- REASON -->
                                            @if(isset($notif->data['reason']) && $notif->data['reason'])
                                            <div class="mt-2 text-xs text-red-500 bg-red-50 px-2 py-1 rounded-lg">
                                                Alasan:
                                                {{ $notif->data['reason'] }}
                                            </div>
                                            @endif

                                            <!-- TIME -->
                                            <div class="text-xs text-gray-400 mt-2">
                                                {{ $notif->created_at->diffForHumans() }}
                                            </div>

                                        </div>

                                        <!-- UNREAD DOT -->
                                        @if(is_null($notif->read_at))
                                        <div class="w-2 h-2 rounded-full bg-red-500 mt-2 flex-shrink-0"></div>
                                        @endif

                                    </div>

                                </a>

                                @empty

                                <div class="p-6 text-center text-sm text-gray-500">
                                    Tidak ada notifikasi
                                </div>

                                @endforelse

                            </div>

                        </div>

                    </div>

                    <!-- User -->
                    <div class="hidden sm:block text-sm font-medium text-gray-700">
                        Halo, {{ Auth::user()->name }}
                    </div>

                </div>

            </div>

            <!-- SEARCH -->
            <div 
                x-data="{
                    keyword: '',
                    results: [],
                    loading: false,

                    async searchDocs() {
                        if (this.keyword.length < 2) {
                            this.results = [];
                            return;
                        }

                        this.loading = true;

                        let response = await fetch(`/datakm/live-search?keyword=${this.keyword}`);
                        this.results = await response.json();

                        this.loading = false;
                    }
                }"
                class="relative mt-4"
            >

                <!-- FORM -->
                <form action="{{ route('datakm.search') }}"
                    method="GET"
                    class="flex items-center bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden">

                    <!-- ICON -->
                    <div class="pl-4 text-gray-400">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>

                    </div>

                    <!-- INPUT -->
                    <input
                        type="text"
                        name="keyword"
                        x-model="keyword"
                        @input.debounce.300ms="searchDocs"
                        placeholder="Cari dokumen, laporan, riset..."
                        class="px-3 py-3 w-full text-sm outline-none border-none focus:ring-0 bg-transparent">

                    <!-- BUTTON -->
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white text-sm font-semibold px-4 lg:px-6 py-3 transition-all">

                        Cari

                    </button>

                </form>

                <!-- RESULT -->
                <div
                    x-show="keyword.length >= 2"
                    x-transition
                    class="absolute top-16 left-0 w-full bg-white border border-gray-200 rounded-2xl shadow-2xl overflow-hidden z-50">

                    <!-- Loading -->
                    <div x-show="loading" class="p-4 text-sm text-gray-500">
                        Mencari dokumen...
                    </div>

                    <!-- Results -->
                    <template x-if="results.length > 0">

                        <div>

                            <template x-for="item in results" :key="item.id">

                                <a
                                    :href="`/datakm/${item.id}`"
                                    class="block px-4 py-3 hover:bg-green-50 transition border-b">

                                    <div class="font-semibold text-sm text-gray-800"
                                        x-text="item.judul">
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1 flex gap-2">
                                        <span x-text="item.nama_penulis"></span>
                                        <span>•</span>
                                        <span x-text="item.kategori"></span>
                                    </div>

                                </a>

                            </template>

                        </div>

                    </template>

                    <!-- Empty -->
                    <template x-if="!loading && results.length == 0">

                        <div class="p-4 text-sm text-gray-500 text-center">
                            Dokumen tidak ditemukan
                        </div>

                    </template>

                </div>

            </div>

        </header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-8">
            @yield('content')
        </main>
    </div>

    <!-- Notifikasi Card -->
    <div class="fixed top-5 right-5 z-50 flex flex-col gap-2">
        <!-- Success Message -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
            class="bg-green-600 text-white p-4 rounded-lg shadow-lg flex items-center">
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
            class="bg-red-600 text-white p-4 rounded-lg shadow-lg">
            {{ $error }}
        </div>
        @endforeach
        @endif
    </div>
</div>
</body>

</html>