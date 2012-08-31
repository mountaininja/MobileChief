<?php

/* ----------------------------------------------------------------------------
	
	Create a Function to Enqueue Styles & Scripts
	
	Usage: Call this function within a wp_enqueue_scripts function to enqueue the scripts
	
	NOTE: 
	This was abstracted to an individual function so we can call it 
	in multiple places, such as the Front-End Add-On
	
---------------------------------------------------------------------------- */	

	function plchf_msb_enqueue_plugin_scripts_and_styles() {

    	// Register Styles
    	wp_register_style( 'plchf_msb_admin_styles', PLUGINCHIEFMSB . 'css/style.css');
    	wp_register_style( 'plchf_msb_font_awesome_styles', PLUGINCHIEFMSB . 'css/font-awesome/css/font-awesome.css');
    	
    	// Enqueue Styles
    	wp_enqueue_style('jquery-ui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/flick/jquery-ui.css');
    	wp_enqueue_style('colors-fresh', admin_url( 'css/colors-fresh.css' ));
    	wp_enqueue_style('farbtastic');
    	wp_enqueue_style('plchf_msb_font_awesome_styles');
    	wp_enqueue_style('plchf_msb_admin_styles');

    	// Enqueue JS
    	add_thickbox();
    	wp_enqueue_script('jquery');
    	wp_enqueue_script('jquery-ui-core');
    	wp_enqueue_script('jquery-ui-sortable');
    	wp_enqueue_script('jquery-ui-draggable');
    	wp_enqueue_script('jquery-ui-sortable');
    	wp_enqueue_script('jquery-ui-datepicker');
    	wp_enqueue_script('jquery-ui-slider');
    	wp_enqueue_script('jquery-touch-punch');
    	wp_enqueue_script('plchf_msb_farbtastic', 	PLUGINCHIEFMSB . 'js/vendor-scripts/farbtastic.js');
    	wp_enqueue_script('plchf_msb_tinymce', 		PLUGINCHIEFMSB . 'js/vendor-scripts/tiny_mce/jquery.tinymce.js');
    	wp_enqueue_script('plchf_msb_tooltip_js', 	PLUGINCHIEFMSB . 'js/vendor-scripts/tipsy.js');
    	wp_enqueue_script('plchf_msb_dropdowns_js', PLUGINCHIEFMSB . 'js/vendor-scripts/dropdowns.js');
    	wp_enqueue_script('plchf_msb_waypoints_js', PLUGINCHIEFMSB . 'js/vendor-scripts/jquery.waypoints.js');
    	wp_enqueue_script('plchf_msb_confirm_js', 	PLUGINCHIEFMSB . 'js/vendor-scripts/jquery.confirm.js');
    	wp_enqueue_script('plchf_msb_custom_js', 	PLUGINCHIEFMSB . 'js/scripts/custom.js');
    	
    }

/* ----------------------------------------------------------------------------
	
	Hide Submenu Pages

	This enqueues a js that we need on ALL admin pages, such as the JS that 
	hides the edit-site and edit-page pages from the admin sub-menus. 
	
	We use jQuery because remove_submenu_page breaks the page functionality. 
	(Perhaps there's a more elegant way around this?)
	
---------------------------------------------------------------------------- */

	function plchf_msb_all_admin_js() {
		
		wp_enqueue_script('plchf_msb_all_admin', 	PLUGINCHIEFMSB . 'js/scripts/admin.js');
		
	}
	
	add_action('admin_enqueue_scripts','plchf_msb_all_admin_js');

/* ----------------------------------------------------------------------------
	
	Enqueue Styles & Scripts
	
	This enqueues the scripts and styles on any of the 
	PluginChief Mobile Site Builder Admin Pages
	
---------------------------------------------------------------------------- */	
	
	function plchf_msb_enqueue_styles_and_scripts() {
		
		if (is_admin()) {

			$screen = get_current_screen();
			$screenid = $screen->id;
			
			// If pluginchiefmsb is in the Screen ID 
			// (So ultimately any sub-page of the main Plugin Chief Admin Page)
			if ( strpos($screenid, 'pluginchiefmsb') ) {
	        	
				plchf_msb_enqueue_plugin_scripts_and_styles();
	        
	        }
        
        }
        
    }

    add_action( 'admin_enqueue_scripts', 'plchf_msb_enqueue_styles_and_scripts' );
    
/* ----------------------------------------------------------------------------
	
	Setup Settings Pages Template Files

	Here we set up some hooks that we can use in any admin pages for the Mobile Site Builder. 
	These allow us to hook into certain parts of the templates. 

---------------------------------------------------------------------------- */
	
	// Get the Header for Admin Pages
	function get_pluginchiefmsb_header(){
		
		global $pluginchiefmsbdir; 
		
		// Pre-Header Hook
		pluginchiefmsb_admin_pre_header();
		
		// Header Hook
		pluginchiefmsb_admin_header();
	
		// Post Header Hook
		pluginchiefmsb_admin_post_header();
		
	}
	
	// Get the Footer for Admin Pages
	function get_pluginchiefmsb_footer(){
		
		// Pre Footer Hook
		pluginchiefmsb_admin_pre_footer();
	
		// Footer Hook
		pluginchiefmsb_admin_footer();
	
		// Post Footer Hook
		pluginchiefmsb_admin_post_footer();
		
	}

/* ----------------------------------------------------------------------------
	
	Check What PLUGINCHIEFMSB Page We're On

	This checks to see if we're on a Pluginchief MSB page
	
---------------------------------------------------------------------------- */

	function is_pluginchiefmsb_page(){
		
		$pluginchiefmsb_page 			= $_GET['page'];
		$pluginchiefmsb_page_firstfive 	= substr($pluginchiefmsb_page, 0, 5);
		
		// Check to see if we are on a pluginchiefmsb page
		if ($pluginchiefmsb_page_firstfive == 'pluginchiefmsb') {
			return true;
		} else {
			return false;
		}
		
	}

