@php
    $currentLocale = app()->getLocale();
    $footerPages = \App\Models\Page::where('locale', $currentLocale)
        ->active()
        ->get(['title', 'slug']);

    if ($footerPages->isEmpty() && $currentLocale !== 'en') {
        $footerPages = \App\Models\Page::where('locale', 'en')
            ->active()
            ->get(['title', 'slug']);
    }

    $socialLinks = json_decode($globalSettings['site_social_links'] ?? '[]', true) ?: [];
    $siteName = $globalSettings['site_name'] ?? 'Dawakhana';
    $siteAddress = $globalSettings['site_address'] ?? 'Dawakhana, Pakistan';
    $sitePhone = $globalSettings['site_phone'] ?? '1-800-DAWAKHANA';
    $siteEmail = $globalSettings['site_email'] ?? 'hello@dawakhana.com';
    $footerDescription = $globalSettings['footer_description'] ?? 'Trusted herbal wellness products, daily care essentials, and natural remedies selected for healthier living.';
    $mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($siteAddress);
    $cleanPhone = preg_replace('/\s+/', '', strip_tags($sitePhone));
    $footerNewsletterAction = \Illuminate\Support\Facades\Route::has('subscribe') ? route('subscribe') : '#';
@endphp

<style>
.site-footer {
    --footer-green: #122d22;
    --footer-green-light: #2d6a4f;
    --footer-gold: #c8a165;
    --footer-gold-light: #e2c08d;
    --footer-line: rgba(255,255,255,0.12);
    --footer-muted: rgba(255,255,255,0.72);
    position: relative;
    overflow: hidden;
    color: #fff;
    background:
        radial-gradient(circle at 12% 12%, rgba(200,161,101,0.16), transparent 28%),
        radial-gradient(circle at 88% 18%, rgba(45,106,79,0.28), transparent 30%),
        linear-gradient(135deg, var(--footer-green) 0%, #183c2e 58%, #0f241c 100%);
}

.site-footer::before {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    background-image:
        linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
    background-size: 44px 44px;
    mask-image: linear-gradient(180deg, transparent, #000 18%, #000 82%, transparent);
}

.footer-cta {
    position: relative;
    z-index: 2;
    margin-bottom: 44px;
    padding: clamp(24px, 4vw, 38px);
    border: 1px solid rgba(226,192,141,0.26);
    border-radius: 8px;
    background: rgba(255,255,255,0.08);
    box-shadow: 0 24px 70px rgba(0,0,0,0.18);
    backdrop-filter: blur(16px);
}

.footer-cta h2 {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    letter-spacing: 0;
}

.footer-cta p,
.footer-brand-copy,
.footer-bottom-text,
.footer-contact-text {
    color: var(--footer-muted);
    line-height: 1.75;
}

.footer-cta-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.footer-btn-primary,
.footer-btn-outline {
    min-height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    border-radius: 50px;
    padding: 12px 20px;
    font-weight: 900;
    text-decoration: none;
    transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease, color 0.25s ease;
}

.footer-btn-primary {
    color: var(--footer-green) !important;
    background: linear-gradient(135deg, var(--footer-gold), var(--footer-gold-light));
    box-shadow: 0 14px 30px rgba(200,161,101,0.28);
}

.footer-btn-outline {
    color: #fff !important;
    border: 1px solid rgba(255,255,255,0.34);
    background: rgba(255,255,255,0.06);
}

.footer-btn-primary:hover,
.footer-btn-outline:hover {
    transform: translateY(-3px);
}

.footer-btn-outline:hover {
    color: var(--footer-green) !important;
    background: #fff;
}

.footer-main {
    position: relative;
    z-index: 2;
    padding: 70px 0 26px;
}

.footer-brand-link {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    text-decoration: none;
    margin-bottom: 18px;
}

.footer-logo {
    width: 48px;
    height: 48px;
    object-fit: contain;
    border-radius: 8px;
    background: #fff;
    padding: 4px;
    box-shadow: 0 10px 24px rgba(0,0,0,0.16);
}

.footer-brand-name {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    font-size: 1.45rem;
    line-height: 1.15;
    letter-spacing: 0;
}

.footer-mini-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--footer-gold-light);
    border: 1px solid rgba(226,192,141,0.28);
    border-radius: 50px;
    background: rgba(200,161,101,0.1);
    padding: 7px 12px;
    font-size: 0.68rem;
    font-weight: 900;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    margin-bottom: 14px;
}

