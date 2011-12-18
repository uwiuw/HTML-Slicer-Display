<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * @category  Uw
 * @package   Uw_Menu
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */

/**
 * Uw_Menu_Creator
 *
 * Creator of page backend page
 *
 * @category   Uw
 * @package    Uw_Menu
 * @subpackage Uw_Menu_Creator
 * @author     Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright  2011 Outerim Aulia Ashari
 * @license    http://dummylicense/ dummylicense License
 * @version    Release: @package_version@
 * @link       http://wp.uwiuw.com/html-slicer-display/
 * @since      3.0.3
 */
class Uw_Menu_Creator
{

    /**
     * Build backend Html Page
     *
     * Will be called from outside theme
     *
     * @param Uw_Menu_Item_Abstract $item handler of class in Uw/Menu/Item
     *
     * @return void
     * @todo covert html to templaty way. and maybe just delete this class if no
     * longer need
     */
    public function buildForm(Uw_Menu_Item_Abstract $item)
    {
        ?>
        <div id="wpbody-content">
            <div class="wrap">
                <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
                <?php echo $item->createTabNav(); ?>
                <p><?php echo $item->description; ?></p>
                <?php echo $item->content; ?>
                <div class="clear"></div>
            </div>
        </div>
        <?php

    }

}