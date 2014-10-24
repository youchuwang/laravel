function show_dashboard_graph_mask(){
	var garph_section_height = jQuery("#graph-section-bar").outerHeight();
	jQuery("#graph_drawing_progress").css("height", garph_section_height).removeClass("hide");
}

function hidden_dashboard_graph_mask(){
	jQuery("#graph_drawing_progress").addClass("hide");
	jQuery("#dashboard-graph-page-content").removeClass("hide");
}

function getMonday( date ) {
    var day = date.getDay() || 7;  
    if( day !== 1 ) 
        date.setHours(-24 * (day - 1));
		
	var y = date.getFullYear(),
		m = date.getMonth(),
		d = date.getDate();
		
	date = new Date(y, m, d, 0, 0, 0, 0);
    return date;
}

function getJustDayTimeStamp( date ){
	var y = date.getFullYear(),
		m = date.getMonth(),
		d = date.getDate();
		
	date = new Date(y, m, d, 0, 0, 0, 0);
    return date;
}

function changeTimeValue( val ){
	val = Math.round( val );
	var mil_sec = 0, sec = 0, min = 0, hrs = 0;
	
	mil_sec = val % 1000;
	sec = Math.floor( val / 1000 );
	min = Math.floor( sec / 60 );
	sec = sec % 60;
	hrs = Math.floor( min / 60 );
	min = min % 60;
	
	if( hrs > 0 ){
		val = hrs + "Hr";
	}else if( min > 0 ){
		val = min + "Min";
	}else if( sec > 0 ){
		val = sec;
		
		if( mil_sec > 0 ){
			val = Math.round( (val + (mil_sec / 100)) * 100 ) / 100;
		}
				
		val = val + "s";
	} else if( mil_sec > 0 ){
		val = Math.round( (mil_sec / 100) * 100 ) / 100 + "s";
	}
	
	return val;
}

function changeTimeValueBySec( val ){
	val = Math.round( val );
	var sec = 0, min = 0, hrs = 0;
	
	min = Math.floor( val / 60 );
	sec = val % 60;
	hrs = Math.floor( min / 60 );
	min = min % 60;
	
	if( hrs > 0 ){
		val = hrs + "Hr";
	}else if( min > 0 ){
		val = min + "Min";
	}else if( sec > 0 ){
		val = sec + "s";
	}
	
	return val;
}

function getTimeStrampToStr( val ){
	var monthNameList = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
	var dayNameList = [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ];
	
	var date	= new Date(val),
		v_year	= date.getFullYear(),
		v_month	= monthNameList[ date.getMonth() ],
		v_date	= date.getDate(),
		v_day	= dayNameList[ date.getDay() ];
	
	var return_val = '';
	return_val = v_day + ", " + v_month + " " + v_date + ", " + v_year;
	
	return return_val;
}

function getTimeStrampToStrSummary( val ){
	var monthNameList = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
	
	var date	= new Date(val),
		v_year	= date.getFullYear(),
		v_month	= monthNameList[ date.getMonth() ],
		// v_date	= date.getDate() + 'th',
		v_date	= date.getDate(); 
	
	var return_val = '';
	// return_val = v_month + " " + v_date + " ," + v_year;
	return_val = v_date;
	
	return return_val;
}

function getTimeStrampToStrHour( val ){
	var monthNameList = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
	var dayNameList = [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];
	
	var date	= new Date(val),
		v_year	= date.getFullYear(),
		v_month	= monthNameList[ date.getMonth() ],
		v_date	= date.getDate() + 'th',
		v_day	= dayNameList[ date.getDay() ];
		v_day	= date.getDay(),
		hour    = date.getHours(),
		minute  = date.getMinutes(),
		seconds = date.getSeconds();  
	
	var return_val = '';
	return_val = v_day + " " + v_month + " " + v_date + " ," + v_year + " " + hour + ":" + minute + ":" + seconds;
	
	return return_val;
}

function getRound3( val ){
	return Math.round( val * 1000 ) / 1000;
}

function getRound4( val ){
	if( val > 99 ){
		return Math.round( val * 10 ) / 10;
	}
	
	return Math.floor( val );
}

