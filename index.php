<?php

$config = getDefaultTheme($config);
$loadXhtml = new Uw_Module_Loader($html);
$path = UW_PATH . SEP . 'xhtml';
$HtmlFileList = new Uw_Module_HtmlFileList($path);
$listofthemes = array_keys($HtmlFileList->getList());
$loadXhtml->setVisible($config->get('nav_visiblity'));
$loadXhtml->show($config->get('defaulttheme'), 'index.html', $listofthemes);