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
$wpdb = service_finder_shortcode_global_vars('wpdb');


/*Get Searched Providers*/

function service_finder_get_providers($category = '',$location = '',$featured = 0, $orderby = 'title',$order = 'ASC', $limit = '', $offset = 0){

	global $wpdb, $service_finder_Tables;

if($featured == 1){
$sql = 'SELECT providers.id,providers.wp_user_id, providers.bio, providers.avatar_id, providers.full_name, providers.phone, providers.mobile, providers.email, providers.phone, providers.lat, providers.long, providers.category_id, providers.address, providers.country, providers.city FROM '.$service_finder_Tables->providers.' as providers WHERE featured = "'.$featured.'" AND admin_moderation = "approved" AND account_blocked != "yes"';
}else{
$sql = 'SELECT providers.id,providers.wp_user_id, providers.bio, providers.avatar_id, providers.full_name, providers.phone, providers.mobile, providers.email, providers.phone, providers.lat, providers.long, providers.category_id, providers.address, providers.country, providers.city FROM '.$service_finder_Tables->providers.' as providers WHERE  admin_moderation = "approved" AND account_blocked != "yes"';
}

$category_id = $category;

if($category_id != '' && $location != ''){
$sql .= ' AND';
$texonomy = 'providers-category';
$term_children = get_term_children($category_id,$texonomy);

if(!empty($term_children)){
$sql .= ' (';
	foreach($term_children as $term_child_id) {
		
		$sql .= ' FIND_IN_SET("'.$term_child_id.'", providers.category_id) OR ';
		
	}
$sql .= ' FIND_IN_SET("'.$category_id.'", providers.category_id) ';	
$sql .= ' ) AND';	
	
}else{

$sql .= ' FIND_IN_SET("'.$category_id.'", providers.category_id) AND';

}

$sql .= ' (providers.city LIKE "'.$location.'" OR providers.state LIKE "'.$location.'" OR providers.country LIKE "'.$location.'")';

}

if($category_id != '' && $location == ''){
$sql .= ' AND';
$texonomy = 'providers-category';
$term_children = get_term_children($category_id,$texonomy);

if(!empty($term_children)){
$sql .= ' (';
	foreach($term_children as $term_child_id) {
		
		$sql .= ' FIND_IN_SET("'.$term_child_id.'", providers.category_id) OR ';
		
	}
$sql .= ' FIND_IN_SET("'.$category_id.'", providers.category_id) ';	
$sql .= ' )';	
	
}else{

$sql .= ' FIND_IN_SET("'.$category_id.'", providers.category_id)';

}

}

if($category_id == '' && $location != ''){
$sql .= ' AND';
$sql .= ' (providers.city LIKE "'.$location.'" OR providers.state LIKE "'.$location.'" OR providers.country LIKE "'.$location.'")';

}


$providers_total = $wpdb->get_results($sql);
$total = count($providers_total);

if($orderby == 'title'){
$orderby = ' ORDER BY full_name '.$order;
}elseif($orderby == 'rating'){
$orderby = ' ORDER BY rating '.$order;
}elseif($orderby == 'rand'){
$orderby = ' ORDER BY RAND()';
}else{
$orderby = ' ORDER BY id '.$order;
}

if($limit != '' && $limit > 0){
$sql .= $orderby.' LIMIT '.$offset.','.$limit;
}else{
$sql .= $orderby;
}


$providers = $wpdb->get_results($sql);

$res = array(
		'count' => $total,
		'srhResult' => $providers
		);

return $res;

}

/*Get Quote Ajax Call*/
add_action('wp_ajax_get_quotation_shortcode', 'service_finder_get_quotation_shortcode');
add_action('wp_ajax_nopriv_get_quotation_shortcode', 'service_finder_get_quotation_shortcode');

