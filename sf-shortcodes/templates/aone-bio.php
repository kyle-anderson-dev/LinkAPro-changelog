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
$title = (!empty($service_finder_options['shortcode-bio-title'])) ? esc_html($service_finder_options['shortcode-bio-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-bio-tagline'])) ? wp_kses_post($service_finder_options['shortcode-bio-tagline']) : '';
$content = (!empty($service_finder_options['shortcode-bio-content'])) ? wp_kses_post($service_finder_options['shortcode-bio-content']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-bio-title-color'])) ? esc_html($service_finder_options['shortcode-bio-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-bio-tagline-color'])) ? esc_html($service_finder_options['shortcode-bio-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-bio-divider-color'])) ? esc_html($service_finder_options['shortcode-bio-divider-color']) : '';

$buttontext = (!empty($service_finder_options['shortcode-bio-button-text'])) ? esc_html($service_finder_options['shortcode-bio-button-text']) : '';
$buttonlink = (!empty($service_finder_options['shortcode-bio-button-link'])) ? esc_html($service_finder_options['shortcode-bio-button-link']) : '';

$imgurl = (!empty($service_finder_options['bio-bg-image']['url'])) ? $service_finder_options['bio-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['bio-background-attachment'])) ? esc_html($service_finder_options['bio-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['bio-bg-color'])) ? $service_finder_options['bio-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['bio-bg-opacity'])) ? $service_finder_options['bio-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 

$curveleftcolor = (!empty($service_finder_options['bio-left-curve-color'])) ? $service_finder_options['bio-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['bio-right-curve-color'])) ? $service_finder_options['bio-right-curve-color'] : '';
?>
<?php
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-overlay-wrapper text-center who-fs-com" style="background:url(<?php echo esc_url($imgurl); ?>) center <?php echo esc_attr($bgattachment); ?> no-repeat;">
  <div class="container">
    <div class="section-head">
        <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
        <?php echo service_finder_title_separator($dividercolor); ?>
        <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
    </div>
    <div class="section-content sf-about-text">
      <div class="row">
        <div class="col-md-12 sf-about-text2" style="color:<?php echo esc_attr($taglinecolor); ?>">
          <?php echo wp_kses_post($content); ?>
          <?php
		  if($buttonlink != '' && $buttontext != '')
		  {
		  ?>
		  <a href="<?php echo esc_html($buttonlink); ?>" class="btn btn-primary" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($buttontext); ?></a>
		  <?php
		  }
		  ?>
        </div>
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
ob_start();
?>
<section class="section-full sf-overlay-wrapper text-center who-fs-com" style="background:url(<?php echo esc_url($imgurl); ?>) center <?php echo esc_attr($bgattachment); ?> no-repeat;">
  <div class="container">
    <div class="section-head">
        <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
        <?php echo service_finder_title_separator($dividercolor); ?>
        <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
    </div>
    <div class="section-content sf-about-text">
      <div class="row">
        <div class="col-md-12 sf-about-text2" style="color:<?php echo esc_attr($taglinecolor); ?>">
          <?php echo wp_kses_post($content); ?>
          <?php
		  if($buttonlink != '' && $buttontext != '')
		  {
		  ?>
		  <a href="<?php echo esc_html($buttonlink); ?>" class="btn btn-primary" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($buttontext); ?></a>
		  <?php
		  }
		  ?>
        </div>
      </div>
    </div>
  </div>
  <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> "></div>
</section>
<?php
$html = ob_get_clean();
}
?>