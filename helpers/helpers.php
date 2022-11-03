<?php

if (!function_exists('is_match_url')) {
    function is_match_url($url = '')
    {
        $server_uri = $_SERVER[ 'REQUEST_URI' ];
        if (is_array($url)) {
            $is_confirm = false;
            foreach($url as $item) {
               if (strpos($server_uri, $item) !== false) {
                    $is_confirm = true;
               }
            }
            return $is_confirm;
        }
        return false !== strpos($server_uri, $url );
    }
}

if (!function_exists('generate_random_string')) {
    function generate_random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}