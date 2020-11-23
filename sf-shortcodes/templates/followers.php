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
?>
<?php 
$imgurl = (!empty($service_finder_options['follow-us-bg-image']['url'])) ? $service_finder_options['follow-us-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['follow-us-background-attachment'])) ? esc_html($service_finder_options['follow-us-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['follow-us-bg-color'])) ? $service_finder_options['follow-us-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['follow-us-bg-opacity'])) ? $service_finder_options['follow-us-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['follow-us-left-curve-color'])) ? $service_finder_options['follow-us-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['follow-us-right-curve-color'])) ? $service_finder_options['follow-us-right-curve-color'] : '';
?>
<!--  Providers Follow us -->
<?php
if(function_exists('service_finder_totalProviders'))
{
	$total = service_finder_totalProviders();
}else{
	$total = 0;
}

if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();

$videourl = (!empty($a['youtube-video-url'])) ? $a['youtube-video-url'] : '';
$followimageurl = (!empty($a['image-url'])) ? $a['image-url'] : '';
if(!empty($videourl))
{
$videoid = service_finder_get_youtubeid_from_url($videourl);
$videothumb = 'https://img.youtube.com/vi/'.$videoid.'/maxresdefault.jpg';
}else{
$videothumb = '';
}
?>
<section class="section-full sf-providers-follow-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
        <div class="section-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="sf-providers-follow-left <?php echo ($videourl == '' || $followimageurl == '') ? 'followers-placeholder' : ''; ?>">
                                <div class="sf-providers-follow-title"><h2><?php echo str_replace("%TOTAL-PROVIDERS%",'<span>'.$total.'</span>',$a['title']); ?></h2></div>
                                <div class="sf-providers-follow-text">
                                <?php $content = str_replace("%TOTAL-PROVIDERS%",'<span>'.$total.'</span>',$content); ?>
								<?php echo apply_filters('the_content', $content); ?>
                                </div>
                                <?php
                                if($a['btn-link'] != '' && $a['btn-text'])
								{
								?>
                                <div class="sf-providers-follow-btn"><a href="<?php echo esc_html($a['btn-link']); ?>" class="btn btn-primary"><?php echo esc_html($a['btn-text']); ?></a></div>
                                <?php
                                }
								?>
                             </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="sf-about-video-right">
                                <div class="overlay-wraper sf-video-pay-pic">
                                    <div class="overlay-main bg-black opacity-01 "></div>
                                    <?php
									if(!empty($videourl))
									{
									?>
									<img src="<?php echo esc_url($videothumb); ?>" alt="">
									<a href="<?php echo esc_url($videourl); ?>" class="popup-youtube play-now">
										<i class="icon fa fa-play"></i>
										<span class="ripple"></span>
									</a>
									<?php 
									}elseif($followimageurl != '')
									{
									echo '<img src="'.$followimageurl.'" alt="">';
									}
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-proFolos-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-proFolos-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> "> 
</section>
<?php
$html = ob_get_clean();

}else{
$html = '<div class="section-full sf-overlay-wrapper text-center providers-follow" style="background:url('.esc_url($imgurl).') center '.$bgattachment.' no-repeat;">
  <div class="container">
    <div class="w-t-element"> <strong class="sf-title">'.str_replace("%TOTAL-PROVIDERS%",'<span>'.$total.'</span>',$a['title']).'</strong>
      <div class="sf-follow-text">'.$content.'</div>
    </div>
  </div>
  <div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
  </div>
</div>
';
}
?>
<!--  Providers Follow us -->
