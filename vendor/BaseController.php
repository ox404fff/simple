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
     * @var string
     */
    public $action;


    /**
     * Initialise and run controller
     *
     * @throws BaseException
     */
    public function init()
    {
        if (method_exists($this, $this->action)) {
            call_user_func([$this, $this->action]);
        } else {
            throw new BaseException('Action "'.$this->action.'" is not found');
        }
    }


    /**
     * Render view file
     *
     * @param $view
     * @return bool
     */
    public function render($view)
    {
        return true;
    }

} 