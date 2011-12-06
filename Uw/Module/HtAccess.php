<?php

class Uw_Module_HtAccess {

    /**
     * Set Htaccess file
     */
    function setHtaccessFile() {
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

        return 'Successful creating a new Htaccess';

    }

}