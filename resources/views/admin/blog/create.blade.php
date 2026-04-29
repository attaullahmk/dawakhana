@extends('admin.layouts.admin')

@section('header', __('Write Post'))

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', 'en')])
                <div class="card p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Post Title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg playfair" name="title" required placeholder="{{ __('Enter an engaging title...') }}" value="{{ old('title') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Excerpt') }}</label>
                        <textarea class="form-control" name="excerpt" rows="2" placeholder="{{ __('Summary of the post...') }}">{{ old('excerpt') }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">{{ __('Content') }}</label>
                        <textarea class="form-control" name="body" rows="15" placeholder="{{ __('Write your post content here...') }}">{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-4">{{ __('Publishing') }}</h5>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Category') }}</label>
                        <select class="form-select" name="category_id">
                            <option value="">{{ __('Uncategorized') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Status') }}</label>
                        <select class="form-select" name="is_published">
                            <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                            <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>{{ __('Published') }}</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn text-white w-100" style="background-color: var(--primary);">{{ __('Save Post') }}</button>
                    </div>
                </div>
                
                <div class="card p-4">
                    <h5 class="fw-bold mb-4">{{ __('Featured Image') }}</h5>
                    <div class="border rounded border-dashed p-4 text-center bg-light cursor-pointer mb-3" onclick="document.getElementById('featured_image').click()" style="cursor: pointer;" id="image-upload-area">
                        <div id="image-preview-container" style="display: none;">
                            <img id="image-preview" class="w-100 rounded mb-2 object-fit-cover" style="max-height: 200px;">
                        </div>
                        <div id="image-placeholder">
                            <i class="fas fa-cloud-upload-alt fs-1 text-muted mb-3"></i>
                            <h6>{{ __('Click to upload image') }}</h6>
                            <small class="text-muted">{{ __('JPEG, PNG, GIF, WebP (Max 5MB)') }}</small>
                        </div>
                    </div>
                    <input type="file" name="featured_image" id="featured_image" class="d-none" accept="image/*">
                </div>

                <div class="card p-4 mt-4">
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary w-100">{{ __('Cancel') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('featured_image');
        const preview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const placeholder = document.getElementById('image-placeholder');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
