function refreshDashboardHomePage(){
	if( jQuery("#check-list").length > 0 ){
		jQuery("#add_another_site_close_btn").trigger('click');
		show_dashboard_mask();
		jQuery.ajax({
			type : 'post',
			dataType : 'html',
			url : jQuery('#checksiterefresh').attr('action'),
			data : jQuery("#checksiterefresh").serialize(),
			success : function( res ){
				hidden_dashboard_mask();
				
				jQuery("#check-list").html( res );
				check_list_action_list();
			}
		});
	}
}

jQuery(document).ready(function(){
	jQuery(".add-another-site-btn-section").click(function(){
		jQuery(".open_inner_page", this).trigger('click');
	});
	
	jQuery("#add_site_btn").click(function(){
		jQuery("#add_site_info_duplicate").addClass("hide");
		
		jQuery(".add_url_parameter_input_section input[type=text]").removeClass("add_site_info_err");
		jQuery(".add_notification_input_section input[type=text]").removeClass("add_site_info_err");
		jQuery(".add_url_parameter_error_section > div").addClass("hide");
		jQuery(".add_notification_error_section > div").addClass("hide");
		
		jQuery(".user-account-email-list").html( jQuery("#user-account-email-list-escape").html() );
		
		jQuery(".remove_check_alert_email").click(function(){
			jQuery(this).parent().remove();
		});
		
		jQuery("#manual_http_alert_list").html('');
		jQuery("#manual_https_alert_list").html('');
		jQuery("#manual_dns_alert_list").html('');
		jQuery("#auto_alert_list").html('');
	});
	
	jQuery(".manual-page-list-items li").click(function(){
		jQuery(".manual-page-list-items li").removeClass("select-page");
		jQuery(this).addClass("select-page");
		
		jQuery('.parameter_section').addClass("hide");
		jQuery('#' + jQuery(this).attr('parameterfield')).removeClass("hide");
		
		return false;
	});
		
	jQuery("#manual_setting_form_dns [name=dns_ip]").ipAddress();
	
	jQuery('#save_site_auto_mode_button').on('click',function(){
		jQuery('#add_site_auto_message_container div[data-type]').remove();
		var input = jQuery('input#site_auto_mode_url');
		var url = input.val();
		var wait_icon = jQuery(this).find('img');
		var validate_required = jQuery('#add_site_auto_mode_required');
		if(url==''){
			input.addClass('add_site_info_err');
			validate_required.removeClass('hide');
		}else{
			validate_required.addClass('hide');
			input.removeClass('add_site_info_err');
			wait_icon.removeClass('hide');
			jQuery.ajax({
				url:input.data('action'),
				type: 'POST',
				data:{url:url}
			}).done(function(data){
				if(data.status == 'OK'){
					var message_container = jQuery('#add_site_auto_message_container');
					for (obj in data.data) {
						message_container.append('<div data-type="'+obj+'" class="alert alert-'+data.data[obj].type+'">'+data.data[obj].message+'</div>');
					};
					
					refreshDashboardHomePage();
				}

				wait_icon.addClass('hide');
			});
		}
		return true;
	});
	
	jQuery("#manual_setting_form_http").submit(function(){
		var urlregex = new RegExp("^http\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
		
		if( urlregex.test( jQuery('#manual_setting_form_http [name=http_url]').val() ) ){	
			jQuery("#manual_http_url").addClass('hide');
			jQuery('#manual_setting_form_http [name=http_url]').removeClass('add_site_info_err');
		} else {
			jQuery('#manual_setting_form_http [name=http_url]').addClass('add_site_info_err');
			
			jQuery("#manual_http_url").removeClass('hide');
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#manual_add_insert_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#manual_setting_form_http').attr('action'),
			data : jQuery("#manual_setting_form_http").serialize(),
			success : function( res ){
				jQuery("#manual_add_insert_progress").addClass("hide");
				if( res.err == 0 ){
					jQuery("#add_site_info_success").removeClass("hide");
					
					refreshDashboardHomePage();
					
					jQuery("#manual_setting_form_http input[type=text]").val('');
				} else if( res.err > 0 ){
					jQuery("#add_site_info_duplicate").removeClass("hide");
				}				
			}
		});
		
		return false;
	});
	
	jQuery("#auto_setting_form").submit(function(){
		var urlregex = new RegExp("^(http|https)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
		
		if( urlregex.test( jQuery('#site_auto_mode_url').val() ) ){	
			jQuery("#auto_url_error").addClass('hide');
			jQuery('#site_auto_mode_url').removeClass('add_site_info_err');
		} else {
			jQuery('#site_auto_mode_url').addClass('add_site_info_err');
			
			jQuery("#auto_url_error").removeClass('hide');
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#auto_add_insert_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#auto_setting_form').attr('action'),
			data : jQuery("#auto_setting_form").serialize(),
			success : function( res ){
				jQuery("#auto_add_insert_progress").addClass("hide");
				
				if( res.status == 'OK' ){					
					refreshDashboardHomePage();
					
					jQuery("#site_auto_mode_url").val('');
				} else if( res.err > 0 ){
					jQuery("#add_auto_site_info_duplicate").removeClass("hide");
				}				
			}
		});
		
		return false;
	});
	
	jQuery("#manual_setting_form_https").submit(function(){
		var urlregex = new RegExp("^https\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
		
		if( urlregex.test( jQuery('#manual_setting_form_https [name=https_url]').val() ) ){
			jQuery('#manual_https_url').addClass('hide');
			jQuery('#manual_setting_form_https [name=https_url]').removeClass('add_site_info_err');
		} else {
			jQuery('#manual_setting_form_https [name=https_url]').addClass('add_site_info_err');
			jQuery('#manual_https_url').removeClass('hide');
						
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#manual_add_insert_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#manual_setting_form_https').attr('action'),
			data : jQuery("#manual_setting_form_https").serialize(),
			success : function( res ){
				jQuery("#manual_add_insert_progress").addClass("hide");
				
				if( res.err == 0 ){
					jQuery("#add_site_info_success").removeClass("hide");
					
					refreshDashboardHomePage();
					
					jQuery("#manual_setting_form_https input[type=text]").val('');
				} else if( res.err > 0 ){
					jQuery("#add_site_info_duplicate").removeClass("hide");
				}
			}
		});
		
		return false;
	});
	
	jQuery("#manual_setting_form_dns").submit(function(){
		var urlregex = new RegExp("^(?!:\/\/)([a-zA-Z0-9]+\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[a-zA-Z]{2,6}?$");
		
		if( urlregex.test( jQuery('#manual_setting_form_dns [name=dns_host_name]').val() ) ){
			jQuery('#manual_dns_url').addClass('hide');
			jQuery('#manual_setting_form_dns [name=dns_host_name]').removeClass('add_site_info_err');
		} else {
			jQuery('#manual_setting_form_dns [name=dns_host_name]').addClass('add_site_info_err');
			jQuery('#manual_dns_url').removeClass('hide');
						
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#manual_add_insert_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#manual_setting_form_dns').attr('action'),
			data : jQuery("#manual_setting_form_dns").serialize(),
			success : function( res ){
				jQuery("#manual_add_insert_progress").addClass("hide");
				
				if( res.err == 0 ){
					jQuery("#add_site_info_success").removeClass("hide");
					
					refreshDashboardHomePage();
					
					jQuery("#manual_setting_form_dns input[type=text]").val('');
				} else if( res.err > 0 ){
					jQuery("#add_site_info_duplicate").removeClass("hide");
				}
			}
		});
		
		return false;
	});
	
	jQuery("#manual_http_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#http_alert_email").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#manual_http_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#manual_http_alert_email_err").addClass("hide");
			jQuery("#http_alert_email").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#manual_http_alert_email_err").removeClass("hide");
			jQuery("#http_alert_email").addClass("add_site_info_err");
		}
	});
	
	jQuery("#manual_https_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#https_alert_email").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#manual_https_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#manual_https_alert_email_err").addClass("hide");
			jQuery("#https_alert_email").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#manual_https_alert_email_err").removeClass("hide");
			jQuery("#https_alert_email").addClass("add_site_info_err");
		}
	});
	
	jQuery("#manual_dns_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#dns_alert_email").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#manual_dns_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#manual_dns_alert_email_err").addClass("hide");
			jQuery("#dns_alert_email").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#manual_dns_alert_email_err").removeClass("hide");
			jQuery("#dns_alert_email").addClass("add_site_info_err");
		}
	});
	
	jQuery("#auto_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#auto_alert_email").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#auto_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#auto_alert_email_err").addClass("hide");
			jQuery("#auto_alert_email").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#auto_alert_email_err").removeClass("hide");
			jQuery("#auto_alert_email").addClass("add_site_info_err");
		}
	});
	
	jQuery(".remove_check_alert_email").click(function(){
		jQuery(this).parent().remove();
	});
});