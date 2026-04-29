@extends('layouts.app')

@section('content')
    <div class="page-header text-center" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">Create Account</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100 d-flex align-items-center">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6">
                    <div class="card border-0 shadow rounded-4 p-4 p-md-5" style="background-color: var(--background);">
                        <h3 class="playfair text-center mb-4">Join Atta_Furniture Today</h3>
                        
                        @if($errors->any())
                            <div class="alert alert-danger mb-4 rounded-3 small">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">First Name</label>
                                    <input type="text" name="first_name" class="form-control rounded-pill px-4 shadow-none py-2 border-white @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required placeholder="John">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted fw-bold small text-uppercase">Last Name</label>
                                    <input type="text" name="last_name" class="form-control rounded-pill px-4 shadow-none py-2 border-white @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required placeholder="Doe">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted fw-bold small text-uppercase">Email Address</label>
                                    <input type="email" name="email" class="form-control rounded-pill px-4 shadow-none py-2 border-white @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="john@example.com">
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label text-muted fw-bold small text-uppercase">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control rounded-start-pill ps-4 shadow-none py-2 border-white border-end-0" required placeholder="••••••••">
                                        <button class="btn btn-outline-secondary border-start-0 rounded-end-pill px-3 py-2 bg-white text-muted shadow-none border-white" type="button" data-toggle-password="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label text-muted small" for="terms">
                                            I agree to the <a href="#" class="text-primary-custom text-decoration-none">Terms of Service</a> and <a href="#" class="text-primary-custom text-decoration-none">Privacy Policy</a>.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-pill py-3 fw-bold shadow mb-3">Create Account</button>
                                    
                                    <a href="#" class="btn btn-outline-dark btn-lg w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 0.95rem; border-color: #ddd;">
                                        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" alt="Google">
                                        Sign up with Google
                                    </a>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4 border-secondary">
                        <p class="text-center text-muted mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary-custom fw-bold text-decoration-none">Login Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