function service_finder_get_quotation_shortcode(){
global $wpdb, $service_finder_Tables, $service_finder_options;

$customer_name = (!empty($_POST['customer_name'])) ? $_POST['customer_name'] : '';
$customer_email = (!empty($_POST['customer_email'])) ? $_POST['customer_email'] : '';
$phone = (!empty($_POST['phone'])) ? $_POST['phone'] : '';
$description = (!empty($_POST['description'])) ? $_POST['description'] : '';
$captcha_code = (!empty($_POST['captcha_code'])) ? $_POST['captcha_code'] : '';
$captchaon = (!empty($_POST['captchaon'])) ? $_POST['captchaon'] : 0;

			if($captchaon == 1){
			if((empty($_SESSION['captcha_code_requestquote'] ) || strcasecmp($_SESSION['captcha_code_requestquote'], $captcha_code) != 0) && (strcasecmp($_SESSION['captcha_code_requestquotepopup'], $captcha_code) != 0 || empty($_SESSION['captcha_code_requestquotepopup'] ))){  
				$error = array(
						'status' => 'error',
						'err_message' => esc_html__('The Validation code does not match!', 'service-finder'),
						);
				echo json_encode($error);
				exit;
			}
			}

			$adminemail = get_option( 'admin_email' );

			if(!empty($service_finder_options['quote-to-admin'])){
				$adminmessage = $service_finder_options['quote-to-admin'];
			}else{
				$adminmessage = 'Requesting for Quotation

Customer Name: %CUSTOMERNAME%

Email: %EMAIL%

Phone: %PHONE%

Description: %DESCRIPTION%
';
			}
			
			$tokens = array('%CUSTOMERNAME%','%EMAIL%','%PHONE%','%DESCRIPTION%');
			$replacements = array($customer_name,$customer_email,$phone,$description);
			$msg_body = str_replace($tokens,$replacements,$message);
			$adminmsg_body = str_replace($tokens,$replacements,$adminmessage);
			
			if($service_finder_options['quote-to-admin-subject'] != ""){
				$adminmsg_subject = $service_finder_options['quote-to-admin-subject'];
			}else{
				$adminmsg_subject = esc_html__('Request a Quotation', 'service-finder');
			}
			
			$msg = (!empty($service_finder_options['get-quote'])) ? $service_finder_options['get-quote'] : esc_html__('Message has been sent', 'service-finder');
			
			if(service_finder_wpmailer($adminemail,$adminmsg_subject,$adminmsg_body)) {
				$success = array(
						'status' => 'success',
						'suc_message' => $msg
						);
				echo json_encode($success);
			} else {
				$error = array(
						'status' => 'error',
						'err_message' => esc_html__('Message could not be sent.', 'service-finder'),
						);
				echo json_encode($error);
			}
			
exit;
} 

/*theme style for plugin*/
function service_finder_themestyle_for_plugin() {
	global $service_finder_options;
	
	$themestyle = (isset($service_finder_options['theme-style'])) ? esc_html($service_finder_options['theme-style']) : '';
	return $themestyle;
}

/*After title seprator*/
function service_finder_title_separator($color = '') {
	global $service_finder_options;
	
	$titleseparator = (isset($service_finder_options['after-title-separator'])) ? esc_html($service_finder_options['after-title-separator']) : true;
	$titleseparatoricon = (isset($service_finder_options['icon-between-devider']['url'])) ? esc_html($service_finder_options['icon-between-devider']['url']) : true;
	if($titleseparator && service_finder_themestyle_for_plugin() != 'style-3'){
	return '<div class="after-titile-line" style="background-image:url('.esc_url($titleseparatoricon).')"><span class="title-line-left" style="background-color:'.$color.'"></span><span class="title-line-right" style="background:'.$color.'"></span></div>';
	}else{
	return '';
	}
		
}

/*Translate month name*/
if (!function_exists( 'service_finder_translate_monthname' ) ){
function service_finder_translate_monthname($month) {
    switch ($month) {
	case 1:
		$mname = esc_html__('Jan', 'service-finder' );
		break;
	case 2:
		$mname = esc_html__('Feb', 'service-finder' );
		break;
	case 3:
		$mname = esc_html__('Mar', 'service-finder' );
		break;
	case 4:
		$mname = esc_html__('Apr', 'service-finder' );
		break;
	case 5:
		$mname = esc_html__('May', 'service-finder' );
		break;
	case 6:
		$mname = esc_html__('Jun', 'service-finder' );
		break;
	case 7:
		$mname = esc_html__('Jul', 'service-finder' );
		break;
	case 8:
		$mname = esc_html__('Aug', 'service-finder' );
		break;
	case 9:
		$mname = esc_html__('Sep', 'service-finder' );
		break;
	case 10:
		$mname = esc_html__('Oct', 'service-finder' );
		break;
	case 11:
		$mname = esc_html__('Nov', 'service-finder' );
		break;
	case 12:
		$mname = esc_html__('Dec', 'service-finder' );
		break;
	}
	return $mname;
}
}

/* Get youtube id from url */
function service_finder_get_youtubeid_from_url($url)
{
  $url_string = parse_url($url, PHP_URL_QUERY);
  parse_str($url_string, $args);
  return isset($args['v']) ? $args['v'] : false;
}

/*theme style for plugin*/
function service_finder_manage_shortcode(){
	global $service_finder_options;
	
	$manageshortcode = get_option('manageshortcode_from_themeoption');
	
	return $manageshortcode;
}

/*Check is new installation or existing client*/
function service_finder_check_new_client_for_shortcode(){
	global $wpdb, $service_finder_Tables, $service_finder_options;
	$flag = 0;
	$result = $wpdb->get_results('SHOW TABLES');
	$dbname = key($result[0]);
	foreach ($result as $mytable)
    {
        if($mytable->$dbname == 'service_finder_cities')
		{
			$flag = 1;
			break;
		}
    }
	
	if($flag == 1)
	{
		return false;
	}else{
		return true;
	}
}