

(function($) {

	var posts = document.querySelectorAll('.initiative-posts .g-grid');
	var ids = ['volunteering', 'rcementoring'];

   [].forEach.call(posts, function(post, index) {
   	 post.setAttribute('id', ids[index]);
   });

	var toggleContent = function(e) {
		e.preventDefault();
		var $this = $(this),
			curr = $this.attr('href'),
			panels = $(curr).siblings(),
			active = $this.parent(),
			links = $(active).siblings();
		$(panels).removeClass('show');
		$(curr).addClass('show');
		$(links).removeClass('active');
		$(active).addClass('active');
	};

	$('.initiatives-section .g-menu-item').on('click', 'a', toggleContent);
	$('.initiatives-section .g-menu-item:first a').trigger('click');


	$('.account-section .nav li:first a').trigger('click');


	setTimeout(function() {

	$('.shop-section .grid-stack-item').each(function(idx, value) {
		if ( $(value).height() < 170 ) {
			$(value).addClass('small');
		}
	});
	}, 1000);

	$('.g-toplevel .menu-item-has-children > .g-menu-item-container').attr('onclick', "sessionStorage.setItem('filterText', 'All')");

	var filterLink = $('.g-sublevel .g-menu-item-container');

	$(filterLink).each(function(idx, value) {
		$(value).attr('onclick', "sessionStorage.setItem('filterText', '" + $(this).find('.g-menu-item-title').text() + "')");
	});


	var curr_text = sessionStorage.getItem('filterText');

	$('.woocommerce-products-header .grid-category a').each(function(id, val) {
		 var text = $.trim($(this).text());
		if( text === curr_text) {
			setTimeout(function() {
				$(val).click();
			}, 2000)
		}
	})


  $('.ladda-button').attr('data-spinner-color', '#fff');


	$('.single-post .entry-header').insertAfter('.tagline h1');


	$('#login, #register').on('click', function(e) {
		e.preventDefault();
		$(this).closest('form').parent().fadeOut();
		$(this).closest('form').parent().siblings('div').fadeIn();
	})

	$('#register').trigger('click');


})(jQuery);


