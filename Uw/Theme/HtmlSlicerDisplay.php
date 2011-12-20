<?php

require 'Helper.php';

if ($config->get('is_firsttime')) {
    $htaccess = new Uw_Module_HtAccess();
    return $htaccess->setHtaccessFile();
}

//backend
$html = new Uw_Module_Templaty();
if (is_admin() && is_user_logged_in()) {
    $themePageCls = $config->get('admin_menu');
    $UwMenu = new $themePageCls($config, $html, new Uw_Menu_Creator);
    $UwMenu->init($config);
} else {
//frontend theme
    $config = getDefaultTheme($config);
}

extract(buildDataForTemplate($config));
$Uw_Sidebar = new Uw_Theme_Widget_Sidebar($config, $tNextPrev);
$Uw_Sidebar->init();