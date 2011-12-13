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
 * Uw_Module_UploadUpgrader
 *
 * Upload portofolio module
 *
 * @category   Uw
 * @package    Uw_Module
 * @subpackage Uw_Module_UploadUpgrader
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Module_UploadUpgrader
{

    var $package;
    var $filename;

    /**
     * Constractor
     *
     * @param string $form_id   form id
     * @param string $urlholder string of url data
     * @param array  $updir   data of upload folder
     *
     * @return void
     */
    function __construct($form_id, $urlholder, $updir)
    {
        if (empty($updir)) {
            $updir = wp_upload_dir();
        }

        if (empty($_FILES[$form_id]['name']) && empty($_GET[$urlholder])) {
            wp_die(__('Please select a file'));
        }

        if (!empty($_FILES)) {
            $this->filename = $_FILES[$form_id]['name'];
        } else if (isset($_GET[$urlholder])) {
            $this->filename = $_GET[$urlholder];
        }

        //Handle a newly uploaded file, Else assume its already been uploaded
        if (!empty($_FILES)) {
            $this->filename = wp_unique_filename($updir['basedir'], $this->filename);
            $this->package = $updir['basedir'] . '/' . $this->filename;

            // Move the file to the uploads dir
            if (false === @move_uploaded_file($_FILES[$form_id]['tmp_name'], $this->package)) {
                wp_die('The uploaded file could not be moved to ' . $updir['path']);
            }
        } else {
            $this->package = $updir['basedir'] . '/' . $this->filename;
        }

    }

}