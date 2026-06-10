@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    <!-- Back -->
    <div>
        <a href="{{ route('datakm.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-green-700 transition-all duration-300">

            <span class="text-lg">←</span>
            <span>Back</span>

        </a>
    </div>

    <!-- Hero -->
    <div class="bg-gradient-to-r from-green-700 to-green-800 rounded-3xl p-8 text-white shadow-xl">

        <div class="flex items-start justify-between gap-6">

            <div>

                <div class="mb-4">
                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">
                        {{ $item->kategori }}
                    </span>
                </div>

                <h1 class="text-4xl font-bold leading-tight mb-4">
                    {{ $item->judul }}
                </h1>

                <p class="text-green-100 leading-relaxed max-w-3xl">
                    {{ $item->ringkasan }}
                </p>

            </div>

        </div>

    </div>

    <!-- Metadata -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
            <p class="text-xs uppercase text-gray-400 font-bold mb-1">
                Penulis
            </p>

            <p class="font-semibold text-gray-800">
                {{ $item->nama_penulis }}
            </p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
            <p class="text-xs uppercase text-gray-400 font-bold mb-1">
                Tanggal
            </p>

            <p class="font-semibold text-gray-800">
                {{ $item->tanggal_laporan }}
            </p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
            <p class="text-xs uppercase text-gray-400 font-bold mb-1">
                Lokasi
            </p>

            <p class="font-semibold text-gray-800">
                {{ $item->lokasi }}
            </p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
            <p class="text-xs uppercase text-gray-400 font-bold mb-1">
                Project
            </p>

            <p class="font-semibold text-gray-800">
                {{ $item->project }}
            </p>
        </div>

    </div>

    <!-- Content -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Ringkasan Dokumen
        </h2>

        <div class="text-gray-600 leading-relaxed whitespace-pre-line">
            {{ $item->ringkasan }}
        </div>

    </div>

    <!-- Actions -->
    <div class="flex flex-wrap gap-4">

        <a href="{{ asset('storage/'.$item->file_path) }}"
        target="_blank"
        class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-2xl font-semibold shadow transition-all duration-300">

            📥 Download PDF
        </a>

    </div>

</div>

@endsection