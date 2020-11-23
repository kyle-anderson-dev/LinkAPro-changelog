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
<!-- How sf Works -->
<?php
$imgurl = (!empty($service_finder_options['how-works-bg-image']['url'])) ? $service_finder_options['how-works-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['how-works-background-attachment'])) ? esc_html($service_finder_options['how-works-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['how-works-bg-color'])) ? $service_finder_options['how-works-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['how-works-bg-opacity'])) ? $service_finder_options['how-works-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['how-works-left-curve-color'])) ? $service_finder_options['how-works-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['how-works-right-curve-color'])) ? $service_finder_options['how-works-right-curve-color'] : '';

if(service_finder_themestyle_for_plugin() == 'style-2'){
$html = '<section class="section-full text-center bg-white" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            
            	<div class="section-head">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
                </div>
                    
                <div class="section-content">
                    <div class="row">
                        
                        '.do_shortcode( $content ).'
                        
                    </div>
                </div>
                
            </div>
        </section>';
}elseif(service_finder_themestyle_for_plugin() == 'style-3')
{
ob_start();
?>
<section class="section-full text-center sf-howServFinder-wrap" style="background-image:url(<?php echo esc_url($imgurl) ?>); background-attachment: <?php echo esc_attr($bgattachment); ?>">
	<div class="container">
	
		<div class="section-head">
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
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-howitwork-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-howitwork-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
</section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full text-center bg-white how-sf-work" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
  <div class="container">
    <div class="section-head">
      <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
      '.service_finder_title_separator($a['divider-color']).'
      <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
    </div>
    <div class="section-content">
      <div class="row">
        '.do_shortcode( $content ).'
        <div class="col-md-12">
          <div class="line-bx">
            <div class="col-md-6 padding-r-40">
              <div class="pull-right">
                <hr>
              </div>
            </div>
            <div class="col-md-6 padding-l-40">
              <div  class="pull-left">
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>';
}
$html = str_replace('<br />','',$html);
$html = str_replace('<br>','',$html);
$html = str_replace('<p></p>','',$html);
?>
<!-- How sf Works END -->
