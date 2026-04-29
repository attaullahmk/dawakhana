<!-- Top Bar (Simplified on Mobile) -->
<div class="d-flex flex-row justify-content-between align-items-center mb-4 pb-3 border-bottom">
    <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-primary-custom d-lg-none rounded-pill px-4 shadow-sm fw-bold border-2" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
            <i class="fas fa-filter me-2"></i> {{ __('Filter') }}
        </button>
        <p class="text-dark mb-0 small d-none d-lg-block">{{ __('Showing') }} {{ $products->count() }} {{ __('results') }}</p>
    </div>
    
    <!-- Desktop Only Sort -->
    <div class="d-none d-lg-flex align-items-center gap-3">
        <div class="d-flex align-items-center">
            <span class="me-2 text-dark text-nowrap small">{{ __('Sort by') }}:</span>
            <select name="sort" class="form-select border-0 shadow-sm rounded-pill small px-4" style="width: auto; min-width: 150px;" onchange="this.form.dispatchEvent(new Event('submit'))">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('New Arrivals') }}</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price') }}: {{ __('Low to High') }}</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price') }}: {{ __('High to Low') }}</option>
            </select>
        </div>
    </div>
</div>

<!-- Products -->
<div class="row g-4">
    @forelse($products as $product)
        <div class="col-sm-6 col-md-4" data-aos="fade-up">
            @include('partials.product-card', ['product' => $product])
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-box-open fs-1 text-muted mb-3 opacity-25" style="font-size: 4rem !important;"></i>
            <h3 class="playfair fw-bold">{{ __('No Products Found') }}</h3>
            <p class="text-muted">{{ __("We couldn't find any products matching your criteria.") }}</p>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 mt-3">{{ __('Clear Filters') }}</a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-5 d-flex justify-content-center">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
