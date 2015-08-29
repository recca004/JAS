jQuery(document).ready(function() {
    jQuery('.fg_group').hide();
	jQuery('.fg_group:first').fadeIn();
	jQuery('#fg_of-nav li:first').addClass('current');
	jQuery('#fg_of-nav li a').click(function(evt){
		jQuery('#fg_of-nav li').removeClass('current');
		jQuery(this).parent().addClass('current');
		if(jQuery(this).attr("title")=="Embed Code"){
			jQuery(".fg_embed_code_save").css("display", "block");
			jQuery(".fg_embed_code_save").css("float", "left");
			jQuery(".fg_embed_code_save").css("width", "120px");
			jQuery(".fg_embed_code_save").css("height", "40px");
		}
		else{
			jQuery(".fg_embed_code_save").css("display", "none");
		}
			var clicked_group = jQuery(this).attr('href');
			jQuery('.fg_group').hide();
			jQuery(clicked_group).fadeIn();
			evt.preventDefault();
		});
    jQuery('.fg_embed_code_save').click(function() {
		jQuery('div#loader_img').css("display","block");
		var text_value = jQuery('textarea#fg_content_html').val();
		var data = {
            action: 'master_response',
            value: text_value
        };
        jQuery.post(script_call.ajaxurl, data, function(response) {
            if (response) {
                jQuery('div#loader_img').css("display", "none");
                }
            else {
                
				jQuery('div#loader_img').css("display", "none");
            }
        });
    });
});