<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        return view('admin.users', [
            'users' => User::all()
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string'
        ]);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Role updated successfully');
    }
}