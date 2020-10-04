<?php
namespace App;

use App\Locale\Locale;
use App\Exceptions\Exception;
use Prismic\Api;
use Prismic\LinkResolver as PrismicLinkResolver;

/**
 * The link resolver is the code building URLs for pages corresponding to
 * a Prismic document.
 *
 * If you want to change the URLs of your site, you need to update this class
 * as well as the routes in routes/web.php.
 */
class LinkResolver extends PrismicLinkResolver
{
    /**
     * This function will be used to generate links to Prismic.io documents
     * As your project grows, you should update this function according to your routes
     *
     * @param  object  $link
     * @return string
     */
    public function resolve($link): ?String
    {

        if(isset($link->link_type) && strcasecmp($link->link_type, 'web') == 0) {
            return $link->url;
        }

        // get locale
        $locale = Locale::findLocaleOfDocument($link);
        $href = '/' . $locale;

        if(empty($locale)) {
            return null;
        }

        // Example link resolver for custom type with API ID of 'page'
        if($link->type === 'homepage') {
            return $href;
        }
        else if($link->type === 'operator') {
            $operatorSlugs = array_flip(Locale::getLocaleConfig($locale, 'parent_slugs'));

            $operatorSlug = '';
            if(array_key_exists('operator', $operatorSlugs)) {
                $operatorSlug = $operatorSlugs['operator'];
            }
            return $href . '/' . $operatorSlug . '/' . $link->uid;
        }
        else if($link->type == 'page') {
            $api = Api::get(config('prismic.url'), config('prismic.token'));
            $slug = '/' . $link->uid;

            $page = $api->getByID($link->id);
            while(true) {
                try {
                    if(isset($page) && isset($page->data) && isset($page->data->parent) && isset($page->data->parent->uid)) {
                        $slug = '/' . $page->data->parent->uid . $slug;
                        $page = $api->getByID($page->data->parent->id);
                    }
                    else {
                        return $href . $slug;
                    }
                }
                catch (Exception  $o) {
                    dump($page);
                }
            }

        }


        // Default case returns the homepage
        return '/';
    }

    public function resolveWithAppUrl($link): ?String
    {
        if($link =$this->resolve($link)) {
            return config('app.url') . $link;
        }

        return null;
    }

}
