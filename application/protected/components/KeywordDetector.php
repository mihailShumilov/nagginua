<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 04.04.14
 * Time: 14:33
 */
class KeywordDetector extends CApplicationComponent
{
    public static function detect($string)
    {
//        $stopWords = Yii::app()->params['stopWord'];

//        $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
//        $string = trim($string); // trim the string
//        $string = preg_replace('/[^а-яА-Яa-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
        $string = strtolower($string); // make it lowercase

//        preg_match_all('/\b.*?\b/i', $string, $matchWords);
//        $matchWords = $matchWords[0];
        $matchWords = explode(" ", $string);
        array_walk($matchWords, 'trim');
//        print_r($matchWords);

        foreach ($matchWords as $key => $item) {
//            if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
            if ($item == '' || strlen($item) <= 6) {
                unset($matchWords[$key]);
            }
        }
        $wordCountArr = array();
        if (is_array($matchWords)) {
            foreach ($matchWords as $key => $val) {
                $val = strtolower($val);
                if (isset($wordCountArr[$val])) {
                    $wordCountArr[$val]++;
                } else {
                    $wordCountArr[$val] = 1;
                }
            }
        }
        arsort($wordCountArr);

        $wordCountArr = array_slice($wordCountArr, 0, 10);
        $returnArr    = array();
        foreach ($wordCountArr as $word => $count) {
            if ($count > 3) {
                $returnArr[] = $word;
            }
        }
//        return array_keys($wordCountArr);
        return $returnArr;
    }
} 