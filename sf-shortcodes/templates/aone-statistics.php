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

$imgurl = (!empty($service_finder_options['statistics-bg-image']['url'])) ? $service_finder_options['statistics-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['statistics-background-attachment'])) ? esc_html($service_finder_options['statistics-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['statistics-bg-color'])) ? $service_finder_options['statistics-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['statistics-bg-opacity'])) ? $service_finder_options['statistics-bg-opacity'] : '';

$curveleftcolor = (!empty($service_finder_options['statistics-left-curve-color'])) ? $service_finder_options['statistics-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['statistics-right-curve-color'])) ? $service_finder_options['statistics-right-curve-color'] : '';

$title = (!empty($service_finder_options['shortcode-statistics-title'])) ? esc_html($service_finder_options['shortcode-statistics-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-statistics-tagline'])) ? wp_kses_post($service_finder_options['shortcode-statistics-tagline']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-statistics-title-color'])) ? esc_html($service_finder_options['shortcode-statistics-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-statistics-tagline-color'])) ? esc_html($service_finder_options['shortcode-statistics-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-statistics-divider-color'])) ? esc_html($service_finder_options['shortcode-statistics-divider-color']) : '';

$providerreplacestring = (!empty($service_finder_options['provider-replace-string'])) ? $service_finder_options['provider-replace-string'] : esc_html__('Provider', 'service-finder');
$customerreplacestring = (!empty($service_finder_options['customer-replace-string'])) ? $service_finder_options['customer-replace-string'] : esc_html__('Customer', 'service-finder');

if(service_finder_themestyle_for_plugin() == 'style-3')
{
ob_start();
?>
<section class="section-full bg-gray sf-trustedBy-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
        <div class="section-head text-center">
            <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
            <?php echo service_finder_title_separator($dividercolor); ?>
            <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
        </div>
        <div class="section-content">
            <div class="row">
                
                <?php
                for($i = 1;$i <= 4; $i++ )
				{
				$type = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-type'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-type']) : '';
				$number = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-number'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-number']) : '';
				$text = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-title'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-title']) : '';
				$text = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-title'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-title']) : '';
				$colorcode = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-color'])) ? $service_finder_options['shortcode-statistics-box'.$i.'-color'] : '';
				switch($type){
				case 'providers': 
					if($number == 0 || $number == ''){
					$total = service_finder_totalProviders();
					$number = $total;
					}
					$text = (!empty($text)) ? $text : $providerreplacestring;
					break;
				case 'customers': 
					if($number == 0 || $number == ''){
					$total = service_finder_totalCustomers();
					$number = $total;
					}
					$text = (!empty($text)) ? $text : $customerreplacestring;
					break;
				case 'jobs': 
					if($number == 0 || $number == ''){
					$total = wp_count_posts('job_listing');
					$number = $total->publish;
					}
					$text = (!empty($text)) ? $text : esc_html__('Jobs', 'service-finder');
					break;
				case 'categories': 
					if($number == 0 || $number == ''){
					$total = wp_count_terms('providers-category');
					$number = $total;
					}
					$text = (!empty($text)) ? $text : esc_html__('Categories', 'service-finder');
					break;
				default:
					$text = (!empty($text)) ? $text : '';
					break;
				}
				
				?>
				<div class="col-md-3 col-sm-6">
                  <div class="sf-company-satus2 text-center">
                        <div class="sf-company-count counter"><?php echo esc_html($number); ?></div>
                        <div class="sf-company-satus-name"><?php echo esc_html($text); ?></div>
                        <div class="sf-company-satus-line" style="background-color:<?php echo esc_attr($colorcode); ?>"></div>
                  </div>
                </div>
				<?php
				}
				?>
                
            </div>
        </div>
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-trustedBy-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-trustedBy-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">             
</section>
<?php
$html = ob_get_clean(); 
}else{
$html = '<section class="section-full bg-primary" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            	
                <div class="row equal-col-outer">';
                
                for($i = 1;$i <= 4; $i++ )
				{
				$type = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-type'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-type']) : '';
				$number = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-number'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-number']) : '';
				$text = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-title'])) ? esc_html($service_finder_options['shortcode-statistics-box'.$i.'-title']) : '';
				$iconclass = (!empty($service_finder_options['shortcode-statistics-box'.$i.'-icon-class'])) ? $service_finder_options['shortcode-statistics-box'.$i.'-icon-class'] : '';
				switch($type){
				case 'providers': 
					if($number == 0 || $number == ''){
					$total = service_finder_totalProviders();
					$number = $total;
					}
					$text = (!empty($text)) ? $text : $providerreplacestring;
					break;
				case 'customers': 
					if($number == 0 || $number == ''){
					$total = service_finder_totalCustomers();
					$number = $total;
					}
					$text = (!empty($text)) ? $text : $customerreplacestring;
					break;
				case 'jobs': 
					if($number == 0 || $number == ''){
					$total = wp_count_posts('job_listing');
					$number = $total->publish;
					}
					$text = (!empty($text)) ? $text : esc_html__('Jobs', 'service-finder');
					break;
				case 'categories': 
					if($number == 0 || $number == ''){
					$total = wp_count_terms('providers-category');
					$number = $total;
					}
					$text = (!empty($text)) ? $text : esc_html__('Categories', 'service-finder');
					break;
				default:
					$text = (!empty($text)) ? $text : '';
					break;
				}
				
				$html .= '<div class="col-md-3 col-sm-6 equal-col sf-counter-wrap">
                      <div class="sf-company-satus text-center">
                            <div class="sf-icon-md margin-b-10"><i class="fa '.esc_attr($iconclass).'"></i></div>
                            <div class="sf-company-count counter">'.esc_html($number).'</div>
                            <div class="sf-company-satus-name">'.esc_html($text).'</div>
                      </div>
                    </div>';
				}
                    
		$html .= '</div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
$html = str_replace('<br />','',$html);
$html = str_replace('<p></p>','',$html);
}
?>

