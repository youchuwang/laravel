<?php
class CheckSiteController extends BaseController {
	private $siteInfo;
	private $mongoAPI;
	private $checkAlertEmail;
	
	public function __construct(UserSiteInfo $siteInfo, MongoAPI $mongoAPI, CheckAlertEmail $checkAlertEmail){
		$this->siteInfo = $siteInfo;
		$this->mongoAPI = $mongoAPI;
		$this->checkAlertEmail = $checkAlertEmail;
	}
	
	public function postAddSiteInfoHTTP(){
		$input = \Input::all();
		$http_domain = $this->getDomainFromURLString( $input['http_url'] );
		$option = json_encode( array( 
			'phrases_to_match' => $input['http_phrases'],
			'url_path' => $this->getPathFromURLString( $input['http_url'] )
		) );
		
		$insert_result = $this->siteInfo->insert( Sentry::getUser()->id, '', 'http', $http_domain, $input['http_url'],  '', $option, time() );
		if( $insert_result == 0 ){
			$inserted_check_id = $this->siteInfo->getMaxCheckId();
			
			foreach( $input['check_alert_email'] as $email ){
				$this->checkAlertEmail->insert( Sentry::getUser()->id, $inserted_check_id, $email );
			}
			
			$mongoId = $this->mongoAPI->saveSiteInfoToMongo( 'http', 'KUU-' . Sentry::getUser()->id . '-' . $inserted_check_id, $http_domain );
			if( $mongoId != '' ){
				$this->siteInfo->updateMongoIdByCheckId( $inserted_check_id, $mongoId );
			}
		}
		
		return Response::json( array(
			'err' => $insert_result
		) );
	}
	
	public function postAddSiteInfoHTTPS(){
		$input = \Input::all();
		$https_domain = $this->getDomainFromURLString( $input['https_url'] );
		$option = json_encode( array( 
			'phrases_to_match' => $input['https_phrases'],
			'url_path' => $this->getPathFromURLString( $input['https_url'] )
		) );
		
		$insert_result = $this->siteInfo->insert( Sentry::getUser()->id, '', 'https', $https_domain, $input['https_url'], '', $option, time() );
		if( $insert_result == 0 ){
			$inserted_check_id = $this->siteInfo->getMaxCheckId();
			
			foreach( $input['check_alert_email'] as $email ){
				$this->checkAlertEmail->insert( Sentry::getUser()->id, $inserted_check_id, $email );
			}
			
			$mongoId = $this->mongoAPI->saveSiteInfoToMongo( 'https', 'KUU-' . Sentry::getUser()->id . '-' . $inserted_check_id, $https_domain );
			if( $mongoId != '' ){
				$this->siteInfo->updateMongoIdByCheckId( $inserted_check_id, $mongoId );
			}
		}
		
		return Response::json( array(
			'err' => $insert_result
		) );
	}
	
	public function postAddSiteInfoDNS(){
		$input = \Input::all();
		$dns_domain = $input['dns_host_name'];
		$option = json_encode( array( 
			'url_path' => $dns_domain
		) );
		
		$insert_result = $this->siteInfo->insert( Sentry::getUser()->id, '', 'dns', $dns_domain, $dns_domain, $input['dns_ip'], '', time() );
		if( $insert_result == 0){
			$inserted_check_id = $this->siteInfo->getMaxCheckId();
			
			foreach( $input['check_alert_email'] as $email ){
				$this->checkAlertEmail->insert( Sentry::getUser()->id, $inserted_check_id, $email );
			}
			
			$mongoId = $this->mongoAPI->saveSiteInfoToMongo( 'dns', 'KUU-' . Sentry::getUser()->id . '-' . $inserted_check_id, $dns_domain );
			if( $mongoId != '' ){
				$this->siteInfo->updateMongoIdByCheckId( $inserted_check_id, $mongoId );
			}		
		}
		
		return Response::json( array(
			'err' => $insert_result
		) );
	}

