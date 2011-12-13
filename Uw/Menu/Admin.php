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
 * @link      http://uwiuw.com/outerrim/
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
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Menu_Admin
{

    private $menuItemCls = 'Uw_Menu_Item_';
    private $menuAjaxCls = 'Uw_Menu_Ajax_';
    private $config;
    private $html;
    private $creator;
    private $navigation;
    private $curPageSlug;
    private $curPageFile;
    private $curPageAjCls;

    /**
     * Constractor
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
        $this->config = & $data;
        $this->html = & $html;
        $this->creator = & $creator;
        $this->curPageSlug = $this->config->get('curPageSlug');
        $this->curPageFile = $this->config->get('curPageFile');
        $this->navigation = $this->config->get('admin_menu_lists');

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
            if (false !== $clsname = $this->_initClass($this->curPageFile)) {
                $this->curPageAjCls = $clsname;
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
        if ($this->navigation) {
            $number = 4;
            add_menu_page(
                'Slicer Syndicate', 'Slicer', 10, 'slicer', array($this, 'loadItemMenu'), '', $number
            );
            foreach ($this->navigation as $k => $v) {
                $name = ucfirst($v);
                add_submenu_page('slicer', $name, $name, 10, $v, array($this, 'loadItemMenu'), '', $number++);
            }
        } else {
            throw new Uw_Exception('Empty Navigation');
        }

    }

    /**
     * Load item menu and transform it into a form
     *
     * @return void
     */
    public function loadItemMenu()
    {
        $clsname = $this->menuItemCls . $this->curPageFile;
        $clsname = new $clsname($this->config, $this->html, $this->curPageAjCls);
        $clsname->setNav($this->curPageSlug, $this->curPageFile, $this->navigation);
        $clsname->selfRender();

        $this->creator->buildForm($clsname);

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
        $fl = UW_PATH . SEP . 'Uw' . SEP . 'Menu' . SEP . 'Ajax' . SEP;
        $fl .=$checkMe . '.php';
        if (file_exists2($fl)) {
            $clsname = $this->menuAjaxCls . $checkMe;
            return new $clsname($this->config, $this->html);
        }
        return false;

    }

    /**
     * Validating action in $_POST['HtmlSlicerDisplay'] before caling doAjaxAction()
     *
     * @return bool
     * @todo ganti HtmlSlicerDisplay dengan constant khusus
     */
    private function _preDoAjaxAction()
    {
        $flaq = $_POST['HtmlSlicerDisplay'];
        if ($flaq && false != $_POST['action'] && $_POST['_wp_http_referer']) {
            $url = parse_url($_POST['_wp_http_referer']);
            if ($url['query']) {
                parse_str($url['query'], $url);
                if ($url['page'] != '') {
                    $this->curPageFile = ucfirst($url['page']);
                    $clsname = $this->_initClass($this->curPageFile);
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