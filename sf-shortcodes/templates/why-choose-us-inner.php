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
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<div class="col-md-4 col-sm-4">
  <div class="sf-why-choose w-t-element padding-lr-20">
        <div class="sf-icon-xl margin-b-20">
            <img src="<?php echo esc_url($a['img']); ?>" width="220" height="200" alt="">
        </div>
        <h4 class="sf-tilte margin-b-10"><?php echo esc_html($a['title']); ?></h4>
        <p><?php echo wp_kses_post($content); ?></p>
  </div>
</div>
<?php
$html = ob_get_clean();
}else
{
$html = '<div class="col-md-4">
		  <div class="sf-why-choose w-t-element padding-lr-20">
				<div class="sf-icon-xl margin-b-20">
					<img src="'.esc_url($a['img']).'" width="220" height="200" alt="">
				</div>
				<h4 class="sf-tilte margin-b-10">'.esc_html($a['title']).'</h4>
				<p>'.$content.'</p>
				
		  </div>
		</div>';
}
?>

