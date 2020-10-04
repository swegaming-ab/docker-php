<?php

namespace App\Locale;

class Locale
{

    // TODO Clean up Locale Class
    // I think there's lots of stuff we dont
    // use here or should be located somewhere else

    public static function formatNumeric($locale, $numeric, $decimals = 0)
    {
        return number_format(
            $numeric,
            $decimals,
            self::getLocaleConfig($locale, 'formatting.numbers.decimal_seperator'),
            self::getLocaleConfig($locale, 'formatting.numbers.thousands_seperator')
        );
    }

    public static function formatMoney($locale, $amount, $decimals = 0, $currency = null)
    {

        if($currency == null) {
            $currency = self::getLocaleConfig($locale, 'formatting.numbers.default_currency');
        }

        $formattedNumeric = self::formatNumeric($locale, $numeric, $decimals);
        if(self::getLocaleConfig($locale, 'formatting.numbers.currency_first')) {
            return $currency . $formattedNumeric;
        }
        else {
            return $formattedNumeric . $currency;
        }
    }

    public static function findLocaleOfDocument($document)
    {
        foreach (config('locales') as $locale => $config) {
            if( $config['enabled'] &&
                strtolower($document->lang) == strtolower($config['prismic'])) {
                return $locale;
            }
        }
    }

    public static function getLocaleConfig($locale, $configParameter)
    {
        return config('locales.' . $locale . '.' . $configParameter);
    }

    public static function getAvailablePrismicLocales()
    {
        $availableLocales = [];
        foreach (config('locales') as $locale => $config) {
            if($config['enabled']) {
                $availableLocales[] = $config['prismic'];
            }
        }
        return $availableLocales;
    }
}
