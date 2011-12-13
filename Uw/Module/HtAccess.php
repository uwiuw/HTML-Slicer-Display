<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Module
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Uw_Module_HtAccess
 *
 * HtAccess Writer module
 *
 * @category   Uw
 * @package    Uw_Module
 * @subpackage Uw_Module_HtAccess
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Module_HtAccess
{

    private $_succesMsg = 'Successful creating a new Htaccess';
    /**
     * Set Htaccess file on xhtml folder
     *
     * @return string
     */
    function setHtaccessFile()
    {
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

        return $this->_succesMsg;
    }

}