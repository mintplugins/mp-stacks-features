jQuery(window).ready(function($) {
	
 	//Set height of items to be equal to width
	var div = jQuery('.mp-socialgrid-li');
	var width = div.width();
	div.css('height', width);
		
	//isotope
	$('.mp-socialgrid-container, .mp-socialgrid-ul').isotope({
		// options
		itemSelector : '.mp-socialgrid-li',
		layoutMode : 'masonry'
	});
	
	// filter items when filter link is clicked
	$('.mp-socialgrid-nav').change(function(){
		var selector = $(this).attr('value');
		$('.mp-socialgrid-container, .mp-socialgrid-ul').isotope({ filter: selector });
		return false;
	});
	
	// filter items when filter link is clicked
	$('.mp-socialgrid-nav a').click(function(){
		var selector = $(this).attr('mpvalue');
		$('.mp-socialgrid-container, .mp-socialgrid-ul').isotope({ filter: selector });
		return false;
	});

});

jQuery(window).resize(function($) {
	
	//Call function to make grid items and high as they are wide
 	mp_stacks_socialgrid_size_grid($)
	
});

//Function which makes items as high as they are wide
function mp_stacks_socialgrid_size_grid($){
	
	
	//Set height to be equal to width
	var div = jQuery('.mp-socialgrid-li');
	var width = div.width();
	div.css('height', width);
	
	
    jQuery('.mp-socialgrid-container, .mp-socialgrid-ul').isotope( 'reLayout' )
		
}