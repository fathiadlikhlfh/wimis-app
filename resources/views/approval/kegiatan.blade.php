@extends('layouts.app')

@section('content')

@php
    $pendingProposals = $proposals;
    $historyProposal = $historyProposals;
@endphp

<div class="space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Approval Usulan B1
            </h1>

            <p class="text-gray-500 mt-1">
                Persetujuan usulan kegiatan staf.
            </p>
        </div>

        <!-- STATS -->
        <div class="flex gap-3">

            <div class="bg-yellow-100 text-yellow-700 px-5 py-3 rounded-2xl">
                <div class="text-xs font-medium">
                    Pending
                </div>

                <div class="text-2xl font-bold">
                    {{ $pendingProposals->total() }}
                </div>
            </div>

            <div class="bg-green-100 text-green-700 px-5 py-3 rounded-2xl">
                <div class="text-xs font-medium">
                    Approved
                </div>

                <div class="text-2xl font-bold">
                    {{ $historyProposal->where('status','Approved')->count() }}
                </div>
            </div>

            <div class="bg-red-100 text-red-700 px-5 py-3 rounded-2xl">
                <div class="text-xs font-medium">
                    Rejected
                </div>

                <div class="text-2xl font-bold">
                    {{ $historyProposal->where('status','Rejected')->count() }}
                </div>
            </div>

        </div>

    </div>

    <!-- PENDING -->
    <div>

        <h2 class="text-lg font-bold text-gray-700 mb-4">
            Pending Approval
        </h2>

        <div class="space-y-4">

            @forelse($pendingProposals as $p)

            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-lg transition-all p-5">

                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-5">

                    <!-- LEFT -->
                    <div class="flex items-start gap-4 flex-1">

                        <!-- Avatar -->
                        <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-green-700 font-bold text-lg">
                            {{ strtoupper(substr($p->user->name ?? 'U',0,1)) }}
                        </div>

                        <!-- Content -->
                        <div class="flex-1">

                            <div class="flex flex-wrap items-center gap-2 mb-2">

                                <h2 class="text-lg font-bold text-gray-800">
                                    {{ $p->judul_kegiatan }}
                                </h2>

                                <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-semibold">
                                    Pending
                                </span>

                            </div>

                            <div class="flex flex-wrap gap-2 text-xs mb-3">

                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                    {{ $p->user->name }}
                                </span>

                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                    {{ $p->project_code }}
                                </span>

                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                                    {{ $p->lokasi }}
                                </span>

                            </div>

                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $p->deskripsi ?? 'Tidak ada deskripsi.' }}
                            </p>

                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="flex gap-3">

                        <form action="{{ route('approval.update', $p->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button
                                name="status"
                                value="Approved"
                                class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-2xl font-semibold transition">

                                Approve

                            </button>
                        </form>

                        <button
                            type="button"
                            onclick="document.getElementById('rejectModal{{ $p->id }}').classList.remove('hidden')"
                            class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-2xl font-semibold transition">

                            Reject

                        </button>

                    </div>

                </div>

            </div>

            <!-- Modal Reject -->
            <div id="rejectModal{{ $p->id }}"
                class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center">

                <div class="bg-white rounded-3xl p-6 w-full max-w-lg">

                    <h2 class="text-xl font-bold mb-4">
                        Alasan Reject
                    </h2>

                    <form action="{{ route('approval.update', $p->id) }}"
                        method="POST">

                        @csrf
                        @method('PATCH')

                        <input
                            type="hidden"
                            name="status"
                            value="Rejected">

                        <textarea
                            name="rejection_reason"
                            required
                            rows="5"
                            class="w-full border rounded-2xl p-4"
                            placeholder="Masukkan alasan reject..."></textarea>

                        <div class="flex justify-end gap-3 mt-5">

                            <button
                                type="button"
                                onclick="document.getElementById('rejectModal{{ $p->id }}').classList.add('hidden')"
                                class="px-5 py-2 rounded-xl bg-gray-200">

                                Batal

                            </button>

                            <button
                                type="submit"
                                class="px-5 py-2 rounded-xl bg-red-600 text-white">

                                Reject

                            </button>

                        </div>

                    </form>

                </div>

            </div>
            @empty

            <div class="bg-white border border-dashed border-gray-300 rounded-3xl p-10 text-center">

                <div class="text-5xl mb-4">
                    📂
                </div>

                <h2 class="text-xl font-bold text-gray-700">
                    Tidak Ada Pending Approval
                </h2>

                <p class="text-gray-500 mt-2">
                    Semua usulan sudah diproses.
                </p>

            </div>

            @endforelse

        </div>

    </div>

    <div class="pt-4">
        {{ $pendingProposals->links() }}
    </div>

    <!-- HISTORY -->
    <div>

        <h2 class="text-lg font-bold text-gray-700 mb-4">
            Riwayat Approval
        </h2>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-50 border-b">

                    <tr class="text-left text-xs uppercase text-gray-500">

                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Pengusul</th>
                        <th class="px-6 py-4">Project</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Alasan Reject</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($historyProposal as $p)

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-6 py-4 font-semibold text-gray-700">
                            {{ $p->judul_kegiatan }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $p->user->name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $p->project_code }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $p->status == 'Approved'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">

                                {{ $p->status }}

                            </span>

                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">

                            @if($p->status == 'Rejected')

                                {{ $p->rejection_reason }}

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <div class="p-5 border-t">
        {{ $historyProposal->links() }}
    </div>

</div>

@endsection