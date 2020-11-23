<?php
$html = '<section class="section-full text-center bg-gray">
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
				
				
				$i=0; //start line counter


					
					if($a['subcategory'] == 'yes'){
					$subcategory = true;
					}else{
					$subcategory = false;
					}
					
					if($a['subcategory'] == 'yes'){
						$categories = service_finder_getCategoryList(0,true);
					}else{
						$categories = service_finder_getCategoryList(0,false);
					}
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
							
							
        $html .= '<div class="card-container col-md-4 col-sm-4 col-xs-6">
              <div class="sf-categories-girds">
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
         
		<?php
	
					}
	
				}
            
        $html .= '</div>
</div>
                
            </div>
			
        </section>';
