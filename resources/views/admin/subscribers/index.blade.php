@extends('admin.layouts.admin')

@section('header', __('Subscribers'))

@section('content')
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">{{ __('Newsletter Subscribers') }}</h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3 border-0 py-3 rounded-start">{{ __('Subscription Date') }}</th>
                        <th class="border-0 py-3">{{ __('Email Address') }}</th>
                        <th class="text-end pe-3 border-0 py-3 rounded-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                    <tr>
                        <td class="ps-3">{{ $subscriber->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-secondary-custom opacity-50 me-2"></i>
                                <span class="fw-bold">{{ $subscriber->email }}</span>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle" style="width: 32px; height: 32px; transition: all 0.2s;" onclick="return confirm('{{ __('Are you sure you want to remove this subscriber?') }}')" onmouseover="this.classList.replace('btn-light', 'btn-danger'); this.classList.replace('text-danger', 'text-white');" onmouseout="this.classList.replace('btn-danger', 'btn-light'); this.classList.replace('text-white', 'text-danger');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fs-1 text-light mb-3"></i>
                            <h5>{{ __('No subscribers yet') }}</h5>
                            <p>{{ __('When users subscribe to the newsletter, they will appear here.') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
