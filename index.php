<?php

$config = getDefaultTheme($config);
$loadXhtml = new Uw_Helper_LoadXhtml();
$path = UW_PATH . SEP . 'xhtml';
$HtmlFileList = new Uw_Module_HtmlFileList($path);
$listofthemes = array_keys($HtmlFileList->getList());
$loadXhtml->show($config->get('defaulttheme'), 'index.html', $listofthemes);

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