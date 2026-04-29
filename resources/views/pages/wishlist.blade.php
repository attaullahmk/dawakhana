@extends('layouts.app')

@section('content')
    <!-- Page Header (Hidden on Mobile) -->
    <div class="page-header text-center d-none d-md-block" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">{{ __('My Wishlist') }}</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100">
        <div class="container py-4">
            @if($wishlistItems->count() > 0)
                <div class="row g-4">
                    @foreach($wishlistItems as $item)
                        @if($item->product)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                @include('partials.product-card', ['product' => $item->product])
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-5 my-5">
                    <i class="far fa-heart fs-1 text-muted mb-3 opacity-50" style="font-size: 4rem !important;"></i>
                    <h3 class="playfair mb-3">{{ __('Your wishlist is empty') }}</h3>
                    <p class="text-muted mb-4">{{ __("You haven't saved any items to your wishlist yet. Start exploring and add your favorite pieces!") }}</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary-custom btn-lg rounded-pill px-5 shadow">{{ __('Discover Furniture') }}</a>
                </div>
            @endif
        </div>
    </section>
@endsection
