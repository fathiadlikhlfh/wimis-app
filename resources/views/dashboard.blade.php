@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-br from-green-800 via-green-700 to-emerald-600 p-8 lg:p-10 text-white shadow-xl">

        <div class="relative z-10">
            <p class="text-green-100 text-sm tracking-[0.2em] uppercase font-medium">
                Warsi Management Information System
            </p>

            <h1 class="text-3xl lg:text-5xl font-bold mt-3">
                Selamat Datang, {{ auth()->user()->name }}
            </h1>

            <p class="text-green-100 mt-4 text-sm lg:text-base">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>

            <div class="mt-6 inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur border border-white/20 text-sm">
                {{ ucfirst(auth()->user()->role) }} Dashboard
            </div>
        </div>

        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-emerald-300/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    </div>


    {{-- STAFF DASHBOARD --}}
    @if(auth()->user()->role === 'staff')

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Status Timesheet Hari Ini
            </p>

            <h3 class="text-2xl font-bold text-gray-800 mt-4">
                {{ $timesheetToday ? 'Sudah Diisi' : 'Belum Diisi' }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full {{ $timesheetToday ? 'bg-green-600' : 'bg-red-500' }}"></div>
        </div>

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Total Approval Pending
            </p>

            <h3 class="text-4xl font-bold text-yellow-600 mt-4">
                {{ $pendingProposal }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-yellow-500"></div>
        </div>

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Notifikasi Baru
            </p>

            <h3 class="text-4xl font-bold text-blue-600 mt-4">
                {{ $unreadCount }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-blue-500"></div>
        </div>

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Pengajuan Ditolak
            </p>

            <h3 class="text-4xl font-bold text-red-600 mt-4">
                {{ $rejectedProposal }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-red-500"></div>
        </div>

    </div>

    @endif


    {{-- COORDINATOR DASHBOARD --}}
    @if(auth()->user()->role === 'coordinator')

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Approval Pending
            </p>

            <h3 class="text-4xl font-bold text-yellow-600 mt-4">
                {{ $approvalPending }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-yellow-500"></div>
        </div>

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Pegawai Belum Isi Timesheet
            </p>

            <h3 class="text-4xl font-bold text-red-600 mt-4">
                {{ $staffNotFilled }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-red-500"></div>
        </div>

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Notifikasi Baru
            </p>

            <h3 class="text-4xl font-bold text-blue-600 mt-4">
                {{ $unreadCount }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-blue-500"></div>
        </div>

        <div class="group bg-white rounded-3xl border border-gray-100 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-sm text-gray-500 font-medium">
                Pengajuan Hari Ini
            </p>

            <h3 class="text-4xl font-bold text-green-600 mt-4">
                {{ $submissionToday }}
            </h3>

            <div class="mt-5 h-1 w-16 rounded-full bg-green-500"></div>
        </div>

    </div>

    @endif

    <!-- Smart CV Screening -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="grid lg:grid-cols-2 items-center">

            <!-- Content -->
            <div class="p-8 lg:p-10">

                <span class="text-sm font-semibold text-green-700 uppercase tracking-wider">
                    Smart Recruitment
                </span>

                <h2 class="text-3xl font-bold text-gray-800 mt-3 leading-snug">
                    Smart CV Screening Berbasis AI
                </h2>

                <p class="text-gray-600 mt-5 leading-relaxed">
                    WIMIS menyediakan fitur Smart CV Screening untuk membantu proses
                    rekrutmen secara lebih cepat dan objektif. Sistem akan melakukan
                    analisis CV kandidat berdasarkan kebutuhan posisi, pengalaman,
                    pendidikan, serta tingkat kecocokan terhadap kebutuhan organisasi.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">

                    <a href="{{ route('vacancy') }}"
                    class="px-6 py-3 rounded-2xl bg-green-600 text-white font-semibold
                            hover:bg-green-700 transition duration-300">

                        Buka Smart CV Screening

                    </a>

                    <a href="{{ route('vacancy') }}"
                    class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-700
                            font-semibold hover:bg-gray-50 transition duration-300">

                        Pelajari Fitur

                    </a>

                </div>

            </div>

            <!-- Illustration Area -->
            <div class="bg-gray-50 h-full flex items-center justify-center p-10">

                <div class="w-full max-w-md">

                    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">

                        <h3 class="text-lg font-semibold text-gray-800 mb-6">
                            Alur Smart CV Screening
                        </h3>

                        <div class="space-y-5">

                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    1
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        Tentukan Posisi
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        HR menentukan posisi yang sedang dibutuhkan organisasi.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    2
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        Upload CV Kandidat (Max 5 CV)
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Sistem menerima beberapa CV kandidat dalam format PDF.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    3
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        Analisis Otomatis
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        AI melakukan evaluasi berdasarkan pendidikan, pengalaman, dan relevansi kompetensi.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    4
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        Rekomendasi Kandidat
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Sistem menghasilkan ranking kandidat sebagai bahan pertimbangan rekrutmen.
                                    </p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- INSIGHT PANEL --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-lg transition-all duration-300">

            <p class="text-sm font-semibold tracking-[0.2em] uppercase text-green-700">
                Monitoring
            </p>

            <h2 class="text-3xl font-bold text-gray-800 mt-4">
                Aktivitas Operasional WIMIS
            </h2>

            <p class="text-gray-600 leading-relaxed mt-5">
                Dashboard ini menampilkan ringkasan aktivitas operasional, status approval,
                monitoring timesheet harian, serta informasi penting yang memerlukan tindak
                lanjut dari pengguna sesuai dengan peran masing-masing.
            </p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="rounded-2xl bg-gray-50 p-5 border border-gray-100">
                    <div class="text-sm text-gray-500">
                        Total Notifikasi Baru
                    </div>

                    <div class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $unreadCount }}
                    </div>
                </div>

                <div class="rounded-2xl bg-gray-50 p-5 border border-gray-100">
                    <div class="text-sm text-gray-500">
                        Aktivitas Hari Ini
                    </div>

                    <div class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $submissionToday }}
                    </div>
                </div>

            </div>

        </div>

        <div class="bg-gradient-to-br from-green-700 to-emerald-600 rounded-3xl p-8 text-white shadow-lg hover:shadow-xl transition-all duration-300">

            <p class="uppercase tracking-[0.2em] text-green-100 text-sm">
                Status Sistem
            </p>

            <h3 class="text-2xl font-bold mt-5">
                WIMIS Operational Dashboard
            </h3>

            <p class="text-green-100 mt-5 leading-relaxed text-sm">
                Sistem berjalan normal dan seluruh modul utama dapat digunakan
                untuk mendukung proses administrasi, monitoring, serta approval
                kegiatan operasional organisasi.
            </p>

            <div class="mt-8 pt-6 border-t border-white/20">
                <div class="text-sm text-green-100">
                    Environment
                </div>

                <div class="font-semibold mt-1">
                    Production
                </div>
            </div>

        </div>

    </div>


</div>

@endsection