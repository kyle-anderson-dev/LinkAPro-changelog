<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/

?>
<?php
$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_shortcode_global_vars('wpdb');

$imgurl = (!empty($service_finder_options['pricing-plans-bg-image']['url'])) ? $service_finder_options['pricing-plans-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['pricing-plans-background-attachment'])) ? esc_html($service_finder_options['pricing-plans-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['pricing-plans-bg-color'])) ? $service_finder_options['pricing-plans-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['pricing-plans-bg-opacity'])) ? $service_finder_options['pricing-plans-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['pricing-plans-left-curve-color'])) ? $service_finder_options['pricing-plans-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['pricing-plans-right-curve-color'])) ? $service_finder_options['pricing-plans-right-curve-color'] : '';

if($a['style'] ==  'no-gap'){
$class1 = 'p-lr15';
$class2 = 'no-col-gap';
}else{
$class1 = '';
$class2 = '';
}

if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-site-pricingtable-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
        <div class="section-head text-center">
            <h2 class="text-white" style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2>
            <?php echo service_finder_title_separator($a['divider-color']); ?>
            <p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p>
        </div>
        <div class="section-content">
            <div class="row equal-col-outer">
                    <?php echo do_shortcode( $content ); ?>
                </div>
        </div>
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-pricingtable-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-pricingtable-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
</section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full bg-white">
            <div class="container">
            
            
            	<div class="section-head text-center">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
                </div>
                    
                <div class="section-content">
                	<div class="pricingtable-row m-b30 '.sanitize_html_class($class1).' '.sanitize_html_class($class2).' equal-col-outer">
					<div class="row" id="sf-pricingtable-wrap">'.do_shortcode( $content ).'</div>
					</div>
                </div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
$html = str_replace('<br />','',$html);
$html = str_replace('<p></p>','',$html);
}
?>
