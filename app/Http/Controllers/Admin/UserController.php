<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing user role.
     */
    public function edit(User $user)
    {
        $roles = ['user', 'admin'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the user's role.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        return back()->with('success', "User role updated from {$oldRole} to {$request->role}");
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        $userName = $user->name;
        $user->delete();

        return back()->with('success', "User {$userName} has been deleted");
    }

    /**
     * Bulk delete users.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => 'required',
        ]);

        $ids = is_string($request->user_ids) ? json_decode($request->user_ids, true) : $request->user_ids;

        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No users selected');
        }

        $count = User::whereIn('id', $ids)->delete();

        return back()->with('success', "{$count} user(s) deleted successfully");
    }
}
