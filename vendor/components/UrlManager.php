<?php

namespace vendor\components;

use vendor\BaseComponent;

/**
 * Default url manager
 *
 * Class BaseModel
 * @package vendor\components
 */
class UrlManager extends BaseComponent
{

    /**
     * Request string
     *
     * @var string|null
     */
    private $_request;


    /**
     * If mod rewrite enable, we can use pretty urls
     *
     * @var bool
     */
    public $prettyUrl = false;


    /**
     * Get parameter with route string
     *
     * @var string
     */
    public $routeKey = 'r';


    /**
     * @var array
     */
    public $defaultRoute = ['default', 'index'];


    /**
     * Initialise url manager
     */
    public function init()
    {
        if ($this->prettyUrl) {
            $this->_request = (isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '');
        } else {
            $this->_request = (isset($_GET[$this->routeKey]) ? trim($_GET[$this->routeKey], '/') : '');
        }

    }


    /**
     * Return controller and action by url
     *
     * @return array ['controllerName', 'actionName']
     */
    public function getRoute()
    {
        if (empty($this->_request)) {
            return $this->defaultRoute;
        }

        $explodeRequest = explode('/', $this->_request);

        return array_slice($explodeRequest, 0, 2) + $this->defaultRoute;

    }

} 