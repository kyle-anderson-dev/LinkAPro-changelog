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

$imgurl = (!empty($service_finder_options['pricing-plans-bg-image']['url'])) ? $service_finder_options['pricing-plans-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['pricing-plans-background-attachment'])) ? esc_html($service_finder_options['pricing-plans-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['pricing-plans-bg-color'])) ? $service_finder_options['pricing-plans-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['pricing-plans-bg-opacity'])) ? $service_finder_options['pricing-plans-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['pricing-plans-left-curve-color'])) ? $service_finder_options['pricing-plans-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['pricing-plans-right-curve-color'])) ? $service_finder_options['pricing-plans-right-curve-color'] : '';

$title = (!empty($service_finder_options['shortcode-pricing-plans-title'])) ? esc_html($service_finder_options['shortcode-pricing-plans-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-pricing-plans-tagline'])) ? wp_kses_post($service_finder_options['shortcode-pricing-plans-tagline']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-pricing-plans-title-color'])) ? esc_html($service_finder_options['shortcode-pricing-plans-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-pricing-plans-tagline-color'])) ? esc_html($service_finder_options['shortcode-pricing-plans-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-pricing-plans-divider-color'])) ? esc_html($service_finder_options['shortcode-pricing-plans-divider-color']) : '';

$columngap = (!empty($service_finder_options['shortcode-pricing-plans-column-gap'])) ? esc_html($service_finder_options['shortcode-pricing-plans-column-gap']) : '';
$highlight = (!empty($service_finder_options['shortcode-pricing-plans-highlight'])) ? esc_html($service_finder_options['shortcode-pricing-plans-highlight']) : '';

$signuptype = (!empty($service_finder_options['shortcode-pricing-plans-signup-link-style'])) ? esc_html($service_finder_options['shortcode-pricing-plans-signup-link-style']) : 'page';

if($columngap ==  'no'){
	$class1 = 'p-lr15';
	$class2 = 'no-col-gap';
}else{
	$class1 = '';
	$class2 = '';
}

if(service_finder_themestyle_for_plugin() == 'style-2'){
$class = 'sf-pricing-box-new';
}else{
$class = '';
}

if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-site-pricingtable-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
        <div class="section-head text-center">
            <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
            <?php echo service_finder_title_separator($dividercolor); ?>
            <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
        </div>
        <div class="section-content">
            <div class="row equal-col-outer" id="sf-pricingtable-wrap">
                    <?php
					for($i = 0;$i <= 3; $i++ )
					{
					$enablepackage = (!empty($service_finder_options['enable-package'.$i])) ? $service_finder_options['enable-package'.$i] : '';
					if(isset($service_finder_options['enable-package'.$i]) && $enablepackage > 0){
					
					$packageprice = (isset($service_finder_options['package'.$i.'-price']) && $i > 0) ? $service_finder_options['package'.$i.'-price'] : '';
					$paymenttype = (!empty($service_finder_options['payment-type'])) ? $service_finder_options['payment-type'] : '';
					$packagename = (!empty($service_finder_options['package'.$i.'-name'])) ? $service_finder_options['package'.$i.'-name'] : '';
					
					$packagecolor = (!empty($service_finder_options['shortcode-pricing-plans-column-color'.$i])) ? esc_html($service_finder_options['shortcode-pricing-plans-column-color'.$i]) : '';
					
					$cap = (!empty($service_finder_options['package'.$i.'-capabilities'])) ? $service_finder_options['package'.$i.'-capabilities'] : '';
					$subcap = (!empty($service_finder_options['package'.$i.'-subcapabilities'])) ? $service_finder_options['package'.$i.'-subcapabilities'] : '';
					
					if($highlight == $i){
					$highlightclass = 'sf-pricing-highlight';
					}else{
					$highlightclass = '';
					}
					
					$signup = '';

					$packagenumber = $i;
					
					if(!is_user_logged_in()){
					
					if($signuptype == 'popup'){
					$signup = '<div class="pricingtable-footer" style=" background-color:'.esc_attr($packagecolor).'">
								<a class="btn btn-primary" href="javascript:;" data-action="signup" data-package="'.$packagenumber.'" data-redirect="no" data-toggle="modal" data-target="#login-Modal">'.esc_html__('Sign Up','service-finder').'</a>
							</div>';
					
					}else{
					$pageurl = service_finder_get_url_by_shortcode('[service_finder_signup');
					$link = add_query_arg( array(
						'package' => $packagenumber,
					), $pageurl );
					
					$signup = '<div class="pricingtable-footer" style=" background-color:'.esc_attr($packagecolor).'">
								<a class="btn btn-primary " href="'.esc_url($link).'" target="_blank">'.esc_html__('Sign Up','service-finder').'</a>
							</div>';
					
					}
					}
					
					$billingperiod = '';
					
					if (isset($service_finder_options['payment-type']) && ($service_finder_options['payment-type'] == 'recurring') && $i > 0) {
						$billingPeriod = esc_html__('year','service-finder');
						$packagebillingperiod = (!empty($service_finder_options['package'.$i.'-billing-period'])) ? $service_finder_options['package'.$i.'-billing-period'] : '';
						switch ($packagebillingperiod) {
							case 'Year':
								$billingperiod = esc_html__('Year','service-finder');
								break;
							case 'Month':
								$billingperiod = esc_html__('Month','service-finder');
								break;
							case 'Week':
								$billingperiod = esc_html__('Week','service-finder');
								break;
							case 'Day':
								$billingperiod = esc_html__('Day','service-finder');
								break;
						}
					}
					
					$packageexpday = '';
					if (isset($service_finder_options['payment-type']) && $service_finder_options['payment-type'] == 'single') {
						$packageexpday = (!empty($service_finder_options['package'.$i.'-expday'])) ? $service_finder_options['package'.$i.'-expday'] : '';
					}
					?>
					<div class="col-md-3 col-sm-6 equal-col pricingtable-cell">
                        <div class="pricing-tables-wrap <?php echo sanitize_html_class($class).' '.sanitize_html_class($highlightclass); ?>">
                            <div class="pricing-tables-top">
                                <div class="pricing-tables-name"><?php echo esc_html($packagename); ?></div>
                                <div class="pricing-tables-money" style="background-color:<?php echo esc_attr($packagecolor); ?>">
                                    <strong><?php echo service_finder_money_format($packageprice); ?></strong>
                                    <?php if($billingperiod != ''){ ?>
                                    <span class="sf-billing-period"><?php echo esc_html($billingperiod); ?></span>
                                    <?php } ?>
                                    <?php if($packageexpday != ''){ ?>
                                    <span class="sf-exp-period"><?php echo esc_html($packageexpday).' '.esc_html__('Days','service-finder'); ?></span>
                                    <?php } ?>
                                </div>
                                <?php if($highlight == $i){ ?>
                                <div class="sf-package-highlight"><span><?php echo esc_html__('Best Value','service-finder'); ?></span></div>
                                <?php } ?>
                            </div>
                            <div class="pricing-tables-midd">
                                <ul class="pricing-tables-list">
                                    <?php
                                    if(function_exists('service_finder_get_all_capabilities'))
									{
									$cap_fields = service_finder_get_all_capabilities();
									if(!empty($cap_fields))
									{
										foreach($cap_fields as $key => $cap_field)
										{
										$available = 'no';	
										
										if(!empty($cap[$key])){
										if($cap[$key] == true){
											$available = 'yes';	
										}
										}
										$availableclass = ($available == 'yes') ? 'check' : 'times';
										$notavailableclass = ($available == 'no') ? 'sf-featued-no-provide' : '';
										$featuretitle = service_finder_get_data($service_finder_options,'shortcode-pricing-feature-'.$key,$cap_field);
										?>
										<li class="<?php echo sanitize_html_class($notavailableclass); ?>"><i class="fa fa-<?php echo sanitize_html_class($availableclass); ?>"></i> <?php echo esc_html($featuretitle); ?></li>
										<?php	
										}
									}
									}
									
									$subcaps = (!empty($service_finder_options['package'.$i.'-subcapabilities'])) ? $service_finder_options['package'.$i.'-subcapabilities'] : '';
									if(!empty($subcaps)){
										foreach($subcaps as $key => $value){
											$featuretitle = service_finder_get_data($service_finder_options,'shortcode-pricing-feature-'.$key,service_finder_get_capability_name_by_key($key));
											if($value){
											echo '<li><i class="fa fa-check"></i> '.strtoupper($featuretitle).'</li>';
											}else{
											echo '<li class="sf-featued-no-provide"><i class="fa fa-times"></i> '.strtoupper($featuretitle).'</li>';
											}
										}
									}
									?>
                                    
                                </ul>
                            </div>
                            <?php
                            if(!is_user_logged_in())
                            {
                            if($signuptype == 'popup'){
                            ?>
                            <div class="pricing-tables-bottom" style=" background-color:<?php echo esc_attr($packagecolor); ?>">
                                <a class="btn btn-primary" href="javascript:;" data-action="signup" data-package="<?php echo esc_attr($packagenumber) ?> " data-redirect="no" data-toggle="modal" data-target="#login-Modal">
                                <?php echo esc_html__('Sign Up','service-finder'); ?>
                                </a>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="pricing-tables-bottom" style=" background-color:<?php echo esc_attr($packagecolor); ?>">
                                <a href="<?php echo esc_url($link); ?>" class="btn btn-primary"><?php echo esc_html__('Sign Up','service-finder'); ?></a>
                            </div>
                            <?php
                            }
                            }
                            ?>
                        </div>                                
                    </div>
					<?php
					}
					}
					?>
                </div>
        </div>
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-pricingtable-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-pricingtable-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">           
</section>
<?php
$html = ob_get_clean();
}else{
ob_start();
?>
<section class="section-full bg-white" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
    
    
        <div class="section-head text-center">
            <h2 style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
            <?php echo service_finder_title_separator($dividercolor); ?>
            <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
        </div>
            
        <div class="section-content">
            <div class="pricingtable-row m-b30 <?php echo sanitize_html_class($class1).' '.sanitize_html_class($class2) ?> equal-col-outer">
                <div class="row" id="sf-pricingtable-wrap">
                	<?php
					for($i = 0;$i <= 3; $i++ )
					{
					$enablepackage = (!empty($service_finder_options['enable-package'.$i])) ? $service_finder_options['enable-package'.$i] : '';
					if(isset($service_finder_options['enable-package'.$i]) && $enablepackage > 0){
					
					$packageprice = (isset($service_finder_options['package'.$i.'-price']) && $i > 0) ? $service_finder_options['package'.$i.'-price'] : '';
					$paymenttype = (!empty($service_finder_options['payment-type'])) ? $service_finder_options['payment-type'] : '';
					$packagename = (!empty($service_finder_options['package'.$i.'-name'])) ? $service_finder_options['package'.$i.'-name'] : '';
					
					$packagecolor = (!empty($service_finder_options['shortcode-pricing-plans-column-color'.$i])) ? esc_html($service_finder_options['shortcode-pricing-plans-column-color'.$i]) : '';
					
					$cap = (!empty($service_finder_options['package'.$i.'-capabilities'])) ? $service_finder_options['package'.$i.'-capabilities'] : '';
					$subcap = (!empty($service_finder_options['package'.$i.'-subcapabilities'])) ? $service_finder_options['package'.$i.'-subcapabilities'] : '';
					
					if($highlight == $i){
					$highlightclass = 'sf-pricing-highlight';
					}else{
					$highlightclass = '';
					}
					
					$signup = '';

					$packagenumber = $i;
					
					if(!is_user_logged_in()){
					
					if($signuptype == 'popup'){
					$signup = '<div class="pricingtable-footer" style=" background-color:'.esc_attr($packagecolor).'">
								<a class="btn btn-primary" href="javascript:;" data-action="signup" data-package="'.$packagenumber.'" data-redirect="no" data-toggle="modal" data-target="#login-Modal">'.esc_html__('Sign Up','service-finder').'</a>
							</div>';
					
					}else{
					$pageurl = service_finder_get_url_by_shortcode('[service_finder_signup');
					$link = add_query_arg( array(
						'package' => $packagenumber,
					), $pageurl );
					
					$signup = '<div class="pricingtable-footer" style=" background-color:'.esc_attr($packagecolor).'">
								<a class="btn btn-primary " href="'.esc_url($link).'" target="_blank">'.esc_html__('Sign Up','service-finder').'</a>
							</div>';
					
					}
					}
					
					$billingperiod = '';
					
					if (isset($service_finder_options['payment-type']) && ($service_finder_options['payment-type'] == 'recurring') && $i > 0) {
						$billingPeriod = esc_html__('year','service-finder');
						$packagebillingperiod = (!empty($service_finder_options['package'.$i.'-billing-period'])) ? $service_finder_options['package'.$i.'-billing-period'] : '';
						switch ($packagebillingperiod) {
							case 'Year':
								$billingperiod = esc_html__('Year','service-finder');
								break;
							case 'Month':
								$billingperiod = esc_html__('Month','service-finder');
								break;
							case 'Week':
								$billingperiod = esc_html__('Week','service-finder');
								break;
							case 'Day':
								$billingperiod = esc_html__('Day','service-finder');
								break;
						}
					}
					
					$packageexpday = '';
					if (isset($service_finder_options['payment-type']) && $service_finder_options['payment-type'] == 'single') {
						$packageexpday = (!empty($service_finder_options['package'.$i.'-expday'])) ? $service_finder_options['package'.$i.'-expday'] : '';
					}
					?>
                    <div class="col-sm-6 col-md-3 col-lg-3 equal-col pricingtable-cell">
                    <div class="pricingtable-wrapper <?php echo sanitize_html_class($class).' '.sanitize_html_class($highlightclass) ?>">
                        <div class="pricingtable-inner">
                        	
                            <div class="pricingtable-price" style=" background-color:<?php echo esc_attr($packagecolor) ?>">
                                <span class="pricingtable-bx"><?php echo service_finder_money_format($packageprice); ?></span>
                                <?php if($billingperiod != ''){ ?>
                                <span class="pricingtable-type"><?php echo esc_html($billingperiod); ?></span>
                                <?php } ?>
                                <?php if($packageexpday != ''){ ?>
                                <span class="pricingtable-type"><?php echo esc_html($packageexpday).' '.esc_html__('Days','service-finder'); ?></span>
                                <?php } ?>
                            </div>
                            
                            <div class="pricingtable-title" style=" background-color:<?php echo esc_attr($packagecolor) ?>">
                                <h2><?php echo esc_html($packagename); ?></h2>
                            </div>
                            
                            <ul class="pricingtable-features">
                            	<?php
								if(function_exists('service_finder_get_all_capabilities'))
								{
								$cap_fields = service_finder_get_all_capabilities();
								if(!empty($cap_fields))
								{
									foreach($cap_fields as $key => $cap_field)
									{
									$available = 'no';	
									
									if(!empty($cap[$key])){
									if($cap[$key] == true){
										$available = 'yes';	
									}
									}
									$availableclass = ($available == 'yes') ? 'check' : 'times';
									$notavailableclass = ($available == 'no') ? 'sf-featued-no-provide' : '';
									$featuretitle = service_finder_get_data($service_finder_options,'shortcode-pricing-feature-'.$key,$cap_field);
									?>
									<li class="<?php echo sanitize_html_class($notavailableclass); ?>"><i class="fa fa-<?php echo sanitize_html_class($availableclass); ?>"></i> <?php echo esc_html($featuretitle); ?></li>
									<?php	
									}
								}
								}
								
								$subcaps = (!empty($service_finder_options['package'.$i.'-subcapabilities'])) ? $service_finder_options['package'.$i.'-subcapabilities'] : '';
								if(!empty($subcaps)){
									foreach($subcaps as $key => $value){
										$featuretitle = service_finder_get_data($service_finder_options,'shortcode-pricing-feature-'.$key,service_finder_get_capability_name_by_key($key));
										if($value){
										echo '<li><i class="fa fa-check"></i> '.strtoupper($featuretitle).'</li>';
										}else{
										echo '<li class="sf-featued-no-provide"><i class="fa fa-times"></i> '.strtoupper($featuretitle).'</li>';
										}
									}
								}
								?>    
                            </ul>
                            
                            <?php
                            if(!is_user_logged_in())
                            {
                            if($signuptype == 'popup'){
                            ?>
                            <div class="pricing-tables-bottom" style=" background-color:<?php echo esc_attr($packagecolor); ?>">
                                <a class="btn btn-primary" href="javascript:;" data-action="signup" data-package="<?php echo esc_attr($packagenumber) ?> " data-redirect="no" data-toggle="modal" data-target="#login-Modal">
                                <?php echo esc_html__('Sign Up','service-finder'); ?>
                                </a>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="pricingtable-footer" style=" background-color:<?php echo esc_attr($packagecolor); ?>">
                                <a href="<?php echo esc_url($link); ?>" class="btn btn-primary"><?php echo esc_html__('Sign Up','service-finder'); ?></a>
                            </div>
                            <?php
                            }
                            }
                            ?>
                        
                        </div>
                    </div>
                    </div>
					<?php
					}
					}
					?>
                </div>
            </div>
        </div>
        
    </div>
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">
</section>
<?php		
$html = ob_get_clean();
}
?>
