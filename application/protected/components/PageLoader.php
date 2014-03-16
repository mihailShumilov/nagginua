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
                $ch      = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
            } catch (Exception $e) {
                return false;
            }
        } else {
            throw new Exception("No valid url: `{$url}`");
        }
    }
} 