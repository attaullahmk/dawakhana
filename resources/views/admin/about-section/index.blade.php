@extends('admin.layouts.admin')

@section('header', __('Manage About Section'))

@section('content')
    <div class="d-flex align-items-center gap-2 flex-wrap mb-4 bg-white p-3 rounded shadow-sm {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
        <span class="text-muted small fw-bold text-uppercase me-2">
            <i class="fas fa-language me-1 text-primary"></i>{{ __('Configuring For') }}:
        </span>
        <a href="{{ route('admin.about-section.index', ['locale' => 'en']) }}"
           class="btn btn-sm {{ $locale === 'en' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3 fw-bold">
            🇬🇧 English
        </a>
        <!-- Arabic removed: only English and Urdu supported -->
        <a href="{{ route('admin.about-section.index', ['locale' => 'ur']) }}"
           class="btn btn-sm {{ $locale === 'ur' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-3 fw-bold">
            🇵🇰 اردو (Urdu)
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.about-section.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="locale" value="{{ $locale }}">
        
        <div class="row g-4">
            <!-- Hero Section -->
            <div class="col-lg-12">
                <div class="card p-4 shadow-sm border-0 mb-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2 text-primary">
                        <i class="fas fa-star me-2"></i> {{ __('Hero Section') }}
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6 text-start">
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Hero Title') }}</label>
                                <input type="text" class="form-control" name="hero_title" value="{{ $about->hero_title ?? __('Our Story') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('Hero Subtitle') }}</label>
                                <textarea class="form-control" name="hero_subtitle" rows="2">{{ $about->hero_subtitle ?? __('Crafting beautiful, timeless spaces since 2010.') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 text-start">
                            <label class="form-label fw-bold">{{ __('Hero Background Image') }}</label>
                            <input type="file" class="form-control mb-2" name="hero_image" accept="image/*">
                            @if($about->hero_image)
                                <img src="{{ asset($about->hero_image) }}" class="rounded shadow-sm border" style="max-height: 120px;">
                            @else
                                <div class="bg-light rounded p-4 text-center border border-dashed">
                                    <i class="fas fa-image text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">{{ __('No custom hero image uploaded.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card p-4 shadow-sm border-0 h-100 text-start">
                    <h5 class="fw-bold mb-4 border-bottom pb-2 text-primary">
                        <i class="fas fa-eye me-2"></i> {{ __('Vision Section') }}
                    </h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Small Title') }}</label>
                        <input type="text" class="form-control" name="vision_title" value="{{ $about->vision_title ?? __('THE VISION') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Main Heading') }}</label>
                        <input type="text" class="form-control" name="vision_heading" value="{{ $about->vision_heading ?? __('A Passion for Design') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Paragraph 1') }}</label>
                        <textarea class="form-control" name="vision_description_1" rows="4">{{ $about->vision_description_1 }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Paragraph 2') }}</label>
                        <textarea class="form-control" name="vision_description_2" rows="4">{{ $about->vision_description_2 }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card p-4 shadow-sm border-0 mb-4 text-start">
                    <h5 class="fw-bold mb-4 border-bottom pb-2 text-primary">
                        <i class="fas fa-camera me-2"></i> {{ __('Vision Image') }}
                    </h5>
                    <input type="file" class="form-control mb-3" name="vision_image" accept="image/*">
                    @if($about->vision_image)
                        <img src="{{ asset($about->vision_image) }}" class="rounded shadow-sm border w-100 object-fit-cover" style="height: 300px;">
                    @else
                        <div class="bg-light rounded p-5 text-center border border-dashed">
                            <i class="fas fa-image text-muted fs-1 mb-2"></i>
                            <p class="text-muted">{{ __('No vision image uploaded.') }}</p>
                        </div>
                    @endif
                </div>

                <div class="card p-4 shadow-sm border-0 text-start">
                    <h5 class="fw-bold mb-4 border-bottom pb-2 text-primary">
                        <i class="fas fa-user-tie me-2"></i> {{ __('Founder Details') }}
                    </h5>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Founder Name') }}</label>
                        <input type="text" class="form-control" name="founder_name" value="{{ $about->founder_name ?? __('Sarah Jenkins') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Founder Title') }}</label>
                        <input type="text" class="form-control" name="founder_title" value="{{ $about->founder_title ?? __('Founder & Lead Designer') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Founder Image') }}</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="file" class="form-control" name="founder_image" accept="image/*">
                            @if($about->founder_image)
                                <img src="{{ asset($about->founder_image) }}" class="rounded-circle shadow-sm border" style="width: 60px; height: 60px; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="col-lg-12">
                <div class="card p-4 shadow-sm border-0">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2 {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
                        <h5 class="fw-bold mb-0 text-primary">
                            <i class="fas fa-chart-line me-2"></i> {{ __('Statistics Counters') }}
                        </h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addStat()">{{ __('Add Stat') }}</button>
                    </div>
                    
                    <div id="stats-container" class="row {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
                        @foreach($about->stats ?? [] as $index => $stat)
                            <div class="col-md-4 stat-row mb-3 text-start">
                                <div class="p-3 border rounded shadow-sm bg-light position-relative">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="this.closest('.stat-row').remove()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <div class="mb-2">
                                        <label class="small fw-bold">{{ __('Number') }} ({{ __('e.g., 15+') }})</label>
                                        <input type="text" class="form-control form-control-sm" name="stats_numbers[]" value="{{ $stat['number'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="small fw-bold">{{ __('Label') }}</label>
                                        <input type="text" class="form-control form-control-sm" name="stats_labels[]" value="{{ $stat['label'] ?? '' }}" required>
                                    </div>
                                    <div class="mb-0">
                                        <label class="small fw-bold">{{ __('Small Description') }}</label>
                                        <textarea class="form-control form-control-sm" name="stats_descs[]" rows="2">{{ $stat['desc'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card p-4 shadow-sm border-0 d-flex flex-row justify-content-between align-items-center {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
                    <p class="text-muted mb-0"><i class="fas fa-info-circle me-1"></i> {{ __('Changes will only apply to the ') }} <strong>{{ strtoupper($locale) }}</strong> {{ __('version.') }}</p>
                    <button type="submit" class="btn btn-lg btn-primary px-5 shadow-sm fw-bold rounded-pill">{{ __('Save All Content') }}</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function addStat() {
            const isRtl = "{{ in_array($locale, ['ur']) }}";
            const container = document.getElementById('stats-container');
            const col = document.createElement('div');
            col.className = 'col-md-4 stat-row mb-3 text-start';
            col.innerHTML = `
                <div class="p-3 border rounded shadow-sm bg-light position-relative">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="this.closest('.stat-row').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="mb-2">
                        <label class="small fw-bold">{{ __('Number') }}</label>
                        <input type="text" class="form-control form-control-sm" name="stats_numbers[]" required>
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">{{ __('Label') }}</label>
                        <input type="text" class="form-control form-control-sm" name="stats_labels[]" required>
                    </div>
                    <div class="mb-0">
                        <label class="small fw-bold">{{ __('Small Description') }}</label>
                        <textarea class="form-control form-control-sm" name="stats_descs[]" rows="2"></textarea>
                    </div>
                </div>
            `;
            container.appendChild(col);
        }
    </script>
@endsection
