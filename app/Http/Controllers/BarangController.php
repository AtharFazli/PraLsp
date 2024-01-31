<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::orderBy('id', 'asc')->get();
        return view('dashboard.barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'       => 'required|string',
            'jumlah_barang'     => 'required|numeric',
            'harga_barang'      => 'required|numeric',
            'gambar_barang'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $namaFile = $request->file('gambar_barang')->getClientOriginalName();
        
        $request->file('gambar_barang')->move(public_path('gambar'), $namaFile);

        $barang = Barang::create([
            'nama_barang'       => $request->nama_barang,
            'jumlah_barang'     => $request->jumlah_barang,
            'harga_barang'      => $request->harga_barang,
            'gambar_barang'     => 'gambar/' . $namaFile
        ]);

        // return $barang;


        return to_route('barang.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
