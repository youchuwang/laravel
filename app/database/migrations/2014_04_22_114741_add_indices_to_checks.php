<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndicesToChecks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('checks', function($table)
		{
			$table->index('mongo_id');
		});	

		Schema::table('checks_alert_email', function($table)
		{
			$table->index('check_id');
			$table->index('user_id');
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('checks', function($table)
		{
			$table->dropIndex('checks_mongo_id_index');
		});	

		Schema::table('checks_alert_email', function($table)
		{
			$table->dropIndex('checks_alert_email_check_id_index');
			$table->dropIndex('checks_alert_email_user_id_index');
		});	
	}

}
