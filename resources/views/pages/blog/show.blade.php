@php
    use App\Services\SeoService;
    $seoService = new SeoService();
@endphp

@extends('layouts.app')

@push('seo_tags')
    <!-- Blog Post SEO Tags -->
    <link rel="canonical" href="{{ route('blog.show', $post->slug) }}">
    <meta name="description" content="{{ $post->excerpt ? Str::limit($post->excerpt, 160) : Str::limit(strip_tags($post->body), 160) }}">
    <meta name="keywords" content="{{ $post->title }}, blog, hakami, dawae, Pakistan">
    <meta name="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
    <meta name="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $post->author->name ?? 'Admin' }}">
    
    <!-- Blog-specific Open Graph -->
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt ? Str::limit($post->excerpt, 160) : Str::limit(strip_tags($post->body), 160) }}">
    <meta property="og:image" content="{{ $post->featured_image }}">
    <meta property="og:url" content="{{ route('blog.show', $post->slug) }}">
    <meta property="og:type" content="article">
    
    <!-- Hreflang for Urdu/English -->
    <link rel="alternate" hreflang="en" href="{{ url('/en/blog/' . $post->slug) }}">
    <link rel="alternate" hreflang="ur" href="{{ url('/ur/blog/' . $post->slug) }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/blog/' . $post->slug) }}">
    
    <!-- Article Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {!! json_encode($seoService->generateArticleSchema($post), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    
    <!-- Breadcrumb Structured Data -->
    <script type="application/ld+json">
    {!! json_encode($seoService->generateBreadcrumbSchema([
        __('Home') => route('home'),
        __('Blog') => route('blog.index'),
        $post->category->name => route('blog.index', ['category' => $post->category->slug]),
        $post->title => route('blog.show', $post->slug)
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <div class="pt-5 mt-5 bg-light pb-4 border-bottom">
        <div class="container pt-4 text-center">
            @if($post->category)
                <span class="badge bg-secondary-custom px-3 py-2 text-uppercase mb-3 shadow-sm rounded-pill">{{ $post->category->name }}</span>
            @endif
            <h1 class="playfair display-4 mb-4 lh-sm col-lg-8 mx-auto">{{ $post->title }}</h1>
            <div class="d-flex justify-content-center align-items-center gap-4 text-muted">
                <span><i class="far fa-user me-2"></i> {{ $post->author->name ?? 'Admin' }}</span>
                <span><i class="far fa-calendar me-2"></i> {{ $post->published_at->format('F j, Y') }}</span>
                <span><i class="far fa-eye me-2"></i> {{ $post->views }} {{ __('Views') }}</span>
            </div>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100">
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-5">
                    <img src="{{ str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image) }}" class="w-100 rounded-4 shadow object-fit-cover" style="height: 500px;" alt="{{ $post->title }}">
                </div>
                
                <div class="col-lg-8">
                    <div class="fs-5 lh-lg text-dark mb-5" style="opacity: 0.9;">
                        {!! nl2br(e($post->body)) !!}
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-4 border-top border-bottom mb-5">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold">{{ __('Share this post:') }}</span>
                            <a href="#" class="btn btn-outline-dark rounded-circle" style="width:40px;height:40px;padding:0;line-height:38px;"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-dark rounded-circle" style="width:40px;height:40px;padding:0;line-height:38px;"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-dark rounded-circle" style="width:40px;height:40px;padding:0;line-height:38px;"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>

                    @if($relatedPosts->count() > 0)
                        <h3 class="playfair mb-4">{{ __('Related Articles') }}</h3>
                        <div class="row g-4">
                            @foreach($relatedPosts as $related)
                                <div class="col-md-6">
                                    @include('partials.blog-card', ['post' => $related])
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
