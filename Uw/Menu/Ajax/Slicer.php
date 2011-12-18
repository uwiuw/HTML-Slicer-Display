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
 * Uw_Menu_Ajax_Slicer
 *
 * Slicer page ajax
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Ajax
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Menu_Ajax_Slicer extends Uw_Menu_Ajax_Abstract
{

    protected $_config;
    protected $_itemArgs = array(
        'del_portofolio' => array(
            'Name' => 'del_portofolio',
            'Title' => 'Delete',
            'Description' => '',
            'Ajax' => 'del_portofolio',
            'Icon' => 'semlabs_arrow_circle_down.png',
            'form_id' => 'del_portofolio',
            'button_id' => 'del_portofolio_url',
            'ajax_response_output' => 'del_portofolio_output'
        ),
    );

    /**
     * Doing ajax operation and call die. This method will echo result of ajax
     * operation to be retrieve by related method to be process
     *
     * @return void
     *
     * @todo buat quickedit menu bagi form portofolio dimana bisa diset list of
     * portofolio utamanya. statusnya drooped feature
     */
    function doAjaxAction()
    {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';

        if (false !== $this->_getSubStringAction($action, 'edit_portofolio')) {
            $ajaxResponse = 'Portofolio on editing mode';
            $portoname = $_POST['action'];
            ?>
            <script>
                String.prototype.trim = function () {
                    return this.replace(/^\s*/, "").replace(/\s*$/, "");
                }
                var htmlStr = jQuery('.ajax_output').html();
                htmlStr.trim();
                if (htmlStr == '<?php echo $ajaxResponse ?>' ) {
                    jQuery('#hiddenedit<?php echo '_' . $portoname ?>').toggle();
                    jQuery('.ajax_output').html('<?php echo $ajaxResponse ?>');
                } else {
                    jQuery('#hiddenedit<?php echo '_' . $portoname ?>').toggle();
                    jQuery('.ajax_output').html('Editiong on Quick Mode');
                }
                jQuery('#hiddeneditcancel').click(function () {
                    //hiding cancel button
                    jQuery('#hiddenedit<?php echo '_' . $portoname ?>').hide();
                });
            <?php die() ?>
            </script>
            <?php
            $success = true;
        } elseif (false !==
            $themeName = $this->_getSubStringAction($action, 'del_portofolio')) {
            $ajaxResponse = 'Delete permanently';
            $path = UW_PATH . SEP . 'xhtml' . SEP . $themeName;
            $this->_deleteDir($path);

            $success = true;
        }

        if ($success) {
            $ajaxResponse = <<<HTML
<div class="error fade">
    <p>$ajaxResponse</p>
</div>
HTML;
        }
        die($ajaxResponse);

    }

    /**
     * Get Sub string of ajax action
     *
     * @param string $haystack action name
     * @param string $needle   searched action name
     *
     * @return bool|string
     */
    private function _getSubStringAction($haystack, $needle)
    {
        if (false !== strstr($haystack, $needle)) {
            return substr($haystack, strlen($needle) + 1);
        } else {
            return false;
        }

    }

    /**
     * Delteing a path
     *
     * @param string $dir  absolute path
     *
     * @todo buat process deleted na menampilkan informasi file file yg didelete.
     *      Informasi itu ditampilan dgn fadein fade out
     */
    private function _deleteDir($dir) {
        // open the directory
        $dhandle = opendir($dir);

        if ($dhandle) {
            // loop through it
            while (false !== ($fname = readdir($dhandle))) {
                // if the element is a directory, and
                // does not start with a '.' or '..'
                // we call deleteDir function recursively
                // passing this element as a parameter
                if (is_dir("{$dir}/{$fname}")) {
                    if (($fname != '.') && ($fname != '..')) {
//                        echo "<u>Deleting Files in the Directory</u>: {$dir}/{$fname} <br />";
                        $this->_deleteDir("$dir/$fname");
                    }
                    // the element is a file, so we delete it
                } else {
//                    echo "Deleting File: {$dir}/{$fname} <br />";
                    unlink("{$dir}/{$fname}");
                }
            }
            closedir($dhandle);
        }
        // now directory is empty, so we can use
        // the rmdir() function to delete it
//        echo "<u>Deleting Directory</u>: {$dir} <br />";
        rmdir($dir);

    }

}