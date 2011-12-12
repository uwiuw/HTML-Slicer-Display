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
 * @link      http://uwiuw.com/outerrim/
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
    $classname = str_replace('_', SEP, $classname);
    $classname = str_replace('-', '', $classname);
    return UW_PATH . SEP . $classname;

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
        while ((false !== ($fl = $directory->read())))
        {
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
 * Get and Set Default theme in config handler
 *
 * @param Uw_Config_Data $config object handler
 *
 * @return Uw_Config_Data
 */
function getDefaultTheme(Uw_Config_Data $config)
{
    $pgURL = 'http';
    if (isset($_SERVER["HTTPS"])
        AND $_SERVER["HTTPS"] === "on"
    ) {
        $pgURL .= "s";
    }

    $pgURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pgURL .= $_SERVER["SERVER_NAME"]
            . ":" . $_SERVER["SERVER_PORT"]
            . $_SERVER["REQUEST_URI"];
    } else {
        $pgURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    $needle = UW_URL;
    $temp = str_replace($needle, '', $pgURL);
    if ($temp === $pgURL) {
        $needle = dirname(WP_CONTENT_URL);
        $temp = str_replace($needle . '/', '', $pgURL);
    }

    if ($temp !== $pgURL) {
        $temp = explode('/', $temp);
        if (!empty($pgURL) && is_array($temp)) {
            foreach ($temp as $isValidTheme) {
                if (!empty($isValidTheme)) {
                    $fl = UW_PATH . SEP . 'xhtml' . SEP . $isValidTheme;
                    if (is_dir($fl)) {
                        $config->set('defaulttheme', $isValidTheme);
                    }
                    break;
                }
            }
        }
    }

    return $config;

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

/**
 * Get data to determine the next and previous current portofolio
 *
 * @param string $themename nama themes
 * @param array  $themelist list of themes in folder
 *
 * @return array
 * @todo pindahkan ke module terpisah
 */
function getNextPrevTheme($themename, array $themelist)
{
    if (false !== $pos = array_search($themename, $themelist)) {
        if ($pos === 0) {
            $previous = $themelist[count($themelist) - 1];
            $next = $themelist[$pos + 1];
        } elseif ($pos === count($themelist) - 1) {
            $next = $themelist[0];
            $previous = $themelist[$pos - 1];
        } else {
            if (count($themelist) > 2) {
                $previous = $themelist[$pos - 1];
                $next = $themelist[$pos + 1];
            }
        }

        $o['prevFile'] = UW_U . '/' . $previous . '/';
        $o['nextFile'] = UW_U . '/' . $next . '/';
    }

    return $o;

}

/**
 * Build data for front end
 *
 * @param Uw_Config_Data $config object handler
 *
 * @return type
 */
function buildDataForTemplate(Uw_Config_Data $config)
{
    $HtmlFileList = new Uw_Module_HtmlFileList(UW_PATH . SEP . 'xhtml');
    $themename = $config->get('defaulttheme');
    $listofthemes = array_keys($HtmlFileList->getList());

    $tNextPrev = getNextPrevTheme($themename, $listofthemes);
    $tNextPrev['defaulttheme'] = $themename;
    $tNextPrev['UW_URL'] = UW_URL;
    $o = array(
        'listofthemes' => $listofthemes,
        'themename' => $themename,
        'tNextPrev' => $tNextPrev,
    );

    return $o;

}