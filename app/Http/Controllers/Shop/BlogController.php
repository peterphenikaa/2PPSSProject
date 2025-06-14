<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query()->where('status', 'published');
        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }
        $blogs = $query->orderByDesc('created_at')->paginate(9);
        return view('shop.blog', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('shop.blog-detail', compact('blog'));
    }
}
