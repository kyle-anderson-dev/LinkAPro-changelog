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
$wpdb = service_finder_plugin_global_vars('wpdb');
$service_finder_Tables = service_finder_plugin_global_vars('service_finder_Tables');
$service_finder_options = get_option('service_finder_options');
$paymentsystem = service_finder_plugin_global_vars('paymentsystem');

$walletamount = service_finder_get_wallet_amount($globalproviderid);

wp_add_inline_script( 'service_finder-js-job-form', '/*Declare global variable*/
var walletamount = "'.$walletamount.'";
var user_id = "'.$globalproviderid.'";', 'after' );

$availablelimit = service_finder_get_avl_purchase_credit($globalproviderid);
$joblimitdata = service_finder_get_purchase_credit_data($globalproviderid);
if(!empty($joblimitdata)){
$membershipdate = $joblimitdata->membership_date;
$jobstartdate = $joblimitdata->start_date;
$jobexpire = $joblimitdata->expire_date;
}else{
$membershipdate = '';
$jobstartdate = '';
$jobexpire = ''; 
}
?>
<div class="panel panel-default">
<div class="panel-heading sf-panel-heading">
  <h3 class="panel-tittle m-a0"><span class="fa fa-check-circle-o"></span> <?php echo (!empty($service_finder_options['label-purchase-credit'])) ? esc_html($service_finder_options['label-purchase-credit']) : esc_html__('Purchase Credit Plans', 'service-finder'); ?> </h3>
</div>
<div class="panel-body sf-panel-body padding-30">
 	<div class="joblimit-form-bx" id="sf-limit-bx">
<ul class="row sf-purchase-credit-plans-list list-unstyled" id="sf-purchase-credit-plans">
<?php
$flag = 0;

for($i = 1;$i <= 3;$i++){
	if($service_finder_options['plan'.$i]){
	$flag = 1;
	$plan_name = (!empty($service_finder_options['purchase-credit-package'.$i.'-name'])) ? $service_finder_options['purchase-credit-package'.$i.'-name'] : esc_html__('Plan ', 'service-finder').$i;
	$plan_price = (!empty($service_finder_options['purchase-credit-package'.$i.'-price'])) ? $service_finder_options['purchase-credit-package'.$i.'-price'] : '0.0';
	$plan_limit = (!empty($service_finder_options['purchase-credit-package'.$i.'-limit'])) ? $service_finder_options['purchase-credit-package'.$i.'-limit'] : 0;
	
	if(service_finder_get_purchase_credit_current_plan($globalproviderid) == $i){
	$class = 'selected-plan';
	}else{
	$class = '';
	}
?>
	<li class="col-md-4 sf-purchase-credit-outer <?php echo $class; ?>" data-planid="<?php echo $i; ?>">
		  <div class="sf-plans-bx">
				<h5 class="sf-plans-name"><?php echo esc_html($plan_name); ?></h5>
				<div class="sf-plans-price"><?php echo service_finder_money_format($plan_price); ?></div>
				<div class="sf-plans-connects"><?php echo sprintf( esc_html__('%d connects', 'service-finder'), $plan_limit ); ?> </div>
				<div class="sf-plans-done"><i class="fa fa-check"></i></div>
                <?php if(service_finder_get_purchase_credit_current_plan($globalproviderid) == $i){ ?>
                <div class="sf-current-active"><?php echo esc_html__('Current Package', 'service-finder'); ?></div>
                <?php } ?>
			</div>
	</li>
<?php
	}
}
?>
</ul>
<?php if($flag == 0){ ?>
<div class="alert alert-warning"><?php esc_html_e('There is no active plans.', 'service-finder'); ?></div>
<?php } ?>
<ul class="list-unstyled clear sf-plans-available margin-0">
    <li>
        <h5><?php esc_html_e('Available Limits', 'service-finder'); ?></h5>
        <strong><?php echo sprintf( esc_html__('%d purchase credit', 'service-finder'), $availablelimit ); ?></strong>
    </li>
    <li>
        <h5><?php echo sprintf( esc_html__('Limits with Membership Package. Package Cycle from %s to %s', 'service-finder'), service_finder_date_format($jobstartdate),service_finder_date_format($jobexpire) ); ?></h5>
        <strong>
		<?php
		  $package = get_user_meta($globalproviderid,'provider_role',true);
		  $packageNum = intval(substr($package, 8));
		
	  	  $allowedjobapply = (!empty($service_finder_options['package'.$packageNum.'-purchase-credit'])) ? $service_finder_options['package'.$packageNum.'-purchase-credit'] : '';
		  echo sprintf( esc_html__('%d purchase credit', 'service-finder'), $allowedjobapply );
		?>
	  </strong>
    </li>
</ul>	
  
  <button class="btn btn-primary addpurchasecredit" type="button"><i class="fa fa-plus"></i>
  <?php esc_html_e('Add more Limits', 'service-finder'); ?>
  </button>
  <div id="sf-purchase-credit-paybox" style="display:none;">
  <form class="purchase-credit-payment-form sf-card-group" method="post">
              <?php echo service_finder_display_wallet_amount($globalproviderid); ?>  
	  
	  			<?php
                $payment_methods = (!empty($service_finder_options['payment-methods'])) ? $service_finder_options['payment-methods'] : '';
				$falg = 0;
				if($paymentsystem == 'woocommerce'){
				echo '<div class="col-lg-12" id="purchasecreditskipoption">
				  <div class="form-group form-inline">';
				if(service_finder_getUserRole($current_user->ID) == 'administrator'){
				echo '<div class="radio sf-radio-checkbox">
									<input id="purchasecredit_skipforadmin" type="radio" name="purchasecredit_woopayment" value="skippayment">
									<label for="purchasecredit_skipforadmin">'.esc_html__('Skip Payment','service-finder').'</label>
									<input id="purchasecredit_skippayment" type="hidden" name="payment_mode" value="skippayment">
								</div>';
				}
				echo service_finder_add_wallet_option('purchasecredit_woopayment','purchasecredit');
				echo service_finder_add_woo_commerce_option('purchasecredit_woopayment','purchasecredit');
				echo '</div></div>';						
				?>
				<div class="col-md-12">
                    <input type="hidden" name="plan" value="" id="purchase-credit-planid">
                    <input type="hidden" name="provider_id" value="<?php echo esc_attr($globalproviderid); ?>">
                    <input type="submit" class="btn btn-primary btn-block" name="purchasecredit-payment" value="<?php esc_html_e('Pay Now', 'service-finder'); ?>" />
                </div>
				<?php
				}else{
                if(!empty($payment_methods)){
				echo '<div class="panel-body padding-30">
			          <div class="row"><div class="form-group form-inline">';
                foreach($payment_methods as $key => $value){
                if($key != 'paypal-adaptive' && $key != 'cod' && $key != 'payulatam'){
				if($value){
				$falg = 1;
				}
                    if($key == 'stripe'){
					$label = '<img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/mastercard.jpg" title="'.esc_html__('Stripe','service-finder').'" alt="'.esc_html__('mastercard','service-finder').'"><img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/payment.jpg" title="'.esc_html__('Stripe','service-finder').'" alt="'.esc_html__('american express','service-finder').'"><img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/discover.jpg" title="'.esc_html__('Stripe','service-finder').'" alt="'.esc_html__('discover','service-finder').'"><img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/visa.jpg" title="'.esc_html__('Stripe','service-finder').'" alt="'.esc_html__('visa','service-finder').'">';
					}elseif($key == 'twocheckout'){
					 $label = '<img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/twocheckout.jpg" title="'.esc_html__('2Checkout','service-finder').'" alt="'.esc_html__('2Checkout','service-finder').'">';
					}elseif($key == 'wired'){
					$label = '<img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/wired.jpg" title="'.esc_html__('Wire Transfer','service-finder').'" alt="'.esc_html__('Wired','service-finder').'">';
					}elseif($key == 'payumoney'){
					 $label = '<img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/payumoney.jpg" title="'.esc_html__('PayU Money','service-finder').'" alt="'.esc_html__('PayU Money','service-finder').'">';
					}else{
					$label = '<img src="'.SERVICE_FINDER_BOOKING_IMAGE_URL.'/payment/paypal.jpg" title="'.esc_html__('Paypal','service-finder').'" alt="'.esc_html__('Paypal','service-finder').'">';
					}
                    if($value == 1){
                        echo '<div class="radio sf-radio-checkbox">
                                    <input id="purchasecredit_'.$key.'" type="radio" name="payment_mode" value="'.$key.'">
                                    <label for="purchasecredit_'.esc_attr($key).'">'.$label.'</label>
                                </div>';	
                    }
                }
                }
				
				if(service_finder_getUserRole($current_user->ID) == 'administrator'){
				$falg = 1;
				echo '<div class="radio sf-radio-checkbox">
									<input id="purchasecredit_skippayment" type="radio" name="payment_mode" value="skippayment">
									<label for="purchasecredit_skippayment">'.esc_html__('Skip Payment','service-finder').'</label>
								</div>';
				}
				?>
				<?php echo service_finder_add_wallet_option('payment_mode','purchasecredit'); ?>
				<?php
                echo '</div></div>
			          </div>';
                ?>
		<?php if($falg == 1 || service_finder_check_wallet_system()){ ?>                
      <div id="purchase-credit-cardinfo" class="default-hidden">
        <div class="col-md-8">
          <div class="form-group">
            <label>
            <?php esc_html_e('Card Number', 'service-finder'); ?>
            </label>
            <div class="input-group"> <i class="input-group-addon fa fa-credit-card"></i>
              <input type="text" id="pccd_number" name="pccd_number" class="form-control sf-form-control">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>
            <?php esc_html_e('CVC', 'service-finder'); ?>
            </label>
            <div class="input-group"> <i class="input-group-addon fa fa-ellipsis-h"></i>
              <input type="text" id="pccd_cvc" name="pccd_cvc" class="form-control sf-form-control">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>
            <?php esc_html_e('Select Month', 'service-finder'); ?>
            </label>
            <select id="pccd_month" name="pccd_month" class="form-control sf-form-control sf-select-box" title="Select Month">
              <option value="1"><?php echo esc_html__('January', 'service-finder') ?></option>
              <option value="2"><?php echo esc_html__('February', 'service-finder')?></option>
              <option value="3"><?php echo esc_html__('March', 'service-finder')?></option>
              <option value="4"><?php echo esc_html__('April', 'service-finder')?></option>
              <option value="5"><?php echo esc_html__('May', 'service-finder')?></option>
              <option value="6"><?php echo esc_html__('June', 'service-finder')?></option>
              <option value="7"><?php echo esc_html__('July', 'service-finder')?></option>
              <option value="8"><?php echo esc_html__('August', 'service-finder')?></option>
              <option value="9"><?php echo esc_html__('September', 'service-finder')?></option>
              <option value="10"><?php echo esc_html__('October', 'service-finder')?></option>
              <option value="11"><?php echo esc_html__('November', 'service-finder')?></option>
              <option value="12"><?php echo esc_html__('December', 'service-finder')?></option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>
            <?php esc_html_e('Select Year', 'service-finder'); ?>
            </label>
            <select id="pccd_year" name="pccd_year" class="form-control sf-form-control sf-select-box"  title="Select Year">
              <?php
											$year = date('Y');
                                            for($i = $year;$i<=$year+50;$i++){
												echo '<option value="'.esc_attr($i).'">'.$i.'</option>';
											}
											?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <input type="hidden" name="plan" value="" id="purchase-credit-planid">
        <input type="hidden" name="provider_id" value="<?php echo esc_attr($globalproviderid); ?>">
        <input type="submit" class="btn btn-primary btn-block" name="purchasecredit-payment" value="<?php esc_html_e('Pay Now', 'service-finder'); ?>" />
      </div>
      <?php }else{
	  echo '<div class="alert alert-danger">'.esc_html__('There is no payment gateway available.', 'service-finder').' </div>';
	  }?>
      <?php } ?>
      <?php } ?>
    </form>
  </div>
</div>
</div>
</div>