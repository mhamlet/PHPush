<?php

// Registering autoload
spl_autoload_extensions(".php");
spl_autoload_register(function($classname) {
    if (class_exists($classname)) return;
    $classname = str_replace(["\\", 'PHPush/'], ['/', ''], $classname);
    require_once $classname . '.php';
});