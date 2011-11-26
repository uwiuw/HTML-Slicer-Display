<?php

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
            $o += array($parts[0] => trim($parts[1]));
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