<?php

namespace controllers;

use models\Comments;
use vendor\Application;
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

        $parentId = $this->post('parent-comment-id');
        $title    = $this->post('comment-title');
        $message  = $this->post('comment-text');

        try {
            $newComment = Comments::appendNewComment($parentId, $title, $message);

            $html = $this->getContent(empty($parentId) ? 'commentsItemRoot' : 'commentsItem', [
                'comment' => $newComment,
                'style'   => 'panel-primary'
            ]);

            return $this->ajaxSuccess([
                'html' => [
                    'comment' => $html,
                    'form'    => $html,
                ],
                'message'     => 'Comment successfully created!'
            ]);

        } catch (\Exception $e) {
            return $this->ajaxError($e->getMessage());
        }

    }


    public function actionUpdateComment()
    {
        return $this->ajaxSuccess();
    }

} 