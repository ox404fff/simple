<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class DefaultController extends BaseController
{

    /**
     * @var array
     */
    public $createCommentElementIds = [
        'createCommentPopup'  => 'js-create-comment-popup',
        'parentCommentInput'  => 'js-parent-comment-input',
        'currentCommentInput' => 'js-current-comment-input',
    ];

    public function actionIndex()
    {

        $limit = 50;

        $commentsList = Comments::getRootLevelComments(null, $limit);

        return $this->render('index', [
            'commentsList'            => array_values($commentsList),
            'count'                   => count($commentsList),
            'limit'                   => $limit,
            'isShowEmptyBlock'        => true,
            'createCommentElementIds' => $this->createCommentElementIds,
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

            $htmlComment = $this->getContent(empty($parentId) ? 'commentItemRoot' : 'commentItem', [
                'comment' => $newComment,
                'style'   => 'panel-info'
            ]);

            $htmlForm = $this->getContent('createComment', $this->createCommentElementIds);

            return $this->ajaxSuccess([
                'html' => [
                    'comment' => $htmlComment,
                    'form'    => $htmlForm,
                ],
                'created'     => 1,
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