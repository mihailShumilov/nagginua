<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 09.03.14
 * Time: 6:43
 */
class PageLoader extends CApplicationComponent
{
    public static function load($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            try {
                $opts = array(
                    'http' => array(
                        'method' => "GET",
                        'header' => "Accept-language: ru\r\n" .
                            "Cookie: foo=bar\r\n"
                    )
                );

                $context = stream_context_create($opts);
                return file_get_contents($url, false, $context);
            } catch (Exception $e) {
                return false;
            }
        } else {
            throw new Exception("No valid url: `{$url}`");
        }
    }
} 