<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 26.03.14
 * Time: 14:32
 */
class Wordpress extends CApplicationComponent
{
    private $url = '';
    private $login = '';
    private $password = '';

    public function __construct()
    {
        $this->url      = Yii::app()->params['wp']['url'];
        $this->login    = Yii::app()->params['wp']['login'];
        $this->password = Yii::app()->params['wp']['password'];
    }

    protected function makeRequest($url, $params = array(), $post = false)
    {
        if ($url && !empty($params)) {
            $result  = '';
//            $request = http_build_query($params);
            if ($post) {
                $result = PageLoader::load($url, $params);
            } else {
                $request = http_build_query($params);

                $result = PageLoader::load($url . "?" . $request);
            }
            if ("?" == substr($result, 0, 1)) {
                $result = preg_replace('/.+?({.+}).+/', '$1', $result);
            }
            return json_decode($result);
        } else {
            return false;
        }
    }

    public function createPost($title, $content, $source, $status = "draft", $attachment = false)
    {
        $nonce = $this->getNonce("posts", "create_post");

        $params = array(
            "nonce"   => $nonce->nonce,
            "status" => $status,
            "title"   => $title,
            "content" => $content,
            "author"  => "admin",
            "cookie" => $this->getAuthCookie(),
            "custom[source]" => $source,
        );
        if ($attachment) {
            echo "\n ATT \n";
            $params["attachment"] = "@{$attachment}";
            echo $params["attachment"] . "\n";
        }
        $result = $this->makeRequest($this->url . "posts/create_post/", $params, true);
//        $result = $this->makeRequest("http://na.loc/uploadCheck.php", $params, true);
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
        return $this->makeRequest($this->url . "core/get_nonce/", $params);
    }

    protected function getAuthCookie()
    {
        $nonce  = $this->getNonce("auth", "generate_auth_cookie");
        $params = array(
            "nonce"    => $nonce->nonce,
            "username" => $this->login,
            "password" => $this->password
        );

        $result = $this->makeRequest($this->url . "auth/generate_auth_cookie/", $params);
        return $result->cookie;

    }
} 