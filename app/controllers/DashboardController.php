<?php
class DashboardController extends BaseController {
	public function index(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}		
		
		$UserSiteInfo = new UserSiteInfo();
		$userAlertEmail = new UserAlertEmail();
		
		$data_model = array(
			'user_id' 		=> Sentry::getUser()->id,
			'check_list'	=> $UserSiteInfo->getCheckSiteListByUserId( Sentry::getUser()->id ),
			'usealertemail' => $userAlertEmail->getDataByUserId( Sentry::getUser()->id ),
			'useremail' 	=> Sentry::getUser()->email,
		);
		
		return View::make('dashboard.index', $data_model);
	}
	
	public function getGraphData(){
		$user_id = Sentry::getUser()->id;
		$period = Input::get( 'check_report_period' );
		$mongo_id = Input::get( 'report_mongo_id' );
		$check_id = Input::get( 'report_check_id' );
		
		$mongoAPI = new MongoAPI();
		$checkAlertEmail = new CheckAlertEmail();
		
		$data = json_decode( $mongoAPI->getServerModelData( $mongo_id, $period ), true );
		$data['alert'] = $checkAlertEmail->getDataByCheckId( $check_id );
		
		return Response::json( $data );
	}

	public function walkthrough(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		$UserSiteInfo = new UserSiteInfo();
		$userAlertEmail = new UserAlertEmail();
		
		$data_model = array(
			'user_id' 		=> Sentry::getUser()->id,
			'check_list'	=> $UserSiteInfo->getCheckSiteListForWalkthrough(),
			'usealertemail' => $userAlertEmail->getDataByUserId( Sentry::getUser()->id ),
			'useremail' 	=> Sentry::getUser()->email,			
		);
		
		return View::make('dashboard.walkthrough', $data_model);
	}

	public function getGraphDataWalkthrough(){
		$data = array (
		  'Result' => 'OK',
		  'Records' => 
		  array (
		    0 => 
			    array (
			      'check_id' => '5368cf7e685fabd7490000ca',
			      'availability' => 0.2,
			      'down_time' => 86400,
			      'response_time' => 0.58560606060606,
			      'responsiveness' => 100,
			      'timestamp' => 1399853401,
			      'outages' => 
			      array (),
			      '_id' => '53701159d1eca36357d1daf1',
			    ),
			    1 => 
			    array (
			      'check_id' => '5368cf7e685fabd7490000ca',
			      'availability' => 0.5,
			      'down_time' => 86400,
			      'response_time' => 0.67295875420875,
			      'responsiveness' => 100,
			      'timestamp' => 1399767001,
			      'outages' => 
			      array (),
			      '_id' => '536ebfd9d1eca36357d1d32a',
			    ),
			    2 => 
			    array (
			      'check_id' => '5368cf7e685fabd7490000ca',
			      'availability' => 1,
			      'down_time' => 86400,
			      'response_time' => 0.90850168350168,
			      'responsiveness' => 100,
			      'timestamp' => 1399680601,
			      'outages' => 
			      array (),
			      '_id' => '536d6e59d1eca36357d1cd8b',
			    ),
			    3 => 
			    array (
			      'check_id' => '5368cf7e685fabd7490000ca',
			      'availability' => 0.7,
			      'down_time' => 86400,
			      'response_time' => 0.97718855218855,
			      'responsiveness' => 100,
			      'timestamp' => 1399594201,
			      'outages' => 
			      array (),
			      '_id' => '536c1cd9d1eca36357d1c9b2',
			    ),
			    4 => 
			    array (
			      'check_id' => '5368cf7e685fabd7490000ca',
			      'availability' => 0.3,
			      'down_time' => 86400,
			      'response_time' => 0.73670033670034,
			      'responsiveness' => 100,
			      'timestamp' => 1399507801,
			      'outages' => 
			      array (),
			      '_id' => '536acb59d1eca36357d1c4ee',
			    ),
			    5 => 
			    array (
			      'check_id' => '5368cf7e685fabd7490000ca',
			      'availability' => 0,
			      'down_time' => 43200,
			      'response_time' => 0.70151515151515,
			      'responsiveness' => 100,
			      'timestamp' => 1399421401,
			      'outages' => 
			      array (),
			      '_id' => '536979d9d1eca36357d1bfe6',
			    ),
			),		    
		  'alert' => 
		  array (
		    0 => 
		    array(
		       'user_id' => 3,
		       'check_id' => 91,
		       'alert_id' => 9,
		       'alert_email' => 'example@example.org',
		    ),
		    1 => 
		    array(
		       'user_id' => 3,
		       'check_id' => 91,
		       'alert_id' => 19,
		       'alert_email' => 'example2@example.org',
		    ),
		    2 => 
		    array(
		       'user_id' => 3,
		       'check_id' => 91,
		       'alert_id' => 19,
		       'alert_email' => 'example3@example.org',
		    ),
		  ),
		);
		
		return Response::json( $data );
	}
}

	
