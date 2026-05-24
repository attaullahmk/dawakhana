@extends('layouts.app')

@push('styles')
<style>
:root {
    --blog-green: #17382b;
    --blog-green-light: #2d6a4f;
    --blog-gold: #c8a165;
    --blog-gold-light: #e2c08d;
    --blog-ink: #1f2d26;
    --blog-muted: #6f7d73;
    --blog-line: rgba(26, 60, 46, 0.12);
    --blog-soft: #f8f5f0;
    --blog-shadow: 0 22px 54px rgba(26, 60, 46, 0.13);
}

.blog-page {
    min-height: 100vh;
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45, 106, 79, 0.1), transparent 28%),
        radial-gradient(circle at 92% 18%, rgba(200, 161, 101, 0.13), transparent 24%),
        linear-gradient(180deg, #fff 0%, var(--blog-soft) 100%);
}

.blog-hero {
    position: relative;
    min-height: 360px;
    display: flex;
    align-items: center;
    margin-top: 50px;
    color: #fff;
    background:
        linear-gradient(105deg, rgba(12, 24, 18, 0.95) 0%, rgba(23, 56, 43, 0.84) 58%, rgba(45, 106, 79, 0.58) 100%),
        url('https://images.unsplash.com/photo-1471864190281-a93a3070b6de?q=80&w=1920&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
}

.blog-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 94px;
    background: linear-gradient(180deg, transparent, rgba(248, 245, 240, 0.98));
}

.blog-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
    padding: 92px 0 124px;
}

.blog-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226, 192, 141, 0.42);
    border-radius: 50px;
    background: rgba(200, 161, 101, 0.14);
    color: var(--blog-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.blog-hero h1,
.blog-section-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.blog-hero p {
    max-width: 660px;
    color: rgba(255, 255, 255, 0.84);
    line-height: 1.8;
}

.blog-stat-row {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    max-width: 560px;
    margin-top: 28px;
}

.blog-stat {
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    padding: 14px;
}

.blog-stat strong {
    display: block;
    font-size: 1.2rem;
    color: #fff;
}

.blog-stat span {
    color: rgba(255, 255, 255, 0.72);
    font-size: 0.76rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.blog-shell {
    position: relative;
    z-index: 5;
    margin-top: -72px;
    padding-bottom: 82px;
}

.blog-toolbar {
    border: 1px solid var(--blog-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.92);
    box-shadow: var(--blog-shadow);
    padding: 18px;
    margin-bottom: 28px;
}

.blog-filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 16px;
}

.blog-filter-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 50px;
    color: var(--blog-green);
    background: rgba(200, 161, 101, 0.11);
    padding: 7px 12px;
    font-size: 0.75rem;
    font-weight: 900;
}

.blog-section-title {
    position: relative;
    display: inline-block;
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    padding-bottom: 12px;
    margin-bottom: 0;
    text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
}

.blog-section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 82px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, #2f7d4f, #d4a853);
    box-shadow: 0 8px 18px rgba(212, 168, 83, 0.28);
}

.blog-page .card-hover-lift {
    overflow: hidden;
    border: 1px solid var(--blog-line) !important;
    border-radius: 8px !important;
    background: #fff;
    box-shadow: 0 16px 36px rgba(26, 60, 46, 0.09) !important;
    transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
}

.blog-page .card-hover-lift:hover {
    transform: translateY(-6px);
    border-color: rgba(200, 161, 101, 0.38) !important;
    box-shadow: 0 24px 48px rgba(26, 60, 46, 0.14) !important;
}

.blog-page .card-hover-lift .card-img-top {
    transition: transform 0.45s ease;
}

.blog-page .card-hover-lift:hover .card-img-top {
    transform: scale(1.04);
}

.blog-page .card-hover-lift .badge {
    border-radius: 50px;
    background: linear-gradient(135deg, var(--blog-gold), var(--blog-green-light)) !important;
    box-shadow: 0 10px 24px rgba(26, 60, 46, 0.18);
}

.blog-card-modern {
    isolation: isolate;
}

