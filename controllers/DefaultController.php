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

    /**
     * @var array create comment errors
     */
    protected $errors = [];


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

        $parentId = (int) $this->post('parent-comment-id');
        $title    = trim($this->post('comment-title'));
        $message  = trim($this->post('comment-text'));

        $data = [
            'comment-title' => $title,
            'comment-text'  => $message
        ];

        try {
            $htmlComment = '';
            $isValid = $this->validate($data);
            if ($isValid) {
                $newComment = Comments::appendNewComment($parentId, $title, $message);
                $htmlComment = $this->getContent(empty($parentId) ? 'commentItemRoot' : 'commentItem', [
                    'comment' => $newComment,
                    'style' => 'panel-info'
                ]);
                $data = [];
            }

            $htmlForm = $this->getContent('createComment', array_merge(
                $this->createCommentElementIds, [
                    'action' => '/default/createComment',
                    'errors' => $this->getErrors(),
                    'values' => $data
                ]
            ));

            return $this->ajaxSuccess([
                'html' => [
                    'comment' => $htmlComment,
                    'form'    => $htmlForm,
                ],
                'created'     => (int) $isValid,
                'message'     => 'Comment successfully created!'
            ]);

        } catch (\Exception $e) {
            return $this->ajaxError($e->getMessage());
        }

    }


    /**
     * @param array $data
     * @return bool
     */
    protected function validate($data)
    {
        $this->errors = [];

        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->errors[$key] = 'Can not be empty!';
            }
        }

        if (mb_strlen($data['comment-title']) < 2) {
            $this->errors['comment-title'] = 'Minimum 2 characters';
        }

        if (mb_strlen($data['comment-title']) > 200) {
            $this->errors['comment-title'] = 'Maximum 200 characters';
        }

        if (mb_strlen($data['comment-text']) < 2) {
            $this->errors['comment-text'] = 'Minimum 2 characters';
        }

        if (mb_strlen($data['comment-text']) > 2000) {
            $this->errors['comment-text'] = 'Minimum 2000 characters';
        }

        return empty($this->errors);
    }


    /**
     * Get errors after validate
     *
     * @return array
     */
    protected function getErrors()
    {
        return $this->errors;
    }


    public function actionUpdateComment()
    {
        return $this->ajaxSuccess();
    }

} 