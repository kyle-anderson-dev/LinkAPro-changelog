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

$available = (isset($a['available'])) ? esc_html($a['available']) : '';
$availableclass = ($available == 'yes') ? 'check' : 'times';
$notavailableclass = ($available == 'no') ? 'sf-featued-no-provide' : '';
if(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<li class="<?php echo sanitize_html_class($notavailableclass); ?>"><i class="fa fa-<?php echo sanitize_html_class($availableclass); ?>"></i> <?php echo esc_html($a['title']); ?></li>
<?php
$html = ob_get_clean();
}else{
$html = '<li class="'.sanitize_html_class($notavailableclass).'"><i class="fa '.sanitize_html_class($availableclass).'"></i> '.esc_html($a['title']).'</li>'; 
}

?>

