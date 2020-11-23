<?php

/*****************************************************************************

*

*	copyright(c) - aonetheme.com - Service Finder Team

*	More Info: http://aonetheme.com/

*	Coder: Service Finder Team

*	Email: contact@aonetheme.com

*

******************************************************************************/

get_header(); 

global $post;

if(get_option('timezone_string') != ""){

date_default_timezone_set(get_option('timezone_string'));

}



$url = str_replace('/','\/',$service_finder_Params['homeUrl']);

$adminajaxurl = str_replace('/','\/',admin_url('admin-ajax.php'));



/*For SF Uploader*/

wp_enqueue_style('image-upload', plugins_url('/sf-booking/') . '/assets/manage-uploads/image-upload.css','',null);

		

wp_enqueue_style('image-manager', plugins_url('/sf-booking/') . '/assets/manage-uploads/image-manager.css','',null);



/*For SF Uploader*/

wp_enqueue_script('image-manager', plugins_url('/sf-booking/') . '/assets/manage-uploads/image-manager.js', array('jquery') , null, true);

		

wp_enqueue_script('managefiles', plugins_url('/sf-booking/') . '/assets/manage-uploads/managefiles.js', array('jquery') , null, true);

		

wp_enqueue_script('plupload', SERVICE_FINDER_ASSESTS_ADMINURL . '/load-scripts.php?c=1&load=plupload&ver=4.3.1', array('jquery') , '4.5.1', true);

?>

