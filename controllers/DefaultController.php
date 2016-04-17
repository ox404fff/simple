<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class DefaultController extends BaseController
{

    public function actionIndex()
    {
        $commentsList = Comments::getRootLevelComments();

        return $this->render('commentsList', [
            'commentsList' => $commentsList
        ]);
    }

} 