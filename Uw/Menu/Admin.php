<?php

class Uw_Menu_Admin {

    private $creator;
    private $navigation;
    private $currentPage;

    function Uw_Menu_Admin(Uw_Config_Data $data, Uw_Menu_Creator $creator) {
        $this->config = & $data;
        $this->creator = & $creator;
        $this->currentPage = $this->config->get('currentPage');
        $this->navigation = $this->config->get('admin_menu_lists');

    }

    function init() {
        add_Action('admin_menu', array($this, 'inMenuHook'));

    }

    function inMenuHook() {
        $number = 4;
        add_menu_page('Slicer Syndicate', 'Slicer', 10, 'slicer', array($this, 'callCreator'), '', $number);
        foreach ($this->navigation as $k => $v) {
            $name = ucfirst($v);
            add_submenu_page('slicer', $name, $name, 10, $v, array($this, 'callCreator'), '', $number++);
        }

    }

    function callCreator() {

        $clsname = 'Uw_Menu_Item_' . ucfirst($this->currentPage);
        $clsname = new $clsname();
        $clsname->setNav($this->currentPage, $this->navigation);
        $clsname->init();
        $this->creator->buildForm($clsname);

    }

}