function check_list_see_more(){
	jQuery(".graph-page-list-items a").click(function(){		
		$report_mongo_id = jQuery(this).attr("mongoid");
		$report_check_id = jQuery(this).attr("checkid");
		$check_type = jQuery(this).attr("checktype");
		$passday = parseInt( jQuery(this).attr("passday") );
		$is_paused = parseInt( jQuery(this).attr("is_paused") );
		
		if( $is_paused == 0 ){
			jQuery("#data-selection-list-suspend-btn").removeClass("hide");
			jQuery("#data-selection-list-delete-btn").addClass("hide");
			jQuery("#data-selection-list-unsuspend-btn").addClass("hide");
		} else {
			jQuery("#data-selection-list-suspend-btn").addClass("hide");
			jQuery("#data-selection-list-delete-btn").removeClass("hide");
			jQuery("#data-selection-list-unsuspend-btn").removeClass("hide");
		}
		
		jQuery(".graph-time-stamp li").each(function(){
			var workday = parseInt( jQuery(this).attr("workday") );
			if( workday == 1 || workday < $passday ){
				jQuery(this).removeClass("hide");
			} else {
				jQuery(this).addClass("hide");
			}
		});
		
		jQuery("#check_report_period").val( jQuery('.select-time-stamp').attr('combo-val') );
		jQuery("#report_mongo_id").val( $report_mongo_id );
		jQuery("#report_check_id").val( $report_check_id );
		
		show_dashboard_graph_mask();
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#getgraphdataform').attr('action'),
			data : jQuery('#getgraphdataform').serialize(),
			success : function( res ){				
				$report_mongo_id = jQuery("#report_mongo_id").val();
				$report_check_id = jQuery("#report_check_id").val();
				
				jQuery("#data-selection-list-edit-btn").attr("data-checkid", $report_check_id);
				jQuery("#data-selection-list-edit-btn").attr("data-mongoid", $report_mongo_id);
				
				jQuery("#data-selection-list-suspend-btn").attr("data-checkid", $report_check_id);
				jQuery("#data-selection-list-suspend-btn").attr("data-mongoid", $report_mongo_id);
				jQuery("#data-selection-list-unsuspend-btn").attr("data-checkid", $report_check_id);
				jQuery("#data-selection-list-unsuspend-btn").attr("data-mongoid", $report_mongo_id);
				jQuery("#data-selection-list-delete-btn").attr("data-checkid", $report_check_id);
				jQuery("#data-selection-list-delete-btn").attr("data-mongoid", $report_mongo_id);
				
				jQuery("#graph-section-bar").removeClass("hide");
				
				hidden_dashboard_graph_mask();
		
				var notification_email = '';
				for( var i =0; i < res.alert.length; i++ ){
					notification_email += '<li><a href="mailTo:' + res.alert[i].alert_email + '">' + res.alert[i].alert_email + '</a></li>';
				}
				jQuery("#detail_notification_email").html( notification_email );
				
				reDrawVectorGraph( res.Records );				
				reDrawLineGraph( res.Records );
			}
		});
	});
}

function check_list_action_list(){	
	jQuery(".see_detail_btn").click(function(){
		$index = jQuery(this).data("index");
		$site_url = jQuery('#site-url-section-' + $index).html();
		$detail_page_url = jQuery('#domain-section-' + $index + ' .url-detail-title-' + $index);
		
		$detail_page_list = '<ul>';
		for( var i = 0; i < $detail_page_url.length; i++ ){
			$detail_page_list += '<li><a href="" class="' + jQuery($detail_page_url[i]).attr('class') + '" checktype="' + jQuery($detail_page_url[i]).attr('checktype') + '" mongoid="' + jQuery($detail_page_url[i]).attr('mongoid') + '" checkid="' + jQuery($detail_page_url[i]).attr('checkid') + '" passday="' + jQuery($detail_page_url[i]).attr('passday') + '" is_paused="' + jQuery($detail_page_url[i]).attr('is_paused') + '">' + jQuery($detail_page_url[i]).html() + '</a></li>';
		}
		$detail_page_list += '</ul>';
		
		if( $detail_page_url.length < 2 ){
			jQuery("#dashboard-graph-page-list .graph-page-prev").addClass("hide");
			jQuery("#dashboard-graph-page-list .graph-page-next").addClass("hide");
			
			jQuery("#dashboard-graph-page-list .graph-page-prev").unbind('click');
			jQuery("#dashboard-graph-page-list .graph-page-next").unbind('click');
		} else {
			jQuery("#dashboard-graph-page-list .graph-page-prev").removeClass("hide");
			jQuery("#dashboard-graph-page-list .graph-page-next").removeClass("hide");
			
			jQuery(".graph-page-prev").bind('click', function(){
				$prev = jQuery(".graph-page-list-items .select-page").prev();
				jQuery('a', $prev).trigger('click');
				$prev.trigger('click');
			});
			jQuery("#dashboard-graph-page-list .graph-page-next").bind('click', function(){
				$next = jQuery(".graph-page-list-items .select-page").next();
				jQuery('a', $next).trigger('click');
				$next.trigger('click');
			});
		}
		
		jQuery("#graph-title").html( $site_url );
		jQuery(".graph-page-list-items").html( $detail_page_list );
		
		jQuery(".graph-page-list-items a").removeClass("mytooltip").removeClass("bottom");
		
		jQuery(".graph-page-list-items li").click(function(){
			jQuery(".graph-page-list-items li").removeClass("select-page");
			jQuery(this).addClass("select-page");
			return false;
		});
		
		jQuery("#dashboard").addClass('hide');
		jQuery("#graph-section-bar").removeClass('hide');
		
		check_list_see_more();
		jQuery(".graph-page-list-items li:eq(0) a").trigger("click");
		
		return false;
	});
	
	// App.init();
}

