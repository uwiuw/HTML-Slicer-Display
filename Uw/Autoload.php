<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Autoload
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */
if (function_exists('spl_autoload_register')) {

    /**
     * Class name that going to be loaded its file
     *
     * @param string $classname autoload class name
     *
     * @return void
     */
    function thisThemeAutoload($classname)
    {
        autoloadLogic($classname);

    }

    spl_autoload_register('thisThemeAutoload');
} elseif (!function_exists('__autoload')) {

    /**
     * Class name that going to be loaded its file
     *
     * @param string $classname autoload class name
     *
     * @return void
     */
    function __autoload($classname)
    {
        autoloadLogic($classname);

    }

} else {
    throw new Exception('Framework is failing to register __autoload() method');
}

/**
 * Class name that going to be loaded its file
 *
 * @param string $classname autoload class name
 *
 * @return void
 */
function autoloadLogic($classname)
{
    $file = getClassPath($classname) . '.php';
    if (file_exists2($file)) {
        include_once $file;
    }

}

require 'Helper.php';