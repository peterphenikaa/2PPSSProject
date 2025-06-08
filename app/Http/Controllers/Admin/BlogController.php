<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();
        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        $blogs = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.blog', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'required|image|max:2048', // Bắt buộc phải có ảnh
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
        }
        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status ?? 'draft',
            'author_id' => Auth::id(),
        ]);
        return redirect()->route('admin.blog.index')->with('success', 'Tạo bài viết thành công!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog-edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = $request->only(['title', 'content', 'status']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog_images', 'public');
        }
        $data['slug'] = Str::slug($request->title);
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Đã xóa bài viết!');
    }
}
