@extends('admin.layouts.admin')

@section('header', __('Blog Categories'))

@section('content')
    @include('admin.partials.locale-filter')
    <div class="row g-4">
        <!-- Add Category Form -->
        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">{{ __('Add New Category') }}</h5>
                <form action="{{ route('admin.blog-categories.store') }}" method="POST">
                    @csrf
                    @php $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)']; @endphp
                    @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', 'en')])
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Category Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="{{ __('e.g. Interior Design') }}" required>
                    </div>
                    <button type="submit" class="btn text-white w-100" style="background-color: var(--primary);">{{ __('Save Category') }}</button>
                </form>
            </div>
        </div>

        <!-- Category List -->
        <div class="col-lg-8">
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

            <div class="card p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Posts Count') }}</th>
                                <th class="text-end pe-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="ps-4 text-muted">#{{ $category->id }}</td>
                                    <td class="fw-bold">{{ $category->name }}</td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $category->posts_count }} {{ __('posts') }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.blog-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blog-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">{{ __('No blog categories found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
