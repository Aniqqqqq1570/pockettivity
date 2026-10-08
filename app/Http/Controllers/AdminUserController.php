<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function makeAdmin(User $user)
    {
        $user->role = 'admin';

        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil dijadikan admin.');
    }

    public function makeUser(User $user)
    {
        if ((int) $user->id === (int) Auth::id()) {
            return redirect()->route('admin.users')
                ->with('error', 'Kamu tidak dapat menghapus role admin sendiri.');
        }

        $user->role = 'user';

        $user->save();

        return redirect()->route('admin.users')
            ->with('success', 'Admin berhasil dijadikan user.');
    }
}
