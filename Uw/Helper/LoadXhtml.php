<?php

class Uw_Helper_LoadXhtml {

    private $isVisibleNav = True;

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
                $o = $this->_frontNavigation($o, $themename, $prevFile, $nextFile);
            }
        }

        return $o;

    }

    private function _frontNavigation($o, $themename, $prevFile, $nextFile) {
        $UW_URL = UW_URL;
        $prevname = basename($prevFile);
        $nextname = basename($nextFile);

        $nav = <<<HTML
<div style="position:fixed; top:20%; right:2%;">
    $prevname
    <br/>
    <a href ="$prevFile"><img src="$UW_URL/assets/semlabs_arrow_right.png" style="border:none"></a>
</div>
<div style="position:fixed; top:20%; left:2%;">
    $nextname
    <br/>
    <a href ="$nextFile"><img src="$UW_URL/assets/semlabs_arrow_left.png" style="border:none"></a>
</div>
</body>
HTML;

        $o = str_replace('</body>', $nav, $o);
        return $o;

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

    function setVisible($visibility = '') {
        $this->isVisibleNav = empty($visibility) ? FALSE : TRUE;

    }

}