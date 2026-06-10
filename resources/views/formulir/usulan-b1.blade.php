@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Form Usulan B1
            </h1>

            <p class="text-gray-500 mt-1">
                Ajukan kegiatan program untuk approval coordinator.
            </p>
        </div>

        <div class="hidden lg:flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-2xl text-sm font-semibold">
            Draft Baru
        </div>

    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <!-- TOP -->
        <div class="px-8 py-6 border-b bg-gradient-to-r from-green-50 to-emerald-50">

            <h2 class="text-lg font-bold text-gray-800">
                Informasi Kegiatan
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Lengkapi detail kegiatan yang akan diajukan.
            </p>

        </div>

        <!-- FORM -->
        <form action="{{ route('usulan.store') }}"
            method="POST"
            class="p-8 space-y-8">

            @csrf

            <!-- SECTION -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Judul -->
                <div class="lg:col-span-2">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Kegiatan
                    </label>

                    <input type="text"
                        name="judul_kegiatan"
                        placeholder="Contoh: Monitoring Kawasan Konservasi"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                        required>

                </div>

                <!-- Project -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Project Code
                    </label>

                    <input type="text"
                        name="project_code"
                        placeholder="PRJ-001"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                        required>

                </div>

                <!-- Lokasi -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Lokasi
                    </label>

                    <input type="text"
                        name="lokasi"
                        placeholder="Lokasi kegiatan"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                        required>

                </div>

                <!-- Tanggal -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input type="date"
                        name="tanggal_mulai"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                        required>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input type="date"
                        name="tanggal_selesai"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                        required>

                </div>

            </div>

            <!-- DESCRIPTION -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Kegiatan
                </label>

                <textarea
                    name="deskripsi"
                    rows="5"
                    placeholder="Tuliskan deskripsi kegiatan..."
                    class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition resize-none"></textarea>

            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-3 pt-4 border-t">

                <button type="button"
                    class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition">

                    Simpan Draft

                </button>

                <button type="submit"
                    class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg shadow-green-200 transition">

                    Kirim Usulan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection