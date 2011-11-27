<?php

class Uw_Menu_Item {

    public $title = 'No Title';
    public $title_before = '<h2>';
    public $title_after = '</h2>';
    public $decription = 'No Description';
    public $content = '';
    public $navigation;
    public $currentPage;

    public function setNav($currentPage, array $navs) {
        $this->currentPage = $currentPage;
        $this->navigation = $navs;

    }

    public function createNav() {
        foreach ($this->navigation as $k => $v) {
            if ($this->currentPage === $v) {
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