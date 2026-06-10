@extends('layouts.app')

@section('content')

@php
    $pendingTimesheet = $timesheets;
    $historyTimesheet = $historyTimesheets;
@endphp

<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-black text-gray-800">
                Approval Timesheet B3
            </h1>

            <p class="text-gray-500 mt-2">
                Persetujuan aktivitas dan pekerjaan harian staf lapangan.
            </p>
        </div>

        <div class="flex gap-3">

            <div class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-2xl text-sm font-semibold">
                Pending :
                {{ $pendingTimesheet->total() }}
            </div>

            <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-2xl text-sm font-semibold">
                Riwayat :
                {{ $historyTimesheet->total() }}
            </div>

        </div>

    </div>

    <!-- Pending -->
    <div>

        <div class="flex items-center gap-3 mb-5">

            <div class="w-2 h-8 rounded-full bg-blue-500"></div>

            <h2 class="text-xl font-bold text-gray-800">
                Menunggu Approval
            </h2>

        </div>

        @forelse($pendingTimesheet as $ts)

        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 mb-4">

            <div class="flex flex-col 2xl:flex-row 2xl:items-center justify-between gap-6">

                <!-- Left -->
                <div class="flex items-start gap-5 flex-1">

                    <!-- Avatar -->
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-lg">
                        {{ strtoupper(substr($ts->user->name ?? 'U',0,1)) }}
                    </div>

                    <!-- Content -->
                    <div class="flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            <h2 class="text-xl font-bold text-gray-800">
                                {{ $ts->user->name }}
                            </h2>

                            <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-semibold">
                                Pending
                            </span>

                        </div>

                        <div class="flex flex-wrap gap-2 mt-3">

                            <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full">
                                {{ $ts->tanggal_kegiatan }}
                            </span>

                            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                                {{ $ts->project }}
                            </span>

                            <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                                {{ $ts->lokasi }}
                            </span>

                        </div>

                        <div class="mt-4 text-gray-600 leading-relaxed">
                            {{ $ts->aktivitas }}
                        </div>

                    </div>

                </div>

                <!-- Action -->
                <form action="{{ route('approval.timesheet.update', $ts->id) }}" method="POST">

                    @csrf
                    @method('PATCH')

                    <div class="flex gap-3">

                        <button
                            type="submit"
                            name="status"
                            value="Approved"
                            onclick="this.disabled=true;this.form.submit();"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-2xl font-semibold transition-all duration-300 shadow">

                            Approve

                        </button>

                        <button
                            type="button"
                            onclick="document.getElementById('rejectModal{{ $ts->id }}').classList.remove('hidden')"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-2xl font-semibold transition-all duration-300 shadow">

                            Reject

                        </button>

                    </div>

                </form>

                <div id="rejectModal{{ $ts->id }}"
                    class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center">

                    <div class="bg-white rounded-3xl p-6 w-full max-w-lg">

                        <h2 class="text-xl font-bold mb-4">
                            Alasan Reject
                        </h2>

                        <form action="{{ route('approval.timesheet.update', $ts->id) }}"
                            method="POST">

                            @csrf
                            @method('PATCH')

                            <input type="hidden"
                                name="status"
                                value="Rejected">

                            <textarea
                                name="rejection_reason"
                                required
                                class="w-full border rounded-2xl p-4"
                                rows="5"
                                placeholder="Masukkan alasan reject..."></textarea>

                            <div class="flex justify-end gap-3 mt-5">

                                <button type="button"
                                    onclick="document.getElementById('rejectModal{{ $ts->id }}').classList.add('hidden')"
                                    class="px-5 py-2 rounded-xl bg-gray-200">

                                    Batal

                                </button>

                                <button type="submit"
                                    onclick="this.disabled=true;this.form.submit();"
                                    class="px-5 py-2 rounded-xl bg-red-600 text-white">

                                    Reject

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        @empty

        <!-- Empty State -->
        <div class="bg-white border border-dashed border-gray-300 rounded-3xl p-16 text-center">

            <div class="text-6xl mb-5">
                📂
            </div>

            <h2 class="text-2xl font-bold text-gray-700">
                Tidak Ada Pengajuan Timesheet
            </h2>

            <p class="text-gray-500 mt-2">
                Semua timesheet sudah diproses atau belum ada pengajuan baru.
            </p>

        </div>

        @endforelse

    </div>

    <div class="pt-4">
        {{ $timesheets->links() }}
    </div>

    <!-- History -->
    <div>

        <div class="flex items-center gap-3 mb-5">

            <div class="w-2 h-8 rounded-full bg-gray-500"></div>

            <h2 class="text-xl font-bold text-gray-800">
                Riwayat Approval
            </h2>

        </div>

        <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
                            Project
                        </th>

                        <th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($historyTimesheet as $item)

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-6 py-4 font-semibold text-gray-700">
                            {{ $item->user->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $item->tanggal_kegiatan }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->project }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="
                                px-3 py-1 rounded-full text-xs font-bold
                                {{ $item->status_approval == 'Approved'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'
                                }}
                            ">

                                {{ $item->status_approval }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center py-10 text-gray-400">
                            Belum ada riwayat approval.
                        </td>

                    </tr>

                    @endforelse

                    <div class="mt-5">
                        {{ $pendingTimesheet->links() }}
                    </div>

                </tbody>

            </table>

            <div class="p-5 border-t">
                {{ $historyTimesheet->links() }}
            </div>

        </div>

    </div>

    <div class="p-5">
        {{ $historyTimesheets->links() }}
    </div>

</div>

@endsection