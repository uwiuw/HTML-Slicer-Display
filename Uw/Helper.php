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

function ajaxStr($x, $y) {
    $x = $x . '_' . $y;
    return strtolower($x);

}

/**
 * Get prev and next theme
 * @param string $themename
 * @param string $listofthemes
 * @return string
 * @todo pindahkan ke module terpisah
 */
function getNextPrevTheme($themename, array $themelist) {
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