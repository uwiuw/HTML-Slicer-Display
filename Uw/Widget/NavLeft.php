<?php

class Uw_Widget_NavLeft extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __("Visitor can navigate your previous portofolio"));
        parent::__construct('navleft', __('Navigation Left'), $widget_ops);

    }

    function widget($args, $instance) {
        $prevFile = $this->dataForWidget['prevFile'];
        ?>
        <div class="Uw_Widget_NavLeft"><a href ="<?php echo $prevFile ?>">Prev</a></div>
        <?php
        echo $output;

    }

    function update($new_instance, $old_instance) {
        
    }

    function form($instance) {
        
    }

}