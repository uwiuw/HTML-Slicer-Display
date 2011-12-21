<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Theme_Widget
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Theme_Widget_NavLeft
 *
 * Widget for navigate into previous portofolio
 *
 * @category   Uw
 * @package    Uw_Theme_Widget
 * @subpackage Uw_Theme_Widget_NavLeft
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Theme_Widget_NavLeft extends WP_Widget
{

    private $_icon = 'semlabs_arrow_left.png';

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
            'description' => __("Help visitor navigate your previous portofolio")
        );
        parent::__construct('navleft', __('Previous Portofolio'), $widget_ops);

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
        $prevFile = $this->_dataWidget['prevFile'];
        $iconURL = $this->_dataWidget['UW_URL'] . '/Uw/Theme/assets/' . $this->_icon;
        ?>
        <style type="text/css">
            .prev a {
                background: url(<?php echo $iconURL ?>) no-repeat left top;
                display: block; width: 40px; height: 40px;
            }
        </style>
        <div class="Uw_Theme_Widget_NavLeft">
            <a class="prev" href ="<?php echo $prevFile ?>"></a>
        </div>
        <?php
        echo $output;

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