	public function postAddSiteInfoAuto(){
		$validator = App::make('Authority\Service\Form\AddAutoCheck\AddAutoCheckForm');
		$input = \Input::all();
		$data = array(
			'http' => $input['url'],
			'https' => str_replace('http://','https://',$input['url']),
			'dns' => gethostbyname(str_replace(array('http://','https://'),'',$input['url']))
		);
		
		$messages = array();
		$connections_array = array('http','https','dns');
		if(!$validator->isValidAdd($data)){
			foreach($connections_array as $connection){
				$errors = $validator->errors()->get($connection);
				if(count($errors)>0){
					$connections_array = array_diff($connections_array,array($connection));		
					$messages[$connection] = array('type'=>'error','message'=>$errors[0]);
				}
			}
		}
		
		foreach($connections_array as $valid){
			$host = $valid == 'dns' ? $data['dns'] : '';
			$url  = $valid == 'https' ? $data['https'] : $data['http'];
			$domain = $this->getDomainFromURLString($url);
			
			$option = json_encode( array( 
				'url_path' => $this->getPathFromURLString( $url )
			) );
		
			$insert_result = $this->siteInfo->insert(Sentry::getUser()->id,'',$valid,$domain,$url,$host,$option, time());
			if( $insert_result == 0){
				$inserted_check_id = $this->siteInfo->getMaxCheckId();
				
				foreach( $input['check_alert_email'] as $email ){
					$this->checkAlertEmail->insert( Sentry::getUser()->id, $inserted_check_id, $email );
				}
			
				$mongoId = $this->mongoAPI->saveSiteInfoToMongo( $valid, 'KUU-' . Sentry::getUser()->id . '-' . $inserted_check_id, $domain );
				if( $mongoId != '' ){
					$this->siteInfo->updateMongoIdByCheckId( $inserted_check_id, $mongoId );
				}
			}
			
			$messages[$valid] = array('type'=>'success','message'=>strtoupper($valid).' check was successfully added.');
		}

		return \Response::json(array('status'=>'OK','data'=>$messages));
	}
	
	public function deleteCheck(){
		$del_check_id = Input::get( 'del_check_id' );
		$del_mongo_id = Input::get( 'del_mongo_id' );
		
		$UserSiteInfo = new UserSiteInfo();
		$CheckAlertEmail = new CheckAlertEmail();
		
		if( $del_mongo_id != '' ){
			$this->mongoAPI->deleteCheckInMongo( $del_mongo_id );
		}
		
		$UserSiteInfo->deleteByCheckId( $del_check_id );
		$CheckAlertEmail->deleteDataByCheckId( $del_check_id );
	}
	
	public function suspendCheck(){
		$suspend_check_id = Input::get( 'suspend_check_id' );
		$suspend_mongo_id = Input::get( 'suspend_mongo_id' );
		$suspend_is_paused = Input::get( 'suspend_is_paused' );
		
		$UserSiteInfo = new UserSiteInfo();
		
		$checkinfo = $UserSiteInfo->getUserSiteInfoByCheckId( $suspend_check_id );
		
		if( $suspend_mongo_id != '' ){
			$this->mongoAPI->updateCheckInMongo( $suspend_mongo_id, $checkinfo['type'], 'KUU-' . Sentry::getUser()->id . '-' . $checkinfo['check_id'], $checkinfo['domain'], $suspend_is_paused );
		}
		
		$UserSiteInfo->suspendByCheckId( $suspend_check_id, $suspend_is_paused );
	}
	
	public function getDomainFromURLString( $url ){
		$parse = parse_url( $url );
		if( isset($parse['host']) ){
			return $parse['host'];
		}
		
		return -1;
	}
	
	public function getPathFromURLString( $url ){
		$parse = parse_url( $url );

		if( !isset($parse['path']) || ( isset($parse['path']) && $parse['path'] == '/' ) ){
			// return $parse['host'];
			return 'Homepage';
		} else {
			return substr( $parse['path'], 1, strlen( $parse['path'] ) - 1 );
		}
		
		return -1;
	}
	
