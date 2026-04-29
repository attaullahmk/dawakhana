@extends('admin.layouts.admin')

@section('header', __('Manage Coupons'))

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- New Coupon Form -->
        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">{{ __('Create Coupon') }}</h5>
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_active" value="1">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Code') }} <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control text-uppercase" required placeholder="{{ __('e.g. SUMMER20') }}" value="{{ old('code') }}">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">{{ __('Type') }}</label>
                            <select name="type" class="form-select">
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>{{ __('Percentage %') }}</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }} ({{ $globalSettings['currency_symbol'] ?? '$' }} )</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">{{ __('Value') }} <span class="text-danger">*</span></label>
                            <input type="number" name="value" class="form-control" required placeholder="{{ __('20') }}" value="{{ old('value') }}" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Minimum Order Amount') }}</label>
                        <input type="number" name="min_order" class="form-control" placeholder="{{ __('100.00') }}" value="{{ old('min_order') }}" min="0" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Maximum Uses') }}</label>
                        <input type="number" name="max_uses" class="form-control" placeholder="{{ __('Unlimited if blank') }}" value="{{ old('max_uses') }}" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Expiry Date') }}</label>
                        <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
                    </div>
                    <button type="submit" class="btn text-white w-100 mt-2" style="background-color: var(--primary);">{{ __('Save Coupon') }}</button>
                </form>
            </div>
        </div>

        <!-- Coupons List -->
        <div class="col-lg-8">
            <div class="card p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __('Usage') }}</th>
                                <th>{{ __('Expiry') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>
                                    <span class="badge border border-secondary text-dark rounded-0 px-3 py-2 fw-bold text-uppercase fs-6">
                                        <i class="fas fa-ticket-alt me-2 text-warning"></i>{{ $coupon->code }}
                                    </span>
                                </td>
                                <td class="fw-bold text-success">
                                    {{ $coupon->type == 'percent' ? $coupon->value . '%' : ($globalSettings['currency_symbol'] ?? '$') . ' ' . $coupon->value }} {{ __('OFF') }}
                                </td>
                                <td>{{ $coupon->used_count }} / {{ $coupon->max_uses ?: '∞' }}</td>
                                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : __('Never') }}</td>
                                <td>
                                    @if($coupon->is_active && (!$coupon->expires_at || $coupon->expires_at > now()))
                                        <span class="badge bg-success bg-opacity-25 text-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-25 text-danger">{{ __('Expired') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('{{ __('Delete this coupon?') }}');">
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
        </div>
    </div>
@endsection
