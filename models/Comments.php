<?php
/**
 * Created by PhpStorm.
 * User: ox404fff
 * Date: 14.04.16
 * Time: 21:20
 */

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

    protected static $tableName = 'comments';


    /**
     * Find all comments
     */
    public static function findAll()
    {
        return [];
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

        self::insert([
            'message' => 'test',
        ]);


    }

}