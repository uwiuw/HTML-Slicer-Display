<?php

abstract class Uw_Menu_Ajax_Abstract {

    protected $html;
    protected $config;
    private $action;

    abstract public function doAjaxAction();

    final function __construct(Uw_Config_Data $data, Uw_Module_HtmlCreator $html) {

        if (empty($this->itemArgs)) {
            throw new Uw_Exception('E123 : Item arguments is empty');
        }
        $this->html = $html;
        $this->config = &$data;
        $this->action = $_POST['action'];

    }

    function inject() {
        if ($this->itemArgs) {

            foreach ($this->itemArgs as $k => $v) {
                $o .= $this->html->getButtonAjax(
                    $v['button_id'], $v['form_id'], $v['button_id_output']
                );
            }
            $o = '<script type="text/javascript">' . $o . '</script>';
            echo $o;
        }

    }

}
