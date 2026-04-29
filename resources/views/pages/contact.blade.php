@extends('layouts.app')

@section('content')
    <!-- Page Header (Hidden on Mobile) -->
    <div class="page-header text-center d-none d-md-block" style="background-image: linear-gradient(rgba(92, 61, 46, 0.9), rgba(92, 61, 46, 0.9)), url('https://picsum.photos/seed/contact/1920/400'); background-size: cover; background-position: center; padding: 100px 0 60px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">{{ __($globalSettings['contact_heading'] ?? 'Get In Touch') }}</h1>
            <p class="lead" style="opacity: 0.8;">{{ __($globalSettings['contact_subheading'] ?? "We'd love to hear from you. Our team is always here to help.") }}</p>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100">
        <div class="container py-4">
            <div class="row gx-lg-5">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h3 class="playfair mb-4">{{ __('Contact Information') }}</h3>
                    <p class="text-muted mb-5">{{ __($globalSettings['contact_description'] ?? 'Have a question or comment? Use the form to give us a message or contact us directly using the details below.') }}</p>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-secondary-custom text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 60px; height: 60px;">
                            <i class="fas fa-map-marker-alt fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __('Our Location') }}</h5>
                            <p class="text-muted mb-0">{{ $globalSettings['site_address'] ?? '123 FurniCraft HQ, New York, NY 10001' }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-secondary-custom text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 60px; height: 60px;">
                            <i class="fas fa-phone fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __('Phone Number') }}</h5>
                            <p class="text-muted mb-0">{!! nl2br(e($globalSettings['site_phone'] ?? '1-800-FURNITURE')) !!}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="bg-secondary-custom text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow" style="width: 60px; height: 60px;">
                            <i class="fas fa-envelope fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __('Email Address') }}</h5>
                            <p class="text-muted mb-0">{{ $globalSettings['site_email'] ?? 'hello@furnicraft.com' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4" style="background-color: var(--background);">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="playfair mb-4">{{ __('Send Us a Message') }}</h3>
                            
                            @if(session('success'))
                                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Your Name') }}</label>
                                        <input type="text" name="name" class="form-control rounded-pill px-4 shadow-none py-2 border-0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Your Email') }}</label>
                                        <input type="email" name="email" class="form-control rounded-pill px-4 shadow-none py-2 border-0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Phone') }}</label>
                                        <input type="text" name="phone" class="form-control rounded-pill px-4 shadow-none py-2 border-0">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Subject') }}</label>
                                        <input type="text" name="subject" class="form-control rounded-pill px-4 shadow-none py-2 border-0" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Message') }}</label>
                                        <textarea name="message" rows="5" class="form-control rounded-4 px-4 shadow-none py-3 border-0" required></textarea>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary-custom btn-lg rounded-pill px-5 shadow w-100">{{ __('Send Message') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
