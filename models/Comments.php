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
            sprintf('SELECT * '.
                'FROM `%s` as t WHERE t.id = :id AND is_deleted = 0%s', self::$tableName, $lock ? ' FOR UPDATE' : ''
            ), [
                ':id' => $id
            ]
        );
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
            sprintf('SELECT * '.
                'FROM %s as t '.
                'WHERE '.implode(' AND ', $wheres).' '.
                'ORDER BY t.id DESC '.
                'LIMIT %d', self::$tableName, (int) $limit
            ), $binds
        );
    }


    /**
     * Return all child nodes
     *
     * @param $parentId
     * @return array
     * @throws \Exception
     */
    public static function getChildComments($parentId)
    {
        $parent = self::findById($parentId);

        if (empty($parent)) {
            throw new \Exception('Parent node is not found');
        }

        $wheres = ['t.id_left > :id_left', 't.id_right < :id_right', 't.is_deleted = 0'];
        $binds = [
            ':id_right' => $parent['id_right'],
            ':id_left' => $parent['id_left'],
        ];

        return self::queryAll(
            sprintf('SELECT * '.'FROM `%s` as t WHERE '.implode(' AND ', $wheres).' ORDER BY t.id_left ASC',
                self::$tableName
            ), $binds
        );

    }


    /**
     * Getting count comments in subtree
     *
     * @param $idLeft
     * @param $idRight
     *
     * @return integer
     */
    public static function getCountChildComments($idLeft, $idRight)
    {
        $wheres = ['t.id_left > :id_left', 't.id_right < :id_right', 't.is_deleted = 0'];
        $binds = [
            ':id_right' => $idRight,
            ':id_left'  => $idLeft,
        ];

        return self::query(
            sprintf('SELECT COUNT(*) as count '.'FROM `%s` as t WHERE '.implode(' AND ', $wheres),
                self::$tableName
            ), $binds
        )['count'];

    }


    /**
     * Find root node, by any node id
     *
     * @param $nodeId
     * @return array
     * @throws \Exception
     */
    public static function getRoot($nodeId)
    {

        $node = self::findById($nodeId);

        if (empty($node)) {
            throw new \Exception('Parent node is not found');
        }

        if ($node['level'] == 0) {
            return $node;
        }

        return self::query(
            sprintf('SELECT * '.'FROM `%s` as t WHERE t.id_left <= :id_left AND t.id_right >= :id_right AND level = 0 AND is_deleted = 0 LIMIT 1',
                self::$tableName
            ), [
                ':id_left'  => $node['id_left'],
                ':id_right' => $node['id_right'],
            ]
        );
    }


    /**
     * Delete tree
     *
     * @param $idLeft
     * @param $idRight
     *
     * @throws \Exception
     * @return bool
     */
    public static function delete($idLeft, $idRight)
    {

        self::beginTransaction();

        try {

            $result = self::exec(sprintf(
                'DELETE '.'FROM `%s` '.'WHERE id_left >= :id_left AND id_right <= :id_right', self::$tableName
                ), [
                    ':id_left'  => $idLeft,
                    ':id_right' => $idRight
                ]
            );

            if (!$result) {
                throw new \Exception('Cannot delete comment from database!');
            }

            $result = self::exec(sprintf(
                'UPDATE `%s` as t '.
                'SET t.id_right = t.id_right - (:id_right - :id_left + 1) '.
                'WHERE t.id_right > :id_right AND :id_left < :id_left', self::$tableName), [
                    ':id_left'  => $idLeft,
                    ':id_right' => $idRight
                ]
            );

            if (!$result) {
                throw new \Exception('Cannot delete comment from database!');
            }

            $result = self::exec(sprintf(
                    'UPDATE `%s` as t '.
                    'SET t.id_left = t.id_left - (:id_right - :id_left + 1), t.id_right = t.id_right - (:id_right - :id_left + 1) '.
                    'WHERE t.id_left > :id_right', self::$tableName), [
                    ':id_left'  => $idLeft,
                    ':id_right' => $idRight
                ]
            );

            if (!$result) {
                throw new \Exception('Cannot delete comment from database!');
            }

            self::commit();

        } catch (\Exception $e) {

            self::rollback();

            throw $e;
        }

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
        self::beginTransaction();

        try {
            if ($parentId != self::ID_ROOT) {

                $parentComment = self::findById($parentId, true);
                if (empty($parentComment)) {
                    throw new \Exception('Parent comment with id = '.$parentId.' is not exists');
                }

                $parentRightKey = $parentComment['id_right'];
                $newCommentLevel = $parentComment['level'] + 1;

                self::_updateBeforeNodes($parentRightKey);
                self::_updateParentTree($parentRightKey);

            } else {
                $parentRightKey = (int) self::_getMaxRootId()['id_right'] + 1;
                $newCommentLevel = 0;
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
     * Update data in comment
     *
     * @param $id
     * @param $name
     * @param $commentText
     *
     * @return bool
     */
    public static function update($id, $name, $commentText)
    {
        return self::exec(sprintf(
                'UPDATE `%s` as t '.
                'SET t.name = :name, t.message = :message '.
                'WHERE t.id = :id AND t.is_deleted = 0', self::$tableName), [
                    ':id'      => $id,
                    ':name'    => $name,
                    ':message' => $commentText,
            ]
        );
    }


    /**
     * Update count child`s in comment
     *
     * @param $id
     * @param $count
     *
     * @return bool
     */
    public static function updateCount($id, $count)
    {
        return self::exec(sprintf(
            'UPDATE `%s` as t '.
            'SET t.count_children = :new_count '.
            'WHERE t.id = :id', self::$tableName), [
                ':id'        => $id,
                ':new_count' => $count,
            ]
        );
    }


    /**
     * Update right and left ids for child nodes
     *
     * @param $parentRightKey
     */
    private static function _updateBeforeNodes($parentRightKey)
    {
        self::exec(sprintf(
                'UPDATE `%s` as t '.
                'SET t.id_left = t.id_left + 2, t.id_right = t.id_right + 2 '.
                'WHERE t.id_left > :id_right AND t.is_deleted = 0', self::$tableName), [
                ':id_right' => $parentRightKey,
            ]
        );
    }


    /**
     * Update right id and child counts for parent tree
     *
     * @param $parentRightKey
     */
    private static function _updateParentTree($parentRightKey)
    {
        self::exec(sprintf(
                'UPDATE `%s` as t '.
                'SET t.id_right = t.id_right + 2, t.count_children = t.count_children + 1 '.
                'WHERE t.id_right >= :id_right AND t.id_left < :id_right AND t.is_deleted = 0', self::$tableName), [
                ':id_right' => $parentRightKey,
            ]
        );
    }


    /**
     * Return max right id, for create root nodes
     *
     * @return array
     */
    private static function _getMaxRootId()
    {
        return self::query(sprintf('SELECT '.'MAX(t.id_right) as id_right from %s as t WHERE t.is_deleted = 0', self::$tableName));
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
    private static function _insertNewComment($parentRightKey, $newCommentLevel, $name, $commentText)
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


}