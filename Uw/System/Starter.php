<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_System
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_System_Loader
 *
 * First framework initiator. Called from function.php. Most of its work is for
 * building config
 *
 * @category   Uw
 * @package    Uw_System
 * @subpackage Uw_System_Loader
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_System_Starter
{

    /**
     * Current theme opt
     * @var array
     */
    private $_opt = array();

    /**
     * Config File name (without absolute path)
     * @var string
     */
    private $_firsttimefile = 'firsttime.ini';

    /**
     * Initiation
     *
     * @param Uw_Config_Data $config   object config data container
     * @param Uw_Config_Read $reader   object reader
     * @param array          $opt      Current config data. This data mus be empty
     *                                 If the theme activate for the first time.
     *                                 If it only switching then it must be not empty
     * @param string         $db_field Optional. empty.
     * @param string         $filename Optional. empty.
     *
     * @return Uw_Config_Data
     * @see http://wp.uwiuw.com/issue-compability-theme-option-version-0-0-1-ke-0-0-2
     */
    public function init(Uw_Config_Data $config, Uw_Config_Read $reader, $opt,
        $db_field, $filename =''
    ) {
        if ($filename) {
            $this->_firsttimefile = $filename;
        }

        //if $opt not empty, then it's not the first time
        $inInifile = $reader->getOutput($this->_firsttimefile);
        if ($opt) {
            /**
             * @see issue-compability-theme-option-version-0-0-1-ke-0-0-2
             */
            if (true === $this->_isNeedUpgrade($opt, $inInifile)) {
                $opt = $reader->saveConfig($inInifile, $db_field);
            }

            $config->set('is_firsttime', false);
        } else {
            //first time
            $this->_rebuildHtaccess();
            $opt = $reader->saveConfig($inInifile, $db_field);
            $config->set('is_firsttime', true);
        }

        if ($opt) {
            $config->sets($opt);
        }

        return $config;

    }

    /**
     * Wrapper for object building htaccess
     *
     * @return bool
     */
    private function _rebuildHtaccess()
    {
        $htaccess = new Uw_Module_HtAccess();
        return $htaccess->setHtaccessFile();

    }

    /**
     * Check ig data in database need to be upgrade or not
     *
     * The checking process are based on missing array key comparation between
     * parameter. If a missing key found, the value will transfer to $inDb and it
     * will override $inIniFile as by reference param
     *
     * @param array $inDb       saved database data
     * @param array &$inIniFile by reference. config yg berada dalam file ini
     *
     * @return bool
     */
    private function _isNeedUpgrade($inDb, &$inIniFile)
    {
        if (empty($inDb)) {
            return true;
        }

        foreach ($inIniFile['mandatory'] as $k) {
            if (false === array_key_exists($k, $inDb)) {
                $missingKey[] = $k;
                $is_true = true;
            }
        }

        if ($is_true) {
            foreach ($missingKey as $k) {
                $inDb[$k] = $inIniFile[$k];
            }
            $inIniFile = $inDb;

            return true;
        }

        return false;

    }

}