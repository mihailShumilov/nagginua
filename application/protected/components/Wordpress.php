<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 26.03.14
 * Time: 14:32
 */
class Wordpress extends CApplicationComponent
{
    private $wpUrl = '';

    public function __construct()
    {
        $this->wpUrl = Yii::app()->params['wpurl'];
    }

    protected function makeRequest($url, $params = array())
    {
        if ($url && !empty($params)) {
            $request = http_build_query($params);
            return json_decode(PageLoader::load($url . $request));
        } else {
            return false;
        }
    }

    public function getPost($postID)
    {
        echo "<pre>";
        print_r($this->makeRequest($this->wpUrl . "get_post/?", array("post_id" => 1)));
    }

    public function createPost()
    {
        $params = array(
            "blog_id"  => 1,
            "username" => "admin",
            "password" => "admin_na",
            "content"  => array(
                "post_type"    => "post",
                "post_status"  => "draft",
                "post_title"   => "TEST title",
                "post_author"  => "admin",
                "post_content" => "<h1>POST CONTENT</h1>",
                "post_date"    => date("Y-m-d H:i:s")
            )
        );
        echo "<pre>";
        print_r($this->makeRequest($this->wpUrl . "posts/create_post/?", array("post_id" => 1)));
    }
} 