.blog-card-media {
    height: 230px;
    background: var(--blog-soft);
}

.blog-card-image {
    width: 100%;
    height: 230px !important;
    transition: transform 0.45s ease;
}

.blog-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 40%, rgba(12, 24, 18, 0.64) 100%);
    pointer-events: none;
}

.blog-card-category,
.blog-card-readtime {
    position: absolute;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 900;
    padding: 8px 12px;
}

.blog-card-category {
    left: 14px;
    bottom: 14px;
    color: #fff;
    background: linear-gradient(135deg, var(--blog-gold), var(--blog-green-light));
    box-shadow: 0 10px 24px rgba(26, 60, 46, 0.18);
}

.blog-card-readtime {
    top: 14px;
    right: 14px;
    color: var(--blog-green);
    background: rgba(255, 255, 255, 0.92);
}

.blog-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    color: var(--blog-muted);
    font-size: 0.78rem;
    font-weight: 800;
    margin-bottom: 12px;
}

.blog-card-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.blog-card-title a {
    color: var(--blog-ink);
    transition: color 0.22s ease;
}

.blog-card-title a:hover {
    color: var(--blog-green-light);
}

.blog-card-excerpt {
    line-height: 1.7;
}

.blog-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    border-top: 1px solid rgba(26, 60, 46, 0.08);
    padding-top: 16px;
}

.blog-card-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--blog-green);
    font-size: 0.78rem;
    font-weight: 900;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    text-decoration: none;
}

.blog-card-link:hover {
    color: var(--blog-gold);
}

.blog-card-dot {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: var(--blog-green);
    background: rgba(200, 161, 101, 0.12);
}

.blog-page .card-title a {
    color: var(--blog-ink) !important;
    transition: color 0.22s ease;
}

.blog-page .card-title a:hover {
    color: var(--blog-green-light) !important;
}

.blog-featured {
    overflow: hidden;
    border: 1px solid var(--blog-line);
    border-radius: 8px;
    background: #fff;
    box-shadow: var(--blog-shadow);
    margin-bottom: 28px;
}

.blog-featured-img {
    width: 100%;
    height: 100%;
    min-height: 340px;
    object-fit: cover;
}

.blog-featured-body {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: clamp(24px, 4vw, 38px);
}

.blog-featured-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: fit-content;
    border-radius: 50px;
    color: var(--blog-green);
    background: rgba(200, 161, 101, 0.13);
    padding: 8px 13px;
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.blog-featured-title {
    color: var(--blog-ink);
    text-decoration: none;
    transition: color 0.22s ease;
}

.blog-featured-title:hover {
    color: var(--blog-green-light);
}

.blog-meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    color: var(--blog-muted);
    font-size: 0.82rem;
    margin-bottom: 12px;
}

.blog-sidebar {
    position: sticky;
    top: 96px;
}

.blog-widget {
    overflow: hidden;
    border: 1px solid var(--blog-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.94);
    box-shadow: 0 16px 36px rgba(26, 60, 46, 0.09);
}

.blog-widget + .blog-widget {
    margin-top: 24px;
}

.blog-newsletter {
    color: #fff;
    background:
        linear-gradient(145deg, rgba(23, 56, 43, 0.96), rgba(45, 106, 79, 0.92)),
        url('https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=900&auto=format&fit=crop') center/cover;
}

.blog-newsletter .blog-widget-header {
    color: #fff;
}

.blog-newsletter p {
    color: rgba(255, 255, 255, 0.76);
    line-height: 1.7;
}

.blog-newsletter-form {
    display: flex;
    gap: 8px;
    padding: 7px;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
}

.blog-newsletter-input {
    min-height: 48px;
    flex: 1 1 auto;
    border: 0;
    outline: 0;
    border-radius: 8px;
    color: var(--blog-green);
    background: rgba(255, 255, 255, 0.95);
    padding: 12px 13px;
}

