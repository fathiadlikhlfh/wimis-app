@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Rekap Timesheet B3
            </h1>

            <p class="text-gray-500 mt-1">
                Monitoring aktivitas dan progress pekerjaan Anda.
            </p>
        </div>

        <!-- SUMMARY -->
        <div class="flex gap-3 flex-wrap">

            <div class="bg-blue-100 text-blue-700 px-5 py-3 rounded-2xl">
                <div class="text-xs font-medium">
                    Total Data
                </div>

                <div class="text-2xl font-bold">
                    {{ $timesheets->total() }}
                </div>
            </div>

            <div class="bg-green-100 text-green-700 px-5 py-3 rounded-2xl">
                <div class="text-xs font-medium">
                    Approved
                </div>

                <div class="text-2xl font-bold">
                    {{ $timesheets->where('status_approval', 'Approved')->count() }}
                </div>
            </div>

            <div class="bg-yellow-100 text-yellow-700 px-5 py-3 rounded-2xl">
                <div class="text-xs font-medium">
                    Pending
                </div>

                <div class="text-2xl font-bold">
                    {{ $timesheets->where('status_approval', 'Pending')->count() }}
                </div>
            </div>

        </div>

    </div>

    <!-- LIST -->
    <div class="space-y-4">

        @forelse($timesheets as $item)

        <div class="bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-lg transition-all p-5">

            <div class="flex flex-col xl:flex-row xl:items-start justify-between gap-5">

                <!-- LEFT -->
                <div class="flex items-start gap-4 flex-1">

                    <!-- ICON -->
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-700 font-bold text-lg">
                        📄
                    </div>

                    <!-- CONTENT -->
                    <div class="flex-1">

                        <div class="flex flex-wrap items-center gap-2 mb-2">

                            <h2 class="text-lg font-bold text-gray-800">
                                {{ $item->project }}
                            </h2>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $item->status_approval == 'Approved'
                                    ? 'bg-green-100 text-green-700'
                                    : ($item->status_approval == 'Rejected'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-yellow-100 text-yellow-700') }}">

                                {{ $item->status_approval ?? 'Pending' }}

                            </span>

                        </div>

                        <!-- META -->
                        <div class="flex flex-wrap gap-2 text-xs mb-3">

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                {{ $item->tanggal_kegiatan }}
                            </span>

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                {{ $item->lokasi }}
                            </span>

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                {{ $item->total_jam }} Jam
                            </span>

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                {{ $item->claim_type }}
                            </span>

                        </div>

                        <!-- ACTIVITY -->
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $item->aktivitas }}
                        </p>

                    </div>

                </div>

                <!-- ACTION -->
                <div class="flex flex-col items-end gap-3">

                    @if($item->status_approval == 'Pending')

                    <div class="flex gap-2">

                        <a href="{{ route('mydata.timesheet.edit', $item->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">

                            Edit

                        </a>

                        <form action="{{ route('mydata.timesheet.delete', $item->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus timesheet ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">

                                Hapus

                            </button>

                        </form>

                    </div>

                    @else

                    <div class="flex items-center gap-2 bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-sm">

                        🔒
                        <span>
                            Terkunci
                        </span>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        @empty

        <!-- EMPTY -->
        <div class="bg-white border border-dashed border-gray-300 rounded-3xl p-12 text-center">

            <div class="text-6xl mb-4">
                ⏳
            </div>

            <h2 class="text-2xl font-bold text-gray-700">
                Belum Ada Timesheet
            </h2>

            <p class="text-gray-500 mt-2">
                Aktivitas timesheet Anda akan muncul di sini.
            </p>

        </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="pt-4">
        {{ $timesheets->links() }}
    </div>

</div>

@endsection