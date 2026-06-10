@extends('layouts.app')

@section('content')

<div x-data="{ tab: 'A' }" class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Timesheet B3
            </h1>

            <p class="text-gray-500 mt-1">
                Input aktivitas harian dan monitoring bulanan kegiatan.
            </p>
        </div>

        <!-- STATUS -->
        <div class="flex items-center gap-2 bg-green-100 text-green-700 px-4 py-3 rounded-2xl text-sm font-semibold">
            Work Activity Tracker
        </div>

    </div>

    <!-- TAB -->
    <div class="flex gap-3">

        <button
            @click="tab = 'A'"
            :class="tab == 'A'
                ? 'bg-green-700 text-white shadow-lg shadow-green-200'
                : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50'"
            class="px-5 py-3 rounded-2xl font-semibold transition-all duration-300">

            Form A (Harian)

        </button>

        <button
            @click="tab = 'B'"
            :class="tab == 'B'
                ? 'bg-green-700 text-white shadow-lg shadow-green-200'
                : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50'"
            class="px-5 py-3 rounded-2xl font-semibold transition-all duration-300">

            Form B (Bulanan)

        </button>

    </div>

    <!-- FORM A -->
    <div x-show="tab == 'A'" x-transition>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <!-- TOP -->
            <div class="px-8 py-6 border-b bg-gradient-to-r from-green-50 to-emerald-50">

                <h2 class="text-lg font-bold text-gray-800">
                    Input Aktivitas Harian
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Catat kegiatan harian untuk monitoring dan evaluasi program.
                </p>

            </div>

            <!-- FORM -->
            <form action="{{ route('timesheet.store') }}"
                method="POST"
                class="p-8 space-y-8">

                @csrf

                <!-- GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Tanggal -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Kegiatan
                        </label>

                        <input type="date"
                            name="tanggal"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                            required>

                    </div>

                    <!-- Project -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Project
                        </label>

                        <input type="text"
                            name="project"
                            placeholder="Nama project"
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

                    <!-- Total Jam -->
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Total Jam
                        </label>

                        <input type="number"
                            name="total_jam"
                            placeholder="Contoh: 8"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                            required>

                    </div>

                    <!-- Claim -->
                    <div class="lg:col-span-2">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Claim Type
                        </label>

                        <select
                            name="claim_type"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition"
                            required>

                            <option value="">
                                Pilih Claim Type
                            </option>

                            <option value="Perdiem">
                                Perdiem
                            </option>

                            <option value="Uang Makan">
                                Uang Makan
                            </option>

                            <option value="Actual Cost">
                                Actual Cost
                            </option>

                        </select>

                    </div>

                </div>

                <!-- AKTIVITAS -->
                <div>

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Aktivitas / Kegiatan
                    </label>

                    <textarea
                        name="aktivitas"
                        rows="5"
                        placeholder="Tuliskan aktivitas yang dilakukan..."
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none transition resize-none"
                        required></textarea>

                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-3 pt-4 border-t">

                    <button type="button"
                        class="px-6 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition">

                        Reset

                    </button>

                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg shadow-green-200 transition">

                        Simpan Timesheet

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- FORM B -->
    <div x-show="tab == 'B'" x-transition>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <!-- TOP -->
            <div class="px-8 py-6 border-b bg-gradient-to-r from-blue-50 to-cyan-50">

                <h2 class="text-lg font-bold text-gray-800">
                    Monitoring Bulanan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Rekap aktivitas bulanan berbentuk matriks monitoring.
                </p>

            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full min-w-[1200px]">

                    <!-- HEADER -->
                    <thead class="bg-gray-50 border-b">

                        <tr>

                            <th class="sticky left-0 bg-gray-50 z-10 px-6 py-4 text-left text-xs font-bold uppercase text-gray-500 border-r">
                                Kegiatan
                            </th>

                            @for($i = 1; $i <= 31; $i++)

                            <th class="px-3 py-4 text-center text-xs font-bold text-gray-500 border-r">
                                {{ $i }}
                            </th>

                            @endfor

                        </tr>

                    </thead>

                    <!-- BODY -->
                    <tbody>

                        <tr class="hover:bg-gray-50 transition">

                            <td class="sticky left-0 bg-white z-10 px-6 py-4 border-r font-semibold text-gray-700">
                                Kegiatan Lapangan
                            </td>

                            @for($i = 1; $i <= 31; $i++)

                            <td class="text-center border-r border-b py-3">

                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">

                            </td>

                            @endfor

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection