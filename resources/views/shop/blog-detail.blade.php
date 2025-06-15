@extends('layouts.layouts')

@section('content')
<div class="bg-white min-h-screen py-0 px-0 font-sans">
    <div class="max-w-6xl mx-auto">
        <div class="pt-12 pb-0 px-0">
            <div class="text-gray-400 text-base mb-2 px-2 md:px-0">
                @if($blog->created_at)
                    {{ \Carbon\Carbon::parse($blog->created_at)->format('d F Y') }}
                @else
                    Không rõ
                @endif
            </div>
            <h1 class="text-gray-900 font-extrabold text-5xl md:text-7xl leading-tight mb-10 px-2 md:px-0" style="word-break:break-word; letter-spacing:-2px;">{{ $blog->title }}</h1>
        </div>
        <div class="w-full flex flex-col md:flex-row md:gap-8 md:items-start mb-12">
            <div class="md:w-2/3 w-full flex-shrink-0">
                @if($blog->image)
                    <img src="{{ asset('images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full max-h-[480px] object-cover object-center rounded-lg shadow-lg transition-transform duration-300 hover:scale-105" loading="lazy">
                @else
                    <div class="w-full h-80 bg-gray-100 flex items-center justify-center rounded-lg shadow-lg">
                        <span class="material-icons-round text-gray-400 text-6xl">image_not_supported</span>
                    </div>
                @endif
            </div>
            <div class="md:w-1/3 w-full flex flex-col justify-center">
                <div class="bg-gray-50 rounded-xl shadow-lg p-8 mt-8 md:mt-0 md:ml-0 mx-2 md:mx-0">
                    <h2 class="text-xl font-bold mb-4 text-gray-900">What to know</h2>
                    <ul class="list-disc text-base text-gray-700 pl-5 space-y-3">
                        <li>Demo giao diện blog lấy cảm hứng từ Nike Newsroom.</li>
                        <li>Ảnh lớn, box nổi bật, nhiều khoảng trắng.</li>
                        <li>Tiêu đề cực lớn, font sans-serif hiện đại.</li>
                        <li>Box này có thể thêm các điểm nhấn, tóm tắt, bullet point.</li>
                        <li>Giao diện tối giản, tinh tế, dễ đọc.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bg-white px-8 py-12 mt-0 max-w-6xl mx-auto rounded-xl shadow-sm">
            <article class="prose prose-lg max-w-none text-gray-900 leading-relaxed">
                {!! $blog->content !!}
                <blockquote class="border-l-4 border-gray-400 pl-4 italic text-gray-700 mt-8">“Chúng tôi luôn nghiên cứu kỹ môi trường sử dụng thực tế để tạo ra sản phẩm phù hợp nhất cho người dùng.”</blockquote>
            </article>
        </div>
    </div>
</div>
@endsection

@section('meta_title', $blog->title)
@section('meta_description', Str::limit(strip_tags($blog->content), 150))
@section('meta_image', asset('images/' . $blog->image)) 