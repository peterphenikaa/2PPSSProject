<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class AdminStoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $stores = $query->orderByDesc('created_at')->paginate(10);
        $provinces = Store::select('province')->distinct()->pluck('province');
        $statuses = Store::select('status')->distinct()->pluck('status');
        return view('admin.stores.index', compact('stores', 'provinces', 'statuses'));
    }
    public function create() {
        $provinces = Store::select('province')->distinct()->pluck('province');
        $statuses = Store::select('status')->distinct()->pluck('status');
        return view('admin.stores.create', compact('provinces', 'statuses'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_hours' => 'nullable',
            'status' => 'required',
        ]);
        Store::create($validated);
        return redirect()->route('admin.stores.index')->with('success', 'Thêm cửa hàng thành công!');
    }
    public function edit($id) {
        $store = Store::findOrFail($id);
        $provinces = Store::select('province')->distinct()->pluck('province');
        $statuses = Store::select('status')->distinct()->pluck('status');
        return view('admin.stores.edit', compact('store', 'provinces', 'statuses'));
    }
    public function update(Request $request, $id) {
        $store = Store::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_hours' => 'nullable',
            'status' => 'required',
        ]);
        $store->update($validated);
        return redirect()->route('admin.stores.index')->with('success', 'Cập nhật cửa hàng thành công!');
    }
    public function destroy($id) {
        $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Xóa cửa hàng thành công!');
    }
} 