@php
    use App\Services\SeoService;

    $seoService = new SeoService();
    $postUrl = route('blog.show', $post->slug);
    $postImage = str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image);
    $postDescription = $post->excerpt ? Str::limit($post->excerpt, 160) : Str::limit(strip_tags($post->body), 160);
    $readingMinutes = max(1, ceil(str_word_count(strip_tags($post->body)) / 180));
    $breadcrumbs = [
        __('Home') => route('home'),
        __('Blog') => route('blog.index'),
    ];

    if ($post->category) {
        $breadcrumbs[$post->category->name] = route('blog.index', ['category' => $post->category->slug]);
    }

    $breadcrumbs[$post->title] = $postUrl;
@endphp

@extends('layouts.app')

@push('seo_tags')
    <link rel="canonical" href="{{ $postUrl }}">
    <meta name="description" content="{{ $postDescription }}">
    <meta name="keywords" content="{{ $post->title }}, blog, hakami, dawae, Pakistan">
    <meta name="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
    <meta name="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $post->author->name ?? 'Admin' }}">

    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $postDescription }}">
    <meta property="og:image" content="{{ $postImage }}">
    <meta property="og:url" content="{{ $postUrl }}">
    <meta property="og:type" content="article">

    <link rel="alternate" hreflang="en" href="{{ url('/en/blog/' . $post->slug) }}">
    <link rel="alternate" hreflang="ur" href="{{ url('/ur/blog/' . $post->slug) }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/blog/' . $post->slug) }}">

    <script type="application/ld+json">
    {!! json_encode($seoService->generateArticleSchema($post), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    <script type="application/ld+json">
    {!! json_encode($seoService->generateBreadcrumbSchema($breadcrumbs), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@push('styles')
<style>
:root {
    --article-green: #17382b;
    --article-green-light: #2d6a4f;
    --article-gold: #c8a165;
    --article-gold-light: #e2c08d;
    --article-ink: #1f2d26;
    --article-muted: #6f7d73;
    --article-line: rgba(26, 60, 46, 0.12);
    --article-soft: #f8f5f0;
    --article-shadow: 0 22px 54px rgba(26, 60, 46, 0.13);
}

.article-progress {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1060;
    width: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--article-gold), var(--article-green-light));
    box-shadow: 0 8px 18px rgba(200, 161, 101, 0.28);
}

.article-page {
    min-height: 100vh;
    overflow: hidden;
    background:
        radial-gradient(circle at 8% 12%, rgba(45, 106, 79, 0.1), transparent 28%),
        radial-gradient(circle at 92% 18%, rgba(200, 161, 101, 0.13), transparent 24%),
        linear-gradient(180deg, #fff 0%, var(--article-soft) 100%);
}

.article-hero {
    position: relative;
    min-height: 560px;
    display: flex;
    align-items: end;
    margin-top: 50px;
    color: #fff;
    background:
        linear-gradient(105deg, rgba(12, 24, 18, 0.95) 0%, rgba(23, 56, 43, 0.82) 54%, rgba(45, 106, 79, 0.5) 100%),
        url('{{ $postImage }}') center/cover;
}

.article-hero::after {
    content: '';
    position: absolute;
    inset: auto 0 0;
    height: 116px;
    background: linear-gradient(180deg, transparent, rgba(248, 245, 240, 0.98));
}

.article-hero-content {
    position: relative;
    z-index: 2;
    max-width: 940px;
    padding: 116px 0 146px;
}

.article-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid rgba(226, 192, 141, 0.42);
    border-radius: 50px;
    background: rgba(200, 161, 101, 0.14);
    color: var(--article-gold-light);
    font-size: 0.72rem;
    font-weight: 900;
    letter-spacing: 2.2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.article-hero h1,
.article-section-title {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.article-hero h1 {
    max-width: 900px;
    text-shadow: 0 16px 44px rgba(0, 0, 0, 0.28);
}

.article-excerpt {
    max-width: 760px;
    color: rgba(255, 255, 255, 0.84);
    line-height: 1.8;
}

.article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 26px;
}

.article-meta span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 50px;
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.82);
    padding: 9px 13px;
    font-size: 0.84rem;
    font-weight: 800;
    backdrop-filter: blur(10px);
}

.article-shell {
    position: relative;
    z-index: 5;
    margin-top: -78px;
    padding-bottom: 82px;
}

.article-featured-image {
    overflow: hidden;
    border: 1px solid var(--article-line);
    border-radius: 8px;
    background: #fff;
    box-shadow: var(--article-shadow);
    margin-bottom: 34px;
}

.article-featured-image img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    display: block;
}

