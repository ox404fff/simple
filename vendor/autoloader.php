<?php

/**
 * autoloader
 */
spl_autoload_register(function($class) {
    if (class_exists($class)) {
        return;
    }

    $classPath = BASE_PATH.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (!file_exists($classPath)) {
        throw new \Exception('Class '.$classPath.' is not found');
    }

    require BASE_PATH.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
});