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
<script type='text/javascript' src='/wp-includes/js/jquery/jquery.js'></script>
<style type="text/css">
    .navigation {width: 98%; height: 0; margin: 0; padding: 0; position: absolute; top: 0; left: 0;background-color:#fff }
    .navigation.bottom { top: 100%; margin-top: -108px; clear: both; }
    .navigation .prev { float: left; text-indent: -9999px; margin: 100px 0 0; width: 40px; height: 40px; clear: none; }
    .navigation .next { float: right; text-indent: -9999px; margin: 100px 0 0; width: 40px; height: 40px; text-align: left; clear: none; }
    .navigation .prev a,
    .navigation .next a { display: block; width: 40px; height: 40px; }
    .navigation .prev a { background: url($UW_URL/assets/semlabs_arrow_left.png) no-repeat left top; }
    .navigation .next a { background: url($UW_URL/assets/semlabs_arrow_right.png) no-repeat right top; }
    .navigation .prev a:hover { background: url($UW_URL/assets/semlabs_arrow_left.png) no-repeat left bottom; }
    .navigation .next a:hover { background: url($UW_URL/assets/semlabs_arrow_right.png) no-repeat right bottom; }
</style>
<script>
    // once the dom is loaded
    jQuery(document).ready(function(){
        if ( jQuery(".navigation").length ) {
            jQuery(".navigation.bottom").remove();
            var navi = jQuery(".navigation"),
            scrollTop = jQuery(window).scrollTop(),
            lowerBound = navi.parent().height() - 108;
            jQuery(window).scroll(function(){
                scrollTop = jQuery(window).scrollTop();
                lowerBound = navi.parent().height() - 108;
                if ( parseInt(navi.css("top")) <= lowerBound && scrollTop <= lowerBound ) {
                    navi.stop().animate({ top: scrollTop },300);
                } else {
                    navi.stop().animate({ top: lowerBound },300);
                }
            });
        }
    });
</script>
<div class="navigation">
    <div class="prev"><a href ="$prevFile">Prev2</a></div>
    <div class="next"><a href ="$nextFile">Next</a></div>
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