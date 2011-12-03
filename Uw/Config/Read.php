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
 * Uw_Config_Read
 *
 * @category   Uw
 * @package    Uw_Config
 * @subpackage Uw_Config_Read
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Config_Read {

    function getOutput($filename) {

        $stripClsName = rtrim(get_class(), strrchr(get_class(), '_'));
        $filename = getClassPath($stripClsName) . SEP . $filename;
        if (!file_exists($filename)) {
            throw new exception('E10001 : config file is not exists');
        }

        $file_handle = fopen($filename, "rb");
        $o = array();
        while (!feof($file_handle))
        {
            $line_of_text = fgets($file_handle);
            $parts = explode('=', $line_of_text);
            $data = trim($parts[1]);
            if ($data !== $temp = str_replace('[array]', '', $data)) {
                $data = explode(',', $temp);
            }

            $o += array($parts[0] => $data);
        }

        fclose($file_handle);
        return $o;

    }

    function saveConfig(array $opt) {
        if (!empty($opt)) {
            if ($o = update_option(UW_NAME, $opt)) {
                return $opt;
            }
            throw new exception('Error 10002: first time option saving is fail');
        }

    }

}