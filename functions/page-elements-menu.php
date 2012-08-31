<?php

/* ---------------------------------------------------------------------------- */
/* Loop Through Global Page Elements and Create the Menu That Adds them
/* 
/* usage: pluginchiefmsb_page_elements_menu();
/* 
/* ---------------------------------------------------------------------------- */

function pluginchiefmsb_page_elements_menu() {
	
	global $pluginchiefmsb_page_elements;
	
	// Start the Menu Output
	echo '<ul class="elementmenu sgray" id="page-element-menu">';
		
		$support = plchf_msb_theme_supports_page_elements();
		
		// If Theme Supports Page Elements
		if ($support == 'Yes') {
		
			echo apply_filters('plchf_msb_page_elements_title','<li><p>Page Elements:</p></li>');
			
			// Element Sections Hook
			do_action('plchf_msb_page_element_sections');
		
		} else {
			
			echo '<li><p>Page: '.plchf_msb_get_page_title().'</p></li>';
			
			// No Support For Page Elements in this theme
			do_action('plchf_msb_page_element_menu_no_support');
			
		}
		
			// Add Elements to the Right Side of the Menu
			do_action('plchf_msb_page_element_right_sections');
	
	// End the Menu Output
	echo '</ul>';
	
}

/* ---------------------------------------------------------------------------- */
/* Content Section
/* ---------------------------------------------------------------------------- */

	function plchf_add_element_section_content() {
		
		plchf_msb_add_page_element_section('Content', 'left');
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_add_element_section_content');

/* ---------------------------------------------------------------------------- */
/* Media Section
/* ---------------------------------------------------------------------------- */

	function plchf_add_element_section_media() {
		
		plchf_msb_add_page_element_section('Media', 'left');
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_add_element_section_media');

/* ---------------------------------------------------------------------------- */
/* Social Section
/* ---------------------------------------------------------------------------- */

	function plchf_add_element_section_social() {
		
		plchf_msb_add_page_element_section('Social', 'left');
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_add_element_section_social');
	
/* ---------------------------------------------------------------------------- */
/* Style Section
/* ---------------------------------------------------------------------------- */

	function plchf_add_element_section_style() {
		
		plchf_msb_add_page_element_section('Style', 'left');
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_add_element_section_style');
	
/* ---------------------------------------------------------------------------- */
/* Add Delete Site Item to the Menu
/* ---------------------------------------------------------------------------- */
	
	function plchf_msb_edit_page_menu_edit_pages_menu_items() {
		
		$site_id = plchf_msb_get_site_id();									
									
		echo '<li class="floatr">';
			
			echo '<a href="#" class="deletesite">';	
			
				echo '<span class="'.apply_filters('plchf_msb_edit_site_page_delete_menu_item_icon','delete_site').'"></span>';
				
				echo apply_filters('plchf_msb_edit_site_page_edit_pages_menu_item','Edit Pages');
				
			echo '</a>';
				
				$args = array(
					'post_type' 	=> 'pluginchiefmsb-sites',
					'post_parent' 	=> $site_id,
					'posts_per_page'=> '-1'
				);
					
				$posts = get_posts( $args );
					
				if ($posts) {
				
				echo '<ul>';
					
					foreach ($posts as $post) {
				
						echo '<li>';
						
							echo '<a href="'.apply_filters( 'plchf_msb_edit_page_page', get_bloginfo('url') . '/wp-admin/admin.php' ).'?page=pluginchiefmsb/edit-page&mobilesite_page_id='.$post->ID.'">';
								
								echo $post->post_title; 
								
							echo'</a>';
							
						echo '</li>';
						
					}
					
				echo '</ul>';
				
				}
			
		echo '</li>';
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_msb_edit_page_menu_edit_pages_menu_items');
	
/* ---------------------------------------------------------------------------- */
/* Delete Page Link
/* ---------------------------------------------------------------------------- */

	function plchf_add_element_section_delete_page() {
		
		plchf_msb_add_page_element_section('Delete Page', 'right');
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_add_element_section_delete_page');
	
/* ---------------------------------------------------------------------------- */
/* Site Settings Link
/* ---------------------------------------------------------------------------- */

	function plchf_add_element_section_site_settings() {
		
		plchf_msb_add_page_element_section('Site Settings', 'right');
		
	}
	
	add_action('plchf_msb_page_element_sections','plchf_add_element_section_site_settings');