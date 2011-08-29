<?php

class Uw_Menu_Ajax_Emergency extends Uw_Menu_Ajax_Abstract {

    protected $config;
    protected $itemArgs = array(
        'form_id' => 'fix_htaccess',
        'button_id' => 'fix_htaccess_url',
        'button_id_output' => 'fix_htaccess_url_output',
    );

    function inject() {
        $o = $this->html->getButtonAjax(
            $this->itemArgs['button_id'], $this->itemArgs['form_id'], $this->itemArgs['button_id_output']
        );
        $o = '<script type="text/javascript">' . $o . '</script>';
        echo $o;

    }

    function doAjaxAction() {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';
        if ($action === 'fix_htaccess') {
            $htaccess = new Uw_Module_Htaccess();
            $ajaxResponse = $htaccess->setHtaccessFile();
        }
        ?>
        <script>
            jQuery('div .update-nag').html('<?php echo $ajaxResponse ?>');
        </script>

        <?php
        die();

    }

}