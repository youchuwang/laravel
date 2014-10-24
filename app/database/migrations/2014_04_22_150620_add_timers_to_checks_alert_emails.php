<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimersToChecksAlertEmails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('checks_alert_email', function($table)
		{
			$table->dateTime('last_sent')->default('0000-00-00 00:00:00');
			$table->integer('times_sent')->default('0');
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('checks_alert_email', function($table)
		{
			$table->dropColumn('last_sent');
			$table->dropColumn('times_sent');
		});	
	}

}
