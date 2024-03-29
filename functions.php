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
define('UW_U', dirname(WP_CONTENT_URL));
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
require_once UW_PATH . SEP . 'Uw' . SEP . 'Autoload.php';
require_once UW_PATH . SEP . 'Uw' . SEP . 'Helper.php';

/*
 * Main Theme Logic
 *
 * The algoritma have seperated action for back and front end. It's also support how
 * sidebar module register itself and list of default widgets.
 */
$UwStart = new Uw_Starter;
$reader = new Uw_Config_Read;
$inInifile = $reader->getOutput('firsttime.ini');

define('UW_NAME', $inInifile['theme']);
define('UW_NAME_LOWERCASE', strtolower(UW_NAME));
define('UW_URL', WP_CONTENT_URL . '/themes/' . UW_NAME);

$opt = get_option(UW_NAME_LOWERCASE);
 
$config = $UwStart->init(new Uw_Config_Data, $inInifile, $opt);
if ($config->get('_isNeedUpgrade') == TRUE) {
    $opt = $reader->saveConfig($inInifile, UW_NAME_LOWERCASE);
} elseif ($config->get('_isFirsttime') == TRUE) {
    $opt = $reader->saveConfig($inInifile, UW_NAME_LOWERCASE);
} else {
    /**
     * bypass aja
     */
}


if ($opt) {
    $config->sets($opt);
}


//, get_option(UW_NAME_LOWERCASE), UW_NAME_LOWERCASE
if (!is_a($config, 'Uw_Config_Data')) {
    throw new Exception('E999 : config is empty');
}

include_once UW_PATH . SEP . 'Uw' . SEP . 'Theme' . SEP . UW_NAME . '.php';

/**
 * Start using Wordpress Tempating System
 */