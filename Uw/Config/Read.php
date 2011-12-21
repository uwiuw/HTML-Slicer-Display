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
 * Uw_Config_Read
 *
 * @category   Uw
 * @package    Uw_Config
 * @subpackage Uw_Config_Read
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Config_Read
{

    /**
     * Get value of firstime.ini
     *
     * @param string $filename filename
     *
     * @return mixed
     */
    function getOutput($filename)
    {
        $stripClsName = rtrim(get_class(), strrchr(get_class(), '_'));
        $filename = dirname(getClassPath($stripClsName)) . SEP . 'Theme' . SEP . $filename;

        if (!file_exists2($filename)) {
            throw new exception('E10001 : config file is not exists');
        }

        $file_handle = fopen($filename, "rb");
        $o = array();
        while (!feof($file_handle)) {
            $line_of_text = fgets($file_handle);
            $parts = explode('=', $line_of_text);
            $data = trim($parts[1]);
            if ($data !== $temp = str_replace('[array]', '', $data)) {
                $data = explode(',', $temp);
            } elseif ($data !== $temp = str_replace('[serial]', '', $data)) {
                $data = maybe_unserialize($temp);
            }

            $o += array($parts[0] => $data);
        }

        fclose($file_handle);
        return $o;

    }

    /**
     * Save current config
     *
     * @param array  $newvalue    value going to be save
     * @param string $option_name option name
     *
     * @return array
     */
    function saveConfig(array $newvalue, $option_name)
    {
        if (!empty($newvalue)) {
            $oldvalue = get_option($option_name);
            if (empty($oldvalue)) {
                add_option($option_name, $newvalue);
                global $wpdb;
                if ($wpdb->last_error) {
                    throw new Uw_Exception($wpdb->last_error);
                }
            } else {
                if ($oldvalue !== $newvalue) {
                    update_option($option_name, $newvalue);
                }
            }
            return $newvalue;
        }

        throw new Uw_Exception('Error 10002: first time option saving is fail');

    }

}