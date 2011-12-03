<?php

if (function_exists('spl_autoload_register')) {

    function __HtmlSlicerDisplayAutoload($classname)
    {
        autoloadLogic($classname);
    }

    spl_autoload_register('__HtmlSlicerDisplayAutoload');
} elseif (!function_exists('__Autoload')) {

    function __Autoload($classname)
    {
        autoloadLogic($classname);

    }

} else {
    throw new Exception('Framework is failing to register __autoload() method');
}

function autoloadLogic($classname)
{
    $file = getClassPath($classname) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }

}

function getClassPath($classname) {
    $classname = str_replace('_', SEP, $classname);
    $classname = str_replace('-', '', $classname);
    return UW_PATH . SEP . $classname;

}