@extends('admin.layouts.admin')

@section('header', __('Site Settings'))

@section('content')
    <div class="d-flex align-items-center gap-2 flex-wrap mb-4 bg-white p-3 rounded shadow-sm {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
        <span class="text-muted small fw-bold text-uppercase me-2">
            <i class="fas fa-language me-1 text-primary"></i>{{ __('Configuring Settings For') }}:
        </span>
        <a href="{{ route('admin.settings.index', ['locale' => 'en']) }}"
           class="btn btn-sm {{ $locale === 'en' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-3 fw-bold">
            🇬🇧 English
        </a>
        <!-- Arabic removed: only English and Urdu are supported -->
        <a href="{{ route('admin.settings.index', ['locale' => 'ur']) }}"
           class="btn btn-sm {{ $locale === 'ur' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} rounded-pill px-3 fw-bold">
            🇵🇰 اردو (Urdu)
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="locale" value="{{ $locale }}">
        <div class="row g-4">
            <!-- General Settings -->
            <div class="col-lg-6">
                <div class="card p-4 h-100 mb-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2"><i class="fas fa-cog me-2 text-primary"></i> {{ __('General Settings') }}</h5>
                    
                    @php
                        /** @var \Illuminate\Database\Eloquent\Collection $settings */
                        $getSetting = function($key) use ($settings) {
                            return $settings->where('key', $key)->first()?->value;
                        }
                    @endphp

                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Site Name') }}</label>
                        <input type="text" class="form-control" name="site_name" value="{{ $getSetting('site_name') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Contact Email') }}</label>
                        <input type="email" class="form-control" name="site_email" value="{{ $getSetting('site_email') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Contact Phone') }}</label>
                        <input type="text" class="form-control" name="site_phone" value="{{ $getSetting('site_phone') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Physical Address') }}</label>
                        <textarea class="form-control" rows="2" name="site_address">{{ $getSetting('site_address') }}</textarea>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Footer Description') }}</label>
                        <textarea class="form-control" rows="3" name="footer_description">{{ $getSetting('footer_description') }}</textarea>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Contact Page Heading') }}</label>
                        <input type="text" class="form-control" name="contact_heading" value="{{ $getSetting('contact_heading') ?? __('Get In Touch') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Contact Page Sub-heading') }}</label>
                        <input type="text" class="form-control" name="contact_subheading" value="{{ $getSetting('contact_subheading') ?? __('We\'d love to hear from you. Our team is always here to help.') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Contact Side Description') }}</label>
                        <textarea class="form-control" rows="3" name="contact_description">{{ $getSetting('contact_description') ?? __('Have a question or comment? Use the form to give us a message or contact us directly using the details below.') }}</textarea>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Currency Symbol') }}</label>
                        <input type="text" class="form-control" name="currency_symbol" value="{{ $getSetting('currency_symbol') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Shipping Estimate (Flat Amount)') }}</label>
                            <div class="input-group {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
                            <span class="input-group-text">{{ $getSetting('currency_symbol') ?? '$' }}</span>
                            <input type="number" step="0.01" class="form-control" name="shipping_estimate" value="{{ $getSetting('shipping_estimate') ?? '50.00' }}">
                        </div>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Estimated Tax (Flat Amount)') }}</label>
                            <div class="input-group {{ in_array($locale, ['ur']) ? 'flex-row-reverse' : '' }}">
                            <span class="input-group-text">{{ $getSetting('currency_symbol') ?? '$' }}</span>
                            <input type="number" step="0.01" class="form-control" name="estimated_tax" value="{{ $getSetting('estimated_tax') ?? '25.00' }}">
                        </div>
                    </div>
                    <div class="mb-3 border-top pt-3 text-start">
                        <label class="form-label fw-bold text-success"><i class="fab fa-whatsapp me-2"></i> {{ __('WhatsApp Integration') }}</label>
                        <div class="mb-2">
                            <label class="small text-muted fw-bold">{{ __('WhatsApp Number (International Format)') }}</label>
                            <input type="text" class="form-control text-start" name="whatsapp_number" value="{{ $getSetting('whatsapp_number') }}" placeholder="{{ __('e.g., 923001234567') }}">
                            <small class="text-info d-block mt-1">
                                <i class="fas fa-info-circle me-1"></i> {{ __('Important: Enter the **full number** including country code. Do not include + or leading zeros.') }}
                            </small>
                        </div>
                        <div class="mb-2">
                            <label class="small text-muted fw-bold">{{ __('Default Welcome Message') }}</label>
                            <textarea class="form-control" rows="2" name="whatsapp_message" placeholder="{{ __('How can we help you today?') }}">{{ $getSetting('whatsapp_message') }}</textarea>
                        </div>
                    </div>

                    <div class="mb-0 border-top pt-3 text-start">
                        <label class="form-label fw-bold text-primary"><i class="fas fa-wallet me-2"></i> {{ __('Payment Methods') }}</label>
                        <div class="bg-light p-3 rounded-4 shadow-sm">
                            <div class="form-check form-switch mb-2 {{ in_array($locale, ['ur']) ? 'form-check-reverse' : '' }}">
                                <input class="form-check-input" type="checkbox" name="payment_card_enabled" id="payment_card" value="1" {{ $getSetting('payment_card_enabled') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2 me-2" for="payment_card">{{ __('Enable Credit Card') }}</label>
                            </div>
                            <div class="form-check form-switch mb-2 {{ in_array($locale, ['ur']) ? 'form-check-reverse' : '' }}">
                                <input class="form-check-input" type="checkbox" name="payment_cod_enabled" id="payment_cod" value="1" {{ $getSetting('payment_cod_enabled') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2 me-2" for="payment_cod">{{ __('Enable Cash on Delivery (COD)') }}</label>
                            </div>
                            <div class="form-check form-switch {{ in_array($locale, ['ur']) ? 'form-check-reverse' : '' }}">
                                <input class="form-check-input" type="checkbox" name="payment_whatsapp_enabled" id="payment_whatsapp" value="1" {{ $getSetting('payment_whatsapp_enabled') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2 me-2" for="payment_whatsapp">{{ __('Enable Ordering via WhatsApp') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media & Logos -->
            <div class="col-lg-6">
                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2"><i class="fas fa-image me-2 text-primary"></i> {{ __('Branding') }}</h5>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Site Logo') }} <small class="text-muted">({{ __('Leave empty to keep current') }})</small></label>
                        <input type="file" class="form-control" name="site_logo" accept="image/*">
                        @if($getSetting('site_logo'))
                            <div class="mt-2 text-start">
                                <img src="{{ asset($getSetting('site_logo')) }}" alt="{{ __('Logo') }}" class="border rounded p-1" style="max-height: 50px;">
                            </div>
                        @endif
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Site Favicon') }} <small class="text-muted">({{ __('Leave empty to keep current') }})</small></label>
                        <input type="file" class="form-control" name="site_favicon" accept="image/*">
                        @if($getSetting('site_favicon'))
                            <div class="mt-2 text-start">
                                <img src="{{ asset($getSetting('site_favicon')) }}" alt="{{ __('Favicon') }}" class="border rounded p-1" style="max-height: 30px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                         <h5 class="fw-bold mb-0"><i class="fas fa-share-alt me-2 text-primary"></i> {{ __('Social Links') }}</h5>
                         <button type="button" class="btn btn-sm btn-primary" onclick="addSocialLink()">{{ __('Add New') }}</button>
                    </div>
                    
                    <div id="social-links-container">
                        @php
                            $socialLinks = json_decode($getSetting('site_social_links') ?? '[]', true);
                            $availableIcons = [
                                'fab fa-facebook' => __('Facebook'),
                                'fab fa-instagram' => __('Instagram'),
                                'fab fa-x-twitter' => __('Twitter / X'),
                                'fab fa-linkedin' => __('LinkedIn'),
                                'fab fa-pinterest' => __('Pinterest'),
                                'fab fa-youtube' => __('YouTube'),
                                'fab fa-whatsapp' => __('WhatsApp'),
                                'fab fa-tiktok' => __('TikTok'),
                                'fas fa-link' => __('Other / General')
                            ];
                        @endphp
                        @if(empty($socialLinks))
                            <div class="social-link-row mb-3 p-3 border rounded shadow-sm bg-light">
                                <div class="row g-2">
                                    <div class="col-md-5 text-start">
                                        <label class="small fw-bold">{{ __('Select Icon') }}</label>
                                        <select class="form-select form-select-sm" name="social_icons[]">
                                            @foreach($availableIcons as $class => $name)
                                                <option value="{{ $class }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 text-start">
                                        <label class="small fw-bold">{{ __('URL') }}</label>
                                        <input type="url" class="form-control form-control-sm" name="social_urls[]" placeholder="{{ __('https://...') }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-sm btn-danger w-100 py-1" onclick="removeSocialLink(this)"><i class="fas fa-trash-alt me-1"></i> {{ __('Remove') }}</button>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($socialLinks as $link)
                                <div class="social-link-row mb-3 p-3 border rounded shadow-sm bg-light">
                                    <div class="row g-2">
                                        <div class="col-md-5 text-start">
                                            <label class="small fw-bold">{{ __('Select Icon') }}</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="{{ $link['icon'] ?? 'fas fa-link' }}"></i></span>
                                                <select class="form-select" name="social_icons[]" onchange="this.previousElementSibling.querySelector('i').className = this.value">
                                                    @foreach($availableIcons as $class => $name)
                                                        <option value="{{ $class }}" {{ ($link['icon'] ?? '') == $class ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 text-start">
                                            <label class="small fw-bold">{{ __('URL') }}</label>
                                            <input type="url" class="form-control form-control-sm" name="social_urls[]" value="{{ $link['url'] ?? '' }}" placeholder="{{ __('https://...') }}">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-danger w-100 py-1" onclick="removeSocialLink(this)"><i class="fas fa-trash-alt me-1"></i> {{ __('Remove') }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <h5 class="fw-bold mb-4 border-bottom pb-2"><i class="fas fa-bullhorn me-2 text-primary"></i> {{ __('Promotional Banner') }}</h5>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Banner Title') }}</label>
                        <input type="text" class="form-control" name="promo_banner_title" value="{{ $getSetting('promo_banner_title') ?? __('Up to 40% Off on Living Room Sets') }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Banner Subtitle') }}</label>
                        <textarea class="form-control" rows="2" name="promo_banner_subtitle">{{ $getSetting('promo_banner_subtitle') ?? __('Elevate your living space with our premium collections at unbeatable prices.') }}</textarea>
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Background Image') }} <small class="text-muted">({{ __('Leave empty to keep current') }})</small></label>
                        <input type="file" class="form-control" name="promo_banner_image" accept="image/*">
                        @if($getSetting('promo_banner_image'))
                            <div class="mt-2 text-start">
                                <img src="{{ asset($getSetting('promo_banner_image')) }}" alt="{{ __('Promo Banner') }}" class="border rounded p-1" style="max-height: 80px;">
                            </div>
                        @endif
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">{{ __('Countdown Target Date') }} <small class="text-muted">({{ __('Format: April 30, 2026 23:59:59') }})</small></label>
                        <input type="text" class="form-control" name="promo_banner_countdown" value="{{ $getSetting('promo_banner_countdown') ?? \Carbon\Carbon::now()->addDays(12)->format('F d, Y 23:59:59') }}">
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 text-start">
                           <label class="form-label fw-bold">{{ __('Button Text') }}</label>
                           <input type="text" class="form-control" name="promo_banner_btn_text" value="{{ $getSetting('promo_banner_btn_text') ?? 'Shop The Sale' }}">
                        </div>
                        <div class="col-md-6 text-start">
                           <label class="form-label fw-bold">{{ __('Button Link') }}</label>
                           <input type="text" class="form-control" name="promo_banner_btn_link" value="{{ $getSetting('promo_banner_btn_link') ?? '#' }}">
                        </div>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                         <h5 class="fw-bold mb-0"><i class="fas fa-list-check me-2 text-primary"></i> {{ __('Why Choose Us') }}</h5>
                         <button type="button" class="btn btn-sm btn-primary" onclick="addFeature()">{{ __('Add Feature') }}</button>
                    </div>
                    
                    <div id="features-container">
                        @php
                            $features = json_decode($getSetting('site_why_choose_us') ?? '[]', true);
                            if(empty($features)) {
                                $features = [
                                    ['icon' => 'fas fa-truck-fast', 'title' => __('Free Shipping'), 'desc' => __('Enjoy free shipping on all orders over') . ' ' . ($getSetting('currency_symbol') ?? '$') . ' 500.'],
                                    ['icon' => 'fas fa-undo-alt', 'title' => __('Easy Returns'), 'desc' => __('Return your item within 30 days for a refund.')],
                                    ['icon' => 'fas fa-shield-alt', 'title' => __('Quality Guarantee'), 'desc' => __('We stand behind our craftsmanship.')],
                                    ['icon' => 'fas fa-headset', 'title' => __('24/7 Support'), 'desc' => __('Our dedicated team is here to assist you.')]
                                ];
                            }
                            
                            $importantIcons = [
                                'fas fa-truck-fast' => __('Free Shipping'),
                                'fas fa-undo-alt' => __('Easy Returns'),
                                'fas fa-shield-alt' => __('Quality Guarantee'),
                                'fas fa-headset' => __('24/7 Support'),
                                'fas fa-wallet' => __('Best Prices'),
                                'fas fa-clock' => __('Fast Delivery'),
                                'fas fa-gem' => __('Premium Material'),
                                'fas fa-award' => __('Award Winning'),
                                'fas fa-star' => __('Top Rated'),
                                'fas fa-box-open' => __('Huge Variety'),
                                'custom' => __('Custom Icon...')
                            ];
                        @endphp
                        @foreach($features as $feature)
                            <div class="feature-row mb-3 p-3 border rounded shadow-sm bg-light">
                                <div class="row g-2">
                                    <div class="col-md-4 text-start icon-container">
                                        <label class="small fw-bold">{{ __('Icon') }}</label>
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text"><i class="{{ $feature['icon'] ?? 'fas fa-check' }}"></i></span>
                                            @php
                                                $isCustom = !isset($importantIcons[$feature['icon'] ?? '']);
                                            @endphp
                                            <select class="form-select icon-selector" onchange="handleIconChange(this)">
                                                @foreach($importantIcons as $class => $label)
                                                    <option value="{{ $class }}" {{ ($feature['icon'] ?? '') == $class ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                                {{-- If it's custom and not in our array, we must show it as custom --}}
                                                @if($isCustom && !empty($feature['icon']))
                                                    <option value="custom" selected>{{ __('Custom Icon...') }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="custom-icon-input {{ $isCustom ? '' : 'd-none' }}">
                                            <input type="text" class="form-control form-control-sm" {{ $isCustom ? 'name=feature_icons[]' : '' }} value="{{ $feature['icon'] ?? '' }}" placeholder="fas fa-..." oninput="updateIconPreview(this)">
                                        </div>
                                        @if(!$isCustom)
                                            <input type="hidden" name="feature_icons[]" value="{{ $feature['icon'] ?? '' }}">
                                        @endif
                                    </div>
                                    <div class="col-md-8 text-start">
                                        <label class="small fw-bold">{{ __('Title') }}</label>
                                        <input type="text" class="form-control form-control-sm" name="feature_titles[]" value="{{ $feature['title'] ?? '' }}">
                                    </div>
                                    <div class="col-md-10 text-start">
                                        <label class="small fw-bold">{{ __('Description') }}</label>
                                        <textarea class="form-control form-control-sm" name="feature_descs[]" rows="2">{{ $feature['desc'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-sm btn-danger w-100 py-1" onclick="this.closest('.feature-row').remove()"><i class="fas fa-trash-alt me-1"></i> {{ __('Remove') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                            <div class="card p-4">
                    <button type="submit" class="btn btn-lg text-white w-100 shadow-sm" style="background-color: var(--primary);">{{ __('Save All Settings') }}</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        // Data for dynamic icon rendering
        const availableIconsHtml = `
            @foreach($availableIcons as $class => $name)
                <option value="{{ $class }}">{{ $name }}</option>
            @endforeach
        `;

        const importantIconsOptions = `
            @foreach($importantIcons as $class => $label)
                <option value="{{ $class }}">{{ $label }}</option>
            @endforeach
        `;

        // Social Links Functions
        function addSocialLink() {
            const isRtl = "{{ in_array($locale, ['ur']) }}";
            const container = document.getElementById('social-links-container');
            const row = document.createElement('div');
            row.className = 'social-link-row mb-3 p-3 border rounded shadow-sm bg-light';
            row.innerHTML = `
                <div class="row g-2 text-start ${isRtl ? 'flex-row-reverse' : ''}">
                    <div class="col-md-5">
                        <label class="small fw-bold">{{ __('Select Icon') }}</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                            <select class="form-select" name="social_icons[]" onchange="this.previousElementSibling.querySelector('i').className = this.value">
                                ${availableIconsHtml}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="small fw-bold">{{ __('URL') }}</label>
                        <input type="url" class="form-control form-control-sm" name="social_urls[]" placeholder="{{ __('https://...') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100 py-1" onclick="removeSocialLink(this)"><i class="fas fa-trash-alt me-1"></i> {{ __('Remove') }}</button>
                    </div>
                </div>
            `;
            container.appendChild(row);
        }

        function removeSocialLink(btn) {
            btn.closest('.social-link-row').remove();
        }

        // Feature Icons Change Handler
        function handleIconChange(select) {
            const container = select.closest('.icon-container');
            const customInputDiv = container.querySelector('.custom-icon-input');
            const customInput = customInputDiv.querySelector('input');
            const previewIcon = container.querySelector('.input-group-text i');
            
            // Remove any existing hidden or direct named input first
            let hiddenInput = container.querySelector('input[type="hidden"]');
            
            if (select.value === 'custom') {
                customInputDiv.classList.remove('d-none');
                if (hiddenInput) {
                    hiddenInput.remove();
                }
                customInput.name = "feature_icons[]";
                previewIcon.className = customInput.value || 'fas fa-question';
            } else {
                customInputDiv.classList.add('d-none');
                customInput.name = ""; // Remove name so it doesn't submit
                
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = "feature_icons[]";
                    container.appendChild(hiddenInput);
                }
                hiddenInput.value = select.value;
                previewIcon.className = select.value;
            }
        }

        function updateIconPreview(input) {
            const container = input.closest('.icon-container');
            const previewIcon = container.querySelector('.input-group-text i');
            previewIcon.className = input.value || 'fas fa-question';
        }

        // Add New Feature
        function addFeature() {
            const isRtl = "{{ in_array($locale, ['ur']) }}";
            const container = document.getElementById('features-container');
            const div = document.createElement('div');
            div.className = 'feature-row mb-3 p-3 border rounded shadow-sm bg-light';
            div.innerHTML = `
                <div class="row g-2 text-start ${isRtl ? 'flex-row-reverse' : ''}">
                    <div class="col-md-4 icon-container">
                        <label class="small fw-bold">{{ __('Icon') }}</label>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text"><i class="fas fa-truck-fast"></i></span>
                            <select class="form-select icon-selector" onchange="handleIconChange(this)">
                                ${importantIconsOptions}
                            </select>
                        </div>
                        <div class="custom-icon-input d-none">
                            <input type="text" class="form-control form-control-sm" name="" value="" placeholder="fas fa-..." oninput="updateIconPreview(this)">
                        </div>
                        <input type="hidden" name="feature_icons[]" value="fas fa-truck-fast">
                    </div>
                    <div class="col-md-8">
                        <label class="small fw-bold">{{ __('Title') }}</label>
                        <input type="text" class="form-control form-control-sm" name="feature_titles[]" value="">
                    </div>
                    <div class="col-md-10">
                        <label class="small fw-bold">{{ __('Description') }}</label>
                        <textarea class="form-control form-control-sm" name="feature_descs[]" rows="2"></textarea>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100 py-1" onclick="this.closest('.feature-row').remove()"><i class="fas fa-trash-alt me-1"></i> {{ __('Remove') }}</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
@endsection
