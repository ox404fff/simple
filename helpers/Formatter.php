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

    /**
     * Return date string from timestamp
     *
     * @param $timestamp
     * @return bool|string
     */
    public function dateInTime($timestamp)
    {
        return date('Y-m-d в H:i', $timestamp);
    }


    /**
     * Replace html entities
     *
     * @param $value
     * @param bool $recursive
     * @return array|string
     */
    public function escapeHtml($value, $recursive = true)
    {
        if ($recursive && is_array($value)) {
            return array_map([$this, 'escapeHtml'], $value);
        } else {
            return htmlentities($value);
        }
    }

} 