/* ----------------------------------------------------------------------------
	
	Get What PLUGINCHIEFMSB Page We're On, so we can do checks when necessary

	Example: if (get_pluginchiefmsb_page()) { // Do Something } else { // Do something else }

---------------------------------------------------------------------------- */

	function get_pluginchiefmsb_page() {
		
		$pluginchiefmsb_page 			= $_GET['page'];
		$pluginchiefmsb_page_firstfive 	= substr($pluginchiefmsb_page, 0, 5);
		$pluginchiefmsb_page_stripped	= substr($pluginchiefmsb_page, 6);
		
		// Check to see if we are on a pluginchiefmsb page
		if ($pluginchiefmsb_page_firstfive == 'pluginchiefmsb') {

			// Return what 
			return $pluginchiefmsb_page_stripped;
			
		} else {
			
		}
		
	}
	
/* ----------------------------------------------------------------------------
	
	Add Page Element Section to the Page Element menu on the "Edit Mobile Page" page
	
	Example: 
	
	function add_new_element_section() {
	
		plchf_msb_add_page_element_section('Content');
		
	}
	
	add_action('plchf_msb_page_element_section','add_new_element_section');
	
---------------------------------------------------------------------------- */

	function plchf_msb_add_page_element_section($title, $align) {
		
		if ($align == 'right') {
			$align = ' class="floatr"';
		} else {
			$align = '';
		}
		
		echo '<li'.$align.'>';
			echo '<a href="#" id="'.strtolower(str_replace(" ", "-", $title)).'-elements">'.$title.'</a>';
			echo '<ul class="form-elements '.strtolower(str_replace(" ", "-", $title)).'-elements">';
				
				// Social Elements Hook
				do_action('plchf_msb_'.strtolower(str_replace(" ", "_", $title)).'_elements');
				
			echo '</ul>';
		echo '</li>';
		
	}

/* ----------------------------------------------------------------------------
	
	Add Page Element to the Page Element menu on the "Edit Mobile Page" page
	
	usage: 
	
	function add_new_element() {
	
		plchf_msb_add_page_element('Text Element');
		
	}
	
	add_action('','add_new_element');
	
---------------------------------------------------------------------------- */

	function plchf_msb_add_page_element($element_type){
		
		echo '<li>';
			echo '<a href="#" data-elementtype="'.strtolower(str_replace(" ", "-", $element_type)).'">';
				echo $element_type;
			echo '</a>';
		echo '<li>';
		
	}
	
/* ----------------------------------------------------------------------------
	
	Add menu item to the Edit Page menu, to create a Page section
		
---------------------------------------------------------------------------- */

	function plchf_msb_add_page_section($section_type){
		
		echo '<li>';
			echo '<a href="#" data-sectiontype="'.strtolower(str_replace(" ", "-", $section_type)).'">';
				echo $section_type;
			echo '</a>';
		echo '<li>';
		
	}

/* ----------------------------------------------------------------------------
	
	Get the Page Title that we're editing
	
	This function gets the Page Title based on the Page ID, 
	for use on the edit page page

---------------------------------------------------------------------------- */
	
	function plchf_msb_get_page_title(){
		
		$page_id = $_GET['mobilesite_page_id'];
		
		$output .= get_the_title( $page_id );
		
		return apply_filters('plchf_msb_get_page_title', $output);
		
	}
	
/* ----------------------------------------------------------------------------
	
	Get the Site Title that we're editing

	This function gets the Site Title based on the Site ID, 
	for use on the edit page page
	
---------------------------------------------------------------------------- */
	
	function plchf_msb_get_site_title($id) {
		
		// Get the ID Passed to the Function or Get the Site ID if on Site Page
		if ($id) {
			$id = $id;
		} else {
			$id = $_GET['mobilesite_site_id'];
		}
		
		$post = get_post( $id );
		
		// Check to see if post has a parent or not. . .if so, the site is the post's parent, if not, this is the site
		if ( ($post->post_parent == 0) ) {
			$site_id = $post->ID;
		} else {
			$site_id = get_post($post->ID)->post_parent;
		}
		
		$output .= get_the_title( $site_id );
		
		return apply_filters('plchf_msb_get_site_title', $output);
		
	}

/* ----------------------------------------------------------------------------
	
	Get the Page ID, whether we're on the edit page screen or on the Non-Admin side
	
---------------------------------------------------------------------------- */
		
	function plchf_msb_get_page_id(){
		
		if (!is_admin())  {
		
			global $post, $wp_query;
			
			$page_id = $wp_query->post->ID;
		
		
		} else {
			
			$screen = get_current_screen();
		
			// Get Screen ID on Edit Page, page
			if ($screen->id == 'mobile-site-builder_page_pluginchiefmsb/edit-page') {

				$page_id = $_GET['mobilesite_page_id'];
		
			}
			
		}
		
		return apply_filters('plchf_msb_get_page_id_filter', $page_id);
		
	}
	
/* ----------------------------------------------------------------------------
	
	Set the Mobile Phone Preview Image
	
	This allows us to filter the image, so if we wanted to show an Android rather than an iPhone, for example, we could. . .
	or perhaps we offer users to preview their site on a White iPhone instead of Black! haha!
	
---------------------------------------------------------------------------- */
	
	function plchf_msb_phone_preview_image(){
		
		global $pluginchiefmsbdir;
		
		return apply_filters('plchf_phone_preview_image',$pluginchiefmsbdir . 'images/iphone.png');	
		
	}

