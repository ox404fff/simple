<?php

namespace controllers;

use vendor\BaseController;

class DefaultController extends BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

} 