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
    }


} 