<?php

namespace vendor;

/**
 * Base controller class
 *
 * Class BaseController
 * @package vendor
 */
abstract class BaseController extends BaseComponent
{

    /**
     * Action name
     *
     * @var string
     */
    public $action;


    /**
     * Controller identity string
     *
     * @var string
     */
    public $id;


    /**
     * Default layout
     *
     * @var string
     */
    public $layout = 'main';


    /**
     * Application title
     *
     * @var string
     */
    public $title = '';


    /**
     * View instance for render content
     *
     * @var View
     */
    protected $contentView;


    /**
     * View for render layout
     *
     * @var View
     */
    protected $layoutView;


    /**
     * Initialise and run controller
     *
     * @throws BaseException
     */
    public function init()
    {
        if (!method_exists($this, $this->action)) {
            throw new BaseException('Action "' . $this->action . '" is not found');
        }

        $this->initLayoutView();

        $this->initContentView();

        call_user_func([$this, $this->action]);

    }


    /**
     * Initialise layout view object
     *
     * @throws \Exception
     */
    protected function initLayoutView()
    {
        $this->layoutView = new View();
        $layoutPath = $this->getLayoutPath($this->layout);
        $this->layoutView->setTemplate($layoutPath);
    }


    /**
     * Initialise content view object
     */
    protected function initContentView()
    {
        $this->contentView = new View();
    }


    /**
     * Render view file
     *
     * @param string $view
     * @param array $data
     *
     * @return bool
     */
    public function render($view, $data = [])
    {
        $templatePath = $this->getTemplatePath($view);
        $this->contentView->setTemplate($templatePath);
        $this->contentView->setData($data);
        $content = $this->contentView->getHtml();

        $this->layoutView->setData([
            'content'  => $content,
            'title'    => $this->title,
        ]);
        echo $this->layoutView->getHtml();
    }


    /**
     * Getting full path to template
     *
     * @param $viewFile
     * @return string
     */
    protected function getTemplatePath($viewFile)
    {
        return BASE_PATH.'/views/'.$this->id.'/'.$viewFile.'.php';
    }


    /**
     * Getting full path to layout file
     *
     * @param $layoutFile
     * @return string
     */
    protected function getLayoutPath($layoutFile)
    {
        return BASE_PATH.'/views/layout/'.$layoutFile.'.php';
    }


} 