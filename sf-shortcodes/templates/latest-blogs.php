<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/

$wpdb = service_finder_shortcode_global_vars('wpdb');

$imgurl = (!empty($service_finder_options['latest-blogs-bg-image']['url'])) ? $service_finder_options['latest-blogs-bg-image']['url'] : '';
$bgattachment = (isset($service_finder_options['latest-blogs-background-attachment'])) ? esc_html($service_finder_options['latest-blogs-background-attachment']) : '';
$bgcolor = (!empty($service_finder_options['latest-blogs-bg-color'])) ? $service_finder_options['latest-blogs-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['latest-blogs-bg-opacity'])) ? $service_finder_options['latest-blogs-bg-opacity'] : '';
$bgopacity = ($bgopacity > 0) ? $bgopacity : ''; 
$curveleftcolor = (!empty($service_finder_options['latest-blogs-left-curve-color'])) ? $service_finder_options['latest-blogs-left-curve-color'] : '';
$curverightcolor = (!empty($service_finder_options['latest-blogs-right-curve-color'])) ? $service_finder_options['latest-blogs-right-curve-color'] : '';
?>
<!-- Latest blog post -->
<?php
$postinner = '';

$showitem = (isset($a['showitem'])) ? esc_html($a['showitem']) : 3;

if(service_finder_themestyle_for_plugin() == 'style-2'){
$slideritem = 3;
}else{
$slideritem = 2;
}

wp_add_inline_script( 'service_finder-js-custom', 'var showblogitem = "'.$slideritem.'";', 'before' );

$args = array(

	'post_type'=> 'post',

	'post_status' => 'publish',

	'orderby' => 'post_date',
	
	'order' => 'DESC',

	'posts_per_page'  => $showitem,

);

$the_query = new WP_Query( $args );
while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
<?php
if ( has_post_thumbnail() ) { 
$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id(), 'service_finder-blog-home-page' );
$imgsrc = $imgsrc[0];
}else{
$imgsrc = '';
}

if($imgsrc != ""){
if(service_finder_themestyle_for_plugin() == 'style-2'){
$imgtag = '<a href="'.esc_url(get_the_permalink()).'"><img src="'.esc_url($imgsrc).'" alt=""><div class="sf-overlay-box"></div></a>';
}else{
$imgtag = '<img src="'.esc_url($imgsrc).'" alt="">';
}
$class = '';
}else{
$imgtag = '';
$class = 'sf-no-img-blog';
}
$posttags = get_the_tags(get_the_id());
$tagname = '';
if ($posttags) {
  foreach($posttags as $tag) {
    $tagname .= '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a>' . ' '; 
  }
}
?>
<?php
if(service_finder_themestyle_for_plugin() == 'style-2'){
$postinner .= '<div class="blog-post '.sanitize_html_class($class).' equal-height-bx">
                              <div class="post-bx sf-latest-news">
                              
                                <div class="post-thum">
                                    '.$imgtag.'
                                </div>
                                
                                <div class="post-info">
                                    
                                    <div class="post-text">
                                        <h4 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h4>
                                        <div class="post-meta">
                                            <ul>
                                                <li class="post-author"><i class="fa fa-user"></i>'.esc_html__('By', 'service-finder').' '.get_the_author_posts_link().'</li>
                                                <li class="post-comment"><i class="fa fa-comments"></i><a href="'.esc_url(get_comments_link()).'">'.get_comments_number( get_the_id() ).' '.esc_html__('Comments','service-finder').'</a></li>
                                            </ul>
                                        </div>
                                        <p>'.service_finder_getExcerpts(get_the_excerpt(),0,75).'</p> 
                                    </div>
                                    
                                </div>
                                
                              </div>
                            </div>';
}elseif(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<div class="col-md-4 col-sm-4" style="background-image:url(<?php echo esc_url($imgurl) ?>); background-attachment: <?php echo esc_attr($bgattachment); ?>">
    <div class="blog-post">
      <div class="post-bx sf-latest-news2">
      
        <div class="post-thum">
            <?php echo wp_kses_post($imgtag); ?>
            <div class="sf-overlay-box"></div>
        </div>
        
        <div class="post-info">
            
            <div class="post-text">
                <h4 class="post-title"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title(); ?></a></h4>
                <div class="post-meta">
                    <ul>
                        <li class="post-author"><?php echo esc_html__('Posted By', 'service-finder'); ?> : <?php echo get_the_author_posts_link(); ?></li>
                    </ul>
                </div>
                <p><?php echo service_finder_getExcerpts(get_the_excerpt(),0,75); ?></p> 
            </div>
            
        </div>
        
      </div>
    </div>
</div>
<?php
$postinner .= ob_get_clean();
}else{
$postinner .= '<div class="blog-post '.sanitize_html_class($class).' equal-height-bx">
<div class="post-bx">
  <div class="post-thum img-effect2">
	'.$imgtag.'
	<div class="post-date"> <strong><a href="'.esc_url(get_the_permalink()).'">'.date('d',strtotime(get_the_date())).'</a></strong> <span>'.service_finder_translate_monthname(date('n',strtotime(get_the_date()))).'</span> </div>
  </div>
  <div class="post-info">
	<div class="post-text">
	  <h4 class="post-title">
	   <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>
	  </h4>
	  <div class="post-meta">
		<ul>
		  <li class="post-author"><i class="fa fa-user"></i>
			'.esc_html__('By', 'service-finder').'
		   '.get_the_author_posts_link().'
		  </li>
		  <li class="post-comment"><i class="fa fa-comments"></i>
		  <a href="'.esc_url(get_comments_link()).'">'.get_comments_number( get_the_id() ).' '.esc_html__('Comments','service-finder').'</a>
		  </li>
		  <li class="post-tags"><i class="fa fa-tags"></i>
			'.$tagname.'
		  </li>
		</ul>
	  </div>
	  <p>'.get_the_excerpt().'</p>
	  <a href="'.esc_url(get_the_permalink()).'" class="read-more">
	  '.esc_html__('Read More', 'service-finder').'
	  </a> </div>
  </div>
</div>
</div>';
}
?>                                        
<?php 
endwhile; 
wp_reset_query();
?>
<!-- Latest blog post -->

