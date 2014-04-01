<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 09.03.14
 * Time: 6:43
 */
class PageLoader extends CApplicationComponent
{
    public static function load($url, $postParams = false)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            try {
                $ch      = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                if (isset($postParams) && !empty($postParams)) {
                    curl_setopt($ch, CURLOPT_HTTP_VERSION, '1.1');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
                }
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

    public static function loadFile($url)
    {
        if ($url) {
            $tmpfname = tempnam(sys_get_temp_dir(), "img_") . ".png";
            $fp = fopen($tmpfname, "w");
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FILE, $fp);

            $data = curl_exec($ch);

            curl_close($ch);
            fclose($fp);
            return $tmpfname;
        }
    }
} 