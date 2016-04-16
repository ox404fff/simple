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
     */
    public function init()
    {

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