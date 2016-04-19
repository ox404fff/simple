<?php

namespace vendor;

/**
 * View class
 *
 * Class View
 * @package vendor
 */
class View extends BaseComponent
{

    /**
     * Full path to template
     *
     * @var string
     */
    public $templatePath = '';


    /**
     * Data extracted to template
     *
     * @var array
     */
    public $data = [];


    /**
     * Setting rendering template path
     *
     * @param $templatePath
     * @throws \Exception
     */
    public function setTemplate($templatePath)
    {
        if (!file_exists($templatePath)) {
            throw new \Exception('View file "'.$templatePath.'" is not exists');
        }

        $this->templatePath = $templatePath;
    }


    /**
     * Setting data for extract into template
     *
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = (array) $data;
    }


    /**
     * Get data with escape html
     *
     * @param bool $raw
     * @return array|string
     */
    public function getData($raw = false)
    {
        if ($raw) {
            return $this->data;
        } else {
            return $this->escape($this->data);
        }
    }


    /**
     * Get value in view model
     *
     * @param $var
     * @param bool $raw
     *
     * @return mixed
     */
    public function getVar($var, $raw = false)
    {
        if (!isset($this->data[$var])) {
            return null;
        }

        return $raw ? $this->data[$var] : $this->escape($this->data[$var]);
    }


    /**
     * Get rendered view html string
     *
     * @return string
     */
    public function getHtml($raw = true)
    {
        extract($this->getData($raw));

        ob_start();

        require ($this->templatePath);

        $html = ob_get_clean();

        return $html;
    }


    /**
     * Render partial
     *
     * @param $view
     * @param $data
     * @throws \Exception
     */
    public function render($view, $data = [], $raw = true)
    {

        $templatePath = implode(DIRECTORY_SEPARATOR, [$this->getViewDirectory(), $view.'.php']);

        $partialView = new View();

        $partialView->setTemplate($templatePath);

        $partialView->setData($data);

        echo $partialView->getHtml($raw);
    }


    /**
     * Get current view directory path
     *
     * @return string
     */
    public function getViewDirectory()
    {
        return dirname($this->templatePath);
    }


    /**
     * Getting assert manager component
     *
     * @return components\AssetsManager
     */
    public function getAssertManager()
    {
        return Application::getInstance()->assetsManager;
    }


    /**
     * Getting component for format output
     *
     * @return \helpers\Formatter
     */
    public function getFormatter()
    {
       return Application::getInstance()->formatter;
    }


    /**
     * Replace html entities
     *
     * @param $value
     * @param bool $recursive
     * @return array|string
     */
    public function escape($value, $recursive = true)
    {
        return $this->getFormatter()->escapeHtml($value, $recursive);
    }

}