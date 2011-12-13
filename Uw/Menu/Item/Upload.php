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
    function init() {
        if ($_GET['action'] === 'upload-theme') {
            $this->content = $this->doUpload();
        } else {
            $this->content = $this->_createUploadForm();
        }

    }

    protected function _getContent() {

    }

    function doUpload() {
        if (!current_user_can('install_themes')) {
            wp_die(__('You do not have sufficient permissions to install themes for this site.'));
        }
        check_admin_referer('theme-upload');
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

        $file_upload = new Uw_Module_UploadUpgrader('themezip', 'package', $uploads);
        if (WP_Filesystem()) {
            $o = unzip_file($file_upload->package, $uploads['path']);
            return 'Success to upload archieve file : ' . $file_upload->filename;
        }

        return 'Fail to upload archieve file : ' . $file_upload->filename;

    }

    private function _submitButton($text, $type, $name, $wrap) {
        if (!function_exists('get_submit_button')) {
            include_once ABSPATH . 'wp-admin/includes/template.php';
        }

        return get_submit_button('Install Now', 'button', 'install-theme-submit', false);

    }

    private function _createUploadForm() {
        $actionUrl = menu_page_url('upload', false) . '&action=upload-theme';
        $nonce = wp_nonce_field('theme-upload', "_wpnonce", true, false);
        $submit = $this->_submitButton('Install Now', 'button', 'install-theme-submit', false);

        $upload = <<<HTML
<h4>Install a theme in .zip format</h4>
<p class="install-help">
    If you have a theme in a .zip format,
    you may install it by uploading it here.
</p>
<form method="post" enctype="multipart/form-data" action="$actionUrl">
    $nonce
    <input type="file" name="themezip" />
    $submit
</form>
HTML;
        return $upload;

    }

}