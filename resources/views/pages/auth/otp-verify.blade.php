@extends('layouts.app')

@section('content')
    <div class="page-header text-center" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">Verify Your Email</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100 d-flex align-items-center">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="card border-0 shadow rounded-4 p-4 p-md-5" style="background-color: var(--background);">
                        <h3 class="playfair text-center mb-1">Enter OTP</h3>
                        <p class="text-center text-muted mb-4 small">We've sent a 6-digit code to {{ session('email') }}</p>
                        
                        @if(session('error'))
                            <div class="alert alert-danger mb-4 rounded-3 small">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('register.verify') }}" method="POST">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between gap-2" id="otp-inputs">
                                    <input type="text" name="otp[]" class="form-control rounded shadow-none text-center fw-bold fs-4 py-3" maxlength="1" required style="width: 50px; border-color: #eee;">
                                    <input type="text" name="otp[]" class="form-control rounded shadow-none text-center fw-bold fs-4 py-3" maxlength="1" required style="width: 50px; border-color: #eee;">
                                    <input type="text" name="otp[]" class="form-control rounded shadow-none text-center fw-bold fs-4 py-3" maxlength="1" required style="width: 50px; border-color: #eee;">
                                    <input type="text" name="otp[]" class="form-control rounded shadow-none text-center fw-bold fs-4 py-3" maxlength="1" required style="width: 50px; border-color: #eee;">
                                    <input type="text" name="otp[]" class="form-control rounded shadow-none text-center fw-bold fs-4 py-3" maxlength="1" required style="width: 50px; border-color: #eee;">
                                    <input type="text" name="otp[]" class="form-control rounded shadow-none text-center fw-bold fs-4 py-3" maxlength="1" required style="width: 50px; border-color: #eee;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-pill py-3 fw-bold shadow">Verify & Activate</button>
                        </form>
                        
                        <div class="mt-4 text-center">
                            <p class="text-muted small">Didn't receive the code? 
                                <form action="{{ route('register.resend') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 text-primary-custom fw-bold text-decoration-none small">Resend OTP</button>
                                </form>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Simple auto-tab script for OTP inputs
        const inputs = document.querySelectorAll('#otp-inputs input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length >= 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
    @endpush
@endsection
