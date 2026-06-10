@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-700 to-green-800 p-8 text-white">

            <h1 class="text-3xl font-bold mb-2">
                Tambah Dokumen Baru
            </h1>

            <p class="text-green-100">
                Tambahkan dokumen pengetahuan organisasi secara terstruktur.
            </p>

        </div>

        <!-- Form -->
        <form action="{{ route('datakm.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-8 space-y-10">

            @csrf

            <!-- Section 1 -->
            <div>

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800">
                        Informasi Dokumen
                    </h2>

                    <p class="text-sm text-gray-500">
                        Isi informasi utama terkait dokumen.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Judul Dokumen
                        </label>

                        <input type="text"
                            name="judul"
                            placeholder="Masukkan judul dokumen..."
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Kategori
                        </label>

                        <select name="kategori"
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300">

                            <option value="Riset">Dokumen Riset</option>
                            <option value="Laporan">Laporan</option>
                            <option value="Pembelajaran">Pembelajaran</option>

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Nama Penulis
                        </label>

                        <input type="text"
                            name="nama_penulis"
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300"
                            required>
                    </div>

                </div>

            </div>

            <!-- Divider -->
            <div class="border-t border-dashed border-gray-300"></div>

            <!-- Section 2 -->
            <div>

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800">
                        Metadata Dokumen
                    </h2>

                    <p class="text-sm text-gray-500">
                        Informasi pendukung terkait dokumen.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Tanggal Laporan
                        </label>

                        <input type="date"
                            name="tanggal_laporan"
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Project
                        </label>

                        <input type="text"
                            name="project"
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Lokasi
                        </label>

                        <input type="text"
                            name="lokasi"
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300">
                    </div>

                </div>

            </div>

            <!-- Divider -->
            <div class="border-t border-dashed border-gray-300"></div>

            <!-- Section 3 -->
            <div>

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800">
                        Ringkasan & File
                    </h2>

                    <p class="text-sm text-gray-500">
                        Tambahkan ringkasan dan file dokumen PDF.
                    </p>
                </div>

                <!-- Summary -->
                <div class="mb-6">

                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Ringkasan Dokumen
                    </label>

                    <textarea name="ringkasan"
                            rows="5"
                            placeholder="Tuliskan ringkasan dokumen..."
                            class="w-full rounded-2xl border border-gray-300 bg-gray-50 px-4 py-3 
                            focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100
                            hover:border-gray-400 transition-all duration-300"></textarea>

                </div>

                <!-- Upload -->
                <div>

                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        Upload File PDF
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-3xl p-10 text-center bg-gray-50 hover:border-green-500 hover:bg-green-50 transition-all duration-300">

                        <div class="text-5xl mb-4">
                            📄
                        </div>

                        <p class="font-semibold text-gray-700 mb-2">
                            Upload Dokumen PDF
                        </p>

                        <p class="text-sm text-gray-500 mb-4">
                            Maksimal ukuran file 5MB
                        </p>

                        <input type="file"
                            name="file_pdf"
                            accept="application/pdf"
                            class="text-sm"
                            required>

                    </div>

                </div>

            </div>

            <!-- Button -->
            <div class="flex justify-end gap-4 pt-4">

                <a href="{{ route('datakm.index') }}"
                class="px-6 py-3 rounded-2xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition-all duration-300">

                    Batal
                </a>

                <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-2xl font-semibold shadow-lg transition-all duration-300">

                    Simpan Dokumen
                </button>

            </div>

        </form>

    </div>

</div>

@endsection