.footer-socials {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 24px;
}

.footer-social-link,
.footer-contact-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    border: 1px solid rgba(255,255,255,0.14);
    background: rgba(255,255,255,0.08);
    text-decoration: none;
    transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease, border-color 0.25s ease;
}

.footer-social-link:hover {
    color: var(--footer-green);
    background: var(--footer-gold);
    border-color: var(--footer-gold);
    transform: translateY(-4px);
}

.footer-column-title {
    position: relative;
    color: #fff;
    font-size: 0.95rem;
    font-weight: 900;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 22px;
    padding-bottom: 12px;
}

.footer-column-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 42px;
    height: 2px;
    border-radius: 10px;
    background: linear-gradient(90deg, var(--footer-gold), transparent);
}

.footer-link-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-link-list li + li {
    margin-top: 11px;
}

.footer-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--footer-muted);
    text-decoration: none;
    line-height: 1.5;
    transition: color 0.22s ease, transform 0.22s ease;
}

.footer-link::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(226,192,141,0.55);
    transform: scale(0.72);
    transition: transform 0.22s ease, background 0.22s ease;
}

.footer-link:hover {
    color: #fff;
    transform: translateX(4px);
}

.footer-link:hover::before {
    background: var(--footer-gold);
    transform: scale(1);
}

.footer-contact-item {
    display: grid;
    grid-template-columns: 42px 1fr;
    gap: 12px;
    align-items: start;
}

.footer-contact-item + .footer-contact-item {
    margin-top: 14px;
}

.footer-contact-icon {
    color: var(--footer-gold-light);
    flex: 0 0 auto;
}

.footer-contact-item a {
    color: var(--footer-muted);
    text-decoration: none;
    overflow-wrap: anywhere;
}

.footer-contact-item a:hover {
    color: #fff;
}

.footer-trust-row {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1px;
    overflow: hidden;
    border: 1px solid var(--footer-line);
    border-radius: 8px;
    background: var(--footer-line);
    margin-top: 34px;
}

.footer-trust-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    background: rgba(255,255,255,0.06);
}

.footer-trust-item i {
    color: var(--footer-gold-light);
}

.footer-trust-item span {
    color: var(--footer-muted);
    font-size: 0.86rem;
}

.footer-divider {
    position: relative;
    z-index: 2;
    border-color: var(--footer-line);
    margin: 34px 0 22px;
}

.footer-bottom {
    position: relative;
    z-index: 2;
}

.footer-payments {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.9);
    font-size: 1.45rem;
}

.footer-wellness-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 22px;
}

.footer-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    min-height: 34px;
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 50px;
    color: var(--footer-muted);
    background: rgba(255,255,255,0.06);
    padding: 7px 12px;
    font-size: 0.78rem;
    font-weight: 800;
    text-decoration: none;
    transition: transform 0.22s ease, background 0.22s ease, color 0.22s ease, border-color 0.22s ease;
}

.footer-chip:hover {
    color: var(--footer-green);
    background: var(--footer-gold);
    border-color: var(--footer-gold);
    transform: translateY(-3px);
}

.footer-newsletter {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 24px;
    align-items: center;
    margin-top: 34px;
    padding: clamp(20px, 3vw, 30px);
    border: 1px solid rgba(226,192,141,0.2);
    border-radius: 8px;
    background: rgba(255,255,255,0.07);
    overflow: hidden;
}

