<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GambarController extends Controller
{
    public function index()
    {
        $gambars = Gambar::latest()->get();
        return view('gambars.index', compact('gambars'));
    }

    public function create()
    {
        return view('gambars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('gambars', 'public');
        }

        Gambar::create([
            'judul' => $request->judul,
            'gambar' => $path,
        ]);

        return redirect()->route('gambars.index')->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function edit(Gambar $gambar)
    {
        return view('gambars.edit', compact('gambar'));
    }

    public function update(Request $request, Gambar $gambar)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $path = $gambar->gambar;

        if ($request->hasFile('gambar')) {
            // hapus gambar lama
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            // upload baru
            $path = $request->file('gambar')->store('gambars', 'public');
        }

        $gambar->update([
            'judul' => $request->judul,
            'gambar' => $path,
        ]);

        return redirect()->route('gambars.index')->with('success', 'Gambar berhasil diperbarui!');
    }

    public function destroy(Gambar $gambar)
    {
        if ($gambar->gambar && Storage::disk('public')->exists($gambar->gambar)) {
            Storage::disk('public')->delete($gambar->gambar);
        }

        $gambar->delete();

        return redirect()->route('gambars.index')->with('success', 'Gambar berhasil dihapus!');
    }
}
