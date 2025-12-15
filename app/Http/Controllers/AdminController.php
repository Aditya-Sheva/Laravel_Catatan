<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::withCount('notes')->get();
        return view('admin.users', compact('users'));
    }

    public function userNotes($userId)
    {
        $user = User::findOrFail($userId);
        $notes = $user->notes()->paginate(10);
        return view('admin.user-notes', compact('user', 'notes'));
    }

    public function deleteNote($noteId)
    {
        $note = Note::findOrFail($noteId);
        $userId = $note->user_id;
        $note->delete();
        return redirect()->route('admin.user-notes', $userId)->with('success', 'Note berhasil dihapus.');
    }
}
