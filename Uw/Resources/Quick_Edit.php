<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * Template for quick edit for slicer page
 *
 * @category  Uw
 * @package   Resources
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */
?>
<form method="get" action="">
    <table id="<?php echo $Hidden_ID ?>" style="display: none">
        <tbody id="inlineedit">
            <tr id="inline-edit" class="">
                <td colspan="7" class="colspanchange">
                    <fieldset class="inline-edit-col-left">
                        <div class="inline-edit-col">
                            <h4>Quick Edit</h4>
                            <label>
                                <span class="title">Portofolio</span>
                                <span class="input-text-wrap">
                                    <input type="text"
                                           name="post_title"
                                           class="ptitle"
                                           value="<?php echo $Name ?>" />
                                    <input type="hidden"
                                           name="porto_real_title"
                                           class="ptitle"
                                           value="<?php echo $Name ?>" />
                                </span>
                            </label>
                            <label>
                                <span class="title">Author</span>
                                <span class="input-text-wrap">
                                    <input type="text"
                                           name="porto_author"
                                           value='<?php echo $Author ?>' />
                                           <?php echo $Author ?>
                                </span>
                            </label>
                    </fieldset>
                    <fieldset class="inline-edit-col-left">
                        <label>
                            <span class="title">Description</span>
                            <span class="input-text-wrap">
                                <textarea name="porto_desc"
                                          id="ping_sites"
                                          class="large-text code"
                                          rows="3"><?php echo $Description ?>
                                </textarea>
                            </span>
                        </label>
                    </fieldset>

                    <p class="submit inline-edit-save">
                        <a accesskey="c"
                           id="hiddeneditcancel"
                           href="#"
                           title="Cancel"
                           class="button-secondary cancel alignleft">Cancel</a>
                        <input type="submit"
                               name="bulk_edit"
                               id="bulk_edit"
                               class="button-primary alignright"
                               value="Update" accesskey="s"  />
                        <input type="hidden" name="post_view" value="list" />
                        <input type="hidden" name="screen" value="edit-post" />
                        <span class="error" style="display:none"></span>
                        <br class="clear" />
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</form>