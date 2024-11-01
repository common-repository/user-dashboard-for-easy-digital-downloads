

jQuery(document).ready(function($) {
	var custom_uploader;

	$('#ud_for_edd_upload_logo_button').click(function(e) {
		e.preventDefault();
		//If the uploader object has already been created, reopen the dialog
	if (custom_uploader) {
		custom_uploader.open();
		return;
	}
	
	//Extend the wp.media object
	custom_uploader = wp.media.frames.file_frame = wp.media({
		title: 'Choose Image',
		button: {
			text: 'Choose Image'
	},
		multiple: false
	});
	
	//When a file is selected, grab the URL and set it as the text field's value
	custom_uploader.on('select', function() {
		attachment = custom_uploader.state().get('selection').first().toJSON();
		$('#upload_image').val(attachment.url);
		$(".ud-for-edd-preview-logo").html("<span>Preview: </span><img src='" + attachment.url + "'>");
	});
		//Open the uploader dialog
		custom_uploader.open();
	});

	const newLocal = ".ud_reset_submit";
	$(newLocal).on('click', function(){
		const confirmBox = confirm("Are you sure to reset all settings.");
		const ajaxMessage = $(".ud-ajax-message");

		if ( confirmBox == true ) {
			$.ajax({
				type: "POST",
				url: udAjax.url,
				data: {
					'action' 		: 'ud_reset_settings',
					'ud_nonce_reset': $('#ud_nonce_reset').val(),
					'reset_settings': 'true',
				},
				dataType: "json",
				beforeSend : function () {
					$(ajaxMessage).html("<p>Please wait...</p>");
				},
				success: function ( response ) {
					if ( response.resetStatus == 'true' ) {
						$(ajaxMessage).html('<p>Reset sucessfull.</p>');
					} else {
						$(ajaxMessage).html('<p>Problem while reseting. Please try again.</p>');
						console.log(response);
					}
				},
				fail: function ( response ) {
					$(ajaxMessage).html('<p>Failed, please contact plugin author for support.</p>');
				},
			});
		} else {
			$(ajaxMessage).html('<p>Oops! You clicked cancel.</p>');
		}
	});
});

