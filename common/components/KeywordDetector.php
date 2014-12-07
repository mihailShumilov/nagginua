<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/7/14
     * Time: 11:10
     */

    namespace common\components;

    use yii\base\Component;


    class KeywordDetector extends Component
    {
        public static function detect( $string )
        {
            $string     = mb_strtolower( $string, "UTF-8" ); // make it lowercase
            $matchWords = mb_split( " ", $string );
            array_walk( $matchWords, 'trim' );

            foreach ($matchWords as $key => $item) {
                if ($item == '' || strlen( $item ) <= 6) {
                    unset( $matchWords[$key] );
                }
            }
            $wordCountArr = array();
            if (is_array( $matchWords )) {
                foreach ($matchWords as $key => $val) {
                    $val = mb_strtolower( $val, "UTF-8" );
                    if (isset( $wordCountArr[$val] )) {
                        $wordCountArr[$val] ++;
                    } else {
                        $wordCountArr[$val] = 1;
                    }
                }
            }
            arsort( $wordCountArr );

            $wordCountArr = array_slice( $wordCountArr, 0, 10 );
            $returnArr    = array();
            foreach ($wordCountArr as $word => $count) {
                if ($count > 3) {
                    $returnArr[] = $word;
                }
            }

            return $returnArr;
        }
    }