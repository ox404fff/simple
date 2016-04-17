<?php

namespace vendor;

/**
 * Base model class
 *
 * Class BaseModel
 * @package vendor
 */
abstract class BaseModel extends BaseComponent
{

    /**
     * Set table name for auto queries
     *
     * @var string
     */
    protected static $tableName;


    /**
     * Select record from database
     *
     * @param $query
     * @param array $bind
     * @return array
     */
    public static function query($query, $bind = [])
    {
        return self::getConnection()->query($query, $bind);
    }


    /**
     * Select data from database
     *
     * @param $query
     * @param array $bind
     * @return array
     */
    public static function queryAll($query, $bind = [])
    {
        return self::getConnection()->queryAll($query, $bind);
    }


    /**
     * Execute database changes
     *
     * @param $query
     * @param array $bind
     * @return bool
     */
    public static function exec($query, $bind = [])
    {
        return self::getConnection()->exec($query, $bind);
    }


    /**
     * Insert a new record
     *
     * @param $data
     * @return bool
     */
    public static function insert($data)
    {
        $bind = [];
        foreach ($data as $column => $value) {
            $bind[':'.$column] = $value;
        }

        return self::exec('INSERT INTO `'.static::$tableName.'`('.implode(', ', array_keys($data)).') VALUES('.implode(', ', array_keys($bind)).')', $bind);
    }


    /**
     * Get database connection object
     *
     * @return components\DBConnection
     */
    public static function getConnection()
    {
        return Application::getInstance()->db;
    }

} 