jQuery(document).ready(function(){	
	check_list_action_list();
	check_list_see_more();
	
	jQuery("#data-selection-list-suspend-btn").click(function(){
		if( confirm("Are you sure to suspend this check?") ){
			show_dashboard_graph_mask();
			
			var mongo_id = jQuery(this).attr("data-mongoid"),
				check_id = jQuery(this).attr("data-checkid");
			
			jQuery("#suspend_check_id").val( check_id );
			jQuery("#suspend_mongo_id").val( mongo_id );
			jQuery("#suspend_is_paused").val( 1 );
			
			jQuery.ajax({
				type : 'post',
				dataType : 'json',
				url : jQuery('#suspendcheckform').attr('action'),
				data : jQuery("#suspendcheckform").serialize(),
				success : function( res ){
					hidden_dashboard_graph_mask();
					
					jQuery("#data-selection-list-suspend-btn").addClass("hide");
					jQuery("#data-selection-list-delete-btn").removeClass("hide");
					jQuery("#data-selection-list-unsuspend-btn").removeClass("hide");
					
					jQuery(".graph-page-list-items .select-page a").attr("is_paused", "1");
					$checkid = jQuery(".graph-page-list-items .select-page a").attr("checkid");
					
					jQuery(".url-detail-title a[checkid=" + $checkid + "]").attr("is_paused", 1);
				}
			});
		}
	});
	
	jQuery("#data-selection-list-unsuspend-btn").click(function(){
		if( confirm("Are you sure to unsuspend this check?") ){
			show_dashboard_graph_mask();
			
			var mongo_id = jQuery(this).attr("data-mongoid"),
				check_id = jQuery(this).attr("data-checkid");
			
			jQuery("#suspend_check_id").val( check_id );
			jQuery("#suspend_mongo_id").val( mongo_id );
			jQuery("#suspend_is_paused").val( 0 );
			
			jQuery.ajax({
				type : 'post',
				dataType : 'json',
				url : jQuery('#suspendcheckform').attr('action'),
				data : jQuery("#suspendcheckform").serialize(),
				success : function( res ){
					hidden_dashboard_graph_mask();
					
					jQuery("#data-selection-list-suspend-btn").removeClass("hide");
					jQuery("#data-selection-list-delete-btn").addClass("hide");
					jQuery("#data-selection-list-unsuspend-btn").addClass("hide");
					
					jQuery(".graph-page-list-items .select-page a").attr("is_paused", "0");
					$checkid = jQuery(".graph-page-list-items .select-page a").attr("checkid");
					
					jQuery(".url-detail-title a[checkid=" + $checkid + "]").attr("is_paused", 0);
				}
			});
		}
	});
	
	jQuery("#data-selection-list-delete-btn").click(function(){
		if( confirm("Are you sure to delete this check?") ){
			show_dashboard_graph_mask();
			
			var mongo_id = jQuery(this).attr("data-mongoid"),
				check_id = jQuery(this).attr("data-checkid");
			
			jQuery("#del_check_id").val( check_id );
			jQuery("#del_mongo_id").val( mongo_id );
			
			jQuery.ajax({
				type : 'post',
				dataType : 'json',
				url : jQuery('#deletecheckform').attr('action'),
				data : jQuery("#deletecheckform").serialize(),
				success : function( res ){				
					$domain_section = jQuery("#check_row_" + check_id).parent();
					jQuery("#check_row_" + check_id).remove();
					
					if( jQuery("[id^=check_row]", $domain_section).length == 0 ){
						$domain_section.remove();
					}
					
					hidden_dashboard_graph_mask();
					
					jQuery("#graph-section-bar").addClass("hide");
					jQuery("#dashboard").removeClass("hide");
				}
			});
		}
	});
	
	jQuery(".graph-time-stamp li").click(function(){
		jQuery(".graph-time-stamp li").removeClass("select-time-stamp");
		jQuery(this).addClass("select-time-stamp");
		
		var sel_combo_val = jQuery(this).attr('combo-val');
		
		jQuery("#check_report_period").val( sel_combo_val );
		
		show_dashboard_graph_mask();
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#getgraphdataform').attr('action'),
			data : jQuery('#getgraphdataform').serialize(),
			success : function( res ){				
				jQuery("#graph-section-bar").removeClass("hide");
				
				hidden_dashboard_graph_mask();
				
				reDrawVectorGraph( res.Records );
				reDrawLineGraph( res.Records );				
			}
		});
	});
	
	jQuery(".showing-type").click(function(){
		jQuery(".showing-type").removeClass('select-data-item');
		jQuery(this).addClass('select-data-item');
		
		var type = jQuery(this).attr( 'type' );
		
		jQuery("#check_report_period").val( jQuery('#check_report_period').val() );		
		
		show_dashboard_graph_mask();
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#getgraphdataform').attr('action'),
			data : jQuery('#getgraphdataform').serialize(),
			success : function( res ){
				hidden_dashboard_graph_mask();
				
				reDrawLineGraph( res.Records );
			}
		});
	});
	
	jQuery("#graph-section-close").click(function(){
		jQuery("#graph-section-bar").addClass('hide');
		jQuery("#dashboard").removeClass('hide');
	});
	
	jQuery("#contact-support-manual-mode-list .graph-page-prev").click(function(){
		$prev = jQuery(".manual-page-list-items .select-page").prev();
		jQuery('a', $prev).trigger('click');
		$prev.trigger('click');
	});
	
	jQuery("#contact-support-manual-mode-list .graph-page-next").click(function(){
		$next = jQuery(".manual-page-list-items .select-page").next();
		jQuery('a', $next).trigger('click');
		$next.trigger('click');
	});
	
	jQuery("#data-selection-list-edit-btn").click(function(){
		$checkid = jQuery(this).attr('data-checkid');
		$mongoid = jQuery(this).attr('data-mongoid');

		jQuery('#getsiteinfoforedit input[name=mongo_id]').val( $mongoid );
		jQuery('#getsiteinfoforedit input[name=check_id]').val( $checkid );
				
		show_dashboard_graph_mask();
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery('#getsiteinfoforedit').attr('action'),
			data : jQuery('#getsiteinfoforedit').serialize(),
			success : function( res ){
				hidden_dashboard_graph_mask();
				
				jQuery("#edit-site-info").removeClass("hide");
				jQuery("#graph-section-bar").addClass("hide");
		
				if( res.type == 'http' ){
					jQuery(".edit_http_header").removeClass('hide');
					jQuery(".edit_https_header").addClass('hide');
					jQuery(".edit_dns_header").addClass('hide');
					
					jQuery(".edit-http-section").removeClass('hide');
					jQuery(".edit-https-section").addClass('hide');
					jQuery(".edit-dns-section").addClass('hide');
					
					jQuery("#edithttpsiteinfoforedit input[name=checkid]").val( jQuery('#getsiteinfoforedit input[name=check_id]').val() );
					jQuery("#edithttpsiteinfoforedit input[name=mongoid]").val( jQuery('#getsiteinfoforedit input[name=mongo_id]').val() );
					
					jQuery("#edit-site-info-param input[name=http_url]").val( res.url );
					jQuery("#edit-site-info-param input[name=http_phrases]").val( res.options['phrases_to_match'] );
					
					var notification_email_html = '';
					
					for( var i = 0; i < res.alert_email.length; i++ ){
						notification_email_html += '<li><span class="pull-left">' + res.alert_email[i]['alert_email'] + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + res.alert_email[i]['alert_email'] + '"></li>';
					}
					
					jQuery("#edit_http_alert_list").html( notification_email_html );
				} else if( res.type == 'https' ){
					jQuery(".edit_http_header").addClass('hide');
					jQuery(".edit_https_header").removeClass('hide');
					jQuery(".edit_dns_header").addClass('hide');
					
					jQuery(".edit-http-section").addClass('hide');
					jQuery(".edit-https-section").removeClass('hide');
					jQuery(".edit-dns-section").addClass('hide');
					
					jQuery("#edithttpssiteinfoforedit input[name=checkid]").val( jQuery('#getsiteinfoforedit input[name=check_id]').val() );
					jQuery("#edithttpssiteinfoforedit input[name=mongoid]").val( jQuery('#getsiteinfoforedit input[name=mongo_id]').val() );
					
					jQuery("#edit-site-info-param input[name=https_url]").val( res.url );
					jQuery("#edit-site-info-param input[name=https_phrases]").val( res.options['phrases_to_match'] );
					
					var notification_email_html = '';
					
					for( var i = 0; i < res.alert_email.length; i++ ){
						notification_email_html += '<li><span class="pull-left">' + res.alert_email[i]['alert_email'] + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + res.alert_email[i]['alert_email'] + '"></li>';
					}
					
					jQuery("#edit_https_alert_list").html( notification_email_html );
				} else if( res.type == 'dns' ){
					jQuery(".edit_http_header").addClass('hide');
					jQuery(".edit_https_header").addClass('hide');
					jQuery(".edit_dns_header").removeClass('hide');
					
					jQuery(".edit-http-section").addClass('hide');
					jQuery(".edit-https-section").addClass('hide');
					jQuery(".edit-dns-section").removeClass('hide');
					
					jQuery("#editdnssiteinfoforedit input[name=checkid]").val( jQuery('#getsiteinfoforedit input[name=check_id]').val() );
					jQuery("#editdnssiteinfoforedit input[name=mongoid]").val( jQuery('#getsiteinfoforedit input[name=mongo_id]').val() );
					
					jQuery("#edit-site-info-param input[name=dns_host_name]").val( res.url );
					jQuery("#edit-site-info-param input[name=dns_ip]").val( res.host );
					
					var notification_email_html = '';
					
					for( var i = 0; i < res.alert_email.length; i++ ){
						notification_email_html += '<li><span class="pull-left">' + res.alert_email[i]['alert_email'] + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + res.alert_email[i]['alert_email'] + '"></li>';
					}
					
					jQuery("#edit_dns_alert_list").html( notification_email_html );
				}
				
				jQuery(".remove_check_alert_email").click(function(){
					jQuery(this).parent().remove();
				});
			}
		});
	});
	
	jQuery("#edithttpsiteinfoforedit").submit(function(){
		var urlregex = new RegExp("^http\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
		
		if( urlregex.test( jQuery('#edithttpsiteinfoforedit input[name=http_url]').val() ) ){	
			jQuery("#edit_http_url_error").addClass('hide');
			jQuery('#edithttpsiteinfoforedit input[name=http_url]').removeClass('add_site_info_err');
		} else {
			jQuery('#edithttpsiteinfoforedit input[name=http_url]').addClass('add_site_info_err');
			
			jQuery("#edit_http_url_error").removeClass('hide');
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#site_edit_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery(this).attr('action'),
			data : jQuery(this).serialize(),
			success : function( res ){
				jQuery("#site_edit_progress").addClass("hide");
				if( res.status == 'OK' ){					
					refreshDashboardHomePage();
				}
			}
		});
		
		return false;
	});
	
	jQuery("#edit_http_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#edithttpsiteinfoforedit input[name=edit_alert_email]").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#edit_http_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#edit_http_alert_email_err").addClass("hide");
			jQuery("#edithttpsiteinfoforedit input[name=edit_alert_email]").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#edit_http_alert_email_err").removeClass("hide");
			jQuery("#edithttpsiteinfoforedit input[name=edit_alert_email]").addClass("add_site_info_err");
		}
	});
	
	jQuery("#edithttpssiteinfoforedit").submit(function(){
		var urlregex = new RegExp("^https\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
		
		if( urlregex.test( jQuery('#edithttpssiteinfoforedit input[name=https_url]').val() ) ){	
			jQuery("#edit_https_url_error").addClass('hide');
			jQuery('#edithttpssiteinfoforedit input[name=https_url]').removeClass('add_site_info_err');
		} else {
			jQuery('#edithttpssiteinfoforedit input[name=https_url]').addClass('add_site_info_err');
			
			jQuery("#edit_https_url_error").removeClass('hide');
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#site_edit_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery(this).attr('action'),
			data : jQuery(this).serialize(),
			success : function( res ){
				jQuery("#site_edit_progress").addClass("hide");
				
				if( res.status == 'OK' ){					
					refreshDashboardHomePage();
				}
			}
		});
		
		return false;
	});
	
	jQuery("#edit_https_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#edithttpssiteinfoforedit input[name=edit_alert_email]").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#edit_https_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#edit_https_alert_email_err").addClass("hide");
			jQuery("#edithttpssiteinfoforedit input[name=edit_alert_email]").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#edit_https_alert_email_err").removeClass("hide");
			jQuery("#edithttpssiteinfoforedit input[name=edit_alert_email]").addClass("add_site_info_err");
		}
	});
	
	jQuery("#editdnssiteinfoforedit").submit(function(){
		var urlregex = new RegExp("^(?!:\/\/)([a-zA-Z0-9]+\.)?[a-zA-Z0-9][a-zA-Z0-9-]+\.[a-zA-Z]{2,6}?$");
		
		if( urlregex.test( jQuery('#editdnssiteinfoforedit [name=dns_host_name]').val() ) ){
			jQuery('#edit_dns_url_error').addClass('hide');
			jQuery('#editdnssiteinfoforedit [name=dns_host_name]').removeClass('add_site_info_err');
		} else {
			jQuery('#editdnssiteinfoforedit [name=dns_host_name]').addClass('add_site_info_err');
			jQuery('#edit_dns_url_error').removeClass('hide');
						
			return false;
		}
		
		$broswer_height = jQuery(window).outerHeight();
		jQuery("#site_edit_progress").removeClass("hide").css("height", $broswer_height + "px");
		
		jQuery.ajax({
			type : 'post',
			dataType : 'json',
			url : jQuery(this).attr('action'),
			data : jQuery(this).serialize(),
			success : function( res ){
				jQuery("#site_edit_progress").addClass("hide");
				
				if( res.status == 'OK' ){					
					refreshDashboardHomePage();
				}
			}
		});
		
		return false;
	});
	
	jQuery("#edit_dns_add_alert_email").click(function(){
		var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
			alert_email = jQuery("#editdnssiteinfoforedit input[name=edit_alert_email]").val();
		
		if( pattern.test( alert_email ) ) {
			jQuery("#edit_dns_alert_list").append('<li><span class="pull-left">' + alert_email + '</span><a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"></a><input type="hidden" name="check_alert_email[]" value="' + alert_email + '"></li>');
			
			jQuery("#edit_dns_alert_email_err").addClass("hide");
			jQuery("#editdnssiteinfoforedit input[name=edit_alert_email]").removeClass("add_site_info_err");
			
			jQuery(".remove_check_alert_email").click(function(){
				jQuery(this).parent().remove();
			});
		} else {
			jQuery("#edit_dns_alert_email_err").removeClass("hide");
			jQuery("#editdnssiteinfoforedit input[name=edit_alert_email]").addClass("add_site_info_err");
		}
	});
});

