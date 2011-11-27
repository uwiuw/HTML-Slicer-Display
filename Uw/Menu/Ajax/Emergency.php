<?php

class Uw_Menu_Ajax_Emergency {

    private $config;
    private $action = array(
        'form_id' => 'fix_htaccess',
        'button_id' => 'fix_htaccess_url',
        'button_id_output' => 'fix_htaccess_url_output',
    );

    function __construct(Uw_Config_Data $data) {
        $this->config = &$data;
        $this->html = new Uw_Module_HtmlCreator();

    }

    function inject() {
        $o = $this->html->getButtonAjax(
            $this->action['button_id'], $this->action['form_id'], $this->action['button_id_output']
        );
        $o = '<script type="text/javascript">' . $o . '</script>';
        echo $o;

    }

    function processAjax() {
        
    }

}