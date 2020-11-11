<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package simone
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
	<?php get_sidebar( 'footer' ); ?>
		<div class="site-info">
			<?php do_action( 'simone_credits' ); ?>
			<?php
			printf(
				/* translators: %s = text link: WordPress, URL: http://wordpress.org/ */
				__( 'Proudly powered by %s', 'simone' ),
				'<a href="http://wordpress.org/" rel="generator">' . esc_html__( 'WordPress', 'simone' ) . '</a>'
			);
			?>
			<span class="sep"> | </span>
			<?php
			printf(
				/* translators: %s = text link: mor10.com, URL: http://mor10.com/ */
				__( 'Theme: Simone by %s', 'simone' ),
				'<a href="https://themesbycarolina.com" rel="designer nofollow">' . esc_html__( 'Carolina', 'simone' ) . '</a>'
			);
			?>
		</div><!-- .site-info -->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

<script>
	
/*	 By jQuery
var $grid= $('.grid').isotope({
  // options
  itemSelector: '.grid-item',
  layoutMode: 'fitRows',
  getSortData:{
    name: '.title'}
});
	$('.filter-button-group').on( 'click', 'button', function() {
  var filterValue = $(this).attr('data-filter');
  $grid.isotope({ filter: filterValue });
});

 //for sorting
  $('.sort-by-button-group').on( 'click', 'button', function() {
  var sortByValue = $(this).attr('data-sort-by');
  $grid.isotope({ sortBy: sortByValue });
});
*/
</script>
<script>
	// By Javascript
	var iso= new Isotope('.grid',{
		itemSelector:'.grid-item',
		layoutMode:'fitRows',
		getSortData:{
    name: '.title'}
	});
	// bind filter button click
	var filtersElem = document.querySelector('.filter-button-group');
	if(filtersElem!=null){
		filtersElem.addEventListener('click', function (event){
		//only work with button
		if(!matchesSelector(event.target, 'button') ){
			return;
		}
		var filterValue = event.target.getAttribute('data-filter');
		//use matching filter function
		iso.arrange({filter:filterValue });
		});	
	

}
if(filtersElem!=null){
	var filtersElem = document.querySelector('.filter-buttons-group');
		filtersElem.addEventListener('click', function (event){
			//only work with button
			if(!matchesSelector(event.target, 'button') ){
				return;
			}
			var filterValue = event.target.getAttribute('data-filter');
			//use matching filter function
			iso.arrange({filter:filterValue });
		});
		
}
//    Sorting Function
//
// bind sort button click
var sortByGroup = document.querySelector('.sort-by-button-group');
if(sortByGroup!= null){

	sortByGroup.addEventListener( 'click', function( event ) { 
	  // only button clicks
	  if ( !matchesSelector( event.target, '.button' ) ) {
	  	console.log(23);
	    return;
	  }
	  var sortValue = event.target.getAttribute('data-sort-by');
	  iso.arrange({ sortBy: sortValue });
	});
}
// change is-checked class on buttons
var buttonGroups = document.querySelectorAll('.button-group');
for ( var i=0; i < buttonGroups.length; i++ ) {
  buttonGroups[i].addEventListener( 'click', onButtonGroupClick );
}
function onButtonGroupClick( event ) {
  // only button clicks
  if ( !matchesSelector( event.target, '.button' ) ) {
    return;
  }
  var button = event.target;
  button.parentNode.querySelector('.is-checked').classList.remove('is-checked');
  button.classList.add('is-checked');
}

let filterInput=document.getElementById("filterInput");
filterInput.addEventListener('keyup',filterTitles);
function filterTitles(){
	let filterValue=document.getElementById('filterInput').value.toUpperCase();
	//console.log(filterValue);
	let gridbox=document.getElementById('gridbox');
	let atag=gridbox.querySelectorAll("a");
	//loop through collection -items 
	for(var i=0;i<atag.length;i++){
		let title=atag[i].getElementsByTagName('h5')[0];
		//console.log(val.innerHTML);
		if(title.innerHTML.toUpperCase().indexOf(filterValue) > -1){
			console.log(1);
			iso.arrange({filter:filterValue });
		}
		else{
			console.log(0);
		}
	}

}

</script>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
