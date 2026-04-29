@forelse($socialLinks ?? [] as $link)
    @php
        $shareHref = '#';
        $icon = $link['icon'] ?? '';
        $currentUrl = urlencode(url()->current());
        $productName = urlencode($product->name);
        $productImage = urlencode(asset($product->main_image));
        
        if (str_contains($icon, 'facebook')) {
            $shareHref = "https://www.facebook.com/sharer/sharer.php?u={$currentUrl}";
        } elseif (str_contains($icon, 'twitter') || str_contains($icon, 'x-twitter')) {
            $shareHref = "https://twitter.com/intent/tweet?url={$currentUrl}&text={$productName}";
        } elseif (str_contains($icon, 'pinterest')) {
            $shareHref = "https://pinterest.com/pin/create/button/?url={$currentUrl}&media={$productImage}&description={$productName}";
        } elseif (str_contains($icon, 'linkedin')) {
            $shareHref = "https://www.linkedin.com/sharing/share-offsite/?url={$currentUrl}";
        } elseif (str_contains($icon, 'whatsapp')) {
            $shareHref = "https://api.whatsapp.com/send?text={$productName}%20{$currentUrl}";
        }
    @endphp
    @if($shareHref !== '#')
        <a href="{{ $shareHref }}" target="_blank" class="text-dark fs-5 hover-gold transition shadow-none mx-1">
            <i class="{{ $icon }}"></i>
        </a>
    @endif
@empty
    <!-- Fallback if no social settings -->
    @php
        $currentUrl = urlencode(url()->current());
        $productName = urlencode($product->name);
    @endphp
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}" target="_blank" class="text-dark fs-5 hover-gold mx-1"><i class="fab fa-facebook-f"></i></a>
    <a href="https://twitter.com/intent/tweet?url={{ $currentUrl }}&text={{ $productName }}" target="_blank" class="text-dark fs-5 hover-gold mx-1"><i class="fab fa-x-twitter"></i></a>
@endforelse
