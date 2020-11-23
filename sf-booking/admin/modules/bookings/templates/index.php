<?php 
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<!--Template for bookings in admin panel-->
<?php
$service_finder_options = get_option('service_finder_options');
$providerreplacestring = (!empty($service_finder_options['provider-replace-string'])) ? $service_finder_options['provider-replace-string'] : esc_html__('Provider', 'service-finder');	
$customerreplacestring = (!empty($service_finder_options['customer-replace-string'])) ? $service_finder_options['customer-replace-string'] : esc_html__('Customers', 'service-finder');	
$admin_fee_label = (!empty($service_finder_options['admin-fee-label'])) ? esc_html($service_finder_options['admin-fee-label']) : esc_html__('Admin Fee', 'service-finder');

if(service_finder_get_data($_GET,'filterbookings') != '')
{
	$filterbookings = service_finder_get_data($_GET,'filterbookings');
}else
{
	$filterbookings = '';
}
wp_add_inline_script( 'admin-booking-form', 'var filterbookings = "'.$filterbookings.'";', 'after' );

?>
<div class="sf-wpbody-inr">
  <div class="sedate-title">
    <h2>
      <?php esc_html_e( 'Bookings', 'service-finder' ); ?>
    </h2>
  </div>
  <div class="sf-by-provider"> 
    <div class="row">
    <div class="col-sm-6">
	<?php echo esc_html__( 'By', 'service-finder' ).' '.esc_html($providerreplacestring); ?> -
    <select name="byprovider" id="byprovider" class="sf-select-box form-control sf-form-control">
      <?php
if(!empty($args)){
	echo '<option value="">'.esc_html__( 'All ', 'service-finder' ).esc_html($providerreplacestring).'</option>';
	foreach($args as $arg){
	echo '<option value="'.esc_attr($arg->full_name).'">'.$arg->full_name.'</option>';
	}
}else{
	echo '<option value="">'.esc_html__( 'No Providers Found', 'service-finder' ).'</option>';
}
?>
    </select>
    </div>
    <div class="col-sm-6">
    <?php esc_html_e( 'By Date', 'service-finder' ); ?> -
    <?php
    $pageurl = menu_page_url( 'bookings', false );
	?>
    <select name="bydate" id="bydate" class="sf-select-box form-control sf-form-control" data-pageurl="<?php echo esc_attr($pageurl); ?>">
      <option value="">
      <?php esc_html_e( 'All Days', 'service-finder' ); ?>
      </option>
      <option value="today">
      <?php esc_html_e( 'Today', 'service-finder' ); ?>
      </option>
      <option value="yesterday">
      <?php esc_html_e( 'Yesterday', 'service-finder' ); ?>
      </option>
      <option value="tomorrow">
      <?php esc_html_e( 'Tomorrow', 'service-finder' ); ?>
      </option>
      <option value="last_7">
      <?php esc_html_e( 'Last 7 Days', 'service-finder' ); ?>
      </option>
      <option value="last_30">
      <?php esc_html_e( 'Last 30 Days', 'service-finder' ); ?>
      </option>
      <option value="next_7">
      <?php esc_html_e( 'Next 7 Days', 'service-finder' ); ?>
      </option>
      <option value="this_month">
      <?php esc_html_e( 'This Month', 'service-finder' ); ?>
      </option>
      <option value="next_month">
      <?php esc_html_e( 'Next Month', 'service-finder' ); ?>
      </option>
    </select>
    </div>
    </div>
  </div>
  
  <div class="datatable-outer">
  <div class="table-responsive">
    <table id="admin-bookings-grid" class="table table-striped sf-table">
    <thead>
      <tr>
        <th></th>
        <th><input type="checkbox"  id="bulkAdminBookingsDelete"  />
          <button id="deleteAdminBookingTriger" class="btn btn-danger btn-xs">
          <i class="fa fa-trash-o"></i>
          </button></th>
        <th><?php esc_html_e( 'Booking Reference ID #', 'service-finder' ); ?></th>
        <th><?php esc_html_e( 'Date/Time', 'service-finder' ); ?></th>
        <th><?php echo sprintf( esc_html__('%s Name', 'service-finder'), $providerreplacestring ); ?></th>
        <th><?php echo sprintf( esc_html__('%s Name', 'service-finder'), $customerreplacestring ); ?></th>
        <th><?php esc_html_e( 'Upcoming or Past', 'service-finder' ); ?></th>
        <th><?php esc_html_e( 'Type', 'service-finder' ); ?></th>
        <th><?php esc_html_e( 'Payment Status', 'service-finder' ); ?></th>
        <th><?php esc_html_e( 'Booking Amount', 'service-finder' ); ?></th>
        <th><?php esc_html_e( 'Booking Status', 'service-finder' ); ?></th>
        <th><?php echo sprintf( esc_html__('Pay to %s via Bank Transffer', 'service-finder'), $providerreplacestring ); ?></th>
        <th><?php echo sprintf( esc_html__('Pay to %s via Paypal/Stripe/Mangopay', 'service-finder'), $providerreplacestring ); ?></th>
        <th><?php esc_html_e( 'Actions', 'service-finder' ); ?></th>
      </tr>
    </thead>
    </table>
    <div id="booking-details" class="hidden"> </div>
  </div>
  </div>
</div>
<!-- Loading area start -->
<div class="loading-area default-hidden">
  <div class="loading-box"></div>
  <div class="loading-pic"></div>
</div>
<!-- Loading area end -->