function reDrawVectorGraph( datalist ){
	jQuery(".uptimebar-graph").html( '' );
	jQuery(".uptimebar-graph-label").html( '' );
	
	if( datalist.length == 0 ){
		jQuery(".bar-graph-title").css("display", "none");
		jQuery("#uptimeBar").addClass("hide");
		jQuery(".bar-graph-x-axis").css("display", "none");
		
		return;
	} else {
		jQuery(".bar-graph-title").css("display", "block");
		jQuery("#uptimeBar").removeClass("hide");
		jQuery(".bar-graph-x-axis").css("display", "block");
	}
	
	var period = jQuery('.select-time-stamp').attr('combo-val');
	
	var min_date_str = getTimeStrampToStr( datalist[ datalist.length - 1 ].timestamp * 1000 ),
		max_date_str = getTimeStrampToStr( datalist[ 0 ].timestamp * 1000 );
	
	jQuery(".graph-date-range").html( min_date_str + " - " + max_date_str );
	
	var max_date = getJustDayTimeStamp( new Date( datalist[0].timestamp * 1000  + 24 * 3600 * 1000 ) ),
		min_date = getJustDayTimeStamp( new Date( datalist[ datalist.length - 1 ].timestamp * 1000 ) );
		
	var max_date_timestamp = max_date.getTime() / 1000,
		min_date_timestamp = min_date.getTime() / 1000;
	
	var distance = max_date_timestamp - min_date_timestamp;
	
	var valuelist = new Array();
	var titlelist = new Array();
	
	var offset = 0;
	for( var i = datalist.length - 1 ; i >=0; i-- ){
		if( typeof  datalist[i].outages != 'undefined' ) {
			for( var j = 0; j < datalist[i].outages.length; j++ ){
				var diff = datalist[i].outages[j].timestamp - min_date_timestamp;
				if( diff > 0 ){
					valuelist.push( ( diff / distance ) * 100 );
					titlelist.push( datalist[i].outages[j].timestamp );
					// offset = diff / distance;
				}
			}
		}
	}
	
	var html_str = "";
	var var_html_str = "";
		
	for( var i = 0; i < valuelist.length; i++ ){
		html_str += '<div class="down" style="left:' + valuelist[i] + '%;" title="' + getTimeStrampToStrHour( titlelist[i] * 1000 ) + '"></div>';
	}
	
	var style_width = '';
	
	if( datalist.length > 0 ){
		style_width = 'style="width:' + 100.0 / datalist.length + '%"';
	}
	
	var monthNameList = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
	
	for( var i = datalist.length - 1; i >= 0 ; i-- ){		
		if( period == "day" ){
			var x_val = new Date( datalist[i].timestamp * 1000 );
			var_html_str += '<div class="bar-graph-week-title" ' + style_width + '>' + x_val.getHours() + '</div>';
		} else if( period == "week" ){
			var_html_str += '<div class="bar-graph-week-title" ' + style_width + '>' + getTimeStrampToStrSummary( datalist[i].timestamp * 1000 ) + '</div>';
		} else if( period == "month" ){
			var x_val = new Date( datalist[i].timestamp * 1000 );
			var_html_str += '<div class="bar-graph-week-title" ' + style_width + '>' + x_val.getDate() + '</div>';
			// var_html_str += '<div class="bar-graph-week-title" ' + style_width + '>' + x_val.getDate() + "/" + ( x_val.getMonth() + 1 ) + '</div>';
		} else if( period == "months" ){
			var x_val = new Date( datalist[i].timestamp * 1000 );
			var_html_str += '<div class="bar-graph-week-title" ' + style_width + '>' + monthNameList[x_val.getMonth()] + '</div>';
		}
	}
	
	jQuery(".uptimebar-graph").html( html_str );
	jQuery(".uptimebar-graph-label").html( var_html_str );
}

