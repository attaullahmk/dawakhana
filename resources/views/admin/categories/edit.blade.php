@extends('admin.layouts.admin')

@section('header', __('Edit Category'))

@section('content')
    <div class="row g-4">
        <!-- Edit Category Form -->
        <div class="col-lg-6 mx-auto">
            <div class="card p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">{{ __('Edit Category') }}: {{ $category->name }}</h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-light"><i class="fas fa-arrow-left me-1"></i> {{ __('Back') }}</a>
                </div>

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', $category->locale ?? 'en')])

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name', $category->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Image') }}</label>
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset($category->image) }}" class="rounded shadow-sm" width="100">
                                <p class="small text-muted mt-1">{{ __('Current Image') }}</p>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        <small class="text-muted">{{ __('Leave empty to keep the current image.') }}</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn text-white w-100" style="background-color: var(--primary);">{{ __('Update Category') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
