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
     * View instance
     *
     * @var View
     */
    protected $view;


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

        $this->view = new View();

        call_user_func([$this, $this->action]);

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

        $this->view->setTemplate($templatePath);

        $this->view->setData($data);

        echo $this->view->getHtml();
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
} 