<?php
global $wpdb,$service_finder_options,$service_finder_Tables;

wp_enqueue_style('sf-jquery-ui');
wp_enqueue_script('sf-jquery-ui');
wp_enqueue_script('sf-job-search');


$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_plugin_global_vars('wpdb');
$service_finder_Tables = service_finder_plugin_global_vars('service_finder_Tables');
$searchAddress = service_finder_get_data($_REQUEST,'searchAddress');
$keyword = service_finder_get_data($_REQUEST,'keyword');
$zipcode = service_finder_get_data($_REQUEST,'zipcode');
$price = service_finder_get_data($_REQUEST,'price');
$identitycheck = service_finder_get_data($service_finder_options,'identity-check');
$restrictuserarea = service_finder_get_data($service_finder_options,'restrict-user-area');
$providerreplacestring = service_finder_provider_replace_string();
$searchprice = service_finder_get_data($service_finder_options,'search-price');
$searchradius = service_finder_get_data($service_finder_options,'search-radius');
$defaultradius = service_finder_get_data($service_finder_options,'default-radius',0);
$searchbtntext = service_finder_get_data($service_finder_options,'search-btn-text',esc_html__('Search Now', 'service-finder'));
$minpricerange = 0;
$maxpricerange = service_finder_get_data($service_finder_options,'search-max-price',1000);
$minradiusrange = 0;
$maxradiusrange = service_finder_get_data($service_finder_options,'search-max-radius',1000);
$radiussearchunit = service_finder_get_data($service_finder_options,'radius-search-unit','mi');
$advancesearchview = service_finder_get_data($service_finder_options,'advance-search-view');
if($radiussearchunit == 'km'){
$radiusunit = esc_html__( ' Km', 'service-finder' );
}else{
$radiusunit = esc_html__( ' Mi.', 'service-finder' );
}
if($advancesearchview == 'hide'){
$hiddenclass = 'default-hidden';
$arrowclass = 'fa-chevron-up';
}else{
$hiddenclass = '';
$arrowclass = 'fa-chevron-down';
}
$actionurl = service_finder_get_url_by_shortcode('[service_finder_job_qa_form]');
?>

