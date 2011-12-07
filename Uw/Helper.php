<?php

function getClassPath($classname) {
    $classname = str_replace('_', SEP, $classname);
    $classname = str_replace('-', '', $classname);
    return UW_PATH . SEP . $classname;

}

function getCls($class) {
    return 'class="' . $class . '"';

}

/**
 * Is windows OS ?
 * @return bool
 */
function is_windows() {
    if (false !== strpbrk(strtolower(php_uname()), 'windows')) {
        return true;
    }
    return false;

}

/**
 * Check the existance of a File
 * @return bool
 */
function file_exists2($abdfile) {
    if (is_windows()) {
        $path = dirname($abdfile);
        $filename = basename($abdfile);

        if (empty($filename)
            || !is_dir($path)
        ) {
            return false;
        }

        $directory = dir($path);
        while ((FALSE !== ($fl = $directory->read())))
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

function getDefaultTheme(Uw_Config_Data $config) {
    $pgURL = 'http';
    if (isset($_SERVER["HTTPS"])
        AND $_SERVER["HTTPS"] === "on"
    ) {
        $pgURL .= "s";
    }

    $pgURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pgURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
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
            foreach ($temp as $isThisCurrentTheme) {
                if (!empty($isThisCurrentTheme)) {
                    $config->set('defaulttheme', $isThisCurrentTheme);
                    break;
                }
            }
        }
    }

    return $config;

}

function ajaxStr($x, $y) {
    $x = $x . '_' . $y;
    return strtolower($x);

}