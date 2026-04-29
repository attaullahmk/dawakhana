@extends('admin.layouts.admin')

@section('header', __('Manage Reviews'))

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card p-4">
        <h5 class="fw-bold mb-4">{{ __('Customer Reviews') }}</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Rating') }}</th>
                        <th>{{ __('Review') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $review->product->main_image ?? 'https://picsum.photos/50/50' }}" width="40" height="40" class="rounded object-fit-cover shadow-sm">
                                <small class="fw-bold text-truncate" style="max-width: 150px;">{{ $review->product->name ?? __('Deleted Product') }}</small>
                            </div>
                        </td>
                        <td class="fw-bold">{{ $review->user->name ?? __('Unknown') }}</td>
                        <td class="text-warning">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted opacity-25' }}"></i>
                            @endfor
                        </td>
                        <td>
                            <strong>{{ $review->title }}</strong>
                            <p class="mb-0 small text-muted text-truncate" style="max-width: 300px;">{{ $review->body }}</p>
                        </td>
                        <td>
                            @if($review->is_approved)
                                <span class="badge bg-success bg-opacity-25 text-success">{{ __('Approved') }}</span>
                            @else
                                <span class="badge bg-warning bg-opacity-25 text-warning">{{ __('Pending') }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if($review->is_approved)
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="{{ __('Hide Review') }}"><i class="fas fa-eye-slash"></i></button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-success" title="{{ __('Approve Review') }}"><i class="fas fa-check"></i></button>
                                    @endif
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this review?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="{{ __('Delete Review') }}"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
