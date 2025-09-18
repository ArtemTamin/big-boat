<?php
    /*
    # ------------------------------------------------------------------------
    # Extensions for Joomla 3.x
    # ------------------------------------------------------------------------
    # Copyright (C) 2015 standardcompany.ru. All Rights Reserved.
    # @license - PHP files are GNU/GPL V2.
    # Author: standardcompany.ru
    # Websites:  http://standardcompany.ru
    # Date modified: 10/03/2015
    # ------------------------------------------------------------------------
    */

    defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript(JURI::base() . '/modules/mod_simple_countdown/assets/js/timecircles.js');

$style = "
.time_circles {
    position: relative;
    width: 100%;
    height: 100%;
}

.time_circles > div {
    position: absolute;
    text-align: center;
}

.time_circles > div > h4 {
    margin: 0px;
    padding: 0px;
    text-align: center;
    text-transform: uppercase;
}

.time_circles > div > span {
    display: block;
    width: 100%;
    text-align: center;
    font-size: 300%;
    margin-top: 0.4em;
    font-weight: bold;
}";


$document->addStyleDeclaration($style);

if ($params->get('use_circle') == 'false') {
$style_1 = '#DateCountdown' . $module->id . ' canvas {
        opacity: 0!important;
        }';
$document->addStyleDeclaration( $style_1 );
}

if (strlen($params->get('text_color')) != 0) {
$style_2 = '#DateCountdown' . $module->id . ' h4, #DateCountdown' . $module->id . ' span {
        color:' . $params->get('text_color') . ';
        }';
$document->addStyleDeclaration( $style_2 );
}

?>

<div class="text-before-clock">
    <p> <?php echo $params->get('text_before'); ?></p>
</div>
 
<div id="DateCountdown<?php echo $module->id ?>" class="DateCountdown<?php echo $module->id ?>" data-date="<?php echo $params->get('date_countdown'); ?> <?php echo $params->get('set_time'); ?>"></div>


<div id="clock"></div>
<script type="text/javascript">
jQuery("#DateCountdown<?php echo $module->id ?>").TimeCircles({
    "animation": "<?php echo $params->get('type_animation'); ?>",
    "bg_width": <?php echo $params->get('thickness_of_bg'); ?>,
    "fg_width": <?php echo $params->get('thickness_of_cr'); ?>,
    "circle_bg_color": "<?php echo $params->get('circle_bg_color'); ?>",
    "time": {
        "Days": {
            "text": "<?php echo $params->get('time_days'); ?>",
            "color": "<?php echo $params->get('days_bg_color'); ?>",
            "show": <?php echo $params->get('use_days'); ?>
        },
        "Hours": {
            "text": "<?php echo $params->get('time_hours'); ?>",
            "color": "<?php echo $params->get('hours_bg_color'); ?>",
            "show": <?php echo $params->get('use_hours'); ?>
        },
        "Minutes": {
            "text": "<?php echo $params->get('time_minutes'); ?>",
            "color": "<?php echo $params->get('minutes_bg_color'); ?>",
            "show": <?php echo $params->get('use_minutes'); ?>
        },
        "Seconds": {
            "text": "<?php echo $params->get('time_seconds'); ?>",
            "color": "<?php echo $params->get('seconds_bg_color'); ?>",
            "show": <?php echo $params->get('use_seconds'); ?>
        }
    }
});

<?php if ($params->get('use_run_out_time') == 'true') {; ?>
    var time = jQuery("#DateCountdown<?php echo $module->id ?>").TimeCircles().getTime(); 
    if(time <= 0) {
        jQuery("#DateCountdown<?php echo $module->id ?>").TimeCircles().destroy();
        jQuery( "#DateCountdown<?php echo $module->id ?>" ).append( "<h1><?php echo $params->get('run_out_time'); ?></h1>" );

    }
<?php } ?>


</script>

<script>
    jQuery(document).ready(function () {
        if (window.devicePixelRatio > 1) {
        // Output to Canvas, taking into account devices such as iPhone 4 with Retina Display
        var hidefCanvas = jQuery('.DateCountdown<?php echo $module->id ?> canvas')[0];
        var hidefContext = hidefCanvas.getContext('2d');

        if (window.devicePixelRatio) {
            var hidefCanvasWidth = jQuery(hidefCanvas).attr('width');
            var hidefCanvasHeight = jQuery(hidefCanvas).attr('height');
            var hidefCanvasCssWidth = hidefCanvasWidth;
            var hidefCanvasCssHeight = hidefCanvasHeight;

            jQuery(hidefCanvas).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            jQuery(hidefCanvas).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            jQuery(hidefCanvas).css('width', hidefCanvasCssWidth);
            jQuery(hidefCanvas).css('height', hidefCanvasCssHeight);
            hidefContext.scale(window.devicePixelRatio, window.devicePixelRatio);
        }
    }
    });

    jQuery(window).resize(function() { 
        jQuery("#DateCountdown<?php echo $module->id ?>").TimeCircles().rebuild();
        if (window.devicePixelRatio > 1) {
        var hidefCanvas = jQuery('.DateCountdown<?php echo $module->id ?> canvas')[0];
        var hidefContext = hidefCanvas.getContext('2d');

        if (window.devicePixelRatio) {
            var hidefCanvasWidth = jQuery(hidefCanvas).attr('width');
            var hidefCanvasHeight = jQuery(hidefCanvas).attr('height');
            var hidefCanvasCssWidth = hidefCanvasWidth;
            var hidefCanvasCssHeight = hidefCanvasHeight;

            jQuery(hidefCanvas).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            jQuery(hidefCanvas).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            jQuery(hidefCanvas).css('width', hidefCanvasCssWidth);
            jQuery(hidefCanvas).css('height', hidefCanvasCssHeight);
            hidefContext.scale(window.devicePixelRatio, window.devicePixelRatio);
        }
    }


<?php if ($params->get('use_run_out_time') == 'true') {; ?>
    var time = jQuery("#DateCountdown<?php echo $module->id ?>").TimeCircles().getTime(); 
    if(time <= 0) {
        jQuery("#DateCountdown<?php echo $module->id ?>").TimeCircles().destroy();

    }
<?php } ?>

    });


</script>