/* ----------------------------------------------------------------------------
	
	Set the Mobile Phone Preview Content
	
	This sets the iFrame content for the live site preview.
	
---------------------------------------------------------------------------- */
	
	function plchf_msb_phone_preview_site(){
		
		global $pluginchiefmsbdir;
		
		if (is_admin()) { 
			
			$screen = get_current_screen();
		
			// Get Screen ID on Edit Page, page
			if ($screen->id == 'mobile-site-builder_page_pluginchiefmsb/edit-page') {
			
				// Get the Page We're Editing
				$id = $_GET['mobilesite_page_id'];
		  
			// Get the Site ID on the Edit Site Page 
			} elseif ($screen->id == 'mobile-site-builder_page_pluginchiefmsb/edit-site') {
	    	
				// Get the Home Page
				$id = $_GET['mobilesite_site_id'];
	    	
				// ID of the Home Page we generated on Site Completion
				$id = get_post_meta($id, '_homepage_', true);
	    	 	
		    }
		 
		// If Not Admin   
		} else {
			
			//Globals
			global $post, $wp_query, $plchf_msb_options;
		
			// Get the Post ID
			$postid = $wp_query->post->ID;
			
			// Get Front End Page IDs
			$edit_page_id 	= $plchf_msb_options['_edit_page_page_'];
			$edit_site_id 	= $plchf_msb_options['_edit_site_page_'];
			$my_sites_id 	= $plchf_msb_options['_my_sites_page_'];
			
			// Check if Page is one of the Pages selected in the Plugin Settings Panel
			if ( ($postid == $edit_page_id) ) {

				// Get the Page We're Editing
				$id = $_GET['mobilesite_page_id'];
							
			} elseif ( ($postid == $edit_site_id) || ($postid == $my_sites_id) ) {
					
				// Site ID
				$id = $_GET['mobilesite_site_id'];
				
				// ID of the Home Page we generated on Site Completion
				$id = get_post_meta($id, '_homepage_', true);
				
			}
			
		}
	    
	    $url = get_permalink($id);
		
		// Iframe Preview
		$output .= '<iframe id="preview-frame" src="'.$url.'" data-siteid="'.$id.'" data-id="'.$postid.'" width="230" height="343"></iframe>';
		
		// Loading Gif Div
		$output .= '<div class="mobile-preview-loader"></div>';
		
		return apply_filters('plchf_msb_phone_preview_site_filter',$output);	
		
	}

/* ----------------------------------------------------------------------------
	
	Mobile Page Generator

	This is the form where page elements are added, then submitted to be saved. 
	
	There is a hook before the form (so no data is saved from those hooks). . .
	we can show things like warnings and alerts here or whatever
	
	There is a hook at the top of the form (so we can hook in and add settings that will be saved)
	
	There is a hook at the bottom of the form (so we can hook in and add settings that will be saved)
	
	There is a hook after the form (so no data is saved from those hooks). . .
	we can show things like warnings and alerts here or whatever
	
	
	
---------------------------------------------------------------------------- */
	
	function plchf_msb_page_generator(){
		
		// Run action before Page Generator Form
		do_action('plchf_msb_before_page_generator');
		
		$page_id = plchf_msb_get_page_id();

		// Page Generator Form
		echo '<form id="page-generator" class="page-generator connected-sortable" enctype="multipart/form-data" action="" method="post" data-postid="'.$page_id.'">';
						
			// Run Action at the Top of the Page Generator form
			do_action('plchf_msb_top_page_generator');
						
			$elements = get_post_meta($page_id, '_plchf_msb_page_elements', true);
			
			if($elements) { 
							
				// Loop Through the Post Meta
				foreach($elements as $element) {
		    		
		    		foreach ($element as $k => $values) {
			    		
			    		// $k is the element type, and element count, we split that into 2 parts
			    		// so part [0] is the Element Type and part [1] is the element count
			    		// We then pass that to the element type action
			    		$element_type_and_count = explode("_", $k);
			    		$element_type = str_ireplace("-", "_", $element_type_and_count[0]);
			    		$count	= $element_type_and_count[1];
			    		
			    		// Check if the Element Type is 
			    		if ($element_type == 'section_start') {
			    			
			    			echo plchf_msb_page_section_start('Start Section','',$count,'');
			    		
			    		}  elseif ($element_type == 'section_end') {
				    		
				    		
				    		echo plchf_msb_page_section_end('End Section','',$count,'');
				    		
			    		}
			    		
			    		// We run the action for each element
			    		do_action('plchf_msb_page_element_settings_'.$element_type.'', $element_type_and_count[1], $values);
			    		
		    		}	
	    		
	    		}
				
			} else {
				
				// Display Message When No Page Elements Exist
				
				echo '<div class="element-placeholder"><br/>';
					
					echo apply_filters('plchf_msb_no_page_elements_message','Choose elements above to add to the page.');
				
				echo '</div>';
			
			}
			
			// Run Action at the Bottom of the Page Generator
			do_action('plchf_msb_bottom_page_generator');
	
			echo apply_filters('plchf_msb_page_generator_save_button','<button class="ajaxsave button-primary">Save</button>');
	
			wp_nonce_field('page_elements_nonce', 'page_elements_nonce_field');

		// End Form
		echo '</form>';
		
		// Run Action After Page Generator Form
		do_action('plchf_msb_after_page_generator');
		
	}

/* ----------------------------------------------------------------------------
	
	Function to Get the Values of the Page Elements
	
	This function lets us specify an element field that we want to get a value for
	
	An example of usage is the Facebook wall. . .
	We need to get the value from the page element in order to add JS to the footer of the template
	
	NOTE:
	
	There's a good chance this MAY need to be re-worked somehow to allow for getting values of fields 
	for elements when there are multiple instances of the same element on the page.
	
---------------------------------------------------------------------------- */	

	function plchf_msb_get_page_element_field( $element_field ){
		
		// Get the Page ID
		$page_id = plchf_msb_get_page_id();
		
		// Get teh Page Elements
		$elements = get_post_meta($page_id, '_plchf_msb_page_elements', true);
		
		if ($elements) {
			
			// Loop Throught Elements Array
			foreach ($elements as $element) {
			
				// Loop through the elements
				foreach ($element as $element_type) {

					// Loop through all element fields within the element
					foreach ($element_type as $key => $value) {
				    	
				    	// The it's the element field we're looking for
				    	if ($element_field == $key) {
				    		
				    		// Return The Value
				    		return $value;
				    	
				    	}
				    	
			    	}
				
				}
				
			}
			
		}
		
	}

