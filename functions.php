<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Theme
 * @package   Wordpress
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */
define('SEP', DIRECTORY_SEPARATOR);
define('UW_NAME', 'HtmlSlicerDisplay');
define('UW_NAME_LOWERCASE', strtolower(UW_NAME));
define('UW_U', dirname(WP_CONTENT_URL));
define('UW_URL', WP_CONTENT_URL . '/themes/' . UW_NAME);
define('UW_PATH', TEMPLATEPATH);

require_once UW_PATH . SEP . 'Uw' . SEP . 'Autoload.php';

/*
 * Main Theme Logic
 * The algoritma have seperated action for back and front end. Its also support how
 * sidebar module register itself and list of default widgets.
 */
$UwStart = new Uw_System_Starter;
$config = new Uw_Config_Data;
$html = new Uw_Module_Templaty();
$savedOpt = get_option(UW_NAME_LOWERCASE);
$config = $UwStart->init($config, new Uw_Config_Read, $savedOpt);
if (is_a($config, 'Uw_Config_Data')) {
    //backend
    if (is_admin() && is_user_logged_in()) {
        $adminMenuClass = $config->get('admin_menu');
        $UwMenu = new $adminMenuClass($config, $html, new Uw_Menu_Creator);
        $UwMenu->init($config);
    } else {
        //frontend theme
        $config = getDefaultTheme($config);
    }

    extract(buildDataForTemplate($config));
    $Uw_Sidebar = new Uw_Widget_Sidebar($config, $tNextPrev);
    $Uw_Sidebar->init();
    $success = true;
}

if (!isset($success) OR $success == false) {
    throw new Exception('E999 : config is empty');
} else {

}

/**
 * Start using Tempating
 */