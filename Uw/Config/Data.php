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
 * @link      http://wp.uwiuw.com/html-slicer-display/
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
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Config_Data
{

    private $_isFirsttime;
    private $_deftheme;
    private $_adminmenu;
    private $_curPageSlug;
    private $_curPageFile;
    private $_adminmenulists;

    /**
     * Constractor
     *
     * @return void
     */
    function __construct()
    {
        $this->_curPageSlug = trim($_GET['page']);
        $this->_curPageFile = ucfirst($_GET['page']);

    }

    /**
     * Getter
     *
     * @param string $prope property names
     *
     * @return mixed
     */
    function get($prope)
    {
        return $this->$prope;

    }

    /**
     * Setter
     *
     * @param string $prope property name
     * @param mixed  $value property value
     *
     * @return mixed
     */
    function set($prope, $value)
    {
        return $this->$prope = $value;

    }

    /**
     * Set multiple properties
     *
     * @param array $properties list of inejcetd properties
     *
     * @return array
     */
    function sets(array $properties)
    {
        foreach ($properties as $k => $v) {
            $this->$k = $v;
        }

        return $properties;

    }

}