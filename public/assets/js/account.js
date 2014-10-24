jQuery(document).ready(function(){
	jQuery("#accountupdate-personal").submit(function(){
		$error = false;
		
		$email = jQuery("#email").val();
		
		var urlregex = new RegExp("^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$");
		
		if( !urlregex.test( $email ) ){	
			jQuery("#email_error").removeClass('hide');
			jQuery("#email").addClass('add_site_info_err');
			
			$error = true;
		} else {
			jQuery("#email_error").addClass('hide');
			jQuery("#email").removeClass('add_site_info_err');
			
			$error = false;
		}
		
		if( $error )
			return false;
	});
	
	jQuery("#accountupdate-password").submit(function(){
		$error = false;
		
		$currentpassword = jQuery('#currentpassword').val();
		$newpassword = jQuery('#newpassword').val();
		$confirmpassword = jQuery('#confirmpassword').val();
		
		if( $currentpassword == '' ){
			jQuery("#currentpassword_error").removeClass('hide');
			jQuery("#currentpassword").addClass('add_site_info_err');
			
			$error = true;
		} else {
			jQuery("#currentpassword_error").addClass('hide');
			jQuery("#currentpassword").removeClass('add_site_info_err');
			
			$error = false;
		}
		
		if( $newpassword == '' ){
			jQuery("#newpassword_error").removeClass('hide');
			jQuery("#newpassword").addClass('add_site_info_err');
			
			$error = true;
		} else {
			jQuery("#newpassword_error").addClass('hide');
			jQuery("#newpassword").removeClass('add_site_info_err');
			
			$error = false;
		}
		
		if( $confirmpassword == '' || $newpassword != $confirmpassword ){
			jQuery("#confirmpassword_error").removeClass('hide');
			jQuery("#confirmpassword").addClass('add_site_info_err');
			
			$error = true;
		} else {
			jQuery("#confirmpassword_error").addClass('hide');
			jQuery("#confirmpassword").removeClass('add_site_info_err');
			
			$error = false;
		}
		
		if( $error )
			return false;
	});
	
	jQuery(".deletealertemail").click(function(){
		$del_id = jQuery(this).attr('index');
		jQuery("#delid").val( $del_id );
		
		jQuery("#accountalertemaildelete").submit();
	});
	
	jQuery(".confirm_alert_email").click(function(){
		var confirm_id = jQuery(this).data("id");
		jQuery("#confirm_id").val( confirm_id );
		
		show_dashboard_mask();
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#sendconfirmaccountalertemail').attr('action'),
			data : jQuery("#sendconfirmaccountalertemail").serialize(),
			success : function( res ){				
				hidden_dashboard_mask();
				
				jQuery("#confirm_alert_email_success").removeClass("hide");
			}
		});
	});
});