<?php

namespace vendor;

/**
 * Base http exception class
 *
 * Class BaseException
 * @package vendor
 */
class BaseHttpException extends BaseException
{

    public function __construct($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }

} 