<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * Template for table body of Slicer page content
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
<tbody <?php echo $tbody_class ?>>
<th scope="row" <?php echo $th_class ?>>
    <input type="checkbox" name="checked[]"
           <?php echo $disabled ?> value="<?php echo $Name ?>">
</th>
<td <?php echo $td_class ?> style="width:100px">
    <?php echo $Img ?>
</td>
<td <?php echo $td_class ?>>
    <?php echo $content ?>
</td>
<td <?php echo $td_class ?> style="width:400px">
    <?php echo $Button ?>
</td>
</tbody>