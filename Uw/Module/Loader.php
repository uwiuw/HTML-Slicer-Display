<?php

class Uw_Module_Loader {

    private $isVisibleNav = True;

    /**
     * For rendering Front_Nav.php file in resources folder
     * @var Uw_Module_Templaty
     */
    private $template;

    function __construct(Uw_Module_Templaty $template) {
        $this->template = $template;

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
        $args = array(
            'UW_U' => UW_U,
            'UW_URL' => UW_URL,
            'cssClass' => 'navigation',
            'prevFile' => UW_U . '/' . basename($prevFile),
            'nextFile' => UW_U . '/' . basename($nextFile),
        );

        $nav = $this->template->model->getTemplate('Front_Nav.php', $args);
        return str_replace('</body>', $nav . '</body>', $defHTML);

    }

    /**
     * Wrapper for _load private function
     *
     * @param type $themename
     * @param type $filename
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
    function setVisible($visibility = '') {
        $this->isVisibleNav = empty($visibility) ? FALSE : TRUE;

    }

}