.blog-newsletter-btn {
    border: 0;
    border-radius: 8px;
    color: var(--blog-green);
    background: linear-gradient(135deg, var(--blog-gold), var(--blog-gold-light));
    font-weight: 900;
    padding: 12px 15px;
    white-space: nowrap;
}

.blog-newsletter-message {
    min-height: 18px;
    color: var(--blog-gold-light);
    font-size: 0.78rem;
    font-weight: 800;
    margin-top: 10px;
}

.blog-widget-header {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--blog-green);
    margin-bottom: 18px;
}

.blog-widget-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 38px;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--blog-green), var(--blog-green-light));
}

.blog-search-control {
    min-height: 52px;
    border: 1px solid rgba(26, 60, 46, 0.12) !important;
    border-radius: 8px 0 0 8px !important;
    color: var(--blog-ink) !important;
    background: #fff !important;
    box-shadow: none !important;
}

.blog-search-control:focus {
    border-color: rgba(200, 161, 101, 0.72) !important;
    box-shadow: 0 0 0 4px rgba(200, 161, 101, 0.14) !important;
}

.blog-search-btn {
    min-width: 54px;
    border: 0;
    border-radius: 0 8px 8px 0 !important;
    color: #fff;
    background: linear-gradient(135deg, var(--blog-green), var(--blog-green-light));
}

.blog-category-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    border: 1px solid transparent;
    border-radius: 8px;
    color: var(--blog-muted);
    padding: 10px 12px;
    text-decoration: none;
    transition: color 0.22s ease, background 0.22s ease, border-color 0.22s ease, transform 0.22s ease;
}

.blog-category-link:hover,
.blog-category-link.active {
    color: var(--blog-green);
    border-color: rgba(200, 161, 101, 0.24);
    background: rgba(200, 161, 101, 0.11);
    transform: translateX(3px);
}

.blog-category-count {
    min-width: 30px;
    text-align: center;
    border-radius: 50px;
    color: var(--blog-green);
    background: rgba(45, 106, 79, 0.08);
    padding: 4px 8px;
    font-size: 0.72rem;
    font-weight: 900;
}

.blog-recent-item {
    display: flex;
    gap: 13px;
    align-items: center;
    padding-bottom: 16px;
    margin-bottom: 16px;
    border-bottom: 1px solid rgba(26, 60, 46, 0.1);
}

.blog-recent-item:last-child {
    padding-bottom: 0;
    margin-bottom: 0;
    border-bottom: 0;
}

.blog-recent-img {
    width: 74px;
    height: 74px;
    flex: 0 0 74px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 10px 22px rgba(26, 60, 46, 0.12);
}

.blog-recent-title {
    color: var(--blog-ink);
    line-height: 1.35;
    transition: color 0.22s ease;
}

.blog-recent-title:hover {
    color: var(--blog-green-light);
}

.blog-empty {
    border: 1px dashed rgba(26, 60, 46, 0.18);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.78);
    padding: 56px 22px;
}

.blog-clear-link,
.blog-read-link {
    color: var(--blog-green);
    font-weight: 900;
    text-decoration: none;
}

.blog-clear-link:hover,
.blog-read-link:hover {
    color: var(--blog-gold);
}

@media (max-width: 991.98px) {
    .blog-hero {
        margin-top: 0;
        min-height: auto;
    }

    .blog-hero-content {
        padding: 108px 0 96px;
    }

    .blog-shell {
        margin-top: 0;
        padding-top: 42px;
    }

    .blog-sidebar {
        position: static;
    }
}

