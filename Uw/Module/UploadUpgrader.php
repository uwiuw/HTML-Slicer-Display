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

    private $_action = 'upload-theme';

    /**
     * Form Upload ID
     * @var string
     */
    private $_frmUpID = 'themezip';
    private $_nonceID = 'theme-upload';
    var $package;
    var $filename;

    /**
     * Do upload process
     *
     * @param string $urlholder string of url data
     * @param array  $updir     data of upload folder
     *
     * @return string
     */
    function doUpload($updir = '')
    {
        if (!current_user_can('install_themes')) {
            wp_die(__('You do not have sufficient permissions to install themes for this site.'));
        }
        check_admin_referer($this->_nonceID);
        if (!class_exists('File_Upload_Upgrader', false)) {
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        }

        $uploads = array(
            'path' => UW_PATH . SEP . 'xhtml',
            'url' => UW_URL . '/xhtml',
            'subdir' => '/xhtml',
            'basedir' => UW_PATH . SEP . 'xhtml',
            'baseurl' => UW_URL . '/xhtml',
            'error' => '',
        );

        if (empty($updir)) {
            $updir = wp_upload_dir();
        }

        if (empty($_FILES[$this->_frmUpID]['name']) && empty($_GET[$urlholder])) {
            wp_die(__('Please select a file'));
        }

        if (!empty($_FILES)) {
            $this->filename = $_FILES[$this->_frmUpID]['name'];
        } else if (isset($_GET[$urlholder])) {
            $this->filename = $_GET[$urlholder];
        }

        //Handle a newly uploaded file, Else assume its already been uploaded
        if (!empty($_FILES)) {
            $this->filename = wp_unique_filename($updir['basedir'], $this->filename);
            $this->package = $updir['basedir'] . '/' . $this->filename;

            // Move the file to the uploads dir
            if (false === @move_uploaded_file($_FILES[$this->_frmUpID]['tmp_name'], $this->package)) {
                wp_die('The uploaded file could not be moved to ' . $updir['path']);
            }
        } else {
            $this->package = $updir['basedir'] . '/' . $this->filename;
        }

        if (WP_Filesystem()) {
            $o = unzip_file($this->package, $uploads['path']);
            return 'Success to upload archieve file : ' . $this->filename;
        }

        return 'Fail to upload archieve file : ' . $this->filename;

    }

    /**
     * Get Action property value
     *
     * @return string
     */
    public function getAction()
    {
        return $this->_action;

    }

    private function _submitButton($text, $type, $name, $wrap)
    {
        if (!function_exists('get_submit_button')) {
            include_once ABSPATH . 'wp-admin/includes/template.php';
        }

        return get_submit_button('Install Now', 'button', 'install-theme-submit', false);

    }

    function createUploadForm()
    {
        $actionUrl = menu_page_url('upload', false) . '&action=' . $this->_action;
        $nonce = wp_nonce_field($this->_nonceID, "_wpnonce", true, false);
        $submit = $this->_submitButton('Install Now', 'button', 'install-theme-submit', false);
        $formUpload_id = $this->_frmUpID;

        $upload = <<<HTML
<h4>Install a theme in .zip format</h4>
<p class="install-help">
    If you have a theme in a .zip format,
    you may install it by uploading it here.
</p>
<form method="post" enctype="multipart/form-data" action="$actionUrl">
    $nonce
    <input type="file" name="$formUpload_id" />
    $submit
</form>
HTML;
        return $upload;

    }

}