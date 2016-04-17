<?php

namespace vendor\components;

use vendor\BaseComponent;

/**
 * Default connection to database component
 *
 * Class DBConnection
 * @package vendor\components
 */
class DBConnection extends BaseComponent
{

    /**
     * @var string
     */
    public $dsn;


    /**
     * @var string
     */
    public $username;


    /**
     * @var string
     */
    public $password;


    /**
     * @var string
     */
    public $charset;


    /**
     * @var \PDO
     */
    private $_handler;


    /**
     * Error reporting (Production - \PDO::ERRMODE_SILENT, Development - \PDO::ERRMODE_EXCEPTION)
     *
     * @var int
     */
    public $errorMode = \PDO::ERRMODE_SILENT;


    /**
     * Connect to database
     *
     * @throws \PDOException
     */
    public function init()
    {
        $this->_handler = new \PDO(
            $this->dsn.';'.$this->charset,
            $this->username, $this->password
        );

        $this->_handler->setAttribute(\PDO::ATTR_ERRMODE, $this->errorMode);
    }


    /**
     * Execute command
     *
     * @param $query
     * @param array $bind
     * @return bool
     */
    public function exec($query, $bind = [])
    {
        $query = $this->_handler->prepare($query);
        return $query->execute($bind);
    }


    /**
     * Select one record
     *
     * @param $query
     * @param array $bind
     * @return mixed
     */
    public function query($query, $bind = [])
    {
        $query = $this->_handler->prepare($query, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $query->execute($bind);
        return $query->fetch();
    }


    /**
     * Select collection records
     *
     * @param $query
     * @param array $bind
     * @return array
     */
    public function queryAll($query, $bind = [])
    {
        $query = $this->_handler->prepare($query, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $query->execute($bind);
        return $query->fetchAll();
    }


    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        $this->_handler->beginTransaction();
    }


    /**
     * Apply changes in transaction
     */
    public function commit()
    {
        $this->_handler->commit();
    }


    /**
     * Rollback changes in transaction
     */
    public function rollback()
    {
        $this->_handler->rollBack();
    }
} 