function reDrawLineGraph( recordDatalist ){	
	var type = jQuery(".select-data-item").attr( 'type' );
	var period = jQuery('.select-time-stamp').attr('combo-val');
	
	var lineGraphDatas = new Array( );
	var lineGraphXAxis = new Array( );
	
	var avg_availability = 0, avg_downtime = 0, original_avg_downtime = 0, avg_responsetime = 0, original_avg_responsetime = 0, avg_responsiveness = 0;
	
	if( recordDatalist.length > 0 ){
		for( var i = 0; i < recordDatalist.length; i++ ){					
			var index = recordDatalist.length - i -1;
			
			if( type == "Availability" ){
				lineGraphDatas[index] = getRound3( recordDatalist[i].availability );
			} else if( type == "Downtime" ){
				lineGraphDatas[index] = getRound3( recordDatalist[i].down_time );
			} else if( type == "Response Time" ){
				lineGraphDatas[index] = getRound3( recordDatalist[i].response_time );
			} else if( type == "Responsiveness" ){
				lineGraphDatas[index] = getRound3( recordDatalist[i].responsiveness );
			}
			
			var x_val = new Date( recordDatalist[i].timestamp * 1000 );
			
			var monthNameList = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ];
			
			if( period == "day" ){
				lineGraphXAxis[index] = x_val.getHours();
			} else if( period == "week" ){
				// lineGraphXAxis[index] = x_val.getDate() + "/" + ( x_val.getMonth() + 1 ) + "/" + x_val.getFullYear();
				lineGraphXAxis[index] = x_val.getDate();
			} else if( period == "month" ){
				// lineGraphXAxis[index] = x_val.getDate() + "/" + ( x_val.getMonth() + 1 );
				lineGraphXAxis[index] = x_val.getDate();
			} else if( period == "months" ){
				// lineGraphXAxis[index] = x_val.getDate() + "/" + ( x_val.getMonth() + 1 ) + "/" + x_val.getFullYear();
				lineGraphXAxis[index] = monthNameList[ x_val.getMonth() ];
			}
			
			avg_availability 	+= recordDatalist[i].availability;
			avg_downtime 		+= recordDatalist[i].down_time;
			avg_responsetime 	+= recordDatalist[i].response_time;
			avg_responsiveness 	+= recordDatalist[i].responsiveness;
		}
		
		avg_availability 	= getRound4( avg_availability  / recordDatalist.length );
		original_avg_downtime = avg_downtime;
		avg_downtime 		= changeTimeValueBySec( avg_downtime );
		original_avg_responsetime = avg_responsetime  / recordDatalist.length;		
		avg_responsetime 	= changeTimeValue( avg_responsetime  / recordDatalist.length );
		avg_responsiveness 	= getRound4( avg_responsiveness  / recordDatalist.length );
	}
	
	jQuery("#availability_value").html( avg_availability + "%" );
	jQuery("#downtime_value").html( avg_downtime );
	jQuery("#response_time_value").html( avg_responsetime );
	jQuery("#responsiveness_value").html( avg_responsiveness + "%" );
	
	if( type == "Downtime" ){
		if( original_avg_downtime > 3600 ) {
			for( var i = 0; i < lineGraphDatas.length; i++ ){
				lineGraphDatas[i] = lineGraphDatas[i] / 3600;
			}
		} else if( original_avg_downtime > 60 ){
			for( var i = 0; i < lineGraphDatas.length; i++ ){
				lineGraphDatas[i] = lineGraphDatas[i] / 60;
			}
		}
	} else if( type == "Response Time" ){
		for( var i = 0; i < lineGraphDatas.length; i++ ){
			lineGraphDatas[i] = lineGraphDatas[i] / 1000;
		}
	}
	
	var min = lineGraphDatas[0], max = lineGraphDatas[0];
	
	for( var i = 0; i < lineGraphDatas.length; i++ ){		
		if( min > lineGraphDatas[i] ) min = lineGraphDatas[i];
		if( max < lineGraphDatas[i] ) max = lineGraphDatas[i];
	}
	
	new Highcharts.Chart({
		chart: {
			renderTo : 'container',
			backgroundColor: 'transparent',
			type: 'area'
		},
		title: {
			text: ''
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			lineWidth: 1,
			gridLineWidth: 1,
			gridLineColor: '#E7EAEB',
			lineColor: '#E7EAEB',
			categories: lineGraphXAxis,
			tickmarkPlacement: 'on',
			title: {
				enabled: false
			},
			labels: {
				style: {
					color: '#797E86',
					fontSize: '16px',
					fontFamily: 'Roboto',
					fontWeight: '300'
				}
			}				
		},
		yAxis: {
			min: min,
			max : max,
			title: {
				text: ''
			},
			labels: {
				style: {
					color: '#797E86',
					fontSize: '16px',
					fontFamily: 'Roboto',
					fontWeight: '300'
				},
				formatter: function() {
					return ' ' + this.value;
				}
			},
			gridLineWidth: 1,
			lineWidth: 1,
			lineColor: '#E7EAEB',
			gridLineColor: '#E7EAEB'
		},
		tooltip: {
			shared: true,
			valueSuffix: ''
		},
		plotOptions: {
			area: {
				stacking: 'normal',
				lineColor: '#549ACE',
				lineWidth: 1,
				marker: {
					lineWidth: 2,
					lineColor: '#0575BD',
					fillColor: '#fff',
					radius: 4
				}
			},
			series: {
				fillOpacity: 0.3
			}
		},
		series: [{
			showInLegend: false,
			name: 'value',
			data: lineGraphDatas,
			color: '#0072BC'
		}],
		credits: {
			enabled: false
		}
	});
}