<?php

class Uw_Widget_NavLeft extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __("Visitor can navigate your previous portofolio"));
        parent::__construct('navleft', __('Navigation Left'), $widget_ops);

    }

    function widget($args, $instance) {
        $prevFile = $this->dataForWidget['prevFile'];
        $UW_URL = $this->dataForWidget['UW_URL'];
        ?>
        <style type="text/css">
            .prev a {
                background: url(<?php echo $UW_URL ?>/assets/semlabs_arrow_left.png) no-repeat left top;
                display: block; width: 40px; height: 40px;                
            }
        </style>
        <div class="Uw_Widget_NavLeft">
            <a class="prev" href ="<?php echo $prevFile ?>"></a>
        </div>
        <?php
        echo $output;

    }

    function update($new_instance, $old_instance) {
        
    }

    function form($instance) {
        
    }

}