	public function refresh(){
		$userSiteInfo = new UserSiteInfo();
		
		return \Response::make( $userSiteInfo->getRefreshContent( Sentry::getUser()->id ) );
	}
	
	public function getSiteInfo(){
		$input = \Input::all();
		
		$checkid = $input['check_id'];
		$mongoid = $input['mongo_id'];
		
		$site_info = $this->siteInfo->getUserSiteInfoByCheckId( $checkid );
		$alert_email_info = $this->checkAlertEmail->getDataByCheckId( $checkid );
		
		return \Response::json(array(
			'check_id' => $site_info['check_id'],
			'type' => $site_info['type'],
			'url' => $site_info['url'],
			'host' => $site_info['host'],
			'options' => $site_info['options'],
			'alert_email' => $alert_email_info
		));
	}
	
	public function editHTTPSiteInfo(){
		$input = \Input::all();
		
		$http_domain = $this->getDomainFromURLString( $input['http_url'] );
		$option = json_encode( array( 
			'phrases_to_match' => $input['http_phrases'],
			'url_path' => $this->getPathFromURLString( $input['http_url'] )
		) );
		
		$checkid = $input['checkid'];
		$mongoid = $input['mongoid'];
		
		$this->mongoAPI->updateCheckInMongo( $mongoid, 'http', 'KUU-' . Sentry::getUser()->id . '-' . $checkid, $http_domain, 0);			
		$this->siteInfo->updateByCheckId( Sentry::getUser()->id, $checkid, 'http', $http_domain, $input['http_url'],  '', $option );
		$this->checkAlertEmail->deleteDataByCheckId( $checkid );
		
		foreach(  $input['check_alert_email'] as $email ){
			$this->checkAlertEmail->insert( Sentry::getUser()->id, $checkid, $email );
		}
		
		return \Response::json(array('status'=>'OK'));
		// print_r( $input );
	}
	
	public function editHTTPSSiteInfo(){
		$input = \Input::all();
		
		$https_domain = $this->getDomainFromURLString( $input['https_url'] );
		$option = json_encode( array( 
			'phrases_to_match' => $input['https_phrases'],
			'url_path' => $this->getPathFromURLString( $input['https_url'] )
		) );
		
		$checkid = $input['checkid'];
		$mongoid = $input['mongoid'];
		
		$this->mongoAPI->updateCheckInMongo( $mongoid, 'https', 'KUU-' . Sentry::getUser()->id . '-' . $checkid, $https_domain, 0 );
		$this->siteInfo->updateByCheckId( Sentry::getUser()->id, $checkid, 'https', $https_domain, $input['https_url'],  '', $option );
		$this->checkAlertEmail->deleteDataByCheckId( $checkid );
		
		foreach(  $input['check_alert_email'] as $email ){
			$this->checkAlertEmail->insert( Sentry::getUser()->id, $checkid, $email );
		}
		
		return \Response::json(array('status'=>'OK'));
		// print_r( $input );
	}
	
	public function editDNSSiteInfo(){
		$input = \Input::all();
		
		$dns_domain = $input['dns_host_name'];
		$option = json_encode( array( 
			'url_path' => $dns_domain
		) );
		
		$checkid = $input['checkid'];
		$mongoid = $input['mongoid'];
		
		$this->mongoAPI->updateCheckInMongo( $mongoid, 'dns', 'KUU-' . Sentry::getUser()->id . '-' . $checkid, $dns_domain );
		$this->siteInfo->updateByCheckId( Sentry::getUser()->id, $checkid, 'dns', $dns_domain, $input['dns_host_name'],  '', $option );
		$this->checkAlertEmail->deleteDataByCheckId( $checkid );
		
		foreach(  $input['check_alert_email'] as $email ){
			$this->checkAlertEmail->insert( Sentry::getUser()->id, $checkid, $email );
		}
		
		return \Response::json(array('status'=>'OK'));
		// print_r( $input );
	}
}