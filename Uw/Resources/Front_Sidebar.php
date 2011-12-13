<?php
/**
 * Uw Framework
 *
 * PHP version 5
 *
 * Template for default sidebar
 *
 * @category  Uw
 * @package   Resources
 * @author    Aulia Ashari <uwiuw.inlove@gmail.com>
 * @copyright 2011 Outerim Aulia Ashari
 * @license   http://dummylicense/ dummylicense License
 * @version   $SVN: $
 * @link      http://uwiuw.com/outerrim/
 */
?><script type='text/javascript' src='<?php echo $UW_U ?>/wp-includes/js/jquery/jquery.js'></script>
<style type="text/css">
    .<?php echo $cssClass ?> {
        width:100%;height: 0; margin: 0; padding: 0; position: absolute; top: 0; left: 0;
    }
    .<?php echo $cssClass ?> .bottom { top: 108px; margin-top: -108px; clear: both; }
    .<?php echo $cssClass ?> .prev {float: left; margin: 100px 0 0; height: 40px; clear: none;text-align: left }
    .<?php echo $cssClass ?> .next {float: right; margin: 100px 0 0; height: 40px; clear: none;text-align: right }
</style>
<script>
    // once the bloody dom is loaded
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
    h2,h3, form{
        font-size:14px;
    }

    .label, font{
        font-weight:100;
        font-style: inherit;
        font-size: 100%;
        font-family: inherit;
        vertical-align: baseline;
        font-family: "proxima-nova-1", "proxima-nova-2", Tahoma, Helvetica, Verdana, sans-serif;
        font-size: 14px;
        color: #333;
    }
    li, ul, h2,input, #searchform, .Uw_Widget_PortoSearch {
        padding:0;
        margin:0;
        list-style:none;
    }

    .next, .prev {
        padding:0 10px;
        margin:0 10px;
    }
    .textwidget,Uw_Widget_PortoSearch  {
        width:130px;
    }
    #searchform {
        margin-top:10px;
        border:none;
    }
    .Uw_Widget_PortoSearch {
        margin-top:5px;
    }
    #searchAgain {
        height:10px;
        width:100px;
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
