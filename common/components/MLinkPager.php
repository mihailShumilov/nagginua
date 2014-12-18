<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/18/14
     * Time: 22:45
     */

    namespace common\components;


    use yii\helpers\Html;
    use yii\widgets\LinkPager;

    class MLinkPager extends LinkPager
    {
        /**
         * Renders a page button.
         * You may override this method to customize the generation of page buttons.
         *
         * @param string $label the text label for the button
         * @param integer $page the page number
         * @param string $class the CSS class for the page button.
         * @param boolean $disabled whether this page button is disabled
         * @param boolean $active whether this page button is active
         *
         * @return string the rendering result
         */
        protected function renderPageButton( $label, $page, $class, $disabled, $active )
        {
            $options = [ ];

            if ($disabled) {
                Html::addCssClass( $options, $this->disabledPageCssClass );

                return Html::tag( 'li', Html::tag( 'span', $label ), $options );
            }
            $linkOptions              = $this->linkOptions;
            $linkOptions['data-page'] = $page;
            $linkOptions['class']     = $class === '' ? null : $class;
            if ($active) {
                Html::addCssClass( $linkOptions, $this->activePageCssClass );
            }

            return Html::tag( 'li', Html::a( $label, $this->pagination->createUrl( $page ), $linkOptions ), $options );
        }
    }