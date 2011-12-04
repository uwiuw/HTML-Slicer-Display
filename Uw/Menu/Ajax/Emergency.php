<?php

class Uw_Menu_Ajax_Emergency extends Uw_Menu_Ajax_Abstract {

    protected $config;
    protected $itemArgs = array(
        'fix_htaccess' => array(
            'Name' => 'fix_htaccess',
            'Title' => 'Fixing htaccess',
            'Description' => 'reconfigurate theme rewrite rule (will not change blog permalink)',
            'Ajax' => 'fix_htaccess',
            'Icon' => 'semlabs_terminal.png',
            'form_id' => 'fix_htaccess',
            'button_id' => 'fix_htaccess_url',
            'button_id_output' => 'fix_htaccess_url_output'
        ),
        'rebuild_config' => array(
            'Name' => 'rebuild_config',
            'Title' => 'Rebuild Config',
            'Description' => 'Rebuild current config. Sometimes this needed cause by various reason',
            'Ajax' => 'rebuild_config',
            'Icon' => 'semlabs_arrow_circle_right.png',
            'form_id' => 'rebuild_config',
            'button_id' => 'rebuild_config_url',
            'button_id_output' => 'rebuild_config_output'
        ),
    );

    function doAjaxAction() {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';
        
        if ($action === 'fix_htaccess') {
            $htaccess = new Uw_Module_Htaccess();
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