<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;

class SeoService
{
    /**
     * Generate canonical URL for current route
     */
    public static function getCanonicalUrl($route = null, $params = [])
    {
        if ($route) {
            return route($route, $params, false);
        }
        return request()->url();
    }

    /**
     * Generate hreflang tags for English and Urdu
     */
    public static function generateHreflangs($route = null, $params = [])
    {
        $hreflangs = [];
        $locales = ['en', 'ur'];

        foreach ($locales as $locale) {
            $currentParams = array_merge($params, ['locale' => $locale]);
            if ($route) {
                $url = route($route, $currentParams, false);
            } else {
                $url = request()->fullUrl();
            }

            $hreflangs[$locale] = [
                'lang' => $locale,
                'url' => $url,
                'tag' => '<link rel="alternate" hreflang="' . $locale . '" href="' . $url . '">'
            ];
        }

        // Add x-default hreflang
        $hreflangs['x-default'] = [
            'lang' => 'x-default',
            'url' => route($route ?? 'home', ['locale' => 'en'], false),
            'tag' => '<link rel="alternate" hreflang="x-default" href="' . route($route ?? 'home', ['locale' => 'en'], false) . '">'
        ];

        return $hreflangs;
    }

    /**
     * Generate Product structured data (JSON-LD)
     */
    public static function generateProductSchema($product)
    {
        $avgRating = $product->reviews->avg('rating') ?: 0;
        $reviewCount = $product->reviews->count();

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->short_description ?: $product->description,
            'url' => route('product.show', $product->slug),
            'image' => $product->main_image,
            'brand' => [
                '@type' => 'Brand',
                'name' => config('app.name', 'dwakhana')
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('product.show', $product->slug),
                'priceCurrency' => 'PKR',
                'price' => $product->sale_price ?? $product->price,
                'availability' => $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ]
        ];

        if ($reviewCount > 0) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => round($avgRating, 1),
                'reviewCount' => $reviewCount
            ];
        }

        return $schema;
    }

    /**
     * Generate Article/BlogPost structured data (JSON-LD)
     */
    public static function generateArticleSchema($post)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->excerpt,
            'articleBody' => strip_tags($post->body),
            'image' => $post->featured_image,
            'datePublished' => $post->published_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name ?? 'Admin'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name', 'dwakhana')
            ]
        ];

        return $schema;
    }

    /**
     * Generate Breadcrumb structured data (JSON-LD)
     */
    public static function generateBreadcrumbSchema($breadcrumbs)
    {
        $items = [];
        $position = 1;

        foreach ($breadcrumbs as $label => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $label,
                'item' => $url
            ];
            $position++;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }

    /**
     * Generate LocalBusiness schema with location data
     */
    public static function generateLocalBusinessSchema($settings)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $settings['site_name'] ?? 'dwakhana',
            'url' => config('app.url'),
            'description' => $settings['meta_description'] ?? 'Trusted hakimai dawae in Pakistan',
            'areaServed' => 'PK'
        ];

        if (!empty($settings['site_phone'])) {
            $schema['telephone'] = $settings['site_phone'];
        }

        if (!empty($settings['site_address'])) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $settings['site_address'],
                'addressCountry' => 'PK'
            ];
        }

        if (!empty($settings['site_logo'])) {
            $schema['image'] = asset($settings['site_logo']);
        }

        return $schema;
    }

    /**
     * Generate Organization schema
     */
    public static function generateOrganizationSchema($settings)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $settings['site_name'] ?? 'dwakhana',
            'url' => config('app.url'),
            'logo' => asset($settings['site_logo'] ?? '/assets/logo.png'),
            'sameAs' => [],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Support',
                'telephone' => $settings['site_phone'] ?? '+92-1234567890'
            ]
        ];

        return $schema;
    }
}
