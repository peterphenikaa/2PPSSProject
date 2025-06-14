@extends('layouts.layouts')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Quản lý Blog</h1>
        <a href="{{ route('admin.blogs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">+ Thêm bài viết</a>
    </div>
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tiêu đề</label>
            <input type="text" name="title" value="{{ request('title') }}" class="border rounded px-3 py-2 w-48">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
            <select name="status" class="border rounded px-3 py-2 w-40">
                <option value="">Tất cả</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @if(request('status') == $status) selected @endif>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-900 transition">Lọc</button>
    </form>
    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Tiêu đề</th>
                    <th class="p-3 text-left">Ảnh</th>
                    <th class="p-3 text-left">Trạng thái</th>
                    <th class="p-3 text-left">Ngày đăng</th>
                    <th class="p-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr class="border-b">
                    <td class="p-3">{{ $blog->id }}</td>
                    <td class="p-3 font-semibold">{{ $blog->title }}</td>
                    <td class="p-3">
                        @if($blog->image && file_exists(public_path('images/' . $blog->image)))
                            <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-16 h-12 object-cover rounded">
                        @else
                            <span class="text-gray-400">Không có ảnh</span>
                        @endif
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $blog->status == 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ ucfirst($blog->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $blog->created_at ? $blog->created_at->format('d/m/Y') : '' }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">Sửa</a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $blogs->links('pagination::tailwind') }}
    </div>
</div>
@endsection 