@extends('admin.layouts.admin')

@section('header', __('Manage Products'))

@section('content')
    <div class="card p-4">
        @include('admin.partials.locale-filter')
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <form class="d-flex w-100 w-md-25">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0 shadow-none" placeholder="{{ __('Search products...') }}">
                </div>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn border-0 text-white px-4 py-2 rounded-3 shadow-sm w-100 w-md-auto" style="background-color: var(--primary);">
                <i class="fas fa-plus me-2"></i> {{ __('Add Product') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">{{ __('ID') }}</th>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="text-muted fw-bold">#{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $product->main_image }}" class="rounded shadow-sm object-fit-cover" style="width: 50px; height: 50px;">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ __('SKU') }}: {{ $product->sku }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($product->category)
                                <div class="d-flex align-items-center gap-2">
                                    @if($product->category->image)
                                        <img src="{{ asset($product->category->image) }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 30px; height: 30px;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 30px; height: 30px;">
                                            <i class="fas fa-folder text-muted small"></i>
                                        </div>
                                    @endif
                                    <span class="badge bg-light text-dark border">{{ $product->category->name }}</span>
                                </div>
                            @else
                                <span class="badge bg-light text-dark border">{{ __('None') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->sale_price)
                                <span class="fw-bold text-danger">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ $product->sale_price }}</span><br>
                                <small class="text-muted text-decoration-line-through">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ $product->price }}</small>
                            @else
                                <span class="fw-bold">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ $product->price }}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->stock_quantity <= 0)
                                <span class="badge bg-danger rounded-pill">{{ __('Out of Stock') }}</span>
                            @elseif($product->stock_quantity < 10)
                                <span class="badge bg-warning rounded-pill">{{ $product->stock_quantity }} {{ __('Low') }}</span>
                            @else
                                <span class="badge bg-success rounded-pill">{{ $product->stock_quantity }} {{ __('In Stock') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success bg-opacity-25 text-success">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-25 text-secondary">{{ __('Draft') }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-light text-primary me-1"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-light text-warning me-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
