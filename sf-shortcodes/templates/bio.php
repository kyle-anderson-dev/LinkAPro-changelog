<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/
global $current_user;
$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_shortcode_global_vars('wpdb');
?>
<?php 
$imgurl = (!empty($service_finder_options['bio-bg-image']['url'])) ? $service_finder_options['bio-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['bio-background-attachment'])) ? esc_html($service_finder_options['bio-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['bio-bg-color'])) ? $service_finder_options['bio-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['bio-bg-opacity'])) ? $service_finder_options['bio-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 

$curveleftcolor = (!empty($service_finder_options['bio-left-curve-color'])) ? $service_finder_options['bio-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['bio-right-curve-color'])) ? $service_finder_options['bio-right-curve-color'] : '';
?>
<!-- Who's on sf  -->
<?php 
if($a['btntext'] != "" && service_finder_getUserRole($current_user->ID) == 'Provider'){
	$url = add_query_arg( array('tabname' => 'my-services'), service_finder_get_url_by_shortcode('[service_finder_my_account') );
  	$btnlink = '<a href="'.esc_url($url).'" class="btn btn-primary">'.esc_html($a['btntext']).'</a>';
}else{
	$btnlink = '';
}

if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-overlay-wrapper text-center who-fs-com" style="background:url(<?php echo esc_url($imgurl); ?>) center <?php echo esc_attr($bgattachment); ?> no-repeat;">
		  <div class="container">
			<div class="section-head">
                <h2 class="text-white" style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2>
                <?php echo service_finder_title_separator($a['divider-color']); ?>
                <p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p>
            </div>
			<div class="section-content sf-about-text">
			  <div class="row">
				<div class="col-md-12">
				  <p> <em><?php echo do_shortcode( $content ); ?></em> </p>
				  <?php echo wp_kses_post($btnlink); ?>
				</div>
			  </div>
			</div>
		  </div>
		  
          <div class="sf-curve-topWrap"><div class="sf-curveTop sf-howitwork-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
        <div class="sf-curve-botWrap"><div class="sf-curveBot sf-howitwork-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
        <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> "></div>
		</section>
<?php
$html = ob_get_clean();		
}else{
$html = '<section class="section-full sf-overlay-wrapper text-center who-fs-com" style="background:url('.$imgurl.') center '.$bgattachment.' no-repeat;">
		  <div class="container">
			<div class="section-head w-t-element">
			  <h1 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h1>
			 '.service_finder_title_separator($a['divider-color']).'
			  <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
			</div>
			<div class="section-content sf-about-text">
			  <div class="row">
				<div class="col-md-12">
				  <p> <em>'.$content.'</em> </p>
				  '.$btnlink.'
				</div>
			  </div>
			</div>
		  </div>
		  <div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
		  </div>
		</section>';
}
?>
<!-- Who's on sf END -->
