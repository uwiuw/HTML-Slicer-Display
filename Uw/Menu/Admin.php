<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Menu
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Menu_Admin
 *
 * Admin menu initiator
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Admin
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Menu_Admin
{

    private $_menuItemCls = 'Uw_Theme_Menu_Item_';
    private $_menuAjaxCls = 'Uw_Theme_Menu_Ajax_';
    private $_config;
    private $html;
    private $_creator;
    private $_navigation;
    private $_curPgSlug;
    private $_curPgFile;
    private $_curPgAjCls;

    /**
     * Constructors
     *
     * @param Uw_Config_Data     $data    handler
     * @param Uw_Module_Templaty $html    handler
     * @param Uw_Menu_Creator    $creator hander
     *
     * @return void
     */
    function __construct(Uw_Config_Data $data, Uw_Module_Templaty $html,
        Uw_Menu_Creator $creator
    ) {
        $this->_config = & $data;
        $this->html = & $html;
        $this->_creator = & $creator;
        $this->_curPgSlug = $this->_config->get('_thisSlug');
        $this->_curPgFile = $this->_config->get('_thisFile');
        $this->_navigation = $this->_config->get('admin_menu_lists');

    }

    /**
     * Initiator
     *
     * @return void
     */
    function init()
    {
        if (defined('DOING_AJAX')) {
            $this->_preDoAjaxAction();
        } else {
            if (false !== $clsname = $this->_initClass($this->_curPgFile)) {
                $this->_curPgAjCls = $clsname;
            }
            /*
             * Register theme menu into backend
             */
            add_Action('admin_menu', array($this, 'regItemMenu'));
        }

    }

    /**
     * Register Menu items
     *
     * @return void
     * @throws Uw_Exception if backend menu navigation is empty
     */
    public function regItemMenu()
    {
        if ($this->_navigation) {
            $mainPage = $this->_config->get('admin_menu_page');
            if (count($mainPage)) {
                $this->_regMainNav($mainPage, $this->_navigation);
            } else {
                $arr = array('Slicer Syndicate', 'Slicer', 10, 'slicer', 4);
                $this->_regMainNav($arr, $this->_navigation);
            }
        } else {
            throw new Uw_Exception('Empty Navigation');
        }

    }

    private function _regMainNav(array $main, array $lists, $func = 'loadItemMenu') {

        $number = $main[4];
        add_menu_page(
            $main[0], $main[1], $main[2], $main[3], array($this, $func), '', $number
        );

        foreach ($lists as $k => $v) {
            $name = ucfirst($v);
            add_submenu_page(
                $main[3], $name, $name, $main[2], $v, array($this, $func), '', $number++
            );
        }

    }

    /**
     * Define a page class name, load a new instance and transform it into a page
     *
     * @return void
     */
    public function loadItemMenu()
    {
        $clsname = $this->_menuItemCls . $this->_curPgFile;

        $clsname = new $clsname($this->_config, $this->html, $this->_curPgAjCls);
        $clsname->setNav($this->_curPgSlug, $this->_curPgFile, $this->_navigation);
        $clsname->selfRender();
        $this->_creator->buildForm($clsname);

    }

    /**
     * Check the existance of menu
     *
     * @param string $checkMe filename
     *
     * @return object|false
     */
    private function _initClass($checkMe)
    {
        $fl = UW_PATH . SEP . 'Uw' . SEP . 'Theme' . SEP . 'Menu' . SEP . 'Ajax' . SEP;
        $fl .= $checkMe . '.php';

        if (file_exists2($fl)) {
            $clsname = $this->_menuAjaxCls . $checkMe;
            return new $clsname($this->_config, $this->html);
        }
        return false;

    }

    /**
     * Validating action in $_POST[UW_NAME] before caling doAjaxAction()
     *
     * @return bool
     */
    private function _preDoAjaxAction()
    {
        $flaq = $_POST[UW_NAME];
        if ($flaq && false != $_POST['action'] && $_POST['_wp_http_referer']) {
            $url = parse_url($_POST['_wp_http_referer']);
            if ($url['query']) {
                parse_str($url['query'], $url);
                if ($url['page'] != '') {
                    $this->_curPgFile = ucfirst($url['page']);
                    $clsname = $this->_initClass($this->_curPgFile);
                    if (false !== $clsname
                        && is_object($clsname)
                    ) {
                        $clsname->doAjaxAction();
                        return true;
                    }
                }
            }
        }
        return false;

    }

}