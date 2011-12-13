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
 * @link      http://uwiuw.com/outerrim/
 */

/**
 * Uw_Widget_EmptyWidget
 *
 * Empty Widget
 *
 * @category   Uw
 * @package    Uw_Widget
 * @subpackage Uw_Widget_EmptyWidget
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://uwiuw.com/outerrim/
 * @since      3.0.3
 */
class Uw_Widget_EmptyWidget extends WP_Widget
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
        $widget_ops = array('description' => __("To create profile-like front end"));
        parent::__construct('emptywidget', __('EmptyWidget'), $widget_ops);

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
        echo "<div><!-- Uw_Widget_EmptyWidget --></div>";

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