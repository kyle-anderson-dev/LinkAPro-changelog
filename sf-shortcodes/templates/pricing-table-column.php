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

if(service_finder_themestyle_for_plugin() == 'style-2'){
$class = 'sf-pricing-box-new';
}else{
$class = '';
}

$highlight = (isset($a['highlight'])) ? esc_html($a['highlight']) : 'no';
$packagecolor = (isset($a['color'])) ? esc_html($a['color']) : '';

if($highlight == 'yes'){
$highlightclass = 'sf-pricing-highlight';
}else{
$highlightclass = '';
}

$signup = '';

$signuptype = (isset($a['signuptype'])) ? esc_html($a['signuptype']) : '';
$packagenumber = (isset($a['packagenumber'])) ? esc_html($a['packagenumber']) : '';

if(!is_user_logged_in()){

if($signuptype == 'popup'){
$signup = '<div class="pricingtable-footer" style=" background-color:'.esc_attr($packagecolor).'">
            <a class="btn btn-primary" href="javascript:;" data-action="signup" data-package="'.$packagenumber.'" data-redirect="no" data-toggle="modal" data-target="#login-Modal">'.esc_html__('Sign Up','service-finder').'</a>
        </div>';

}else{

$link = add_query_arg( array(
    'package' => $packagenumber,
), $a['link'] );

$signup = '<div class="pricingtable-footer" style=" background-color:'.esc_attr($packagecolor).'">
            <a class="btn btn-primary " href="'.esc_url($link).'" target="_blank">'.esc_html__('Sign Up','service-finder').'</a>
        </div>';

}

}

if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<div class="col-md-3 col-sm-6 equal-col">
    <div class="pricing-tables-wrap <?php echo sanitize_html_class($class).' '.sanitize_html_class($highlightclass); ?>">
        <div class="pricing-tables-top">
            <div class="pricing-tables-name"><?php echo esc_html($a['title']); ?></div>
            <div class="pricing-tables-text"><?php echo esc_html($a['tagline']); ?></div>
            <div class="pricing-tables-money" style="background-color:<?php echo esc_attr($packagecolor); ?>">
                <strong><?php echo esc_html($a['price']); ?></strong>
                <span><?php echo esc_html($a['period']); ?></span>
            </div>
            <?php if($highlight == 'yes'){ ?>
            <div class="sf-package-highlight"><span><?php echo esc_html__('Best Value','service-finder'); ?></span></div>
            <?php } ?>
        </div>
        <div class="pricing-tables-midd">
            <ul class="pricing-tables-list">
                <?php echo do_shortcode( $content ); ?>
            </ul>
        </div>
        <?php
        if(!is_user_logged_in())
		{
		if($signuptype == 'popup'){
		?>
		<div class="pricing-tables-bottom" style=" background-color:<?php echo esc_attr($packagecolor); ?>">
            <a class="btn btn-primary" href="javascript:;" data-action="signup" data-package="<?php echo esc_attr($packagenumber) ?> " data-redirect="no" data-toggle="modal" data-target="#login-Modal">
            <?php echo esc_html__('Sign Up','service-finder'); ?>
            </a>
        </div>
		<?php
		}else{
		?>
        <div class="pricing-tables-bottom" style=" background-color:<?php echo esc_attr($packagecolor); ?>">
            <a href="<?php echo esc_url($link); ?>" class="btn btn-primary"><?php echo esc_html__('Sign Up','service-finder'); ?></a>
        </div>
        <?php
		}
        }
		?>
    </div>                                
</div>
<?php
$html = ob_get_clean();
}else{
if($a['period'] != '')
{
	$periodtypeclass = 'pricingtable-type';
}else{
	$periodtypeclass = '';
}
$html = '<div class="col-sm-6 col-md-3 col-lg-3 equal-col pricingtable-cell">
<div class="pricingtable-wrapper '.sanitize_html_class($class).' '.sanitize_html_class($highlightclass).'">
    <div class="pricingtable-inner">
    
        <div class="pricingtable-price" style=" background-color:'.esc_attr($packagecolor).'">
            <span class="pricingtable-bx">'.esc_html($a['price']).'</span>
            <span class="'.sanitize_html_class($periodtypeclass).'">'.esc_html($a['period']).'</span>
        </div>
        
        <div class="pricingtable-title" style=" background-color:'.esc_attr($packagecolor).'">
            <h2>'.esc_html($a['title']).'</h2>
        </div>
        
        <ul class="pricingtable-features">
            '.do_shortcode( $content ).'
        </ul>
        
        '.$signup.'
    
    </div>
</div>
</div>';
}
?>
