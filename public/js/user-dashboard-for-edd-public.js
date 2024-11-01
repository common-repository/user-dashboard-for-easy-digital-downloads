jQuery(document).ready(function($) {
	$(".menu-open-icon").on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$(this).css('display', 'none');
		$(".menu-close-icon").css('display', 'block');
		$(".ud-sidenav-fixed").css({
			'visibility': 'visible',
			'opacity': '1',
		});
	});

	$(".menu-close-icon").on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$(this).css('display', 'none');
		$(".menu-open-icon").css('display', 'block');
		$(".ud-sidenav-fixed").css({
			'visibility': 'invisible',
			'opacity': '0',
		});
	});
});