<div class="job-search-wrap">
	<div class="job-search-container">
        <form class="clearfix job-search-form" method="get" action="<?php echo $actionurl; ?>">
        <div class="searchbars-left">
            <ul class="job-search-form-list">
            <li class="aon-search-category">
            	<span class="fa fa-search"></span>
                <input id="catautocomplete" name="category" class="form-control" placeholder="<?php esc_html_e('What service do you need.','revamp'); ?>" type="text">
                <span class="category-autoload"><i class="fa fa-spinner fa-pulse"></i></span>
                <span class="aon-cat-clean"><i class="fa fa-close"></i></span>
            </li>
            <li class="aon-search-city">
            	<span class="fa fa-map-marker"></span> 
                <select class="sf-select-box form-control sf-form-control" data-live-search="true" name="city" id="city" title="<?php echo esc_html__('City','service-finder') ?>" data-header="<?php echo esc_html__('Select a City','service-finder') ?>">
                <option value=""><?php echo esc_html__('Select City','service-finder') ?></option>
                <?php
                $country = (isset($_REQUEST['country'])) ? $_REQUEST['country'] : '';
                $city = (isset($_REQUEST['city'])) ? $_REQUEST['city'] : '';
                $categorysrh = (isset($_REQUEST['categorysrh'])) ? $_REQUEST['categorysrh'] : '';
                $searchAddress = (isset($_REQUEST['searchAddress'])) ? $_REQUEST['searchAddress'] : '';
                $defaultcity = (!empty($service_finder_options['default-city'])) ? $service_finder_options['default-city'] : '';
                $defaultcountry = (!empty($service_finder_options['default-country'])) ? $service_finder_options['default-country'] : '';
                
                if($service_finder_options['search-country']){
                if($country != ""){
                    
                    if($restrictuserarea && $identitycheck){
                $maincities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->providers." WHERE country = '%s' AND identity = 'approved' AND admin_moderation = 'approved' AND account_blocked != 'yes' ORDER BY `city`",$country));
                }else{
                $maincities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->providers." WHERE country = '%s' AND admin_moderation = 'approved' AND account_blocked != 'yes' ORDER BY `city`",$country));
                }
                
                $branchcities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->branches." WHERE country = '%s' ORDER BY `city`",$country));
                
                $allcities = array();
                
                if(!empty($maincities)){
                foreach($maincities as $city){
                    $allcities[] = $city->city;
                }
                }
                
                if(!empty($branchcities)){
                foreach($branchcities as $city){
                    $allcities[] = $city->city;
                }
                }
                
                $allcities = array_unique($allcities);
                sort($allcities);	
                    
                    if(!empty($allcities)){
                    $getcity = (isset($_REQUEST['city'])) ? $_REQUEST['city'] : '';
                    foreach($allcities as $city){
                        
                        if($getcity == $city){
                            $select = 'selected="selected"';
                        }else{
                            $select = '';
                        }
                        ?>
                        <option <?php echo esc_attr($select); ?> value="<?php echo esc_attr($city) ?>"><?php echo esc_html($city) ?></option>
                        <?php
                    }
                    }else{
                    ?>
                        <option value=""><?php echo esc_html__('No city available','service-finder') ?></option>
                        <?php
                    }
                }elseif($country == "" && $city == "" && $categorysrh == "" && $searchAddress == "" && $defaultcountry != ""){
                
                        if($restrictuserarea && $identitycheck){
                        $maincities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->providers." WHERE country = '%s' AND identity = 'approved' AND admin_moderation = 'approved' AND account_blocked != 'yes' ORDER BY `city`",$defaultcountry));
                        }else{
                        $maincities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->providers." WHERE country = '%s' AND admin_moderation = 'approved' AND account_blocked != 'yes' ORDER BY `city`",$defaultcountry));
                        }
                        
                        $branchcities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->branches." WHERE country = '%s' ORDER BY `city`",$defaultcountry));
                
                        $allcities = array();
                        
                        if(!empty($maincities)){
                        foreach($maincities as $city){
                            $allcities[] = $city->city;
                        }
                        }
                        
                        if(!empty($branchcities)){
                        foreach($branchcities as $city){
                            $allcities[] = $city->city;
                        }
                        }
                        
                        $allcities = array_unique($allcities);
                        sort($allcities);	
                        
                        if(!empty($allcities)){
                        foreach($allcities as $city){
                            
                            if($defaultcity == $city){
                                $select = 'selected="selected"';
                            }else{
                                $select = '';
                            }
                            ?>
                            <option <?php echo esc_attr($select) ?> value="<?php echo esc_attr($city) ?>"><?php echo esc_html($city) ?></option>
                            <?php
                        }
                        }else{
                        ?>
                            <option value=""><?php echo esc_html__('No city available','service-finder') ?></option>
                            <?php
                        }
                }
                }else{
                
                    if($restrictuserarea && $identitycheck){
                    $maincities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->providers." WHERE country = '%s' AND identity = 'approved' AND admin_moderation = 'approved' AND account_blocked != 'yes' ORDER BY `city`",$defaultcountry));
                    }else{
                    $maincities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->providers." WHERE country = '%s' AND admin_moderation = 'approved' AND account_blocked != 'yes' ORDER BY `city`",$defaultcountry));
                    }
                    
                    $branchcities = $wpdb->get_results($wpdb->prepare("select DISTINCT city from ".$service_finder_Tables->branches." WHERE country = '%s' ORDER BY `city`",$defaultcountry));
                
                    $allcities = array();
                    
                    if(!empty($maincities)){
                    foreach($maincities as $city){
                        $allcities[] = $city->city;
                    }
                    }
                    
                    if(!empty($branchcities)){
                    foreach($branchcities as $city){
                        $allcities[] = $city->city;
                    }
                    }
                    
                    $allcities = array_unique($allcities);
                    sort($allcities);
                    
                    if(!empty($allcities)){
                    $getcity = (isset($_REQUEST['city'])) ? $_REQUEST['city'] : '';
                    foreach($allcities as $city){
                        
                        if($getcity == $city){
                            $select = 'selected="selected"';
                        }else{
                            $select = '';
                        }
                        ?>
                        <option <?php echo esc_attr($select) ?> value="<?php echo esc_attr($city) ?>"><?php echo esc_html($city) ?></option>
                        <?php
                    }
                    }else{
                        ?>
                        <option value=""><?php echo esc_html__('No city available','service-finder') ?></option>
                        <?php
                    }
                
                }
                ?>
                </select>
            </li>
            </ul>
        </div>
        <div class="searchbars-right">
            <button class="site-button btn btn-primary"><i class="fa fa-search"></i> <?php echo esc_html__('Search', 'service-finder'); ?></button>
        </div>
        </form>
	</div>    
</div>     
    