<?php global $post; ?>
<?php 
if(get_option('timezone_string') != ""){
date_default_timezone_set(get_option('timezone_string'));
}
?>
<?php if(service_finder_themestyle_fortheme() == 'style-3'){ ?>
<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_lat ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_long ); ?>">
    <a class="job-clickable-box" href="<?php the_job_permalink(); ?>"></a>
    <div class="job-comapny-logo"><?php the_company_logo(); ?></div>
        <div class="job-comapny-info">
            <div class="position">
                <h3><?php the_title(); ?></h3>
                <div class="company">
                    <?php the_company_name( '<strong>', '</strong> ' ); ?>
                    <?php the_company_tagline( '<span class="tagline">', '</span>' ); ?>
                    <?php printf( __( '%s ago', 'service-finder' ), human_time_diff( get_post_time( 'U' ), current_time('timestamp') ) ); ?>
                </div>
            </div>
            <div class="location">
                <?php the_job_location( false ); ?>
            </div>
            <ul class="meta">
                <?php do_action( 'job_listing_meta_start' ); ?>
    			
                <?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
					<?php $types = wpjm_get_the_job_types(); ?>
                    <?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>
                        <li class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>" itemprop="employmentType"><?php echo esc_html( $type->name ); ?></li>
                    <?php endforeach; endif; ?>
                <?php } ?>
                <?php do_action( 'job_listing_meta_end' ); ?>
            </ul>
            <div class="job-cost">
                <?php
                 $cost = get_post_meta( $post->ID, '_job_cost', true );
				 echo service_finder_money_format( $cost );
				?>
            </div>
        </div>
</li>
<?php }else{ ?>
<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_lat ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_long ); ?>">
    <a class="job-clickable-box" href="<?php the_job_permalink(); ?>"></a>
    <div class="job-comapny-logo"><?php the_company_logo(); ?></div>
        <div class="job-comapny-info">
            <div class="position">
                <h3><?php the_title(); ?></h3>
                <div class="company">
                    <?php the_company_name( '<strong>', '</strong> ' ); ?>
                    <?php the_company_tagline( '<span class="tagline">', '</span>' ); ?>
                </div>
            </div>
            <div class="location">
                <?php the_job_location( false ); ?>
            </div>
            <ul class="meta">
                <?php do_action( 'job_listing_meta_start' ); ?>
    			
                <?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
					<?php $types = wpjm_get_the_job_types(); ?>
                    <?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>
                        <li class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>" itemprop="employmentType"><?php echo esc_html( $type->name ); ?></li>
                    <?php endforeach; endif; ?>
                <?php } ?>
                <li class="date"><date><?php printf( __( '%s ago', 'service-finder' ), human_time_diff( get_post_time( 'U' ), current_time('timestamp') ) ); ?></date></li>
    
                <?php do_action( 'job_listing_meta_end' ); ?>
            </ul>
        </div>
</li>
<?php } ?>