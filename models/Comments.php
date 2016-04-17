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
     * Find all comments
     *
     * @return array
     */
    public static function findAll()
    {
        return self::queryAll('SELECT * FROM `'.self::$tableName.'` as t WHERE t.id > :id', [':id' => 5]);
    }


    /**
     * Find one comments
     *
     * @return array
     */
    public static function find()
    {
        return self::query('SELECT * FROM `'.self::$tableName.'` as t WHERE t.id = :id', [':id' => 6]);
    }



    /**
     * Create a new comment
     *
     * @param int $parentId
     * @param string $commentText
     * @param bool $prepend
     * @return bool
     */
    public static function createNewComment($parentId, $commentText, $prepend = false)
    {

        return self::insert([
            'message'    => $commentText,
            'created_at' => time(),
            'updated_at' => time()
        ]);

    }

}