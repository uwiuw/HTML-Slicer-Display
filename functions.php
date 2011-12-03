<?php

define('SEP', DIRECTORY_SEPARATOR);
define('UW_NAME', 'HtmlSlicerDisplay');
define('UW_U', dirname(WP_CONTENT_URL));
define('UW_URL', WP_CONTENT_URL . '/themes/' . UW_NAME);
define('UW_PATH', TEMPLATEPATH);

include_once(UW_PATH . SEP . 'Uw' . SEP . 'Autoload.php');

$UwStart = new Uw_Module_Start;
$config = new Uw_Config_Data;
$config = $UwStart->init($config, new Uw_Config_Read, get_option(UW_NAME));

if (is_a($config, 'Uw_Config_Data')) {
    if (is_admin() && is_user_logged_in()) {
        $adminMenuClass = $config->get('admin_menu');
        $html = new Uw_Module_Templaty();
        $UwMenu = new $adminMenuClass($config, $html, new Uw_Menu_Creator); //default cls Uw_Menu_Admin
        $UwMenu->init($config);
    } else {
        
    }
    $success = TRUE;
}

if (!isset($success) OR $success == FALSE) {
    throw new Exception('E999 : config is empty');
}