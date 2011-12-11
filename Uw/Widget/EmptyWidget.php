<?php

class Uw_Widget_EmptyWidget extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __("Empty widget to create profile like on your front end"));
        parent::__construct('emptywidget', __('EmptyWidget'), $widget_ops);

    }

    function widget($args, $instance) {
        echo "<div><!-- Uw_Widget_EmptyWidget --></div>";

    }

    function update($new_instance, $old_instance) {

    }

    function form($instance) {

    }

}