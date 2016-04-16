<?php

namespace vendor;

/**
 * Base http exception class
 *
 * Class BaseException
 * @package vendor
 */
class HttpException extends BaseException
{

    public function __construct($httpStatusCode, $message = '')
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->message = $message;
    }

} 