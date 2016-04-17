<?php

namespace helpers;

use vendor\BaseComponent;

/**
 * Format output component
 *
 * Class Formatter
 * @package helper
 */
class Formatter extends BaseComponent
{

    public function dateInTime($timestamp)
    {
        return date('Y-m-d в H:i', $timestamp);
    }

} 