@extends('admin.layouts.admin')

@section('header', __('Manage Blog Posts'))

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card p-4">
        @include('admin.partials.locale-filter')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">{{ __('Articles') }}</h5>
            <a href="{{ route('admin.blog.create') }}" class="btn text-white" style="background-color: var(--primary);">
                <i class="fas fa-plus me-2"></i> {{ __('Write Post') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Post') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Views') }}</th>
                        <th class="text-end">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $post->featured_image ? asset($post->featured_image) : 'https://via.placeholder.com/60x40' }}" class="rounded shadow-sm object-fit-cover" width="60" height="40">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ Str::limit($post->title, 40) }}</h6>
                                    <small class="text-muted">{{ $post->published_at ? $post->published_at->format('M d, Y') : __('Not published') }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $post->category->name ?? __('Uncategorized') }}</td>
                        <td>{{ $post->author->name ?? __('System') }}</td>
                        <td>
                            @if($post->is_published)
                                <span class="badge bg-success bg-opacity-25 text-success">{{ __('Published') }}</span>
                            @else
                                <span class="badge bg-secondary">{{ __('Draft') }}</span>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $post->views }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-light text-warning me-1"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-light text-danger" onclick="if(confirm('{{ __('Are you sure you want to delete this post?') }}')) document.getElementById('delete-form-{{ $post->id }}').submit();"><i class="fas fa-trash"></i></button>
                            <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" id="delete-form-{{ $post->id }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-blog fs-1 mb-3 d-block opacity-25"></i>
                            <h6>{{ __('No blog posts yet') }}</h6>
                            <a href="{{ route('admin.blog.create') }}" class="btn btn-sm text-white mt-2" style="background-color: var(--primary);">{{ __('Write Your First Post') }}</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
