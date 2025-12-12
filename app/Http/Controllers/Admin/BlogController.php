<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\ImageService;

class BlogController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = Blog::query();
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
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
            $imagePath = $this->imageService->upload($request->file('image'), 'blogs');
        }

        Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status ?? 'draft',
            'author_id' => Auth::id(),
        ]);

        Cache::forget('featured_blogs');
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
            // Xóa ảnh cũ trên MinIO
            if ($blog->image) {
                $this->imageService->delete($blog->image);
            }
            // Upload ảnh mới
            $data['image'] = $this->imageService->upload($request->file('image'), 'blogs');
        }

        $data['slug'] = Str::slug($request->title);
        $blog->update($data);

        Cache::forget('featured_blogs');
        return redirect()->route('admin.blog.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Xóa ảnh trên MinIO
        if ($blog->image) {
            $this->imageService->delete($blog->image);
        }

        $blog->delete();

        Cache::forget('featured_blogs');
        return redirect()->route('admin.blog.index')->with('success', 'Đã xóa bài viết!');
    }
}
