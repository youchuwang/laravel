<?php

class ContactsController extends Controller {

	public function send(){
		//check if its our form
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
				'err' => 1,
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
		
		$name = Input::get( 'name' );
        $email = Input::get( 'email' );
        $category = Input::get( 'category' );
        $message_content = Input::get( 'message' );
		
		$mail_config = Config::get('mail');
		
		$toEamil = $mail_config['from']['address'];
		$toName = "Keep us up";
		
		Mail::send('contact.mails.support', array( 'message_content' => $message_content ), function( $message ) use ($toEamil, $toName){
			$message->from(Input::get( 'email' ), Input::get( 'name' ));
			$message->to($toEamil, $toName);
			$message->subject('Hello, KeepUsUp manager!');
		});
	
		return Response::json( array(
			'err' => 0
		) );
	}
	
	function contactSupport(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
				
		$data_model = array(
			'useremail' 	=> Sentry::getUser()->email,
			'first_name' 	=> Sentry::getUser()->first_name,
			'last_name' 	=> Sentry::getUser()->last_name,
		);
		
		return View::make('dashboard.contact-support', $data_model);
	}
}