.footer-newsletter::after {
    content: '';
    position: absolute;
    top: -65%;
    left: -70%;
    width: 40%;
    height: 230%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.24), transparent);
    transform: rotate(18deg);
    opacity: 0;
    transition: left 0.78s ease, opacity 0.32s ease;
    pointer-events: none;
}

.footer-newsletter:hover::after {
    left: 126%;
    opacity: 1;
}

.footer-newsletter h3 {
    font-family: 'Playfair Display', serif;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
}

.footer-newsletter p {
    color: var(--footer-muted);
    line-height: 1.7;
}

.footer-newsletter-form {
    display: flex;
    gap: 8px;
    padding: 7px;
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: 8px;
    background: rgba(255,255,255,0.08);
}

.footer-newsletter-input {
    min-height: 50px;
    flex: 1 1 auto;
    border: 0;
    outline: 0;
    border-radius: 8px;
    background: rgba(255,255,255,0.95);
    color: var(--footer-green);
    padding: 12px 14px;
}

.footer-newsletter-input::placeholder {
    color: rgba(18,45,34,0.55);
}

.footer-newsletter-btn,
.footer-copy-btn {
    border: 0;
    border-radius: 8px;
    color: var(--footer-green);
    background: linear-gradient(135deg, var(--footer-gold), var(--footer-gold-light));
    font-weight: 900;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
}

.footer-newsletter-btn {
    min-height: 50px;
    padding: 12px 18px;
    white-space: nowrap;
}

.footer-newsletter-btn:hover,
.footer-copy-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(200,161,101,0.22);
}

.footer-copy-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 8px;
}

.footer-toast {
    position: fixed;
    left: 50%;
    bottom: 24px;
    z-index: 1060;
    max-width: calc(100vw - 32px);
    padding: 12px 16px;
    border-radius: 50px;
    color: var(--footer-green);
    background: var(--footer-gold);
    font-weight: 900;
    box-shadow: 0 18px 44px rgba(0,0,0,0.22);
    opacity: 0;
    transform: translate(-50%, 14px);
    pointer-events: none;
    transition: opacity 0.24s ease, transform 0.24s ease;
}

.footer-toast.is-visible {
    opacity: 1;
    transform: translate(-50%, 0);
}

[dir="rtl"] .footer-column-title::after {
    left: auto;
    right: 0;
    background: linear-gradient(270deg, var(--footer-gold), transparent);
}

[dir="rtl"] .footer-link:hover {
    transform: translateX(-4px);
}

