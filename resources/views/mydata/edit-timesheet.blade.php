@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Edit Timesheet B3
    </h1>

    <form action="{{ route('mydata.timesheet.update', $timesheet->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-5">

            <input type="date" name="tanggal"
                value="{{ $timesheet->tanggal_kegiatan }}"
                class="border rounded-2xl p-4">

            <input type="text" name="project"
                value="{{ $timesheet->project }}"
                class="border rounded-2xl p-4">

            <input type="text" name="lokasi"
                value="{{ $timesheet->lokasi }}"
                class="border rounded-2xl p-4">

            <input type="number" name="total_jam"
                value="{{ $timesheet->total_jam }}"
                class="border rounded-2xl p-4">

            <select
                name="claim_type"
                class="border rounded-2xl p-4">

                <option value="Perdiem" {{ $timesheet->claim_type == 'Perdiem' ? 'selected' : '' }}>
                    Perdiem
                </option>

                <option value="Uang Makan" {{ $timesheet->claim_type == 'Uang Makan' ? 'selected' : '' }}>
                    Uang Makan
                </option>

                <option value="Actual Cost" {{ $timesheet->claim_type == 'Actual Cost' ? 'selected' : '' }}>
                    Actual Cost
                </option>

            </select>

        </div>

        <textarea
            name="aktivitas"
            rows="5"
            class="w-full border rounded-2xl p-4 mt-5">{{ $timesheet->aktivitas }}</textarea>

        <button
            class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-2xl mt-6 font-semibold">

            Update Timesheet

        </button>

    </form>

</div>

@endsection