.article-content-card,
.article-widget,
.article-related-panel {
    border: 1px solid var(--article-line);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.94);
    box-shadow: 0 16px 36px rgba(26, 60, 46, 0.09);
}

.article-content-card {
    padding: clamp(24px, 4vw, 42px);
}

.article-body {
    color: var(--article-ink);
    font-size: 1.08rem;
    line-height: 1.95;
}

.article-body p {
    margin-bottom: 1.4rem;
}

.article-body::first-letter {
    float: left;
    color: var(--article-green);
    font-family: 'Playfair Display', serif;
    font-size: 4.2rem;
    line-height: 0.85;
    padding: 11px 11px 0 0;
}

.article-share-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    border-top: 1px solid var(--article-line);
    margin-top: 34px;
    padding-top: 24px;
}

.article-guidance-box {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 16px;
    border: 1px solid rgba(200, 161, 101, 0.28);
    border-radius: 8px;
    background:
        linear-gradient(135deg, rgba(200, 161, 101, 0.13), rgba(45, 106, 79, 0.07)),
        #fff;
    padding: 20px;
    margin-top: 30px;
}

.article-guidance-icon {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--article-green), var(--article-green-light));
    box-shadow: 0 14px 28px rgba(26, 60, 46, 0.18);
}

.article-guidance-box h3 {
    color: var(--article-green);
    font-size: 1.05rem;
    font-weight: 900;
    margin-bottom: 6px;
}

.article-guidance-box p {
    color: var(--article-muted);
    line-height: 1.75;
    margin-bottom: 0;
}

.article-share-actions {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-wrap: wrap;
}

.article-share-btn {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(26, 60, 46, 0.12);
    border-radius: 50%;
    color: var(--article-green);
    background: #fff;
    text-decoration: none;
    transition: transform 0.22s ease, color 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
}

.article-share-btn:hover {
    color: #fff;
    border-color: transparent;
    background: linear-gradient(135deg, var(--article-green), var(--article-green-light));
    box-shadow: 0 12px 26px rgba(26, 60, 46, 0.18);
    transform: translateY(-2px);
}

.article-copy-btn {
    border: 1px solid rgba(200, 161, 101, 0.24);
    border-radius: 50px;
    color: var(--article-green);
    background: rgba(200, 161, 101, 0.11);
    font-weight: 900;
    padding: 10px 14px;
}

.article-sidebar {
    position: sticky;
    top: 96px;
}

.article-widget + .article-widget {
    margin-top: 22px;
}

.article-widget {
    overflow: hidden;
}

.article-widget-inner {
    padding: 22px;
}

.article-widget-title {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--article-green);
    margin-bottom: 15px;
}

.article-widget-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 38px;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--article-green), var(--article-green-light));
}

.article-author {
    display: flex;
    gap: 13px;
    align-items: center;
}

.article-author-avatar {
    width: 58px;
    height: 58px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 58px;
    border-radius: 50%;
    color: #fff;
    background: linear-gradient(135deg, var(--article-gold), var(--article-green-light));
    font-weight: 900;
    font-size: 1.35rem;
}

.article-info-list {
    display: grid;
    gap: 10px;
}

.article-info-list span {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    color: var(--article-muted);
    border-bottom: 1px solid rgba(26, 60, 46, 0.08);
    padding-bottom: 10px;
    font-size: 0.9rem;
}

.article-info-list span:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.article-note {
    color: #fff;
    background:
        linear-gradient(145deg, rgba(23, 56, 43, 0.96), rgba(45, 106, 79, 0.92)),
        url('https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=900&auto=format&fit=crop') center/cover;
}

.article-note p {
    color: rgba(255, 255, 255, 0.78);
    line-height: 1.7;
}

.article-note .article-widget-title {
    color: #fff;
}

.article-back-link,
.article-read-link {
    color: var(--article-green);
    font-weight: 900;
    text-decoration: none;
}

.article-back-link:hover,
.article-read-link:hover {
    color: var(--article-gold);
}

