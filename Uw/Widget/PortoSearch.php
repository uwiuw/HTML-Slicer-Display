<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Widget
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Widget_PortoSearch
 *
 * Widget for searching portofolio
 *
 * @category   Uw
 * @package    Uw_Widget
 * @subpackage Uw_Widget_PortoSearch
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Widget_PortoSearch extends WP_Widget
{

    /**
     * Constractor
     *
     * Method will static call the parent constractor
     *
     * @return void
     */
    function __construct()
    {
        $widget_ops = array('description' => __("Custom Portofolio Search"));
        parent::__construct('search', __('Search Portofolio'), $widget_ops);

    }

    /**
     * Widget
     *
     * @param type $args     handler
     * @param type $instance handler
     *
     * @return void
     */
    function widget($args, $instance)
    {
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

    /**
     * Update
     *
     * @param object $new_instance handler
     * @param object $old_instance handler
     *
     * @return void
     */
    function update($new_instance, $old_instance)
    {

    }

    /**
     * Form
     *
     * @param object $instance handler
     *
     * @return void
     */
    function form($instance)
    {

    }

}
