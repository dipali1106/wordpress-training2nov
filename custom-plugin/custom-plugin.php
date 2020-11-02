<?php
   /*
   Plugin Name: custom-plugin
   Plugin URI: http://test-plugin.com
   description: >-
  a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: dipali
   Author URI: http://mrtotallyawesome.com
   License: GPL2
   */
if(! defined('ABSPATH') ) exit;

   // Our custom post type function Book

   function book_init() {
$labels = array(
'name' => esc_html__('Books', 'themedomain' ),
'singular_name' => esc_html__('Book ',
'themedomain' ),
'add_new' => esc_html__('Add New Book', 'themedomain'
),
'add_new_item' => esc_html__('Add New Book',
'themedomain' ),
'edit_item' => esc_html__('Edit Book',
'themedomain' ),
'new_item' => esc_html__('Add New Book',
'themedomain' ),
'view_item' => esc_html__('View Book', 'themedomain' ),
'search_items' => esc_html__('Search Book',
'themedomain' ),
'not_found' => esc_html__('No Books found',
'themedomain' ),
'not_found_in_trash' => esc_html__('No Books
found in trash', 'themedomain' )
);
$args = array(
'labels' => $labels,
'public' => true,
'show_ui' => true,
'menu_icon' => 'dashicons-paperclip',
'show_in_menu'=>true,
'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions'
),

'hierarchical' => false,
'rewrite' => array( 'slug' => sanitize_title(
'Book' ), 'with_front' => false ),
'menu_position' => 5,
'has_archive' => true
);
register_post_type( 'book', $args );
}
add_action( 'init', 'book_init' );


//hook into the init action and call create_Types_nonhierarchical_taxonomy when it fires

add_action( 'init', 'create_categories_taxonomy', 0 );
 
function create_categories_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Types', 'taxonomy general name' ),
    'singular_name' => _x( 'Type', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Types' ),
    'popular_items' => __( 'Popular Types' ),
    'all_items' => __( 'All Types' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Type' ), 
    'update_item' => __( 'Update Type' ),
    'add_new_item' => __( 'Add New Type' ),
    'new_item_name' => __( 'New Type Name' ),
    'separate_items_with_commas' => __( 'Separate Types with commas' ),
    'add_or_remove_items' => __( 'Add or remove Types' ),
    'choose_from_most_used' => __( 'Choose from the most used Types' ),
    'menu_name' => __( 'Types' ),
  ); 
 
// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('type','book',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'Type' ),
  ));
}

//author taxonomy
 
add_action( 'init', 'create_author_taxonomy', 0 );
 
function create_author_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Authors', 'taxonomy general name' ),
    'singular_name' => _x( 'Author', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Authors' ),
    'popular_items' => __( 'Popular Authors' ),
    'all_items' => __( 'All Authors' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Author' ), 
    'update_item' => __( 'Update Author' ),
    'add_new_item' => __( 'Add New Author' ),
    'new_item_name' => __( 'New Topic Author' ),
    'separate_items_with_commas' => __( 'Separate authors with commas' ),
    'add_or_remove_items' => __( 'Add or remove authors' ),
    'choose_from_most_used' => __( 'Choose from the most used authors' ),
    'menu_name' => __( 'Authors' ),
  ); 
 
// Now register the non-hierarchical taxonomy author
 
  register_taxonomy('author','book',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'author' ),
  ));
}

  

?>