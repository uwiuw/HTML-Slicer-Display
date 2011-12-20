<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_System
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Theme_Loader
 *
 * Loader for portofolio html files
 *
 * @category   Uw
 * @package    Uw_System
 * @subpackage Uw_Theme_Loader
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Theme_Loader
{

    /**
     * Widgeting Resource HTML Template
     * @var string
     */
    private $_froWidgetFile = 'Front_Sidebar.php';

    /**
     * Default navigating resource HTML Template
     * @var string
     */
    private $_froNavFile = 'Front_Nav.php';

    /**
     * Object For rendering Front_Nav.php file in resources folder
     * @var Uw_Module_Templaty
     */
    private $_template;

    /**
     * Object for rendering default wordpress sidebar
     * @var Uw_Theme_Widget_Sidebar
     */
    private $_sidebar;

    /**
     * List of registered Sidebar
     * @var array
     */
    private $_sidebar_lists;

    /**
     * Constractor
     *
     * @param Uw_Module_Templaty $template   Object templating
     * @param Uw_Theme_Widget_Sidebar  $Uw_Sidebar Optional. Null. object
     */
    function __construct(Uw_Module_Templaty $template,
        Uw_Theme_Widget_Sidebar $Uw_Sidebar = null
    ) {
        $this->_template = $template;
        $this->_sidebar = $Uw_Sidebar;
        $this->_sidebar_lists = $Uw_Sidebar->getListSidebar();

    }

    /**
     * Load
     *
     * If There no sidebar, will use default navigation menu
     *
     * @param string $themename    theme name
     * @param string $filename     filename
     * @param array  $listofthemes list of themes
     *
     * @return html
     */
    private function _load($themename, $filename, array $listofthemes)
    {
        $o = $this->_getCurPortoHmtl($themename, $filename);
        $tNextPrev = getNextPrevTheme($themename, $listofthemes);
        if ($sidebar = $this->_sidebar->getWidgetBuffer()) {
            $nav = $this->_getFrontWidget($sidebar);
        } else {
            $nav = $this->_frontNav($tNextPrev);
        }
        //change title
        return str_replace('</body>', $nav . '</body>', $o);

    }

    /**
     * Get current porto html
     *
     * @param string $foldername folder name
     * @param string $file       filename
     *
     * @return html
     */
    private function _getCurPortoHmtl($foldername, $file)
    {
        $xhtmlUrl = UW_URL . '/xhtml/' . $foldername . '/';
        $file = UW_PATH . SEP . 'xhtml' . SEP . $foldername . SEP . $file;
        $o = file_get_contents($file);

        $search = '</title>';
        $replace = '</title>' . '<base href="' . $xhtmlUrl . '" />';
        $o = str_replace($search, $replace, $o);
        return $o;

    }

    /**
     * Get default Frontend navigation html
     *
     * @param array $argsNav arguents
     *
     * @return html|void
     */
    private function _frontNav(array $argsNav)
    {
        if (!empty($argsNav)) {
            $args = array(
                'UW_U' => UW_U,
                'UW_URL' => UW_URL,
                'cssClass' => 'navigation',
                'prevFile' => UW_U . '/' . basename($argsNav['prevFile']),
                'nextFile' => UW_U . '/' . basename($argsNav['nextFile'])
            );
            $o = $this->_template->model->getTemplate($this->_froNavFile, $args);
            return $o;
        }

    }

    /**
     * Get front widget
     *
     * @param array $sidebar list of registered sidebars
     *
     * @return html
     */
    private function _getFrontWidget(array $sidebar)
    {
        $args = array(
            'UW_U' => UW_U,
            'UW_URL' => UW_URL,
            'cssClass' => 'navigation');
        if ($this->_sidebar_lists) {
            foreach ($this->_sidebar_lists as $k => $v) {
                $id = $v['id'];
                $args[$id] = $sidebar[$id];
            }
        }

        $o = $this->_template->model->getTemplate($this->_froWidgetFile, $args);
        return $o;

    }

    /**
     * Print Html. Wrapper for _load() private function
     *
     * @param string $themename    the current portofolio folder name
     * @param string $filename     the filename that going to be shown
     * @param array  $listofthemes array of current registered portofolio folders
     *
     * @return void
     */
    public function show($themename, $filename, array $listofthemes)
    {
        echo $this->_load($themename, $filename, $listofthemes);

    }

}