/* ----------------------------------------------------------------------------
	
	Get Site Option
	
	This allows us to specify an option from the Site Options array and get the value

---------------------------------------------------------------------------- */	

	function plchf_msb_get_site_option($type, $id) {
		
		global $post, $wp_query;
		
		$site_id = plchf_msb_get_site_id();
		
		$settings = get_post_meta($site_id, '_plchf_msb_site_options', true);
		
		if ($settings) {
		
			foreach ($settings as $setting) {
				
				$output .= $setting[''.$type.$id.''][''.$id.''];
				
			} 
		
		}
		
		return $output;
		
	}

/* ----------------------------------------------------------------------------
	Site Settings Panels
---------------------------------------------------------------------------- */	
	
	function plchf_msb_site_settings() {
		
		do_action('plchf_msb_before_site_settings');
		
		// Page Generator Form
		echo '<form id="site-settings" class="site-settings" enctype="multipart/form-data" action="" method="post" data-postid="'.plchf_msb_get_site_id().'">';
			
			// Run Action at the Top of the Form
			do_action('plchf_msb_top_site_settings'); 
			
			$theme_slug = plchf_msb_get_theme_slug();
			
			// Page Generator Content
			do_action('plchf_msb_site_settings_content_'.$theme_slug.'');
			
			// Run Action at the Bottom of the Form
			do_action('plchf_msb_bottom_site_settings');
			
			wp_nonce_field('site_options_nonce', 'site_options_nonce_field');
			
			echo apply_filters('plchf_msb_site_settings_save_button','<button class="site-options-ajaxsave button-primary">Save</button>');	
			
		// End Form
		echo '</form>';
		
		do_action('plchf_msb_after_site_settings');	
		
	}

/* ----------------------------------------------------------------------------
	Site Settings Title
---------------------------------------------------------------------------- */	

	function plchf_msb_add_title_above_site_settngs_panels(){
		
		$output .= '<h3>Site Settings</h3>';
		
		echo apply_filters('plchf_msb_site_settings_panel_title', $output);
		
	}
	
	add_action('plchf_msb_before_site_settings','plchf_msb_add_title_above_site_settngs_panels');
	
/* ----------------------------------------------------------------------------
	Mobile Page Content
---------------------------------------------------------------------------- */	
     
    function plchf_msb_page_content() {
	  	
	  	global $post, $wp_query;
	  	
	  	// Get Page ID
	  	$page_id = $wp_query->post->ID;
	  	
	  	// Get Page Elements
	  	$elements = get_post_meta($page_id, '_plchf_msb_page_elements', true);
			
		if($elements) { 
						
			// Loop Through the Post Meta
			foreach($elements as $element) {
	    		
	    		foreach ($element as $k => $values) {
		    		
		    		// $k is the element type, and element count, we split that into 2 parts
		    		// so part [0] is the Element Type and part [1] is the element count
		    		// We then pass that to the element type action
		    		$element_type_and_count = explode("_", $k);
		    		$element_type = str_ireplace("-", "_", $element_type_and_count[0]);
		    		
		    		$tidy = new Tidy();

		    		// We run the action for each element
		    		echo do_action('plchf_msb_page_element_output_'.$element_type.'', $values);
		    		
	    		}
	    		
    		
    		}
			
		} else {
			
			// Display Message When No Page Elements Exist
			echo '<div class="element-placeholder">';
				echo apply_filters('plchf_msb_no_page_elements_message','Choose elements above to add to the page.');
			echo '</div>';
		
		}
	    
    }
    	
//------------------------------------------------------------------------//
// Save Mobile Page Elements
//------------------------------------------------------------------------//

	function plchf_msb_save_the_page_elements_ajax() {
	
		global $post, $wp_query;
			
		$id	= $_POST['post_id'];
		
		if (get_post_meta(''.$id.'','_plchf_msb_page_elements', true)) {
			$page_elements = get_post_meta(''.$id.'','_plchf_msb_page_elements', true);
		} else {
			$page_elements = false;	
		}
		
		if(isset($_POST['page_elements_nonce_field']) && wp_verify_nonce($_POST['page_elements_nonce_field'], 'page_elements_nonce')) {
		
			$page_elements = array();
										
				foreach($_POST['field'] as $k => $v) {
                                       
                	$page_elements[] = array(
                		$k => $v,
                	);
                               
                }
			
			$updated_meta = update_post_meta(''.$id.'', '_plchf_msb_page_elements', $page_elements);
			
			// Print the Data on return to AJAX
			print_r($page_elements);
			
			die();
		
		}
	
	}
	
	add_action('wp_ajax_plchf_msb_save_the_page_elements_ajax','plchf_msb_save_the_page_elements_ajax');

/* ----------------------------------------------------------------------------
	
	Save Site Options
	
	This saves the Site Options using AJAX

---------------------------------------------------------------------------- */	

	function plchf_msb_save_site_options_ajax() {
		
		global $post, $wp_query;
		
		$id	= $_POST['site_id'];
		
		if (get_post_meta(''.$id.'','_plchf_msb_page_elements', true)) {
			$site_options = get_post_meta(''.$id.'','_plchf_msb_site_options', true);
		} else {
			$site_options = false;	
		}
		
		if(isset($_POST['site_options_nonce_field']) && wp_verify_nonce($_POST['site_options_nonce_field'], 'site_options_nonce')) {
		
			$site_options = array();
										
				foreach($_POST['field'] as $key => $value) {
                                       
                	$site_options[] = array(
                		$key => $value,
                	);
                               
                }
			
			$updated_meta = update_post_meta(''.$id.'', '_plchf_msb_site_options', $site_options);
			
			// Print the Data on return to AJAX
			// print_r($page_elements);
			
			die();
		
		}
	
	}
	
	add_action('wp_ajax_plchf_msb_save_site_options_ajax', 'plchf_msb_save_site_options_ajax');
	
