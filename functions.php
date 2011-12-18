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
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */
define('SEP', DIRECTORY_SEPARATOR);
define('UW_NAME', 'HtmlSlicerDisplay');
define('UW_NAME_LOWERCASE', strtolower(UW_NAME));
define('UW_U', dirname(WP_CONTENT_URL));
define('UW_URL', WP_CONTENT_URL . '/themes/' . UW_NAME);
define('UW_PATH', TEMPLATEPATH);

/**
 * @todo fix this : Daripada membuat simplepie class sbg third party, lebih baik
 * meng-include-nya aja pada moment dimana dia dibutuhkan yaitu pada proses
 * widgeting. Seluruh proses pengincludean dimulai dari fetch_feed(). Jadi ternyata
 * bukan masalah yg lokal terjadi pada index.php dashboard admin panel.
 *
 * Menurut pembacaan :
 * 1. \wp-admin\includes\dashboard.php
 * 2. \wp-includes\default-widgets.php
 * 3. \wp-includes\feed.php
 *
 * Another alternative adalah membuat arsitektur yg tidak akan memanggil autoload
 * atau autoload-nya dikembalikan menjadi consitional autoload.
 * Atau sampai seluruh class_exists() diganti sama wordpress menjadi false autoload
 */
//if (defined('DOING_AJAX')) {
require_once ABSPATH . WPINC . '/class-simplepie.php';
//}

require_once UW_PATH . SEP . 'Uw' . SEP . 'Autoload.php';

/*
 * Main Theme Logic
 *
 * The algoritma have seperated action for back and front end. It's also support how
 * sidebar module register itself and list of default widgets.
 */
$UwStart = new Uw_System_Starter;
$config = new Uw_Config_Data;
$html = new Uw_Module_Templaty();
$config = $UwStart->init($config, new Uw_Config_Read, get_option(UW_NAME_LOWERCASE), UW_NAME_LOWERCASE);
if (is_a($config, 'Uw_Config_Data')) {
    //backend
    if (is_admin() && is_user_logged_in()) {
        require_once ABSPATH . WPINC . '/class-simplepie.php';

        $themePageCls = $config->get('admin_menu');
        $UwMenu = new $themePageCls($config, $html, new Uw_Menu_Creator);
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
    /**
     * Start using Wordpress Tempating System
     */
}