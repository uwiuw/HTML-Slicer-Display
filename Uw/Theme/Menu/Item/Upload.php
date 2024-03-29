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
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Theme_Menu_Item_Upload
 *
 * Upload menu page data for rendering
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Theme_Menu_Item
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Theme_Menu_Item_Upload extends Uw_Theme_Menu_Item_Abstract
{

    public $title = 'Upload';
    public $description = 'Upload new portfolio';

    /**
     * Inititate the process of rendenring page and set the value of $content
     *
     * @return void
     */
    function selfRender()
    {
        $file_upload = new Uw_Theme_Module_UploadUpgrader();
        if ($_GET['action'] === $file_upload->getAction()) {
            $this->content = $file_upload->doUpload();
        } else {
            $this->content = $file_upload->createUploadForm();
        }

    }

    /**
     * Get Content
     *
     * @return void
     */
    protected function _getContent()
    {

    }

}