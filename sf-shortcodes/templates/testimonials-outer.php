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
<!-- Testimonials Outer Template-->
<?php
$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_shortcode_global_vars('wpdb');

$imgurl = (!empty($service_finder_options['testimonials-bg-image']['url'])) ? $service_finder_options['testimonials-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['testimonials-background-attachment'])) ? esc_html($service_finder_options['testimonials-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['testimonials-bg-color'])) ? $service_finder_options['testimonials-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['testimonials-bg-opacity'])) ? $service_finder_options['testimonials-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['testimonials-left-curve-color'])) ? $service_finder_options['testimonials-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['testimonials-right-curve-color'])) ? $service_finder_options['testimonials-right-curve-color'] : '';

if(service_finder_themestyle_for_plugin() == 'style-2'){

$html = '<section class="section-full bg-gray sf-testimonials"  style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            
            	<div class="section-head text-center">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p >
                </div>
                    
                <div class="section-content">
                    <div class="section-content">
                      <div class="owl-testimonials">'.do_shortcode( $content ).'</div>
                </div>
                </div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
}elseif(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-testimonials-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
        <div class="section-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="sf-testimonials-left">
                                <div class="sf-testimonials-title"><h2 style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2></div>
                                <div class="sf-testimonials-text"><p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p></div>                                     
                                </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="owl-carousel testimonial-two">
                                <?php echo do_shortcode( $content ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-testimo-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-testimo-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
</section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full bg-gray sf-testimonials"  style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
  <div class="container">
    <div class="section-head text-center ">
      <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
      '.service_finder_title_separator($a['divider-color']).'
      <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p >
    </div>
    <div class="section-content">
      <div class="section-content">
        <div class="owl-carousel">'.do_shortcode( $content ).'</div>
      </div>
    </div>
  </div>
  <div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
</section>';
}
$html = str_replace('<br />','',$html);
$html = str_replace('<p>','',$html);
$html = str_replace('</p>','',$html);

?>
<!-- Testimonials Outer Template-->
