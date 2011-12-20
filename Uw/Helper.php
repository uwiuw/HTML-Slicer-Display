<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Helper
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 * @todo      Pisahkan seluruh helper theme dengan helper framework
 */

/**
 * Get class path
 *
 * Used by autoload to determine file to be loader
 *
 * @param string $classname class name
 *
 * @return string
 */
function getClassPath($classname)
{
    $search = array('Uw_', '_', '-');
    $replace = array('', SEP, '');

    return UW_PATH . SEP . 'Uw' . SEP . str_replace($search, $replace, $classname);

}

/**
 * Get css class
 *
 * @param string $class css class
 *
 * @return string
 */
function getCls($class)
{
    return 'class="' . $class . '"';

}

/**
 * Is windows OS ?
 *
 * @return bool
 */
function isWindows()
{
    if (false !== strpbrk(strtolower(php_uname()), 'windows')) {
        return true;
    }
    return false;

}

/**
 * Check the existance of a File
 *
 * @param string $abdfile abolute file path
 *
 * @return bool
 */
function file_exists2($abdfile)
{
    if (isWindows()) {
        $path = dirname($abdfile);
        $filename = basename($abdfile);

        if (empty($filename)
            || !is_dir($path)
        ) {
            return false;
        }

        $directory = dir($path);
        while ((false !== ($fl = $directory->read()))) {
            if (!is_dir($path . SEP . $fl)
                && $fl != '.'
                && $fl != '..'
            ) {
                if ($filename === $fl) {
                    return true;
                }
            }
        }
        $directory->close();
        return false;
    } else {
        return file_exists($abdfile);
    }

}

/**
 * Get ajax string and returned lowered string
 *
 * @param string $x string
 * @param string $y string
 *
 * @return string
 */
function ajaxStr($x, $y)
{
    $x = $x . '_' . $y;
    return strtolower($x);

}

/* * ***************
 * Depreceated Class from Wordpress
 * @see deprecated.php
 */

/**
 * Class ini sudah tidak dipakai. Dan digantikan WP_User_Query. Oleh karena kita
 * memakai autoload, maka class ini akan diextends saja demi menghindari pengecekan
 * via class_exists di deprecated.php:291. Tujuanya demi optimasi autoload
 */
class WP_User_Search extends WP_User_Query
{

}