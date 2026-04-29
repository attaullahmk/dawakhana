@extends('admin.layouts.admin')

@section('header', __('Edit Blog Category'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">{{ __('Update Category') }}</h5>
                <form action="{{ route('admin.blog-categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', $category->locale ?? 'en')])

                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Category Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn text-white px-4" style="background-color: var(--primary);">{{ __('Update Category') }}</button>
                        <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-light px-4">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
