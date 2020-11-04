<?php
/*
 * Template Name: book
 * description: >-
  Page template without sidebar
 */

get_header();?>

<div>
	<input type="text" class="filterInput" placeholder="Search">
</div>
<h5> FILTER BY TYPE</h5>

<div class="button-group filter-button-group">
  <button class="button " data-filter="*">show all</button>
<?php 
$terms = get_terms( array( 
   	'taxonomy' => 'type',
   	'hide_empty' => false) ); 
 
        foreach ( $terms as $term ) {?>
        	<button data-filter=".<?php echo $term->slug; ?>" ><?php echo $term->name; ?></button>
        <?php }
    ?>   	
</div>
<!-- Button for author -->
<h5> FILTER BY AUTHOR</h5>
<div class="button-group filter-button-group">
  <button class="button " data-filter="*">show all</button>
<?php  
   $terms = get_terms( array( 
   	'taxonomy' => 'author',
   	'hide_empty' => false) ); 
        foreach ( $terms as $term ) {?>
        	<button data-filter=".<?php echo $term->slug; ?>" ><?php echo $term->name; ?></button>
        <?php }
    ?>   	
  
  <!--<button data-filter=".adventure">Adventure</button> -->
</div>

<div id="gridbox" class="grid">
<?php  $args=array(
  		'post_type'=> 'book');
  	$query=new WP_Query($args);

// The Loop
if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();?>

        <a class="grid-item
        <?php isotope_classes(get_the_id()); ?>"
        href="<?php the_permalink(); ?>">
        	<div class="card" >
        	<img class="img-fluid" src="<?php the_field('image'); ?>" alt="book1"></div>
         <h5 class="title"><?php the_title() ;?></h5>
        <?php the_field('author'); ?></a>
        
   <?php
      }
      global $wp_query; // you can remove this line if everything works for you
 
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 )
  echo '<div class="misha_loadmore">More posts</div>'; // you can use <a> as well


     
} else {
    // no posts found
    echo "No products";
}?>
</div>
<?php
/* Restore original Post Data */
wp_reset_postdata();
 
?>
<?php get_footer(); ?>