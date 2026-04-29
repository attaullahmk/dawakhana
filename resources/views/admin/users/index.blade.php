@extends('admin.layouts.admin')

@section('header', __('Manage Users'))

@section('content')
    <div class="card p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">{{ __('Platform Users') }}</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control" placeholder="{{ __('Search users...') }}">
                <button class="btn btn-outline-secondary">{{ __('Search') }}</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">{{ __('Avatar') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Orders') }}</th>
                        <th>{{ __('Joined') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width:40px;height:40px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </td>
                        <td class="fw-bold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin' || $user->role == 'super_admin')
                                <span class="badge bg-danger rounded-pill px-3">{{ __('Admin') }}</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">{{ __('Customer') }}</span>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $user->orders_count ?? 0 }}</span></td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <button class="btn btn-sm btn-light text-warning" title="{{ __('Edit coming soon') }}"><i class="fas fa-edit"></i></button>
                                @if($user->role != 'super_admin')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('WARNING: Are you sure you want to delete this user? This action cannot be undone.') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger" title="{{ __('Delete User') }}"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