/* ----------------------------------------------------------------------------
	Add Element to Page
---------------------------------------------------------------------------- */	

	function plchf_msb_add_element(){
		
		$pageid			= $_POST['pageid'];
		$element_type 	= $_POST['elementType'];
		$element_type 	= strtolower(str_replace("-", "_", $element_type));
		
		// Get Current Page Element Count
		$meta 	= get_post_custom($pageid);
		$count	= $meta['_plchf_msb_page_element_count'][0]; 
		
		// Increase Page Element Count By 1
		$count 	= ($count+1);
		
		// Update Page Element Count
		update_post_meta($pageid, '_plchf_msb_page_element_count', $count);
		
		do_action('plchf_msb_page_element_settings_'.$element_type.'', $count, $values);
		
		die();
		
	}
	
	add_action( 'wp_ajax_plchf_msb_add_element','plchf_msb_add_element');

/* ----------------------------------------------------------------------------
	Add Page Section to Page
---------------------------------------------------------------------------- */	
	
	function plchf_msb_add_section() {

		$pageid			= $_POST['pageid'];
		$section_type 	= $_POST['sectionType'];
		$section_type 	= strtolower(str_replace("-", "_", $section_type));
		
		// Get Current Page Element Count
		$meta 	= get_post_custom($pageid);
		$count	= $meta['_plchf_msb_page_element_count'][0]; 
		
		// Increase Page Element Count By 1
		$count 	= ($count+1);
		
		// Update Page Element Count
		update_post_meta($pageid, '_plchf_msb_page_element_count', $count);
		
		do_action('plchf_msb_page_element_settings_'.$section_type.'', $count, $values);
		
		die();
				
	}
	
	add_action( 'wp_ajax_plchf_msb_add_section','plchf_msb_add_section');

/* ----------------------------------------------------------------------------
	Create some JS Variables
---------------------------------------------------------------------------- */
	
	function plchf_msb_page_section_start_1($section_type, $fields, $count, $values) {
		
		$formatted_section_type = strtolower(str_replace(" ", "_", $section_type));
		
		$output .= '<div class="page-generator-section">';
		
			$output .= '<div class="section-element-move">';
			
				$output .= '<h3>'.$section_type.'</h3>'; 
				
			$output .= '</div>';
				
			$output .= '<input type="hidden" name="field[section-start_'.$count.'][section_type]" value="'.$formatted_section_type.'">';
				
			$output .= '<div class="section-sortable connected-sortable"></div>';
		
		echo $output;
		
	}
	
	function plchf_msb_page_section_start($section_type, $fields, $count, $values) {
	
		$formatted_section_type = strtolower(str_replace(" ", "_", $section_type));
		
	    echo  '<div class="page-section element-'.$formatted_section_type.' sortable">';
	    	
	    	// Settings Bar
	    	echo  '<div class="settings-bar">';
	    		echo  '<div class="inner-settings-bar">';
	    			echo  '<div class="one_third">';
	    				echo  '<div class="element-info">';
	    					echo  $section_type;
	    				echo  '</div>';
	    			echo  '</div>';
	    			echo  '<div class="two_third column-last">';
		    			echo  '<div class="controls">';
		    				echo  '<div class="element-control element-move"></div>';
		    				echo  '<div class="element-control element-open"></div>';
		    				echo  '<div class="element-control element-remove"></div>';
		    			echo  '</div>';
		    		echo  '</div>';
	    		echo  '</div>';
	    	echo  '</div>';
	    	
	    	// Settings Content
		    echo  '<div class="content">';
			    echo '<input type="hidden" name="field[section-start_'.$count.'][section_type]" value="'.$formatted_section_type.'">';
			    echo '<div class="section-sortable connected-sortable">';
		
	}
	
	function plchf_msb_page_section_end($section_type, $fields, $count, $values) {
		
		$formatted_section_type = strtolower(str_replace(" ", "_", $section_type));
			
				
				$output .= '</div>';			
			
			$output .= '<input type="hidden" name="field[section-end_'.$count.'][section_type]" value="'.$formatted_section_type.'">';
			
			$output .= '</div>';
			
		$output .= '</div>';
		
		echo $output;
		
	}

/* ----------------------------------------------------------------------------
	Create some JS Variables
---------------------------------------------------------------------------- */	

	function plchf_msb_jquery_theme_directory_variable() {
		
		global $stripe_secret, $stripe_publishable;
		
		$plugin_dir 	= PLUGINCHIEFMSB;
		$permalink		= get_permalink();	
		$siteRoot		= get_bloginfo('url');
		$ajaxurl		= admin_url('admin-ajax.php');
		$adminRoot		= admin_url();
		
		echo '
		<script type="text/javascript" src="https://js.stripe.com/v1/?ver=1.0"></script>
		<script type="text/javascript">
			var pluginDir = "'.$plugin_dir.'";
			var siteRoot = "'.$siteRoot.'";
			var adminRoot = "'.$adminRoot.'";
			var ajaxurl = "'.$ajaxurl.'";
			Stripe.setPublishableKey("'.$stripe_publishable.'");
		</script>
		';
		
	}
	
	add_action('wp_head','plchf_msb_jquery_theme_directory_variable', 999);
	add_action('admin_head','plchf_msb_jquery_theme_directory_variable');

/* ----------------------------------------------------------------------------
	Create Settings Section for Page Elements
---------------------------------------------------------------------------- */	
	    
    function plchf_msb_page_element_settings_section($element_type, $fields, $count, $values){
	    
	    $element_type_formatted = strtolower(str_replace(" ", "-", $element_type));
	    
	    echo  '<div class="page-section sortable">';
	    	
	    	echo '<h2>'.$element_type.'</h2>';
	    	
	    	echo  '<div class="controls-wrapper">';
	    		echo  '<div class="controls">';
	    			echo  '<div>';
	    				echo  '<div>';
	    					echo  '<div class="element-control element-move"></div>';
	    					echo  '<div class="element-control element-remove"></div>';
	    				echo  '</div>';
	    			echo  '</div>';
	    		echo  '</div>';
	  		echo  '</div>';
	  		
	  		echo '<div class="nested-sortable connected-sortable">';
	  			
	  		echo '</div>';
		    	
		echo  '</div>';
	    
    }
    
