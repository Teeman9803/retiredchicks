(function ($) {
	$(document).ready(function () {
		// If enabled Floating mode display Post Type selection and positioning
		$('#enable_floating_mode').on('change', function () {
			$('.wc_ss_btns-float-post-types, .wc_ss_btns-float-positions').fadeToggle();
		})
	});
})(window.jQuery,document)