<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Module
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Module_HtmlFileList
 *
 * Wrapper ileterate a path and list all portofolio theme folder
 *
 * @category   Uw
 * @package    Uw_Module
 * @subpackage Uw_Module_HtmlFileList
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Module_HtmlFileList
{

    private $_path;
    private $_fileScreen = array(
        'screenshot.png',
        'screenshots.png',
        'screenshot.jpg',
        'screenshot.jpeg',
        'screenshots.jpg',
        'screenshot.jpeg',
        'screenshot.gif',
        'screenshots.gif',
    );
    private $_fileIndex = array(
        'index.html',
        'index.htm',
    );
    private $_FileStyle = array(
        'style.css',
    );
    private $_pathStyle = array(
        'css',
        'assets',
        'asset',
        'images',
    );
    private $_desc = 'Vestibulum venenatis. Nulla vel ipsum. Proin rutrum, urna sit
        amet bibendum pellentesque';

    /**
     * Constractor
     *
     * @param string $path xhtml directory path location
     *
     * @return void
     */
    function __construct($path)
    {
        $this->_path = $path;

    }

    /**
     * Get list of xhtml directory
     *
     * @return array
     */
    function getList()
    {
        if (!is_dir($this->_path)) {
            throw new Uw_Module_Exception('E998 : path is invalid');
        }

        $directory = dir($this->_path);
        $listFile = array();

        // Loop while the read method goes through each and
        // every file
        while ((false !== ($dirname = $directory->read()))) {
            // If an item is not "." and "..", then something
            // exists in the directory and it is not empty
            if (is_dir($this->_path . SEP . $dirname)
                && $dirname != '.'
                && $dirname != '..'
            ) {
                $isDirNotEmpty = true;
                $listFile[$dirname] = $this->_checkInsideDir($dirname);
            }
        }
        // Close the directory
        $directory->close();

        if ($isDirNotEmpty) {
            return $listFile;
        }

    }

    /**
     * Check and gather info inside directory
     *
     * @param string $dir directory name
     *
     * @return array
     */
    private function _checkInsideDir($dir)
    {
        $o = array(
            'Name' => $dir,
            'Screenshot' => $this->_getUrlLocation($dir, $this->_fileScreen),
            'Indexfile' => $this->_getUrlLocation($dir, $this->_fileIndex)
        );

        $themedata = $this->getTemplateData($dir, $this->_FileStyle, $this->_desc);
        $o['Description'] = $themedata['Description'];
        $o['Version'] = $themedata['Version'];
        $o['Author'] = $themedata['Author'];
        return $o;

    }

    /**
     * Get a portofolio path location
     *
     * @param string $dirname  portofolio directory name
     * @param array  $namelist list of portofolio names
     * @param bool   $return   return value
     *
     * @return bool|string
     */
    private function _getLocation($dirname, array $namelist, $return = false)
    {
        foreach ($namelist as $fl) {
            if (file_exists2($this->_path . SEP . $dirname . SEP . $fl)) {
                return $this->_path . SEP . $dirname . SEP . $fl;
            }
        }

        return $return;

    }

    /**
     * Get url based on protofolio name
     *
     * @param string $dirname  dirname
     * @param array  $namelist list of portofolio
     * @param mixed  $return   Optional. False.
     *
     * @return bool|string
     */
    private function _getUrlLocation($dirname, array $namelist, $return = false)
    {
        foreach ($namelist as $fl) {
            if (file_exists2($this->_path . SEP . $dirname . SEP . $fl)) {
                return UW_URL . '/xhtml/' . $dirname . '/' . $fl;
            }
        }

        return $return;

    }

    /**
     * Get a Portofolio data
     *
     * @param string $dirname  directory name
     * @param array  $namelist list of portofolio names
     * @param bool   $return   default return value when fallback
     *
     * @return type
     */
    function getTemplateData($dirname, array $namelist, $return)
    {
        $namelist[] = $dirname . '.css';
        /**
         * remove any number from string
         */
        $temp = preg_replace('/[^\\/\-a-z\s]/i', '', $dirname);
        if ($temp != $dirname) {
            $namelist[] = $temp . '.css';
        }

        $o = $this->_getLocation($dirname, $namelist);
        if ($o == false) {
            foreach ($this->_pathStyle as $pathStyle) {
                $o = $this->_getLocation($dirname . SEP . $pathStyle, $namelist);
                if ($o !== false) {
                    break;
                }
            }
        }

        if ($o) {
            return get_theme_data($o);
        }

        return $return;

    }

}

