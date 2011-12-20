<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Theme
 * @package   Wordpress
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */
if (is_search() && false != $search_query = strtolower(trim(get_search_query()))) {
    foreach ($listofthemes as $k => $v) {
        if (strtolower($v) === $search_query) {
            $themename = $search_query;
            break;
        } elseif (false !== stristr($v, $search_query)) {
            $themename = $v;
            break;
        }
    }
}

$loadXhtml = new Uw_Theme_Loader($html, $Uw_Sidebar);
$loadXhtml->show($themename, 'index.html', $listofthemes);