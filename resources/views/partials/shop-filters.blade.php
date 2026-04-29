
<!-- Mobile Only Sort (Moved from top bar) -->
<div class="mb-5 d-lg-none">
    <h5 class="filter-group-title fw-bold playfair border-bottom pb-2 mb-3 text-dark" style="border-color: rgba(0,0,0,0.1) !important;">{{ __('Sort by') }}</h5>
    <div class="position-relative">
        <select name="sort" class="form-select border-2 bg-white rounded-pill shadow-sm py-3 px-4 fw-bold text-primary-custom appearance-none transition hover-lift" onchange="this.form.submit()" style="cursor: pointer; font-size: 0.95rem;">
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('New Arrivals') }}</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price') }}: {{ __('Low to High') }}</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price') }}: {{ __('High to Low') }}</option>
        </select>
    </div>
</div>

<div class="mb-5 mt-2">
    <div class="d-flex bg-white rounded-pill shadow-sm border overflow-hidden p-1">
        <div class="input-group border-0 align-items-center">
            <span class="bg-transparent border-0 ps-3 pe-2 text-muted">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" name="q" class="form-control border-0 shadow-none bg-transparent px-2" placeholder="{{ __('Search products...') }}" value="{{ request('q') }}" style="font-size: 0.95rem;">
        </div>
        <button type="submit" class="btn btn-primary-custom rounded-pill px-4 fw-bold shadow-sm" style="font-size: 0.9rem;">
            {{ __('Apply') }}
        </button>
    </div>
</div>

<div class="mb-4">
    <h5 class="filter-group-title fw-bold playfair border-bottom pb-2 mb-3 text-dark" style="border-color: rgba(0,0,0,0.1) !important;">{{ __('Categories') }}</h5>
    <ul class="list-unstyled mb-0">
        @php
            $selectedCats = (array) request('category', []);
        @endphp
        @foreach($categories as $category)
            <li class="mb-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->slug }}" id="cat_{{ $category->id }}" {{ in_array($category->slug, $selectedCats) ? 'checked' : '' }}>
                    <label class="form-check-label text-dark small" for="cat_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
                <span class="badge bg-light text-dark rounded-pill" style="font-size: 0.7rem;">{{ $category->products_count }}</span>
            </li>
        @endforeach
    </ul>
</div>

<div class="mb-4">
    <h5 class="filter-group-title fw-bold playfair border-bottom pb-2 mb-3 text-dark" style="border-color: rgba(0,0,0,0.1) !important;">{{ __('Price') }}</h5>
    <input type="range" name="max_price" class="form-range price-range-input" min="0" max="5000" step="50" value="{{ request('max_price', 5000) }}">
    <div class="d-flex justify-content-between text-dark small mt-2">
        <span>{{ $globalSettings['currency_symbol'] ?? '$' }} 0</span>
        <span class="fw-bold text-primary-custom price-display-text">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ request('max_price', 5000) }}</span>
    </div>
</div>

<div class="mb-4">
    <h5 class="filter-group-title fw-bold playfair border-bottom pb-2 mb-3 text-dark" style="border-color: rgba(0,0,0,0.1) !important;">{{ __('Availability') }}</h5>
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="stock" id="all_stock" value="" {{ !request('stock') ? 'checked' : '' }}>
        <label class="form-check-label text-dark small" for="all_stock">
            {{ __('All Status') }}
        </label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="stock" id="instock" value="in_stock" {{ request('stock') == 'in_stock' ? 'checked' : '' }}>
        <label class="form-check-label text-dark small" for="instock">{{ __('In Stock') }}</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="stock" id="outstock" value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'checked' : '' }}>
        <label class="form-check-label text-dark small" for="outstock">
            {{ __('Coming Soon') }}
        </label>
    </div>
</div>

<button type="submit" class="btn btn-primary-custom w-100 rounded-pill mt-3 shadow-sm py-2 fw-bold">
    {{ __('Apply Filters') }}
</button>
<a href="{{ route('shop.index') }}" class="btn btn-link w-100 text-dark small mt-2 text-decoration-none text-center d-block">
    {{ __('Clear All') }}
</a>
