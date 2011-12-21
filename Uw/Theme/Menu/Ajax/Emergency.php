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
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Theme_Menu_Ajax_Emergency
 *
 * Emergency page ajax
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Theme_Menu_Ajax
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Theme_Menu_Ajax_Emergency extends Uw_Theme_Menu_Ajax_Abstract
{

    protected $_config;
    protected $_itemArgs = array(
        'fix_htaccess' => array(
            'Name' => 'fix_htaccess',
            'Title' => 'Fixing htaccess',
            'Description' => 'Rewrite htaccess file (will not change permalink)',
            'Ajax' => 'fix_htaccess',
            'Icon' => 'semlabs_terminal.png',
            'form_id' => 'fix_htaccess',
            'button_id' => 'fix_htaccess_url',
            'ajax_response_output' => 'fix_htaccess_output'
        ),
        'rebuild_config' => array(
            'Name' => 'rebuild_config',
            'Title' => 'Rebuild Config',
            'Description' => 'Rebuild config. Sometimes needed to refresh config',
            'Ajax' => 'rebuild_config',
            'Icon' => 'semlabs_arrow_circle_down.png',
            'form_id' => 'rebuild_config',
            'button_id' => 'rebuild_config_url',
            'ajax_response_output' => 'rebuild_config_output'
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
        $action = $_POST[UW_NAME];
        $ajaxResponse = 'Process is failing for unknown reason';

        if ($action === 'fix_htaccess') {
            $htaccess = new Uw_Theme_Module_HtAccess();
            $ajaxResponse = $htaccess->setHtaccessFile();
            $success = true;
        } elseif ($action === 'rebuild_config') {
            $result = delete_option(UW_NAME_LOWERCASE);
            if ($result) {
                $ajaxResponse = 'Rebuilding Option is succesfull';
                $reader = new Uw_Config_Read;
                $reader->saveConfig(
                    $reader->getOutput('firsttime.ini'), UW_NAME_LOWERCASE
                );
            }
            $success = true;
        }

        if ($success) {
            $UW_URL = UW_URL;
            $ajaxResponse = <<<HTML
<div class="updated fade">
    <p>$ajaxResponse</p>
</div>
HTML;
        }
        die($ajaxResponse);

    }

}