<?php

function translate($translate, $key, $default = null)
{
    return default_helper($translate, $key, $default);
}

function setting($settings, $key, $default = null)
{
    return default_helper($settings, $key, $default);
}

function redirect_link($document, $redirectKey = 'redirect_key')
{
    return '/' . App\Locale\Locale::findLocaleOfDocument($document)
        . '/go/' . $document->data->{$redirectKey};
}

/**
 * Get value from object, if it doesnt exist return
 * default value (if we have one)
 *
 * @param  Object $object
 * @param  String $key
 * @param  String $default
 * @return String
 */
function default_helper($object, $key, $default = null) {
    if(isset($object->$key) && $value = $object->$key) {
        return $value;
    }

    if($default) {
        return $default;
    }

    return '';
}
