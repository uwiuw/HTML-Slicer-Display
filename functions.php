<?php

define('SEP', DIRECTORY_SEPARATOR);
define('UW_NAME', 'HtmlSlicerDisplay');
define('UW_U', dirname(WP_CONTENT_URL)); 
define('UW_URL', WP_CONTENT_URL . '/themes/' . UW_NAME);
define('UW_PATH', TEMPLATEPATH);

include_once(UW_PATH . SEP . 'Uw' . SEP . 'Helper' . SEP . 'autoload.php');

$UwStart = new Uw_Module_Start();
$config = $UwStart->init(new Uw_Config_Read, get_option(UW_NAME));
if ($config) {
    if (is_admin() && is_user_logged_in()) {
        $UwMenu = new $config['admin_menu'](new Uw_Menu_Creator);
        $UwMenu->init($config);
    } else {
        

    }
    $success = TRUE;
}

if (!isset($success) OR $success == FALSE) {
    throw new Exception('E999 : config is empty');
}