{{-- Reusable Language Selector for Admin Forms --}}
<div class="mb-4 p-3 border rounded-3 bg-light">
    <label class="form-label fw-bold d-flex align-items-center gap-2">
        <i class="fas fa-globe text-primary"></i>
        {{ __('Content Language') }}
        <span class="badge bg-primary ms-1">{{ __('Required') }}</span>
    </label>
    <div class="d-flex gap-2 flex-wrap">
        @php $selectedLocale = $selectedLocale ?? old('locale', 'en'); @endphp
        @foreach($locales as $code => $label)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="locale" id="locale_{{ $code }}"
                    value="{{ $code }}" {{ $selectedLocale === $code ? 'checked' : '' }} required>
                <label class="form-check-label fw-semibold" for="locale_{{ $code }}">
                    {{ __($label) }}
                </label>
            </div>
        @endforeach
    </div>
    <small class="text-muted mt-1 d-block">
        <i class="fas fa-info-circle me-1"></i>
        {{ __('This content will only be shown to visitors using the selected language.') }}
    </small>
</div>
