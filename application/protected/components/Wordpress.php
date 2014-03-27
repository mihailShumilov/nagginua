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
            $result = PageLoader::load($url . "?" . $request);
            if ("?" == substr($result, 0, 1)) {
                $result = preg_replace('/.+?({.+}).+/', '$1', $result);
            }
            return json_decode($result);
        } else {
            return false;
        }
    }

    public function getPost($postID)
    {
        echo "<pre>";
        print_r($this->makeRequest($this->wpUrl . "get_post/", array("post_id" => 1)));
    }

    public function createPost()
    {
        $nonce = $this->getNonce("posts", "create_post");
//        $params = array(
//            "blog_id"  => 1,
//            "username" => "admin",
//            "password" => "admin_na",
//            "nonce" =>  $nonce->nonce,
//            "content"  => array(
//                "post_type"    => "post",
//                "post_status"  => "draft",
//                "post_title"   => "TEST title",
//                "post_author"  => "1",
//                "post_content" => "<h1>POST CONTENT</h1>",
//                "post_date"    => date("Y-m-d H:i:s")
//            )
//        );
        $params = array(
            "nonce"   => $nonce->nonce,
            "status"  => "draft",
            "title"   => "TEST title",
            "content" => "<h1>POST CONTENT</h1>",
            "author"  => "admin",
            "cookie"  => $this->getAuthCookie()
        );
        echo "<pre>";
        print_r($this->makeRequest($this->wpUrl . "posts/create_post/", $params));
    }

    public function getNonce($controller, $method)
    {
        $params = array(
            "controller" => $controller,
            "method"     => $method,
            "callback"   => "?"
        );
        return $this->makeRequest($this->wpUrl . "core/get_nonce/", $params);
    }

    public function getAuthCookie()
    {
        $nonce  = $this->getNonce("auth", "generate_auth_cookie");
        $params = array(
            "nonce"    => $nonce->nonce,
            "username" => "admin",
            "password" => "admin_na"
        );

        $result = $this->makeRequest($this->wpUrl . "auth/generate_auth_cookie/", $params);
        return $result->cookie;

    }
} 