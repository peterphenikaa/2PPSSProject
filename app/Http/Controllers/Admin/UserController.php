<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;

class UserController
{
    public function user()
    {
        $users = User::where('role','user')->latest()->paginate(10);
        return view('admin.user',compact('users'));
    }
    public function search(Request $request)
    {
        $q = $request->input('q');
        $users = User::where('role', 'user')
            ->where(function ($query) use ($q) {
                $query->where('id', 'like', "%$q%")
                    ->orWhere('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%") ;
            })
            ->latest()
            ->paginate(10);
        return view('admin.user', [
            'users' => $users,
        ]);
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        return redirect()->route('admin.user')->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user')->with('success', 'Xóa tài khoản thành công!');
    }
}
