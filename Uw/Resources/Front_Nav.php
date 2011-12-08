<!-- This code is not part of the the -->
<script type='text/javascript' src='<?php echo UW_U ?>/wp-includes/js/jquery/jquery.js'></script>
<style type="text/css">
    .<?php echo $cssClass ?> {width: 98%; height: 0; margin: 0; padding: 0; position: absolute; top: 0; left: 0;background-color:#fff }
    .<?php echo $cssClass ?> .bottom { top: 100%; margin-top: -108px; clear: both; }
    .<?php echo $cssClass ?> .prev { float: left; text-indent: -9999px; margin: 100px 0 0; width: 40px; height: 40px; clear: none; }
    .<?php echo $cssClass ?> .next { float: right; text-indent: -9999px; margin: 100px 0 0; width: 40px; height: 40px; text-align: left; clear: none; }
    .<?php echo $cssClass ?> .prev a,
    .<?php echo $cssClass ?> .next a { display: block; width: 40px; height: 40px; }
    .<?php echo $cssClass ?> .prev a { background: url(<?php echo $UW_URL ?>/assets/semlabs_arrow_left.png) no-repeat left top; }
    .<?php echo $cssClass ?> .next a { background: url(<?php echo $UW_URL ?>/assets/semlabs_arrow_right.png) no-repeat right top; }
    .<?php echo $cssClass ?> .prev a:hover { background: url(<?php echo $UW_URL ?>/assets/semlabs_arrow_left.png) no-repeat left bottom; }
    .<?php echo $cssClass ?> .next a:hover { background: url(<?php echo $UW_URL ?>/assets/semlabs_arrow_right.png) no-repeat right bottom; }
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
<div class="<?php echo $cssClass ?>">
    <div class="prev"><a href ="<?php echo $prevFile ?>">Prev</a></div>
    <div class="next"><a href ="<?php echo $nextFile ?>">Next</a></div>
</div>
<!-- End -->