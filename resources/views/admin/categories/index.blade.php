@extends('admin.layouts.admin')

@section('header', __('Manage Categories'))

@section('content')
    @include('admin.partials.locale-filter')
    <div class="row g-4">
        <!-- New Category Form -->
        <div class="col-lg-4">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">{{ __('Add New Category') }}</h5>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @php $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)']; @endphp
                    @include('admin.partials.locale-selector', ['selectedLocale' => old('locale', 'en')])
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required placeholder="{{ __('e.g. Living Room') }}" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('Image') }}</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn text-white w-100" style="background-color: var(--primary);">{{ __('Save Category') }}</button>
                </form>
            </div>
        </div>

        <!-- Categories List -->
        <div class="col-lg-8">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card p-4 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">{{ __('Icon') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Products') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset($category->image) }}" class="rounded-circle object-fit-cover shadow-sm" width="50" height="50" onerror="this.src='/assets/img/placeholder.png'">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm" width="50" height="50">
                                            <i class="fas fa-folder text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $category->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $category->products_count }} {{ __('items') }}</span></td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success bg-opacity-25 text-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('Hidden') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-light text-warning me-1"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
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
