@extends('admin.layouts.admin')

@section('header', __('Edit Product'))

@section('content')
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">{{ __('Basic Information') }}</h5>
                        <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt me-1"></i> {{ __('View Live') }}</a>
                    </div>
                    @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', $product->locale ?? 'en')])

                    
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Short Description') }}</label>
                        <textarea class="form-control" name="short_description" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Full Description') }}</label>
                        <textarea class="form-control" name="description" rows="6">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-4">{{ __('Media') }}</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block">{{ __('Current Images') }}</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="position-relative border rounded p-1" style="width: 100px; height: 100px;">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-1 z-1">{{ __('Main') }}</span>
                                <img src="{{ $product->main_image }}" class="w-100 h-100 object-fit-cover rounded">
                            </div>
                            @foreach($product->images as $img)
                                <div class="position-relative border rounded p-1" style="width: 100px; height: 100px;">
                                    <form action="{{ route('admin.products.images.destroy', $img->id) }}" method="POST" class="position-absolute top-0 end-0 m-1 z-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger p-0" style="width: 20px; height: 20px;" type="submit" onclick="return confirm('{{ __('Remove this image?') }}')">
                                            <i class="fas fa-times" style="font-size: 0.7rem;"></i>
                                        </button>
                                    </form>
                                    <img src="{{ $img->image_path }}" class="w-100 h-100 object-fit-cover rounded">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Main Image Upload with Preview --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Update Main Image') }}</label>
                        <div class="border rounded p-3 text-center bg-light position-relative" 
                             onclick="document.getElementById('main_image').click()" 
                             style="cursor: pointer; min-height: 140px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <div id="main-image-placeholder">
                                <i class="fas fa-cloud-upload-alt fs-2 text-muted mb-2 d-block"></i>
                                <p class="mb-0 small text-muted">{{ __('Click to upload a new main image') }}</p>
                            </div>
                            <img id="main-image-preview" src="#" alt="Preview" 
                                 class="d-none w-100 h-100 object-fit-cover rounded" 
                                 style="max-height: 200px; position:absolute; top:0; left:0;">
                        </div>
                        <input type="file" name="main_image" id="main_image" class="d-none" accept="image/*">
                        <div id="main-image-name" class="form-text d-none">
                            <i class="fas fa-check-circle text-success me-1"></i>
                            <span></span> — <a href="#" onclick="clearMainImage(event)" class="text-danger small">{{ __('Remove') }}</a>
                        </div>
                    </div>

                    {{-- Additional Images Upload with Preview --}}
                    <div>
                        <label class="form-label fw-bold">{{ __('Add Additional Images') }}</label>
                        <input type="file" name="additional_images[]" id="additional_images" class="form-control" accept="image/*" multiple>
                        <div class="form-text">{{ __('New images will be appended to the product carousel.') }}</div>
                        
                        {{-- Additional images preview strip --}}
                        <div id="additional-previews" class="d-flex flex-wrap gap-2 mt-3"></div>
                    </div>
                </div>
                
                <!-- Pricing & Inventory -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-4">{{ __('Pricing') }}</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Regular Price') }} ({{ $globalSettings['currency_symbol'] ?? '$' }} ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" step="0.01" class="form-control" required value="{{ old('price', $product->price) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Sale Price') }} ({{ $globalSettings['currency_symbol'] ?? '$' }} )</label>
                                <input type="number" name="sale_price" step="0.01" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-4">{{ __('Inventory') }}</h5>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('SKU') }}</label>
                                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Stock Quantity') }} <span class="text-danger">*</span></label>
                                <input type="number" name="stock_quantity" class="form-control" required value="{{ old('stock_quantity', $product->stock_quantity) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Form -->
            <div class="col-lg-4">
                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-4">{{ __('Organization') }}</h5>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Category') }}</label>
                        <select class="form-select" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Status') }}</label>
                        <select class="form-select" name="is_active">
                            <option value="1" {{ $product->is_active ? 'selected' : '' }}>{{ __('Active (Published)') }}</option>
                            <option value="0" {{ !$product->is_active ? 'selected' : '' }}>{{ __('Draft') }}</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="featured" {{ $product->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold ms-2" for="featured">{{ __('Featured Product') }}</label>
                        </div>
                    </div>
                </div>

                <div class="card p-4">
                    <h5 class="fw-bold mb-4">{{ __('Actions') }}</h5>
                    <button type="submit" class="btn text-white w-100 mb-2 py-2" style="background-color: var(--primary);">{{ __('Update Product') }}</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100 py-2">{{ __('Cancel') }}</a>
                    
                    <hr class="my-4">
                    
                    <button type="button" class="btn btn-outline-danger w-100" onclick="if(confirm('{{ __('Are you sure you want to delete this product?') }}')) document.getElementById('delete-form-{{ $product->id }}').submit();">
                        <i class="fas fa-trash me-2"></i> {{ __('Delete Product') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
    
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    // Preview for Single Main Image
    document.getElementById('main_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('main-image-preview');
        const placeholder = document.getElementById('main-image-placeholder');
        const info = document.getElementById('main-image-name');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
                
                info.classList.remove('d-none');
                info.querySelector('span').textContent = file.name;
            }
            reader.readAsDataURL(file);
        }
    });

    function clearMainImage(e) {
        if(e) e.preventDefault();
        const input = document.getElementById('main_image');
        const preview = document.getElementById('main-image-preview');
        const placeholder = document.getElementById('main-image-placeholder');
        const info = document.getElementById('main-image-name');

        input.value = '';
        preview.src = '#';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
        info.classList.add('d-none');
    }

    // Advanced Multiple Image Handling for NEW uploads
    let additionalFilesArray = [];
    const additionalInput = document.getElementById('additional_images');
    const additionalContainer = document.getElementById('additional-previews');

    additionalInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);
        
        // Add new files to our tracking array
        additionalFilesArray = [...additionalFilesArray, ...newFiles];
        
        updateAdditionalPreviews();
        syncAdditionalInput();
    });

    function updateAdditionalPreviews() {
        additionalContainer.innerHTML = '';
        
        additionalFilesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'position-relative border rounded p-1';
                div.style.width = '100px';
                div.style.height = '100px';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-100 h-100 object-fit-cover rounded">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-0 shadow-sm d-flex align-items-center justify-content-center" 
                            style="width: 22px; height: 22px; border-radius: 50%;"
                            onclick="removeNewAdditionalFile(${index})">
                        <i class="fas fa-times" style="font-size: 0.7rem;"></i>
                    </button>
                    <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-50 text-white" style="font-size: 0.6rem; padding: 2px 4px;">
                         ${(file.size / 1024).toFixed(0)} KB
                    </div>
                `;
                additionalContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }

    function removeNewAdditionalFile(index) {
        additionalFilesArray.splice(index, 1);
        updateAdditionalPreviews();
        syncAdditionalInput();
    }

    function syncAdditionalInput() {
        const dataTransfer = new DataTransfer();
        additionalFilesArray.forEach(file => dataTransfer.items.add(file));
        additionalInput.files = dataTransfer.files;
    }
</script>

<style>
    .hover-opacity-100:hover { opacity: 1 !important; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .border-dashed { border-style: dashed !important; }
</style>
@endpush
