<?php

namespace vendor;

use vendor\components\DBConnection;
use vendor\components\UrlManager;

/**
 * Class Application
 *
 * @property UrlManager $urlManager
 * @property DBConnection $db
 * @property BaseController $controller
 *
 * @package vendor
 */
class Application
{

    /**
     * singleton instance
     *
     * @var static
     */
    private static $_instance;


    /**
     * Application config
     *
     * @var array
     */
    private $_config = [
        'components' => []
    ];


    /**
     * Array of instances of classes components
     *
     * @var BaseComponent[]
     */
    private $_components = [];


    /**
     * Singleton
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            static::$_instance = new self();
        }

        return static::$_instance;
    }


    /**
     * Running application
     *
     * @param array $config
     * @throws \Exception
     */
    public function run($config)
    {
        $this->_config = array_merge($this->_config, $config);

        $this->initComponents($this->_config['components']);

        $urlManager = $this->getUrlManager();

        $this->initController($urlManager);

    }


    /**
     * Get url manager
     *
     * @return UrlManager
     */
    public function getUrlManager()
    {
        return $this->urlManager;
    }


    /**
     * Initialise controller by request
     *
     * @throws HttpException
     *
     * @param UrlManager $urlManager
     */
    protected function initController($urlManager)
    {

        list($controller, $action) = $urlManager->getRoute();

        try {
            $this->attachComponent(
                'controller',
                'controllers\\' . ucfirst($controller) . 'Controller', [
                    'action' => 'action'.ucfirst($action),
                    'id'     => $controller
                ]
            );
        } catch (BaseException $e) {
            throw new HttpException(404, $e->getMessage());
        }

    }


    /**
     * Initialise components
     *
     * @param $components
     * @return bool
     * @throws BaseException
     * @throws \Exception
     */
    protected function initComponents($components)
    {

        foreach ($components as $name => $component) {
            if (!isset($component['class'])) {
                throw new \Exception('Class must be defined');
            }

            $class = $component['class'];
            unset($component['class']);

            $this->attachComponent($name, $class, $component);

        }

        return true;
    }


    /**
     * Attach component
     *
     * @param string $name
     * @param string $class
     * @param array $config
     *
     * @return bool
     * @throws \Exception
     */
    protected function attachComponent($name, $class, $config = [])
    {
        if (isset($this->_components[$name])) {
            return false;
        }

        $this->_components[$name] = new $class();

        if (!($this->_components[$name] instanceof BaseComponent)) {
            throw new BaseException('Component must be extended from BaseComponent class');
        }

        foreach ($config as $attribute => $value) {

            if (!property_exists($this->_components[$name], $attribute)) {
                throw new BaseException('Property "'.$attribute.'" is not exists in component "'.$name.'"');
            }
            $this->_components[$name]->{$attribute} = $value;

        }

        $this->_components[$name]->init();

        return true;

    }


    /**
     * Magic getter for getting the component instances
     *
     * @param $name
     * @return null|BaseComponent
     */
    public function __get($name)
    {
        if (isset($this->_components[$name])) {
            return $this->_components[$name];
        }

        return null;
    }


    /**
     * Singleton
     */
    private function __clone() {}
    private function __construct() {}

} 