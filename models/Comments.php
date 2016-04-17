<?php

namespace models;

use vendor\BaseModel;

/**
 * Model with comments
 *
 * Class Comments
 * @package models
 */
class Comments extends BaseModel
{

    /**
     * Root comment id
     */
    const ID_ROOT = 0;


    /**
     * Table with comments
     *
     * @var string
     */
    protected static $tableName = 'comments';


    /**
     * Gec comment by id
     *
     * @param $id
     * @param $lock - set true if used in transaction!
     * @return array
     */
    public static function findById($id, $lock = false)
    {
        return self::query(
            sprintf('SELECT * FROM `%s` as t WHERE t.id = :id AND is_deleted = 0%s',
                self::$tableName,
                $lock ? ' FOR UPDATE' : ''
            ), [
                ':id' => $id
            ]
        );
    }


    /**
     * Append comment in comments tree
     *
     * @param $parentId
     * @param $name - comment name|title
     * @param $commentText
     *
     * @return array
     * @throws \Exception
     */
    public static function appendNewComment($parentId, $name, $commentText)
    {
        $newCommentLevel = 0;
        $parentRightKey = self::ID_ROOT;

        self::beginTransaction();

        try {
            if ($parentId != self::ID_ROOT) {
                list($parentRightKey, $newCommentLevel) = self::_updateTreeForAppendNewComment($parentId);
            }

            $newComment = self::_insertNewComment($parentRightKey, $newCommentLevel, $name, $commentText);

            self::commit();

        } catch(\Exception $e) {

            self::rollback();

            throw $e;
        }

        return $newComment;
    }


    /**
     * Finding all root level comments
     *
     * @param null $toId
     * @param int $limit
     * @return array
     */
    public static function getRootLevelComments($toId = null, $limit = 50)
    {
        $wheres = ['t.level = 0', 't.is_deleted = 0'];
        $binds = [];

        if (!is_null($toId)){
            $wheres[] = 't.id < :to_id';
            $binds[':to_id'] = $toId;
        }

        return self::queryAll(
            'SELECT * FROM comments as t '.
            'WHERE '.implode(' AND ', $wheres).' '.
            'ORDER BY t.id DESC '.
            'LIMIT '.((int) $limit), $binds
        );
    }


    /**
     * Create new comment and return his
     *
     * @param $parentRightKey
     * @param $newCommentLevel
     * @param $name - comment name|title
     * @param $commentText
     *
     * @throws \Exception
     * @return array
     */
    public static function _insertNewComment($parentRightKey, $newCommentLevel, $name, $commentText)
    {
        $newComment = [
            'id_right'       => $parentRightKey + 1,
            'id_left'        => $parentRightKey,
            'level'          => $newCommentLevel,
            'name'           => $name,
            'message'        => $commentText,
            'count_children' => 0,
            'created_at'     => time(),
            'updated_at'     => time(),
            'is_deleted'     => 0,
        ];

        $result = self::insert($newComment);

        if (!$result) {
            throw new \Exception('Comment is not created');
        }

        $newComment['id'] = self::getLastInsertId();

        return $newComment;
    }


    /**
     * Find parent node by parentId and update right and left ids children and parent nodes
     *
     * @param $parentId
     * @return array
     * @throws \Exception
     */
    private static function _updateTreeForAppendNewComment($parentId)
    {

        $parentComment = self::findById($parentId, true);
        if (empty($parentComment)) {
            throw new \Exception('Parent comment with id = '.$parentId.' is not exists');
        }
        $parentRightKey = (int) $parentComment['id_right'];
        $newCommentLevel = (int) $parentComment['level'] + 1;

        self::exec(
            'UPDATE `' . self::$tableName . '` ' .
            'SET id_right = id_right + 2, id_left = IF(id_left > :parent_right_key, id_left + 2, id_left) '.
            'WHERE id_right >= :parent_right_key AND is_deleted = 0', [
                ':parent_right_key' => $parentRightKey
            ]
        );

        return [$parentRightKey, $newCommentLevel, 1];
    }

}