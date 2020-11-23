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

$imgurl = (!empty($service_finder_options['features-bg-image']['url'])) ? $service_finder_options['features-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['features-background-attachment'])) ? esc_html($service_finder_options['features-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['features-bg-color'])) ? $service_finder_options['features-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['features-bg-opacity'])) ? $service_finder_options['features-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 

$curveleftcolor = (!empty($service_finder_options['features-left-curve-color'])) ? $service_finder_options['features-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['features-right-curve-color'])) ? $service_finder_options['features-right-curve-color'] : '';
?>
<!-- Featured Providers Outer Start -->
<?php
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full text-center bg-white why-use-sf" style="background:url(<?php echo esc_url($imgurl); ?>) center <?php echo esc_attr($bgattachment); ?> no-repeat;">
  <div class="container">
    <div class="section-head">
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
  <div class="sf-curve-topWrap"><div class="sf-curveTop sf-proFolos-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
  <div class="sf-curve-botWrap"><div class="sf-curveBot sf-proFolos-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
  <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> "></div>
</section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full text-center bg-white why-use-sf " style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
  <div class="container">
    <div class="section-head">
      <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
      '.service_finder_title_separator($a['divider-color']).'
      <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
    </div>
    <div class="section-content">
      <div class="row equal-col-outer">
        '.do_shortcode( $content ).'
      </div>
    </div>
  </div>
</section>';
}
$html = str_replace('<br />','',$html);
$html = str_replace('<br>','',$html);
$html = str_replace('<p></p>','',$html);

?>
<!-- Featured Providers Outer End -->
