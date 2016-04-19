<?php

namespace controllers;

use models\Comments;
use vendor\Application;
use vendor\BaseController;
use vendor\HttpException;

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
        $parentId = (int) $this->get('parent-id');
        $createdNodeId = (int) $this->get('new-node-id');

        $root = Comments::getRoot($parentId);
        $countNodesInRoot = Comments::getCountChildComments($root['id_left'], $root['id_right']);
        $commentsList = Comments::getChildComments($parentId);

        $commentsList = $this->_createTreeFromArrayByLevels($commentsList);

        $listHtml = $this->getContent('listTree', [
            'commentsList'  => $commentsList,
            'createdNodeId' => $createdNodeId,
        ]);

        return $this->ajaxSuccess([
            'html'             => $listHtml,
            'rootId'           => $root['id'],
            'countNodesInRoot' => $countNodesInRoot,
        ]);
    }


    /**
     * @return bool
     * @throws HttpException
     */
    public function actionUpdate()
    {
        $commentId = (int) $this->post('current-comment-id');

        $comment = Comments::findById($commentId);

        if (empty($comment)) {
            throw new HttpException(404);
        }

        return $this->_form($comment);

    }


    public function actionCreate()
    {
        return $this->_form();
    }


    private function _form($comment = null)
    {
        $parentId = (int) $this->post('parent-comment-id');
        $title    = trim($this->post('comment-title'));
        $message  = trim($this->post('comment-text'));

        $data = [
            'comment-title' => $title,
            'comment-text'  => $message,
        ];

        try {
            $htmlComment = '';
            $createdId = null;

            $isValid = $this->validate($data);
            if ($isValid) {

                if (is_null($comment)) {
                    $comment = Comments::appendNewComment($parentId, $title, $message);
                    $createdId = $comment['id'];
                    $message = 'Comment successfully created!';
                } else {
                    $comment['name'] = $title;
                    $comment['message'] = $message;
                    Comments::update($comment['id'], $comment['name'], $comment['message']);
                    $message = 'Comment successfully updated!';
                }

                $htmlComment = $this->getContent(empty($parentId) ? 'itemRoot' : 'itemTree', [
                    'comment' => $comment,
                    'style'   => 'panel-info'
                ]);
                $data = [];
            }

            $htmlForm = $this->getContent('create', array_merge(
                $this->createCommentElementIds, [
                    'action' => '/comments/create',
                    'errors' => $this->getErrors(),
                    'values' => array_merge([
                            'current-comment-id' => (int) trim($this->post('current-comment-id')),
                            'parent-comment-id' => (int) trim($this->post('parent-comment-id'))],
                        $data
                    )
                ]
            ));

            return $this->ajaxSuccess([
                'html' => [
                    'comment' => $htmlComment,
                    'form'    => $htmlForm,
                ],
                'comment'   => Application::getInstance()->formatter->escapeHtml($comment),
                'createdId' => $createdId,
                'saved'     => (int) $isValid,
                'message'   => $message
            ]);

        } catch (\Exception $e) {
            return $this->ajaxError($e->getMessage());
        }
    }



    public function actionDelete()
    {
        $id = (int) $this->post('id');

        $comment = Comments::findById($id);

        if (empty($comment)) {
            throw new HttpException(404);
        }

        Comments::delete($comment['id_left'], $comment['id_right']);

        $root = Comments::getRoot($id);
        $countNodesInRoot = Comments::getCountChildComments($root['id_left'], $root['id_right']);

        return $this->ajaxSuccess([
            'countNodesInRoot' => $countNodesInRoot,
            'rootId'           => $root['id'],
        ]);
    }


    /**
     * @return bool
     * @throws HttpException
     */
    public function actionGetComment()
    {
        $id = (int) $this->get('id');

        $comment = Comments::findById($id);

        if (empty($comment)) {
            throw new HttpException(404);
        }

        return $this->ajaxSuccess($comment);
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

        if (mb_strlen($data['comment-text']) > 10000) {
            $this->errors['comment-text'] = 'Minimum 10000 characters';
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
     * Create nested array from db result
     *
     * @param $list
     * @param null $level
     * @return array
     */
    private function _createTreeFromArrayByLevels(&$list, &$index = 0, $level = null)
    {
        $result = [];
        if (is_null($level)) {
            $level = current($list)['level'];
        }
        while($node = current($list)) {
            if ($node['level'] == $level) {
                $result[$index] = $node;
                $index ++;
            } elseif ($node['level'] > $level) {
                $result[$index - 1]['items'] = $this->_createTreeFromArrayByLevels($list, $index, $node['level']);;
            } else {
                prev($list);
                break;
            }
            next($list);
        }


        return $result;
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