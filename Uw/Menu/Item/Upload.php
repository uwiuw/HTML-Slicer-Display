<?php

/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Menu
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Uw_Menu_Item_Upload
 *
 * Upload menu page data for rendering
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Item
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Menu_Item_Upload extends Uw_Menu_Item_Abstract
{

    public $title = 'Upload';
    public $description = 'Upload new portfolio';

    /**
     * Initiator
     *
     * @return void
     */
    function init()
    {
        $file_upload = new Uw_Module_UploadUpgrader();
        if ($_GET['action'] === $file_upload->getAction()) {
            $this->content = $file_upload->doUpload();
        } else {
            $this->content = $file_upload->createUploadForm();
        }
    }

    protected function _getContent() {

    }

}