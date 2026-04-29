@extends('layouts.app')

@section('content')
    <!-- Hero / Page Header -->
    <section class="position-relative d-flex align-items-center justify-content-center" style="height: 60vh; min-height: 400px; background-image: url('{{ $about->hero_image ? asset($about->hero_image) : 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=1920&auto=format&fit=crop' }}'); background-size: cover; background-position: center; margin-top: -1px;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(14,12,10,0.7) 0%, rgba(14,12,10,0.5) 100%); z-index: 1;"></div>
        <div class="container position-relative z-2 text-center text-white mt-5">
            <span class="d-inline-block text-secondary-custom fw-bold px-3 py-1 mb-3 rounded-0" style="font-size: 0.9rem; letter-spacing: 3px; border: 1px solid var(--secondary);">{{ __('DISCOVER') }}</span>
            <h1 class="display-2 fw-bold mb-3" style="font-family: 'Playfair Display', serif; text-shadow: 0 4px 15px rgba(0,0,0,0.3);">{{ $about->hero_title ?? __('Our Story') }}</h1>
            <p class="lead fw-light mx-auto" style="max-width: 600px; opacity: 0.9;">{{ $about->hero_subtitle ?? __('Crafting beautiful, timeless spaces that define luxury living since 2010.') }}</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center mb-5 pb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <div class="position-relative">
                        <!-- Offset background decorative block -->
                        <div class="position-absolute rounded-4" style="background-color: #F8F5F0; top: 30px; left: -30px; width: 100%; height: 100%; z-index: 0;"></div>
                        <img src="{{ $about->vision_image ? asset($about->vision_image) : 'https://images.unsplash.com/photo-1540638349517-3abd5afc5847?q=80&w=800&auto=format&fit=crop' }}" class="w-100 rounded-4 shadow-lg object-fit-cover position-relative" alt="{{ __('Our Workshop') }}" style="height: 550px; z-index: 1;">
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <h5 class="text-secondary-custom fw-bold text-uppercase mb-3" style="letter-spacing: 2px;">{{ $about->vision_title ?? __('The Vision') }}</h5>
                    <h2 class="playfair display-5 mb-4 text-primary-custom fw-bold">{{ $about->vision_heading ?? __('A Passion for Design and Exceptional Craftsmanship') }}</h2>
                    <p class="text-muted fs-5 lh-lg mb-4">{{ $about->vision_description_1 ?? __('Atta_Furniture was born out of a simple idea: furniture should be beautiful, functional, and built to last. We started in a small local workshop with a dedication to traditional woodworking techniques combined with modern luxury aesthetics.') }}</p>
                    <p class="text-muted fs-5 lh-lg mb-4">{{ $about->vision_description_2 ?? __("Over the years, we've grown, but our core philosophy remains untouched. We source the finest materials globally and craft them into timeless pieces that turn an ordinary house into a breathtaking home.") }}</p>
                    <div class="d-flex align-items-center mt-5 p-4 rounded-4 shadow-sm" style="background-color: #F8F5F0;">
                        <img src="{{ $about->founder_image ? asset($about->founder_image) : 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=150&auto=format&fit=crop' }}" class="rounded-circle shadow-sm me-4 border border-3 border-white" alt="{{ __('Founder') }}" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary-custom" style="font-family: 'Playfair Display', serif;">{{ $about->founder_name ?? 'Sarah Jenkins' }}</h5>
                            <span class="text-muted small fw-semibold text-uppercase" style="letter-spacing: 1px;">{{ $about->founder_title ?? __('Founder & Lead Designer') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5" style="background-color: #F8F5F0;">
        <div class="container py-5">
            <div class="row text-center g-4">
                @php
                    $stats = $about->stats ?? [
                        ['number' => '15+', 'label' => __('Years Experience'), 'desc' => __('Mastering the art of luxury furniture since our founding.')],
                        ['number' => '50k', 'label' => __('Happy Homes'), 'desc' => __('Delivering elevated comfort and joy to homes worldwide.')],
                        ['number' => '120', 'label' => __('Design Awards'), 'desc' => __('Recognized globally for outstanding luxury aesthetics.')]
                    ];
                @endphp
                @foreach($stats as $index => $stat)
                    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                        <div class="p-5 bg-white rounded-4 shadow-sm h-100 text-center" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                             <h1 class="display-3 fw-bold text-secondary-custom mb-3" style="font-family: 'Playfair Display', serif;">{{ $stat['number'] ?? '' }}</h1>
                             <h5 class="fw-bold text-primary-custom text-uppercase" style="letter-spacing: 1px;">{{ is_array($stat['label']) ? $stat['label'][app()->getLocale()] ?? $stat['label']['en'] : __($stat['label'] ?? '') }}</h5>
                             <p class="text-muted mt-3 mb-0">{{ is_array($stat['desc']) ? $stat['desc'][app()->getLocale()] ?? $stat['desc']['en'] : __($stat['desc'] ?? '') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
