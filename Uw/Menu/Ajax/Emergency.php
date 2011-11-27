<?php

class Uw_Menu_Ajax_Emergency {

    private $config;
    private $action = array(
        'fix_htaccess'
    );

    function __construct(Uw_Config_Data $data) {
        $this->config = &$data;

    }

    function inject() {
        $clsname = $this->config->get('curPageSlug');
        $action = $this->action[0];
        $o = <<<HTML
<script type="text/javascript">
jQuery('#fixhtaccess').click(function() {
jQuery.post(ajaxurl, jQuery('#fixhtaccess').serialize(), function(data) {
jQuery('.haikamu').html(data);
alert('haikamu');
jQuery.print(data);
});
});
</script>
HTML;
        echo $o;

    }

    function fixhtaccess() {
        
    }

}