<?php
if(service_finder_themestyle_for_plugin() == 'style-2'){
$html = '<section class="section-full latest-blog" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
            <div class="container">
            
            
            	<div class="section-head text-center">
                    <h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
					'.service_finder_title_separator($a['divider-color']).'
                    <p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
                </div>
                    
                <div class="section-content">
                    <div class="owl-blogs">';
                        
                        $html .= $postinner;
                        
                    $html .= '</div>
                </div>
                
            </div>
			<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
        </section>';
}elseif(service_finder_themestyle_for_plugin() == 'style-3'){
ob_start();
?>
<section class="section-full sf-latestBlog-wrap latest-blog" style="background:url(<?php echo esc_url($imgurl) ?>) center <?php echo esc_attr($bgattachment) ?> no-repeat;">
    <div class="container">
    
        <div class="section-head text-center">
            <h2 class="text-white" style="color:<?php echo esc_attr($a['title-color']); ?>"><?php echo esc_html($a['title']); ?></h2>
            <?php echo service_finder_title_separator($a['divider-color']); ?>
            <p style="color:<?php echo esc_attr($a['tagline-color']); ?>"><?php echo apply_filters('the_content', $a['tagline']); ?></p>
        </div>
            
        <div class="section-content">
            <div class="row">
                
                <?php
                echo wp_kses_post($postinner); 
				?>
                
            </div>
        </div>
        
    </div>
    <div class="sf-curve-topWrap"><div class="sf-curveTop sf-latestBlog-curveTop" style="background-color:<?php echo esc_attr($curveleftcolor); ?>"></div></div>
    <div class="sf-curve-botWrap"><div class="sf-curveBot sf-latestBlog-curveBot" style="background-color:<?php echo esc_attr($curverightcolor); ?>"></div></div>            
    <div class="sf-overlay-main" style="opacity:<?php echo esc_attr($bgopacity); ?>; background-color:<?php echo esc_attr($bgcolor); ?> "> 
</section>
<?php
$html = ob_get_clean();
}else{
$html = '<section class="section-full bg-white latest-blog" style="background-image:url('.esc_url($imgurl).');background-attachment: '.$bgattachment.'">
<div class="container">
<div class="section-head text-center">
<h2 style="color:'.$a['title-color'].'">'.esc_html($a['title']).'</h2>
'.service_finder_title_separator($a['divider-color']).'
<p style="color:'.$a['tagline-color'].'">'.esc_html($a['tagline']).'</p>
</div>
<div class="section-content">
<div class="row equal-bx-outer"><div class="owl-blogs">';

$html .= $postinner;

$html .= '</div></div>
</div>
</div>
<div class="sf-overlay-main" style="opacity:'.$bgopacity.'; background-color:'.$bgcolor.'">
</section>';	  
}
?>
