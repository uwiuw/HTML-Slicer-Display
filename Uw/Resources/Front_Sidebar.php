<!-- This code is not part og the the -->
<script type='text/javascript' src='<?php echo $UW_U ?>/wp-includes/js/jquery/jquery.js'></script>
<style type="text/css">
    .<?php echo $cssClass ?> {
        width:100%;height: 0; margin: 0; padding: 0; position: absolute; top: 0; left: 0;
    }
    .<?php echo $cssClass ?> .bottom { top: 108px; margin-top: -108px; clear: both; }
    .<?php echo $cssClass ?> .prev {float: left; margin: 100px 0 0; height: 40px; clear: none;text-align: left }
    .<?php echo $cssClass ?> .next {float: right; margin: 100px 0 0; height: 40px; clear: none;text-align: right }
</style>
<script>
    // once the dom is loaded
    jQuery(document).ready(function(){
        if ( jQuery(".<?php echo $cssClass ?>").length ) {
            jQuery(".<?php echo $cssClass ?>.bottom").remove();
            var navi = jQuery(".<?php echo $cssClass ?>"),
            scrollTop = jQuery(window).scrollTop(),
            lowerBound = navi.parent().height() - 108;
            jQuery(window).scroll(function(){
                scrollTop = jQuery(window).scrollTop();
                lowerBound = navi.parent().height() - 108;
                if ( parseInt(navi.css("top")) <= lowerBound && scrollTop <= lowerBound ) {
                    navi.stop().animate({ top: scrollTop },300);
                } else {
                    navi.stop().animate({ top: lowerBound },300);
                }
            });
        }
    });
</script>
<style type="text/css">
    h2,h3 {
        font-size:14px;
    }
    li, ul, h2 {
        padding:0;
        margin:0;
        list-style:none;
    }

    .next, .prev {
        padding:0 10px;
        margin:0 10px;
    }
    .textwidget {
        width:130px;
    }
</style>
<div class="<?php echo $cssClass ?>">
    <div class="prev" style="left:0">
        <ul>
            <?php echo $navigation_left ?>
        </ul>
    </div>
    <div class="next" style="right:0">
        <ul>
            <?php echo $navigation_right ?>
        </ul>
    </div>
</div>
<!-- End -->
