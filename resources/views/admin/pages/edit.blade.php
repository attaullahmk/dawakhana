@extends('admin.layouts.admin')

@section('header', __('Edit Page'))

@section('content')
    <div class="d-flex align-items-center gap-2 flex-wrap mb-4 bg-white p-3 rounded shadow-sm">
        <span class="text-muted small fw-bold text-uppercase me-2">
            <i class="fas fa-language me-1 text-primary"></i>{{ __('Currently Editing For') }}:
        </span>
        
        @php
            $locales = ['en' => '🇬🇧 English', 'ur' => '🇵🇰 اردو'];
            $btnClasses = ['en' => 'btn-primary', 'ur' => 'btn-warning text-dark'];
            $outlineClasses = ['en' => 'btn-outline-primary', 'ur' => 'btn-outline-warning text-dark'];
        @endphp

        @foreach($locales as $code => $label)
            @if(isset($relatedVersions[$code]))
                <a href="{{ route('admin.pages.edit', $relatedVersions[$code]) }}"
                   class="btn btn-sm {{ $locale === $code ? $btnClasses[$code] : $outlineClasses[$code] }} rounded-pill px-3 fw-bold">
                    {{ $label }}
                </a>
            @else
                <a href="{{ route('admin.pages.create', ['locale' => $code, 'system_key' => $page->system_key]) }}"
                   class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold opacity-50" title="{{ __('Version not created yet') }}">
                    {{ $label }} ({{ __('Create') }})
                </a>
            @endif
        @endforeach
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.pages.index', ['locale' => $locale]) }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to List') }}
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2 text-primary"></i> {{ __('Edit Page Details') }} ({{ strtoupper($locale) }})</h5>
            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                <i class="fas fa-external-link-alt me-1"></i> {{ __('View Page') }}
            </a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="system_key" value="{{ $page->system_key }}">
                
                <div class="row g-4">
                    <div class="col-md-8 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">{{ __('Page Title') }}</label>
                            <input type="text" dir="{{ in_array($locale, ['ur']) ? 'rtl' : 'ltr' }}" class="form-control" name="title" value="{{ $page->title }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">{{ __('URL Slug') }}</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">/page/</span>
                                <input type="text" class="form-control" name="slug" value="{{ $page->slug }}" required>
                            </div>
                            <small class="text-muted">{{ __('Careful: Changing the slug will break old links.') }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">{{ __('Page Content') }}</label>
                            <textarea dir="{{ in_array($locale, ['ur']) ? 'rtl' : 'ltr' }}" class="form-control" name="content" rows="18" required>{{ $page->content }}</textarea>
                            <small class="text-muted">{{ __('You can use HTML tags such as <strong>&lt;h2&gt;</strong>, <strong>&lt;p&gt;</strong>, <strong>&lt;ul&gt;</strong>, <strong>&lt;li&gt;</strong> for formatting.') }}</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="bg-light p-4 rounded-4 border">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">{{ __('Publication') }}</h6>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $page->is_active ? 'checked' : '' }} value="1">
                                <label class="form-check-label fw-bold ms-2" for="isActive">{{ __('Active / Published') }}</label>
                            </div>

                            @if($page->system_key)
                                <div class="mb-3">
                                    <label class="small text-muted fw-bold d-block">{{ __('Page Type') }}</label>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill shadow-sm">
                                        <i class="fas fa-link me-1"></i> {{ __('Core Page') }} ({{ $page->system_key }})
                                    </span>
                                    <small class="d-block text-muted mt-1" style="font-size: 0.7rem;">{{ __('This page is linked to the footer/product detail tabs.') }}</small>
                                </div>
                            @endif
                            
                            <div class="mb-2">
                                <label class="small text-muted fw-bold d-block">{{ __('Created At') }}</label>
                                <span class="small">{{ $page->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="mb-4">
                                <label class="small text-muted fw-bold d-block">{{ __('Last Updated') }}</label>
                                <span class="small">{{ $page->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                            
                            <hr>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                                <i class="fas fa-save me-1"></i> {{ __('Update Page') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
