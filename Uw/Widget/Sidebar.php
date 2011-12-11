<?php

class Uw_Widget_Sidebar {

    /**
     * Config data
     * @var Uw_Config_Data
     */
    private $config;
    private $widgets;

    /**
     * List of registered sidebar
     * @var array
     */
    private $sidebars;
    private $sidebar_html = array();
    private $dataForWidget = array();

    function __construct(Uw_Config_Data $config, array $dataForWidget) {
        $this->config = $config;
        $this->widgets = $this->config->get('widget_lists');
        $this->sidebars = $this->config->get('sidebar_lists');
        $this->dataForWidget = $dataForWidget;

    }

    /**
     * Initiate all the Sidebars logic such as registering sidebars and widgets
     */
    function init($firsttime = false) {
        $this->regThemeSidebars();
        add_action('widgets_init', array($this, 'regThemeWidget'));
        $is_firsttime = $this->config->get('is_firsttime');
        if ($is_firsttime) {
            add_action('init', array($this, 'regDefaultWidget'), 9999);
        }

    }

    /**
     * Public method to retrieve list of registered sidebar
     * @return array
     */
    function getListSidebar() {
        return $this->sidebars;

    }

    function regDefaultWidget() {
        $temp = array();
        $sidebars = $this->getListSidebar();
        if (count($sidebars)) {
            global $wp_registered_widgets;
            $array_key = array_keys($wp_registered_widgets);
            foreach ($sidebars as $k => $v) {
                $id = $v['id'];
                $widget_id = $this->config->get($id);
                foreach ($array_key as $akk => $akv) {
                    if (FALSE !== strripos($akv, $widget_id)) {
                        $temp[$id] = array($akv);
                        break;
                    }
                }
            }

            wp_set_sidebars_widgets($temp);
        }

    }

    /**
     * Hook Public method to register theme widgets. depenedcy $wp_widget_factory
     *
     */
    function regThemeWidget() {
        global $wp_widget_factory;
        if ($this->widgets) {
            foreach ($this->widgets as $k => $v) {
                register_widget($v);
                $wp_widget_factory->widgets[$v]->dataForWidget = $this->dataForWidget;
            }
        }

    }

    /**
     * Register theme Sidebars
     */
    private function regThemeSidebars() {
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