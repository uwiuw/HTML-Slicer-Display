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
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
abstract class Uw_Menu_Item_Abstract
{

    public $title = 'No Title';
    public $title_before = '<h2>';
    public $title_after = '</h2>';
    public $decription = 'No Description';
    public $content = '';
    public $navigation;
    public $curPageSlug;
    public $curPageFile;

    /**
     * HTML creator module
     * @var Uw_Module_Templaty
     */
    protected $html;
    protected $ajax;
    protected $config;

    /**
     * Inititate the process of rendenring page and set the value of $content
     *
     * @return void
     */
    abstract public function selfRender();

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
        $this->config = &$data;
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
        $this->curPageSlug = $curPageSlug;
        $this->curPageFile = $curPageFile;
        $this->navigation = $navs;

    }

    /**
     * Create admin menu navigation
     *
     * @todo create them using certain navigation
     * @return string
     */
    public function createTabNav()
    {
        foreach ($this->navigation as $k => $v) {
            if ($this->curPageSlug === $v) {
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
     * @return void
     */
    protected function _regAjaxButton()
    {
        add_action('admin_print_footer_scripts', array($this->ajax, 'inject'), 9999);

    }

}