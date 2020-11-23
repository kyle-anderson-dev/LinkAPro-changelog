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
$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_shortcode_global_vars('wpdb');

$imgurl = (!empty($service_finder_options['category-bg-image']['url'])) ? $service_finder_options['category-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['category-background-attachment'])) ? esc_html($service_finder_options['category-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['category-bg-color'])) ? $service_finder_options['category-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['category-bg-opacity'])) ? $service_finder_options['category-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['category-left-curve-color'])) ? $service_finder_options['category-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['category-right-curve-color'])) ? $service_finder_options['category-right-curve-color'] : '';


$title = (!empty($service_finder_options['shortcode-categories-title'])) ? esc_html($service_finder_options['shortcode-categories-title']) : '';
$tagline = (!empty($service_finder_options['shortcode-categories-tagline'])) ? wp_kses_post($service_finder_options['shortcode-categories-tagline']) : '';
$titlecolor = (!empty($service_finder_options['shortcode-categories-title-color'])) ? esc_html($service_finder_options['shortcode-categories-title-color']) : '';
$taglinecolor = (!empty($service_finder_options['shortcode-categories-tagline-color'])) ? esc_html($service_finder_options['shortcode-categories-tagline-color']) : '';
$dividercolor = (!empty($service_finder_options['shortcode-categories-divider-color'])) ? esc_html($service_finder_options['shortcode-categories-divider-color']) : '';
$limit = (!empty($service_finder_options['shortcode-categories-limit'])) ? esc_html($service_finder_options['shortcode-categories-limit']) : 6;
$subcategories = (isset($service_finder_options['shortcode-subcategories'])) ? esc_html($service_finder_options['shortcode-subcategories']) : '';
$categoriesshowmore = (isset($service_finder_options['shortcode-categories-showmore'])) ? esc_html($service_finder_options['shortcode-categories-showmore']) : 'yes';
$categoriesdescription = (isset($service_finder_options['shortcode-categories-description'])) ? esc_html($service_finder_options['shortcode-categories-description']) : 'yes';
?>
<!-- services Finder categories version 2   -->
<?php
if(service_finder_themestyle_for_plugin() == 'style-2'){
$html = '<section class="section-full text-center bg-white sf-category2" style="background:url('.esc_url($imgurl).') center '.$bgattachment.' no-repeat;">
  <div class="container">
    <div class="section-head">
      <h2 style="color:'.$titlecolor.'">'.esc_html($title).'</h2>
	  '.service_finder_title_separator($dividercolor).'
	  <div class="sf-tagile-outer" style="color:'.esc_attr($taglinecolor).'">'.wp_kses_post($tagline).'</div>
    </div>
    <div class="section-content">
      <div class="row catlistv2 equal-col-outer">';
						
						if(class_exists('service_finder_texonomy_plugin')){
						
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
								$catimage =  service_finder_getCategoryIcon($catdetails->term_id,'service_finder-category-icon');
		
		$nocaticon = ($catimage == "") ? 'no-cat-icon' : '';
		$imgtag = '';
		if($catimage != ""){
              $imgtag = '<img src="'.esc_url($catimage).'" width="80" height="80" alt="'.esc_attr($catdetails->name).'">';
        }
		
		$excerpt = '';
		if($categoriesdescription == 'yes'){
            $excerpt = '<p>'.nl2br(service_finder_getExcerpts($catdetails->description,0,60)).'</p>';
        }
		
        $html .= '<div class="col-md-3">
          <div class="sf-categories-2 padding-lr-10 equal-col">
            <div class="icon-bx-md rounded-corner bg-primary margin-b-20 '.$nocaticon.'">
              '.$imgtag.'
			  <span class="sf-categories-2-count">'.service_finder_getTotalProvidersByCategory( $catdetails->term_id ).'</span>
			  <a href="'.esc_url(get_term_link( $catdetails )).'" class="sf-category2-link"></a>
            </div>
            <h4 class="sf-tilte"><a href="'.esc_url(get_term_link( $catdetails )).'">'.esc_html($catdetails->name).'</a></h4>
            '.$excerpt.'
          </div>
        </div>';
		}
							}
							?>
        <?php if($totalcat > $limit && $categoriesshowmore == 'yes'){
		if(!empty($catdetails)){
        $html .= '<div class="show_more_main_v2" id="show_more_main_v2'.esc_attr($limit).'"> <span id="'.esc_attr($catdetails->term_id).'" data-catarr="yes" data-offset="'.esc_attr($limit).'" data-showdes="'.esc_attr($categoriesdescription).'" class="btn btn-primary show_more_v2" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder') .'</span> <span class="lodingv2 default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
		}
							}
		
						}else{
							if($subcategories == 'yes'){
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
			
									$catimage =  service_finder_getCategoryIcon($category->term_id,'service_finder-category-icon');
			
        $nocaticon = ($catimage == "") ? 'no-cat-icon' : '';
		$imgtag = '';
		if($catimage != ""){
              $imgtag = '<img src="'.esc_url($catimage).'" width="80" height="80" alt="'.esc_attr($category->name).'">';
        }
		
		$excerpt = '';
		if($categoriesdescription == 'yes'){
            $excerpt = '<p>'.nl2br(service_finder_getExcerpts($category->description,0,60)).'</p>';
        }
		
		$html .= '<div class="col-md-3">
          <div class="sf-categories-2 padding-lr-10 equal-col">
            <div class="icon-bx-md rounded-corner bg-primary margin-b-20 '.$nocaticon.'">
              '.$imgtag.'
			  <span class="sf-categories-2-count">'.service_finder_getTotalProvidersByCategory( $category->term_id ).'</span>
			  <a href="'.esc_url(get_term_link( $category )).'" class="sf-category2-link"></a>
            </div>
            <h4><a href="'.esc_url(get_term_link( $category )).'">'.esc_html($category->name).'</a></h4>
            '. $excerpt.'
          </div>
        </div>';
			
								}
							?>
        <?php if($totalcat > $limit && $categoriesshowmore == 'yes'){
        $html .= '<div class="show_more_main_v2" id="show_more_main_v2'.esc_attr($limit).'"> <span id="'.esc_attr($category->term_id).'" data-subcat="'.esc_attr($subcategory).'" data-offset="'.esc_attr($limit).'" data-showdes="'.esc_attr($categoriesdescription).'" class="show_more_v2 btn btn-primary" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder').'</span> <span class="lodingv2 default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
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
            <h2 class="text-white" style="color:<?php echo  esc_attr($titlecolor); ?>"><?php echo esc_html($title); ?></h2>
            <?php echo service_finder_title_separator($dividercolor); ?>
            <div class="sf-tagile-outer" style="color:<?php echo esc_attr($taglinecolor); ?>"><?php echo wp_kses_post($tagline); ?></div>
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
                                    <?php
                                    if($categoriesdescription == 'yes'){
									?>	
                                    <div class="sf-categoriesBox-text"><?php echo esc_html($catdetails->description); ?></div>
                                    <?php
                                    }
									?>
                                </div>
                            </div>
                            <a href="<?php echo esc_url(get_term_link( $catdetails )) ?>" class="sf-category-link"></a>
                        </div>
						<?php
					}
                    }
						
               		}else{
						if($subcategories == 'yes'){
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
                                            <div class="sf-categoriesBox-text"><?php echo esc_html($category->description); ?></div>
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
$html = '<section class="section-full text-center bg-white sf-category2" style="background:url('.esc_url($imgurl).') center '.$bgattachment.' no-repeat;">
  <div class="container">
    <div class="section-head">
      <h2 style="color:'.$titlecolor.'">'.esc_html($title).'</h2>
      '.service_finder_title_separator($dividercolor).'
	  <div class="sf-tagile-outer" style="color:'.esc_attr($taglinecolor).'">'.wp_kses_post($tagline).'</div>
    </div>
    <div class="section-content">
      <div class="row catlistv2 equal-col-outer">';
						
						if(class_exists('service_finder_texonomy_plugin')){
						
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
								$catimage =  service_finder_getCategoryIcon($catdetails->term_id,'service_finder-category-icon');
		
		$nocaticon = ($catimage == "") ? 'no-cat-icon' : '';
		$imgtag = '';
		if($catimage != ""){
              $imgtag = '<img src="'.esc_url($catimage).'" width="80" height="80" alt="'.esc_attr($catdetails->name).'">';
        }
		
		$excerpt = '';
		if($categoriesdescription == 'yes'){
            $excerpt = '<p>'.nl2br(service_finder_getExcerpts($catdetails->description,0,60)).'</p>';
        }
		
        $html .= '<div class="col-md-3 col-sm-4 col-xs-6 equal-col">
          <div class="sf-element-bx">
            <div class="icon-bx-md rounded-bx '.$nocaticon.'">
              '.$imgtag.'
            </div>
            <h4><a href="'.esc_url(get_term_link( $catdetails )).'">'.esc_html($catdetails->name).'</a></h4>
            '.$excerpt.'
          </div>
        </div>';
		}
							}
							?>
        <?php if($totalcat > $limit && $categoriesshowmore == 'yes'){
		if(!empty($catdetails)){
        $html .= '<div class="show_more_main_v2" id="show_more_main_v2'.esc_attr($limit).'"> <span id="'.esc_attr($catdetails->term_id).'" data-catarr="yes" data-offset="'.esc_attr($limit).'" data-showdes="'.esc_attr($categoriesdescription).'" class="btn btn-primary show_more_v2" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder') .'</span> <span class="lodingv2 default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
		}
							}
		
						}else{
							if($subcategories == 'yes'){
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
			
									$catimage =  service_finder_getCategoryIcon($category->term_id,'service_finder-category-icon');
			
        $nocaticon = ($catimage == "") ? 'no-cat-icon' : '';
		$imgtag = '';
		if($catimage != ""){
              $imgtag = '<img src="'.esc_url($catimage).'" width="80" height="80" alt="'.esc_attr($category->name).'">';
        }
		
		$excerpt = '';
		if($categoriesdescription == 'yes'){
            $excerpt = '<p>'.nl2br(service_finder_getExcerpts($category->description,0,60)).'</p>';
        }
		
		$html .= '<div class="col-md-3 col-sm-4 col-xs-6 equal-col">
          <div class="sf-element-bx">
            <div class="icon-bx-md rounded-bx '.$nocaticon.'">
              '.$imgtag.'
            </div>
            <h4><a href="'.esc_url(get_term_link( $category )).'">'.esc_html($category->name).'</a></h4>
            '. $excerpt.'
          </div>
        </div>';
			
								}
							?>
        <?php if($totalcat > $limit && $categoriesshowmore == 'yes'){
        $html .= '<div class="show_more_main_v2" id="show_more_main_v2'.esc_attr($limit).'"> <span id="'.esc_attr($category->term_id).'" data-subcat="'.esc_attr($subcategory).'" data-offset="'.esc_attr($limit).'" data-showdes="'.esc_attr($categoriesdescription).'" class="show_more_v2 btn btn-primary" title="Load more categories"><i class="fa fa-refresh"></i> '.esc_html__('Show more','service-finder').'</span> <span class="lodingv2 default-hidden"><span class="loding_txt btn btn-default"><i class="fa fa-refresh fa-spin"></i></span></span> </div>';
							}
			
							}
						}
						}
						
      $html .= '</div>
    </div>
  </div>
  <div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'"></div>
</section>';
}
?>
<!-- services Finder categories  END -->
