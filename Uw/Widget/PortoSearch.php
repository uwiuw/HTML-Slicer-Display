<?php

class Uw_Widget_PortoSearch extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __("Custom Portofolio Search"));
        parent::__construct('search', __('Search Portofolio'), $widget_ops);

    }

    function widget($args, $instance) {
        ?>
        <div class="f_related_form">
            <?php
            $theme_url = $this->dataForWidget['UW_URL'];
            $homeurl = home_url();
            $search_query = get_search_query();
            $form = <<<HTML
<form role="search" method="get" id="searchform" action="$homeurl/" >
<label for="searchAgain" class="label">Search Portofolio</label>
    <div class="Uw_Widget_PortoSearch">
            <input id="searchAgain" type="text"  value="$search_query" name="s"  />
            <input value="Go" type="submit" style="display:none"/>
        </div>
</form>
HTML;
            echo $form;
            ?>
        </div><!-- /f_related_form -->
        <?php

    }

    function update($new_instance, $old_instance) {
        
    }

    function form($instance) {
        
    }

}
