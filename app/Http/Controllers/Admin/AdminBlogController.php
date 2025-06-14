<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();
        if ($request->filled('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $blogs = $query->orderByDesc('created_at')->paginate(10);
        $statuses = Blog::select('status')->distinct()->pluck('status');
        return view('admin.blogs.index', compact('blogs', 'statuses'));
    }
    public function create() {
        $statuses = Blog::select('status')->distinct()->pluck('status');
        return view('admin.blogs.create', compact('statuses'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|string',
            'status' => 'required',
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = auth()->id() ?? 1;
        Blog::create($validated);
        return redirect()->route('admin.blogs.index')->with('success', 'Thêm bài viết thành công!');
    }
    public function edit($id) {
        $blog = Blog::findOrFail($id);
        $statuses = Blog::select('status')->distinct()->pluck('status');
        return view('admin.blogs.edit', compact('blog', 'statuses'));
    }
    public function update(Request $request, $id) {
        $blog = Blog::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|string',
            'status' => 'required',
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        $blog->update($validated);
        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật bài viết thành công!');
    }
    public function destroy($id) {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa bài viết thành công!');
    }
} 