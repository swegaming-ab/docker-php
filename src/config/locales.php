<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | Locale options and configuration. The key of the array should
    | be how we connect to the locale in the url. E.g:
    | https://bettingguide.com/{locale}/...
    |
    */

    'in' => [
        'enabled' => in_array('in', explode(',', env('LOCALES', 'in'))),
        'prismic' => 'en-IN',
        'html_lang' => 'en-IN',
        'country' => 'India',

        // 'local' => 'prismic'
        'parent_slugs' => [
            'operator' => 'operator',
        ],

        'locale_selector' => [
            'img' => [
                'overlay' => '/icons/flags/indiaoverlay.png',
                'flag' => '/icons/flags/india.png',
            ],
        ],
    ],
    'sv' => [
        'enabled' => in_array('sv', explode(',', env('LOCALES', 'in'))),
        'country' => 'Sweden',
        'html_lang' => 'sv',
        'prismic' => 'sv-SE',

        'parent_slugs' => [
            'spelbolag' => 'operator',
        ],

        'locale_selector' => [
            'img' => [
                'overlay' => '/icons/flags/nigeriaoverlay.png',
                'flag' => '/icons/flags/sweden.png',
            ],
        ],
    ],
    'ng' => [
        'enabled' => in_array('ng', explode(',', env('LOCALES', 'in'))),
        'country' => 'Nigeria',
        'html_lang' => 'en-NG',
        'prismic' => 'en-NG',

        'parent_slugs' => [
            'operator' => 'operator',
        ],

        'locale_selector' => [
            'img' => [
                'overlay' => '/icons/flags/nigeriaoverlay.png',
                'flag' => '/icons/flags/nigeria.png',
            ],
        ],
    ],
    'ca' => [
        'enabled' => in_array('ca', explode(',', env('LOCALES', 'in'))),
        'country' => 'Canada',
        'html_lang' => 'en-CA',
        'prismic' => 'en-CA',
        'parent_slugs' => [
            'operator' => 'operator',
        ],
        'locale_selector' => [
            'img' => [
                'overlay' => '/icons/flags/canada.png',
                'flag' => '/icons/flags/canada.png',
            ],
        ],
    ]
];
