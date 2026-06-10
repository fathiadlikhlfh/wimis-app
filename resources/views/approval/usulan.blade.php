@extends('layouts.app')
@section('content')
@foreach($proposals as $p)
<div class="bg-white p-4 mb-3 rounded shadow flex justify-between">
    <div>
        <p class="font-bold">{{ $p->judul_kegiatan }}</p>
        <p class="text-sm text-gray-600">Oleh: {{ $p->user->name }}</p>
    </div>
    <form action="{{ route('approval.update', $p->id) }}" method="POST">
        @csrf @method('PATCH')
        <button name="status" value="Approved" class="bg-green-600 text-white px-3 py-1 rounded">Approve</button>
        <button name="status" value="Rejected" class="bg-red-600 text-white px-3 py-1 rounded">Reject</button>
    </form>
</div>
@endforeach
@endsection