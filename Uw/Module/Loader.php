<?php

class Uw_Module_Loader {

    private $isVisibleNav = True;

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

    function __construct(Uw_Module_Templaty $template,
        Uw_Widget_Sidebar $Uw_Sidebar = null
    ) {
        $this->template = $template;
        $this->sidebar = $Uw_Sidebar;

    }

    private function _load($themename, $filename, array $listofthemes) {
        if (false !== $pos = array_search($themename, $listofthemes)) {
            if ($pos === 0) {
                $previous = $listofthemes[count($listofthemes) - 1];
                $next = $listofthemes[$pos + 1];
            } elseif ($pos === count($listofthemes) - 1) {
                $next = $listofthemes[0];
                $previous = $listofthemes[$pos - 1];
            } else {
                if (count($listofthemes) > 2) {
                    $previous = $listofthemes[$pos - 1];
                    $next = $listofthemes[$pos + 1];
                }
            }

            $xhtmlUrl = UW_URL . '/xhtml/' . $themename . '/';
            $filename = UW_PATH . SEP . 'xhtml' . SEP . $themename . SEP . $filename;
            $prevFile = UW_U . '/' . $previous . '/';
            $nextFile = UW_U . '/' . $next . '/';

            $o = file_get_contents($filename);
            $o = str_replace('</title>', '</title>' . '<base href="' . $xhtmlUrl . '" />', $o);

            if ($this->isVisibleNav) {
                $o = $this->_frontNav($o, $themename, $prevFile, $nextFile);
            }
        }
        return $o;

    }

    private function _frontNav($defHTML, $themename, $prevFile, $nextFile) {
        $sidebar = $this->sidebar->bufferWidget();

        if (empty($sidebar)) {
            $args = array(
                'UW_U' => UW_U,
                'UW_URL' => UW_URL,
                'cssClass' => 'navigation',
                'prevFile' => UW_U . '/' . basename($prevFile),
                'nextFile' => UW_U . '/' . basename($nextFile),
                'navigation_left' => $sidebar['navigation_left'],
                'navigation_right' => $sidebar['navigation_right']);
            $nav = $this->template->model->getTemplate('Front_Nav.php', $args);
        } else {
            $args = array(
                'UW_U' => UW_U,
                'UW_URL' => UW_URL,
                'cssClass' => 'navigation',
                'navigation_left' => $sidebar['navigation_left'],
                'navigation_right' => $sidebar['navigation_right'],
            );
            $nav = $this->template->model->getTemplate('Front_Sidebar.php', $args);
        }
        return str_replace('</body>', $nav . '</body>', $defHTML);

    }

    /**
     * Wrapper for _load() private function
     *
     * @param string $themename
     * @param string $filename
     * @param array $listofthemes
     */
    public function show($themename, $filename, array $listofthemes) {
        echo $this->_load($themename, $filename, $listofthemes);

    }

    /**
     * Set frontend navigation visibility
     *
     * @param bool $visibility
     */
    function setVisible($visibility = false) {
        $this->isVisibleNav = empty($visibility) ? FALSE : TRUE;

    }

}