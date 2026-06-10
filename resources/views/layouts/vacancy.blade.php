@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- HERO -->
    <div class="bg-gradient-to-r from-green-700 to-emerald-600 rounded-3xl p-8 text-white shadow-lg">

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

            <div>

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl">
                        AI
                    </div>

                    <div>
                        <h1 class="text-3xl font-black">
                            Smart Recruitment AI
                        </h1>

                        <p class="text-green-100 mt-1">
                            Analisis CV otomatis menggunakan AI untuk membantu proses seleksi kandidat terbaik.
                        </p>
                    </div>

                </div>

            </div>

            <!-- STATS -->
            <div class="flex gap-3 flex-wrap">

                <div class="bg-white/10 backdrop-blur px-5 py-4 rounded-2xl">
                    <div class="text-sm text-green-100">
                        Max Upload
                    </div>

                    <div class="text-2xl font-bold">
                        5 CV
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur px-5 py-4 rounded-2xl">
                    <div class="text-sm text-green-100">
                        AI Screening
                    </div>

                    <div class="text-2xl font-bold">
                        Active
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ERROR -->
    @if ($errors->any())

    <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">

        {{ $errors->first() }}

    </div>

    @endif

    <!-- FORM -->
    <div
        x-data="{ loading: false }"
        class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">

        <div class="mb-8">

            <h2 class="text-2xl font-bold text-gray-800">
                Upload Kandidat
            </h2>

            <p class="text-gray-500 mt-1">
                Upload CV kandidat dan biarkan AI melakukan screening otomatis.
            </p>

        </div>

        <form
            action="{{ route('cv.process') }}"
            method="POST"
            enctype="multipart/form-data"
            @submit="loading = true"
            class="space-y-6">

            @csrf

            <!-- POSITION -->
            <div>

                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Posisi Dibutuhkan
                </label>

                <input
                    type="text"
                    name="position"
                    placeholder="Contoh: Staff GIS Lapangan"
                    class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-green-500 focus:outline-none"
                    required>

            </div>

            <!-- FILE -->
            <div>

                <label class="block text-sm font-bold text-gray-700 mb-3">
                    Upload CV Kandidat
                </label>

                <div class="border-2 border-dashed border-gray-300 rounded-3xl p-10 text-center hover:border-green-500 transition">

                    <div class="text-5xl mb-4">
                        📄
                    </div>

                    <h3 class="text-lg font-bold text-gray-700">
                        Drag & Drop CV PDF
                    </h3>

                    <p class="text-gray-500 text-sm mt-2 mb-5">
                        Maksimal 5 file PDF
                    </p>

                    <input
                        type="file"
                        name="cvs[]"
                        multiple
                        accept=".pdf"
                        class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-3 file:px-5
                        file:rounded-2xl
                        file:border-0
                        file:text-sm
                        file:font-semibold
                        file:bg-green-100
                        file:text-green-700
                        hover:file:bg-green-200"
                        required>

                </div>

            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                :disabled="loading"
                class="w-full bg-gradient-to-r from-green-700 to-emerald-600 hover:opacity-90 text-white py-4 rounded-2xl font-bold text-lg transition-all shadow-lg flex justify-center items-center">

                <span x-show="!loading">
                    Analisis Kandidat dengan AI
                </span>

                <span x-show="loading" class="flex items-center">

                    <svg class="animate-spin h-5 w-5 mr-3"
                        viewBox="0 0 24 24">

                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4">
                        </circle>

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8H4z">
                        </path>

                    </svg>

                    AI sedang menganalisis CV...

                </span>

            </button>

        </form>

    </div>

    <!-- RESULT -->
    @if(session('ai_results'))

    <div>

        <div class="flex items-center gap-3 mb-6">

            <div class="w-2 h-8 rounded-full bg-green-600"></div>

            <h2 class="text-2xl font-bold text-gray-800">
                Hasil Analisis AI
            </h2>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            @foreach(session('ai_results') as $index => $candidate)

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all p-6">

                <!-- Rank -->
                <div class="flex items-center justify-between mb-5">

                    <div class="text-sm font-bold text-gray-500">
                        Ranking #{{ $index + 1 }}
                    </div>

                    @if(($candidate['status'] ?? '') == 'Recommended')

                        <div class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">
                            Recommended
                        </div>

                    @elseif(($candidate['status'] ?? '') == 'Low Match')

                        <div class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-semibold">
                            Low Match
                        </div>

                    @else

                        <div class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-semibold">
                            Not Recommended
                        </div>

                    @endif

                </div>

                <!-- Name -->
                <h3 class="text-xl font-bold text-gray-800">
                    {{ $candidate['name'] ?? 'Kandidat' }}
                </h3>

                <!-- Score -->
                <div class="mt-5">

                    <div class="flex justify-between text-sm mb-2">

                        <span class="text-gray-500">
                            AI Match Score
                        </span>

                        <span class="font-bold text-green-700">
                            {{ $candidate['score'] ?? 0 }}/100
                        </span>

                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-3">
                        @php

                        $barColor = 'bg-red-500';

                        if(($candidate['status'] ?? '') == 'Recommended'){
                            $barColor = 'bg-green-600';
                        }
                        elseif(($candidate['status'] ?? '') == 'Low Match'){
                            $barColor = 'bg-yellow-500';
                        }

                        @endphp

                        <div
                            class="{{ $barColor }} h-3 rounded-full"
                            style="width: {{ $candidate['score'] ?? 0 }}%">
                        </div>

                    </div>

                </div>

                <!-- IPK -->
                <div class="mt-5">

                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-semibold">
                        IPK : {{ $candidate['ipk'] ?? '-' }}
                    </span>

                </div>

                <!-- Insight -->
                <div class="mt-5">

                    <p class="text-gray-600 text-sm italic leading-relaxed">
                        "{{ $candidate['insight'] ?? '-' }}"
                    </p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

    @endif

</div>

@endsection