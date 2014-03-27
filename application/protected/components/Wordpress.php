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

    public function createPost($title, $content)
    {
        $nonce = $this->getNonce("posts", "create_post");

        $params = array(
            "nonce"   => $nonce->nonce,
            "status"  => "draft",
            "title"   => $title,
            "content" => $content,
            "author"  => "admin",
            "cookie"  => $this->getAuthCookie()
        );
        $result = $this->makeRequest($this->wpUrl . "posts/create_post/", $params);
        if ("ok" == $result->status) {
            return true;
        } else {
            return false;
        }
    }

    protected function getNonce($controller, $method)
    {
        $params = array(
            "controller" => $controller,
            "method"     => $method,
            "callback"   => "?"
        );
        return $this->makeRequest($this->wpUrl . "core/get_nonce/", $params);
    }

    protected function getAuthCookie()
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