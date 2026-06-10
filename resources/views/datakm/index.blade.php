@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Knowledge Management
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola dokumen, laporan, dan pengetahuan organisasi secara terpusat.
            </p>
        </div>

        <a href="{{ route('datakm.create') }}"
           class="inline-flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-2xl font-semibold shadow-sm transition-all duration-300">

            <span>+</span>
            <span>Tambah Dokumen</span>
        </a>

    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($data as $item)

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">

            <!-- Top -->
            <div class="p-6">

                <!-- Badge -->
                <div class="mb-4">
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold
                        @if($item->kategori == 'Riset')
                            bg-blue-100 text-blue-700
                        @elseif($item->kategori == 'Laporan')
                            bg-green-100 text-green-700
                        @else
                            bg-yellow-100 text-yellow-700
                        @endif
                    ">
                        {{ $item->kategori }}
                    </span>
                </div>

                <!-- Title -->
                <h2 class="text-xl font-bold text-gray-800 leading-snug mb-3">
                    {{ $item->judul }}
                </h2>

                <!-- Summary -->
                <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">
                    {{ $item->ringkasan }}
                </p>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t bg-gray-50">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            {{ $item->nama_penulis }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $item->tanggal_laporan }}
                        </p>
                    </div>

                    <a href="{{ route('datakm.show', $item->id) }}"
                       class="text-sm font-bold text-green-700 hover:text-green-800">
                        Detail →
                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-span-full">

            <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-16 text-center">

                <div class="text-6xl mb-4">
                    📂
                </div>

                <h3 class="text-xl font-bold text-gray-700 mb-2">
                    Dokumen Tidak Ditemukan
                </h3>

                <p class="text-gray-500">
                    Belum ada dokumen atau hasil pencarian tidak ditemukan.
                </p>

            </div>

        </div>

        @endforelse

    </div>

</div>

@endsection