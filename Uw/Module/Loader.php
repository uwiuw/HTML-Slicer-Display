<?php

class Uw_Module_Loader {

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
    private $template;

    /**
     * Object for rendering default wordpress sidebar
     * @var Uw_Widget_Sidebar
     */
    private $sidebar;

    /**
     * List of registered Sidebar
     * @var array
     */
    private $sidebar_lists;

    function __construct(Uw_Module_Templaty $template,
        Uw_Widget_Sidebar $Uw_Sidebar = null
    ) {
        $this->template = $template;
        $this->sidebar = $Uw_Sidebar;
        $this->sidebar_lists = $Uw_Sidebar->getListSidebar();

    }

    /**
     * Load
     *
     * If There no sidebar, will use default navigation menu
     *
     * @param string $themename theme name
     * @param string $filename filename
     * @param array $listofthemes list of themes
     * @return html
     */
    private function _load($themename, $filename, array $listofthemes) {
        $o = $this->_getCurPortoHmtl($themename, $filename);
        $tNextPrev = getNextPrevTheme($themename, $listofthemes);
        if ($sidebar = $this->sidebar->getWidgetBuffer()) {
            $nav = $this->_getFrontWidget($sidebar);
        } else {
            $nav = $this->_frontNav($tNextPrev);
        }

        return str_replace('</body>', $nav . '</body>', $o);

    }

    /**
     * Get current porto html
     *
     * @param string $theme
     * @param string $file
     * @return html
     */
    private function _getCurPortoHmtl($theme, $file) {
        $xhtmlUrl = UW_URL . '/xhtml/' . $theme . '/';
        $file = UW_PATH . SEP . 'xhtml' . SEP . $theme . SEP . $file;
        $o = file_get_contents($file);
        $o = str_replace('</title>', '</title>' . '<base href="' . $xhtmlUrl . '" />', $o);
        return $o;

    }

    /**
     * Default Front end navigation
     *
     * @param string $defHTML
     * @param array $themename
     * @param array $nextPrev
     * @return html
     */
    private function _frontNav(array $nextPrev) {
        if (!empty($nextPrev)) {
            $args = array(
                'UW_U' => UW_U,
                'UW_URL' => UW_URL,
                'cssClass' => 'navigation',
                'prevFile' => UW_U . '/' . basename($nextPrev['prevFile']),
                'nextFile' => UW_U . '/' . basename($nextPrev['nextFile'])
            );
            $o = $this->template->model->getTemplate($this->_froNavFile, $args);
            return $o;
        }

    }

    /**
     * Get front widget
     *
     * @param array $sidebar
     * @return type
     */
    private function _getFrontWidget(array $sidebar) {

        $args = array(
            'UW_U' => UW_U,
            'UW_URL' => UW_URL,
            'cssClass' => 'navigation');
        if ($this->sidebar_lists) {
            foreach ($this->sidebar_lists as $k => $v) {
                $id = $v['id'];
                $args[$id] = $sidebar[$id];
            }
        }

        $o = $this->template->model->getTemplate($this->_froWidgetFile, $args);
        return $o;

    }

    /**
     * Print Html. Wrapper for _load() private function
     *
     * @param string $themename
     * @param string $filename
     * @param array $listofthemes
     */
    public function show($themename, $filename, array $listofthemes) {
        echo $this->_load($themename, $filename, $listofthemes);

    }

}