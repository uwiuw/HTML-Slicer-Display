<?php

class Uw_Menu_Item_Abstract {

    public $title = 'No Title';
    public $title_before = '<h2>';
    public $title_after = '</h2>';
    public $decription = 'No Description';
    public $content = '';
    public $navigation;
    public $curPageSlug;
    public $curPageFile;
    protected $html;
    protected $config;

    final function __construct(Uw_Config_Data $data, Uw_Module_HtmlCreator $html,
        array $itemButtons) {
        $this->config = &$data;
        $this->html = $html;
        $this->buttons = $itemButtons;

    }

    public function setNav($curPageSlug, $curPageFile, array $navs) {
        $this->curPageSlug = $curPageSlug;
        $this->curPageFile = $curPageFile;
        $this->navigation = $navs;

    }

    public function createNav() {
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

}