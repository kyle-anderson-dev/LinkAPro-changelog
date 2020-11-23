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
$wpdb = service_finder_shortcode_global_vars('wpdb');
$service_finder_Tables = service_finder_shortcode_global_vars('service_finder_Tables');
$current_user = wp_get_current_user(); 
?>
<!-- Featured Providers  -->
          <?php
		  $html = '';
		  $innerhtml = '';
		  
				$limit = $a['numberofproviders'];
				$showitem = $a['showitem'];
				$categoryid = ($a['categoryid'] != "" && $a['categoryid'] > 0) ? $a['categoryid'] : 0;
				
				wp_add_inline_script( 'service_finder-js-custom', 'var showfeatureditem = "'.$showitem.'";', 'before' );
				
                $providers = service_finder_getFeaturedProviders($limit,$categoryid);
				$totalproviders = count($providers);
				$k = 0;
				$m = 1;
				//print_r($providers);
				if(!empty($providers)){
					foreach($providers as $provider){
					$subinner = '';
					$addressbox = '';
					$userLink = service_finder_get_author_url($provider->provider_id);

					if(!empty($provider->avatar_id) && $provider->avatar_id > 0){
						$src  = wp_get_attachment_image_src( $provider->avatar_id, 'service_finder-featured-provider' );
						$src  = $src[0];
					}else{
						$src  = service_finder_get_default_avatar();
					}
					
					$chkclass = '';
					$prometa = '';
					if(class_exists('service_finder_booking_plugin')){
					$chkclass = service_finder_check_varified($provider->provider_id);
					
					$prometa = service_finder_show_provider_meta($provider->provider_id,$provider->phone,$provider->mobile);
					$prometa .= service_finder_check_varified_icon($provider->provider_id);
					$prometa .= service_finder_displayRating(service_finder_getAverageRating($provider->provider_id));
					}
					
					$link = $userLink;
					
							if(is_user_logged_in()){
								if($wpdb->get_var("SHOW TABLES LIKE '".$service_finder_Tables->favorites."'") == $service_finder_Tables->favorites) {
								$myfav = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$service_finder_Tables->favorites.' where user_id = %d AND provider_id = %d',$current_user->ID, $provider->provider_id));
								
								if(!empty($myfav)){
								$subinner .= '<a href="javascript:;" class="remove-favorite btn btn-primary" data-proid="'.esc_attr($provider->provider_id).'" data-userid="'.esc_attr($current_user->ID).'">'.esc_html__( 'My Favorite', 'service-finder' ).'<i class="fa fa-heart"></i></a>';
								}else{
								$subinner .= '<a href="javascript:;" class="add-favorite btn btn-primary" data-proid="'.esc_attr($provider->provider_id).'" data-userid="'.esc_attr($current_user->ID).'">'.esc_html__( 'Add to Fav', 'service-finder' ).'<i class="fa fa-heart"></i></a>';
								}
								}
							}else{
								$subinner .= '<a class="btn btn-primary" href="javascript:;" data-action="login" data-redirect="no" data-toggle="modal" data-target="#login-Modal">'.esc_html__( 'Add to Fav', 'service-finder' ).'<i class="fa fa-heart"></i></a>';
							}
							
							$showaddressinfo = (isset($service_finder_options['show-address-info'])) ? esc_attr($service_finder_options['show-address-info']) : '';
							
							if($showaddressinfo && $service_finder_options['show-postal-address']){
								$addressbox = '<div class="overlay-text">
                    <div class="sf-address-bx"> <i class="fa fa-map-marker"></i> '.service_finder_getshortAddress($provider->provider_id).'</div>
                  </div>';
							}
					
					if(service_finder_themestyle_for_plugin() == 'style-2'){
					$current_user = wp_get_current_user();         
					$addtofavorite = '';
					if($service_finder_options['add-to-fav']){
						if(is_user_logged_in()){
						$myfav = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$service_finder_Tables->favorites.' where user_id = %d AND provider_id = %d',$current_user->ID,$provider->provider_id));
						
						if(!empty($myfav)){
						$addtofavorite = '<a href="javascript:;" class="remove-favorite sf-featured-item" data-proid="'.esc_attr($provider->provider_id).'" data-userid="'.esc_attr($current_user->ID).'"><i class="fa fa-heart"></i></a>';
						}else{
						$addtofavorite = '<a href="javascript:;" class="add-favorite sf-featured-item" data-proid="'.esc_attr($provider->provider_id).'" data-userid="'.esc_attr($current_user->ID).'"><i class="fa fa-heart-o"></i></a>';
						}
					}else{
						$addtofavorite = '<a class="sf-featured-item" href="javascript:;" data-action="login" data-redirect="no" data-toggle="modal" data-target="#login-Modal"><i class="fa fa-heart-o"></i></a>';
					}
					}
					$addressbox = service_finder_getshortAddress($provider->provider_id);
					$innerhtml .= '<div class="sf-featured-girds item" id="proid-'.esc_attr($provider->provider_id).'">
						<div class="sf-featured-top">
                                    <div class="sf-featured-media" style="background-image:url('.esc_url($src).')"></div>
                                    <div class="sf-overlay-box"></div>
                                    '.service_finder_display_category_label($provider->provider_id).'
                                    '.service_finder_check_varified_icon($provider->provider_id).'
									'.$addtofavorite.'
                                    
                                    <div class="sf-featured-info">
                                        <div  class="sf-featured-sign">'.esc_html__( 'Featured', 'service-finder' ).'</div>
                                        <div  class="sf-featured-provider">'.esc_html($provider->full_name).'</div>
                                        <div  class="sf-featured-address"><i class="fa fa-map-marker"></i> '.$addressbox.' </div>
                                        '.service_finder_displayRating(service_finder_getAverageRating($provider->provider_id)).'
                                    </div>
									<a href="'.esc_url($link).'" class="sf-profile-link"></a>
                                </div>
                                
                                <div class="sf-featured-bot">
                                    <div class="sf-featured-comapny">'.service_finder_getExcerpts(service_finder_getCompanyName($provider->provider_id),0,30).'</div>
                                    <div class="sf-featured-text">'.service_finder_getExcerpts(nl2br(stripcslashes($provider->bio)),0,130).'</div>
                                    '.service_finder_show_provider_meta($provider->provider_id,$provider->phone,$provider->mobile).'
                                </div>
					  </div>';
					}elseif(service_finder_themestyle_for_plugin() == 'style-3'){
					ob_start();
					$current_user = wp_get_current_user();         
					$addtofavorite = '';
					if($service_finder_options['add-to-fav']){
						
						if(is_user_logged_in()){
							$myfav = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$service_finder_Tables->favorites.' where user_id = %d AND provider_id = %d',$current_user->ID,$provider->provider_id));
							if(!empty($myfav)){
								$addtofavorite = '<span id="favproid-'.esc_attr($provider->provider_id).'" class="sf-feaProgrid-icon sfp-blue removefromfavorite" data-proid="'.esc_attr($provider->provider_id).'" data-userid="'.esc_attr($current_user->ID).'"><span class="sf-feaPro-tooltip">'.esc_html__('My Favorite', 'service-finder').'</span><i class="fa fa-heart"></i></span>';
								}else{
								$addtofavorite = '<span id="favproid-'.esc_attr($provider->provider_id).'" class="sf-feaProgrid-icon sfp-blue addtofavorite" data-proid="'.esc_attr($provider->provider_id).'" data-userid="'.esc_attr($current_user->ID).'"><span class="sf-feaPro-tooltip">'.esc_html__('Add to Favorites', 'service-finder').'</span><i class="sl-icon-heart"></i></span>';
								}
							}else{
								$addtofavorite = '<span id="favproid-'.esc_attr($provider->provider_id).'" class="sf-feaProgrid-icon sfp-blue" data-action="login" data-redirect="no" data-toggle="modal" data-target="#login-Modal"><span class="sf-feaPro-tooltip">'.esc_html__('Add to Favorites', 'service-finder').'</span><i class="sl-icon-heart"></i></span>';
							}
					}
					?>
					<?php if($k %2 == 0){ ?>
					<div class="item">
                    <?php } ?>
                    <?php
					$iconbox = 1;
					if($service_finder_options['review-system']){
						$iconbox++;
					}
					if($service_finder_options['request-quote'] && service_finder_request_quote_for_loggedin_user()){
						$iconbox++;
					}
					if($service_finder_options['add-to-fav']){
						$iconbox++;
					}
					?>
                      <div id="proid-<?php echo esc_attr($provider->provider_id) ?>">		
                      <div class="sf-feaProvideer-wrap clearfix">
                        <div class="sf-feaProvideer-label"><?php echo esc_html__('Featured','service-finder'); ?></div>
                        <div class="sf-feaProvideer-pic">
                        <img src="<?php echo esc_url($src); ?>" alt="">
                        <?php if(service_finder_is_varified_user($provider->provider_id)){ ?>
                        <span class="sf-featured-approve">
                            <i class="fa fa-check"></i><span><?php esc_html_e('Verified Provider', 'service-finder'); ?></span>
                        </span>
                        <?php } ?>
                        </div>
                        <div class="sf-feaProvideer-info">
                          <?php echo service_finder_displayRating(service_finder_getAverageRating($provider->provider_id)); ?>  
                          <h4 class="sf-feaProvideer-title"><?php echo esc_html($provider->full_name); ?></h4>
                          <?php
						  if($showaddressinfo && $service_finder_options['show-postal-address']){
						  echo '<div class="sf-feaProvideer-address">'.service_finder_getshortAddress($provider->provider_id).'</div>';
				  		  }
						  ?>
                          <?php echo service_finder_display_category_label($provider->provider_id); ?>
                          <div class="sf-feaProvideer-text"><?php echo service_finder_getExcerpts(nl2br(stripcslashes($provider->bio)),0,130); ?></div>
                        </div>
                        <div class="sf-feaProvideer-iconwrap sf-iconbox-cnt-<?php echo esc_attr($iconbox); ?>">
                        	<?php
							echo '<span class="sf-feaProvideer-icon sfp-yellow sf-services-slider-btn" data-providerid="'.$provider->provider_id.'"><span class="sf-feaPro-tooltip">'.esc_html__('Display Services','service-finder').'</span><i class="sl-icon-settings"></i></span>';

							if($service_finder_options['review-system']){
							$reviewcount = show_review_at_search_result($provider->provider_id);
							echo '<span class="sf-feaProvideer-icon sfp-perple"><span class="sf-feaPro-tooltip">'.$reviewcount.' '.esc_html__('Comment','service-finder').'</span><i class="sl-icon-speech"></i></span>';
							}
							
							$requestquote = (!empty($service_finder_options['requestquote-replace-string'])) ? esc_attr($service_finder_options['requestquote-replace-string']) : esc_html__( 'Request a Quote', 'service-finder' );
	
							if($service_finder_options['request-quote'] && service_finder_request_quote_for_loggedin_user()){
							echo '<span class="sf-feaProvideer-icon sfp-green" data-providerid="'.$provider->provider_id.'" data-tool="tooltip" data-toggle="modal" data-target="#quotes-Modal"><span class="sf-feaPro-tooltip">'.esc_html__('Request Quote','service-finder').'</span><i class="sl-icon-doc"></i></span>';
							}
							?>
                            
                            
                            <?php
                            echo wp_kses_post($addtofavorite); 
							?>
                        </div>
                        <a href="<?php echo esc_url($link); ?>" class="sf-profile-link"></a>
                      </div>
                      </div>
                    <?php if($m %2 == 0 || $m == $totalproviders){ ?>
                    </div>
                    <?php } ?>
					<?php
					$innerhtml .= ob_get_clean();
					}else{
					$innerhtml .= '<div class="sf-featured-bx item">
						<div class="sf-element-bx">
						  <div class="sf-thum-bx sf-featured-thum img-effect2" style="background-image:url('.esc_url($src).');"> <a class="sf-featured-link" href="'.esc_url($link).'"></a>
							<div class="overlay-bx">
							  '.$addressbox.'
							</div>
							'.service_finder_get_primary_category_tag($provider->provider_id).' </div>
						  <div class="padding-20 bg-white '.$chkclass.'">
							<h4 class="sf-title">'.service_finder_getExcerpts(service_finder_getCompanyName($provider->provider_id),0,30).'</h4>
							<p>'.service_finder_getExcerpts(strip_tags($provider->bio),0,130).'</p>
							<strong class="sf-company-name"><a href="'.esc_url($link).'">'.esc_html($provider->full_name).'</a></strong> '.$prometa.'</div>
						  <div class="btn-group-justified" id="proid-'.esc_attr($provider->provider_id).'"> <a href="'.esc_url($link).'" class="btn btn-custom">'.esc_html__('Full View', 'service-finder').'<i class="fa fa-arrow-circle-o-right"></i></a>
							'.$subinner.'
						  </div>
						</div>
					  </div>';
					  }
					  $k++;
					  $m++;
					}
				}
				?>
