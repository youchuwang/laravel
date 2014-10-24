<div class="clearfix"></div>
<div id="contact-support-add-another-site" class="inner_page_dlg hide">
	<div id="contact-support-add-another-site-header">
		<div class="beta-container">
			<div class="row-fluid">
				<div class="span12">
					<h1>Add Another Site</h1>
					<a href="#" id="add_another_site_close_btn" class="close close_inner_page" main_id="dashboard" modal_id="contact-support-add-another-site">&nbsp;</a>
				</div>
			</div>
		</div>
	</div>
	<div class="beta-container">
		<div class="clearfix"></div>
		<div class="row-fluid">
			<div class="span1">
			</div>
			<div class="span10">
				<h5>Please select your mode of check creation.</h5>
				<br/>
				<div class="clearfix"></div>
				<div class="row-fluid">
					<div class="span6 add-another-site-btn-section">
						<div class="add-site-setting-dlg-auto">
							<img src="assets/img/auto-check.png"/>
							<h5>Auto Check Creation</h5>
							<p>Auto-create checks for you. We will automatically create checks for the web, mail, and dns servers.</p>
							<a href="#" id="auto-check-creation-btn" main_id="dashboard" modal_id="contact-support-auto-mode" class="open_inner_page">SELECT MODE</a>
						</div>
					</div>
					<div class="span6 add-another-site-btn-section">
						<div class="add-site-setting-dlg-manual">
							<img src="assets/img/mannual-check.png"/>
							<h5>Manual Check Creation</h5>
							<p>You have freedome to create your own checks for the web, mail, and dns servers.</p>
							<a href="#" id="manual-check-creation-btn" main_id="dashboard" modal_id="contact-support-manual-mode" class="open_inner_page">SELECT MODE</a>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="span1">
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div id="contact-support-auto-mode" class="inner_page_dlg hide">
	<div id="auto_add_insert_progress" class="hide"></div>
	<div id="contact-support-manual-mode-header">
		<div class="beta-container">
			<div class="row-fluid">
				<div class="span12" style="text-align:center;">
					<h1>Add Site</h1>
					<h1 class="auto_check_creation_header">Auto Check Creation</h1>
					<a href="#" class="close close_inner_page" main_id="contact-support-add-another-site" modal_id="contact-support-auto-mode">&nbsp;</a>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="beta-container" id="auto_manual_mode_param">
		<div class="row-fluid">
			<div id="add_auto_site_info_duplicate" class="alert hide">This site is already exist.</div>
			{{ Form::open( array(
				'route' => 'checksite.addsiteinfoauto',
				'method' => 'post',
				'id' => 'auto_setting_form'
			) ) }}
			<div class="row-fluid">
				<div class="span12">
					<div class="add_url_parameter_section">
						<div class="add_url_parameter_label_section">
							<h5>Enter URL</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="add_url_parameter_error_section">
							<div id="auto_url_error" class="hide">
								<div class="error-label">Entered link is invalid</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="add_url_parameter_input_section">
							<input data-action="{{URL::route('checksite.addsiteinfoauto')}}" id="site_auto_mode_url" type="text" name="url" class="m-wrap" placeholder="Example : http://www.yahoo.com"/>
						</div>
					</div>
					<div class="clearfix h50"></div>
					<div class="add_notification_section">
						<div class="add_notification_label_section">
							<h5>Notification Emails</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="add_notification_error_section">
							<div id="auto_alert_email_err" class="hide">
								<div class="error-label">Please enter valid email address</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="add_notification_input_section">
							<input type="text" placeholder="Email Address" class="m-wrap" name="auto_alert_email" id="auto_alert_email" value="" />
						</div>
						<div class="add_notification_btn_section">
							<input type="button" id="auto_add_alert_email" class="add_check_btn" value="Add Email"/>
						</div>
					</div>
					<div class="check-alert-email-section">
						<ul id="auto_alert_list" class="check-alert-email-list"></ul>
						<ul class="user-account-email-list">
						@foreach ($usealertemail as $item)
							<li>
								<span class="pull-left">{{ $item->alertemail }}</span>
								<a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"/></a>
								<input type="hidden" name="check_alert_email[]" value="{{ $item->alertemail }}" />
							</li>
						@endforeach
							<li>
								<span class="pull-left">{{ $useremail }}</span>
								<a href="#" class="remove_check_alert_email pull-right"><img src="assets/img/remove-icon.png"/></a>
								<input type="hidden" name="check_alert_email[]" value="{{ $useremail }}" />
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>
					<input type="submit" class="add_check_btn create_check_btn" value="Create Check" />
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div id="contact-support-manual-mode" class="inner_page_dlg hide">
	<div id="manual_add_insert_progress" class="hide"></div>
	<div id="contact-support-manual-mode-header">
		<div class="beta-container">
			<div class="row-fluid">
				<div class="span12" style="text-align:center;">
					<h1>Add Site</h1>
					<h1 class="manual_check_creation_header">Manual Check Creations</h1>
					<a href="#" class="close close_inner_page" main_id="contact-support-add-another-site" modal_id="contact-support-manual-mode">&nbsp;</a>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div id="contact-support-manual-mode-list">
		<div class="beta-container">
			<div class="row-fluid">
				<div class="span12">
					<div class="manual-page-list-items">
						<ul>
							<li class="select-page" parameterfield="http_parameter_field">
								<a href="" class="http-label">http</a>
							</li>
							<li parameterfield="https_parameter_field">
								<a href="" class="https-label">https</a>
							</li>
							<li parameterfield="dns_parameter_field">
								<a href="" class="dns-label">dns</a>
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>
					<a href="#" class="graph-page-prev"></a>
					<a href="#" class="graph-page-next"></a>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="beta-container add-another-site-form-section">
		<div class="row-fluid">
			<div class="span12">
				<div class="row-fluid">
					<div class="span12">
						<div id="add_site_info_duplicate" class="alert hide">This site is already exist.</div>
						<!--div id="add_site_info_success" class="alert alert-success hide">Successfully inserted.</div//-->
						<ul id="user-account-email-list-escape" class="hide user-account-email-list">
						@foreach ($usealertemail as $item)
							<li>
								<span class="pull-left">{{ $item->alertemail }}</span>
								<a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"/></a>
								<input type="hidden" name="check_alert_email[]" value="{{ $item->alertemail }}" />
							</li>
						@endforeach
							<li>
								<span class="pull-left">{{ $useremail }}</span>
								<a href="#" class="remove_check_alert_email pull-right"><img src="assets/img/remove-icon.png"/></a>
								<input type="hidden" name="check_alert_email[]" value="{{ $useremail }}" />
							</li>
						</ul>
						<div id="http_parameter_field" class="parameter_section">
							{{ Form::open( array(
								'route' => 'checksite.addsiteinfohttp',
								'method' => 'post',
								'id' => 'manual_setting_form_http'
							) ) }}
							<div class="row-fluid">
								<div class="span12">
									<div class="add_url_parameter_section">
										<div class="add_url_parameter_label_section">
											<h5>Enter URL</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_url_parameter_error_section">
											<div id="manual_http_url" class="hide">
												<div class="error-label">Entered link is invalid</div>
												<div class="error-arrow"></div>
											</div>&nbsp;
										</div>
										<div class="add_url_parameter_input_section">
											<input type="text" placeholder="Example : http://www.yahoo.com" class="m-wrap" name="http_url" value="" />
										</div>
									</div>
									<div class="add_other_parameter_section">
										<div class="add_other_parameter_label_section">
											<h5>Phrases to match (Optional)</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_other_parameter_input_section">
											<input type="text" placeholder="Example : Yahoo" class="m-wrap" name="http_phrases" value=""/>
										</div>
									</div>
									<div class="add_check_btn_section">
										<input type="button" class="add_check_btn hide" value="Add Check" />
									</div>
									<div class="clearfix h50"></div>
									<div class="add_notification_section">
										<div class="add_notification_label_section">
											<h5>Notification Emails</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_notification_error_section">
											<div id="manual_http_alert_email_err" class="hide">
												<div class="error-label">Please enter valid email address</div>
												<div class="error-arrow"></div>
											</div>&nbsp;
										</div>
										<div class="add_notification_input_section">
											<input type="text" placeholder="Email Address" class="m-wrap" name="http_alert_email" id="http_alert_email" value="" />
										</div>
										<div class="add_notification_btn_section">
											<input type="button" class="add_check_btn" id="manual_http_add_alert_email" value="Add Email"/>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="check-alert-email-section">
										<ul id="manual_http_alert_list" class="check-alert-email-list">
										</ul>
										<ul class="user-account-email-list">
										@foreach ($usealertemail as $item)
											<li>
												<span class="pull-left">{{ $item->alertemail }}</span>
												<a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"/></a>
												<input type="hidden" name="check_alert_email[]" value="{{ $item->alertemail }}" />
											</li>
										@endforeach
											<li>
												<span class="pull-left">{{ $useremail }}</span>
												<a href="#" class="remove_check_alert_email pull-right"><img src="assets/img/remove-icon.png"/></a>
												<input type="hidden" name="check_alert_email[]" value="{{ $useremail }}" />
											</li>
										</ul>
									</div>
									<div class="clearfix"></div>
									<input type="submit" class="add_check_btn create_check_btn" value="Create Check"/>
								</div>
							</div>
							{{ Form::close() }}
						</div>
						<div id="https_parameter_field" class="parameter_section hide">
							{{ Form::open( array(
								'route' => 'checksite.addsiteinfohttps',
								'method' => 'post',
								'id' => 'manual_setting_form_https'
							) ) }}
							<div class="row-fluid">
								<div class="span12">
									<div class="add_url_parameter_section">
										<div class="add_url_parameter_label_section">
											<h5>Enter URL</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_url_parameter_error_section">
											<div id="manual_https_url" class="hide">
												<div class="error-label">Entered link is invalid</div>
												<div class="error-arrow"></div>
											</div>&nbsp;
										</div>
										<div class="add_url_parameter_input_section">
											<input type="text" placeholder="Example : https://www.yahoo.com" class="m-wrap" name="https_url" value="" />
										</div>
									</div>
									<div class="add_other_parameter_section">
										<div class="add_other_parameter_label_section">
											<h5>Phrases to match (Optional)</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_other_parameter_input_section">
											<input type="text" placeholder="Example : Yahoo" class="m-wrap" name="https_phrases" value=""/>
										</div>
									</div>
									<div class="add_check_btn_section">
										<input type="button" class="add_check_btn hide" value="Add Check">
									</div>
									<div class="clearfix h50"></div>
									<div class="add_notification_section">
										<div class="add_notification_label_section">
											<h5>Notification Emails</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_notification_error_section">
											<div id="manual_https_alert_email_err" class="hide">
												<div class="error-label">Please enter valid email address</div>
												<div class="error-arrow"></div>
											</div>&nbsp;
										</div>
										<div class="add_notification_input_section">
											<input type="text" placeholder="Email Address" class="m-wrap" id="https_alert_email" name="http_url" value="" />
										</div>
										<div class="add_notification_btn_section">
											<input type="button" id="manual_https_add_alert_email" class="add_check_btn" value="Add Email"/>
										</div>
										<div class="check-alert-email-section">
											<ul id="manual_https_alert_list" class="check-alert-email-list">
											</ul>
											<ul class="user-account-email-list">
											@foreach ($usealertemail as $item)
												<li>
													<span class="pull-left">{{ $item->alertemail }}</span>
													<a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"/></a>
													<input type="hidden" name="check_alert_email[]" value="{{ $item->alertemail }}" />
												</li>
											@endforeach
												<li>
													<span class="pull-left">{{ $useremail }}</span>
													<a href="#" class="remove_check_alert_email pull-right"><img src="assets/img/remove-icon.png"/></a>
													<input type="hidden" name="check_alert_email[]" value="{{ $useremail }}" />
												</li>
											</ul>
										</div>
									</div>
									<div class="clearfix"></div>
									<input type="submit" class="add_check_btn create_check_btn" value="Create Check" />
								</div>
							</div>
							{{ Form::close() }}
						</div>
						<div id="dns_parameter_field" class="parameter_section hide">
							{{ Form::open( array(
								'route' => 'checksite.addsiteinfodns',
								'method' => 'post',
								'id' => 'manual_setting_form_dns'
							) ) }}
							<div class="row-fluid">
								<div class="span12">
									<div class="add_url_parameter_section">
										<div class="add_url_parameter_label_section">
											<h5>Host name</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_url_parameter_error_section">
											<div id="manual_dns_url" class="hide">
												<div class="error-label">Entered link is invalid</div>
												<div class="error-arrow"></div>
											</div>&nbsp;
										</div>
										<div class="add_url_parameter_input_section">
											<input type="text" placeholder="Example : www.yahoo.com" class="m-wrap" name="dns_host_name" value=""/>
										</div>
									</div>
									<div class="add_other_parameter_section">
										<div class="add_other_parameter_label_section">
											<h5>IP Address to match</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_other_parameter_input_section">
											<input type="text" placeholder="Example : xxx.xxx.xxx.xxx" class="m-wrap" name="dns_ip" value=""/>
										</div>
									</div>
									<div class="add_check_btn_section">
										<input type="button" class="add_check_btn hide" value="Add Check">
									</div>
									<div class="clearfix h50"></div>
									<div class="add_notification_section">
										<div class="add_notification_label_section">
											<h5>Notification Emails</h5>
										</div>
										<div class="clearfix h10"></div>
										<div class="add_notification_error_section">
											<div id="manual_dns_alert_email_err" class="hide">
												<div class="error-label">Please enter valid email address</div>
												<div class="error-arrow"></div>
											</div>&nbsp;
										</div>
										<div class="add_notification_input_section">
											<input type="text" placeholder="Email Address" class="m-wrap" name="http_url" id="dns_alert_email" value="" />
										</div>
										<div class="add_notification_btn_section">
											<input type="button" id="manual_dns_add_alert_email" class="add_check_btn" value="Add Email"/>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="check-alert-email-section">
										<ul id="manual_dns_alert_list" class="check-alert-email-list">
										</ul>
										<ul class="user-account-email-list">
										@foreach ($usealertemail as $item)
											<li>
												<span class="pull-left">{{ $item->alertemail }}</span>
												<a class="remove_check_alert_email pull-right" href="#"><img src="assets/img/remove-icon.png"/></a>
												<input type="hidden" name="check_alert_email[]" value="{{ $item->alertemail }}" />
											</li>
										@endforeach
											<li>
												<span class="pull-left">{{ $useremail }}</span>
												<a href="#" class="remove_check_alert_email pull-right"><img src="assets/img/remove-icon.png"/></a>
												<input type="hidden" name="check_alert_email[]" value="{{ $useremail }}" />
											</li>
										</ul>
									</div>
									<div class="clearfix"></div>
									<input type="submit" class="add_check_btn create_check_btn" value="Create Check" />
								</div>
							</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div id="edit-site-info" class="inner_page_dlg hide">
	<div id="edit-site-header">
		<div class="beta-container">
			<div class="row-fluid">
				<div class="span12" style="text-align:center;">
					<h1>Edit Check</h1>
					<h1 class="edit_http_header">http</h1>
					<h1 class="edit_https_header hide">https</h1>
					<h1 class="edit_dns_header hide">dns</h1>
					<a href="#" id="add_another_site_close_btn" class="close close_inner_page" main_id="dashboard" modal_id="contact-support-add-another-site">&nbsp;</a>
				</div>
			</div>
		</div>
	</div>
	<div class="beta-container" id="edit-site-info-param">
		<div class="clearfix"></div>
		<div class="row-fluid">
			<div id="site_edit_progress" class="hide"></div>
			<div class="span12">
				<div class="edit-http-section">
				{{ Form::open( array(
					'route' => 'edithttpsiteinfoforedit',
					'method' => 'post',
					'id' => 'edithttpsiteinfoforedit'
				) ) }}
					<input type="hidden" name="checkid" />
					<input type="hidden" name="mongoid" />
					<div class="edit_url_parameter_section">
						<div class="edit_url_parameter_label_section">
							<h5>Enter URL</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_error_section">
							<div id="edit_http_url_error" class="hide">
								<div class="error-label">Entered link is invalid</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="edit_url_parameter_input_section">
							<input type="text" name="http_url" class="m-wrap" placeholder="Example : http://www.yahoo.com">
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_label_section">
							<h5>Phrases to match (Optional)</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_error_section">
							&nbsp;
						</div>
						<div class="edit_url_parameter_input_section">
							<input name="http_phrases" type="text" class="m-wrap" placeholder="Example : Yahoo">
						</div>
					</div>
					<div class="clearfix h50"></div>
					<div class="edit_notification_section">
						<div class="edit_notification_label_section">
							<h5>Notification Emails</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_notification_error_section">
							<div id="edit_http_alert_email_err" class="hide">
								<div class="error-label">Please enter valid email address</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="edit_notification_input_section">
							<input type="text" placeholder="Email Address" class="m-wrap" name="edit_alert_email" value="" />
						</div>
						<div class="edit_notification_btn_section">
							<input type="button" id="edit_http_add_alert_email" class="add_check_btn" value="Add Email" />
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="check-alert-email-section">
						<ul id="edit_http_alert_list" class="check-alert-email-list">
						</ul>
					</div>
					<div class="clearfix"></div>
					<input type="submit" class="add_check_btn create_check_btn" value="Save Changes" />
				{{ Form::close() }}
				</div>
				<div class="edit-https-section hide">
				{{ Form::open( array(
					'route' => 'edithttpssiteinfoforedit',
					'method' => 'post',
					'id' => 'edithttpssiteinfoforedit'
				) ) }}
					<input type="hidden" name="checkid" />
					<input type="hidden" name="mongoid" />
					<div class="edit_url_parameter_section">
						<div class="edit_url_parameter_label_section">
							<h5>Enter URL</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_error_section">
							<div id="edit_https_url_error" class="hide">
								<div class="error-label">Entered link is invalid</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="edit_url_parameter_input_section">
							<input type="text" name="https_url" class="m-wrap" placeholder="Example : http://www.yahoo.com">
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_label_section">
							<h5>Phrases to match (Optional)</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_error_section">
							&nbsp;
						</div>
						<div class="edit_url_parameter_input_section">
							<input name="https_phrases" type="text" class="m-wrap" placeholder="Example : Yahoo">
						</div>
					</div>
					<div class="clearfix h50"></div>
					<div class="edit_notification_section">
						<div class="edit_notification_label_section">
							<h5>Notification Emails</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_notification_error_section">
							<div id="edit_https_alert_email_err" class="hide">
								<div class="error-label">Please enter valid email address</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="edit_notification_input_section">
							<input type="text" placeholder="Email Address" class="m-wrap" name="edit_alert_email" value="">
						</div>
						<div class="edit_notification_btn_section">
							<input type="button" id="edit_https_add_alert_email" class="add_check_btn" value="Add Email">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="check-alert-email-section">
						<ul id="edit_https_alert_list" class="check-alert-email-list">
						</ul>
					</div>
					<div class="clearfix"></div>
					<input type="submit" class="add_check_btn create_check_btn" value="Save Changes" />
				{{ Form::close() }}
				</div>
				<div class="edit-dns-section hide">
				{{ Form::open( array(
					'route' => 'editdnssiteinfoforedit',
					'method' => 'post',
					'id' => 'editdnssiteinfoforedit'
				) ) }}
					<input type="hidden" name="checkid" />
					<input type="hidden" name="mongoid" />
					<div class="edit_url_parameter_section">
						<div class="edit_url_parameter_label_section">
							<h5>Host name</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_error_section">
							<div id="edit_dns_url_error" class="hide">
								<div class="error-label">Entered link is invalid</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="edit_url_parameter_input_section">
							<input type="text" name="dns_host_name" class="m-wrap" placeholder="Example : www.yahoo.com">
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_label_section">
							<h5>IP Address to match</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_url_parameter_error_section">
							&nbsp;
						</div>
						<div class="edit_url_parameter_input_section">
							<input name="dns_ip" type="text" class="m-wrap">
						</div>
					</div>
					<div class="clearfix h50"></div>
					<div class="edit_notification_section">
						<div class="edit_notification_label_section">
							<h5>Notification Emails</h5>
						</div>
						<div class="clearfix h10"></div>
						<div class="edit_notification_error_section">
							<div id="edit_dns_alert_email_err" class="hide">
								<div class="error-label">Please enter valid email address</div>
								<div class="error-arrow"></div>
							</div>&nbsp;
						</div>
						<div class="edit_notification_input_section">
							<input type="text" placeholder="Email Address" class="m-wrap" name="edit_alert_email" id="edit_alert_email" value="">
						</div>
						<div class="edit_notification_btn_section">
							<input type="button" id="edit_dns_add_alert_email" class="add_check_btn" value="Add Email">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="check-alert-email-section">
						<ul id="edit_dns_alert_list" class="check-alert-email-list">
						</ul>
					</div>
					<div class="clearfix"></div>
					<input type="submit" class="add_check_btn create_check_btn" value="Save Changes" />
				{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
	{{ Form::open( array(
		'route' => 'getsiteinfoforedit',
		'method' => 'post',
		'class' => 'hide',
		'id' => 'getsiteinfoforedit'
	) ) }}
		<input type="hidden" name="mongo_id" value=""/>
		<input type="hidden" name="check_id" value=""/>
	{{ Form::close() }}
</div>