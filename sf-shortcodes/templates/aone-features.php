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
$title = (!empty($service_finder_options['shortcode-features-title'])) ? esc_html($service_finder_options['shortcode-features-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-features-tagline'])) ? wp_kses_post($service_finder_options['shortcode-features-tagline']) : '';
$content = (!empty($service_finder_options['shortcode-features-content'])) ? wp_kses_post($service_finder_options['shortcode-features-content']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-features-title-color'])) ? esc_html($service_finder_options['shortcode-features-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-features-tagline-color'])) ? esc_html($service_finder_options['shortcode-features-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-features-divider-color'])) ? esc_html($service_finder_options['shortcode-features-divider-color']) : '';

$imgurl = (!empty($service_finder_options['features-bg-image']['url'])) ? $service_finder_options['features-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['features-background-attachment'])) ? esc_html($service_finder_options['features-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['features-bg-color'])) ? $service_finder_options['features-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['features-bg-opacity'])) ? $service_finder_options['features-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 

$curveleftcolor = (!empty($service_finder_options['features-left-curve-color'])) ? $service_finder_options['features-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['features-right-curve-color'])) ? $service_finder_options['features-right-curve-color'] : '';
?>
<?php
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full text-center bg-white why-use-sf" style="background:url(<?php echo esc_url($imgurl); ?>) center <?php echo esc_attr($bgattachment); ?> no-repeat;">
  <div class="container">
    <div class="section-head">
      <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
      <?php echo service_finder_title_separator($dividercolor); ?>
      <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
    </div>
    <div class="section-content">
      <div class="row equal-col-outer">
        	<?php
			$boxcnt = 0;
			for($i = 1;$i <= 6; $i++ )
			{
			$show = (isset($service_finder_options['shortcode-features-box'.$i.'-show'])) ? esc_html($service_finder_options['shortcode-features-box'.$i.'-show']) : true;
			if($show == true)
			{
			$boxcnt++;
			}
			}
			for($i = 1;$i <= 6; $i++ )
			{
			$show = (isset($service_finder_options['shortcode-features-box'.$i.'-show'])) ? $service_finder_options['shortcode-features-box'.$i.'-show'] : true;
			$steptitle = (!empty($service_finder_options['shortcode-features-box'.$i.'-title'])) ? wp_kses_post($service_finder_options['shortcode-features-box'.$i.'-title']) : '';
			$stepcontent = (!empty($service_finder_options['shortcode-features-box'.$i.'-content'])) ? esc_html($service_finder_options['shortcode-features-box'.$i.'-content']) : '';
			$stepicon = (!empty($service_finder_options['shortcode-features-box'.$i.'-icon'])) ? $service_finder_options['shortcode-features-box'.$i.'-icon'] : '';
			$boxwidth = ($boxcnt == 2 || $boxcnt == 4) ? 'col-md-6 col-sm-6' : 'col-md-4 col-sm-4';
			if($show == true)
			{
			?>
            <div class="<?php echo esc_attr($boxwidth); ?> col-xs-6 equal-col">
              <div class="sf-element-bx padding-lr-30">
                <div class="icon-bx-md rounded-bx" style="border-color:<?php echo esc_attr($taglinecolor); ?>"> <i class="fa <?php echo sanitize_html_class($stepicon)?>"></i> </div>
                <h4 style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($steptitle); ?></h4>
                <p style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($stepcontent); ?></p>
              </div>
            </div>
			<?php
			}
			}
			?>
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
<section class="section-full text-center bg-white why-use-sf" style="background:url(<?php echo esc_url($imgurl); ?>) center <?php echo esc_attr($bgattachment); ?> no-repeat;">
  <div class="container">
    <div class="section-head">
      <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
      <?php echo service_finder_title_separator($dividercolor); ?>
      <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
    </div>
    <div class="section-content">
      <div class="row equal-col-outer">
        	<?php
			$boxcnt = 0;
			for($i = 1;$i <= 6; $i++ )
			{
			$show = (isset($service_finder_options['shortcode-features-box'.$i.'-show'])) ? esc_html($service_finder_options['shortcode-features-box'.$i.'-show']) : true;
			if($show == true)
			{
			$boxcnt++;
			}
			}
			for($i = 1;$i <= 6; $i++ )
			{
			$show = (isset($service_finder_options['shortcode-features-box'.$i.'-show'])) ? esc_html($service_finder_options['shortcode-features-box'.$i.'-show']) : true;
			$steptitle = (!empty($service_finder_options['shortcode-features-box'.$i.'-title'])) ? wp_kses_post($service_finder_options['shortcode-features-box'.$i.'-title']) : '';
			$stepcontent = (!empty($service_finder_options['shortcode-features-box'.$i.'-content'])) ? esc_html($service_finder_options['shortcode-features-box'.$i.'-content']) : '';
			$stepicon = (!empty($service_finder_options['shortcode-features-box'.$i.'-icon'])) ? $service_finder_options['shortcode-features-box'.$i.'-icon'] : '';
			
			$boxwidth = ($boxcnt == 2 || $boxcnt == 4) ? 'col-md-6 col-sm-6' : 'col-md-4 col-sm-4';
			if($show == true)
			{
			?>
            <div class="<?php echo esc_attr($boxwidth); ?> col-xs-6 equal-col">
              <div class="sf-element-bx padding-lr-30">
                <div class="icon-bx-md rounded-bx" style="border-color:<?php echo esc_attr($taglinecolor); ?>"> <i class="fa <?php echo sanitize_html_class($stepicon)?>"></i> </div>
                <h4 style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($steptitle); ?></h4>
                <p style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($stepcontent); ?></p>
              </div>
            </div>
			<?php
			}
			}
			?>
      </div>
    </div>
  </div>
</section>
<?php
$html = ob_get_clean();
}
?>