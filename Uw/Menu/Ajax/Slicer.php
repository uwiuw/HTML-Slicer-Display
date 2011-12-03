<?php

class Uw_Menu_Ajax_Slicer extends Uw_Menu_Ajax_Abstract {

    protected $config;
    protected $itemArgs = array(
        'edit_portofolio' => array(
            'Name' => 'edit_portofolio',
            'Title' => 'Edit',
            'Description' => '',
            'Ajax' => 'edit_portofolio',
            'Icon' => 'semlabs_terminal.png',
            'form_id' => 'edit_portofolio',
            'button_id' => 'edit_portofolio_url',
            'button_id_output' => 'edit_portofolio_url_output'
        ),
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

    function doAjaxAction() {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';
        if ($action === 'edit_portofolio') {
            //@todo buat quickedit menu bagi form portofolio
            $ajaxResponse = 'Portofolio on editing mode';
            ?>
            <script>
                String.prototype.trim = function () {
                    return this.replace(/^\s*/, "").replace(/\s*$/, "");
                }
                var htmlStr = jQuery('.update-nag').html();
                htmlStr.trim();
                if (htmlStr == '<?php echo $ajaxResponse ?>' ) {
                    jQuery('#hiddenedit').toggle();
                    jQuery('.update-nag').html('<?php echo $ajaxResponse ?>');
                } else {
                    jQuery('#hiddenedit').toggle();
                    jQuery('.update-nag').html('Editiong on Quick Mode');
                }
                jQuery('#hiddeneditcancel').click(function () {
                    jQuery('#hiddenedit').hide(); //hiding cancel button
                });
            <?php die() ?>
            </script>
            <?php
        } elseif ($action === 'del_portofolio') {
            $ajaxResponse = 'Portofolio delete permanently';
        }

        die($ajaxResponse);

    }

}