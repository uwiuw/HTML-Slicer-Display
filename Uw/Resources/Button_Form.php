<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * Template for form with ajax form
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

<form method="<?php $method ?>"
      id="<?php echo $id ?>"
      name="<?php echo $form_id ?>"
      action="<?php echo $action ?>" style="display:none">
    <input type="hidden" name="<?php echo $theme_name ?>" value="<?php echo $id ?>" />
    <input type="hidden" name="action" value="<?php echo $action_value ?>" />
    <input type="submit"
           name="Submit"
           class="button-primary"
           value="<?php echo $submit_title ?>" style="display:none" />
           <?php echo $nonce_field ?>
</form>
<span class="<?php echo $ajax_response_output ?>">
    <a href="#"
       id="<?php echo $button_id ?>"
       class="button-primary"
       style="display:inline-block;margin:5px"><?php echo $submit_title ?></a>
</span>