@media (max-width: 575.98px) {
    .blog-hero h1 {
        font-size: 2.45rem;
    }

    .blog-stat-row {
        grid-template-columns: 1fr;
    }

    .blog-featured-img {
        min-height: 220px;
    }

    .blog-newsletter-form {
        flex-direction: column;
    }

    .blog-newsletter-btn {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
@php
    $featuredPost = $posts->getCollection()->first();
    $gridPosts = $posts->getCollection()->slice(1);
@endphp

<main class="blog-page">
    <section class="blog-hero">
        <div class="container">
            <div class="blog-hero-content">
                <span class="blog-badge">
                    <i class="fas fa-leaf"></i>
                    {{ __('Dawakhana Journal') }}
                </span>
                <h1 class="display-4 mb-3">{{ __('Herbal Wellness Insights') }}</h1>
                <p class="lead mb-0">
                    {{ __('Explore natural care guides, Hakimi wisdom, product education, and practical tips for a healthier daily routine.') }}
                </p>

                <div class="blog-stat-row">
                    <div class="blog-stat">
                        <strong>{{ $posts->total() }}</strong>
                        <span>{{ __('Articles') }}</span>
                    </div>
                    <div class="blog-stat">
                        <strong>{{ $categories->count() }}</strong>
                        <span>{{ __('Topics') }}</span>
                    </div>
                    <div class="blog-stat">
                        <strong>{{ $recentPosts->count() }}</strong>
                        <span>{{ __('Recent') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-shell">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    <div class="blog-toolbar d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h2 class="blog-section-title h1">{{ __('Latest Articles') }}</h2>
                            <p class="text-muted mb-0 mt-2">
                                @if(request('search') || request('category'))
                                    {{ __('Filtered wellness articles for your search.') }}
                                @else
                                    {{ __('Fresh guides and natural wellness notes from Dawakhana.') }}
                                @endif
                            </p>

                            @if(request('search') || request('category'))
                                <div class="blog-filter-pills">
                                    @if(request('search'))
                                        <span class="blog-filter-pill">
                                            <i class="fas fa-search"></i>{{ __('Search') }}: {{ request('search') }}
                                        </span>
                                    @endif
                                    @if(request('category'))
                                        <span class="blog-filter-pill">
                                            <i class="fas fa-tag"></i>{{ __('Category') }}: {{ request('category') }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if(request('search') || request('category'))
                            <a href="{{ route('blog.index') }}" class="blog-clear-link small">
                                <i class="fas fa-times me-1"></i>{{ __('Clear Filters') }}
                            </a>
                        @endif
                    </div>

                    @if($featuredPost)
                        <article class="blog-featured" data-aos="fade-up">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                        <img src="{{ str_starts_with($featuredPost->featured_image, 'http') ? $featuredPost->featured_image : asset($featuredPost->featured_image) }}" class="blog-featured-img" alt="{{ $featuredPost->title }}">
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <div class="blog-featured-body">
                                        <span class="blog-featured-label">
                                            <i class="fas fa-star"></i>{{ __('Featured Read') }}
                                        </span>
                                        <div class="blog-meta-row">
                                            @if($featuredPost->category)
                                                <span><i class="fas fa-leaf me-1"></i>{{ $featuredPost->category->name }}</span>
                                            @endif
                                            <span><i class="far fa-calendar-alt me-1"></i>{{ $featuredPost->published_at->format('M d, Y') }}</span>
                                        </div>
                                        <h3 class="playfair fw-bold mb-3">
                                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="blog-featured-title">
                                                {{ $featuredPost->title }}
                                            </a>
                                        </h3>
                                        <p class="text-muted mb-4">{{ Str::limit($featuredPost->excerpt, 150) }}</p>
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="blog-read-link text-uppercase small">
                                            {{ __('Read Featured Article') }} <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endif

                    <div class="row g-4">
                        @if($gridPosts->isNotEmpty())
                            @foreach($gridPosts as $post)
                                <div class="col-md-6" data-aos="fade-up">
                                    @include('partials.blog-card', ['post' => $post])
                                </div>
                            @endforeach
                        @elseif(!$featuredPost)
                            <div class="col-12">
                                <div class="blog-empty text-center">
                                    <i class="fas fa-magnifying-glass fa-2x mb-3" style="color: var(--blog-gold);"></i>
                                    <h3 class="playfair fw-bold mb-2">{{ __('No posts found.') }}</h3>
                                    <p class="text-muted mb-3">{{ __('Try a different keyword or browse all herbal wellness articles.') }}</p>
                                    <a href="{{ route('blog.index') }}" class="blog-read-link">{{ __('View all articles') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        <div class="blog-widget">
                            <div class="p-4">
                                <div class="blog-widget-header">
                                    <span class="blog-widget-icon"><i class="fas fa-search"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Search Journal') }}</h5>
                                </div>

                                <form action="{{ route('blog.index') }}" method="GET">
                                    @if(request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control blog-search-control" placeholder="{{ __('Search remedies, tips...') }}" value="{{ request('search') }}">
                                        <button class="btn blog-search-btn" type="submit" aria-label="{{ __('Search') }}">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>

                                @if(request('search'))
                                    <div class="mt-3 text-start">
                                        <a href="{{ route('blog.index', ['category' => request('category')]) }}" class="blog-clear-link small">
                                            <i class="fas fa-times me-1"></i>{{ __('Clear Search') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="blog-widget">
                            <div class="p-4">
                                <div class="blog-widget-header">
                                    <span class="blog-widget-icon"><i class="fas fa-layer-group"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Categories') }}</h5>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('blog.index', ['search' => request('search')]) }}" class="blog-category-link {{ !request('category') ? 'active' : '' }}">
                                        <span>{{ __('All Categories') }}</span>
                                        <span class="blog-category-count">{{ $categories->sum('posts_count') }}</span>
                                    </a>

                                    @foreach($categories as $category)
                                        <a href="{{ route('blog.index', ['category' => $category->slug, 'search' => request('search')]) }}" class="blog-category-link {{ request('category') == $category->slug ? 'active' : '' }}">
                                            <span>{{ $category->name }}</span>
                                            <span class="blog-category-count">{{ $category->posts_count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="blog-widget">
                            <div class="p-4">
                                <div class="blog-widget-header">
                                    <span class="blog-widget-icon"><i class="fas fa-clock"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Recent Posts') }}</h5>
                                </div>

                                @forelse($recentPosts as $recent)
                                    <div class="blog-recent-item">
                                        <img src="{{ str_starts_with($recent->featured_image, 'http') ? $recent->featured_image : asset($recent->featured_image) }}" class="blog-recent-img" alt="{{ $recent->title }}">
                                        <div>
                                            <h6 class="mb-1 fw-bold">
                                                <a href="{{ route('blog.show', $recent->slug) }}" class="blog-recent-title text-decoration-none d-block">
                                                    {{ Str::limit($recent->title, 44) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>{{ $recent->published_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">{{ __('No recent posts yet.') }}</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="blog-widget blog-newsletter">
                            <div class="p-4">
                                <div class="blog-widget-header">
                                    <span class="blog-widget-icon"><i class="fas fa-envelope-open-text"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Wellness Updates') }}</h5>
                                </div>
                                <p class="mb-3">{{ __('Get short herbal care tips, seasonal wellness notes, and Dawakhana updates in your inbox.') }}</p>
                                <form class="blog-newsletter-form" id="blogNewsletterForm" action="{{ route('subscribe') }}" method="POST">
                                    @csrf
                                    <input type="email" name="email" class="blog-newsletter-input" placeholder="{{ __('Email address') }}" required>
                                    <button type="submit" class="blog-newsletter-btn" id="blogNewsletterBtn">{{ __('Join') }}</button>
                                </form>
                                <div class="blog-newsletter-message" id="blogNewsletterMessage"></div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('blogNewsletterForm');
    var button = document.getElementById('blogNewsletterBtn');
    var message = document.getElementById('blogNewsletterMessage');

    if (!form || !button || !message) return;

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        var originalText = button.textContent;
        button.disabled = true;
        button.textContent = '{{ __('Joining...') }}';
        message.textContent = '';

        try {
            var response = await fetch(form.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            var data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || '{{ __('Please try again.') }}');
            }

            message.textContent = data.message || '{{ __('Thank you for subscribing.') }}';
            form.reset();
        } catch (error) {
            message.textContent = error.message || '{{ __('Something went wrong. Please try again.') }}';
        } finally {
            button.disabled = false;
            button.textContent = originalText;
        }
    });
});
</script>
@endpush
