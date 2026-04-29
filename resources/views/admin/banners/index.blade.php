@extends('admin.layouts.admin')

@section('header', __('Manage Banners'))

@section('content')
    @include('admin.partials.locale-filter')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">{{ __('Manage the hero sliders that appear on the homepage.') }}</p>
        <a href="{{ route('admin.banners.create') }}" class="btn text-white" style="background-color: var(--primary);">
            <i class="fas fa-plus me-2"></i> {{ __('Add Banner') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @foreach($banners as $banner)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="position-relative">
                    <img src="{{ asset($banner->image) }}" class="w-100 object-fit-cover" style="height: 200px;">
                    <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-light border shadow-sm"><i class="fas fa-edit text-warning"></i></a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this banner?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light border shadow-sm"><i class="fas fa-trash text-danger"></i></button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold playfair mb-0">{{ $banner->title }}</h5>
                        <span class="badge bg-secondary-custom shadow-sm text-dark">{{ __('Order') }}: {{ $banner->sort_order }}</span>
                    </div>
                    <p class="text-muted small">{{ $banner->subtitle }}</p>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-muted">{{ __('Btn') }}: <strong>{{ $banner->button_text }}</strong> <i class="fas fa-arrow-right mx-1"></i> {{ $banner->button_link }}</span>
                        <div class="form-check form-switch m-0 d-flex align-items-center gap-2">
                            <input class="form-check-input m-0" type="checkbox" disabled {{ $banner->is_active ? 'checked' : '' }}>
                            <label class="form-check-label mb-0">{{ $banner->is_active ? __('Active') : __('Inactive') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
