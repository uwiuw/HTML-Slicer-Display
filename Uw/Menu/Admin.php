<?php

class Uw_Menu_Admin {

    private $menuItemCls = 'Uw_Menu_Item_';
    private $menuAjaxCls = 'Uw_Menu_Ajax_';
    private $config;
    private $html;
    private $creator;
    private $navigation;
    private $curPageSlug;
    private $curPageFile;
    private $curPageAjCls;

    function __construct(Uw_Config_Data $data, Uw_Module_Templaty $html,
        Uw_Menu_Creator $creator) {
        $this->config = & $data;
        $this->html = & $html;
        $this->creator = & $creator;
        $this->curPageSlug = $this->config->get('curPageSlug');
        $this->curPageFile = $this->config->get('curPageFile');
        $this->navigation = $this->config->get('admin_menu_lists');

    }

    function init() {
        if (defined('DOING_AJAX')) {
            /**
             * determine whether the ajax action is belong to us
             */
            $flaq = $_POST['HtmlSlicerDisplay'];
            if ($flaq && false != $_POST['action'] && $_POST['_wp_http_referer']) {
                $url = parse_url($_POST['_wp_http_referer']);
                if ($url['query']) {
                    parse_str($url['query'], $url);
                    if ($url['page'] != '') {
                        $this->curPageFile = $url['page'];
                        if (false !== $clsname = $this->_ifExist($this->curPageFile)) {
                            $clsname->doAjaxAction();
                        }
                    }
                }
            }
        } else {
            if (false !== $clsname = $this->_ifExist($this->curPageFile)) {
                $this->curPageAjCls = $clsname;
            }
            add_Action('admin_menu', array($this, 'regItemMenu')); //register theme menu into backend
        }

    }

    /**
     * Register Menu items
     */
    public function regItemMenu() {
        if ($this->navigation) {
            $number = 4;
            add_menu_page('Slicer Syndicate', 'Slicer', 10, 'slicer', array($this, 'loadItemMenu'), '', $number);
            foreach ($this->navigation as $k => $v) {
                $name = ucfirst($v);
                add_submenu_page('slicer', $name, $name, 10, $v, array($this, 'loadItemMenu'), '', $number++);
            }
        } else {
            throw new Uw_Exception('Empty Navigation');
        }

    }

    public function loadItemMenu() {
        $clsname = $this->menuItemCls . $this->curPageFile;
        $clsname = new $clsname($this->config, $this->html, $this->curPageAjCls);
        $clsname->setNav($this->curPageSlug, $this->curPageFile, $this->navigation);
        $clsname->init();

        $this->creator->buildForm($clsname);

    }

    /**
     * Check the existance of menu
     * 
     * @param string filename with out php exstention
     * @return clsname|false
     */
    private function _ifExist($checkMe) {
        $fl = UW_PATH . SEP . 'Uw' . SEP . 'Menu' . SEP . 'Ajax' . SEP . $checkMe . '.php';
        if (file_exists($fl)) {
            $clsname = $this->menuAjaxCls . $checkMe;
            return new $clsname($this->config, $this->html);
        }

        return false;

    }

}