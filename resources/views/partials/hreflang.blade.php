@php
    // Generate hreflang links using current URL and lang query parameter
    $current = url()->current();
    $query = request()->getQueryString();
    $base = $current;
    if ($query) {
        // strip existing lang param if present
        parse_str($query, $qs);
        unset($qs['lang']);
        $base = $current . (count($qs) ? ('?' . http_build_query($qs)) : '');
    }
    $href_en = $base . (strpos($base, '?') === false ? '?lang=en' : '&lang=en');
    $href_ur = $base . (strpos($base, '?') === false ? '?lang=ur' : '&lang=ur');
@endphp

<link rel="alternate" hreflang="en" href="{{ $href_en }}">
<link rel="alternate" hreflang="ur" href="{{ $href_ur }}">
<link rel="alternate" hreflang="x-default" href="{{ $base }}">
