<?php

class Uw_Module_Start {

    /**
     * First time flag
     * @var bool
     */
    private $isFirstTime = true;

    /**
     * Current theme opt
     * @var array
     */
    private $opt = array();
    private $filename = 'firsttime.ini';

    public function init(Uw_Config_Data $config, Uw_Config_Read $reader, $opt,
        $filename =''
    ) {

        if ($opt) {
            $this->isFirstTime = false;
        } else {
            $this->isFirstTime = true;
            if ($this->_setHtaccessFile()) {
                if ($filename) {
                    $this->filename = $filename;
                }
            }
            $opt = $reader->getOutput($this->filename);
//            $opt = $reader->saveConfig($opt);
        }

        if ($opt) {
            $config->sets($opt);
        }

        return $config;

    }

    function _setHtaccessFile() {
        $filename = UW_PATH . SEP . 'xhtml' . SEP . '.htaccess';
        $UW_U = UW_U;
        $basic = <<<HTML
<IfModule mod_rewrite.c>
RewriteEngine on
Options +FollowSymLinks
RewriteCond %{THE_REQUEST} ^.*/index.html
RewriteRule ^(.*)index.html$ $UW_U/$1 [R=301,L]
RewriteCond %{THE_REQUEST} ^.*/index.php
RewriteRule ^(.*)index.php$ $UW_U/$1 [R=301,L]
RewriteCond %{REQUEST_FILENAME} !-f
IndexIgnore *
</IfModule>
HTML;
        $Handle = fopen($filename, 'w ');
        fwrite($Handle, $basic);
        fclose($Handle);

        return true;

    }

}