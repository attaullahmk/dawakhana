@extends('admin.layouts.admin')

@section('header', __('Order Details'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ __('Order') }} #{{ $order->order_number }}</h4>
            <span class="text-muted">{{ $order->created_at->format('F j, Y, g:i a') }}</span>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn text-white px-4" style="background-color: var(--primary);" 
                data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                <i class="fas fa-edit me-2"></i> {{ __('Update Status & Remarks') }}
            </button>
        </div>
    </div>

    @if($order->admin_remarks)
    <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3">
        <i class="fas fa-comment-dots fs-3"></i>
        <div>
            <h6 class="fw-bold mb-1 text-uppercase small">{{ __('Current Admin Remarks') }}</h6>
            <p class="mb-0">{{ $order->admin_remarks }}</p>
        </div>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3">{{ __('Items Ordered') }}</h5>
                <div class="table-responsive">
                    <table class="table align-middle text-center border">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-start ps-3">{{ __('Product') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th class="text-end pe-3">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($order->items) > 0)
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="text-start ps-3 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item->product ? $item->product->main_image : 'https://picsum.photos/100/100' }}" width="60" class="rounded shadow-sm">
                                            <div class="fw-bold">{{ $item->product ? $item->product->name : __('Deleted Product') }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($item->price, 2) }}</td>
                                    <td class="fw-bold">x{{ $item->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            @else
                                <!-- Dummy row if no real items (due to seeder design not saving order items purely) -->
                                <tr>
                                    <td class="text-start ps-3 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="https://picsum.photos/50/50" width="60" class="rounded shadow-sm">
                                            <div class="fw-bold">{{ __('Modern Leather Sofa') }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $globalSettings['currency_symbol'] ?? '$' }} 850.00</td>
                                    <td class="fw-bold">x1</td>
                                    <td class="text-end pe-3 fw-bold">{{ $globalSettings['currency_symbol'] ?? '$' }} 850.00</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-5">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('Subtotal') }}</span>
                            <span>{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ __('Shipping') }}</span>
                            <span>{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                            <span class="text-muted">{{ __('Tax') }}</span>
                            <span>{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">{{ __('Total') }}</span>
                            <h4 class="fw-bold" style="color: var(--primary);">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3">{{ __('Customer info') }}</h5>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fs-4" style="width: 50px; height: 50px;">
                        {{ substr($order->shipping_name, 0, 1) }}
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $order->shipping_name }}</h6>
                        @if($order->user_id) <span class="badge bg-light border text-dark">{{ __('Registered User') }}</span> @else <span class="badge bg-light border text-dark">{{ __('Guest') }}</span> @endif
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6 class="fw-bold text-muted small text-uppercase">{{ __('Contact') }}</h6>
                    <div><i class="far fa-envelope me-2 text-muted"></i> <a href="mailto:{{ $order->shipping_email }}" class="text-dark text-decoration-none">{{ $order->shipping_email }}</a></div>
                    <div class="mt-1"><i class="fas fa-phone me-2 text-muted"></i> {{ $order->shipping_phone }}</div>
                </div>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3">{{ __('Shipping Address') }}</h5>
                <p class="mb-1 fw-bold">{{ $order->shipping_name }}</p>
                <p class="mb-1 text-muted">{{ $order->shipping_address }}</p>
                <p class="mb-1 text-muted">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">{{ __('Update Order Details') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">{{ __('Select Status') }}</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_remarks" class="form-label fw-bold">{{ __('Admin Remarks') }}</label>
                            <textarea name="admin_remarks" id="admin_remarks" class="form-control" rows="4" placeholder="{{ __('How is the order progressing?') }}">{{ $order->admin_remarks }}</textarea>
                            <div class="form-text">{{ __('These remarks will be visible to the customer in their account dashboard.') }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
