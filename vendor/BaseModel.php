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
     * Save model
     */
    public function save()
    {

    }


    /**
     * Select data from database
     *
     * @param $query
     * @param array $bind
     */
    public static function select($query, $bind = [])
    {

    }


    /**
     * Execute database changes
     *
     * @param $query
     * @param array $bind
     */
    public static function execute($query, $bind = [])
    {

    }


    /**
     * @return components\DBConnection
     */
    public static function getConnection()
    {
        return Application::getInstance()->db;
    }

} 