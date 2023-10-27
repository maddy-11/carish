<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language;
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * Adding multi-language functionality in a website developed in laravel
     */
   public function handle($request, Closure $next)
        {
        
           if(\Session::has('locale'))
           {
                $locale = \Session::get('locale');
                \App::setlocale($locale);
                $language = Language::select('id', 'language_title', 'language_code')->where('language_code', $locale)->first();
                \Session::put('language', ['id' => $language->id, 'language_title' => $language->language_title, 'language_code' => $language->language_code]);   
           }else {

                $language = Language::select('id', 'language_title', 'language_code')->where('language_code', 'et')->first();
                \Session::put('language', ['id' => $language->id, 'language_title' => $language->language_title, 'language_code' => $language->language_code]);
        }
        $activeLanguage = \Session::get('language');  
           return $next($request);
        }
}
