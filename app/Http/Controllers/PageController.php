<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Page;

class PageController extends Controller
{
    public function about()
    {
        $about = AboutSection::forLocale()->first();
        
        // Fallback to English if current locale content is missing
        if (!$about && app()->getLocale() !== 'en') {
            $about = AboutSection::where('locale', 'en')->first();
        }

        // Create a new empty instance if still null to prevent crashes
        $about = $about ?? new AboutSection();

        return view('pages.about', compact('about'));
    }

    public function show($slug)
    {
        // First try finding ANY active page with this slug
        $matchedPage = Page::where('slug', $slug)->active()->first();

        if (!$matchedPage) {
            abort(404);
        }

        $page = null;

        // If it belongs to a system_key, get the correct locale version for the current language
        if ($matchedPage->system_key) {
            $page = Page::forLocale()->active()->where('system_key', $matchedPage->system_key)->first();
            
            // Fallback to English if translation is missing
            if (!$page && app()->getLocale() !== 'en') {
                 $page = Page::where('system_key', $matchedPage->system_key)->where('locale', 'en')->active()->first();
            }
        } else {
             $page = Page::forLocale()->active()->where('slug', $slug)->first();
             if (!$page && app()->getLocale() !== 'en') {
                  $page = Page::where('slug', $slug)->where('locale', 'en')->active()->first();
             }
             if (!$page) {
                  $page = $matchedPage;
             }
        }

        if (!$page) {
            abort(404);
        }

        return view('pages.show', compact('page'));
    }
}
