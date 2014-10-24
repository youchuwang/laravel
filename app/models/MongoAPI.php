<?php
class MongoAPI extends Eloquent{
	private $monogoServer;
	private $apiKey;
	private $alert_threshold;
	private $response_threshold;
	private $interval;
	
	function __construct(array $attributes = array()){
		$kuu_config = Config::get('kuu');
		
		$this->monogoServer			= $kuu_config['apiurl'];
		$this->apiKey				= $kuu_config['apikey'];
		$this->alert_threshold		= $kuu_config['alert_threshold'];
		$this->response_threshold	= $kuu_config['response_threshold'];
		$this->interval				= $kuu_config['interval'];
	}
	
	public function saveSiteInfoToMongo( $check_type, $check_name, $check_url ){
		$curl = curl_init();

		// if type=dns, add default dns server 8.8.8.8 (google dns) to url
		if ($check_type == "dns")
			$check_url = "8.8.8.8/" . $check_url;

		$data = "type={$check_type}&name={$check_name}&url={$check_url}&alert_threshold=3&response_threshold=50000&interval=300";

		curl_setopt( $curl, CURLOPT_URL, "{$this->monogoServer}/rest/createcheck?api_key={$this->apiKey}" );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );

		$resp = curl_exec( $curl );
		curl_close( $curl );
		
		if( $resp == '' ){
			return '';
		}
		
		$json_resp = json_decode( $resp );
		
		if( $json_resp->Result == "OK" && isset( $json_resp->Record->_id ) && $json_resp->Record->_id != '' ){
			return $json_resp->Record->_id;
		}
		
		return '';
	}
	
	public function deleteCheckInMongo( $mongo_id ){
		$curl = curl_init();

		$data = "_id={$mongo_id}";

		curl_setopt( $curl, CURLOPT_URL, "{$this->monogoServer}/rest/deletecheck?api_key={$this->apiKey}" );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );

		$resp = curl_exec( $curl );
		curl_close( $curl );
		
		return $resp;
	}
	
	public function updateCheckInMongo( $mongo_id, $type, $name, $url, $is_paused ){		
		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, "{$this->monogoServer}/rest/updatecheck?api_key={$this->apiKey}");
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );

		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, "_id={$mongo_id}&type={$type}&name={$name}&url={$url}&alert_threshold=3&response_threshold=5000&interval=300&is_paused={$is_paused}" );

		$resp = curl_exec( $curl );
		curl_close( $curl );
	}
	
	function getServerModelData( $mongo_id, $period ){	
		// $mongo_id = '52fe2d4caa82d6d6c5f25a82';
		$time_span = '';
		$count = '';
		if( $period == 'day' ){
			$time_span = 'hour';
			$count = '24';
		} else if( $period == 'week' ){
			$time_span = 'day';
			$count = '7';
		} else if( $period == 'month' ){
			$time_span = 'day';
			$count = '28';
		} else if( $period == 'months' ){
			$time_span = 'week';
			$count = '12';
		}
		
		$curl = curl_init();
		
		$data = "&check_id={$mongo_id}&time_span={$time_span}&count={$count}";
		
		curl_setopt( $curl, CURLOPT_URL, "{$this->monogoServer}/rest/getstats?api_key={$this->apiKey}" . $data );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );
		
		$resp = curl_exec( $curl );
		curl_close( $curl );
		
		return $resp;
	}
	
	function getMultiCheckLastDayStatus( $mongo_id_list_after_one_day, $mongo_id_list_less_one_day ){	
		$datalist = array();
		
		if(  is_array( $mongo_id_list_after_one_day ) && count(  $mongo_id_list_after_one_day ) > 0 ){
			$curl = curl_init();
			$data = "&time_span=day&count=1";
			$mongo_id_str = "";
			
			foreach( $mongo_id_list_after_one_day as $mongo_id ){
				if( $mongo_id_str != "" ) $mongo_id_str .= "&";
				$mongo_id_str .= "check_ids[]=" . $mongo_id;
			}
			
			curl_setopt( $curl, CURLOPT_URL, "{$this->monogoServer}/rest/getstats?api_key={$this->apiKey}" . $data );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
			curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );
			
			curl_setopt( $curl, CURLOPT_POST, 1 );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $mongo_id_str );
			
			$resp = curl_exec( $curl );
			curl_close( $curl );
			
			$resp_result = json_decode( $resp );
			
			// echo '<pre>';print_r( $resp_result );echo '</pre>';
			
			
			foreach( $resp_result as $res ){
				if( $res->Result == "OK" && is_array($res->Records) && count($res->Records) > 0 ){				
					$datalist[$res->Records[0]->check_id] = $res->Records[0];
				}
			}
			
			// echo '<pre>';print_r( $datalist );echo '</pre>';
		}
		
		if(  is_array( $mongo_id_list_less_one_day ) && count(  $mongo_id_list_less_one_day ) > 0 ){
			$curl = curl_init();
			$data = "&time_span=hour&count=1";
			$mongo_id_str = "";
			
			foreach( $mongo_id_list_less_one_day as $mongo_id ){
				if( $mongo_id_str != "" ) $mongo_id_str .= "&";
				$mongo_id_str .= "check_ids[]=" . $mongo_id;
			}
			
			curl_setopt( $curl, CURLOPT_URL, "{$this->monogoServer}/rest/getstats?api_key={$this->apiKey}" . $data );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
			curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );
			
			curl_setopt( $curl, CURLOPT_POST, 1 );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $mongo_id_str );
			
			$resp = curl_exec( $curl );
			curl_close( $curl );
			
			$resp_result = json_decode( $resp );
			
			// echo '<pre>';print_r( $resp_result );echo '</pre>';
			
			
			foreach( $resp_result as $res ){
				if( $res->Result == "OK" && is_array($res->Records) && count($res->Records) > 0 ){				
					$datalist[$res->Records[0]->check_id] = $res->Records[0];
				}
			}
			
			// echo '<pre>';print_r( $datalist );echo '</pre>';
		}
		
		return $datalist;
	}
}
