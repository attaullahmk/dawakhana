@once
    @push('styles')
        <style>
            .shop-filter-panel {
                --filter-green: var(--primary, #1a3c2e);
                --filter-gold: var(--secondary, #c8a165);
                --filter-cream: #f8f5f0;
                color: #23372d;
            }

            .shop-filter-hero {
                position: relative;
                border: 1px solid rgba(26, 60, 46, 0.08);
                border-radius: 8px;
                padding: 18px;
                background:
                    linear-gradient(135deg, rgba(26, 60, 46, 0.95), rgba(45, 106, 79, 0.9)),
                    url('https://images.unsplash.com/photo-1471193945509-9ad0617afabf?q=80&w=900&auto=format&fit=crop');
                background-size: cover;
                background-position: center;
                overflow: hidden;
                box-shadow: 0 18px 38px rgba(26, 60, 46, 0.16);
            }

            .shop-filter-hero::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(120deg, rgba(200, 161, 101, 0.16), transparent 58%);
            }

            .shop-filter-hero > * {
                position: relative;
                z-index: 1;
            }

            .shop-filter-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                border: 1px solid rgba(200, 161, 101, 0.36);
                border-radius: 50px;
                padding: 6px 11px;
                color: #f5d7a4;
                background: rgba(255, 255, 255, 0.09);
                font-size: 0.66rem;
                font-weight: 800;
                letter-spacing: 1.4px;
                text-transform: uppercase;
            }

            .shop-filter-title {
                font-family: 'Playfair Display', serif;
                color: #fff;
                line-height: 1.16;
            }

            .shop-filter-section {
                border-top: 1px solid rgba(26, 60, 46, 0.08);
                padding-top: 22px;
                margin-top: 22px;
            }

            .shop-filter-heading {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 14px;
                color: #1f2f27;
                font-size: 0.92rem;
                font-weight: 800;
            }

            .shop-filter-heading span {
                display: inline-flex;
                align-items: center;
                gap: 9px;
            }

            .shop-filter-heading i {
                color: var(--filter-gold);
            }

            .shop-search-box {
                display: flex;
                align-items: center;
                gap: 8px;
                border: 1px solid rgba(26, 60, 46, 0.11);
                border-radius: 50px;
                background: #fff;
                padding: 7px;
                box-shadow: 0 10px 26px rgba(26, 60, 46, 0.08);
                transition: border-color 0.25s ease, box-shadow 0.25s ease;
            }

            .shop-search-box:focus-within {
                border-color: rgba(200, 161, 101, 0.58);
                box-shadow: 0 14px 32px rgba(26, 60, 46, 0.12);
            }

            .shop-search-icon {
                width: 38px;
                height: 38px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
                border-radius: 50%;
                color: var(--filter-green);
                background: rgba(200, 161, 101, 0.16);
            }

            .shop-search-input {
                min-width: 0;
                border: 0 !important;
                box-shadow: none !important;
                background: transparent !important;
                font-size: 0.92rem;
            }

            .shop-filter-apply-mini {
                border: 0;
                border-radius: 50px;
                padding: 10px 15px;
                color: #fff;
                background: var(--filter-green);
                font-size: 0.82rem;
                font-weight: 800;
                white-space: nowrap;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .shop-filter-apply-mini:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 24px rgba(26, 60, 46, 0.18);
            }

            .shop-active-filters {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 14px;
            }

            .shop-filter-chip {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                border-radius: 50px;
                padding: 7px 11px;
                color: var(--filter-green);
                background: rgba(26, 60, 46, 0.07);
                font-size: 0.74rem;
                font-weight: 800;
            }

            .shop-filter-chip i {
                color: var(--filter-gold);
            }

            .shop-sort-select {
                border: 1px solid rgba(26, 60, 46, 0.12) !important;
                border-radius: 8px !important;
                padding: 13px 15px !important;
                color: var(--filter-green) !important;
                background-color: #fff !important;
                box-shadow: 0 10px 26px rgba(26, 60, 46, 0.08) !important;
                font-size: 0.92rem;
                font-weight: 800;
                cursor: pointer;
            }

            .shop-quick-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 9px;
            }

            .shop-quick-filter {
                display: flex;
                align-items: center;
                gap: 9px;
                min-height: 48px;
                border: 1px solid rgba(26, 60, 46, 0.09);
                border-radius: 8px;
                padding: 10px;
                color: #27372f;
                background: #fff;
                text-decoration: none;
                font-size: 0.78rem;
                font-weight: 850;
                line-height: 1.25;
                transition: transform 0.22s ease, border-color 0.22s ease, background 0.22s ease, box-shadow 0.22s ease;
            }

            .shop-quick-filter i {
                width: 30px;
                height: 30px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex: 0 0 auto;
                border-radius: 50%;
                color: var(--filter-green);
                background: rgba(200, 161, 101, 0.16);
            }

            .shop-quick-filter:hover,
            .shop-quick-filter.is-active {
                transform: translateY(-2px);
                border-color: rgba(200, 161, 101, 0.45);
                color: var(--filter-green);
                background: var(--filter-cream);
                box-shadow: 0 10px 24px rgba(26, 60, 46, 0.09);
            }

            .shop-category-list {
                max-height: 280px;
                overflow-y: auto;
                padding-right: 4px;
            }

            .shop-category-option,
            .shop-stock-option,
            .shop-sale-option {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                border: 1px solid rgba(26, 60, 46, 0.08);
                border-radius: 8px;
                padding: 10px 11px;
                background: #fff;
                transition: transform 0.22s ease, border-color 0.22s ease, background 0.22s ease, box-shadow 0.22s ease;
            }

            .shop-category-option + .shop-category-option,
            .shop-stock-option + .shop-stock-option {
                margin-top: 9px;
            }

            .shop-category-option:hover,
            .shop-stock-option:hover,
            .shop-sale-option:hover {
                transform: translateY(-2px);
                border-color: rgba(200, 161, 101, 0.42);
                background: var(--filter-cream);
                box-shadow: 0 10px 24px rgba(26, 60, 46, 0.08);
            }

            .shop-sale-option {
                background:
                    linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 245, 240, 0.86));
            }

            .shop-sale-ribbon {
                flex: 0 0 auto;
                border-radius: 50px;
                padding: 6px 10px;
                color: #fff;
                background: linear-gradient(135deg, var(--filter-green), #2d6a4f);
                font-size: 0.66rem;
                font-weight: 900;
                letter-spacing: 0.6px;
                text-transform: uppercase;
            }

            .shop-filter-panel .form-check {
                min-width: 0;
                margin: 0;
            }

            .shop-filter-panel .form-check-input {
                border-color: rgba(26, 60, 46, 0.32);
                box-shadow: none;
                cursor: pointer;
            }

            .shop-filter-panel .form-check-input:checked {
                background-color: var(--filter-green);
                border-color: var(--filter-green);
            }

            .shop-filter-label {
                color: #27372f;
                font-size: 0.86rem;
                font-weight: 700;
                cursor: pointer;
            }

            .shop-category-count {
                flex: 0 0 auto;
                border-radius: 50px;
                padding: 5px 9px;
                color: var(--filter-green);
                background: rgba(200, 161, 101, 0.16);
                font-size: 0.68rem;
                font-weight: 800;
            }

            .shop-price-box {
                border: 1px solid rgba(26, 60, 46, 0.08);
                border-radius: 8px;
                padding: 16px;
                background: linear-gradient(135deg, #fff 0%, var(--filter-cream) 100%);
            }

            .shop-price-value {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50px;
                padding: 7px 12px;
                color: var(--filter-green);
                background: rgba(200, 161, 101, 0.18);
                font-weight: 900;
            }

            .price-range-input {
                accent-color: var(--filter-green);
            }

            .price-range-input::-webkit-slider-thumb {
                background: var(--filter-green);
                box-shadow: 0 0 0 6px rgba(26, 60, 46, 0.12);
            }

            .shop-filter-actions {
                position: sticky;
                bottom: -1px;
                z-index: 2;
                margin-top: 24px;
                padding-top: 14px;
                background: linear-gradient(180deg, rgba(255,255,255,0), #fff 26%);
            }

            .shop-filter-submit {
                border: 0;
                border-radius: 50px;
                padding: 12px 18px;
                color: #fff;
                background: linear-gradient(135deg, var(--filter-green), #2d6a4f);
                font-weight: 900;
                box-shadow: 0 14px 30px rgba(26, 60, 46, 0.2);
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .shop-filter-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 38px rgba(26, 60, 46, 0.25);
            }

            .shop-filter-clear {
                color: #54645b;
                font-size: 0.82rem;
                font-weight: 800;
                text-decoration: none;
            }

            .shop-filter-clear:hover {
                color: var(--filter-green);
            }

            .shop-trust-strip {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
                margin-top: 16px;
            }

            .shop-trust-item {
                border: 1px solid rgba(26, 60, 46, 0.08);
                border-radius: 8px;
                padding: 9px 7px;
                text-align: center;
                color: var(--filter-green);
                background: rgba(248, 245, 240, 0.74);
                font-size: 0.66rem;
                font-weight: 850;
                line-height: 1.25;
            }

            .shop-trust-item i {
                display: block;
                color: var(--filter-gold);
                margin-bottom: 5px;
            }

            @media (max-width: 575.98px) {
                .shop-filter-hero {
                    padding: 16px;
                }

                .shop-search-box {
                    border-radius: 8px;
                    flex-wrap: wrap;
                    padding: 9px;
                }

                .shop-search-input {
                    flex: 1 1 calc(100% - 50px);
                }

                .shop-filter-apply-mini {
                    width: 100%;
                }

                .shop-category-list {
                    max-height: 235px;
                }

                .shop-quick-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush
@endonce

@php
    $filterInstance = 'shop_filter_' . uniqid();
    $selectedCats = (array) request('category', []);
    $selectedCategoryNames = $categories
        ->whereIn('slug', $selectedCats)
        ->pluck('name')
        ->take(2);
    $activeFilterCount = count($selectedCats)
        + (request('q') ? 1 : 0)
        + (request('stock') ? 1 : 0)
        + (request('sale') === 'true' ? 1 : 0)
        + ((int) request('max_price', 5000) < 5000 ? 1 : 0);
    $stockLabel = request('stock') === 'in_stock'
        ? __('In Stock')
        : (request('stock') === 'out_of_stock' ? __('Coming Soon') : null);
    $currentFilters = request()->except('page');
    $quickFilters = [
        [
            'label' => __('New Arrivals'),
            'icon' => 'fas fa-star',
            'href' => route('shop.index', array_merge($currentFilters, ['sort' => 'newest'])),
            'active' => request('sort', 'newest') === 'newest',
        ],
        [
            'label' => __('On Sale'),
            'icon' => 'fas fa-tags',
            'href' => route('shop.index', array_merge($currentFilters, ['sale' => 'true'])),
            'active' => request('sale') === 'true',
        ],
        [
            'label' => __('In Stock'),
            'icon' => 'fas fa-circle-check',
            'href' => route('shop.index', array_merge($currentFilters, ['stock' => 'in_stock'])),
            'active' => request('stock') === 'in_stock',
        ],
        [
            'label' => __('Under') . ' ' . ($globalSettings['currency_symbol'] ?? '$') . '1000',
            'icon' => 'fas fa-coins',
            'href' => route('shop.index', array_merge($currentFilters, ['max_price' => 1000])),
            'active' => (int) request('max_price', 5000) <= 1000,
        ],
    ];
@endphp

<div class="shop-filter-panel">
    <div class="shop-filter-hero mb-4">
        <span class="shop-filter-badge mb-3">
            <i class="fas fa-leaf"></i>
            {{ __('Smart Filters') }}
        </span>
        <h4 class="shop-filter-title fw-bold mb-2">
            {{ __('Find your herbal care faster') }}
        </h4>
        <p class="text-white-50 mb-0 small" style="line-height: 1.7;">
            {{ __('Search, sort, and narrow products by category, price, and availability.') }}
        </p>
    </div>

    <div class="shop-trust-strip">
        <div class="shop-trust-item">
            <i class="fas fa-shield-heart"></i>
            {{ __('Quality') }}
        </div>
        <div class="shop-trust-item">
            <i class="fas fa-truck-fast"></i>
            {{ __('Fast Delivery') }}
        </div>
        <div class="shop-trust-item">
            <i class="fas fa-headset"></i>
            {{ __('Support') }}
        </div>
    </div>

    <!-- Mobile Only Sort (Moved from top bar) -->
    <div class="shop-filter-section d-lg-none mt-0 pt-0 border-0">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-arrow-down-wide-short"></i>{{ __('Sort by') }}</span>
        </h5>
        <select name="sort" class="form-select shop-sort-select" onchange="this.form.submit()">
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('New Arrivals') }}</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price') }}: {{ __('Low to High') }}</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price') }}: {{ __('High to Low') }}</option>
        </select>
    </div>

    <div class="shop-filter-section">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-bolt"></i>{{ __('Popular Quick Filters') }}</span>
        </h5>
        <div class="shop-quick-grid">
            @foreach($quickFilters as $quick)
                <a href="{{ $quick['href'] }}" class="shop-quick-filter {{ $quick['active'] ? 'is-active' : '' }}">
                    <i class="{{ $quick['icon'] }}"></i>
                    <span>{{ $quick['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="shop-filter-section">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-magnifying-glass"></i>{{ __('Search') }}</span>
            @if($activeFilterCount > 0)
                <small class="shop-filter-chip">{{ $activeFilterCount }} {{ __('Active') }}</small>
            @endif
        </h5>
        <div class="shop-search-box">
            <span class="shop-search-icon">
                <i class="fas fa-search"></i>
            </span>
            <input type="text"
                name="q"
                class="form-control shop-search-input px-1"
                placeholder="{{ __('Search herbal products...') }}"
                value="{{ request('q') }}">
            <button type="submit" class="shop-filter-apply-mini">
                {{ __('Apply') }}
            </button>
        </div>

        @if($activeFilterCount > 0)
            <div class="shop-active-filters">
                @if(request('q'))
                    <span class="shop-filter-chip"><i class="fas fa-search"></i>{{ \Illuminate\Support\Str::limit(request('q'), 16) }}</span>
                @endif
                @foreach($selectedCategoryNames as $catName)
                    <span class="shop-filter-chip"><i class="fas fa-tag"></i>{{ \Illuminate\Support\Str::limit($catName, 16) }}</span>
                @endforeach
                @if(count($selectedCats) > 2)
                    <span class="shop-filter-chip">+{{ count($selectedCats) - 2 }}</span>
                @endif
                @if((int) request('max_price', 5000) < 5000)
                    <span class="shop-filter-chip"><i class="fas fa-coins"></i>{{ $globalSettings['currency_symbol'] ?? '$' }} {{ request('max_price') }}</span>
                @endif
                @if(request('sale') === 'true')
                    <span class="shop-filter-chip"><i class="fas fa-tags"></i>{{ __('On Sale') }}</span>
                @endif
                @if($stockLabel)
                    <span class="shop-filter-chip"><i class="fas fa-box"></i>{{ $stockLabel }}</span>
                @endif
            </div>
        @endif
    </div>

    <div class="shop-filter-section">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-layer-group"></i>{{ __('Categories') }}</span>
            <small class="text-muted">{{ $categories->count() }}</small>
        </h5>
        <div class="shop-category-list custom-scrollbar">
            @foreach($categories as $category)
                @php $catId = $filterInstance . '_cat_' . $category->id; @endphp
                <label class="shop-category-option" for="{{ $catId }}">
                    <span class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input"
                            type="checkbox"
                            name="category[]"
                            value="{{ $category->slug }}"
                            id="{{ $catId }}"
                            {{ in_array($category->slug, $selectedCats) ? 'checked' : '' }}>
                        <span class="shop-filter-label">{{ $category->name }}</span>
                    </span>
                    <span class="shop-category-count">{{ $category->products_count }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="shop-filter-section">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-percent"></i>{{ __('Special Offers') }}</span>
        </h5>
        @php $saleId = $filterInstance . '_sale'; @endphp
        <label class="shop-sale-option" for="{{ $saleId }}">
            <span class="form-check d-flex align-items-center gap-2">
                <input class="form-check-input"
                    type="checkbox"
                    name="sale"
                    value="true"
                    id="{{ $saleId }}"
                    {{ request('sale') === 'true' ? 'checked' : '' }}>
                <span class="shop-filter-label">
                    <i class="fas fa-tags text-secondary-custom me-1"></i>
                    {{ __('Show discounted products') }}
                </span>
            </span>
            <span class="shop-sale-ribbon">{{ __('Sale') }}</span>
        </label>
    </div>

    <div class="shop-filter-section">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-coins"></i>{{ __('Price') }}</span>
        </h5>
        <div class="shop-price-box">
            <input type="range"
                name="max_price"
                class="form-range price-range-input"
                min="0"
                max="5000"
                step="50"
                value="{{ request('max_price', 5000) }}">
            <div class="d-flex justify-content-between align-items-center small mt-3">
                <span class="text-muted">{{ $globalSettings['currency_symbol'] ?? '$' }} 0</span>
                <span class="shop-price-value price-display-text">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ request('max_price', 5000) }}</span>
            </div>
        </div>
    </div>

    <div class="shop-filter-section">
        <h5 class="shop-filter-heading">
            <span><i class="fas fa-boxes-stacked"></i>{{ __('Availability') }}</span>
        </h5>

        @php
            $stockOptions = [
                ['id' => 'all_stock', 'value' => '', 'label' => __('All Status'), 'icon' => 'fas fa-border-all'],
                ['id' => 'instock', 'value' => 'in_stock', 'label' => __('In Stock'), 'icon' => 'fas fa-circle-check'],
                ['id' => 'outstock', 'value' => 'out_of_stock', 'label' => __('Coming Soon'), 'icon' => 'fas fa-clock'],
            ];
        @endphp

        @foreach($stockOptions as $stock)
            @php $stockId = $filterInstance . '_' . $stock['id']; @endphp
            <label class="shop-stock-option" for="{{ $stockId }}">
                <span class="form-check d-flex align-items-center gap-2">
                    <input class="form-check-input"
                        type="radio"
                        name="stock"
                        id="{{ $stockId }}"
                        value="{{ $stock['value'] }}"
                        {{ request('stock') == $stock['value'] || (!request('stock') && $stock['value'] === '') ? 'checked' : '' }}>
                    <span class="shop-filter-label">
                        <i class="{{ $stock['icon'] }} text-secondary-custom me-1"></i>
                        {{ $stock['label'] }}
                    </span>
                </span>
            </label>
        @endforeach
    </div>

    <div class="shop-filter-actions">
        <button type="submit" class="shop-filter-submit w-100">
            <i class="fas fa-sliders me-2"></i>{{ __('Apply Filters') }}
        </button>
        <a href="{{ route('shop.index') }}" class="shop-filter-clear w-100 mt-3 text-center d-block">
            <i class="fas fa-rotate-left me-1"></i>{{ __('Clear All') }}
        </a>
    </div>
</div>
