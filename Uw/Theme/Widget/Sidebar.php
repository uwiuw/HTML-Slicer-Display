<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Theme_Widget
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Theme_Widget_Sidebar
 *
 * Registering Sidebar, Widget and etc. All data came from config inside
 * firsttime.ini
 *
 * @category   Uw
 * @package    Uw_Theme_Widget
 * @subpackage Uw_Theme_Widget_Sidebar
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Theme_Widget_Sidebar
{

    /**
     * Config data
     * @var Uw_Config_Data
     */
    private $_config;
    private $_widgets;

    /**
     * List of registered sidebar
     * @var array
     */
    private $_sidebars;
    private $_sdbarHtml = array();
    private $_dataWidget = array();

    /**
     * Constractor
     *
     * Method will static call the parent constractor
     *
     * @param Uw_Config_Data $config        handler
     * @param array          $dataForWidget data that going to be injected into
     *                                      a widget
     *
     * @return void
     */
    function __construct(Uw_Config_Data $config, array $dataForWidget)
    {
        $this->_config = $config;
        $this->_widgets = $this->_config->get('widget_lists');
        $this->_sidebars = $this->_config->get('sidebar_lists');
        $this->_dataWidget = $dataForWidget;

    }

    /**
     * Initiate all the Sidebars logic such as registering sidebars and widgets
     *
     * Method will hook into related action
     *
     * @param bool $firsttime Optional. Default is false. state of the initiation
     *
     * @return void
     */
    function init($firsttime = false)
    {
        $this->_regThemeSidebars();
        add_action('widgets_init', array($this, 'regThemeWidget'));
        if ($this->_config->get('_isFirsttime')) {
            add_action('init', array($this, 'regFirstTimeWidget'), 9999);
        }

    }

    /**
     * Public method to retrieve list of registered sidebar
     *
     * @return array
     */
    function getListSidebar()
    {

        return $this->_sidebars;

    }

    /**
     * Register first time default widget
     *
     * @return void
     */
    function regFirstTimeWidget()
    {
        $temp = array();
        $sidebars = $this->getListSidebar();
        if (count($sidebars)) {
            global $wp_registered_widgets;
            $array_key = array_keys($wp_registered_widgets);
            foreach ($sidebars as $k => $v) {
                $id = $v['id'];
                $widget_id = $this->_config->get($id);
                foreach ($array_key as $akk => $akv) {
                    if (false !== strripos($akv, $widget_id)) {
                        $temp[$id] = array($akv);
                        break;
                    }
                }
            }

            wp_set_sidebars_widgets($temp);
        }

    }

    /**
     * Hook Public method to register theme widgets.
     *
     * depenedcy $wp_widget_factory and must be public
     *
     * @return void
     */
    function regThemeWidget()
    {
        global $wp_widget_factory;
        if ($this->_widgets) {

            foreach ($this->_widgets as $k => $v) {

                register_widget($v);
                $wp_widget_factory->widgets[$v]->_dataWidget = $this->_dataWidget;
            }
        }

    }

    /**
     * Register theme Sidebars
     *
     * @return void
     */
    private function _regThemeSidebars()
    {
        foreach ($this->_sidebars as $k => $v) {
            register_sidebar($v);
        }

    }

    /**
     * Get HTML buffer output of all widgets inside a sidebar
     *
     * @return array
     */
    public function getWidgetBuffer()
    {
        foreach ($this->_sidebars as $k => $v) {
            ob_start();
            dynamic_sidebar($v['id']);
            $html = ob_get_clean();
            if ($html) {
                $lists[$v['id']] = $html;
            }
            ob_end_clean();
        }

        return $this->_sdbarHtml = $lists;

    }

}