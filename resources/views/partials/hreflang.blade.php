@php
    $href_en = request()->fullUrlWithQuery(['lang' => 'en']);
    $href_ur = request()->fullUrlWithQuery(['lang' => 'ur']);
@endphp

<link rel="alternate" hreflang="en" href="{{ $href_en }}">
<link rel="alternate" hreflang="ur" href="{{ $href_ur }}">
<link rel="alternate" hreflang="x-default" href="{{ $href_en }}">
