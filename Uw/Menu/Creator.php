<?php

class Uw_Menu_Creator {

    function buildForm(Uw_Menu_Item_Abstract $item) {
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