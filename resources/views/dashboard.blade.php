@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-700 to-emerald-600 rounded-3xl p-8 text-white shadow-sm">

        <p class="text-sm text-green-100 mb-2">
            Selamat Datang
        </p>

        <h1 class="text-3xl font-bold">
            {{ Auth::user()->name }}
        </h1>

        <p class="text-sm text-green-100 mt-3">
            Warsi Management Information System
        </p>

    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Card -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">

            <p class="text-sm text-gray-500">
                Total Surat
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-3">
                1,284
            </h3>

            <p class="text-sm text-green-600 mt-2">
                ↑ 12% bulan ini
            </p>

        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">

            <p class="text-sm text-gray-500">
                Approval Pending
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-3">
                12
            </h3>

            <p class="text-sm text-red-500 mt-2">
                Membutuhkan tindak lanjut
            </p>

        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">

            <p class="text-sm text-gray-500">
                Anggaran Terserap
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-3">
                84%
            </h3>

            <p class="text-sm text-blue-600 mt-2">
                Sesuai target
            </p>

        </div>

    </div>

    <!-- Error -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Insight -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="md:flex">

            <!-- Left -->
            <div class="md:w-1/2 p-8">

                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide">
                    Data Insight
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-3 leading-snug">
                    Analisis Peningkatan Kapasitas SDM
                </h2>

                <p class="text-gray-600 mt-4 leading-relaxed">
                    Berdasarkan data kuartal terakhir, peningkatan kapasitas SDM menunjukkan korelasi positif terhadap efisiensi pelaporan internal di seluruh departemen WIMIS.
                </p>

                <a href="#"
                   class="inline-block mt-6 text-green-700 font-semibold hover:text-green-900">
                    Baca Selengkapnya →
                </a>

            </div>

            <!-- Right -->
            <div class="md:w-1/2 bg-gray-50 flex items-center justify-center p-8">

                <div class="w-full h-64 rounded-2xl border border-dashed border-gray-300 flex items-center justify-center text-gray-400 text-sm">
                    Visual Analytics
                </div>

            </div>

        </div>

    </div>

</div>

@endsection