/* ----------------------------------------------------------------------------
	Create Settings Panel for Page Element
---------------------------------------------------------------------------- */	
	    
    function plchf_msb_page_element_settings_panel($element_type, $fields, $count, $values){
	    
	    $element_type_formatted = strtolower(str_replace(" ", "-", $element_type));
	    
	    echo  '<div class="page-element element-'.$element_type_formatted.' sortable">';
	    	
	    	// Settings Bar
	    	echo  '<div class="settings-bar">';
	    		echo  '<div class="inner-settings-bar">';
	    			echo  '<div class="one_third">';
	    				echo  '<div class="element-info">';
	    					echo  $element_type;
	    				echo  '</div>';
	    			echo  '</div>';
	    			echo  '<div class="two_third column-last">';
		    			echo  '<div class="controls">';
		    				echo  '<div class="element-control element-move"></div>';
		    				echo  '<div class="element-control element-open"></div>';
		    				echo  '<div class="element-control element-remove"></div>';
		    			echo  '</div>';
		    		echo  '</div>';
	    		echo  '</div>';
	    	echo  '</div>';
	    	
	    	// Settings Content
		    echo  '<div class="content">';
		    		
		    	echo  '<h2>'.$element_type.'</h2>';
		    	
		    		// Loop through the fields that were passed when setting up the page element
		    		foreach ($fields as $fields) {
		    		
		    			// Get the Field Type
		    			$type = $fields['field']['type'];
			    		
			    		$element_type = $element_type_formatted;
			    		
			    		// Do the Action for the Associated Field Type
			    		do_action('plchf_msb_page_element_settings_field_'.$type, $fields, $element_type, $count, $values);
			    		
			    		echo '<br/>';
		    		
		    		}
		    		
		    		echo '<button class="ajaxsave button-primary">Save</button>';
		    		
		    	echo  '</div>';
		    	
		    echo  '</div>';
	    
    }

/* ----------------------------------------------------------------------------
	Create Settings Panel for Site Settings
---------------------------------------------------------------------------- */	
	    
    function plchf_site_settings_settings_panel($panels){
    
    	foreach ($panels as $panel) {
    	
    		$panel_name = $panel['panel_name'];
    		
		    $panel_name_formatted = strtolower(str_replace(" ", "-", $panel_name));
		    
		    echo  '<div class="page-element '.$panel_name_formatted.' draggable">';
		    	
		    	// Settings Bar
		    	echo  '<div class="settings-bar">';
		    		echo  '<div class="inner-settings-bar">';
		    			echo  '<div class="one_third">';
		    				echo  '<div class="element-info">';
		    					echo  $panel_name;
		    				echo  '</div>';
		    			echo  '</div>';
		    			echo  '<div class="two_third column-last">';
			    			echo  '<div class="controls">';
			    				echo  '<div class="element-control element-open"></div>';
			    			echo  '</div>';
			    		echo  '</div>';
		    		echo  '</div>';
		    	echo  '</div>';
		    	
		    	// Settings Content
			    echo  '<div class="content">';
			    		
			    	echo  '<h2>'.$panel_name.'</h2>';
			    		
		    		// Loop through the fields that were passed when setting up the page element
		    		foreach ($panel['fields'] as $fields) {
		    		
		    			// Get the Field Type
		    			$type = $fields['type'];
			    		
			    		// Do the Action for the Associated Field Type
			    		do_action('plchf_msb_site_settings_field_'.$type.'', $fields, $type);
			    		
			    		echo '<br/>';
		    		
		    		}
		    		
		    		echo '<button class="site-options-ajaxsave button-primary">Save</button>';
			    		
			    echo  '</div>';
			   	
			echo  '</div>';
	
	    } // End Panels loop
   
    }

/* ----------------------------------------------------------------------------
	Get Site ID
---------------------------------------------------------------------------- */	
   
    function plchf_msb_get_site_id() {
	    
	    if (is_admin()) {

		    $screen = get_current_screen();
			
			// Get Screen ID on Edit Page, page
			if ($screen->id == 'mobile-site-builder_page_pluginchiefmsb/edit-page') {
				
				// Get the Page We're Editing
			    $page_id = $_GET['mobilesite_page_id'];
			    
			    // Get the Page Parent, which is the Site
			    $site_id = get_post($page_id)->post_parent;
			  
			// Get the Site ID on the Edit Site Page 
		    } elseif ($screen->id == 'mobile-site-builder_page_pluginchiefmsb/edit-site') {
			 
				$site_id = $_GET['mobilesite_site_id'];	 
				    
		    }
		
		// If Front End
		} else {
			
			//Globals
			global $post, $wp_query, $plchf_msb_options;
		
			// Get the Post ID
			$postid = $wp_query->post->ID;
			
			// Get Front End Page IDs
			$edit_page_id 	= $plchf_msb_options['_edit_page_page_'];
			$edit_site_id 	= $plchf_msb_options['_edit_site_page_'];
			$my_sites_id 	= $plchf_msb_options['_my_sites_page_'];
		
			// Check if Page is one of the Pages selected in the Plugin Settings Panel
			if ( ($postid == $edit_page_id) ) {

				// Get the Page We're Editing
				$page_id = $_GET['mobilesite_page_id'];
		    
				// Get the Page Parent, which is the Site
				$site_id = get_post($page_id)->post_parent;
							
			} else if ( ($postid == $edit_site_id) || ($postid == $my_sites_id) ) {
				
				$site_id = $_GET['mobilesite_site_id'];
			
			// If we're on one of the Mobile Site Pages	
			} else {
				
				$site_id = get_post($postid)->post_parent;
				
			}
			
		}
	    
	    return apply_filters('plchf_msb_get_site_id', $site_id);
	    
    }

