{{-- Reusable Language Filter Tabs for Admin Index Pages --}}
@php $currentLocale = $locale ?? 'all'; @endphp
<div class="d-flex align-items-center gap-2 flex-wrap mb-3">
    <span class="text-muted small fw-bold text-uppercase me-1">
        <i class="fas fa-filter me-1"></i>{{ __('Filter by Language') }}:
    </span>
    <a href="{{ request()->fullUrlWithQuery(['locale' => 'all']) }}"
       class="btn btn-sm {{ $currentLocale === 'all' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill">
        {{ __('All') }}
    </a>
    <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}"
       class="btn btn-sm {{ $currentLocale === 'en' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
        🇬🇧 English
    </a>
    <!-- Arabic removed: only English and Urdu supported -->
    <a href="{{ request()->fullUrlWithQuery(['locale' => 'ur']) }}"
       class="btn btn-sm {{ $currentLocale === 'ur' ? 'btn-warning' : 'btn-outline-warning' }} rounded-pill">
        🇵🇰 اردو
    </a>
</div>