@media (max-width: 991.98px) {
    .footer-main {
        padding-top: 52px;
    }

    .footer-cta-actions {
        justify-content: flex-start;
    }

    .footer-trust-row {
        grid-template-columns: 1fr;
    }

    .footer-newsletter {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767.98px) {
    .footer-cta {
        margin-bottom: 30px;
        padding: 22px;
    }

    .footer-cta-actions,
    .footer-btn-primary,
    .footer-btn-outline,
    .footer-newsletter-form,
    .footer-newsletter-btn {
        width: 100%;
    }

    .footer-newsletter-form {
        flex-direction: column;
    }

    .footer-bottom-text {
        font-size: 0.84rem;
    }

}
</style>

<footer class="site-footer">
    <div class="footer-toast" id="footerToast" aria-live="polite"></div>

    <div class="footer-main">
        <div class="container">
            <div class="footer-cta">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="footer-mini-badge">
                            <i class="fas fa-leaf"></i>{{ __('Natural Wellness') }}
                        </span>
                        <h2 class="text-white mb-2">{{ __('Need help choosing the right herbal care?') }}</h2>
                        <p class="mb-0">{{ __('Browse trusted products or contact our team for guidance before you order.') }}</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="footer-cta-actions">
                            <a href="{{ route('shop.index') }}" class="footer-btn-primary">
                                {{ __('Shop Now') }} <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="{{ route('contact') }}" class="footer-btn-outline">
                                {{ __('Ask Support') }} <i class="fas fa-headset"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gy-5">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="footer-brand-link">
                        <img src="{{ asset('storage/settings/XxkHVaHPreip4SouIaDyPcSwyqTbick49TKyBP22.jpg') }}"
                            alt="{{ $siteName }}"
                            class="footer-logo">
                        <span class="footer-brand-name">{{ $siteName }}</span>
                    </a>

                    <p class="footer-brand-copy mb-0">{{ $footerDescription }}</p>

                    <div class="footer-wellness-chips" aria-label="{{ __('Popular wellness searches') }}">
                        <a href="{{ route('shop.index', ['search' => 'immunity']) }}" class="footer-chip">
                            <i class="fas fa-shield-alt"></i>{{ __('Immunity') }}
                        </a>
                        <a href="{{ route('shop.index', ['search' => 'digestion']) }}" class="footer-chip">
                            <i class="fas fa-leaf"></i>{{ __('Digestion') }}
                        </a>
                        <a href="{{ route('shop.index', ['search' => 'pain relief']) }}" class="footer-chip">
                            <i class="fas fa-fire-alt"></i>{{ __('Pain Relief') }}
                        </a>
                    </div>

                    <div class="footer-socials">
                        @forelse($socialLinks as $social)
                            <a href="{{ $social['url'] ?? '#' }}"
                                class="footer-social-link"
                                target="_blank"
                                rel="noopener"
                                aria-label="{{ $social['label'] ?? __('Social link') }}">
                                <i class="{{ $social['icon'] ?? 'fas fa-link' }}"></i>
                            </a>
                        @empty
                            <a href="{{ route('contact') }}" class="footer-social-link" aria-label="{{ __('Contact') }}">
                                <i class="fas fa-envelope"></i>
                            </a>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-column-title">{{ __('Quick Links') }}</h5>
                    <ul class="footer-link-list">
                        <li><a href="{{ route('home') }}" class="footer-link">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('shop.index') }}" class="footer-link">{{ __('Shop') }}</a></li>
                        <li><a href="{{ route('about') }}" class="footer-link">{{ __('About Us') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="footer-link">{{ __('Contact') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-column-title">{{ __('Customer Service') }}</h5>
                    <ul class="footer-link-list">
                        @forelse($footerPages as $fPage)
                            <li>
                                <a href="{{ route('pages.show', $fPage->slug) }}" class="footer-link">
                                    {{ $fPage->title }}
                                </a>
                            </li>
                        @empty
                            <li><a href="{{ route('contact') }}" class="footer-link">{{ __('Support') }}</a></li>
                        @endforelse
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-column-title">{{ __('Contact Us') }}</h5>

                    <div class="footer-contact-item">
                        <span class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="footer-contact-text">
                            <a href="{{ $mapUrl }}" target="_blank" rel="noopener">{{ $siteAddress }}</a>
                        </div>
                    </div>

                    <div class="footer-contact-item">
                        <span class="footer-contact-icon"><i class="fas fa-phone"></i></span>
                        <div class="footer-contact-text">
                            <a href="tel:{{ $cleanPhone }}">{!! nl2br(e($sitePhone)) !!}</a>
                            <br>
                            <button type="button" class="footer-copy-btn" data-footer-copy="{{ e(preg_replace('/\s+/', ' ', strip_tags($sitePhone))) }}" aria-label="{{ __('Copy phone') }}">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="footer-contact-item">
                        <span class="footer-contact-icon"><i class="fas fa-envelope"></i></span>
                        <div class="footer-contact-text">
                            <a href="mailto:{{ $siteEmail }}">{{ $siteEmail }}</a>
                            <br>
                            <button type="button" class="footer-copy-btn" data-footer-copy="{{ e($siteEmail) }}" aria-label="{{ __('Copy email') }}">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-newsletter">
                <div>
                    <span class="footer-mini-badge">
                        <i class="fas fa-envelope-open-text"></i>{{ __('Wellness Updates') }}
                    </span>
                    <h3>{{ __('Get herbal care tips and private offers') }}</h3>
                    <p class="mb-0">{{ __('Short, useful updates for new arrivals, daily care, and seasonal wellness.') }}</p>
                </div>
                <form class="footer-newsletter-form" id="footerNewsletterForm" method="POST" action="{{ $footerNewsletterAction }}">
                    @csrf
                    <input type="email"
                        name="email"
                        class="footer-newsletter-input"
                        placeholder="{{ __('Enter your email') }}"
                        required>
                    <button type="submit" class="footer-newsletter-btn" id="footerNewsletterBtn">
                        {{ __('Subscribe') }}
                    </button>
                </form>
            </div>

            <div class="footer-trust-row">
                <div class="footer-trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>{{ __('Quality checked herbal products') }}</span>
                </div>
                <div class="footer-trust-item">
                    <i class="fas fa-truck-fast"></i>
                    <span>{{ __('Reliable delivery support') }}</span>
                </div>
                <div class="footer-trust-item">
                    <i class="fas fa-headset"></i>
                    <span>{{ __('Helpful customer care') }}</span>
                </div>
            </div>

            <hr class="footer-divider">

            <div class="footer-bottom row align-items-center g-3">
                <div class="col-lg-7 text-center text-lg-start">
                    <p class="footer-bottom-text mb-0">
                        &copy; {{ date('Y') }} {{ $siteName }}. {{ __('All Rights Reserved') }}.
                        | {{ __('Developed by') }}
                        <a href="https://www.codessol.com/" class="text-white text-decoration-none fw-bold" target="_blank" rel="noopener">Codessol</a>
                    </p>
                </div>
                <div class="col-lg-5 text-center text-lg-end">
                    <span class="footer-payments" aria-label="{{ __('Payment methods') }}">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-paypal"></i>
                        <i class="fab fa-cc-amex"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('footerToast');
    const newsletterForm = document.getElementById('footerNewsletterForm');
    const newsletterBtn = document.getElementById('footerNewsletterBtn');
    let toastTimer;

    function showFooterToast(message) {
        if (!toast) return;

        toast.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(function () {
            toast.classList.remove('is-visible');
        }, 2200);
    }

    document.querySelectorAll('[data-footer-copy]').forEach(function (button) {
        button.addEventListener('click', async function () {
            const value = button.dataset.footerCopy || '';

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(value);
                } else {
                    const temp = document.createElement('textarea');
                    temp.value = value;
                    temp.setAttribute('readonly', '');
                    temp.style.position = 'fixed';
                    temp.style.opacity = '0';
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    document.body.removeChild(temp);
                }

                showFooterToast('{{ __('Copied to clipboard') }}');
            } catch (error) {
                showFooterToast('{{ __('Copy failed') }}');
            }
        });
    });

    if (newsletterForm && newsletterBtn) {
        newsletterForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const action = newsletterForm.getAttribute('action');
            const formData = new FormData(newsletterForm);

            if (!action || action === '#') {
                showFooterToast('{{ __('Thank you for subscribing.') }}');
                newsletterForm.reset();
                return;
            }

            newsletterBtn.disabled = true;
            newsletterBtn.textContent = '{{ __('Subscribing...') }}';

            try {
                const response = await fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json().catch(function () {
                    return {};
                });

                if (!response.ok) {
                    throw new Error(data.message || '{{ __('Please enter a valid email address.') }}');
                }

                showFooterToast(data.message || '{{ __('Thank you for subscribing.') }}');
                newsletterForm.reset();
            } catch (error) {
                showFooterToast(error.message || '{{ __('Something went wrong. Please try again.') }}');
            } finally {
                newsletterBtn.disabled = false;
                newsletterBtn.textContent = '{{ __('Subscribe') }}';
            }
        });
    }
});
</script>
