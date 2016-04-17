<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class DefaultController extends BaseController
{

    public function actionIndex()
    {
        Comments::appendNewComment(Comments::ID_ROOT, 'test');

        $commentsList = Comments::getRootLevelComments();

        return $this->render('commentsList', [
            'commentsList' => $commentsList
        ]);
    }

} 