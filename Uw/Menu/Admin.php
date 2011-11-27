<?php

class Uw_Menu_Admin {

    private $menuItemCls = 'Uw_Menu_Item_';
    private $menuAjaxCls = 'Uw_Menu_Ajax_';
    private $config;
    private $creator;
    private $navigation;
    private $curPageSlug;
    private $curPageFile;

    function __construct(Uw_Config_Data $data, Uw_Menu_Creator $creator) {
        $this->config = & $data;
        $this->creator = & $creator;
        $this->curPageSlug = $this->config->get('curPageSlug');
        $this->curPageFile = $this->config->get('curPageFile');
        $this->navigation = $this->config->get('admin_menu_lists');

    }

    function init() {
        add_Action('admin_menu', array($this, 'publicHook'));

    }

    public function publicHook() {
        $this->_itemMenu();
        $this->_ajaxMenu();

    }

    /**
     * Register Menu items
     */
    private function _itemMenu() {
        $number = 4;
        add_menu_page('Slicer Syndicate', 'Slicer', 10, 'slicer', array($this, 'loadItem'), '', $number);
        foreach ($this->navigation as $k => $v) {
            $name = ucfirst($v);
            add_submenu_page('slicer', $name, $name, 10, $v, array($this, 'loadItem'), '', $number++);
        }

    }

    private function _ajaxMenu() {
        $fl = UW_PATH . SEP . 'UW' . SEP . 'Menu' . SEP . 'Ajax' . SEP . $this->curPageFile . '.php';

        if (file_exists($fl)) {
            add_action('admin_head', array($this, 'loadAjax'));
        }

    }

    public function loadItem() {
        $clsname = $this->menuItemCls . $this->curPageFile;
        $clsname = new $clsname();
        $clsname->setNav($this->curPageSlug, $this->curPageFile, $this->navigation);
        $clsname->init();
        $this->creator->buildForm($clsname);

    }

    public function loadAjax() {

        $clsname = $this->menuAjaxCls . $this->curPageFile;
        $clsname = new $clsname($this->config);
        $clsname->inject();

    }

}