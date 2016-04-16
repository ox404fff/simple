<?php

namespace vendor;

/**
 * Class Application
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
     * Application config array
     *
     * @var
     */
    private $_config = [];


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
     * @param $config
     * @throws \Exception
     */
    public function run($config)
    {
        $this->_config = $config;

        $this->initComponents();
    }


    /**
     * Initialise components
     *
     * @return bool
     * @throws BaseException
     * @throws \Exception
     */
    protected function initComponents()
    {

        if (!isset($this->_config['components'])) {
            return false;
        }

        foreach ($this->_config['components'] as $name => $component) {
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
     * @param $name
     * @param $class
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

            $this->_components[$name]->init();
        }

        return true;

    }


    private function __clone() {}
    private function __construct() {}

} 