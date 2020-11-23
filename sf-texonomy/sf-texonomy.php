<?php
/*
Plugin Name: Service Finder Texonomies
Plugin URI: http://aonetheme.com/
Description: This is a plugin for providers category
Version: 3.5
Author: Aonetheme
Author URI: http://aonetheme.com/
*/

if(!class_exists('service_finder_texonomy_plugin')) {
	class service_finder_texonomy_plugin {
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
			
			add_action( 'init', array(&$this, 'service_finder_register_user_taxonomy'),10 );
			
			add_action( 'init', array(&$this, 'service_finder_register_post_type') );
			
			add_action( 'admin_head', array( &$this, 'service_finder_tax_inline_styles'));
			
			add_action( 'admin_menu', array(&$this, 'service_finder_add_user_category_menu') );
			
			add_action( 'add_meta_boxes', array(&$this, 'sk_fn_add_testimonials_metabox') );
			
			add_action( 'save_post', array(&$this, 'sk_fn_save_testimonials_meta'), 1, 2 );
			
			add_action( 'providers-category_add_form_fields', array(&$this, 'service_finder_add_provider_image_field') );
			
			add_action( 'providers-category_edit_form_fields', array(&$this, 'service_finder_providers_edit_meta_field') );
			
			add_action( 'edited_providers-category', array(&$this, 'service_finder_save_providers_custom_meta') );
			
			add_action( 'create_providers-category', array(&$this, 'service_finder_save_providers_custom_meta') );
			
			add_action( 'admin_enqueue_scripts', array(&$this, 'service_finder_load_wp_media_files') );
			
			add_action( 'sf-amenities_add_form_fields', array(&$this, 'service_finder_add_icon_field') );
			
			add_action( 'sf-amenities_edit_form_fields', array(&$this, 'service_finder_edit_meta_field') );
			
			add_action( 'edited_sf-amenities', array(&$this, 'service_finder_save_custom_meta') );
			
			add_action( 'create_sf-amenities', array(&$this, 'service_finder_save_custom_meta') );
			
			add_action( 'sf_question_category_add_form_fields', array(&$this, 'service_finder_add_icon_field') );
			
			add_action( 'sf_question_category_edit_form_fields', array(&$this, 'service_finder_edit_meta_field') );
			
			add_action( 'edited_sf_question_category', array(&$this, 'service_finder_save_custom_meta') );
			
			add_action( 'create_sf_question_category', array(&$this, 'service_finder_save_custom_meta') );
			
			add_action( 'sf_article_category_add_form_fields', array(&$this, 'service_finder_add_icon_field') );
			
			add_action( 'sf_article_category_edit_form_fields', array(&$this, 'service_finder_edit_meta_field') );
			
			add_action( 'edited_sf_article_category', array(&$this, 'service_finder_save_custom_meta') );
			
			add_action( 'create_sf_article_category', array(&$this, 'service_finder_save_custom_meta') );
			
			add_action( 'sf-cities_add_form_fields', array(&$this, 'service_finder_add_country_field') );
			
			add_action( 'sf-cities_edit_form_fields', array(&$this, 'service_finder_edit_country_field') );
			
			add_action( 'edited_sf-cities', array(&$this, 'service_finder_save_country_meta') );
			
			add_action( 'create_sf-cities', array(&$this, 'service_finder_save_country_meta') );
			
		} // END public function __construct
		
		public function sk_fn_add_testimonials_metabox() {
	
			add_meta_box(
				'testimonialsinfo',
				esc_html__( 'Testimonial Details', 'service-finder' ),
				array($this, 'sk_fn_testimonials_meta_box'),
				'sf_testimonials',
				'normal',
				'high'
			);
		
		}
		
		/*Callback function for testimonials info meta box*/ 
		public function sk_fn_save_testimonials_meta( $post_id, $post ) {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
			
			$testimonials_fields = (!empty($_POST['testimonials_fields'])) ? esc_attr($_POST['testimonials_fields']) : '';
			
			if ( ! wp_verify_nonce( $testimonials_fields, basename(__FILE__) ) ) {
				return $post_id;
			}
			
			$authorname = (!empty($_POST['authorname'])) ? esc_attr($_POST['authorname']) : '';
			$designation = (!empty($_POST['designation'])) ? esc_attr($_POST['designation']) : '';
			
			$testimonials_meta['authorname'] = $authorname;
			$testimonials_meta['designation'] = $designation;
			
			foreach ( $testimonials_meta as $key => $value ) 
			{
				if ( 'revision' === $post->post_type ) {
					return;
				}
				
				if ( get_post_meta( $post_id, $key, false ) ) {
					update_post_meta( $post_id, $key, $value );
				} else {
					add_post_meta( $post_id, $key, $value);
				}
				
				if ( ! $value ) {
					delete_post_meta( $post_id, $key );
				}
			}
		}
		
		/*Callback function for testimonials info meta box*/ 
		public function sk_fn_testimonials_meta_box() 
		{
			global $post;
			
			wp_nonce_field( basename( __FILE__ ), 'testimonials_fields' );
			$authorname = get_post_meta( $post->ID, 'authorname', true );
			$designation = get_post_meta( $post->ID, 'designation', true );
			
			?>
			<table class="sk-package-info">
			  <tr>
				<td><?php echo esc_html__( 'Name', 'service-finder' ); ?></td>
				<td><input type="text" name="authorname" value="<?php echo esc_attr( $authorname ); ?>" class="form-control"></td>
			  </tr>
			  <tr>
				<td><?php echo esc_html__( 'Designation', 'service-finder' ); ?></td>
				<td><input type="text" name="designation" value="<?php echo esc_attr( $designation ); ?>" class="form-control"></td>
			  </tr>
			</table>
			<?php
		}
		
		/**
		 * Activate the plugin
		 */
		public static function service_finder_activate() {
			global $wpdb, $service_finder_Tables;

			/*Create object for table name access in theme*/
			$service_finder_Tables = (object) array(
										'providers' =>  'service_finder_providers',
										'services' =>  'service_finder_services',
										'team_members' =>  'service_finder_team_members',
										'bookings' =>  'service_finder_bookings',
										'customers' =>  'service_finder_customers',
										'customers_data' =>  'service_finder_customers_data',
										'booked_services' =>  'service_finder_booked_services',
										'timeslots' =>  'service_finder_timeslots',
										'service_area' =>  'service_finder_service_area',
										'attachments' =>  'service_finder_attachments',
										'invoice' =>  'service_finder_invoice',
										'feedback' =>  'service_finder_feedback',
										'feature' =>  'service_finder_feature',
										'favorites' =>  'service_finder_favorites',
										'newsletter' =>  'service_finder_newsletter',
										'unavailability' =>  'service_finder_unavailability',
										'business_hours' =>  'service_finder_business_hours',
							);
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function service_finder_deactivate() {
			// Do nothing
		} // END public static function deactivate
		
		/*Get User Role By ID*/
		public function service_finder_getrole($userid){
		if($userid > 0){
			$user = new WP_User( $userid );
			return $user->roles[0];
		}	
		}
		/*Register Post type*/
		public function service_finder_register_post_type(){
			$labels = array(
				'name'                => esc_html_x( 'Payout Transactions', 'Post Type General Name', 'service-finder' ),
				'singular_name'       => esc_html_x( 'Payout Transaction', 'Post Type Singular Name', 'service-finder' ),
				'menu_name'           => esc_html__( 'Payout Transactions', 'service-finder' ),
				'parent_item_colon'   => esc_html__( 'Parent Payout Transaction:', 'service-finder' ),
				'all_items'           => esc_html__( 'All Payout Transactions', 'service-finder' ),
				'view_item'           => esc_html__( 'View Payout Transaction', 'service-finder' ),
				'add_new_item'        => esc_html__( 'Add New Payout Transaction', 'service-finder' ),
				'add_new'             => esc_html__( 'Add New', 'service-finder' ),
				'edit_item'           => esc_html__( 'Edit Payout Transaction', 'service-finder' ),
				'update_item'         => esc_html__( 'Update Payout Transaction', 'service-finder' ),
				'search_items'        => esc_html__( 'Search Payout Transaction', 'service-finder' ),
				'not_found'           => esc_html__( 'Not found', 'service-finder' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'service-finder' ),
			);
		
			$custom_slug = 'payout_transaction';
			//$custom_slug = null;
			$rewrite = array(
				'slug'                => $custom_slug,
				'with_front'          => false,
				'pages'               => true,
				'feeds'               => true,
			);
			$args = array(
				'label'               => esc_html__( 'Payout Transactions', 'service-finder' ),
				'description'         => esc_html__( 'Payout Transaction Details', 'service-finder' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'author', 'custom-fields' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 8,
				'menu_icon'           => 'dashicons-hammer',
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'post',
				'capabilities' => array(
					//'create_posts' => false
				)
			);
			register_post_type( 'payout_transaction', $args );
			
			/*Register Articles post type*/
			register_post_type('sf_testimonials', array(
				'labels' => array(
					'name' => esc_html__('Testimonials', 'service-finder'),
					'all_items' => esc_html__('Testimonials', 'service-finder'),
					'singular_name' => esc_html__('Testimonial', 'service-finder'),
					'add_new' => esc_html__('Add Testimonial', 'service-finder'),
					'add_new_item' => esc_html__('Add New Testimonial', 'service-finder'),
					'edit' => esc_html__('Edit', 'service-finder'),
					'edit_item' => esc_html__('Edit Testimonial', 'service-finder'),
					'new_item' => esc_html__('New Testimonial', 'service-finder'),
					'view' => esc_html__('View Testimonial', 'service-finder'),
					'view_item' => esc_html__('View Testimonial', 'service-finder'),
					'search_items' => esc_html__('Search Testimonial', 'service-finder'),
					'not_found' => esc_html__('No Testimonial found', 'service-finder'),
					'not_found_in_trash' => esc_html__('No Testimonial found in trash', 'service-finder'),
					'parent' => esc_html__('Parent Testimonial', 'service-finder'),
				),
				'description' => '',
				'public' => true,
				'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
				'show_ui' => true,
				'capability_type' => 'post',
				'map_meta_cap' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'hierarchical' => true,
				'menu_position' => 10,
				'rewrite' => array('slug' => 'testimonials', 'with_front' => true),
				'query_var' => true,
				'has_archive' => 'testimonials'
			));
			
			/*Register Articles post type*/
			register_post_type('sf_articles', array(
            'labels' => array(
                'name' => esc_html__('Articles', 'service-finder'),
                'all_items' => esc_html__('Articles', 'service-finder'),
                'singular_name' => esc_html__('Article', 'service-finder'),
                'add_new' => esc_html__('Add Article', 'service-finder'),
                'add_new_item' => esc_html__('Add New Article', 'service-finder'),
                'edit' => esc_html__('Edit', 'service-finder'),
                'edit_item' => esc_html__('Edit Article', 'service-finder'),
                'new_item' => esc_html__('New Article', 'service-finder'),
                'view' => esc_html__('View Article', 'service-finder'),
                'view_item' => esc_html__('View Article', 'service-finder'),
                'search_items' => esc_html__('Search Article', 'service-finder'),
                'not_found' => esc_html__('No Article found', 'service-finder'),
                'not_found_in_trash' => esc_html__('No Article found in trash', 'service-finder'),
                'parent' => esc_html__('Parent Article', 'service-finder'),
            ),
            'description' => '',
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'rewrite' => array('slug' => 'article', 'with_front' => true),
            'query_var' => true,
            'has_archive' => 'articles'
        ));
		
		/*Register Question post type*/
		register_post_type('sf_questions', array(
            'labels' => array(
                'name' => esc_html__('Questions', 'service-finder'),
                'all_items' => esc_html__('Questions', 'service-finder'),
                'singular_name' => esc_html__('Question', 'service-finder'),
                'add_new' => esc_html__('Add Question', 'service-finder'),
                'add_new_item' => esc_html__('Add New Question', 'service-finder'),
                'edit' => esc_html__('Edit', 'service-finder'),
                'edit_item' => esc_html__('Edit Question', 'service-finder'),
                'new_item' => esc_html__('New Question', 'service-finder'),
                'view' => esc_html__('View Question', 'service-finder'),
                'view_item' => esc_html__('View Question', 'service-finder'),
                'search_items' => esc_html__('Search Question', 'service-finder'),
                'not_found' => esc_html__('No Question found', 'service-finder'),
                'not_found_in_trash' => esc_html__('No Question found in trash', 'service-finder'),
                'parent' => esc_html__('Parent Question', 'service-finder'),
            ),
            'description' => '',
            'public' => true,
            'supports' => array('title', 'editor', 'excerpt', 'comments'),
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'rewrite' => array('slug' => 'questions', 'with_front' => true),
            'query_var' => true,
            'has_archive' => 'questions'
        ));
		
		register_taxonomy('sf_question_category', 'sf_questions', array(
            'hierarchical' => false,
            'labels' => array(
                'name' => esc_html__('Categories', 'service-finder'),
                'singular_name' => esc_html__('category', 'service-finder'),
                'search_items' => esc_html__('Search Categories', 'service-finder'),
                'popular_items' => esc_html__('Popular Categories', 'service-finder'),
                'all_items' => esc_html__('All Categories', 'service-finder'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Category', 'service-finder'),
                'update_item' => esc_html__('Update Category', 'service-finder'),
                'add_new_item' => esc_html__('Add New Category', 'service-finder'),
                'new_item_name' => esc_html__('New Category Name', 'service-finder'),
                'separate_items_with_commas' => esc_html__('Separate categories with commas', 'service-finder'),
                'add_or_remove_items' => esc_html__('Add or remove categories', 'service-finder'),
                'choose_from_most_used' => esc_html__('Choose from the most used categories', 'service-finder'),
                'menu_name' => esc_html__('Categories', 'service-finder'),
            ),
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'sf_question_category'),
        ));
		
		/*Register Answer post type*/
		register_post_type('sf_answers', array(
            'labels' => array(
                'name' => esc_html__('Answers', 'service-finder'),
                'all_items' => esc_html__('Answers', 'service-finder'),
                'singular_name' => esc_html__('Answer', 'service-finder'),
                'add_new' => esc_html__('Add Answer', 'service-finder'),
                'add_new_item' => esc_html__('Add New Answer', 'service-finder'),
                'edit' => esc_html__('Edit', 'service-finder'),
                'edit_item' => esc_html__('Edit Answer', 'service-finder'),
                'new_item' => esc_html__('New Answer', 'service-finder'),
                'view' => esc_html__('View Answer', 'service-finder'),
                'view_item' => esc_html__('View Answer', 'service-finder'),
                'search_items' => esc_html__('Search Answer', 'service-finder'),
                'not_found' => esc_html__('No Answer found', 'service-finder'),
                'not_found_in_trash' => esc_html__('No Answer found in trash', 'service-finder'),
                'parent' => esc_html__('Parent Answer', 'service-finder'),
            ),
            'description' => '',
            'public' => true,
            'supports' => array('title', 'editor', 'excerpt', 'comments'),
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'rewrite' => array('slug' => 'answers', 'with_front' => true),
            'query_var' => true,
            'has_archive' => 'answers'
        ));
		
		register_taxonomy('sf_article_category', 'sf_articles', array(
            'hierarchical' => false,
            'labels' => array(
                'name' => esc_html__('Categories', 'service-finder'),
                'singular_name' => esc_html__('category', 'service-finder'),
                'search_items' => esc_html__('Search Categories', 'service-finder'),
                'popular_items' => esc_html__('Popular Categories', 'service-finder'),
                'all_items' => esc_html__('All Categories', 'service-finder'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Category', 'service-finder'),
                'update_item' => esc_html__('Update Category', 'service-finder'),
                'add_new_item' => esc_html__('Add New Category', 'service-finder'),
                'new_item_name' => esc_html__('New Category Name', 'service-finder'),
                'separate_items_with_commas' => esc_html__('Separate categories with commas', 'service-finder'),
                'add_or_remove_items' => esc_html__('Add or remove categories', 'service-finder'),
                'choose_from_most_used' => esc_html__('Choose from the most used categories', 'service-finder'),
                'menu_name' => esc_html__('Categories', 'service-finder'),
            ),
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'sf_article_category'),
        ));
		}
		
		/*Register Taxonomy*/
		public function service_finder_register_user_taxonomy(){
			global $service_finder_options;
			
			$providerscategoryreplacestring = (!empty($service_finder_options['providers-category-replace-string'])) ? $service_finder_options['providers-category-replace-string'] : 'providers-category';
				 
			$labels = array(
				'name' => esc_html__('Providers Category', 'service-finder'),
				'singular_name' => esc_html__('Providers Category', 'service-finder'),
				'search_items' => esc_html__('Search Providers Categories', 'service-finder'),
				'all_items' => esc_html__('All Providers Categories', 'service-finder'),
				'parent_item' => esc_html__('Parent Providers Category', 'service-finder'),
				'parent_item_colon' => esc_html__('Parent Providers Category', 'service-finder'),
				'edit_item' => esc_html__('Edit Providers Category', 'service-finder'),
				'update_item' => esc_html__('Update Providers Category', 'service-finder'),
				'add_new_item' => esc_html__('Add New Providers Category', 'service-finder'),
				'new_item_name' => esc_html__('New Providers Category Name', 'service-finder'),
				'menu_name' => esc_html__('Providers Category', 'service-finder')
			);
		 
		 	if($providerscategoryreplacestring != ""){
				$catslug = $providerscategoryreplacestring;
			}else{
				$catslug = 'providers-category';
			}	
		 
			$args = array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => $catslug)
			);
		 
			register_taxonomy( 'providers-category' , array('user') , $args );
			
			/*Add Amenities Texonomy*/
			$labels = array(
				'name' => esc_html__('Amenities', 'service-finder'),
				'singular_name' => esc_html__('Amenity', 'service-finder'),
				'search_items' => esc_html__('Search Amenities', 'service-finder'),
				'all_items' => esc_html__('All Amenities', 'service-finder'),
				'parent_item' => esc_html__('Parent Amenity', 'service-finder'),
				'parent_item_colon' => esc_html__('Parent Amenity', 'service-finder'),
				'edit_item' => esc_html__('Edit Amenity', 'service-finder'),
				'update_item' => esc_html__('Update Amenity', 'service-finder'),
				'add_new_item' => esc_html__('Add New Amenity', 'service-finder'),
				'new_item_name' => esc_html__('New Amenity Name', 'service-finder'),
				'menu_name' => esc_html__('Amenities', 'service-finder')
			);
		 
			$catslug = 'sf-amenities';
		 
			$args = array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => $catslug)
			);
		 
			register_taxonomy( 'sf-amenities' , array('user') , $args );
			
			//Size for Category Image at Home
			add_image_size( 'service_finder-category-home', 600, 450, true ); 
			
			//Size for Category Image at Home
			add_image_size( 'service_finder-category-small', 60, 60, true ); 
			
			//Size for marker icon
			add_image_size( 'service_finder-marker-icon', 40, 40, true ); 
			
			//Size for category icon
			add_image_size( 'service_finder-category-icon', 80, 80, true ); 
			
			//Size for amenity icon
			add_image_size( 'service_finder-amenity-icon', 20, 20, true ); 
			
			//Size for category icon
			add_image_size( 'service_finder-all-category-icon', 128, 128, true ); 
		}
		
		/*User Category Add Menu*/
		public function service_finder_add_user_category_menu() {
			add_submenu_page( 'users.php' , esc_html__('Providers Category', 'service-finder'), esc_html__('Providers Category', 'service-finder') , 'manage_options',  'edit-tags.php?taxonomy=providers-category' );
			add_submenu_page( 'users.php' , esc_html__('Amenities', 'service-finder'), esc_html__('Amenities', 'service-finder') , 'manage_options',  'edit-tags.php?taxonomy=sf-amenities' );
			add_submenu_page( 'service-finder' , esc_html__('Cities', 'service-finder'), esc_html__('Cities', 'service-finder') , 'manage_options',  'edit-tags.php?taxonomy=sf-cities' );
		}
		
		/* Add Image Upload to Provider Category Taxonomy */
		public function service_finder_add_provider_image_field() {
			// this will add the custom meta field to the add new term page
			?>
		
		<div class="form-field">
		  <label for="provider_image">
		  <?php esc_html_e( 'Category Image:', 'service-finder' ); ?>
		  </label>
		  <input type="hidden" name="imageid" id="imageid" value="">
          <input type="text" name="provider_image[image]" id="provider_image[image]" class="provider-image" value="">
		  <input class="upload_image_button button" name="_add_provider_image" id="_add_provider_image" type="button" value="<?php esc_html_e( 'Select/Upload Image', 'service-finder' ); ?>" />
		</div>
		<div class="form-field">
		  <label for="provider_icon">
		  <?php esc_html_e( 'Category Icon:', 'service-finder' ); ?>
		  </label>
          <input type="hidden" name="iconid" id="iconid" value="">
		  <input type="text" name="provider_icon[icon]" id="provider_icon[icon]" class="provider-icon" value="">
		  <input class="upload_image_button button" name="_add_provider_icon" id="_add_provider_icon" type="button" value="<?php esc_html_e( 'Select/Upload Icon', 'service-finder' ); ?>" />
		  <script>
		  // <![CDATA[
			jQuery(document).ready(function() {
				jQuery( '.colorpicker' ).wpColorPicker();
				jQuery('#_add_provider_icon').click(function() {
					wp.media.editor.send.attachment = function(props, attachment) {
						jQuery('#iconid').val(attachment.id);
						jQuery('.provider-icon').val(attachment.url);
					}
					wp.media.editor.open(this);
					return false;
				});
				jQuery('#_add_provider_image').click(function() {
					wp.media.editor.send.attachment = function(props, attachment) {
						jQuery('#imageid').val(attachment.id);
						jQuery('.provider-image').val(attachment.url);
					}
					wp.media.editor.open(this);
					return false;
				});
			});
			// ]]>
		</script>
		</div>
        <div class="form-field term-colorpicker-wrap">
            <label for="term-colorpicker"><?php esc_html_e( 'Color:', 'service-finder' ); ?></label>
            <input name="provider_category_color" value="" class="colorpicker" id="term-colorpicker" />
        </div>
        
        <tr class="form-field">
                <th scope="row"><label for="term-colorpicker"><?php esc_html_e( 'Make it Hightlight:', 'service-finder' ); ?></label></th>
                <td>
                    <input type="checkbox" name="provider_category_hightlight" value="yes" id="provider_category_hightlight" />
                </td>
            </tr>
		<?php
		}
		
		// Add Upload fields to "Edit Taxonomy" form
		public function service_finder_providers_edit_meta_field($term) {
		 
			// put the term ID into a variable
			$t_id = $term->term_id;
		 
			// retrieve the existing value(s) for this meta field. This returns an array
			$term_meta_image = get_option( "providers-category_image_".$t_id );
			$term_meta_icon = get_option( "providers-category_icon_".$t_id );
			$color = get_term_meta( $t_id, 'provider_category_color', true );
            $color = ( ! empty( $color ) ) ? "{$color}" : '';
			$imageid = get_term_meta( $t_id, 'imageid', true );
			$iconid = get_term_meta( $t_id, 'iconid', true );
			
			$provider_category_hightlight = get_term_meta( $t_id, 'provider_category_hightlight', true );
			?>
            <tr class="form-field">
              <th scope="row" valign="top"><label for="_provider_image">
                <?php esc_html_e( 'Provider Image', 'service-finder' ); ?>
                </label></th>
              <td><?php
                            $providerimage = esc_attr( $term_meta_image ) ? esc_attr( $term_meta_image ) : ''; 
                            ?>
                <input type="hidden" name="imageid" id="imageid" value="<?php echo esc_attr($imageid); ?>">
                <input type="text" name="provider_image[image]" id="provider_image[image]" class="provider-image" value="<?php echo esc_attr($providerimage); ?>">
                <input class="upload_image_button button" name="_provider_image" id="_provider_image" type="button" value="<?php esc_html_e( 'Select/Upload Image', 'service-finder' ); ?>" />
              </td>
            </tr>
            <tr class="form-field">
              <th scope="row" valign="top"></th>
              <td class="tax-height-bx"><style>
                            div.img-wrap {
                                background: url('http://placehold.it/960x300') no-repeat center; 
                                background-size:contain; 
                                max-width: 450px; 
                                max-height: 150px; 
                                width: 100%; 
                                height: 100%; 
                                overflow:hidden; 
                            }
                            div.img-wrap img {
                                max-width: 450px;
                            }
                        </style>
                <div class="sf-img-wrap-bx"> <img src="<?php echo esc_url($providerimage); ?>" id="provider-img"> </div>
              </td>
            </tr>
            <tr class="form-field">
              <th scope="row" valign="top"><label for="_provider_icon">
                <?php esc_html_e( 'Provider Icon', 'service-finder' ); ?>
                </label></th>
              <td><?php
                            $providericon = esc_attr( $term_meta_icon ) ? esc_attr( $term_meta_icon ) : ''; 
                            ?>
                <input type="hidden" name="iconid" id="iconid" value="<?php echo esc_attr($iconid); ?>">
                <input type="text" name="provider_icon[icon]" id="provider_image[icon]" class="provider-icon" value="<?php echo esc_attr($providericon); ?>">
                <input class="upload_image_button button" name="_provider_icon" id="_provider_icon" type="button" value="<?php esc_html_e( 'Select/Upload Icon', 'service-finder' ); ?>" />
              </td>
            </tr>
            <tr class="form-field">
              <th scope="row" valign="top"></th>
              <td class="tax-height-bx">
                <div class="sf-img-wrap-bx"> <img src="<?php echo esc_url($providericon); ?>" id="provider-icn"> </div>
                <script>
                // <![CDATA[
				jQuery(document).ready(function() {
					jQuery( '.colorpicker' ).wpColorPicker();
					jQuery('#_provider_image').click(function() {
						wp.media.editor.send.attachment = function(props, attachment) {
							jQuery('#imageid').val(attachment.id);
							jQuery('#provider-img').attr("src",attachment.url)
							jQuery('.provider-image').val(attachment.url)
						}
						wp.media.editor.open(this);
						return false;
					});
					jQuery('#_provider_icon').click(function() {
						wp.media.editor.send.attachment = function(props, attachment) {
							jQuery('#iconid').val(attachment.id);
							jQuery('#provider-icn').attr("src",attachment.url)
							jQuery('.provider-icon').val(attachment.url)
						}
						wp.media.editor.open(this);
						return false;
					});
				});
				// ]]>
				</script>
              </td>
            </tr>
            <tr class="form-field term-colorpicker-wrap">
                <th scope="row"><label for="term-colorpicker"><?php esc_html_e( 'Color', 'service-finder' ); ?></label></th>
                <td>
                    <input name="provider_category_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" />
                </td>
            </tr>
            
            <tr class="form-field">
                <th scope="row"><label for="term-colorpicker"><?php esc_html_e( 'Make it Hightlight', 'service-finder' ); ?></label></th>
                <td>
                    <input type="checkbox" name="provider_category_hightlight" <?php echo ($provider_category_hightlight == 'yes') ? 'checked="checked"' : ''; ?> value="yes" id="provider_category_hightlight" />
                </td>
            </tr>
        
		<?php
		}
		
		/* Add Icon Upload to Amenities Taxonomy */
		public function service_finder_add_icon_field() { ?>
		<div class="form-field">
		  <label for="provider_icon">
		  <?php esc_html_e( 'Icon:', 'service-finder' ); ?>
		  </label>
		  <input type="text" name="cat_icon[icon]" id="cat_icon[icon]" class="cat-icon" value="">
		  <input class="upload_image_button button" name="_add_cat_icon" id="_add_cat_icon" type="button" value="<?php esc_html_e( 'Select/Upload Icon', 'service-finder' ); ?>" />
		  <script>
		  // <![CDATA[
			jQuery(document).ready(function() {
				jQuery('#_add_cat_icon').click(function() {
					wp.media.editor.send.attachment = function(props, attachment) {
						jQuery('.cat-icon').val(attachment.url);
					}
					wp.media.editor.open(this);
					return false;
				});
			});
			// ]]>
		</script>
		</div>
		<?php
		}
		
		/* Add country to cities taxonomy */
		public function service_finder_add_country_field() { 
		global $service_finder_options;
		?>
		<div class="form-field term-parent-wrap">
        <label for="parent"><?php esc_html_e( 'Select Country', 'makeover' ); ?></label>
        <select name="country" id="country" class="postform">
        <option value=""><?php esc_html_e( 'Select Country', 'makeover' ); ?></option>
		<?php
        $allcountry = (!empty($service_finder_options['all-countries'])) ? $service_finder_options['all-countries'] : '';
		if(class_exists('service_finder_booking_plugin'))
		{
        $countries = service_finder_get_countries();
        if($allcountry){
          if(!empty($countries)){
            foreach($countries as $key => $country){
                echo '<option value="'.esc_attr($country).'" data-code="'.esc_attr($key).'">'. $country.'</option>';
            }
          }
        }else{
         $countryarr = (!empty($service_finder_options['allowed-country'])) ? $service_finder_options['allowed-country'] : '';
         if($countryarr){
            foreach($countryarr as $key){
                echo '<option value="'.esc_attr($countries[$key]).'" data-code="'.esc_attr($key).'">'. $countries[$key].'</option>';
            }
         }
        }
		}
        ?>
        </select>
        <p><?php esc_html_e( 'Select country', 'makeover' ); ?></p>
        </div>
		<?php
		}
		
		/* Edit country to cities taxonomy */
		public function service_finder_edit_country_field($term) {
		global $service_finder_options;
		$countryname = get_term_meta($term->term_id, 'country', true);
		?>
		<tr class="form-field term-parent-wrap">
			<th scope="row"><label for="parent"><?php esc_html_e( 'Country', 'makeover' ); ?></label></th>
			<td>
				<select name="country" id="country" class="postform">
				<option value=""><?php esc_html_e( 'Select Country', 'makeover' ); ?></option>
				<?php
				$allcountry = (!empty($service_finder_options['all-countries'])) ? $service_finder_options['all-countries'] : '';
				if(class_exists('service_finder_booking_plugin'))
				{
				$countries = service_finder_get_countries();
				if($allcountry){
				  if(!empty($countries)){
					foreach($countries as $key => $country){
						if($country == $countryname)
						{
							$select = 'selected="selected"';
						}else{
							$select = '';
						}
						echo '<option '.$select.' value="'.esc_attr($country).'" data-code="'.esc_attr($key).'">'. $country.'</option>';
					}
				  }
				}else{
				 $countryarr = (!empty($service_finder_options['allowed-country'])) ? $service_finder_options['allowed-country'] : '';
				 if($countryarr){
					foreach($countryarr as $key){
						if($countries[$key] == $countryname)
						{
							$select = 'selected="selected"';
						}else{
							$select = '';
						}
						echo '<option '.$select.' value="'.esc_attr($countries[$key]).'" data-code="'.esc_attr($key).'">'. $countries[$key].'</option>';
					}
				 }
				}
				}
				?>
				</select>
				<p><?php esc_html_e( 'Assign a country to the city.', 'makeover' ); ?></p>
			</td>
		</tr>
		<?php 
		}
		
		/* Save country to cities taxonomy */
		public function service_finder_save_country_meta( $term_id ) {
			if(isset($_POST['country'])){
				update_term_meta($term_id, 'country', $_POST['country']);
			}
		}
		
		// Add Upload fields to "Edit Taxonomy" form
		public function service_finder_edit_meta_field($term) {
		 
			// put the term ID into a variable
			$t_id = $term->term_id;
		 
			$term_meta_icon = get_option( "cat_icon_".$t_id );
			?>
            <tr class="form-field">
              <th scope="row" valign="top"><label for="_cat_icon">
                <?php esc_html_e( 'Icon', 'service-finder' ); ?>
                </label></th>
              <td><?php
                            $caticon = esc_attr( $term_meta_icon ) ? esc_attr( $term_meta_icon ) : ''; 
                            ?>
                <input type="text" name="cat_icon[icon]" id="cat_icon[icon]" class="cat-icon" value="<?php echo esc_attr($caticon); ?>">
                <input class="upload_image_button button" name="_cat_icon" id="_cat_icon" type="button" value="<?php esc_html_e( 'Select/Upload Icon', 'service-finder' ); ?>" />
              </td>
            </tr>
            <tr class="form-field">
              <th scope="row" valign="top"></th>
              <td class="tax-height-bx">
                <div class="sf-img-wrap-bx"> <img src="<?php echo esc_url($caticon); ?>" id="amenity-icn"> </div>
                <script>
                // <![CDATA[
				jQuery(document).ready(function() {
					jQuery('#_cat_icon').click(function() {
						wp.media.editor.send.attachment = function(props, attachment) {
							jQuery('#cat-icn').attr("src",attachment.url)
							jQuery('.cat-icon').val(attachment.url)
						}
						wp.media.editor.open(this);
						return false;
					});
				});
				// ]]>
				</script>
              </td>
            </tr>
		<?php
		}
		
		//Inline Styles
		public function service_finder_tax_inline_styles() {
		
		?>
		<style>
			div.img-wrap {
				background: url('http://placehold.it/960x300') no-repeat center; 
				background-size:contain; 
				max-width: 450px; 
				max-height: 150px; 
				width: 100%; 
				height: 100%; 
				overflow:hidden; 
			}
			div.img-wrap img {
				max-width: 450px;
			}
			
			.tax-height-bx{ 
				height:150px;
			}
		</style>
		<?php
		
		}
		// Save Taxonomy Image fields callback function.
		public function service_finder_save_providers_custom_meta( $term_id ) {
			if ( isset( $_POST['provider_image'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "providers-category_".$t_id );
				$cat_keys = array_keys( $_POST['provider_image'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['provider_image'][$key] ) ) {
						$term_meta_image = $_POST['provider_image'][$key];
					}
				}
				// Save the option array.
				update_option( "providers-category_image_".$t_id, $term_meta_image );
			}
			
			if( isset( $_POST['imageid'] ) && ! empty( $_POST['imageid'] ) ) {
				update_term_meta( $term_id, 'imageid', $_POST['imageid'] );
			} else {
				delete_term_meta( $term_id, 'imageid' );
			}
			
			if( isset( $_POST['iconid'] ) && ! empty( $_POST['iconid'] ) ) {
				update_term_meta( $term_id, 'iconid', $_POST['iconid'] );
			} else {
				delete_term_meta( $term_id, 'iconid' );
			}
			
			if ( isset( $_POST['provider_icon'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "providers-category_".$t_id );
				$cat_keys = array_keys( $_POST['provider_icon'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['provider_icon'][$key] ) ) {
						$term_meta_icon = $_POST['provider_icon'][$key];
					}
				}
				// Save the option array.
				update_option( "providers-category_icon_".$t_id, $term_meta_icon );
			}
			
			// Save term color if possible
			if( isset( $_POST['provider_category_color'] ) && ! empty( $_POST['provider_category_color'] ) ) {
				update_term_meta( $term_id, 'provider_category_color', $_POST['provider_category_color'] );
			} else {
				delete_term_meta( $term_id, 'provider_category_color' );
			}
			
			// Save term hightlight
			if( isset( $_POST['provider_category_hightlight'] ) && ! empty( $_POST['provider_category_hightlight'] ) ) {
				update_term_meta( $term_id, 'provider_category_hightlight', $_POST['provider_category_hightlight'] );
			} else {
				delete_term_meta( $term_id, 'provider_category_hightlight' );
			}
		}  
		
		// Save Taxonomy Icon fields callback function.
		public function service_finder_save_custom_meta( $term_id ) {
			if ( isset( $_POST['cat_icon'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "cat_".$t_id );
				$cat_keys = array_keys( $_POST['cat_icon'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['cat_icon'][$key] ) ) {
						$term_meta_icon = $_POST['cat_icon'][$key];
					}
				}
				// Save the option array.
				update_option( "cat_icon_".$t_id, $term_meta_icon );
			}
		}  
		
		/**
		 * Load media files needed for Uploader
		 */
		public function service_finder_load_wp_media_files() {
		  wp_enqueue_media();
		  
		 // Colorpicker Scripts
		 wp_enqueue_script( 'wp-color-picker' );
	
		 // Colorpicker Styles
		 wp_enqueue_style( 'wp-color-picker' );
		}
		



	} // END class booked_plugin
} // END if(!class_exists('service_finder_booking_plugin'))

if(class_exists('service_finder_texonomy_plugin')) {
	
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('service_finder_texonomy_plugin', 'service_finder_activate'));
	register_deactivation_hook(__FILE__, array('service_finder_texonomy_plugin', 'service_finder_deactivate'));

	// instantiate the plugin class
	$service_finder_texonomy_plugin = new service_finder_texonomy_plugin();
}