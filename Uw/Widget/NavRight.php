<?php

class Uw_Widget_NavRight extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __("Visitor can navigate your next portofolio"));
        parent::__construct('navright', __('Navigation Right'), $widget_ops);

    }

    function widget($args, $instance) {
        $nextFile = $this->dataForWidget['nextFile'];
        $UW_URL = $this->dataForWidget['UW_URL'];
        ?>
        <style type="text/css">
            .next a {
                background: url(<?php echo $UW_URL ?>/assets/semlabs_arrow_right.png) no-repeat  right top;
                display: block; width: 40px; height: 40px;                
            }
        </style>
        <div class="Uw_Widget_NavRight">
            <a class="next" href="<?php echo $nextFile ?>"></a>
        </div>
        <?php

    }

    function update($new_instance, $old_instance) {

    }

    function form($instance) {

    }

}