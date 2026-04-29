@extends('admin.layouts.admin')

@section('header', __('Manage Orders'))

@section('content')
    <div class="card p-4">
        <div class="mb-4 bg-light p-3 rounded-4 shadow-sm">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold small text-uppercase text-muted">{{ __('Search Order') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0 shadow-none" placeholder="{{ __('Search by Order ID or Name...') }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">{{ __('Status Filter') }}</label>
                    <select name="status" class="form-select shadow-none" onchange="this.form.submit()">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('Shipped') }}</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('Delivered') }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-3 py-2 fw-bold">{{ __('Search') }}</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100 rounded-3 py-2 fw-bold">{{ __('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Order ID') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Remarks') }}</th>
                        <th>{{ __('Total') }}</th>
                        <th class="text-end">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="fw-bold text-dark">#{{ $order->order_number }}</td>
                        <td>
                            <div class="fw-bold">{{ $order->user->name ?? $order->shipping_name }}</div>
                            <small class="text-muted">{{ $order->shipping_email }}</small>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <span class="badge 
                                {{ $order->status == 'delivered' ? 'bg-success' : '' }}
                                {{ $order->status == 'pending' ? 'bg-warning' : '' }}
                                {{ $order->status == 'processing' ? 'bg-info' : '' }}
                                {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-danger' : '' }}
                            ">
                                {{ __(ucfirst($order->status)) }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted d-block text-truncate" style="max-width: 150px;" title="{{ $order->admin_remarks }}">
                                {{ __($order->admin_remarks ?? 'No remarks added') }}
                            </small>
                        </td>
                        <td class="fw-bold text-success">{{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-primary update-status-btn" 
                                    data-id="{{ $order->id }}" 
                                    data-order-number="{{ $order->order_number }}"
                                    data-status="{{ $order->status }}"
                                    data-remarks="{{ $order->admin_remarks }}"
                                    data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                    <i class="fas fa-edit me-1"></i> {{ __('Status') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" id="updateStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">{{ __('Update Order Status') }}: <span id="modalOrderNumber"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">{{ __('Select New Status') }}</label>
                            <select name="status" id="modalStatusSelect" class="form-select" required>
                                <option value="pending">{{ __('Pending') }}</option>
                                <option value="processing">{{ __('Processing') }}</option>
                                <option value="shipped">{{ __('Shipped') }}</option>
                                <option value="delivered">{{ __('Delivered') }}</option>
                                <option value="cancelled">{{ __('Cancelled') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_remarks" class="form-label fw-bold">{{ __('Admin Remarks (Visible to User)') }}</label>
                            <textarea name="admin_remarks" id="modalRemarksArea" class="form-control" rows="4" placeholder="{{ __('Enter remarks for the customer...') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update Order') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateButtons = document.querySelectorAll('.update-status-btn');
        const updateForm = document.getElementById('updateStatusForm');
        const modalOrderNumber = document.getElementById('modalOrderNumber');
        const modalStatusSelect = document.getElementById('modalStatusSelect');
        const modalRemarksArea = document.getElementById('modalRemarksArea');

        updateButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const orderNumber = this.getAttribute('data-order-number');
                const status = this.getAttribute('data-status');
                const remarks = this.getAttribute('data-remarks');

                updateForm.action = `/admin/orders/${id}/status`;
                modalOrderNumber.innerText = '#' + orderNumber;
                modalStatusSelect.value = status;
                modalRemarksArea.value = remarks === 'null' ? '' : remarks;
            });
        });
    });
</script>
@endpush
