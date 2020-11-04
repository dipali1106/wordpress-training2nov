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

  
  //shortcode
add_shortcode('isotope',function($atts,$content=null){
  
  wp_enqueue_script('isotope-js','https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js',array(),true);
  echo wp_enqueue_style( 'style-css', get_template_directory_uri().'/css/style.css' );
  
  $query = new WP_Query(array(
    'post_type'=>'book',
    'posts_per_page'=>8
  ));
  
  if($query->have_posts()){
    $posts = [];
    $all_types=[];
    $all_authors = [];
    while($query->have_posts()){
      $query->the_post();
      global $post;
      $type = wp_get_object_terms($post->ID,'type');
      $author = wp_get_object_terms($post->ID,'author');
      if(!empty($type)){
        $post->cats=[];
        foreach($type as $cat){
                     $post->cats[]=$cat->slug;
          if(!in_array($cat->term_id,array_keys($all_types))){
            $all_types[$cat->term_id]=$cat;
          }
        }
      }
      if(!empty($author)){
        $post->auths=[];
        foreach($author as $auth){
          $post->auths[] = $auth->slug;
          if(!in_array($auth->term_id,array_keys($all_authors))){
            $all_authors[$auth->term_id]=$auth;
          }
        }
      }
      $posts[] = $post;
    }
    wp_reset_postdata();

    echo '<div class="isotope_wrapper"><div>';
    if(!empty($all_types)){
      ?>
      <ul class="post_categories">
      <?php
        foreach($all_types as $type){
          ?>
        <li class="grid-selector" data-filter="<?php echo $type->slug; ?>"><?php echo $type->name; ?></li>
             <?php
        }
      ?>
      </ul>
      <?php
    }
    if(!empty($all_authors)){
      ?>
      <ul class="post_tags">
      <?php
        foreach($all_authors as $type){
          ?>
        <li class="grid-subselector" data-filter="<?php echo $type->slug; ?>"><?php echo $type->name; ?></li>
             <?php
        }
      ?>
      </ul>
      <?php
    }
    ?>
    </div>
    <div class="grid">
    <?php
    foreach($posts as $post){
      
      ?>
      <div class="grid-item <?php echo empty($post->cats)?'':implode(',',$post->cats); ?> <?php echo empty($post->auths)?'':implode(',',$post->auths); ?>">
        
        <h5>
          <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
        </h5>
      </div>
      <?php
    }

    ?>
    </div></div>
    <script>
      window.addEventListener('load',function(){


        var iso = new Isotope( document.querySelector('.grid'), {
          itemSelector: '.grid-item',
          layoutMode: 'fitRows'
        });

        
        document.querySelectorAll('.grid-selector').forEach(function(el){

          el.addEventListener('click',function(){
            
            let sfilter = el.getAttribute('data-filter');

            iso.arrange({
              filter: function( gridIndex, itemElem ) {
                return itemElem.classList.contains(sfilter);
              }
            });
            
          });
        });


        document.querySelectorAll('.grid-subselector').forEach(function(el){

          el.addEventListener('click',function(){
            
            let sfilter = el.getAttribute('data-filter');

            iso.arrange({
              filter: function( gridIndex, itemElem ) {
                return itemElem.classList.contains(sfilter);
              }
            });
            
          });
        });
        
      });


    </script>
       <style>
      .isotope_wrapper {
          display: flex;
          flex-direction: column;
      }

      .isotope_wrapper > div {
          display: flex;
          flex-direction: row;
          flex-wrap: wrap;
          margin: 0 -1rem;
          justify-content: space-between;
      }

      .isotope_wrapper > div > ul {
          display: flex;
          flex-wrap: wrap;
          margin: 1rem;
          list-style: none;
      }

      .isotope_wrapper > div>div {
          padding: 1rem;
          border: 1px solid #eee;
          margin: 1rem;
      }

      .isotope_wrapper > div > ul > li {
          padding: 0.5rem 1rem;
          background: #eee;
          margin: 2px;cursor:pointer;
          border-radius: 4px;

      }
      a {
    color: #8b3c51;
    text-decoration: none;
}
.entry-content a {
    text-decoration: none;
}

    </style>
 
    <?php
  }
});

?>