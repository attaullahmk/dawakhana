@extends('layouts.app')

@section('content')
    <!-- Page Header (Hidden on Mobile) -->
    <div class="page-header text-center d-none d-md-block" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">{{ __('Interior Inspiration') }}</h1>
            <p class="lead" style="opacity: 0.8;">{{ __('Latest trends, tips, and ideas for your home.') }}</p>
        </div>
    </div>

    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row g-4">
                        @forelse($posts as $post)
                            <div class="col-md-6" data-aos="fade-up">
                                @include('partials.blog-card', ['post' => $post])
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <h3>{{ __('No posts found.') }}</h3>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0 ps-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 mb-5" style="background-color: var(--background);">
                        <div class="card-body p-4">
                            <h5 class="playfair fw-bold mb-4">{{ __('Search') }}</h5>
                            <form action="{{ route('blog.index') }}" method="GET">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control rounded-start-pill shadow-none border-secondary" placeholder="{{ __('Search blog...') }}" value="{{ request('search') }}">
                                    <button class="btn btn-secondary-custom rounded-end-pill px-3" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                            @if(request('search'))
                                <div class="mt-2 text-start">
                                    <a href="{{ route('blog.index', ['category' => request('category')]) }}" class="text-danger small text-decoration-none">
                                        <i class="fas fa-times me-1"></i> {{ __('Clear Search') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 mb-5">
                        <div class="card-body p-4">
                            <h5 class="playfair fw-bold mb-4">{{ __('Categories') }}</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('blog.index', ['search' => request('search')]) }}" class="text-decoration-none {{ !request('category') ? 'text-primary fw-bold' : 'text-muted' }} hover-gold">{{ __('All Categories') }}</a>
                                </li>
                                @foreach($categories as $category)
                                    <li class="mb-3 d-flex justify-content-between align-items-center">
                                        <a href="{{ route('blog.index', ['category' => $category->slug, 'search' => request('search')]) }}" 
                                           class="text-decoration-none {{ request('category') == $category->slug ? 'text-primary fw-bold' : 'text-muted' }} hover-gold">
                                            {{ $category->name }}
                                        </a>
                                        <span class="badge bg-light text-dark rounded-pill">{{ $category->posts_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="playfair fw-bold mb-4">{{ __('Recent Posts') }}</h5>
                            @foreach($recentPosts as $recent)
                                <div class="d-flex mb-3 align-items-center border-bottom pb-3">
                                    <img src="{{ str_starts_with($recent->featured_image, 'http') ? $recent->featured_image : asset($recent->featured_image) }}" class="rounded shadow-sm object-fit-cover me-3" style="width: 70px; height: 70px;">
                                    <div>
                                        <h6 class="mb-1 fw-bold"><a href="{{ route('blog.show', $recent->slug) }}" class="text-dark text-decoration-none lh-sm d-block">{{ Str::limit($recent->title, 40) }}</a></h6>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $recent->published_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<style>
    .hover-gold:hover { color: var(--secondary) !important; }
</style>
@endpush
