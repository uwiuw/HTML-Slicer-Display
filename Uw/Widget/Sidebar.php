<?php

class Uw_Widget_Sidebar {

    private $sidebars = array(
        array(
            'id' => 'navigation_left',
            'name' => 'Navigation Left',
            'description' => 'Navigation Left'),
        array(
            'id' => 'navigation_right',
            'name' => 'Navigation Right',
            'description' => 'Navigation Right')
    );
    private $sidebar_html = array();

    function __construct() {
        
    }

    function init() {
        $this->regSidebars();

    }

    private function regSidebars() {
        foreach ($this->sidebars as $k => $v) {
            register_sidebar($v);
        }

    }

    public function getWidgetBuffer() {
        foreach ($this->sidebars as $k => $v) {
            ob_start();
            dynamic_sidebar($v['id']);
            $html = ob_get_clean();
            if ($html) {
                $lists[$v['id']] = $html;
            }
            ob_end_clean();
        }

        return $this->sidebar_html = $lists;
    }
}