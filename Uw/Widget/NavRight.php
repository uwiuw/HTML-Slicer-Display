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
 * Uw_Widget_EmptyWidget
 *
 * Widget for navigate into next portofolio
 *
 * @category   Uw
 * @package    Uw_Widget
 * @subpackage Uw_Widget_NavRight
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Widget_NavRight extends WP_Widget
{

    private $_icon = 'semlabs_arrow_right.png';

    /**
     * Constractor
     *
     * Method will static call the parent constractor
     *
     * @return void
     */
    function __construct()
    {
        $widget_ops = array(
            'description' => __("Help visitor navigate your next portofolio")
        );
        parent::__construct('navright', __('Next Portofolio'), $widget_ops);

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
        $nextFile = $this->_dataWidget['nextFile'];
        $iconURL = $this->_dataWidget['UW_URL'] . '/assets/' . $this->_icon;

        ?>
        <style type="text/css">
            .next a {
                background: url(<?php echo $iconURL ?>) no-repeat  right top;
                display: block; width: 40px; height: 40px;
            }
        </style>
        <div class="Uw_Widget_NavRight">
            <a class="next" href="<?php echo $nextFile ?>"></a>
        </div>
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