<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        $urls[] = [
            'loc' => url('/'),
            'lastmod' => now()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // Pages
        foreach (Page::where('is_active', 1)->get() as $page) {
            $urls[] = [
                'loc' => url('/page/' . $page->slug),
                'lastmod' => $page->updated_at ? $page->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        // Categories
        foreach (Category::all() as $cat) {
            $urls[] = [
                'loc' => url('/shop?category=' . $cat->slug),
                'lastmod' => $cat->updated_at ? $cat->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Products
        foreach (Product::where('is_active', 1)->get() as $product) {
            $urls[] = [
                'loc' => url('/product/' . $product->slug),
                'lastmod' => $product->updated_at ? $product->updated_at->toAtomString() : now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Blog posts
        foreach (BlogPost::where('is_published', 1)->get() as $post) {
            $urls[] = [
                'loc' => url('/blog/' . $post->slug),
                'lastmod' => $post->published_at ? $post->published_at->toAtomString() : ($post->updated_at ? $post->updated_at->toAtomString() : now()->toAtomString()),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $xml = $this->buildXml($urls);

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    protected function buildXml(array $urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>\n';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . e($u['loc']) . "</loc>\n";
            if (!empty($u['lastmod'])) {
                $xml .= "    <lastmod>" . e($u['lastmod']) . "</lastmod>\n";
            }
            if (!empty($u['changefreq'])) {
                $xml .= "    <changefreq>" . e($u['changefreq']) . "</changefreq>\n";
            }
            if (!empty($u['priority'])) {
                $xml .= "    <priority>" . e($u['priority']) . "</priority>\n";
            }
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
