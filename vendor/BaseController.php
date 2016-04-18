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
        $content = $this->getContent($view, $data);

        $this->layoutView->setData([
            'content'  => $content,
            'title'    => $this->title,
        ]);

        echo $this->layoutView->getHtml();
    }


    /**
     * Return rendered view
     *
     * @param $view
     * @param array $data
     *
     * @return string
     */
    public function getContent($view, $data = [])
    {
        $templatePath = $this->getTemplatePath($view);
        $this->contentView->setTemplate($templatePath);
        $this->contentView->setData($data);
        return $this->contentView->getHtml();
    }


    /**
     * Return json success fot ajax request
     *
     * @param array $data
     * @return bool
     */
    public function ajaxSuccess($data = [])
    {
        return $this->_renderJson([
            'status' => 1,
            'data'   => $data,
        ]);
    }


    /**
     * Return json error fot ajax request
     *
     * @param string $message
     * @param array $data
     * @return bool
     */
    public function ajaxError($message, $data = [])
    {
        return $this->_renderJson([
            'status' => 0,
            'error'  => $message,
            'data'   => $data,
        ]);
    }


    /**
     * Render json content
     *
     * @param $data
     * @return bool
     */
    private function _renderJson($data)
    {
        header('content-type:application/json');
        echo json_encode($data);
        return true;
    }


    /**
     * Return value from post
     *
     * @param $key
     *
     * @return mixed
     */
    public function post($key)
    {
        return Application::getInstance()->request->post($key);
    }


    /**
     * Return value from get
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return Application::getInstance()->request->get($key);
    }


    /**
     * Getting full path to template
     *
     * @param $viewFile
     * @return string
     */
    protected function getTemplatePath($viewFile)
    {
        return implode(DIRECTORY_SEPARATOR, [BASE_PATH, 'views', $this->id, $viewFile.'.php']);
    }


    /**
     * Getting full path to layout file
     *
     * @param $layoutFile
     * @return string
     */
    protected function getLayoutPath($layoutFile)
    {
        return implode(DIRECTORY_SEPARATOR, [BASE_PATH, 'views', 'layout', $layoutFile.'.php']);
    }

} 