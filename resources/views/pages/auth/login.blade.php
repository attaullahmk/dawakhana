@extends('layouts.app')

@section('content')
    <div class="page-header text-center" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">Welcome Back</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100 d-flex align-items-center">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                        @if(session('error'))
                            <div class="alert alert-danger mb-4 rounded-3 small">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger mb-4 rounded-3 small">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold small text-uppercase">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-pill px-4 shadow-none py-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="you@example.com">
                            </div>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control rounded-start-pill ps-4 shadow-none py-2 border-end-0" required placeholder="••••••••">
                                    <button class="btn btn-outline-secondary border-start-0 rounded-end-pill px-3 py-2 bg-white text-muted shadow-none" type="button" data-toggle-password="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                <label class="form-check-label text-muted" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-pill py-3 fw-bold shadow mb-3">Login Now</button>
                            
                            <a href="#" class="btn btn-outline-dark btn-lg w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2" style="font-size: 0.95rem; border-color: #ddd;">
                                <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" alt="Google">
                                Continue with Google
                            </a>
                        </form>
                        <hr class="my-4 border-secondary">
                        <p class="text-center text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary-custom fw-bold text-decoration-none">Create One</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
