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
?>
<?php 
$imgurl = (!empty($service_finder_options['why-choose-us-bg-image']['url'])) ? $service_finder_options['why-choose-us-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['why-choose-us-background-attachment'])) ? esc_html($service_finder_options['why-choose-us-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['why-choose-us-bg-color'])) ? $service_finder_options['why-choose-us-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['why-choose-us-bg-opacity'])) ? $service_finder_options['why-choose-us-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['why-choose-us-left-curve-color'])) ? $service_finder_options['why-choose-us-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['why-choose-us-right-curve-color'])) ? $service_finder_options['why-choose-us-right-curve-color'] : '';
$title = (!empty($service_finder_options['shortcode-why-choose-title'])) ? esc_html($service_finder_options['shortcode-why-choose-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-why-choose-tagline'])) ? wp_kses_post($service_finder_options['shortcode-why-choose-tagline']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-why-choose-title-color'])) ? esc_html($service_finder_options['shortcode-why-choose-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-why-choose-tagline-color'])) ? esc_html($service_finder_options['shortcode-why-choose-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-why-choose-divider-color'])) ? esc_html($service_finder_options['shortcode-why-choose-divider-color']) : '';
?>
<?php
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full text-center sf-whyChoos-wrap" style="background-image:url(<?php echo esc_url($imgurl) ?>); background-attachment: <?php echo esc_attr($bgattachment); ?>">
    <div class="container">
    
        <div class="section-head w-t-element">
            <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
            <?php echo service_finder_title_separator($dividercolor); ?>
            <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
        </div>
            
        <div class="section-content">
            <div class="row">
                
                <?php
				$boxcnt = 0;
				for($i = 1;$i <= 3; $i++ )
				{
				$show = (isset($service_finder_options['shortcode-why-choose-step'.$i.'-show'])) ? esc_html($service_finder_options['shortcode-why-choose-step'.$i.'-show']) : true;
				if($show == true)
				{
				$boxcnt++;
				}
				}
                for($i = 1;$i <= 3; $i++ )
				{
				$show = (isset($service_finder_options['shortcode-why-choose-step'.$i.'-show'])) ? $service_finder_options['shortcode-why-choose-step'.$i.'-show'] : true;
				$steptitle = (!empty($service_finder_options['shortcode-why-choose-box'.$i.'-title'])) ? esc_html($service_finder_options['shortcode-why-choose-box'.$i.'-title']) : '';
				$stepcontent = (!empty($service_finder_options['shortcode-why-choose-box'.$i.'-content'])) ? wp_kses_post($service_finder_options['shortcode-why-choose-box'.$i.'-content']) : '';

				$stepicon = (!empty($service_finder_options['shortcode-why-choose-box'.$i.'-icon']['url'])) ? $service_finder_options['shortcode-why-choose-box'.$i.'-icon']['url'] : '';
				$boxwidth = ($boxcnt == 2) ? 'col-md-6 col-sm-6' : 'col-md-4 col-sm-4';
				if($show == true)
				{
				?>
				<div class="<?php echo esc_attr($boxwidth); ?>">
                  <div class="sf-why-choose w-t-element padding-lr-20">
                        <div class="sf-icon-xl margin-b-20">
                            <img src="<?php echo esc_url($stepicon); ?>" width="220" height="200" alt="">
                        </div>
                        <h4 class="sf-tilte margin-b-10" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo esc_html($steptitle); ?></h4>
                        <p style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($stepcontent); ?></p>
                  </div>
                </div>
				<?php
				}
				}
				?>
                
            </div>
        </div>
        
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-whyChoos-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-whyChoos-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">        
</section>
<?php
$html = ob_get_clean();

}else{
$html = '<section class="section-full sf-overlay-wrapper text-center" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            
            	<div class="section-head w-t-element">
					<h2 style="color:'.$titlecolor.'">'.esc_html($title).'</h2>
					'.service_finder_title_separator($dividercolor).'
					<div class="sf-tagile-outer" style="color:'.esc_attr($taglinecolor).'">'.wp_kses_post($tagline).'</div>
                </div>
                    
                <div class="section-content">
                    <div class="row">';
					$boxcnt = 0;
					for($i = 1;$i <= 3; $i++ )
					{
					$show = (isset($service_finder_options['shortcode-why-choose-step'.$i.'-show'])) ? $service_finder_options['shortcode-why-choose-step'.$i.'-show'] : true;
					if($show == true)
					{
					$boxcnt++;
					}
					}
					for($i = 1;$i <= 3; $i++ )
					{
					$show = (isset($service_finder_options['shortcode-why-choose-step'.$i.'-show'])) ? $service_finder_options['shortcode-why-choose-step'.$i.'-show'] : true;
					$show = (isset($service_finder_options['shortcode-how-works-step'.$i.'-show'])) ? $service_finder_options['shortcode-how-works-step'.$i.'-show'] : true;
					$steptitle = (!empty($service_finder_options['shortcode-why-choose-box'.$i.'-title'])) ? esc_html($service_finder_options['shortcode-why-choose-box'.$i.'-title']) : '';
					$stepcontent = (!empty($service_finder_options['shortcode-why-choose-box'.$i.'-content'])) ? wp_kses_post($service_finder_options['shortcode-why-choose-box'.$i.'-content']) : '';
	
					$stepicon = (!empty($service_finder_options['shortcode-why-choose-box'.$i.'-icon']['url'])) ? $service_finder_options['shortcode-why-choose-box'.$i.'-icon']['url'] : '';
					$boxwidth = ($boxcnt == 2) ? 'col-md-6 col-sm-6' : 'col-md-4 col-sm-4';
					if($show == true)
					{
					$html .= '<div class="'.esc_attr($boxwidth).'">
							  <div class="sf-why-choose w-t-element padding-lr-20">
									<div class="sf-icon-xl margin-b-20">
										<img src="'.esc_url($stepicon).'" width="220" height="200" alt="">
									</div>
									<h4 class="sf-tilte margin-b-10" style="color:'.esc_attr($taglinecolor).'">'.esc_html($steptitle).'</h4>
									<p style="color:'.esc_attr($taglinecolor).'">'.wp_kses_post($stepcontent).'</p>
									
							  </div>
							</div>';
					
					}
					}
			$html .= '</div>
                </div>
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
}		
?>

