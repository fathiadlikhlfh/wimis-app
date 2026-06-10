<?php

namespace App\Http\Controllers;

use App\Models\DataKM;
use Illuminate\Http\Request;

class DataKMController extends Controller
{
    public function index(Request $request) {
        $query = DataKM::query();
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        $data = $query->get();
        return view('datakm.index', compact('data'));
    }

    public function create() { return view('datakm.create'); }

    public function store(Request $request) {
        $request->validate(['file_pdf' => 'required|mimes:pdf|max:5120']);
        $path = $request->file('file_pdf')->store('documents', 'public');
        
        DataKM::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'nama_penulis' => $request->nama_penulis,
            'tanggal_laporan' => $request->tanggal_laporan,
            'lokasi' => $request->lokasi,
            'project' => $request->project,
            'ringkasan' => $request->ringkasan,
            'file_path' => $path
        ]);
        
        return redirect()->route('datakm.index')->with('success', 'Dokumen berhasil disimpan');
    }

    public function show($id) {
        $item = DataKM::findOrFail($id);
        return view('datakm.show', compact('item'));
    }

    public function globalSearch(Request $request) {
        $keyword = $request->keyword;
        $data = DataKM::where('judul', 'LIKE', "%$keyword%")
                      ->orWhere('ringkasan', 'LIKE', "%$keyword%")
                      ->orWhere('nama_penulis', 'LIKE', "%$keyword%")->get();
        return view('datakm.index', compact('data'));
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->keyword;

        $data = DataKM::where('judul', 'LIKE', "%{$keyword}%")
            ->orWhere('ringkasan', 'LIKE', "%{$keyword}%")
            ->orWhere('nama_penulis', 'LIKE', "%{$keyword}%")
            ->limit(5)
            ->get();

        return response()->json($data);
    }
}