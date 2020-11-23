<?php

/* ShortCode for quoation replies */
add_shortcode('service_finder_job_applicants','service_finder_fn_job_applicants');
function service_finder_fn_job_applicants( $atts, $content = null )
{
	ob_start();
	global $wpdb,$current_user,$service_finder_Tables,$service_finder_options;
	
	wp_enqueue_script('service-finder-job-applications');
	
	$jobid = service_finder_get_data($_GET,'jobid');
	
	$jsdata = 'var jsdata = { 
				"jobid": '.$jobid.',
				"stripepublickey": "'.service_finder_get_stripe_public_key().'"
				};';
	wp_add_inline_script('service-finder-job-applications', $jsdata, 'before');
	
	?>
    
    
    <div class="row">
    
        <?php
		$providers = service_finder_get_job_related_providers($jobid);
		
		$jobauthor = get_post_field( 'post_author', $jobid );
		if($jobauthor > 0 && $jobid > 0)
		{
		if($current_user->ID == $jobauthor)
		{
		$categories = service_finder_get_job_categories($jobid);
		?>
        <h2><?php echo sprintf(esc_html__('Recommended %s', 'service-finder'),service_finder_provider_replace_string()); ?></h2>
        <h6><?php echo sprintf(esc_html__('%d %s have applied to this job', 'service-finder'),service_finder_get_number_of_applicants($jobid),service_finder_provider_replace_string()); ?></h6>
        <div class="sf-job-box-wrap"> <!-- Google Map -->
            <div class="container">
                <div class="sf-job-box">
                    <h2 class="sf-job-box-title"><?php echo get_the_title($jobid); ?></h2>
                    <?php if(!empty($categories)){ ?>
                    <div class="clear"></div>
                    <div class="sf-provider-cat sf-p-c-v2"><strong><?php esc_html_e('Categories', 'service-finder'); ?>: </strong> <?php echo implode(',', $categories ); ?></div>
                    <?php } ?>
                    <span class="sf-job-box-price">
					<?php echo service_finder_money_format(get_post_meta($jobid,'_job_cost',true)); ?><br/>
                    <span class="sf-jobdetail-link"><a class="btn btn-primary" href="<?php echo get_the_permalink($jobid); ?>" target="_blank"><?php echo esc_html__('View Job', 'service-finder') ?></a></span>
                    </span>
                    <div class="clear"></div>
                    <?php
                    $jobcontent = get_post_field( 'post_content', $jobid );
                    echo apply_filters('the_content', $jobcontent);
                    ?>
                </div>
            </div>
        </div>
    
        <!-- Left part start -->        
        <div class="col-md-4">
            <form name="jobapplicantsfilter" id="jobapplicantsfilter">
            <div class="sf-serach-bar-verticle">
                <div class="sf-serach-bar-box">
                    <h5 class="sf-serach-bar-label"><i class="fa fa-map-marker"></i><?php echo esc_html__( 'Filter by Locatio', 'service-finder' ); ?></h5>
                    <div class="sf-serach-bar-content">
                        <input type="text" class="form-control sf-form-control" name="filterlocation" id="filterlocation" placeholder="<?php echo esc_html__( 'Enter Location', 'service-finder' ); ?>">
                    </div> 
                    <div class="sf-serach-bar-content">
                        <input type="text" class="form-control sf-form-control" name="radius" placeholder="<?php echo esc_html__( 'Enter Radius', 'service-finder' ); ?>">
                    </div> 
                </div>
                <div class="sf-serach-bar-box">
                    <h5 class="sf-serach-bar-label"><i class="fa fa-shield"></i><?php echo sprintf(esc_html__( 'Filter by %s Type', 'service-finder' ),service_finder_provider_replace_string()); ?></h5>
                    <div class="sf-serach-bar-content">
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="verified-provider" name="providertype[]" value="verified">
                                 <label for="verified-provider"><?php echo sprintf(esc_html__( 'Verified %s', 'service-finder' ),service_finder_provider_replace_string()); ?></label>
                             </div>
                        </div>  
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="featured-provider" name="providertype[]" value="featured">
                                 <label for="featured-provider"><?php echo sprintf(esc_html__( 'Featured %s', 'service-finder' ),service_finder_provider_replace_string()); ?></label>
                             </div>
                        </div>
                    </div> 
                </div>
                
                <div class="sf-serach-bar-box">
                    <h5 class="sf-serach-bar-label"><i class="fa fa-shield"></i><?php echo esc_html__( 'Filter by Quote Reply', 'service-finder' ); ?></h5>
                    <div class="sf-serach-bar-content">
                        <div class="form-group">
                            <div class="radio sf-radio-checkbox">
                                 <input type="radio" id="quote-received" name="quotereceived" value="yes">
                                 <label for="quote-received"><?php echo esc_html__( 'Quotation Received', 'service-finder' ); ?></label>
                             </div>
                        </div>  
                        <div class="form-group">
                            <div class="radio sf-radio-checkbox">
                                 <input type="radio" id="quote-not-received" name="quotereceived" value="no">
                                 <label for="quote-not-received"><?php echo esc_html__( 'Quotation Not Received', 'service-finder' ); ?></label>
                             </div>
                        </div>
                    </div> 
                </div>
                <div class="sf-serach-bar-box">
                    <h5 class="sf-serach-bar-label"><i class="fa fa-star-half-empty"></i><?php echo esc_html__( 'Filter by Rating', 'service-finder' ); ?></h5>
                    <div class="sf-serach-bar-content">
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="prorating5" name="providerrating[]" value="5">
                                 <label for="prorating5"><?php echo esc_html__( '5 Star', 'service-finder' ); ?></label>
                             </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="prorating4" name="providerrating[]" value="4">
                                 <label for="prorating4"><?php echo esc_html__( '4 Star', 'service-finder' ); ?></label>
                             </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="prorating3" name="providerrating[]" value="3">
                                 <label for="prorating3"><?php echo esc_html__( '3 Star', 'service-finder' ); ?></label>
                             </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="prorating2" name="providerrating[]" value="2">
                                 <label for="prorating2"><?php echo esc_html__( '2 Star', 'service-finder' ); ?></label>
                             </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox sf-radio-checkbox">
                                 <input type="checkbox" id="prorating1" name="providerrating[]" value="1">
                                 <label for="prorating1"><?php echo esc_html__( '1 Star', 'service-finder' ); ?></label>
                             </div>
                        </div>  
                    </div> 
                </div>
            </div>
            </form>
        </div>
        <!-- Left part END -->    
        
        <!-- Right part start -->
        <div class="col-md-8">  
        
            <div class="sf-serach-result-listing" id="loadfiltered">
            	<div id="loadfiltered">
				<?php
				if(!empty($providers))
				{
					foreach($providers as $provider)
					{
						$providerid = $provider->wp_user_id;
						$profileurl = service_finder_get_author_url($providerid);
						$profileimage = service_finder_get_avatar_by_userid($providerid,'service_finder-provider-medium');
						$providerinfo = service_finder_get_provier_info($providerid);
						$categories = $providerinfo->category_id;
						?>
						<div class="sf-serach-result-wrap">
                            <div class="sf-serach-result-left">
                            	<?php if(service_finder_is_featured($providerid)){ ?>
                                 <div class="sf-featuerd-label"><span><?php echo esc_html__( 'Featured', 'service-finder' ); ?></span></div>
                                <?php } ?> 
                                <div class="sf-serach-result-propic">
                                    <img src="<?php echo esc_url($profileimage); ?>" alt="">
                                    <?php if(service_finder_is_varified_user($providerid)){ ?>
                                    <span class="sf-featured-approve">
                                        <i class="fa fa-check"></i><span><?php esc_html_e('Verified Provider', 'service-finder'); ?></span>
                                    </span>
                                    <?php } ?>
                                </div>
                                <div class="sf-serach-result-bookNow">
                                	<?php
									if(get_post_meta($jobid,'_filled',true)){
										if(get_post_meta($jobid,'_assignto',true) == $providerid){
											echo '<span class="sf-hiring-status status-jobhired">'.esc_html__( 'Hired', 'service-finder' ).'</span>';
										}
									}else{
										$jobexpire = get_post_meta($jobid,'_job_expires',true);
										
										if(strtotime(date('Y-m-d')) > strtotime( $jobexpire )){
											$hireme = '<a href="javascript:;" class="btn btn-primary">'.esc_html__( 'Job Expired', 'service-finder' ).' <i class="fa fa-times"></i></a>';
										}else{
											if(service_finder_has_applied_for_job($jobid,$providerid))
											{
												$walletamount = service_finder_get_wallet_amount($current_user->ID);
												$walletsystem = service_finder_check_wallet_system();
												
												if(service_finder_getUserRole($current_user->ID) == 'Provider' || service_finder_getUserRole($current_user->ID) == 'administrator'){
												$skipoption = true;
												}else{
												$skipoption = false;
												}

												$params = array(
													'jobid' 	=> $jobid,
													'skipoption' 	=> $skipoption,
													'providerid' 	=> $providerid,
													'jobtitle' 	=> get_the_title($jobid),
													'jobprice' 	=> get_post_meta( $jobid, '_job_cost', true ),
													'jobhours' 	=> get_post_meta( $jobid, '_job_hours', true ),
													'walletamount' 	=> $walletamount,
													'walletamountwithcurrency' 	=> service_finder_money_format($walletamount),
													'walletsystem' 	=> $walletsystem,
													'adminfeetype' 	=> service_finder_get_data($service_finder_options,'admin-fee-type'),
													'adminfeefixed' 	=> service_finder_get_data($service_finder_options,'admin-fee-fixed'),
													'adminfeepercentage' 	=> service_finder_get_data($service_finder_options,'admin-fee-percentage'),
												);
												echo '<a href="javascript:;" class="btn btn-primary bookthisprovider" data-params="'.esc_attr(wp_json_encode( $params )).'">'.esc_html__( 'Book Now', 'service-finder' ).'</a>';
											}
										}
									}
									?>
                                    <a href="<?php echo esc_url($profileurl); ?>" target="_blank" class="btn-link"><?php echo esc_html__( 'View Profile', 'service-finder' ); ?></a>
                                    <?php 
									if(get_user_meta($providerid,'primary_category',true) != '')
									{
										echo '<span class="sf-profilecat-label"><a href="'.esc_url(service_finder_getCategoryLink(get_user_meta($providerid,'primary_category',true))).'">'.service_finder_getCategoryName(get_user_meta($providerid,'primary_category',true)).'</a></span>';
									}
									?>
                                </div>
                            </div>
                            <div class="sf-serach-result-right">
                            
                                <div class="sf-serach-result-head">
                                    <h3 class="sf-serach-result-title"><?php echo service_finder_getCompanyName($providerid); ?></h3>
                                    <span class="sf-serach-result-name"><i class="fa fa-user"></i> <?php echo service_finder_getProviderFullName($providerid); ?></span>
                                     <?php if(service_finder_getAddress($providerid) != "" && $service_finder_options['show-postal-address']){ ?>
                                     <div class="sf-serach-result-address"><i class="fa fa-map-marker"></i> <?php echo service_finder_getAddress($providerid); ?> </div>
									 <?php } ?> 	
                                     <div class="sf-serach-result-lable-wrarp">
                                        <?php
                                        if(service_finder_has_sent_invitation($jobid,$providerid))
										{
											echo '<span class="sf-serach-lable-invitation">'.esc_html__( 'Invitation Sent', 'service-finder' ).'</span>';
										}else
										{
											if(!service_finder_has_applied_for_job($jobid,$providerid))
											{
											echo '<span id="jobinvitation-'.$jobid.'-'.$providerid.'"><a class="sf-serach-lable-invitation" href="javascript:;" data-action="invite" data-redirect="no" data-jobid="'.esc_attr($jobid).'" data-providerid="'.esc_attr($providerid).'" data-toggle="modal" data-target="#invite-job">'.esc_html__('Invite for Job', 'service-finder').'</a><span>';
											}
										}
										?>
                                        <?php
                                        if(service_finder_has_applied_for_job($jobid,$providerid))
										{
											echo '<a href="javascript:;" class="sf-serach-lable-quotation provider_description" data-jobid="'.esc_attr($jobid).'" data-providerid="'.esc_attr($providerid).'">'.esc_html__( 'View Quotation', 'service-finder' ).'</a>';
										}
										?>
                                     </div>
                                     <div class="sf-serach-rating-addto">
                                        <div class="sf-serach-ratings">
                                            <?php echo service_finder_displayRating(service_finder_getAverageRating($providerid)); ?>
                                            <span class="sf-serach-ratings-total">
                                            <?php 
											$totalreview = service_finder_get_total_reviews($providerid);
											if($totalreview > 1){
												printf( esc_html__('(%d Reviews)', 'service-finder' ), $totalreview );
											}else{
												printf( esc_html__('(%d Review)', 'service-finder' ), $totalreview );
											}
											?>
                                            </span>
                                        </div>
                                        <?php
                                        $myfav = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$service_finder_Tables->favorites.' where user_id = %d AND provider_id = %d',$current_user->ID,$providerid));
		
										if(!empty($myfav)){
											echo '<a href="javascript:;" id="removefave-'.esc_attr($providerid).'" class="remove-job-favorite sf-serach-addToFav" data-proid="'.esc_attr($providerid).'" data-userid="'.esc_attr($current_user->ID).'"><i class="fa fa-heart"></i></a>';
										}else
										{
											echo '<a href="javascript:;" id="addfave-'.esc_attr($providerid).'" class="add-job-favorite sf-serach-addToFav" data-proid="'.esc_attr($providerid).'" data-userid="'.esc_attr($current_user->ID).'"><i class="fa fa-heart-o"></i></a>';
										}
										?>
                                     </div>
                                     <?php
                                     if($categories != '')
									 {
									 	$displaycat = array();
									 	$categories = explode(',',$categories);
										foreach($categories as $categoryid)
										{
											$displaycat[] = '<a href="'.esc_url(service_finder_getCategoryLink($categoryid)).'">'.service_finder_getCategoryName($categoryid).'</a>';
										}
										?>
										<div class="sf-serach-categoriList">
											<?php echo implode(',',$displaycat); ?>
                                         </div>
										<?php
									 }
									 ?>
                                 </div>
                                 
                                 <div class="sf-serach-result-body">
                                     <div class="sf-serach-proviText">
                                        <?php 
										if($providerinfo->bio != ""){
											echo apply_filters('the_content', $providerinfo->bio);
										}
										?>
                                     </div>
                                 </div>
                                 
                                 <div class="sf-serach-result-footer clearfix">
                                    <?php 
									if(class_exists('aone_messaging')){
										$args = array(
													'view' => 'popup',
													'type' => 'job',
													'targetid' => $jobid,
													'fromid' => $current_user->ID,
													'toid' => $providerid,
												);
										do_action( 'aone_messaging_custom_send_message', $args );
									}
									?>
                                    <?php
									if(service_finder_has_applied_for_job($jobid,$providerid))
									{
										$price =  service_finder_money_format(service_finder_get_job_quote_price($providerid,$jobid));
										echo '<div class="sf-serach-result-price">'.$price.'</div>';
										
									}
									?>
                                 </div>
                            </div>
                        </div>
						<?php
						
						/*echo service_finder_getProviderFullName($providerid);
						
						if(service_finder_has_sent_job_notification($jobid,$providerid))
						{
							echo esc_html__( 'Job publish notification mail has been sent.', 'service-finder' );
						}
						
												
						if(service_finder_has_applied_for_job($jobid,$providerid))
						{
							echo esc_html__( 'Applied for Job', 'service-finder' );
							
							echo esc_html__( 'Quote Price', 'service-finder' ).' '.service_finder_money_format(service_finder_get_job_quote_price($providerid,$jobid));
							
							echo '<a href="javascript:;" class="btn btn-primary" data-jobid="'.esc_attr($jobid).'" data-providerid="'.esc_attr($providerid).'">'.esc_html__( 'Hire Me', 'service-finder' ).'</a>';
						}*/
							
					}
				}else
				{
				echo '<div class="sf-no-results">';
				echo esc_html__('No Results Found', 'service-finder');
				echo '</div>';
				}
				?>
				</div>
				<?php
				require SERVICE_FINDER_BOOKING_LIB_DIR . '/job-booking.php';
				?>
            </div>
        </div>
        <!-- Right part END --> 
        <?php
        }else
		{
			echo service_finder_no_access_layout(esc_html__( 'You are not authorized to', 'service-finder' ),esc_html__( 'access this page.', 'service-finder' ));
		}
		}else
		{
			echo service_finder_no_access_layout(esc_html__( 'Job that you are looking', 'service-finder' ),esc_html__( 'for is not exists', 'service-finder' ));
		}
		?>
    </div>
	<?php
	return ob_get_clean();
}

