<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/
$service_finder_options = get_option('service_finder_options');
?>
<?php 
$imgurl = (!empty($service_finder_options['why-choose-us-bg-image']['url'])) ? $service_finder_options['why-choose-us-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['why-choose-us-background-attachment'])) ? esc_html($service_finder_options['why-choose-us-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['why-choose-us-bg-color'])) ? $service_finder_options['why-choose-us-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['why-choose-us-bg-opacity'])) ? $service_finder_options['why-choose-us-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['why-choose-us-left-curve-color'])) ? $service_finder_options['why-choose-us-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['why-choose-us-right-curve-color'])) ? $service_finder_options['why-choose-us-right-curve-color'] : '';
?>
<?php
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full text-center sf-whyChoos-wrap" style="background-image:url(<?php echo esc_url($imgurl) ?>); background-attachment: <?php echo esc_attr($bgattachment); ?>">
    <div class="container">
    
        <div class="section-head w-t-element">
            <h2 class="text-white" style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2>
            <?php echo service_finder_title_separator($a['divider-color']); ?>
            <p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p>
        </div>
            
        <div class="section-content">
            <div class="row">
                
                <?php echo do_shortcode( $content ); ?>
                
            </div>
        </div>
        
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-whyChoos-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-whyChoos-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
</section>
<?php
$html = ob_get_clean();

}else{
$html = '<section class="section-full sf-overlay-wrapper text-center" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            
            	<div class="section-head w-t-element">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
                </div>
                    
                <div class="section-content">
                    <div class="row">
                        '.do_shortcode( $content ).'
                    </div>
                </div>
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
}		
?>

