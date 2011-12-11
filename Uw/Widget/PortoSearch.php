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
            $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
                        <fieldset>
                        <label for="searchAgain">Search site</label>
                        <div class="f_related_form_content">
                        <span class="text">
                        <input id="searchAgain" type="text"  value="' . get_search_query() . '" name="s"  />
                        </span>
                    <span class="submit">
                    <input value="Go" type="submit" />
                    </span>
                    </div>
                    </fieldset>
                    </form>';

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
