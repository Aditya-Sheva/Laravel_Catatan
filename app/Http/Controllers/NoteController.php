<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->latest()->get();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // validasi file gambar
        ]);

        // Proses upload gambar (jika ada)
        $path = null;
        if ($request->hasFile('gambar')) {
            // Simpan ke storage/app/public/notes
            $path = $request->file('gambar')->store('notes', 'public');
        }

        // Simpan data ke database
        Note::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'content' => $request->content,
            'gambar'  => $path, // simpan path gambar ke kolom 'gambar'
        ]);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil ditambahkan!');
    }


    public function edit(Note $note)
    {
        // Pastikan hanya pemilik catatan yang bisa edit
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diperbarui!');
    }

    public function show(Note $note)
    {
        // Pastikan hanya pemilik catatan yang bisa melihat
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke catatan ini.');
        }

        return view('notes.show', compact('note'));
    }



    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus!');
    }

    public function show($id)
    {
        // Ambil catatan berdasarkan ID
        $note = Note::findOrFail($id);

        // Kirim data ke view show.blade.php
        return view('notes.show', compact('note'));
    }

}