/* ----------------------------------------------------------------------------
	QR Code Site Preview
---------------------------------------------------------------------------- */	
   
    function plchf_msb_qrcode_preview($id) {
	    
	    // Get Site ID
	    $site_id = plchf_msb_get_site_id();
	    
	    if ($id) {
		    $site_id = $id;
	    } else if ($site_id) {
		    $site_id = $site_id;
	    }
	    
	    // Get Permalink for the Site ID
	    $permalink = get_permalink($site_id);
	    
	    $output .= '
	    <div style="display:block; margin:0px auto; width:80%;">
	    	<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$permalink.'&choe=UTF-8&chld=|0" width="100%" height="auto">
	    </div>
	    ';
	    
	    do_action('plchf_msb_above_qrcode_preview');
	    
	    echo apply_filters('plchf_msb_qrcode_preview', $output);
	    
	    do_action('plchf_msb_below_qrcode_preview');
	    
    }
  
/*-----------------------------------------------------------------------------------*/
/* Creates Google Shortlink for Pages and Posts | Usage: wp_get_shortlink();
/*-----------------------------------------------------------------------------------*/

function plchf_msb_googl_shortlink($url) {
	
	$http = new WP_Http();
	
	$headers = array('Content-Type' => 'application/json');
	
	$result = $http->request('https://www.googleapis.com/urlshortener/v1/url', array( 
		'method' => 'POST', 
		'body' => '{
			"longUrl": "' . $url . '"
		}', 
		'headers' => $headers
		)
	);
	
	$result 	= json_decode($result['body']);
	$shortlink 	= $result->id;

	if ($shortlink) {
		return $shortlink;
	} else {
		return $shortlink;
	}

}
  
/* ----------------------------------------------------------------------------
	Mobile Site Shortlink
---------------------------------------------------------------------------- */	
      
    function plchf_msb_site_shortlink($id) {
	    
	    // Get Site ID
	    $site_id = plchf_msb_get_site_id();
	    
	    if ($id) {
		    $site_id = $id;
	    } else if ($site_id) {
		    $site_id = $site_id;
	    }
	    
	    // Get Permalink for the Site ID
	    $permalink = get_permalink($site_id);
	    
	    do_action('plchf_msb_above_googl_shortlink');
	    
	    $output .= '<hr>';
	    
	    $output .= '<strong>'.apply_filters('plchf_msb_shortlink_title', 'Site Shortlink:').'</strong> ';
	    
	    $output .= '<a href="'.plchf_msb_googl_shortlink($permalink).'" target="_blank">'.plchf_msb_googl_shortlink($permalink).'</a>';
	    
	    echo apply_filters('plchf_msb_googl_site_shortlink', $output);
	    
	    do_action('plchf_msb_below_googl_shortlink');
	    
    }
    
/* ----------------------------------------------------------------------------
	Mobile Site Template Redirect
---------------------------------------------------------------------------- */

	function plchf_msb_template_redirect(){
		
		global $post;
		
		// Site ID
		$parent_id 	= get_post($post->ID)->post_parent;
		
		// Site Settings
		$meta 		= get_post_custom($parent_id);
		
		// Site Theme Setting
		$site_theme = $meta['_plchf_msb_site_theme'][0];
		
		// Formatted Site Theme
		$site_theme = strtolower(str_ireplace('-', '_' ,$site_theme));
		
		// Set Theme, or Set to Default Theme
		if ($site_theme == '') {
			$site_theme = 'default_theme';
		} else {
			$site_theme = $site_theme;
		}
		
		// Only Run id Post Type is Plugin Chief MSB Sites
	    if ($post->post_type == 'pluginchiefmsb-sites') {
	    	
	    	$single_template = apply_filters('plchf_msb_theme_root_'.$site_theme.'', 'goo').apply_filters('plchf_msb_theme_page_'.$site_theme.'','goo');
	    
	    }
	     
	    return $single_template;	
		
	}

	add_filter( "single_template", "plchf_msb_template_redirect", 1);

/* ----------------------------------------------------------------------------
	Correct image path issue in thickbox
---------------------------------------------------------------------------- */
 
	function plchf_msb_load_tb_fix() {
		
		echo '<script type="text/javascript">tb_pathToImage = "' . get_option('siteurl') . '/wp-includes/js/thickbox/loadingAnimation.gif";tb_closeImage = "' . get_option('siteurl') . '/wp-includes/js/thickbox/tb-close.png";</script>';
		
	}

	add_action('wp_footer', 'plchf_msb_load_tb_fix');

/* ----------------------------------------------------------------------------
	Create Site Function
---------------------------------------------------------------------------- */

	function plchf_msb_create_new_site() {
		
		global $current_user;
		get_currentuserinfo();
		
		// Set Up Variables
		$userid = $current_user->ID;
		
		// Check to see if Create Site Nonce is verified
		if(isset($_POST['plchf_msb_create_new_site_field']) && wp_verify_nonce($_POST['plchf_msb_create_new_site_field'], 'plchf_msb_create_new_site')) {
			
			// Get Post Data
			$name	= $_POST['plchf_msb_create_new_site_site_name'];
			$theme 	= $_POST['plchf_msb_create_new_site_theme'];
			
			// Allows us to hook in and get more post data, if needed
			do_action('plchf_msb_create_new_site_post_data');
			
			// Create the New Site
			$post = array(
				'post_author' 	=> $userid,
				'post_content' 	=> 'This is the default content for the site',
				'post_name' 	=> $name,
				'post_status' 	=> 'publish',
				'post_title' 	=> $name,
				'post_type' 	=> 'pluginchiefmsb-sites',
			); 
			
			// Insert New Site
			$new_site = wp_insert_post($post);
			
			// Set Site Theme
			update_post_meta($new_site, '_plchf_msb_site_theme', $theme);
			
			// After Create Site
			do_action('plchf_msb_after_create_new_site', $new_site);
			
			// Redirect URL 
			$redirect_url = apply_filters('plchf_msb_redirect_after_create_site', 'admin.php?page=pluginchiefmsb/edit-site&mobilesite_site_id='.$new_site.'', $new_site);
			
			// Redirect to Edit Site Page
			wp_redirect($redirect_url);
			exit;
			
		}
		
	}
	
	add_action('init','plchf_msb_create_new_site');


