<?php

/* * ***************************************************************************** */
/* Helper Theme                                                                    */
/* * ***************************************************************************** */

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
 * @param string         $path   absolute path where xhtm protofolio reside
 *
 * @return array
 */
function buildDataForTemplate(Uw_Config_Data $config, $path)
{
    $HtmlFileList = new Uw_Theme_Module_HtmlFileList($path);
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