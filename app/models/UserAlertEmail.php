<?php
class UserAlertEmail extends Eloquent{
	private $tb_nm;
	
	function __construct( $tablename = 'useralertemail' ){
		$this->tb_nm = $tablename;
		
		$query = "
			CREATE TABLE IF NOT EXISTS `{$this->tb_nm}` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`userid` int(11) NOT NULL,
				`alertemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				`activated` tinyint(1) NOT NULL DEFAULT '0',
				`activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
				`activated_at` timestamp NULL DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `userid` (`userid`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		
		DB::statement($query);
	}
	
	function insert( $userid, $useralertemail ){
		$query = "INSERT INTO {$this->tb_nm} SET userid={$userid}, alertemail='{$useralertemail}', activation_code='" . Str::random(32) . "' ";
		
		DB::statement($query);
	}
	
	function getDataByUserId( $userid ){
		$query = "SELECT * FROM {$this->tb_nm} WHERE userid={$userid}";
		
		return DB::select( $query );
	}
	
	function getOnlyConfirmDataByUserId( $userid ){
		$query = "SELECT * FROM {$this->tb_nm} WHERE userid={$userid} AND activated=1";
		
		return DB::select( $query );
	}
	
	function getDataByAlertEmailId( $alertEmailId ){
		$query = "SELECT * FROM {$this->tb_nm} WHERE id={$alertEmailId}";
		$result = DB::select( $query );
		
		return $result[0];
	}
	
	function deleteById( $delid ){
		$query = "DELETE FROM {$this->tb_nm} WHERE id={$delid}";
		
		DB::delete( $query );
	}
	
	function getMaxId(){
		$query = "SELECT MAX(id) as max_id FROM {$this->tb_nm}";
		$result = DB::select( $query );
		
		return $result[0]->max_id;
	}
	
	function activate( $id, $code ){
		$query = "SELECT * FROM {$this->tb_nm} WHERE id={$id} AND activation_code='{$code}'";
		$result = DB::select( $query );
		if( count( $result ) > 0 ){
			$query = "UPDATE {$this->tb_nm} SET activated=1 WHERE id={$id} AND activation_code='{$code}'";
			DB::statement( $query );
			
			$data = array(
				'success' => true,
				'message' => 'successfully verify your alert email'
			);
			
			return $data;
		}
		
		$data = array(
			'message' => 'Invalid verify'
		);
		
		return $data;
	}
}