/* ----------------------------------------------------------------------------
	Create Default Home Page Upon Site Creation 
---------------------------------------------------------------------------- */

	function plchf_msb_site_pages_links($site_id) {
		
		global $post;
		
		// Args
		$args = array(
			'post_type' => 'pluginchiefmsb-sites',
			'post_parent' => $site_id
		);
		
		$posts = get_posts( $args );
		
		$output .= '<ul class="mobile-site-pages">';
		
		foreach ($posts as $post) {
			
			$output .= '<li><a href="'.apply_filters('plchf_msb_edit_page_link','admin.php?page=pluginchiefmsb/edit-page&mobilesite_page_id='.$post->ID.'').'">'.$post->post_title.'</a></li>';
			
		}
		
		$output .= '</ul>';
		
		echo apply_filters('plchf_msb_site_pages_links',$output);
		
	}

/* ----------------------------------------------------------------------------
	Create Default Home Page Upon Site Creation 
---------------------------------------------------------------------------- */
	
	function plchf_msb_default_theme_default_pages($new_site){
	
		global $current_user;
		get_currentuserinfo();
		
		// Get Current User ID
		$userid = $current_user->ID;
		
		// Create a Default Home Page
		$home = array(
			'comment_status'=> 'closed',      			// 'closed' means no comments.
			'ping_status' 	=> 'closed',      			// 'closed' means pingbacks or trackbacks turned off
			'post_author' 	=> $userid,
			'post_name' 	=> 'home', 					// The name (slug) for your post
			'post_status' 	=> 'publish',     			// Set the status of the new post. 
			'post_title' 	=> 'Home', 	      			// The title of your post.
			'post_parent'   => $new_site,				// Post Parent
			'post_type' 	=> 'pluginchiefmsb-sites'	// Post Type
		);

		// Create a Default About Page
		$about = array(
			'comment_status'=> 'closed',      			// 'closed' means no comments.
			'ping_status' 	=> 'closed',      			// 'closed' means pingbacks or trackbacks turned off
			'post_author' 	=> $userid,
			'post_name' 	=> 'about', 				// The name (slug) for your post
			'post_status' 	=> 'publish',     			// Set the status of the new post. 
			'post_title' 	=> 'About', 	      		// The title of your post.
			'post_parent'   => $new_site,				// Post Parent
			'post_type' 	=> 'pluginchiefmsb-sites'	// Post Type
		);
		
		// Create a Default Contact Page
		$contact = array(
			'comment_status'=> 'closed',      			// 'closed' means no comments.
			'ping_status' 	=> 'closed',      			// 'closed' means pingbacks or trackbacks turned off
			'post_author' 	=> $userid,
			'post_name' 	=> 'contact', 				// The name (slug) for your post
			'post_status' 	=> 'publish',     			// Set the status of the new post. 
			'post_title' 	=> 'Contact', 	      		// The title of your post.
			'post_parent'   => $new_site,				// Post Parent
			'post_type' 	=> 'pluginchiefmsb-sites'	// Post Type
		);
		
		// Insert Default Page for new Sites
		$home = apply_filters('plchf_msb_insert_default_page1', wp_insert_post( $home ));
		
		// Insert Default About Page for new Sites
		$about = apply_filters('plchf_msb_insert_default_page2', wp_insert_post( $about ));
		
		// Insert Default Page for new Sites
		$contact = apply_filters('plchf_msb_insert_default_page3', wp_insert_post( $contact ));
		
		// Update Site Home Meta
		$homepage = update_post_meta($new_site, '_homepage_', $home);
		
	}
	
	add_action('plchf_msb_after_create_new_site','plchf_msb_default_theme_default_pages');
	
/* ----------------------------------------------------------------------------
	Flush Permalinks 
---------------------------------------------------------------------------- */	
	
	function plchf_msb_flush_permalinks(){	
			
		global $wp_rewrite;
		
		$wp_rewrite->flush_rules();
	
	}
	
	add_action('admin_init','plchf_msb_flush_permalinks');

/* ----------------------------------------------------------------------------
	Load Defaul Theme Header Meta 
---------------------------------------------------------------------------- */		
	
	function plchf_msb_load_default_theme_header(){
		
		global $post, $wp_query;
		
		// Get Post ID
		$post_id = $wp_query->post->ID;
		
		$output .= '
		<meta charset="utf-8">
		<title>'.get_the_title($post_id).'</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
	    ';
	    
	    // Echo the Headers
	    echo apply_filters('plchf_msb_load_default_theme_header_filter', $output);
    
	}
	
	add_action('plchf_msb_theme_header','plchf_msb_load_default_theme_header', 1);
	
/* ----------------------------------------------------------------------------
	Load BootStrap Styles in Theme Header 
---------------------------------------------------------------------------- */	
	
	function plchf_msb_load_bootstrap_styles() {
	
		global $pluginchiefmsbdir;
		
		$output .= '
		<!-- Le styles -->
		<link href="'.$pluginchiefmsbdir.'theme-assets/css/bootstrap.css" rel="stylesheet">
		<link href="'.$pluginchiefmsbdir.'theme-assets/css/app.css" rel="stylesheet">
		<link href="'.$pluginchiefmsbdir.'theme-assets/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="'.$pluginchiefmsbdir.'css/font-awesome/css/font-awesome.css" rel="stylesheet">
		
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		';
		
		echo apply_filters('plchf_msb_load_bootstrap_styles_filter', $output);
    
    }
    
    add_action('plchf_msb_theme_header','plchf_msb_load_bootstrap_styles', 2);
    
/* ----------------------------------------------------------------------------
	Site Details on the My Sites Page
---------------------------------------------------------------------------- */

	function plchf_msb_delete_site_button() {
	
		global $post;
		
		$parent = get_post($post->ID)->post_parent;
		
		echo get_post($parent)->ID;
		
	}
	
	add_action('plchf_msb_site_details', 'plchf_msb_delete_site_button');