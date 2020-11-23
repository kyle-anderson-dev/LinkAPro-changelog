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

$imgurl = (!empty($service_finder_options['jobs-bg-image']['url'])) ? $service_finder_options['jobs-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['jobs-background-attachment'])) ? esc_html($service_finder_options['jobs-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['jobs-bg-color'])) ? $service_finder_options['jobs-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['jobs-bg-opacity'])) ? $service_finder_options['jobs-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['jobs-left-curve-color'])) ? $service_finder_options['jobs-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['jobs-right-curve-color'])) ? $service_finder_options['jobs-right-curve-color'] : '';

$title = (!empty($service_finder_options['shortcode-jobs-title'])) ? esc_html($service_finder_options['shortcode-jobs-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-jobs-tagline'])) ? wp_kses_post($service_finder_options['shortcode-jobs-tagline']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-jobs-title-color'])) ? esc_html($service_finder_options['shortcode-jobs-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-jobs-tagline-color'])) ? esc_html($service_finder_options['shortcode-jobs-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-jobs-divider-color'])) ? esc_html($service_finder_options['shortcode-jobs-divider-color']) : '';

if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-postJobs-wrap" style="background-image:url(<?php echo esc_url($imgurl) ?>); background-attachment: <?php echo esc_attr($bgattachment); ?>">
            <div class="container">
            	<div class="section-head text-center">
                    <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
					<?php echo service_finder_title_separator($dividercolor); ?>
                    <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
                </div>
                <div class="section-content">
                    <?php echo do_shortcode( $content ); ?>
                </div>
            </div>
            <div class="sf-curve-topWrap"><div class="sf-curveTop sf-postJobs-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
            <div class="sf-curve-botWrap"><div class="sf-curveBot sf-postJobs-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
            <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
        </section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full latest-blog" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            
            
            	<div class="section-head text-center">
                    <h2 style="color:'.$titlecolor.'">'.esc_html($title).'</h2>
					'.service_finder_title_separator($dividercolor).'
					<div class="sf-tagile-outer" style="color:'.esc_attr($taglinecolor).'">'.wp_kses_post($tagline).'</div>
                </div>
                    
                <div class="section-content">
                	'.do_shortcode( $content ).'
                </div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
}
?>

