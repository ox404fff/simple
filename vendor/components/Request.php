<?php

namespace vendor\components;

use vendor\BaseComponent;

/**
 * Request
 *
 * Class Request
 * @package vendor\components
 */
class Request extends BaseComponent
{


    /**
     * Return value from post
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return array_key_exists($key, $_POST) ? $_POST[$key] : $default;
    }


    /**
     * Return value from get
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }

} 