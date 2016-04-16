<?php

namespace components;

use vendor\BaseComponent;

/**
 * Connection to database component
 *
 * Class BaseModel
 * @package vendor
 */
class DBConnection extends BaseComponent
{

    public $dsn;

    public $username;

    public $password;

    public $charset;

} 