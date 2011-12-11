<?php

if (is_search() && FALSE != $search_query = strtolower(trim(get_search_query()))) {

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

$loadXhtml = new Uw_Module_Loader($html, $Uw_Sidebar);
$loadXhtml->show($themename, 'index.html', $listofthemes);