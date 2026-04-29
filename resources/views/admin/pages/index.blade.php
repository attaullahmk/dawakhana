@extends('admin.layouts.admin')

@section('header', __('Manage Pages'))

@section('content')
    <div class="d-flex align-items-center gap-2 flex-wrap mb-4 bg-white p-3 rounded shadow-sm">
        <span class="text-muted small fw-bold text-uppercase me-2">
            <i class="fas fa-language me-1 text-primary"></i>{{ __('Locale') }}:
        </span>
        <a href="{{ route('admin.pages.index', ['locale' => 'en']) }}"
           class="btn btn-sm {{ $locale === 'en' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3 fw-bold">
            🇬🇧 English
        </a>
        <!-- Arabic removed: only English and Urdu supported -->
        <a href="{{ route('admin.pages.index', ['locale' => 'ur']) }}"
           class="btn btn-sm {{ $locale === 'ur' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-3 fw-bold">
            🇵🇰 اردو
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2 text-primary"></i> {{ __('Pages List') }} ({{ strtoupper($locale) }})</h5>
            <a href="{{ route('admin.pages.create', ['locale' => $locale]) }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> {{ __('Create New Page') }}
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                        <tr>
                            <th class="ps-4 py-3">{{ __('Title') }}</th>
                            <th class="py-3">{{ __('Slug') }}</th>
                            <th class="py-3">{{ __('Status') }}</th>
                            <th class="py-3">{{ __('Last Updated') }}</th>
                            <th class="py-3 text-end pe-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $page->title }}</td>
                                <td><code class="small text-primary">/page/{{ $page->slug }}</code></td>
                                <td>
                                    <span class="badge rounded-pill {{ $page->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3">
                                        {{ $page->is_active ? __('Active') : __('Draft') }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $page->updated_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary border-0 rounded-pilled shadow-none">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-pilled shadow-none">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-info-circle mb-2 fs-2 d-block"></i>
                                    {{ __('No pages found for this locale.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
