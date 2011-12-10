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
    function init() {
        $this->regThemeSidebars();
        add_action('widgets_init', array($this, 'regThemeWidget'));

    }

    /**
     * Public method to retrieve list of registered sidebar
     * @return array
     */
    function getListSidebar() {
        return $this->sidebars;

    }

    /**
     * Hook Public method to register theme widgets
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