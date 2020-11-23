<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// If checks to determine which template/form to show the user
if ( isset( $_GET['confirmemail'] ) && isset( $_GET['key'] ) && isset( $_GET['email'] ) ) {

	$key = (isset($_GET['key'])) ? sanitize_text_field($_GET['key']) : '';
	$email = (isset($_GET['email'])) ? sanitize_text_field($_GET['email']) : '';
	
	$savedkey = get_option('_confirmemail_'.$email);
	
	if($savedkey == $key)
	{
		echo '<div class="alert alert-success">';
		echo esc_html__('You email confirmed successfully.', 'service-finder');
		echo '</div>';
		delete_option('_confirmemail_'.$email);
	}elseif($savedkey != $key)
	{
		echo '<div class="alert alert-danger">';
		echo esc_html__('That key is not valid', 'service-finder');
		echo '</div>';
	}else
	{
		echo '<div class="alert alert-danger">';
		echo esc_html__('That key is not valid', 'service-finder');
		echo '</div>';
	}
	

} 
?>