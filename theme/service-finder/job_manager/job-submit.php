<?php
/**
 * Job Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $job_manager;
$current_user = wp_get_current_user(); 
$service_finder_options = get_option('service_finder_options');
$availablelimit = '';
if(class_exists('service_finder_booking_plugin')) {
$availablelimit = service_finder_get_avl_job_limits($current_user->ID);
}

$jobpostingtype = (!empty($service_finder_options['job-posting-type'])) ? esc_html($service_finder_options['job-posting-type']) : '';

if(service_finder_UserRole($current_user->ID) == 'Customer' || service_finder_UserRole($current_user->ID) == 'administrator' || !is_user_logged_in()){
if($jobpostingtype == 'free' || ($jobpostingtype == 'paid' && $availablelimit > 0 && is_user_logged_in()) || ($jobpostingtype == 'paid' && !is_user_logged_in())){
?>
<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-job-form" class="job-manager-form" enctype="multipart/form-data">

	<?php do_action( 'submit_job_form_start' ); ?>

	<?php if ( apply_filters( 'submit_job_form_show_signin', true ) ) : ?>

		<?php get_job_manager_template( 'account-signin.php' ); ?>

	<?php endif; ?>

	<?php if ( job_manager_user_can_post_job() || job_manager_user_can_edit_job( $job_id ) ) : ?>

		<!-- Job Information Fields -->
		<?php do_action( 'submit_job_form_job_fields_start' ); ?>

		<?php foreach ( $job_fields as $key => $field ) : 
		$fieldreq = (isset($field['required'])) ? $field['required'] : '';
		$fieldtype = (isset($field['type'])) ? $field['type'] : '';
		?>
			<fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
				<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html($field['label']) . apply_filters( 'submit_job_form_required_label', $fieldreq ? '' : ' <small>' . __( '(optional)', 'service-finder' ) . '</small>', $field ); ?></label>
				<div class="field <?php echo sanitize_html_class(($fieldreq) ? 'required-field' : ''); ?>">
					<?php get_job_manager_template( 'form-fields/' . $fieldtype . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
				</div>
			</fieldset>
		<?php endforeach; ?>

		<?php do_action( 'submit_job_form_job_fields_end' ); ?>

		<!-- Company Information Fields -->
		<?php if ( $company_fields ) : ?>
			<h2><?php _e( 'Company Details', 'service-finder' ); ?></h2>

			<?php do_action( 'submit_job_form_company_fields_start' ); ?>

			<?php foreach ( $company_fields as $key => $field ) : 
			$fieldreq = (isset($field['required'])) ? $field['required'] : '';
			$fieldtype = (isset($field['type'])) ? $field['type'] : '';
			?>
				<fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
					<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html($field['label']) . apply_filters( 'submit_job_form_required_label', $fieldreq ? '' : ' <small>' . __( '(optional)', 'service-finder' ) . '</small>', $field ); ?></label>
					<div class="field <?php echo sanitize_html_class($fieldreq ? 'required-field' : ''); ?>">
						<?php get_job_manager_template( 'form-fields/' . $fieldtype . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
					</div>
				</fieldset>
			<?php endforeach; ?>

			<?php do_action( 'submit_job_form_company_fields_end' ); ?>
		<?php endif; ?>

		<?php do_action( 'submit_job_form_end' ); ?>

		<p>
			<input type="hidden" name="job_manager_form" value="<?php echo esc_attr($form); ?>" />
			<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
			<input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
			<input type="submit" name="submit_job" class="button" value="<?php echo esc_attr( $submit_button_text ); ?>" />
		</p>

	<?php else : ?>

		<?php do_action( 'submit_job_form_disabled' ); ?>

	<?php endif; ?>
</form>
<?php }else{
$account_url = '';
if(class_exists('service_finder_booking_plugin')) {
$account_url = service_finder_get_url_by_shortcode('[service_finder_my_account]');
}
$planpage = add_query_arg( array('action' => 'job-post-plans'), $account_url );

echo esc_html__('You do not have available connects.', 'service-finder'); 
echo esc_html__(' Please ', 'service-finder'); 
echo '<a href="'.esc_url($planpage).'" target="_blank"><u>'.esc_html__('click here ', 'service-finder').'</u></a>'; 
echo esc_html__('to upgrade your plan.', 'service-finder'); 
}
}else{
echo esc_html__('You are not allowed to post a job.', 'service-finder'); 
}
?>
