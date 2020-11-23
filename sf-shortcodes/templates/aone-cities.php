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
<!-- Testimonials Outer Template-->
<?php
$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_shortcode_global_vars('wpdb');

$imgurl = (!empty($service_finder_options['city-bg-image']['url'])) ? $service_finder_options['city-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['city-background-attachment'])) ? esc_html($service_finder_options['city-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['city-bg-color'])) ? $service_finder_options['city-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['city-bg-opacity'])) ? $service_finder_options['city-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['city-left-curve-color'])) ? $service_finder_options['city-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['city-right-curve-color'])) ? $service_finder_options['city-right-curve-color'] : '';

$title = (!empty($service_finder_options['shortcode-city-title'])) ? esc_html($service_finder_options['shortcode-city-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-city-tagline'])) ? wp_kses_post($service_finder_options['shortcode-city-tagline']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-city-title-color'])) ? esc_html($service_finder_options['shortcode-city-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-city-tagline-color'])) ? esc_html($service_finder_options['shortcode-city-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-city-divider-color'])) ? esc_html($service_finder_options['shortcode-city-divider-color']) : '';
$limit = (!empty($service_finder_options['shortcode-city-limit'])) ? esc_html($service_finder_options['shortcode-city-limit']) : 6;

$country = (!empty($service_finder_options['shortcode-city-country'])) ? esc_html($service_finder_options['shortcode-city-country']) : '';

if($country != '')
{
	$args = array(
	'hide_empty' => false,
	'number' => $limit,
	'meta_query' => array(
		array(
		   'key'       => 'country',
		   'value'     => $country,
		   'compare'   => 'LIKE'
		)
	),
	'taxonomy'  => 'sf-cities',
	);
}else
{
	$args = array(
	'hide_empty' => false,
	'number' => $limit,
	'taxonomy'  => 'sf-cities',
	);

}
$cities = get_terms( $args );


ob_start();
?>
<section class="section-full sf-populerCities-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
            <div class="container">
            
            	<div class="section-head text-center">
                    <h2 style="color:<?php echo esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
					<?php echo service_finder_title_separator($dividercolor) ?>
                    <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
                </div>
                    
                <div class="section-content">
                    <ul class="sf-popcity-list">
                        <?php
						if(!empty($cities))
						{
							foreach($cities as $city)
							{
								?>
                                <li class="sf-popcity-wrap-two-box">
                                    <div class="sf-popcity-wrap-two">
                                        <span class="sf-popcity-title"><a href="<?php echo get_term_link($city)?>"><?php echo esc_html($city->name); ?></a></span>
                                    </div>
                                </li>
								<?php
							}
						}
						?>
                    </ul>
                   	<?php
					if(count($cities) > 8)
					{
					?>
					<div id="loadmorecities" class="sf-showmore-cities">
						<a href="javascript:;" class="site-button-link"><?php esc_html_e('Show More','service-finder'); ?> <i class="fa fa-plus"></i></a>
					</div>	
					<?php
					}
					?>
                </div>
            </div>
            <?php
			if(service_finder_themestyle_for_plugin() == 'style-3'){
			?>
			<div class="sf-curve-topWrap"><div class="sf-curveTop sf-PopulerCities-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
			<div class="sf-curve-botWrap"><div class="sf-curveBot sf-PopulerCities-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>    <?php } ?>
			<div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
        </section>
<?php
$html = ob_get_clean();