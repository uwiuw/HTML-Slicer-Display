<?php

class Uw_Menu_Ajax_Slicer extends Uw_Menu_Ajax_Abstract {

    protected $config;
    protected $itemArgs = array(
//        'edit_portofolio' => array(
//            'Name' => 'edit_portofolio',
//            'Title' => 'Edit',
//            'Description' => '',
//            'Ajax' => 'edit_portofolio',
//            'Icon' => 'semlabs_terminal.png',
//            'form_id' => 'edit_portofolio',
//            'button_id' => 'edit_portofolio_url',
//            'button_id_output' => 'edit_portofolio_url_output'
//        ),
        'del_portofolio' => array(
            'Name' => 'del_portofolio',
            'Title' => 'Delete',
            'Description' => '',
            'Ajax' => 'del_portofolio',
            'Icon' => 'semlabs_arrow_circle_right.png',
            'form_id' => 'del_portofolio',
            'button_id' => 'del_portofolio_url',
            'button_id_output' => 'del_portofolio_output'
        ),
    );

    /**
     * Method to process current ajax action
     */
    function doAjaxAction() {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';

        if (false !== $this->_getThisAjaxAction($action, 'edit_portofolio')) {
            //@todo buat quickedit menu bagi form portofolio
            $ajaxResponse = 'Portofolio on editing mode';
            $portoname = $_POST['action'];
            ?>
            <script>
                String.prototype.trim = function () {
                    return this.replace(/^\s*/, "").replace(/\s*$/, "");
                }
                var htmlStr = jQuery('.ajax_reponse_output').html();
                htmlStr.trim();
                if (htmlStr == '<?php echo $ajaxResponse ?>' ) {
                    jQuery('#hiddenedit<?php echo '_' . $portoname ?>').toggle();
                    jQuery('.ajax_reponse_output').html('<?php echo $ajaxResponse ?>');
                } else {
                    jQuery('#hiddenedit<?php echo '_' . $portoname ?>').toggle();
                    jQuery('.ajax_reponse_output').html('Editiong on Quick Mode');
                }
                jQuery('#hiddeneditcancel').click(function () {
                    jQuery('#hiddenedit<?php echo '_' . $portoname ?>').hide(); //hiding cancel button
                });
            <?php die() ?>
            </script>
            <?php
        } elseif (false !== $themeName = $this->_getThisAjaxAction($action, 'del_portofolio')) {
            $ajaxResponse = $themeName . ' delete permanently';
        }

        die($ajaxResponse);

    }

    private function _getThisAjaxAction($haystack, $needle) {

        if (False !== strstr($haystack, $needle)) {
            return substr($haystack, strlen($needle) + 1);
        } else {
            return false;
        }

    }

}