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
 * Uw_Menu_Item_Abstract
 *
 * Abstract
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Item
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
abstract class Uw_Menu_Item_Abstract
{

    protected $_title = 'No Title';
    protected $_titlebefore = '<h2>';
    protected $_titleafter = '</h2>';
    public $decription = 'No Description';
    public $content = '';
    protected $_navigation;
    protected $_curPageSlug;
    protected $_curPageFile;

    /**
     * HTML creator module
     * @var Uw_Module_Templaty
     */
    protected $html;

    /**
     * Ajax module
     * @var Uw_Menu_Ajax_Abstract
     */
    protected $ajax;
    protected $_config;

    /**
     * Inititate the process of rendenring page and set the value of $content
     *
     * @return void
     */
    abstract public function selfRender();

    /**
     * get content
     *
     * @return html
     */
    abstract protected function _getContent();

    /**
     * Constractor
     *
     * @param Uw_Config_Data        $data handler
     * @param Uw_Module_Templaty    $html handler
     * @param Uw_Menu_Ajax_Abstract $ajax handler
     *
     * @return void
     */
    final function __construct(Uw_Config_Data $data, Uw_Module_Templaty $html,
        Uw_Menu_Ajax_Abstract $ajax = null
    ) {
        $this->_config = &$data;
        $this->html = $html;
        if ($ajax instanceof Uw_Menu_Ajax_Abstract) {
            $this->ajax = $ajax;
            $this->buttons = $this->ajax->getButtons();
        } else {
            $this->buttons = array();
        }

    }

    /**
     * Set Navigation
     *
     * @param string $curPageSlug current page slug or portofolio
     * @param string $curPageFile current portoflio filename
     * @param array  $navs        current navigation data
     *
     * @return void
     * @todo perjelaslah. terutama darimana dipanggilnya, $navs itu apa aja isinya ?
     */
    public function setNav($curPageSlug, $curPageFile, array $navs)
    {
        $this->_curPageSlug = $curPageSlug;
        $this->_curPageFile = $curPageFile;
        $this->_navigation = $navs;

    }

    /**
     * Create admin menu navigation
     *
     * @return string
     */
    public function createTabNav()
    {
        foreach ($this->_navigation as $k => $v) {
            if ($this->_curPageSlug === $v) {
                $class = 'nav-tab nav-tab-active';
            } else {
                $class = 'nav-tab';
            }

            if ($url = menu_page_url($v, false)) {
                $listOfNav .= '<a href="' . $url . '" class="' . $class . '">' .
                    ucfirst($v) . '</a>';
            }
        }

        $o = <<<HTML
<h2 class="nav-tab-wrapper">$listOfNav</h2>
HTML;
        return $o;

    }

    /**
     * Registering ajax button into its wp hook admin_print_footer_scripts
     *
     * @param string $hokname hook name
     *
     * @return void
     */
    protected function _regAjaxButton($hokname)
    {
        if ($hokname) {
            $hokname = "admin_footer-$hokname";
        } else {
            $hokname = 'admin_print_footer_scripts'; //default hook name
        }

        add_action($hokname, array($this->ajax, 'inject'), 9999);
    }

}