.article-section-title {
    position: relative;
    display: inline-block;
    color: #123524;
    background: linear-gradient(135deg, #0f3d2e 0%, #2f7d4f 48%, #c7962e 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    padding-bottom: 12px;
    margin-bottom: 26px;
    text-shadow: 0 12px 28px rgba(27, 67, 50, 0.12);
}

.article-section-title::after {
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

.article-related-panel {
    padding: clamp(22px, 4vw, 34px);
    margin-top: 34px;
}

.article-toast {
    min-height: 18px;
    color: var(--article-muted);
    font-size: 0.82rem;
    font-weight: 800;
}

.article-page .card-hover-lift {
    overflow: hidden;
    border: 1px solid var(--article-line) !important;
    border-radius: 8px !important;
    box-shadow: 0 16px 36px rgba(26, 60, 46, 0.09) !important;
    transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
}

.article-page .card-hover-lift:hover {
    transform: translateY(-6px);
    border-color: rgba(200, 161, 101, 0.38) !important;
    box-shadow: 0 24px 48px rgba(26, 60, 46, 0.14) !important;
}

.blog-card-modern {
    isolation: isolate;
}

.blog-card-media {
    height: 230px;
    background: var(--article-soft);
}

.blog-card-image {
    width: 100%;
    height: 230px !important;
    transition: transform 0.45s ease;
}

.blog-card-modern:hover .blog-card-image {
    transform: scale(1.04);
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
    background: linear-gradient(135deg, var(--article-gold), var(--article-green-light));
    box-shadow: 0 10px 24px rgba(26, 60, 46, 0.18);
}

.blog-card-readtime {
    top: 14px;
    right: 14px;
    color: var(--article-green);
    background: rgba(255, 255, 255, 0.92);
}

.blog-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    color: var(--article-muted);
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
    color: var(--article-ink);
    transition: color 0.22s ease;
}

.blog-card-title a:hover {
    color: var(--article-green-light);
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
    color: var(--article-green);
    font-size: 0.78rem;
    font-weight: 900;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    text-decoration: none;
}

.blog-card-link:hover {
    color: var(--article-gold);
}

.blog-card-dot {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: var(--article-green);
    background: rgba(200, 161, 101, 0.12);
}

@media (max-width: 991.98px) {
    .article-hero {
        min-height: auto;
        margin-top: 0;
    }

    .article-hero-content {
        padding: 110px 0 104px;
    }

    .article-shell {
        margin-top: 0;
        padding-top: 42px;
    }

    .article-sidebar {
        position: static;
    }

    .article-featured-image img {
        height: 360px;
    }
}

@media (max-width: 575.98px) {
    .article-hero h1 {
        font-size: 2.35rem;
    }

    .article-meta span {
        width: 100%;
        justify-content: center;
    }

    .article-featured-image img {
        height: 240px;
    }

    .article-body {
        font-size: 1rem;
        line-height: 1.85;
    }

    .article-body::first-letter {
        font-size: 3.25rem;
    }

    .article-share-bar {
        align-items: flex-start;
    }

    .article-guidance-box {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="article-progress" id="articleProgress"></div>

<main class="article-page">
    <section class="article-hero">
        <div class="container">
            <div class="article-hero-content">
                @if($post->category)
                    <span class="article-badge">
                        <i class="fas fa-leaf"></i>{{ $post->category->name }}
                    </span>
                @else
                    <span class="article-badge">
                        <i class="fas fa-book-open"></i>{{ __('Dawakhana Journal') }}
                    </span>
                @endif

                <h1 class="display-4 mb-4 lh-sm">{{ $post->title }}</h1>

                @if($post->excerpt)
                    <p class="article-excerpt lead mb-0">{{ $post->excerpt }}</p>
                @endif

                <div class="article-meta">
                    <span><i class="far fa-user"></i>{{ $post->author->name ?? 'Admin' }}</span>
                    <span><i class="far fa-calendar"></i>{{ $post->published_at->format('F j, Y') }}</span>
                    <span><i class="far fa-eye"></i>{{ $post->views }} {{ __('Views') }}</span>
                    <span><i class="far fa-clock"></i>{{ $readingMinutes }} {{ __('min read') }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="article-shell">
        <div class="container">
            <div class="article-featured-image">
                <img src="{{ $postImage }}" alt="{{ $post->title }}">
            </div>

            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    <article class="article-content-card">
                        <a href="{{ route('blog.index') }}" class="article-back-link small text-uppercase">
                            <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Journal') }}
                        </a>

                        <div class="article-body mt-4">
                            {!! nl2br(e($post->body)) !!}
                        </div>

                        <div class="article-guidance-box">
                            <span class="article-guidance-icon">
                                <i class="fas fa-notes-medical"></i>
                            </span>
                            <div>
                                <h3>{{ __('Health Guidance Note') }}</h3>
                                <p>{{ __('This article is shared for general herbal wellness education. If you have severe symptoms, allergies, pregnancy concerns, or a long-term condition, please consult a qualified healthcare professional before using any remedy.') }}</p>
                            </div>
                        </div>

                        <div class="article-share-bar">
                            <div>
                                <strong class="d-block mb-1">{{ __('Share this article') }}</strong>
                                <span class="article-toast" id="copyArticleStatus">{{ __('Help others discover useful herbal care guidance.') }}</span>
                            </div>

                            <div class="article-share-actions">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($postUrl) }}" target="_blank" rel="noopener" class="article-share-btn" aria-label="{{ __('Share on Facebook') }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($postUrl) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="article-share-btn" aria-label="{{ __('Share on Twitter') }}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($postUrl) }}" target="_blank" rel="noopener" class="article-share-btn" aria-label="{{ __('Share on LinkedIn') }}">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <button type="button" class="article-copy-btn" id="copyArticleLink" data-url="{{ $postUrl }}">
                                    <i class="fas fa-link me-1"></i>{{ __('Copy Link') }}
                                </button>
                            </div>
                        </div>
                    </article>

                    @if($relatedPosts->count() > 0)
                        <section class="article-related-panel">
                            <h2 class="article-section-title h1">{{ __('Related Articles') }}</h2>
                            <div class="row g-4">
                                @foreach($relatedPosts as $related)
                                    <div class="col-md-6">
                                        @include('partials.blog-card', ['post' => $related])
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <div class="col-lg-4">
                    <aside class="article-sidebar">
                        <div class="article-widget">
                            <div class="article-widget-inner">
                                <div class="article-widget-title">
                                    <span class="article-widget-icon"><i class="fas fa-user"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Author') }}</h5>
                                </div>
                                <div class="article-author">
                                    <span class="article-author-avatar">{{ Str::upper(Str::substr($post->author->name ?? 'A', 0, 1)) }}</span>
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $post->author->name ?? 'Admin' }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Dawakhana wellness editor') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="article-widget">
                            <div class="article-widget-inner">
                                <div class="article-widget-title">
                                    <span class="article-widget-icon"><i class="fas fa-circle-info"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Article Details') }}</h5>
                                </div>
                                <div class="article-info-list">
                                    <span><strong>{{ __('Published') }}</strong>{{ $post->published_at->format('M d, Y') }}</span>
                                    <span><strong>{{ __('Reading') }}</strong>{{ $readingMinutes }} {{ __('min') }}</span>
                                    <span><strong>{{ __('Views') }}</strong>{{ $post->views }}</span>
                                    @if($post->category)
                                        <span><strong>{{ __('Topic') }}</strong>{{ $post->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="article-widget article-note">
                            <div class="article-widget-inner">
                                <div class="article-widget-title">
                                    <span class="article-widget-icon"><i class="fas fa-shield-heart"></i></span>
                                    <h5 class="playfair fw-bold mb-0">{{ __('Wellness Note') }}</h5>
                                </div>
                                <p class="mb-3">{{ __('Herbal guidance can support daily wellness, but it should not replace professional medical advice for serious symptoms or ongoing conditions.') }}</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-sm fw-bold" style="color: var(--article-green); background: linear-gradient(135deg, var(--article-gold), var(--article-gold-light)); border-radius: 8px; padding: 10px 14px;">
                                    {{ __('Explore Products') }} <i class="fas fa-arrow-right ms-1"></i>
                                </a>
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
    var progress = document.getElementById('articleProgress');
    var copyButton = document.getElementById('copyArticleLink');
    var copyStatus = document.getElementById('copyArticleStatus');

    function updateProgress() {
        if (!progress) return;

        var scrollTop = window.scrollY || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - window.innerHeight;
        var percent = height > 0 ? (scrollTop / height) * 100 : 0;
        progress.style.width = Math.min(100, Math.max(0, percent)) + '%';
    }

    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();

    if (copyButton && copyStatus) {
        copyButton.addEventListener('click', async function () {
            var url = copyButton.getAttribute('data-url');

            try {
                await navigator.clipboard.writeText(url);
                copyStatus.textContent = '{{ __('Article link copied.') }}';
            } catch (error) {
                copyStatus.textContent = url;
            }
        });
    }
});
</script>
@endpush
