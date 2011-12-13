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
 * @link       http://uwiuw.com/outerrim/
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
            'button_id_output' => 'del_portofolio_output'
        ),
    );

    /**
     * Doing ajax operation and call die. This method will echo result of ajax
     * operation to be retrieve by related method to be process
     *
     * @return void
     */
    function doAjaxAction()
    {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';

        if (false !== $this->_getSubStringAction($action, 'edit_portofolio')) {
            //@todo buat quickedit menu bagi form portofolio
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
        } elseif (false !==
            $themeName = $this->_getSubStringAction($action, 'del_portofolio')) {
            $ajaxResponse = $themeName . ' delete permanently';
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

}