<?php
$imgurl = (!empty($service_finder_options['featured-providers-bg-image']['url'])) ? $service_finder_options['featured-providers-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['featured-providers-background-attachment'])) ? esc_html($service_finder_options['featured-providers-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['featured-providers-bg-color'])) ? $service_finder_options['featured-providers-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['featured-providers-bg-opacity'])) ? $service_finder_options['featured-providers-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['featured-providers-left-curve-color'])) ? $service_finder_options['featured-providers-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['featured-providers-right-curve-color'])) ? $service_finder_options['featured-providers-right-curve-color'] : '';

$fullwidth = (isset($a['fullwidth'])) ? esc_html($a['fullwidth']) : '';

$fullwidthclass = ($fullwidth == 'yes') ? 'sf-featured-fullwidth' : '';

if(service_finder_themestyle_for_plugin() == 'style-2'){
$html .= '<section class="section-full sf-overlay-wrapper" style="background-image:url('.$imgurl.');background-attachment: '.$bgattachment.'">
            <div class="container '.sanitize_html_class($fullwidthclass).'">
            
            	<div class="section-head text-center">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
                </div>
                    
                <div class="section-content">
                    
                        <div class="owl-featured-2">';
                        	$html .= $innerhtml;
                        $html .= '</div>
                    
                </div>
                    
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';		

}elseif(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full bg-white sf-featurProviders-wrap" style="background-image:url(<?php echo esc_url($imgurl) ?>); background-attachment: <?php echo esc_attr($bgattachment); ?>">
    <div class="container">
        <div class="section-head text-center">
            <h2 class="text-white" style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2>
            <?php echo service_finder_title_separator($a['divider-color']); ?>
            <p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p>
        </div>
        <div class="section-content equal-col-outer">
            <div class="row">
            	<div class="featured-box-slider">
					<?php print_r($innerhtml); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-feaPro-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-feaPro-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
</section>
<?php
$html = ob_get_clean();
}else{
$html .= '<section class="section-full sf-overlay-wrapper text-center sf-category" style="background-image:url('.$imgurl.');background-attachment: '.$bgattachment.'">
  <div class="container '.sanitize_html_class($fullwidthclass).'">
    <div class="section-head w-t-element">
      <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
      '.service_finder_title_separator($a['divider-color']).'
      <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
    </div>
    <div class="section-content">
      <div class="row">
        <div class="owl-featured">';

$html .= $innerhtml;		

$html .= '</div>
      </div>
    </div>
  </div>
  <div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
  </div>
</section>';		
}
?>
<!-- Featured Providers END -->
