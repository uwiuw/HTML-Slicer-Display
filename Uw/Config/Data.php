<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Config
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Uw_Config_Data
 *
 * @category   Uw
 * @package    Uw_Config
 * @subpackage Uw_Config_Data
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Config_Data {

    private $is_firsttime;
    private $defaulttheme;
    private $admin_menu;
    private $curPageSlug;
    private $curPageFile;
    private $admin_menu_lists;

    function __construct() {
        $this->curPageSlug = trim($_GET['page']);
        $this->curPageFile = ucfirst($_GET['page']);

    }

    function get($prope) {
        return $this->$prope;

    }

    function set($prope, $value) {
        return $this->$prope = $value;

    }

    function sets(array $prope) {

        foreach ($prope as $k => $v) {
            $this->$k = $v;
        }

        return $prope;

    }

}