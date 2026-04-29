@extends('layouts.app')

@section('content')
    <!-- Page Header (Hidden on Mobile) -->
    <div class="page-header text-center d-none d-md-block" style="background-color: var(--primary); padding: 80px 0 60px; margin-top: 50px; color: var(--white);">
        <div class="container pb-3 pt-5">
            <h1 class="playfair display-4 mb-3">{{ __('Shop Our Collection') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white text-decoration-none">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active text-secondary-custom" aria-current="page">{{ __('Shop') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Shop Content -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <form action="{{ route('shop.index') }}" method="GET" id="filter-form">
                <div class="row">
                    <!-- Desktop Sidebar Filters (Hidden on Mobile) -->
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="filter-sidebar shadow-sm p-4 rounded-4 border sticky-top custom-scrollbar" style="top: 100px; background: #fff; max-height: calc(100vh - 130px); overflow-y: auto;">
                            @include('partials.shop-filters')
                        </div>
                    </div>

                    <!-- Mobile Filter Offcanvas -->
                    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
                        <div class="offcanvas-header bg-primary-custom text-white">
                            <h5 class="offcanvas-title playfair fw-bold" id="filterOffcanvasLabel">{{ __('Filter') }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body p-4">
                            @include('partials.shop-filters')
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="col-lg-9" id="product-list-container">
                        @include('pages.shop.partials.product-list')
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle sync between Desktop and Mobile Price Sliders
        const priceInputs = document.querySelectorAll('.price-range-input');
        const priceDisplays = document.querySelectorAll('.price-display-text');
        
        priceInputs.forEach(input => {
            input.addEventListener('input', function() {
                const val = this.value;
                priceInputs.forEach(i => i.value = val);
                priceDisplays.forEach(d => d.textContent = window.currencySymbol + val);
            });
            input.addEventListener('change', function() {
                document.getElementById('filter-form').dispatchEvent(new Event('submit', { cancelable: true }));
            });
        });

        // AJAX Filtering
        const filterForm = document.getElementById('filter-form');
        const container = document.getElementById('product-list-container');

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchResults(new URLSearchParams(new FormData(filterForm)).toString());
        });

        // Handle pagination clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = new URL(e.target.closest('.pagination a').href);
                fetchResults(url.search);
            }
        });

        function fetchResults(queryString) {
            // Add a small loading state
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';

            fetch(`{{ route('shop.index') }}?${queryString}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
                
                // Update URL to keep state copyable
                window.history.pushState(null, '', `?${queryString}`);

                // Re-initialize AOS if needed or trigger tooltips
                if (typeof AOS !== 'undefined') {
                    AOS.init();
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                container.style.opacity = '1';
                container.style.pointerEvents = 'auto';
            });
        }
    });
</script>
@endpush
