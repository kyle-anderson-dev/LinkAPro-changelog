<?php
global $wpdb,$service_finder_options,$service_finder_Tables;

wp_enqueue_script('sf-job-search');


	$category = service_finder_get_data($_GET,'category');
	$city = service_finder_get_data($_GET,'city');
	$catdetails = get_term_by('name', $category, 'job_listing_category');
	$catid = $catdetails->term_id;
	
	
	$usercatdetails = get_term_by('name', $category, 'providers-category');
	$usercatid = $usercatdetails->term_id;
	$bannerimg = service_finder_getCategoryBGImage($usercatid,'full');
	
	$args = array(
		'post_type' 	=> 'jobqa',
		'post_status' 	=> 'publish',
		'posts_per_page' => -1,
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'job_listing_category',
				'field'    => 'term_id',
				'terms'    => $catid
			)
		)
	);
	
	$the_query = new WP_Query( $args );
	ob_start();
	$actionurl = service_finder_get_url_by_shortcode('[submit_job_form]');
	
	?>
    <div id="pixjob-qaform" style="background-image:url(<?php echo esc_url($bannerimg); ?>);">
	<h4><?php echo sprintf(esc_html__('Get quotes for %s in %s', 'service-finder'),$category,$city); ?></h4>
	<?php
	echo '<form class="clearfix job-search-form" method="post" action="'.$actionurl.'">';
	if ( $the_query->have_posts() ) {
	echo '<div class="slider-jobqas owl-carousel-jobqa" id="jobqa-main">';
	while( $the_query->have_posts() ) : $the_query->the_post();
	global $post;
	?>
	<div id="jobqa-item-<?php echo esc_attr($post->ID); ?>" class="jobqa-item-box">
	<div class="jobqa-question"><?php echo get_the_title(); ?></div>
    <input class="jobqaans" data-toggle="toggle" data-on="<?php esc_html_e('True', 'service-finder'); ?>" data-off="<?php esc_html_e('False', 'service-finder'); ?>" type="checkbox" name="jobqa_<?php echo esc_attr($post->ID); ?>">
    </div>
	
	<?php
	endwhile;
	echo '</div>';
	echo '<div id="finishjobouter"><input type="submit" class="btn btn-primary finishjobqa" value="'.esc_html__('Continue', 'service-finder').'"></div>';
	echo '<input type="hidden" name="jobqastring">';
	echo '<input type="hidden" name="catid" value="'.$catid.'">';
	echo '<input type="hidden" name="location" value="'.$city.'">';
	wp_reset_postdata();
	}else{
	echo '<div id="jobqa-notfount">'.esc_html__('Not Found.', 'service-finder').'</div>';
	}
	
	echo '</form>';
	?>
	</div>