@extends('admin.layouts.admin')

@section('header', __('Edit Post'))

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

    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', $post->locale ?? 'en')])
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">{{ __('Post Content') }}</h5>
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt me-1"></i> {{ __('View Live') }}</a>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Post Title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg playfair" name="title" required placeholder="{{ __('Enter an engaging title...') }}" value="{{ old('title', $post->title) }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Excerpt') }}</label>
                        <textarea class="form-control" name="excerpt" rows="2" placeholder="{{ __('Summary of the post...') }}">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">{{ __('Content') }}</label>
                        <textarea class="form-control" name="body" rows="15" placeholder="{{ __('Write your post content here...') }}">{{ old('body', $post->body) }}</textarea>
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
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Status') }}</label>
                        <select class="form-select" name="is_published">
                            <option value="0" {{ old('is_published', $post->is_published) == 0 ? 'selected' : '' }}>{{ __('Draft') }}</option>
                            <option value="1" {{ old('is_published', $post->is_published) == 1 ? 'selected' : '' }}>{{ __('Published') }}</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn text-white w-100 mb-2 py-2" style="background-color: var(--primary);">{{ __('Update Post') }}</button>
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary w-100 py-2">{{ __('Cancel') }}</a>
                    </div>
                </div>
                
                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-4">{{ __('Featured Image') }}</h5>
                    @if($post->featured_image)
                        <div class="mb-3">
                            <img src="{{ asset($post->featured_image) }}" class="w-100 rounded object-fit-cover shadow-sm" style="max-height: 200px;" id="current-image">
                        </div>
                    @endif
                    <div class="border rounded border-dashed p-4 text-center bg-light cursor-pointer mb-3" onclick="document.getElementById('featured_image').click()" style="cursor: pointer;" id="image-upload-area">
                        <div id="image-preview-container" style="display: none;">
                            <img id="image-preview" class="w-100 rounded mb-2 object-fit-cover" style="max-height: 200px;">
                        </div>
                        <div id="image-placeholder">
                            <i class="fas fa-cloud-upload-alt fs-2 text-muted mb-2"></i>
                            <h6>{{ __('Click to upload a new image') }}</h6>
                            <small class="text-muted">{{ __('Leave empty to keep current image') }}</small>
                        </div>
                    </div>
                    <input type="file" name="featured_image" id="featured_image" class="d-none" accept="image/*">
                </div>

                <div class="card p-4">
                    <h5 class="fw-bold mb-4">{{ __('Danger Zone') }}</h5>
                    <button type="button" class="btn btn-outline-danger w-100" onclick="if(confirm('{{ __('Are you sure you want to delete this post?') }}')) document.getElementById('delete-form-{{ $post->id }}').submit();">
                        <i class="fas fa-trash me-2"></i> {{ __('Delete Post') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
    
    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" id="delete-form-{{ $post->id }}" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('featured_image');
        const preview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const placeholder = document.getElementById('image-placeholder');
        const currentImage = document.getElementById('current-image');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    placeholder.style.display = 'none';
                    if (currentImage) currentImage.style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
