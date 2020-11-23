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
<!-- sf categories  -->
<?php 
$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_shortcode_global_vars('wpdb');

$imgurl = (!empty($service_finder_options['category-bg-image']['url'])) ? $service_finder_options['category-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['category-background-attachment'])) ? esc_html($service_finder_options['category-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['category-bg-color'])) ? $service_finder_options['category-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['category-bg-opacity'])) ? $service_finder_options['category-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['category-left-curve-color'])) ? $service_finder_options['category-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['category-right-curve-color'])) ? $service_finder_options['category-right-curve-color'] : '';
?>
<?php
if(service_finder_themestyle_for_plugin() == 'style-2'){
$html = '<section class="section-full text-center bg-gray" style="background:url('.esc_url($imgurl).') center '.$bgattachment.' no-repeat;">
            <div class="container">
            
            	<div class="section-head">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
                </div>
                    
                <div class="section-content">
    <div class="row">
        <div id="masonry" class="catlist sf-catlist-new">';
        
            if(class_exists('service_finder_texonomy_plugin')){
				
				$limit = $a['limit'];
				
				$offset=0; //define offset
				$i=0; //start line counter


                $categories = (!empty($service_finder_options['homepage-categories'])) ? $service_finder_options['homepage-categories'] : array();
				
				
                if(!empty($categories)){
					$totalcat = count($categories);
                    foreach($categories as $category){
						$catdetails = get_term_by('id', $category, 'providers-category');
						if(!empty($catdetails)){
						
						if ($i++ < $offset) continue;
					    if ($i > $offset + $limit) break;
						
                        $catimage =  service_finder_getCategoryImage($catdetails->term_id,'service_finder-category-home');
						if($catimage != ""){
						$class = '';
						$catimgtag = '<img src="'.esc_url($catimage).'" width="600" height="350" alt="'.esc_attr($catdetails->name).'">';
						}else{
						$class = 'sf-cate-no-img';
						$catimgtag = '';
						}
						
						$provider_category_hightlight = get_term_meta( $catdetails->term_id, 'provider_category_hightlight', true );
						
						$hightlight = ($provider_category_hightlight == 'yes') ? 'high-light' : '';

        $html .= '<div class="card-container col-md-4 col-sm-4 col-xs-6">
              <div class="sf-categories-girds '.sanitize_html_class($hightlight).' '.sanitize_html_class($class).'">
                    <div class="sf-categories-thum" style="background-image:url('.esc_url($catimage).')"></div>
                    <div class="sf-overlay-box"></div>
                    <div class="sf-categories-content text-center">
                        <span  class="sf-categories-quantity"><i class="fa fa-user-plus"></i> '.service_finder_getTotalProvidersByCategory( $catdetails->term_id ).'</span>
                        <div  class="sf-categories-title">'.esc_html($catdetails->name).'</div>
						<a href="'.esc_url(get_term_link( $catdetails )).'" class="sf-category-link"></a>
                    </div>
              </div>
            </div>';
		}
                    }
					$html .= '</div>';
					?>
        <?php if($totalcat > $limit && $a['showmore'] == 'yes'){ 
		if(!empty($catdetails)){
        $html .= '<div class="show_more_main" id="show_more_main'.esc_attr($limit).'"> <span id="'.esc_attr($catdetails->term_id).'" data-catarr="yes" data-offset="'.esc_attr($limit).'" class="show_more btn btn-primary" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder').'</span> <span class="loding default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
		}
					}
					
                }else{
					$limit = $a['limit'];
					if($a['subcategory'] == 'yes'){
					$subcategory = true;
					}else{
					$subcategory = false;
					}
					
					$allcat = service_finder_getCategoryList(0,$subcategory);
					$totalcat = count($allcat);
					
					$offset = 0;
					$categories = service_finder_getCategoryListwithOffest($limit,$subcategory,$offset);
					if(!empty($categories)){
	
						foreach($categories as $category){
	
							$catimage =  service_finder_getCategoryImage($category->term_id,'service_finder-category-home');
							
							if($catimage != ""){
							$class = '';
							$catimgtag = '<img src="'.esc_url($catimage).'" width="600" height="350" alt="'.esc_attr($category->name).'">';
							}else{
							$class = 'sf-cate-no-img';
							$catimgtag = '';
							}
							
							$provider_category_hightlight = get_term_meta( $category->term_id, 'provider_category_hightlight', true );
							
							$hightlight = ($provider_category_hightlight == 'yes') ? 'high-light' : '';
        $html .= '<div class="card-container col-md-4 col-sm-4 col-xs-6">
              <div class="sf-categories-girds '.sanitize_html_class($hightlight).' '.sanitize_html_class($class).'">
                    <div class="sf-categories-thum" style="background-image:url('.esc_url($catimage).')"></div>
                    <div class="sf-overlay-box"></div>
                    <div class="sf-categories-content text-center">
                        <span  class="sf-categories-quantity"><i class="fa fa-user-plus"></i> '.service_finder_getTotalProvidersByCategory( $category->term_id ).'</span>
                        <div  class="sf-categories-title">'.esc_html($category->name).'</div>
                    </div>
					<a href="'.esc_url(get_term_link( $category )).'" class="sf-category-link"></a>
              </div>
            </div>';
						}
		$html .= '</div>';				
						?>
         
		<?php if($totalcat > $limit && $a['showmore'] == 'yes'){
        $html .= '<div class="show_more_main" id="show_more_main'.esc_attr($limit).'"> <span id="'.esc_attr($category->term_id).'" data-subcat="'.esc_attr($subcategory).'" data-offset="'.esc_attr($limit).'" class="show_more btn btn-primary" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder') .'</span> <span class="loding default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
						}
	
					}
				}
				}
            
        $html .= '</div>
