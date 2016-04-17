<?php

namespace vendor\components;

use vendor\BaseComponent;

/**
 * Assets manager
 *
 * Class AssetsManager
 * @package vendor\components
 */
class AssetsManager extends BaseComponent
{
    /**
     * Array with global Javascript files
     *
     * @var array
     */
    public $globalJsFiles = [];


    /**
     * Array with global css files
     *
     * @var array
     */
    public $globalCssFiles = [];


    /**
     * Array with Javascript files
     *
     * @var array
     */
    private $_jsFiles = [];


    /**
     * Array with css files
     *
     * @var array
     */
    private $_cssFiles = [];


    /**
     * Array with Javascript blocks
     *
     * @var array
     */
    private $_js = [];


    /**
     * If flag began javascript block
     *
     * @var bool
     */
    private $_isBeginJs = false;


    /**
     * Position began javascript block
     *
     * @var null
     */
    private $_beginJsPosition = null;


    /**
     * Javascript position in document ready block
     */
    const POS_READY = 1;


    /**
     * Getting all javascript file
     *
     * @return array
     */
    public function getJsFiles()
    {
        return array_merge($this->globalJsFiles, $this->_jsFiles);
    }


    /**
     * Get all css files
     *
     * @return array
     */
    public function getCssFiles()
    {
        return array_merge($this->globalCssFiles, $this->_cssFiles);
    }


    /**
     * Adding Javascript file
     *
     * @param $jsFile
     */
    public function addJsFile($jsFile)
    {
        $this->_jsFiles[] = $jsFile;
    }


    /**
     * Adding css file
     *
     * @param $cssFile
     */
    public function addCssFile($cssFile)
    {
        $this->_cssFiles[] = $cssFile;
    }


    /**
     * Check if exists Javascript block for position
     *
     * @param int $pos
     * @return bool
     */
    public function ifExistsJs($pos = self::POS_READY)
    {
        return isset($this->_js[$pos]);
    }


    /**
     * Getting all javascript blocks by position
     *
     * @param int $pos
     * @return mixed
     */
    public function getJs($pos = self::POS_READY)
    {
        return $this->_js[$pos];
    }


    /**
     * Begin Javascript block
     *
     * @param int $pos
     */
    public function beginJs($pos = self::POS_READY)
    {
        $this->_isBeginJs = true;
        $this->_beginJsPosition = $pos;
        ob_start();
    }


    /**
     * End javascript block
     */
    public function endJs()
    {
        $this->_js[$this->_beginJsPosition][] = ob_get_clean();
        $this->_beginJsPosition = null;
        $this->_isBeginJs = false;
    }

} 