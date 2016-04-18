<?php

namespace controllers;

use models\Comments;
use vendor\BaseController;

class CommentsController extends BaseController
{
    /**
     * Limit comments in page
     *
     * @var int
     */
    protected $_limit = 20;


    /**
     * @var array create comment errors
     */
    protected $errors = [];


    public function actionIndex()
    {
        $commentsList = Comments::getRootLevelComments(null, $this->_limit);

        return $this->render('index', [
            'commentsList'            => array_values($commentsList),
            'count'                   => count($commentsList),
            'limit'                   => $this->_limit,
            'isShowEmptyBlock'        => true,
            'createCommentElementIds' => $this->createCommentElementIds,
        ]);
    }


    public function actionMore()
    {
        $fromId = (int) $this->get('from-id');

        $commentsList = Comments::getRootLevelComments($fromId, $this->_limit);

        $listHtml = $this->getContent('listRoot', [
            'commentsList' => $commentsList,
            'limit'        => $this->_limit,
            'count'        => count($commentsList),
        ]);

        return $this->ajaxSuccess([
            'html' => $listHtml
        ]);
    }


    public function actionChilds()
    {
        $rootId = (int) $this->get('root-id');

        $commentsList = Comments::getChildComments($rootId);

        $listHtml = $this->getContent('list', [
            'commentsList' => $commentsList,
            'limit'        => $this->_limit,
            'count'        => count($commentsList),
        ]);

        return $this->ajaxSuccess([
            'html' => $listHtml
        ]);
    }


    public function actionCreate()
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

                $htmlComment = $this->getContent(empty($parentId) ? 'itemRoot' : 'item', [
                    'comment' => $newComment,
                    'style' => 'panel-info'
                ]);
                $data = [];
            }

            $htmlForm = $this->getContent('create', array_merge(
                $this->createCommentElementIds, [
                    'action' => '/comments/create',
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


    public function actionUpdate()
    {
        return $this->ajaxSuccess();
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


    /**
     * Config with creation form input selectors
     *
     * @var array
     */
    public $createCommentElementIds = [
        'createCommentPopup'  => 'js-create-comment-popup',
        'parentCommentInput'  => 'js-parent-comment-input',
        'currentCommentInput' => 'js-current-comment-input',
    ];


} 