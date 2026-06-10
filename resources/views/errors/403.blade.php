@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100 text-center">

        <div class="text-7xl mb-6">
            ⛔
        </div>

        <h1 class="text-3xl font-bold text-red-600">
            Unauthorized Access
        </h1>

        <p class="text-gray-500 mt-3 max-w-xl mx-auto leading-relaxed">
            Anda tidak memiliki hak akses untuk membuka halaman ini.
        </p>

        <p class="text-gray-500 mt-2 max-w-xl mx-auto leading-relaxed">
            Silakan hubungi Coordinator atau Administrator apabila Anda membutuhkan akses ke fitur ini.
        </p>

        <div class="mt-8 flex justify-center gap-3">

            <a href="{{ url()->previous() }}"
               class="px-6 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">

                ← Kembali

            </a>

            <a href="{{ route('dashboard') }}"
               class="px-6 py-3 rounded-2xl bg-green-600 hover:bg-green-700 text-white font-semibold transition">

                Dashboard

            </a>

        </div>

    </div>

</div>

@endsection