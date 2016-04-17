<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class DefaultController extends BaseController
{

    public function actionIndex()
    {

        $limit = 50;

        $commentsList = Comments::getRootLevelComments(null, $limit);

        return $this->render('commentsList', [
            'commentsList'     => array_values($commentsList),
            'count'            => count($commentsList),
            'limit'            => $limit,
            'isShowEmptyBlock' => true,
        ]);
    }


    public function actionShowMoreComments()
    {

    }


    public function actionCreateComment()
    {
        $newComment = Comments::appendNewComment(Comments::ID_ROOT, 'test', 'message');

        return $this->ajaxSuccess();
    }


    public function actionUpdateComment()
    {
        return $this->ajaxSuccess();
    }

} 