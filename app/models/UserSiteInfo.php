<?php
class UserSiteInfo extends Eloquent{
	private $tb_nm;
	protected $table = 'checks';
	function __construct(array $attributes = array()){
		$query = "
			CREATE TABLE IF NOT EXISTS `{$this->table}` (
				`user_id` int(11) NOT NULL,
				`check_id` int(11) NOT NULL AUTO_INCREMENT,
				`mongo_id` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
				`type` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
				`domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`options` text COLLATE utf8_unicode_ci NOT NULL,
				`create_time` bigint(20) NOT NULL,
				`paused` tinyint(1) NOT NULL,
				PRIMARY KEY (`check_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		
		DB::statement($query);
	}
	
	function insert( $user_id, $mongo_id, $type, $domain, $url, $host, $options, $create_time ){
		$check_id = $this->isExistUserSiteInfo( $user_id, $type, $url );
		if( $check_id > 0 ){
			// $this->updateByCheckId( $user_id, $check_id , $type, $url, $host, $options );
			return $check_id;
		} else {
			$query = "INSERT INTO {$this->table} SET user_id={$user_id}, mongo_id='{$mongo_id}', type='{$type}', domain='{$domain}', url='{$url}', host='{$host}', options='{$options}', create_time={$create_time}";
			
			DB::statement($query);
			
			return 0;
		}
		
		return -1;
	}
	
	function suspendByCheckId( $checkId, $is_paused ){
		$query = "UPDATE {$this->table} SET paused={$is_paused} WHERE check_id={$checkId}";
		
		DB::statement( $query );
	}
	
	function updateByCheckId( $user_id, $check_id, $type, $domain, $url, $host, $options ){				
		$query = "UPDATE {$this->table} SET user_id={$user_id}, type='{$type}', domain='{$domain}', url='{$url}', host='{$host}', options='{$options}' WHERE check_id={$check_id}";
		
		DB::statement($query);
	}
	
	function updateMongoIdByCheckId( $check_id, $mongo_id ){
		$query = "UPDATE {$this->table} SET mongo_id='{$mongo_id}' WHERE check_id={$check_id}";
		
		DB::statement($query);
	}
	
	function isExistUserSiteInfo( $user_id, $type, $url ){
		$query = "SELECT check_id FROM {$this->table} WHERE user_id={$user_id} AND type='{$type}' AND url='{$url}'";
		
		$result = DB::select($query);

		if( isset( $result[0]->check_id ) ) return $result[0]->check_id;
		
		return -1;
	}
	
	function isExistUserSiteInfoByHost( $user_id, $type, $host ){
		return $this->where('user_id',$user_id)->where('type',$type)->where('host',$host)->first();
	}
	
	function getMaxCheckId(){
		$query = "SELECT MAX(check_id) as max_check_id FROM {$this->table}";
		
		$result = DB::select($query);
		
		if( isset( $result[0]->max_check_id ) ) return $result[0]->max_check_id;
		
		return -1;
	}
	
	function getDataByUserId( $user_id ){
		$query = "SELECT check_id, mongo_id, type, url, host, options FROM {$this->table} WHERE user_id={$user_id}";
		
		return DB::select( $query );
	}
	
	function getMongoIdByCheckId( $check_id ){
		$query = "SELECT mongo_id FROM {$this->table} WHERE check_id={$check_id}";
		
		return DB::select( $query );
	}
	
	function deleteByCheckId( $check_id ){
		$query = "DELETE FROM {$this->table} WHERE check_id={$check_id}";
		
		DB::delete( $query );
	}
	
	function deleteByUserId( $user_id ){
		$query = "DELETE FROM {$this->table} WHERE user_id={$user_id}";
		
		DB::delete( $query );
	}
	
	function getUserSiteInfo(){
		$user_id = Sentry::getUser()->id;
		
		$dataList = $this->getDataByUserId( $user_id );		
		
		$user_site_info = array();
		
		if( is_array( $dataList ) && count( $dataList ) > 0 ){
			foreach( $dataList as $data ){
				$item = array();
				
				$item['check_id'] = $data->check_id;
				$item['type'] = $data->type;
				$item['url'] = $data->url;
				$item['host'] = $data->host;
				$item['options'] = json_decode( $data->options );
				
				$user_site_info[$data->type] = $item;
			}
		}
		
		return $user_site_info;
	}
	
	
	function getUserSiteInfoByCheckId( $checkid ){
		$query = "SELECT check_id, mongo_id, type, domain, url, host, options FROM {$this->table} WHERE check_id={$checkid}";
		$dataList = DB::select( $query );
		
		$site_info = array();
		
		if( is_array( $dataList ) && count( $dataList ) > 0 ){
			$site_info['check_id'] = $dataList[0]->check_id;
			$site_info['type'] = $dataList[0]->type;
			$site_info['url'] = $dataList[0]->url;
			$site_info['host'] = $dataList[0]->host;
			$site_info['domain'] = $dataList[0]->domain;
			$site_info['options'] = json_decode( $dataList[0]->options );
		}
		
		return $site_info;
	}
	
	function getCheckSiteListByUserId( $user_id ){
		$kuu_config = Config::get('kuu');
		
		$ava_good = $kuu_config['ava_good'];
		$ava_not_good = $kuu_config['ava_not_good'];
		
		$query = "
			SELECT * FROM {$this->table} 
			WHERE user_id={$user_id} 
			ORDER BY domain, type
		";
		
		$result = DB::select( $query );
		
		$datalist = array();
		$data = array();
		$domain = '';
		$currentTime = time();
		
		$mongo_id_list_after_one_day = array();
		$mongo_id_list_less_one_day = array();
		
		foreach( $result as $row ){
			if( ( $currentTime - $row->create_time ) > 86400 ){
				$mongo_id_list_after_one_day[] = $row->mongo_id;
			} else {
				$mongo_id_list_less_one_day[] = $row->mongo_id;
			}
			
			if( $domain != $row->domain ){
				if( is_array( $data ) && count( $data ) > 0 && $domain != '' ){
					$datalist[ $domain ] = $data;
					$data = array();
				}
				
				$domain = $row->domain;
			}
			
			$option = json_decode( $row->options );
			
			$data[] = array(
				'passday' => intval( ($currentTime - $row->create_time) / ( 24 * 3600 ) ),
				'check_id' => $row->check_id,
				'mongo_id' => $row->mongo_id,
				'type' => $row->type,
				'host' => $row->host,
				'is_paused' => $row->paused,
				'url' => isset( $row->url ) ? $row->url : '',
				'path' => isset( $option->url_path ) ? strlen($option->url_path) > 20 ? substr($option->url_path, 0, 20) . '[...]' : $option->url_path : $row->domain,
			);
		}

		if( is_array( $data ) && count( $data ) > 0 && $domain != '' ){
			$datalist[ $domain ] = $data;
		}
		
		if( is_array( $datalist ) && count( $datalist ) > 0 ){
			$mongoAPI = new MongoAPI();
			$lastDayCheckStates = $mongoAPI->getMultiCheckLastDayStatus( $mongo_id_list_after_one_day, $mongo_id_list_less_one_day );	

			foreach( $datalist as &$domain ){
				foreach( $domain as &$data ){
					if( isset($lastDayCheckStates[$data['mongo_id']]) ){
						$check_value = array();
						$check_value['uptime'] = round( $lastDayCheckStates[$data['mongo_id']]->availability * 100 ) / 100;
						
						if( $check_value['uptime'] > 99 ){
							$check_value['uptime'] = round( $check_value['uptime'] * 10 ) / 10;
						} else {
							$check_value['uptime'] = floor( $check_value['uptime'] );
						}
						
						if( $check_value['uptime'] < $ava_not_good ) {
							$check_value['uptime_warning'] = true;
							$check_value['uptime_progress_class'] = 'progress-danger';
							$check_value['uptime_progress_val'] = '20';
						} else if( $check_value['uptime'] < $ava_good ) {
							$check_value['uptime_warning'] = false;
							$check_value['uptime_progress_class'] = 'progress-warning';
							$check_value['uptime_progress_val'] = '50';
						} else {
							$check_value['uptime_warning'] = false;
							$check_value['uptime_progress_class'] = 'progress-success';
							$check_value['uptime_progress_val'] = '100';
						}
						
						$check_value['response_speed'] = $lastDayCheckStates[$data['mongo_id']]->response_time;
						$temp_speed = ( 3000 - $check_value['response_speed'] ) / 3000 * 100;
						if( $check_value['response_speed'] < 1000 ) {
							$check_value['response_speed_text'] = 'Fast';
							$check_value['response_speed_warning'] = false;
							$check_value['response_speed_progress_class'] = 'progress-success';
						} else if( $check_value['response_speed'] < 2000 ) {
							$check_value['response_speed_text'] = 'Average';
							$check_value['response_speed_warning'] = false;
							$check_value['response_speed_progress_class'] = 'progress-warning';
						} else if( $check_value['response_speed'] < 3000 ){
							$check_value['response_speed_text'] = 'Too Slow';
							$check_value['response_speed_warning'] = true;
							$check_value['response_speed_progress_class'] = 'progress-danger';
						} else {
							$temp_speed = 0;
							
							$check_value['response_speed_text'] = 'Too Slow';
							$check_value['response_speed_warning'] = true;
							$check_value['response_speed_progress_class'] = 'progress-danger';
						}
						$check_value['response_speed'] = round( $temp_speed * 100 ) / 100;
						
						$data['check_value'] = $check_value;
					}
				}
			}
		}		
		return $datalist;
	}

	function getCheckSiteListForWalkthrough() {
		return array (
		  'example.com' => 
		  array (
		    0 => 
		    array (
		      'check_id' => 91,
		      'mongo_id' => '5368cf7e685fabd7490000ca',
		      'type' => 'dns',
		      'host' => '173.194.112.227',
		      'url' => 'http://example.com',
		      'path' => 'Homepage',
		      'passday' => 0,
		    ),
		    1 => 
		    array (
		      'check_id' => 89,
		      'mongo_id' => '5368cf7d685fabd7490000c8',
		      'type' => 'http',
		      'host' => '',
		      'url' => 'http://example.com',
		      'path' => 'Homepage',
		      'passday' => 0,
		      'check_value' => 
		      array (
		        'uptime' => 99.1,
		        'uptime_warning' => false,
		        'uptime_progress_class' => 'progress-success',
		        'response_speed' => 15.41,
		        'response_speed_text' => 'Slow',
		        'response_speed_warning' => true,
		        'response_speed_progress_class' => 'progress-danger',
		      ),
		    ),
		    
		  ),
		  'www.example.org' => 
		  array (
		    0 => 
		    array (
		      'check_id' => 44,
		      'mongo_id' => '5322c35e3cdffe992600009a',
		      'type' => 'http',
		      'host' => '',
		      'url' => 'http://example.org',
		      'path' => 'www.example.org',
		      'passday' => 0,
		      'check_value' => 
		      array (
		        'uptime' => 100,
		        'uptime_warning' => false,
		        'uptime_progress_class' => 'progress-success',
		        'response_speed' => 92.16,
		        'response_speed_text' => 'Fast',
		        'response_speed_warning' => false,
		        'response_speed_progress_class' => 'progress-success',
		      ),
		    ),
		    1 => 
		    array (
		      'check_id' => 45,
		      'mongo_id' => '5322c35e3cdffe992600009b',
		      'type' => 'https',
		      'host' => '',
		      'url' => 'https://example.org',
		      'path' => 'www.example.org',
		      'passday' => 0,
		      'check_value' => 
		      array (
		        'uptime' => 99.1,
		        'uptime_warning' => false,
		        'uptime_progress_class' => 'progress-success',
		        'response_speed' => 55.41,
		        'response_speed_text' => 'Average',
		        'response_speed_warning' => false,
		        'response_speed_progress_class' => 'progress-warning',
		      ),
		    ),
		  ),
		);
	}
	
	function getRefreshContent( $user_id ){
		$check_list = $this->getCheckSiteListByUserId( $user_id );
		$html = "";
		
		$index = 0;
		foreach( $check_list as $domain => $datalist ){
		
		$index++;
		
		$html .= '
		<div class="domain-section" id="domain-section-' . $index . '">
			<div class="row-fluid site-url-section">
				<div class="span12">
					<h5 id="site-url-section-'. $index .'">' . $domain . '</h5>
				</div>
			</div>
			<div class="clearfix"></div>';
			foreach( $datalist as $data ){
				$html .= '<div class="row-fluid site-data-section"  id="check_row_' . $data['check_id'] . '">
					<div class="row-fluid">
						<div class="span12 url-detail-title">
							<a href="' . $data['url'] . '" class="' . $data['type'] . '-label mytooltip bottom url-detail-title-' . $index . '" data-tool="' . $data['url'] . '" checktype="' . $data['type'] . '" mongoid="' . $data['mongo_id'] . '" checkid="' . $data['check_id'] . '" passday="' . $data['passday'] . '" is_paused="' . $data['is_paused'] . '">' . $data['path'] . '</a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<div class="row-fluid">
								<div class="span1">
								</div>
								<div class="span11">
									<span class="progress ' . (isset($data['check_value']['uptime_progress_class']) ?  $data['check_value']['uptime_progress_class'] : '') . '" style="display:block;">
										<span style="width: ' . ( isset($data['check_value']['uptime']) ? $data['check_value']['uptime'] : '0' ) . '%;" class="bar pull-right"></span>
									</span>
									<span class="task text-right">
										<span class="pull-right check-value-label">Availability</span>
										<span class="pull-right check-value-data ' . ( isset($data['check_value']['uptime_progress_class']) ? $data['check_value']['uptime_progress_class'] : '' ) . '">
											' . (isset($data['check_value']['uptime']) ? $data['check_value']['uptime'] . '%' : 'Data Not Available') . '
										</span>';
										if( isset($data['check_value']['uptime_warning']) && $data['check_value']['uptime_warning'] ){
										$html .= '<a href="#" class="pull-right fix-this-btn open_inner_page" main_id="dashboard" modal_id="contact-support">Fix This</a>';
										}
									$html .= '</span>
								</div>
							</div>
						</div>
						<div class="span6">
							<div class="row-fluid">
								<div class="span11">
									<span class="progress ' . ( isset($data['check_value']['response_speed_progress_class']) ? $data['check_value']['response_speed_progress_class'] : '' ) . '" style="display:block;">
										<span style="width: ' . ( isset($data['check_value']['response_speed']) ? $data['check_value']['response_speed'] : '0' ) . '%;" class="bar"></span>
									</span>
									<span class="task">
										<span class="check-value-label">Response Speed</span>
										<span class="check-value-data ' . ( isset($data['check_value']['response_speed_progress_class']) ? $data['check_value']['response_speed_progress_class'] : '' ) . '">' .
											(isset($data['check_value']['response_speed_text']) ? $data['check_value']['response_speed_text'] : 'Data Not Available') . '
										</span>';
										if( isset($data['check_value']['response_speed_warning']) && $data['check_value']['response_speed_warning'] ){
										$html .= '<a href="#" class="fix-this-btn open_inner_page" main_id="dashboard" modal_id="contact-support">Fix This</a>';
										}
									$html .= '</span>
								</div>
								<div class="span1">
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
			$html .= '<div class="clearfix"></div>
			<div class="row-fluid detail-section">
				<div class="span12">
					<a class="see_detail_btn" href="" data-index="' . $index . '">See Details</a>
				</div>
			</div>
		</div>';
		}
						
		return $html;
	}
}