<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        $availableLocales = ['en', 'ur'];

        if (in_array($locale, $availableLocales)) {
            session()->put('locale', $locale);
        }

        // Redirect back to the previous URL, or home if no referrer
        $previous = url()->previous();
        $home = url('/');

        // Avoid redirect loops (e.g., back to the lang route itself)
        if (str_contains($previous, '/lang/')) {
            return redirect($home);
        }

        return redirect($previous ?: $home);
    }
}
