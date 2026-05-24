@php
    $cardImage = str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image);
    $cardExcerpt = $post->excerpt ?: Str::limit(strip_tags($post->body), 120);
    $cardReadingMinutes = max(1, ceil(str_word_count(strip_tags($post->body ?? $post->excerpt ?? '')) / 180));
@endphp

<article class="card category-card h-100 hover-tilt-card home-blog-card">
    <div class="img-wrap position-relative">
        @if($post->category)
            <span class="category-card-badge">
                <i class="fas fa-leaf"></i>
                {{ $post->category->name }}
            </span>
        @endif

        <a href="{{ route('blog.show', $post->slug) }}" aria-label="{{ $post->title }}">
            <img src="{{ $cardImage }}" loading="lazy" class="card-img-top object-fit-cover" alt="{{ $post->title }}">
        </a>

        <span class="blog-card-readtime" style="position:absolute;right:12px;bottom:12px;background:rgba(255,255,255,0.9);color:var(--green);padding:6px 10px;border-radius:20px;font-weight:800;border:1px solid rgba(26,60,46,0.08);">
            <i class="far fa-clock"></i>{{ $cardReadingMinutes }} {{ __('min') }}
        </span>
    </div>

    <div class="card-body p-4 d-flex flex-column">
        <div class="blog-card-meta mb-2" style="color:var(--muted);font-size:0.85rem;">
            <span class="me-3"><i class="far fa-calendar-alt"></i> {{ $post->published_at->format('M d, Y') }}</span>
            <span><i class="far fa-user"></i> {{ $post->author->name ?? 'Admin' }}</span>
        </div>

        <h5 class="playfair fw-bold mb-2 category-card-title">
            <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">{{ $post->title }}</a>
        </h5>

        <p class="card-text text-muted blog-card-excerpt mb-3">{{ Str::limit($cardExcerpt, 108) }}</p>

        <div class="category-card-bottom mt-auto">
            <span class="shop-now-link">{{ __('Read Article') }}</span>
            <span class="category-card-arrow"><i class="fas fa-arrow-right"></i></span>
        </div>
    </div>
</article>
