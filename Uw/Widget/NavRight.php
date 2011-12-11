<?php

class Uw_Widget_NavRight extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __("Visitor can navigate your next portofolio"));
        parent::__construct('navright', __('Navigation Right'), $widget_ops);

    }

    function widget($args, $instance) {
        $nextFile = $this->dataForWidget['nextFile'];
        ?>
        <div class="Uw_Widget_NavRight"><a href ="<?php echo $nextFile ?>">Next</a></div>
        <?php

    }

    function update($new_instance, $old_instance) {
        
    }

    function form($instance) {
        
    }

}