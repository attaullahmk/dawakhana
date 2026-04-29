<div class="card border-0 shadow-sm h-100 card-hover-lift">
    <div class="position-relative">
        <a href="{{ route('blog.show', $post->slug) }}">
            <img src="{{ str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image) }}" loading="lazy" class="card-img-top object-fit-cover" alt="{{ $post->title }}" style="height: 220px;">
        </a>
        @if($post->category)
            <span class="badge bg-secondary-custom position-absolute bottom-0 start-0 m-3">{{ $post->category->name }}</span>
        @endif
    </div>
    <div class="card-body p-4">
        <div class="text-muted small mb-2">
            <i class="far fa-calendar-alt me-2"></i> {{ $post->published_at->format('M d, Y') }}
        </div>
        <h4 class="card-title playfair">
            <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a>
        </h4>
        <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
        <a href="{{ route('blog.show', $post->slug) }}" class="text-primary-custom fw-bold text-decoration-none text-uppercase small">{{ __('Read More') }} <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
</div>
