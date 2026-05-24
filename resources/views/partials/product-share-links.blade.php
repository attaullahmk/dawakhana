@once
<style>
.product-share-links {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.product-share-link {
    --share-color: #17382b;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(26,60,46,0.1);
    border-radius: 50%;
    color: var(--share-color) !important;
    background: #fff;
    box-shadow: 0 10px 24px rgba(26,60,46,0.08);
    text-decoration: none;
    transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease, background 0.24s ease, color 0.24s ease;
}

.product-share-link i {
    font-size: 1rem;
    line-height: 1;
    transition: transform 0.24s ease;
}

.product-share-link:hover,
.product-share-link:focus {
    transform: translateY(-4px);
    color: #fff !important;
    border-color: var(--share-color);
    background: var(--share-color);
    box-shadow: 0 16px 32px rgba(26,60,46,0.16);
}

.product-share-link:hover i,
.product-share-link:focus i {
    transform: scale(1.12);
}

.product-share-link.is-facebook { --share-color: #1877f2; }
.product-share-link.is-twitter { --share-color: #111; }
.product-share-link.is-pinterest { --share-color: #bd081c; }
.product-share-link.is-linkedin { --share-color: #0a66c2; }
.product-share-link.is-whatsapp { --share-color: #25d366; }
.product-share-link.is-copy { --share-color: #c8a165; }

.product-share-link.is-copy:hover,
.product-share-link.is-copy:focus {
    color: #17382b !important;
}

@media (max-width: 575.98px) {
    .product-share-links {
        justify-content: center;
    }

    .product-share-link {
        width: 40px;
        height: 40px;
    }
}
</style>
@endonce

@php
    $currentUrlRaw = url()->current();
    $currentUrl = urlencode($currentUrlRaw);
    $productName = urlencode($product->name);
    $productImage = urlencode(asset($product->main_image));
    $renderedShareLinks = 0;
@endphp

<span class="product-share-links">
    @foreach($socialLinks ?? [] as $link)
        @php
            $shareHref = '#';
            $icon = $link['icon'] ?? '';
            $iconLower = strtolower($icon);
            $platformName = __('Share');
            $platformClass = '';

            if (str_contains($iconLower, 'facebook')) {
                $shareHref = "https://www.facebook.com/sharer/sharer.php?u={$currentUrl}";
                $platformName = __('Facebook');
                $platformClass = 'is-facebook';
            } elseif (str_contains($iconLower, 'twitter') || str_contains($iconLower, 'x-twitter')) {
                $shareHref = "https://twitter.com/intent/tweet?url={$currentUrl}&text={$productName}";
                $platformName = __('X');
                $platformClass = 'is-twitter';
            } elseif (str_contains($iconLower, 'pinterest')) {
                $shareHref = "https://pinterest.com/pin/create/button/?url={$currentUrl}&media={$productImage}&description={$productName}";
                $platformName = __('Pinterest');
                $platformClass = 'is-pinterest';
            } elseif (str_contains($iconLower, 'linkedin')) {
                $shareHref = "https://www.linkedin.com/sharing/share-offsite/?url={$currentUrl}";
                $platformName = __('LinkedIn');
                $platformClass = 'is-linkedin';
            } elseif (str_contains($iconLower, 'whatsapp')) {
                $shareHref = "https://api.whatsapp.com/send?text={$productName}%20{$currentUrl}";
                $platformName = __('WhatsApp');
                $platformClass = 'is-whatsapp';
            }
        @endphp

        @if($shareHref !== '#')
            @php $renderedShareLinks++; @endphp
            <a href="{{ $shareHref }}"
                target="_blank"
                rel="noopener noreferrer"
                class="product-share-link {{ $platformClass }}"
                aria-label="{{ __('Share on') }} {{ $platformName }}">
                <i class="{{ $icon }}" aria-hidden="true"></i>
            </a>
        @endif
    @endforeach

    @if($renderedShareLinks === 0)
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            class="product-share-link is-facebook"
            aria-label="{{ __('Share on Facebook') }}">
            <i class="fab fa-facebook-f" aria-hidden="true"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url={{ $currentUrl }}&text={{ $productName }}"
            target="_blank"
            rel="noopener noreferrer"
            class="product-share-link is-twitter"
            aria-label="{{ __('Share on X') }}">
            <i class="fab fa-x-twitter" aria-hidden="true"></i>
        </a>
        <a href="https://api.whatsapp.com/send?text={{ $productName }}%20{{ $currentUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            class="product-share-link is-whatsapp"
            aria-label="{{ __('Share on WhatsApp') }}">
            <i class="fab fa-whatsapp" aria-hidden="true"></i>
        </a>
    @endif

    <button type="button"
        class="product-share-link is-copy border-0"
        data-copy-url="{{ $currentUrlRaw }}"
        aria-label="{{ __('Copy product link') }}">
        <i class="fas fa-link" aria-hidden="true"></i>
    </button>
</span>

@once
<script>
document.addEventListener('click', function (event) {
    const copyButton = event.target.closest('.product-share-link.is-copy');
    if (!copyButton) return;

    const originalHtml = copyButton.innerHTML;
    const url = copyButton.getAttribute('data-copy-url');

    function showCopied() {
        copyButton.innerHTML = '<i class="fas fa-check" aria-hidden="true"></i>';
        copyButton.classList.add('is-copied');
        window.setTimeout(function () {
            copyButton.innerHTML = originalHtml;
            copyButton.classList.remove('is-copied');
        }, 1400);
    }

    if (navigator.clipboard && url) {
        navigator.clipboard.writeText(url).then(showCopied).catch(function () {});
    }
});
</script>
@endonce
