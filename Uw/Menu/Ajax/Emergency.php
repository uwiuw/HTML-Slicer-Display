<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Menu
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Uw_Menu_Ajax_Emergency
 *
 * Emergency page ajax
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Ajax
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Menu_Ajax_Emergency extends Uw_Menu_Ajax_Abstract
{

    protected $config;
    protected $itemArgs = array(
        'fix_htaccess' => array(
            'Name' => 'fix_htaccess',
            'Title' => 'Fixing htaccess',
            'Description' => 'Rewrite htaccess file (will not change permalink)',
            'Ajax' => 'fix_htaccess',
            'Icon' => 'semlabs_terminal.png',
            'form_id' => 'fix_htaccess',
            'button_id' => 'fix_htaccess_url',
            'button_id_output' => 'fix_htaccess_url_output'
        ),
        'rebuild_config' => array(
            'Name' => 'rebuild_config',
            'Title' => 'Rebuild Config',
            'Description' => 'Rebuild config. Sometimes needed to refresh config',
            'Ajax' => 'rebuild_config',
            'Icon' => 'semlabs_arrow_circle_right.png',
            'form_id' => 'rebuild_config',
            'button_id' => 'rebuild_config_url',
            'button_id_output' => 'rebuild_config_output'
        ),
    );

    /**
     * Doing ajax operation and call die. This method will echo result of ajax
     * operation to be retrieve by related method to be process
     *
     * @return void
     */
    function doAjaxAction()
    {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';

        if ($action === 'fix_htaccess') {
            $htaccess = new Uw_Module_HtAccess();
            $ajaxResponse = $htaccess->setHtaccessFile();
        } elseif ($action === 'rebuild_config') {
            $result = delete_option(UW_NAME_LOWERCASE);
            if ($result) {
                $ajaxResponse = 'Rebuilding Option is succesfull';
            }
        }
        die($ajaxResponse);

    }

}