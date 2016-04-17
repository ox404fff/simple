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
     * Get rendered view html string
     *
     * @return string
     */
    public function getHtml()
    {
        extract($this->getData());

        ob_start();

        require ($this->templatePath);

        $html = ob_get_clean();

        return $html;
    }


    /**
     * Render partial
     */
    public function render($view, $data)
    {

        $templatePath = implode(DIRECTORY_SEPARATOR, [$this->getViewDirectory(), $view.'.php']);

        $partialView = new View();

        $partialView->setTemplate($templatePath);

        $partialView->setData($data);

        echo $partialView->getHtml();
    }


    /**
     * @return string
     */
    public function getViewDirectory()
    {
        return dirname($this->templatePath);
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
        if ($recursive && is_array($value)) {
            return array_map([$this, 'escape'], $value);
        } else {
            return htmlentities($value);
        }
    }

}