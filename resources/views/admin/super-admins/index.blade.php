@extends('admin.layouts.admin')

@section('header', __('Manage Admin Staff'))

@section('content')
<div class="card p-4 border-0 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0">{{ __('Administrative Staff') }}</h5>
            <p class="text-muted small mb-0">{{ __('Manage and oversee your team of administrators') }}</p>
        </div>
        <a href="{{ route('admin.super-admins.create') }}" class="btn btn-primary px-4">
            <i class="fas fa-plus me-2"></i> {{ __('Add New Admin') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="px-4">{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th class="text-end px-4">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $user)
                <tr>
                    <td class="px-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="fw-bold">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'super_admin')
                            <span class="badge bg-dark text-white px-3 py-2 rounded-pill">{{ __('Super Admin') }}</span>
                        @else
                            <span class="badge bg-secondary text-white px-3 py-2 rounded-pill">{{ __('Admin') }}</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end px-4">
                        @if($user->role !== 'super_admin')
                        <form action="{{ route('admin.super-admins.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to remove this Admin?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-muted small italic">{{ __('Protected') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">{{ __('No administrative staff found.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
