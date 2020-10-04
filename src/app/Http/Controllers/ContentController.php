<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Locale\Locale;

use App\LinkResolver;
use Prismic\Api;
use Prismic\Predicates;

use Illuminate\Support\Facades\Cache;

class ContentController extends Controller
{

    protected function getCacheString()
    {
        return request()->path();
    }

    /*
    |--------------------------------------------------------------------------
    | Prismic preview route
    |--------------------------------------------------------------------------
    */
   public function preview(Request $request)
   {
       if($token = $request->input('token')) {
           $api = Api::get(config('prismic.url'), config('prismic.token'));
           $url = $api->previewSession($token, new LinkResolver(), '/');
           return response(null, 302)->header('Location', $url);
       }

       abort(404);
   }

    /*
    |--------------------------------------------------------------------------
    | The language selector route
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $html = new \App\HtmlContent();
        return $html->index();
    }

    /*
    |--------------------------------------------------------------------------
    | Locale specific routes
    |--------------------------------------------------------------------------
    */
    public function home($locale)
    {
        $html = new \App\HtmlContent($locale);
        return Cache::remember($this->getCacheString(), config('view.cache'), function() use ($html, $locale) {
            return $html->home();
        });
    }

    public function localePage($locale, ...$path)
    {

        $cacheKey = $this->getCacheString();
        if($response = Cache::get($this->getCacheString($cacheKey))) {
            return $response;
        }

        $html = new \App\HtmlContent($locale);
        if($response = $html->localePage($locale, $path)) {
            Cache::put($cacheKey, $response, config('view.cache'));
            return $response;
        }
    }

    public function redirect($locale, $key)
    {
        $html = new \App\HtmlContent($locale);
        return $html->redirect($locale, $key);
    }
}