</div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'"></div>
        </section>';
}elseif(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full bg-gray sf-cateoriess-wrap" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="sf-cateoriess-half-bg"></div>
    <div class="container"> 
        <div class="section-head text-center">
            <h2 class="text-white" style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2>
            <?php echo service_finder_title_separator($a['divider-color']); ?>
            <p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p>
        </div>
            
        <div class="section-content">
            <div class="row">
            
                <div class="categories-box-slider">
                
                    <?php
                    $categories = (!empty($service_finder_options['homepage-categories'])) ? $service_finder_options['homepage-categories'] : array();
				
	                if(!empty($categories)){
					$totalcat = count($categories);
                    foreach($categories as $category){
						$catdetails = get_term_by('id', $category, 'providers-category');
						if(!empty($catdetails)){
						
                        $catimage =  service_finder_getCategoryImage($catdetails->term_id,'service_finder-category-home');
						
						$provider_category_hightlight = get_term_meta( $catdetails->term_id, 'provider_category_hightlight', true );
						
						$hightlight = ($provider_category_hightlight == 'yes') ? 'high-light' : '';
						
						?>
						<div class="item">
                            <div class="sf-categoriesBox <?php echo ($catimage != "") ? '' : 'sf-cate-no-img'; ?>">
                                <?php
                                if($catimage != ""){
								?>
                                <div class="sf-categoriesBox-pic"><img src="<?php echo esc_url($catimage); ?>" width="600" height="350" alt="<?php echo esc_attr($catdetails->name) ?>"></div>
                                <?php
                                }
								?>
                                <div class="sf-categoriesBox-info">
                                    <h4 class="sf-categoriesBox-title"><?php echo esc_html($catdetails->name); ?></h4>
                                    <div class="sf-categoriesBox-text"><?php echo service_finder_getExcerpts(apply_filters('the_content', $catdetails->description),0,50); ?></div>
                                </div>
                            </div>
                            <a href="<?php echo esc_url(get_term_link( $catdetails )) ?>" class="sf-category-link"></a>
                        </div>
						<?php
					}
                    }
						
               		}else{
						$limit = $a['limit'];
						if($a['subcategory'] == 'yes'){
						$subcategory = true;
						}else{
						$subcategory = false;
						}
						
						$allcat = service_finder_getCategoryList(0,$subcategory);
						$totalcat = count($allcat);
						
						$offset = 0;
						$categories = service_finder_getCategoryListwithOffest($limit,$subcategory,$offset);
						if(!empty($categories)){
		
							foreach($categories as $category){
		
								$catimage =  service_finder_getCategoryImage($category->term_id,'service_finder-category-home');
								
								?>
                                <div class="item">
                                    <div class="sf-categoriesBox <?php echo ($catimage != "") ? '' : 'sf-cate-no-img'; ?>">
                                        <?php
                                        if($catimage != ""){
                                        ?>
                                        <div class="sf-categoriesBox-pic"><img src="<?php echo esc_url($catimage); ?>" width="600" height="350" alt="<?php echo esc_attr($catdetails->name) ?>"></div>
                                        <?php
                                        }
                                        ?>
                                        <div class="sf-categoriesBox-info">
                                            <h4 class="sf-categoriesBox-title"><?php echo esc_html($category->name); ?></h4>
                                            <div class="sf-categoriesBox-text"><?php echo service_finder_getExcerpts(apply_filters('the_content', $category->description),0,50); ?></div>
                                        </div>
                                    </div>
                                    <a href="<?php echo esc_url(get_term_link( $category )) ?>" class="sf-category-link"></a>
                                </div>
                                <?php
							}
            			}
					}
					?>
                </div>
            
            </div>
        </div>
            
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-cateori-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-cateori-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> ">           
</section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full text-center bg-gray sf-category" style="background:url('.esc_url($imgurl).') center '.$bgattachment.' no-repeat;">
  <div class="container">
    <div class="section-head">
      <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
      '.service_finder_title_separator().'
      <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
    </div>
    <div class="section-content">
      <div class="row catlist">';

				if(class_exists('service_finder_texonomy_plugin')){
				
				$limit = $a['limit'];
				
				$offset=0; //define offset
				$i=0; //start line counter


                $categories = (!empty($service_finder_options['homepage-categories'])) ? $service_finder_options['homepage-categories'] : '';
				
                if(!empty($categories)){
					$totalcat = count($categories);
                    foreach($categories as $category){
						$catdetails = get_term_by('id', $category, 'providers-category');
						if(!empty($catdetails)){
						
						if ($i++ < $offset) continue;
					    if ($i > $offset + $limit) break;
						
                        $catimage =  service_finder_getCategoryImage($catdetails->term_id,'service_finder-category-home');
						if($catimage != ""){
						$class = '';
						$catimgtag = '<img src="'.esc_url($catimage).'" width="600" height="350" alt="'.esc_attr($catdetails->name).'">';
						}else{
						$class = 'sf-cate-no-img';
						$catimgtag = '';
						}

        $html .= '<div class="col-md-4 col-sm-6">
          <div class="sf-element-bx">
          <a href="'.esc_url(get_term_link( $catdetails )).'">
          <div class="'.sanitize_html_class($class).' overlay-bg">
            <div class="sf-thum-bx sf-catagories-listing img-effect1" style="background-image:url('.esc_url($catimage).');"> </div>
            <span  class="service-plus"> <i class="fa fa-user-plus"></i> ('.service_finder_getTotalProvidersByCategory( $catdetails->term_id ).') </span>
            <h4 class="service-name pull-left">'.esc_html($catdetails->name).'</h4>
          </div>
          </a>
          </div>
        </div>';
		}
                    }
					
					?>
        <?php if($totalcat > $limit && $a['showmore'] == 'yes'){ 
		if(!empty($catdetails)){
        $html .= '<div class="show_more_main" id="show_more_main'.esc_attr($limit).'"> <span id="'.esc_attr($catdetails->term_id).'" data-catarr="yes" data-offset="'.esc_attr($limit).'" class="show_more btn btn-primary" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder').'</span> <span class="loding default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
		}
					}
					
                }else{
					$limit = $a['limit'];
					if($a['subcategory'] == 'yes'){
					$subcategory = true;
					}else{
					$subcategory = false;
					}
					
					$allcat = service_finder_getCategoryList(0,$subcategory);
					$totalcat = count($allcat);
					
					$offset = 0;
					$categories = service_finder_getCategoryListwithOffest($limit,$subcategory,$offset);
					if(!empty($categories)){
	
						foreach($categories as $category){
	
							$catimage =  service_finder_getCategoryImage($category->term_id,'service_finder-category-home');
							
							if($catimage != ""){
							$class = '';
							$catimgtag = '<img src="'.esc_url($catimage).'" width="600" height="350" alt="'.esc_attr($category->name).'">';
							}else{
							$class = 'sf-cate-no-img';
							$catimgtag = '';
							}
        $html .= '<div class="col-md-4 col-sm-6">
        <div class="sf-element-bx">
          <a href="'.esc_url(get_term_link( $category )).'">
          <div class="'.sanitize_html_class($class).' overlay-bg">
            <div class="sf-thum-bx sf-catagories-listing img-effect1" style="background-image:url('.esc_url($catimage).');"> </div>
            <span  class="service-plus"> <i class="fa fa-user-plus"></i> ('.service_finder_getTotalProvidersByCategory( $category->term_id ).') </span>
            <h4 class="service-name pull-left">'.esc_html($category->name).'</h4>
          </div>
          </a>
        </div>  
        </div>';
						}
						?>
        <?php if($totalcat > $limit && $a['showmore'] == 'yes'){
        $html .= '<div class="show_more_main" id="show_more_main'.esc_attr($limit).'"> <span id="'.esc_attr($category->term_id).'" data-subcat="'.esc_attr($subcategory).'" data-offset="'.esc_attr($limit).'" class="show_more btn btn-primary" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder') .'</span> <span class="loding default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
						}
	
					}
				}
				}
      $html .= '
    </div>
  </div>
  </div>
  <div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'"></div>
</section>';
}
?>
<!-- sf categories END -->
