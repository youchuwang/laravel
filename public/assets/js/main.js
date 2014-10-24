function removeBroswerSpace(){
	$broswer_height = jQuery(window).outerHeight();
	$main_header_height = jQuery("#main-header-hav").outerHeight();
	$page_content_footer = jQuery("#footer-page-container").outerHeight();
	
	jQuery("#main-page-container").css("min-height", ($broswer_height - $main_header_height - $page_content_footer) + "px");
}

function show_dashboard_mask(){
	var height = jQuery("#dashboard").outerHeight();
	jQuery("#dashboard-section-mask").css("height", height + "px").removeClass('hide');
}

function hidden_dashboard_mask(){
	jQuery("#dashboard-section-mask").addClass('hide');
}

jQuery(document).ready(function(){
	removeBroswerSpace();
	
	jQuery(window).resize(function(){
		removeBroswerSpace();
	});
	
	jQuery(".close_inner_page").click(function(){
		jQuery(".inner_page_dlg").addClass('hide');
		
		$main_id = jQuery(this).attr("main_id");
		$modal_id = jQuery(this).attr("modal_id");
		
		jQuery('#' + $modal_id).addClass("hide");
		jQuery('#' + $main_id).removeClass("hide");
	});
	
	jQuery(".open_inner_page").click(function(){
		jQuery(".inner_page_dlg").addClass('hide');
		
		$main_id = jQuery(this).attr("main_id");
		$modal_id = jQuery(this).attr("modal_id");
		
		jQuery('#' + $modal_id).removeClass("hide");
		jQuery('#' + $main_id).addClass("hide");
	});
	
	jQuery("#contacts-support").submit(function(){
		jQuery("#waiticon").removeClass("hide");

		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#contacts-support').attr('action'),
			data : {
				"_token" : jQuery('input[name=_token]', jQuery('#contacts-support')).val(),
				"name" : jQuery('input[name=name]', jQuery('#contacts-support')).val(),
				"email" : jQuery('input[name=email]', jQuery('#contacts-support')).val(),
				"category" : jQuery('input[name=category]', jQuery('#contacts-support')).val(),
				"message" : jQuery('textarea[name=message]', jQuery('#contacts-support')).val()
			},
			success : function( res ){
				jQuery("#waiticon").addClass("hide");
				
				if( res['err'] == 0 ){
					jQuery(".inner_page_dlg").addClass('hide');
					jQuery("#contact-support-success").removeClass('hide');
				} else {
					alert(res['msg']);
				}
				
				
				jQuery('input[name=_token]', jQuery('#contacts-support')).val('');
				jQuery('input[name=name]', jQuery('#contacts-support')).val('');
				jQuery('input[name=email]', jQuery('#contacts-support')).val('');
				jQuery('input[name=category]', jQuery('#contacts-support')).val('');
				jQuery('textarea[name=message]', jQuery('#contacts-support')).val('');
			}
		});
		
		return false;
	});
	
	jQuery("#contacts-support-page").submit(function(){
		jQuery("#waiticon").removeClass("hide");

		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#contacts-support-page').attr('action'),
			data : {
				"_token" : jQuery('input[name=_token]', jQuery('#contacts-support-page')).val(),
				"name" : jQuery('input[name=name]', jQuery('#contacts-support-page')).val(),
				"email" : jQuery('input[name=email]', jQuery('#contacts-support-page')).val(),
				"category" : jQuery('input[name=category]', jQuery('#contacts-support-page')).val(),
				"message" : jQuery('textarea[name=message]', jQuery('#contacts-support-page')).val()
			},
			success : function( res ){
				jQuery("#waiticon").addClass("hide");
				
				if( res['err'] == 0 ){
					jQuery("#contact-support-page-info").removeClass('hide');
				} else {
					alert(res['msg']);
				}
				
				
				jQuery('input[name=_token]', jQuery('#contacts-support-page')).val('');
				jQuery('input[name=name]', jQuery('#contacts-support-page')).val('');
				jQuery('input[name=email]', jQuery('#contacts-support-page')).val('');
				jQuery('input[name=category]', jQuery('#contacts-support-page')).val('');
				jQuery('textarea[name=message]', jQuery('#contacts-support-page')).val('');
			}
		});
		
		return false;
	});
});