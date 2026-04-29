@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <!-- Hero Section -->
    <div class="bg-light py-5 mb-5 shadow-sm border-bottom">
        <div class="container text-center py-4">
            <h1 class="display-4 fw-bold text-dark mb-0">{{ $page->title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mt-3 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mb-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <div class="content-body fs-5 lead fw-normal text-muted" style="line-height: 1.8;">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .content-body h2 { color: #333; margin-top: 1.5rem; margin-bottom: 1rem; font-weight: 700; }
    .content-body h3 { color: #444; margin-top: 1.25rem; margin-bottom: 0.75rem; font-weight: 600; }
    .content-body ul, .content-body ol { margin-bottom: 1.5rem; }
    .content-body li { margin-bottom: 0.5rem; }
    .content-body p { margin-bottom: 1.5rem; }
</style>
@endpush
