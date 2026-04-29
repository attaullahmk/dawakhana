@extends('layouts.app')

@section('content')
    <div class="page-header text-center" style="background-color: var(--primary); padding: 80px 0 40px; margin-top: 50px; color: var(--white);">
        <div class="container pt-5">
            <h1 class="playfair display-4 mb-2">{{ __('My Account') }}</h1>
        </div>
    </div>

    <section class="py-5 bg-white min-vh-100">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-3 mb-5 mb-lg-0">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                        <div class="card-body p-4 text-center">
                            @php
                                $initials = collect(explode(' ', $user->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                            @endphp
                            <div class="bg-primary-custom text-white d-flex align-items-center justify-content-center mx-auto rounded-circle mb-3 fs-3" style="width: 80px; height: 80px;">
                                {{ strtoupper($initials) }}
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted small mb-4">{{ $user->email }}</p>
                            @php
                                $activeTab = (session('active_tab') == 'settings' || $errors->any()) ? 'settings' : 'dashboard';
                            @endphp
                            
                            <div class="nav flex-column nav-pills text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link {{ $activeTab == 'dashboard' ? 'active' : '' }} text-start rounded-pill mb-2 px-4 py-3" data-bs-toggle="pill" data-bs-target="#dashboard" type="button" role="tab">
                                    <i class="fas fa-home me-2"></i> {{ __('Dashboard') }}
                                </button>
                                <button class="nav-link text-start rounded-pill mb-2 px-4 py-3" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab">
                                    <i class="fas fa-box me-2"></i> {{ __('My Orders') }}
                                </button>
                                <button class="nav-link {{ $activeTab == 'settings' ? 'active' : '' }} text-start rounded-pill mb-2 px-4 py-3" data-bs-toggle="pill" data-bs-target="#settings" type="button" role="tab">
                                    <i class="fas fa-cog me-2"></i> {{ __('Settings') }}
                                </button>
                                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">@csrf</form>
                                <a href="#" class="nav-link text-start rounded-pill text-danger px-4 py-3 mt-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 ps-lg-5">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Dashboard -->
                        <div class="tab-pane fade {{ $activeTab == 'dashboard' ? 'show active' : '' }}" id="dashboard" role="tabpanel">
                            <h3 class="playfair mb-4">{{ __('Dashboard') }}</h3>
                            <p class="text-muted mb-4">{{ __('Hello') }} {{ $user->name }}! {{ __("From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.") }}</p>
                            
                            <div class="row g-4 mb-5">
                                <div class="col-md-4">
                                    <div class="card border border-opacity-25 shadow-sm rounded-4 text-center h-100 py-4">
                                        <div class="card-body">
                                             <i class="fas fa-box text-secondary-custom fs-1 mb-3"></i>
                                            <h2 class="fw-bold mb-1">{{ $ordersCount }}</h2>
                                            <p class="text-muted mb-0">{{ __('Total Orders') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border border-opacity-25 shadow-sm rounded-4 text-center h-100 py-4">
                                        <div class="card-body">
                                            <i class="far fa-heart text-secondary-custom fs-1 mb-3"></i>
                                            <h2 class="fw-bold mb-1">{{ $wishlistCount }}</h2>
                                            <p class="text-muted mb-0">{{ __('Wishlist Items') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border border-opacity-25 shadow-sm rounded-4 text-center h-100 py-4">
                                        <div class="card-body">
                                            <i class="fas fa-map-marker-alt text-secondary-custom fs-1 mb-3"></i>
                                            <h2 class="fw-bold mb-1">{{ $addressCount }}</h2>
                                            <p class="text-muted mb-0">{{ __('Saved Addresses') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Orders -->
                        <div class="tab-pane fade" id="orders" role="tabpanel">
                            <h3 class="playfair mb-4">{{ __('My Orders') }}</h3>
                            @if($orders->count() > 0)
                                <div class="table-responsive bg-white rounded-4 border">
                                    <table class="table align-middle text-center mb-0">
                                        <thead class="bg-light text-muted small text-uppercase">
                                            <tr>
                                                <th class="py-3 px-4 text-start">{{ __('Order ID') }}</th>
                                                <th class="py-3">{{ __('Date') }}</th>
                                                <th class="py-3">{{ __('Status') }}</th>
                                                <th class="py-3">{{ __('Total') }}</th>
                                                <th class="py-3">{{ __('Payment') }}</th>
                                                <th class="py-3">{{ __('Remarks') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td class="text-start py-3 px-4">
                                                        <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                                                    </td>
                                                    <td class="text-muted small py-3">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td class="py-3">
                                                        @php
                                                            $badgeClass = [
                                                                'pending' => 'bg-warning text-dark',
                                                                'processing' => 'bg-info text-white',
                                                                'shipped' => 'bg-primary text-white',
                                                                'delivered' => 'bg-success text-white',
                                                                'cancelled' => 'bg-danger text-white'
                                                            ][$order->status] ?? 'bg-secondary text-white';
                                                        @endphp
                                                        <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2 text-uppercase" style="font-size: 0.75rem;">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>
                                                    <td class="fw-bold text-primary-custom py-3">
                                                        {{ $globalSettings['currency_symbol'] ?? '$' }} {{ number_format($order->total, 2) }}
                                                    </td>
                                                    <td class="text-muted small text-uppercase py-3">
                                                        {{ str_replace('_', ' ', $order->payment_method) }}
                                                    </td>
                                                    <td class="py-3">
                                                        @if($order->admin_remarks)
                                                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $order->admin_remarks }}">
                                                                <i class="fas fa-info-circle me-1"></i> {{ __('View') }}
                                                            </button>
                                                            <div class="d-none d-md-block text-muted small mt-1" style="max-width: 150px; font-style: italic;">
                                                                "{{ Str::limit($order->admin_remarks, 30) }}"
                                                            </div>
                                                        @else
                                                            <span class="text-muted small">{{ __('No remarks') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5 bg-light rounded-4 border">
                                    <i class="fas fa-box-open fs-1 text-muted mb-3 opacity-50" style="font-size: 3rem !important;"></i>
                                    <h5>{{ __('No orders found') }}</h5>
                                    <p class="text-muted">{{ __('You haven\'t placed any orders yet.') }}</p>
                                    <a href="{{ route('shop.index') }}" class="btn btn-outline-dark rounded-pill px-4 mt-2">{{ __('Go to Shop') }}</a>
                                </div>
                            @endif
                        </div>

                        <!-- Settings -->
                        <div class="tab-pane fade {{ $activeTab == 'settings' ? 'show active' : '' }}" id="settings" role="tabpanel">
                            <h3 class="playfair mb-4">{{ __('Account Settings') }}</h3>
                             <div class="card border-0 shadow-sm rounded-4 border border-opacity-25 p-4">
                                <form action="{{ route('account.update') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Full Name') }}</label>
                                            <input type="text" name="name" class="form-control rounded-pill px-4 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                            @error('name') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Email (Cannot be changed)') }}</label>
                                            <input type="email" class="form-control rounded-pill px-4 text-muted" value="{{ $user->email }}" readonly style="background-color: #f8f9fa;">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Phone Number') }}</label>
                                            <input type="text" name="phone" class="form-control rounded-pill px-4 @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                            @error('phone') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Address') }}</label>
                                            <input type="text" name="address" class="form-control rounded-pill px-4 @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}">
                                            @error('address') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                                        </div>

                                        <hr class="my-4">
                                        <h5 class="playfair mb-3">{{ __('Change Password') }}</h5>
                                        <p class="small text-muted mb-2">{{ __('Leave blank if you don\'t want to change it.') }}</p>

                                        <div class="col-md-12">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Current Password') }}</label>
                                            <div class="input-group">
                                                <input type="password" name="current_password" id="current_password" class="form-control rounded-start-pill ps-4 shadow-none py-2 border-end-0 @error('current_password') is-invalid @enderror">
                                                <button class="btn btn-outline-secondary border-start-0 rounded-end-pill px-3 py-2 bg-white text-muted shadow-none @error('current_password') border-danger @enderror" type="button" data-toggle-password="current_password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @error('current_password') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('New Password') }}</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password" id="new_password" class="form-control rounded-start-pill ps-4 shadow-none py-2 border-end-0 @error('new_password') is-invalid @enderror">
                                                <button class="btn btn-outline-secondary border-start-0 rounded-end-pill px-3 py-2 bg-white text-muted shadow-none @error('new_password') border-danger @enderror" type="button" data-toggle-password="new_password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @error('new_password') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold small text-uppercase">{{ __('Confirm New Password') }}</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control rounded-start-pill ps-4 shadow-none py-2 border-end-0">
                                                <button class="btn btn-outline-secondary border-start-0 rounded-end-pill px-3 py-2 bg-white text-muted shadow-none" type="button" data-toggle-password="new_password_confirmation">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4 text-center">
                                            <button type="submit" class="btn btn-primary-custom rounded-pill px-5 py-2">{{ __('Save Changes') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<style>
    .nav-pills .nav-link { color: var(--text-dark); transition: all 0.3s; }
    .nav-pills .nav-link.active { background-color: var(--primary) !important; color: white !important; font-weight: bold; }
    .nav-pills .nav-link:not(.active):hover { background-color: var(--background); color: var(--primary); }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
