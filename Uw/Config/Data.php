<?php

class Uw_Config_Data {

    private $defaulttheme;
    private $admin_menu;
    private $curPageSlug;
    private $curPageFile;
    private $admin_menu_lists;

    function __construct() {
        $this->curPageSlug = trim($_GET['page']);
        $this->curPageFile = ucfirst($_GET['page']);

    }

    function get($property) {
        return $this->$property;

    }

    function sets(array $properties) {

        foreach ($properties as $k => $v) {
            $this->$k = $v;
        }

        return $properties;

    }

}