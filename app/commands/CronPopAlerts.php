<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CronPopAlerts extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:CronPopAlerts';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks pop alerts API and mails results.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$reset_inverval = 60*60*24; // one day

		$api_key = 'c3RhY2tvdmVyZmxvdy5';
		$count = 1;
		$url = 'http://54.196.143.144:8000/rest/popalerts?api_key='.$api_key.'&count='.$count;

		$alert_intervals = array(5*60, 10*60, 30*60, 60*60, 2*60*60, 2*60*60, 8*60*60);

		$browser = new Buzz\Browser();
		$response = $browser->get($url);

		$response_array = json_decode($response->getContent());
		//$checkAlertEmail = new CheckAlertEmail();

		if(isset($response_array->Result) && $response_array->Result == 'OK') {

			$mail_counter = 0;

			foreach ($response_array->Records as $record_id => $record) {
				$record->time_formatted =  date("m/d H:i:s T", $record->timestamp - $record->downtime);
				$record->title = 'Site is '.Str::title($record->type);
				//$this->info('Record '.print_r($record, TRUE));

				$alert_emails = CheckAlertEmail::getAlertEmailsByMongoId($record->check_id);
//				$alert_emails = CheckAlertEmail::getAlertEmailsByMongoId('5357d420685fabd7490000a4');


				//DB::select('SELECT * FROM checks LEFT JOIN checks_alert_email USING (check_id) 
				//	LEFT JOIN users ON checks_alert_email.user_id=users.id WHERE mongo_id = ?', 
				//	array('5322c33f3cdffe9926000099'));
				//	array($record->check_id));

				foreach ($alert_emails as $id => $email) {

					//$this->info('Alert email '.print_r($alert_emails, TRUE));

					$since_last_time = time() - strtotime($email->last_sent);
					$times_sent = $since_last_time > $reset_inverval ? 1 : $email->times_sent;
					$current_interval = $alert_intervals[min($times_sent - 1, 6)];
					//$this->info('since_last_time '.$since_last_time.' '.$times_sent.' '.$current_interval);

					if($since_last_time >= $current_interval) {

						//$this->info($email->alert_email.' '.$email->first_name.' '.$email->last_name);
						$record->alert_email = $email;
						Mail::send('emails.cronalert', (array)$record, function($message) use ($email)
						{						
							$message->from('noreply@dev.keepusup.com', 'KeepUsUp');
						    $message->to($email->alert_email, $email->first_name.' '.$email->last_name)
						    	->subject('Alerts')
						    	->cc('harrison.hung@gmail.com')
						    	->cc('andrei.tsygankov@gmail.com');
						    //$message->to('andrei.tsygankov@gmail.com', 'Andrei Tsygankov')->subject('Alerts');

						});
						$mail_counter++;

						if($record->downtime == 'down') {
							CheckAlertEmail::where('alert_id', $email->alert_id)->update(
								array(
									'last_sent' => gmdate("Y-m-d H:i:s"),
									'times_sent' => $times_sent + 1
									));
						}
						else {
							CheckAlertEmail::where('alert_id', $email->alert_id)->update(
								array(
									'last_sent' => '0000-00-00 00:00:00',
									'times_sent' => 0
									));
						}
					}
				}

				// just send to admin
				/*
				if(!count($alert_emails)) {
					Mail::send('emails.cronalert', (array)$record, function($message)
					{
						$message->from('noreply@dev.keepusup.com', 'KeepUsUp');
					    $message->to('andrei.tsygankov@gmail.com', 'Admin')
					    	->subject('Alerts')					    	
					    	//->cc('harrison.hung@gmail.com')
					    	;
					});
					$mail_counter++;
				}
				*/
				
			}
			$this->info('Successfully sent '.$mail_counter.' emails');
		}
		else {
			if(isset($response_array->Result))
				$this->info('Failed with result='.$response_array->Result);
			else
				$this->info('Failed with to fetch REST API data');
		}
		
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		//	array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
