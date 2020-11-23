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
$imgurl = (!empty($service_finder_options['statistics-bg-image']['url'])) ? $service_finder_options['statistics-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['statistics-background-attachment'])) ? esc_html($service_finder_options['statistics-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['statistics-bg-color'])) ? $service_finder_options['statistics-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['statistics-bg-opacity'])) ? $service_finder_options['statistics-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['statistics-left-curve-color'])) ? $service_finder_options['statistics-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['statistics-right-curve-color'])) ? $service_finder_options['statistics-right-curve-color'] : '';

if(service_finder_themestyle_for_plugin() == 'style-3')
{
ob_start();
?>
<section class="section-full bg-gray sf-trustedBy-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
        <div class="section-head text-center">
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
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-trustedBy-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-trustedBy-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> "> 
</section>
<?php
$html = ob_get_clean(); 
}else{
$html = '<section class="section-full bg-primary" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            	
                <div class="row equal-col-outer">
                    
                    '.do_shortcode( $content ).'
                    
                </div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
$html = str_replace('<br />','',$html);
$html = str_replace('<p></p>','',$html);
}
?>

