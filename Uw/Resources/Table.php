<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * Template for table
 *
 * @category  Uw
 * @package   Resources
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://wp.uwiuw.com/html-slicer-display/
 */
?>
<div class="ajax_output"></div>
<table class="widefat" cellspacing="0" id="update-themes-table">
    <thead>
        <tr>
            <th scope="col" class="manage-column check-column">
                <input type="checkbox" id="themes-select-all">
            </th>
            <th scope="col" class="manage-column">
                <label for="themes-select-all"><?php echo $headertitle ?></label>
            </th>
            <th scope="col"> <?php echo 'Description' ?></th>
            <th scope="col"> <?php echo 'Action' ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th scope="col" class="manage-column check-column">
                <input type="checkbox" id="themes-select-all-2">
            </th>
            <th scope="col" class="manage-column">
                <label for="themes-select-all-2"><?php echo $footertitle ?></label>
            </th>
            <th scope="col"> <?php echo 'Description' ?></th>
            <th scope="col"> <?php echo 'Action' ?></th>
        </tr>
    </tfoot>
    <tbody <?php echo $in_tbody ?>>
        <?php echo $content ?>
    </tbody>
</table>