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
            if (!is_dir($path . SEP . $fl) && $fl != '.' && $fl != '..') {
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