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
?>
<!-- Who's on sf  -->
<?php 
if($a['btntext'] != "" && service_finder_getUserRole($current_user->ID) == 'Provider'){
	$url = add_query_arg( array('tabname' => 'my-services'), service_finder_get_url_by_shortcode('[service_finder_my_account') );
  	$btnlink = '<a href="'.esc_url($url).'" class="btn btn-primary">'.esc_html($a['btntext']).'</a>';
}else{
	$btnlink = '';
}

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
?>
<!-- Who's on sf END -->
