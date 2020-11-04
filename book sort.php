<?php
/*
 * Template Name: book-sort
 * description: >-
  Page template without sidebar
 */

get_header();?>

<h5> Sort BY</h5>
<div class="button-group sort-by-button-group">
  <button data-sort-by="original-order">Recency</button>
  <button data-sort-by="name">name</button>
  
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
        
   <?php  }
     
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