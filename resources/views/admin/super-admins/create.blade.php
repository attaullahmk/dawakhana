@extends('admin.layouts.admin')

@section('header', __('Add Admin Staff'))

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card p-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-4">{{ __('Create New Admin Account') }}</h5>
            
            <p class="text-muted small mb-4">{{ __('Note: This account will be granted administrative permissions. Super Admin roles are only manageable via system seeding.') }}</p>
            
            @if($errors->any())
                <div class="alert alert-danger mb-4 rounded-3 small">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.super-admins.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">{{ __('Full Name') }}</label>
                    <input type="text" name="name" class="form-control rounded-3" required value="{{ old('name') }}" placeholder="{{ __('Enter full name') }}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">{{ __('Email Address') }}</label>
                    <input type="email" name="email" class="form-control rounded-3" required value="{{ old('email') }}" placeholder="{{ __('admin@example.com') }}">
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">{{ __('Password') }}</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control rounded-3-start shadow-none border-end-0" required placeholder="{{ __('Minimum 8 characters') }}">
                        <button class="btn btn-outline-secondary border-start-0 rounded-3-end px-3 py-2 bg-white text-muted shadow-none" type="button" data-toggle-password="password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">{{ __('Create Admin Account') }}</button>
                    <a href="{{ route('admin.super-admins.index') }}" class="btn btn-outline-secondary px-4 py-2 border-0 fw-bold">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
