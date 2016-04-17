<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class DefaultController extends BaseController
{

    public function actionIndex()
    {
        Comments::createNewComment(Comments::ID_ROOT, 'test');

        return $this->render('index', [
        ]);
    }

} 