<div class="page-content">

        

            <!-- inner page banner -->

            <div class="sf-job-info-section">

            	<div class="container">

                    <h2> <?php the_title(); ?> </h2>

                    <?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) { ?>

                        <div class="job-manager-info"><?php _e( 'This listing has expired.', 'service-finder' ); ?></div>

                    <?php } else { ?>

                    <ul class="job-info-list">

                    	<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>

							<?php if ( function_exists( 'wpjm_get_the_job_types' ) ){ ?>

                            <?php $types = wpjm_get_the_job_types(); ?>

                            <?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>

                    

                                <li class="sf-job-timing full-time-job <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>" itemprop="employmentType"><i class="fa fa-clock-o"></i> <?php echo esc_html( $type->name ); ?></li>

                    

                            <?php endforeach; endif; ?>

                            <?php } ?>

                        <?php } ?>

                        <li class="sf-job-addresss"><a href="#"><i class="fa fa-map-marker"></i> <?php the_job_location(); ?></a></li>

                        <li class="sf-job-dates"><i class="fa fa-calendar"></i> <?php echo esc_html__( 'Posted', 'service-finder' ); ?></span> <span><?php printf( __( '%s ago', 'service-finder' ), human_time_diff( get_post_time( 'U' ), current_time('timestamp') ) ); ?></span></li>

                        <li class="sf-job-dates"><i class="fa fa-trash"></i> <?php echo esc_html__( 'Expire Date', 'service-finder' ); ?></span> <span><?php echo date('F j, Y',strtotime(get_post_meta( $post->ID,'_job_expires',true ))); ?></span></li>

                        <li class="sf-job-dates"><i class="fa fa-tasks"></i> <?php echo esc_html__( 'Job Status', 'service-finder' ); ?></span> 

                        <span>

						<?php 

						if(class_exists('service_finder_booking_plugin')) {

						echo strtoupper(service_finder_translate_static_status_string($post->post_status));

						}else{

						echo esc_html(strtoupper($post->post_status));

						}

						?>

                        </span></li>

                    </ul>

                    <?php } ?>

                </div>

           </div>

            <!-- inner page banner END -->

            

            <!-- Breadcrumb  row -->

            <?php require get_template_directory() . '/lib/breadcrumb.php';//Breadcrumb ?>

            <!-- Breadcrumb  row END -->

            

            <?php if ( have_posts() ) : the_post(); ?>

            <!-- Left & right section start -->

            <div class="container">

            

                <div class="section-content provider-content">

                

                    <div class="row">

                    

                        <!-- Left part start -->

                        <div class="col-md-8">



                            <div class="padding-20  margin-b-30  bg-white">

                           	  <h4><?php echo esc_html__( 'Job Details', 'service-finder' ); ?></h4>

                              <div class="sf-job-details-fileds">

                              <?php do_action( 'single_job_listing_start' ); ?>

							  </div>

                              <?php

								/**

								 * single_job_listing_end hook

								 */

								 if(is_user_logged_in()){

								 $current_user = wp_get_current_user(); 

									 if(service_finder_getUserRole($current_user->ID) == 'Provider'){

										echo '<div class="sf-jobdetail-introduction">';

										do_action( 'single_job_listing_end' );

										echo '</div>';

									 }	

								}

								?>

                              <h4><?php echo esc_html__( 'Job Description', 'service-finder' ); ?></h4>

							  <?php echo apply_filters( 'the_job_description', get_the_content() ); ?>                                                 

                              

                             </div>

                             

                        </div>

                        <!-- Left part END -->

                        

                        <!-- Right part start -->

                        <div class="col-md-4">

                        

                            <div class="padding-20  margin-b-30  bg-white">

                                <div class="sf-customerinfo-wrap">

                                    <ul>

                                        <li>

                                            <div class="sf-job-customerimage">

                                                <?php if(class_exists('service_finder_booking_plugin')) { ?>

                                                <img src="<?php echo esc_url(service_finder_get_avatar_by_userid($post->post_author)); ?>"> 

                                                <?php } ?>

                                            </div>

                                            <div class="sf-job-customerinfoinfo">

												<h6 class="sf-job-customer-companyname"><?php the_company_name(); ?></h6>

                                                <?php

                                                if(service_finder_getUserRole($post->post_author) == 'Customer'){

												if(class_exists('service_finder_booking_plugin')) {

												$authorname = service_finder_getCustomerName($post->post_author);

												}else{

												$user_info = get_userdata($post->post_author);

												$authorname = $user_info->user_login;

												}

												}else{

												$user_info = get_userdata($post->post_author);

												$authorname = $user_info->user_login;												

												}

												?>

                                                <span class="sf-job-customername"><?php esc_html_e( 'By', 'service-finder' ); ?>: <?php echo esc_html($authorname); ?></span>

                                            </div>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                            

                            <div class="padding-20  margin-b-30  bg-white">

                                <div class="sf-companyinfo-wrap">

                                    <ul>

                                        <li>

                                            <div class="sf-job-companylogo">

                                                <?php the_company_logo(); ?>

                                            </div>

                                            <div class="sf-job-companyinfo">

												<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>

                                                    <?php if ( function_exists( 'wpjm_get_the_job_types' ) ){ ?>

                                                    <?php $types = wpjm_get_the_job_types(); ?>

                                                    <?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>

                                            

                                                        <a href="javascript:void(0);" class="sf-jobcompanybtn"> <?php echo esc_html( $type->name ); ?></a>

                                            

                                                    <?php endforeach; endif; ?>

                                                    <?php } ?>

                                                <?php } ?>

                                                   

                                                <h6 class="sf-jobcompanytitle"><a href="javascript:;"> <?php the_title(); ?></a></h6>

                                                <?php if ( candidates_can_apply() ) : ?>

                                                <?php get_job_manager_template( 'job-application.php' ); ?>

                                                <?php endif; ?> 

                                            </div>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                            

                            <h4><?php esc_html_e( 'Address info', 'service-finder' ) ?></h4>                         

                            <div class="padding-20  margin-b-30  bg-white">

                                <ul class="job-info-detail">

                                	<li><i class="fa fa-map-marker"></i><?php the_job_location(); ?></li> 

                                </ul>

                                <?php echo service_finder_get_direction($post); ?>

                            </div>



                        	<?php if(service_finder_is_related_jobs($post)){ ?>

                            <h4><?php esc_html_e( 'Related Jobs', 'service-finder' ) ?></h4>

                            <div class="padding-20  margin-b-30  bg-white">

                                <div class="sf-relatedjobs-listing">

                                    <?php echo service_finder_related_jobs($post); ?>

                                </div>

                            </div>     

                            <?php } ?>

                            

                        	<h4><?php esc_html_e( 'Share this Job', 'service-finder' ) ?></h4>

                            <div class="padding-20  margin-b-30  bg-white">

                                <div class="sf-share-social">

                                    <?php echo service_finder_share_jobs($post); ?>

                                </div>

                            </div>                                                     

                        </div>

                        <!-- Right part END -->

                        

                    </div>

                

                </div>

                

            </div>

            <!-- Left & right section  END -->

            <?php endif; ?>

        

        

        </div>

<?php get_footer(); ?>

