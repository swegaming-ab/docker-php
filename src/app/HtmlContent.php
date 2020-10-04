<?php
namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


use App\Locale\Locale;

use Prismic\Api;
use App\LinkResolver;
use Prismic\Predicates;


class HtmlContent
{
    private $client;
    private $locale;

    public function __construct($locale = null) {
        $this->locale = $locale;
        $this->client = Api::get(config('prismic.url'), config('prismic.token'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    protected function localeActive($locale)
    {

        // check that the page exists, and that it's
        // enabled through the env file

        return in_array($locale, array_keys(config('locales')))
            && config('locales.' .$locale. '.enabled');
    }

    protected function localeOption($locale, $array = array())
    {
        return array_merge($array, ['lang' => config('locales.' . $locale . '.prismic')]);
    }

    protected function return404()
    {
        abort(404);
    }


    protected function getCustomType($postType)
    {

        if($this->locale) {
            $response = $this->client->query(
                [Predicates::at('document.type', $postType)],
                ['lang' => Locale::getLocaleConfig($this->locale, 'prismic')]
            );

            if(count($response->results) > 0) {
                return $response->results[0]->data;
            }
        }

        // default return to empty
        return [];
    }

    protected function getView($documentOrResponse, $view, $checkForRedirect = true)
    {
        $document = null;
        if(isset($documentOrResponse->results)) {
            if(count($documentOrResponse->results) > 0) {
                $document = $documentOrResponse->results[0];
            }
        }
        else {
            $document = $documentOrResponse;
        }

        if($document == null) {
            return $this->return404();
        }

        if($checkForRedirect) {

            // let's check the url, if it's incorrect lets redirect
            $linkResolver = new LinkResolver();
            $url = $linkResolver->resolve($document);

            if(strcasecmp($url, '/' . request()->path()) !== 0) {

                // redirect to the url we should have if
                // we're not at it.
                redirect()->away($url, 301);
                return null;
            }
        }

        $variables = [
            'document' => $document,
            'settings' => $this->getCustomType('settings'),
            'translations' => $this->getCustomType('translations')
        ];

        if($this->locale) {
            $variables['locale'] = $this->locale;
        }

        // TODO Html Minify
        // Should probably be done through minifying blade
        // templates instead of doing like this. Or both??
        // This is ok for now though as we cache the results
        // so this is not done very often anyway

        if(config('view.minify')) {
            $search = array(
                '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
                '/[^\S ]+\</s',     // strip whitespaces before tags, except space
                '/(\s)+/s',         // shorten multiple whitespace sequences
                '/<!--(.|\s)*?-->/' // Remove HTML comments
            );

            $replace = array(
                '>',
                '<',
                '\\1',
                ''
            );

            return preg_replace($search, $replace, view($view, $variables)->render());
        }
        else {
            return view($view, $variables)->render();
        }
    }


    public function index()
    {
        return view('index');
    }

    public function home($locale = null)
    {
        if($locale == null) {
            $locale = $this->locale;
        }

        if($locale) {
            if(!$this->localeActive($locale)) {
                return $this->return404();
            }

            return $this->getView(
                $this->client->getSingle(
                    'homepage',
                    $this->localeOption(
                        $locale,
                        ['fetchLinks' => 'operator.title, operator.operator_logo, operator.operator_main_color'])
                ),
                'locale.index'
            );
        }
    }

    public function redirect($locale, $key)
    {
        if(!$this->localeActive($locale)) {
            return $this->return404();
        }

        $operatorSearch = $this->client->query(
            Predicates::at('my.operator.redirect_key', $key),
            $this->localeOption($locale)
        );

        // get view without checking for redirect. we're giving
        // it another document than the url because we want to
        return $this->getView($operatorSearch, 'locale.redirect', false);
    }

    public function localePage($locale, $path)
    {

        // TODO clean up this function

        $this->locale = $locale;
        if(!$this->localeActive($locale)) {
            return $this->return404();
        }

        if(count($path) == 1) {

            // query a document with uid path[0]
            // and doesnt have a parent page

            return $this->getView(
                $this->client->query(
                    [
                        Predicates::at('my.page.uid', $path[0]),
                        Predicates::missing('my.page.parent'),
                    ],
                    $this->localeOption($locale)
                ),
                'locale.page'
            );
        }
        else {
            if(count($path) == 2) {

                // check if it's a special page type
                // that we're looking for. E.g. operator
                $parentSlugs = Locale::getLocaleConfig($locale, 'parent_slugs');
                if(array_key_exists($path[0], $parentSlugs)) {

                    // if it's a special page typ that we use
                    // parent slug for. Then, let's find that
                    // document.

                    $pageType = $parentSlugs[$path[0]];
                    return $this->getView(
                        $this->client->getByUID($pageType, $path[1], $this->localeOption($locale, ['fetchLinks' => 'payment_method.logo'])),
                        'locale.operator'
                    );
                }
            }

            $slug = end($path);
            if($possibleDocument = $this->client->getByUID('page', $slug, $this->localeOption($locale))) {
                $parentCount = count($path) - 1;

                $currentDocument = $possibleDocument;
                while($parentCount-- > 0) {
                    if(isset($currentDocument->data) && isset($currentDocument->data->parent) && $currentDocument->data->parent->uid == $path[$parentCount]) {

                        // all good, get the next.
                        if($parentCount > 0) {
                            $currentDocument = $this->client->getByID($currentDocument->data->parent->id);
                        }
                    }
                    else {
                        // if we can't find it, that means that it
                        // doesnt exists and the url is faulty
                        return $this->return404();
                    }
                }
                return $this->getView($possibleDocument, 'locale.page');
            }
            return $this->return404();
        }
    }

}
