@extends('admin.layouts.admin')

@section('header', __('Create New Page'))

@section('content')
    <div class="d-flex align-items-center gap-2 flex-wrap mb-4 bg-white p-3 rounded shadow-sm">
        <span class="text-muted small fw-bold text-uppercase me-2">
            <i class="fas fa-language me-1 text-primary"></i>{{ __('Currently Creating For') }}:
        </span>
        <a href="{{ route('admin.pages.create', ['locale' => 'en']) }}"
           class="btn btn-sm {{ $locale === 'en' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3 fw-bold">
            🇬🇧 English
        </a>
        <!-- Arabic removed: only English and Urdu supported -->
        <a href="{{ route('admin.pages.create', ['locale' => 'ur']) }}"
           class="btn btn-sm {{ $locale === 'ur' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-3 fw-bold">
            🇵🇰 اردو
        </a>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.pages.index', ['locale' => $locale]) }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to List') }}
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i> {{ __('Page Details') }} ({{ strtoupper($locale) }})</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="locale" value="{{ $locale }}">
                <input type="hidden" name="system_key" value="{{ $systemKey ?? '' }}">
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">{{ __('Page Title') }}</label>
                            <input type="text" dir="{{ in_array($locale, ['ur']) ? 'rtl' : 'ltr' }}" class="form-control" name="title" required placeholder="{{ __('e.g., Shipping Policy') }}" id="titleInput">
                        </div>
                        
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold text-dark">{{ __('URL Slug') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">/page/</span>
                                <input type="text" class="form-control" name="slug" required placeholder="shipping-policy" id="slugInput">
                            </div>
                            <small class="text-muted">{{ __('The slug will be used in the URL. Use lowercase and hyphens.') }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">{{ __('Page Content') }}</label>
                            <textarea dir="{{ in_array($locale, ['ur']) ? 'rtl' : 'ltr' }}" class="form-control" name="content" rows="15" required placeholder="{{ __('Write your page content here...') }}"></textarea>
                            <small class="text-muted">{{ __('You can use HTML tags for formatting.') }}</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="bg-light p-4 rounded-4 border">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">{{ __('Status') }}</h6>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                                <label class="form-check-label fw-bold ms-2" for="isActive">{{ __('Active / Published') }}</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">{{ __('Locale') }}</label>
                                <input type="text" class="form-control form-control-sm text-uppercase fw-bold" value="{{ $locale }}" readonly>
                            </div>
                            
                            <hr>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                                <i class="fas fa-save me-1"></i> {{ __('Save Page') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('titleInput').addEventListener('input', function() {
            if(!document.getElementById('slugInput').value.trim()) {
                const slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
                document.getElementById('slugInput').placeholder = slug;
            }
        });
    </script>
@endsection
