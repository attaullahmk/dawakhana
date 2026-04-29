@extends('admin.layouts.admin')

@section('header', isset($banner) ? __('Edit Banner') : __('Create Banner'))

@section('content')
<div class="card p-4">
    <form action="{{ isset($banner) ? route('admin.banners.update', $banner->id) : route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($banner))
            @method('PUT')
        @endif

        @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', $banner->locale ?? 'en')])

        <div class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Banner Title') }}</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $banner->title ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Subtitle') }}</label>
                    <textarea class="form-control" name="subtitle" rows="3">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea>
                </div>
                <div class="row g-2">
                    <div class="col-md-6 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Button Text') }}</label>
                            <input type="text" class="form-control" name="button_text" value="{{ old('button_text', $banner->button_text ?? '') }}" placeholder="{{ __('Explore Collection') }}">
                        </div>
                    </div>
                    <div class="col-md-6 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Button Link') }}</label>
                            <input type="text" class="form-control" name="button_link" value="{{ old('button_link', $banner->button_link ?? '') }}" placeholder="{{ __('/shop') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Banner Image') }}</label>
                    <input type="file" class="form-control" name="image" {{ isset($banner) ? '' : 'required' }} accept="image/*">
                    <small class="text-muted">{{ __('Recommended size: 1920x800px') }}</small>
                    @if(isset($banner) && $banner->image)
                        <div class="mt-2">
                            <img src="{{ asset($banner->image) }}" alt="Preview" class="rounded shadow-sm" style="max-height: 150px;">
                        </div>
                    @endif
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Sort Order') }}</label>
                            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
                        </div>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <div class="form-check form-switch pb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="isActive">{{ __('Is Active') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <button type="submit" class="btn btn-primary px-5">{{ isset($banner) ? __('Update Banner') : __('Create Banner') }}</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary px-5">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
@endsection
