jQuery(function($) {
	$('.mod_jshopping_catprod .category .category-title').on('click', function(e) {
		e.preventDefault();
		$(this).siblings('.category-content').slideToggle('slow');
		$('.mod_jshopping_catprod .category .category-title').not(this).siblings('.category-content').slideUp('slow');
		$('.mod_jshopping_catprod .subcategory .subcategory-title').not(this).siblings('.subcategory-content').slideUp('slow');
	});
	
	$('.mod_jshopping_catprod .subcategory .subcategory-title').on('click', function(e) {
		e.preventDefault();
		$(this).siblings('.subcategory-content').slideToggle('slow');
		$(this).parent('.subcategory').siblings('.subcategory').find('.subcategory-title').not(this).siblings('.subcategory-content').slideUp('slow');
	});
});