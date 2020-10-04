<?php
return [

    /*
    |--------------------------------------------------------------------------
    | prismic.io preview
    |--------------------------------------------------------------------------
    |
    | If we're using this url as a preview site, this will be set to
    | true. We can do preview on local, dev but not on production as
    | it's adding some scripts etc. that we don't need. Therefor we're
    | using a clone on production for the previews.
    |
    */
   'preview' => env('PRISMIC_PREVIEW', false),

    /*
    |--------------------------------------------------------------------------
    | prismic.io API Endpoint URL
    |--------------------------------------------------------------------------
    |
    | Here you must specify the URL of your prismic.io repository. This is
    | required to be able to load the content.
    |
    */
    'url' => 'https://sgbg.cdn.prismic.io/api/v2',

    /*
    |--------------------------------------------------------------------------
    | prismic.io API Access Token
    |--------------------------------------------------------------------------
    |
    | Here you can specify your API Access Token if you are using a private API.
    | If you are not using a private API, then leave this configuration set to
    | the default value of null.
    |
    */
    'token' => 'MC5YaFNYSWhFQUFDSUFIQ2V1.77-977-977-9Vnjvv71yDXfvv71a77-977-9Y0Lvv70777-9C38O77-9a--_ve-_vW3vv73vv73vv709GU8',

    'page_types' => [
        'home' => 'homepage',
        'operator' => 'operator',
        'academy' => 'academy',
    ]
];
