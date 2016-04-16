<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class DefaultController extends BaseController
{

    public function actionIndex()
    {
        $comments = Comments::findAll();

        return $this->render('index', [
            'comments' => $comments
        ]);
    }

} 