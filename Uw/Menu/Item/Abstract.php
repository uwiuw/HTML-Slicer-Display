<?php

abstract class Uw_Menu_Item_Abstract {

    public $title = 'No Title';
    public $title_before = '<h2>';
    public $title_after = '</h2>';
    public $decription = 'No Description';
    public $content = '';
    public $navigation;
    public $curPageSlug;
    public $curPageFile;

    /**
     * HTML creator module
     * @var Uw_Module_Templaty
     */
    protected $html;
    protected $ajax;
    protected $config;

    abstract protected function init();

    abstract protected function _getContent();

    final function __construct(
    Uw_Config_Data $data, Uw_Module_Templaty $html,
        Uw_Menu_Ajax_Abstract $ajax = NULL
    ) {
        $this->config = &$data;
        $this->html = $html;
        if ($ajax instanceof Uw_Menu_Ajax_Abstract) {
            $this->ajax = $ajax;
            $this->buttons = $this->ajax->getButtons();
        } else {
            $this->buttons = array();
        }

    }

    public function setNav($curPageSlug, $curPageFile, array $navs) {
        $this->curPageSlug = $curPageSlug;
        $this->curPageFile = $curPageFile;
        $this->navigation = $navs;

    }

    /**
     * Create admin menu navigation
     *
     * @todo create them using certain navigation
     * @return string
     */
    public function createTabNav() {
        foreach ($this->navigation as $k => $v) {
            if ($this->curPageSlug === $v) {
                $class = 'nav-tab nav-tab-active';
            } else {
                $class = 'nav-tab';
            }

            if ($url = menu_page_url($v, false)) {
                $listOfNav .= '<a href="' . $url . '" class="' . $class . '">' . ucfirst($v) . '</a>';
            }
        }

        $o = <<<HTML
<h2 class="nav-tab-wrapper">$listOfNav</h2>
HTML;
        return $o;

    }

    protected function _regAjaxButton() {
        add_action('admin_print_footer_scripts', array($this->ajax, 'inject'), 99999);

    }

}