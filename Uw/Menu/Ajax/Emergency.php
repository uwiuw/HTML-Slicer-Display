<?php

class Uw_Menu_Ajax_Emergency extends Uw_Menu_Ajax_Abstract {

    protected $config;
    protected $itemArgs = array(
        'fix_htaccess' => array(
            'Name' => 'fix_htaccess',
            'Title' => 'Fixing htaccess',
            'Description' => 'reconfigurate theme rewrite rule (will not change blog permalink)',
            'Ajax' => 'fix_htaccess',
            'Icon' => 'semlabs_terminal.png',
            'form_id' => 'fix_htaccess',
            'button_id' => 'fix_htaccess_url',
            'button_id_output' => 'fix_htaccess_url_output'
        ),
        'test' => array(
            'Name' => 'test',
            'Title' => 'Example Button',
            'Description' => 'Example button of mine ooooh yeah',
            'Ajax' => 'test',
            'Icon' => 'semlabs_page_about.png',
            'form_id' => 'test',
            'button_id' => 'test_url',
            'button_id_output' => 'test_url_output'
        ),
    );

    function getButtons() {
        return $this->itemArgs;

    }

    function doAjaxAction() {
        $action = $_POST['HtmlSlicerDisplay'];
        $ajaxResponse = 'Process is failing for unknown reason';
        if ($action === 'fix_htaccess') {
            $htaccess = new Uw_Module_Htaccess();
            $ajaxResponse = $htaccess->setHtaccessFile();
        }
        ?>
        <script>jQuery('div .update-nag').html('<?php echo $ajaxResponse ?>');</script>
        <?php
        die();

    }

}