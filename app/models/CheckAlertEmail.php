<?php
class CheckAlertEmail extends Eloquent{
	protected $table = 'checks_alert_email';
	public $timestamps = false;
	
	function __construct(array $attributes = array()){
		$query = "
			CREATE TABLE IF NOT EXISTS `{$this->table}` (
				`user_id` int(11) NOT NULL,
				`check_id` int(11) NOT NULL,
				`alert_id` int(11) NOT NULL AUTO_INCREMENT,
				`alert_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
				PRIMARY KEY (`alert_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		";
		
		DB::statement($query);
	}
	
	function insert( $user_id, $check_id, $alert_email ){
		$query = "INSERT INTO {$this->table} SET user_id={$user_id}, check_id='{$check_id}', alert_email='{$alert_email}'";
		
		DB::statement($query);
	}
	
	function deleteDataByCheckId( $check_id ){
		$query = "DELETE FROM {$this->table} WHERE check_id={$check_id}";
		
		DB::delete( $query );
	}
	
	function getDataByCheckId( $check_id ){
		$query = "SELECT * FROM {$this->table} WHERE check_id={$check_id} ORDER BY alert_email";
		
		return DB::select( $query );
	}

	static function getAlertEmailsByMongoId( $mongo_id ) {
		return DB::select('SELECT * FROM checks LEFT JOIN checks_alert_email USING (check_id) 
			LEFT JOIN users ON checks_alert_email.user_id=users.id WHERE mongo_id = ?',
			array($mongo_id));	
	}
}