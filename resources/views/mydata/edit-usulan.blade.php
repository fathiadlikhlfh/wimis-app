@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Edit Usulan B1
    </h1>

    <form action="{{ route('mydata.usulan.update', $proposal->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-5">

            <input type="text" name="judul_kegiatan"
                value="{{ $proposal->judul_kegiatan }}"
                class="border rounded-2xl p-4">

            <input type="text" name="project_code"
                value="{{ $proposal->project_code }}"
                class="border rounded-2xl p-4">

            <input type="text" name="lokasi"
                value="{{ $proposal->lokasi }}"
                class="border rounded-2xl p-4">

            <input type="date" name="tanggal_mulai"
                value="{{ $proposal->tanggal_mulai }}"
                class="border rounded-2xl p-4">

            <input type="date" name="tanggal_selesai"
                value="{{ $proposal->tanggal_selesai }}"
                class="border rounded-2xl p-4">

        </div>

        <textarea
            name="deskripsi"
            rows="5"
            class="w-full border rounded-2xl p-4 mt-5">{{ $proposal->deskripsi }}</textarea>

        <button
            class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-2xl mt-6 font-semibold">

            Update Usulan

        </button>

    </form>

</div>

@endsection