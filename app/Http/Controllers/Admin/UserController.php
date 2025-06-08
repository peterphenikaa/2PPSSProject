<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;

class UserController
{
    public function user()
    {
        $users = User::where('role','user')->get()->map(function ($user) {
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => optional($user->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($user->updated_at)->format('Y-m-d H:i:s'),
            ];
        })->toArray();
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
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => optional($user->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => optional($user->updated_at)->format('Y-m-d H:i:s'),
                ];
            })->toArray();
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
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('admin.user')->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user')->with('success', 'Xóa tài khoản thành công!');
    }
}
