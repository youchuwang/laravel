<?php

use Authority\Repo\User\UserInterface;
use Authority\Repo\Group\GroupInterface;
use Authority\Service\Form\Register\RegisterForm;
use Authority\Service\Form\User\UserForm;
use Authority\Service\Form\ResendActivation\ResendActivationForm;
use Authority\Service\Form\ForgotPassword\ForgotPasswordForm;
use Authority\Service\Form\ChangePassword\ChangePasswordForm;
use Authority\Service\Form\SuspendUser\SuspendUserForm;

class UserController extends BaseController {

	protected $user;
	protected $group;
	protected $registerForm;
	protected $userForm;
	protected $resendActivationForm;
	protected $forgotPasswordForm;
	protected $changePasswordForm;
	protected $suspendUserForm;

	/**
	 * Instantiate a new UserController
	 */
	public function __construct(
		UserInterface $user, 
		GroupInterface $group, 
		RegisterForm $registerForm, 
		UserForm $userForm,
		ResendActivationForm $resendActivationForm,
		ForgotPasswordForm $forgotPasswordForm,
		ChangePasswordForm $changePasswordForm,
		SuspendUserForm $suspendUserForm
		)
	{
		$this->user = $user;
		$this->group = $group;
		$this->registerForm = $registerForm;
		$this->userForm = $userForm;
		$this->resendActivationForm = $resendActivationForm;
		$this->forgotPasswordForm = $forgotPasswordForm;
		$this->changePasswordForm = $changePasswordForm;
		$this->suspendUserForm = $suspendUserForm;

		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

		// Set up Auth Filters
		$this->beforeFilter('auth', array('only' => array('change')));
		$this->beforeFilter('inGroup:Admins', array('only' => array('show', 'index', 'destroy', 'suspend', 'unsuspend', 'ban', 'unban', 'edit', 'update')));
		//array('except' => array('create', 'store', 'activate', 'resend', 'forgot', 'reset')));
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = $this->user->all();
      
        return View::make('users.index')->with('users', $users);
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('users.create');
	}

	/**
	 * Store a newly created user.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Form Processing		
        $result = $this->registerForm->save( Input::all() );
		
        if( $result['success'] )
        {
            Event::fire('user.signup', array(
            	'email' => $result['mailData']['email'], 
            	'userId' => $result['mailData']['userId'], 
                'activationCode' => $result['mailData']['activationCode']
            ));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@create')
                ->withInput()
                ->withErrors( $this->registerForm->errors() );
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = $this->user->byId($id);

        if($user == null || !is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        return View::make('users.show')->with('user', $user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = $this->user->byId($id);

        if($user == null || !is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $currentGroups = $user->getGroups()->toArray();
        $userGroups = array();
        foreach ($currentGroups as $group) {
        	array_push($userGroups, $group['name']);
        }
        $allGroups = $this->group->all();

        return View::make('users.edit')->with('user', $user)->with('userGroups', $userGroups)->with('allGroups', $allGroups);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		// Form Processing
        $result = $this->userForm->update( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('UserController@show', array($id));

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@edit', array($id))
                ->withInput()
                ->withErrors( $this->userForm->errors() );
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		if ($this->user->destroy($id))
		{
			Session::flash('success', 'User Deleted');
            return Redirect::to('/users');
        }
        else 
        {
        	Session::flash('error', 'Unable to Delete User');
            return Redirect::to('/users');
        }
	}

	/**
	 * Activate a new user
	 * @param  int $id   
	 * @param  string $code 
	 * @return Response
	 */
	public function activate($id, $code)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		$result = $this->user->activate($id, $code);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
	}

	/**
	 * Process resend activation request
	 * @return Response
	 */
	public function resend()
	{
		// Form Processing
        $result = $this->resendActivationForm->resend( Input::all() );

        if( $result['success'] )
        {
            Event::fire('user.resend', array(
				'email' => $result['mailData']['email'], 
				'userId' => $result['mailData']['userId'], 
				'activationCode' => $result['mailData']['activationCode']
			));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } 
        else 
        {
            Session::flash('error', $result['message']);
            return Redirect::route('profile')
                ->withInput()
                ->withErrors( $this->resendActivationForm->errors() );
        }
	}

	/**
	 * Process Forgot Password request
	 * @return Response
	 */
	public function forgot()
	{
		// Form Processing
        $result = $this->forgotPasswordForm->forgot( Input::all() );

        if( $result['success'] )
        {
            Event::fire('user.forgot', array(
				'email' => $result['mailData']['email'],
				'userId' => $result['mailData']['userId'],
				'resetCode' => $result['mailData']['resetCode']
			));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } 
        else 
        {
            Session::flash('error', $result['message']);
            return Redirect::route('forgotPasswordForm')
                ->withInput()
                ->withErrors( $this->forgotPasswordForm->errors() );
        }
	}

	/**
	 * Process a password reset request link
	 * @param  [type] $id   [description]
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	public function reset($id, $code)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		$result = $this->user->resetPassword($id, $code);

        if( $result['success'] )
        {
            Event::fire('user.newpassword', array(
				'email' => $result['mailData']['email'],
				'newPassword' => $result['mailData']['newPassword']
			));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
	}

	/**
	 * Process a password change request
	 * @param  int $id 
	 * @return redirect     
	 */
	public function change($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		$data = Input::all();
		$data['id'] = $id;

		// Form Processing
        $result = $this->changePasswordForm->change( $data );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } 
        else 
        {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@edit', array($id))
                ->withInput()
                ->withErrors( $this->changePasswordForm->errors() );
        }
	}

	/**
	 * Process a suspend user request
	 * @param  int $id 
	 * @return Redirect     
	 */
	public function suspend($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		// Form Processing
        $result = $this->suspendUserForm->suspend( Input::all() );

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('UserController@suspend', array($id))
                ->withInput()
                ->withErrors( $this->suspendUserForm->errors() );
        }
	}

	/**
	 * Unsuspend user
	 * @param  int $id 
	 * @return Redirect     
	 */
	public function unsuspend($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		$result = $this->user->unSuspend($id);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('users');
        }
	}

	/**
	 * Ban a user
	 * @param  int $id 
	 * @return Redirect     
	 */
	public function ban($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

		$result = $this->user->ban($id);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('users');
        }
	}

	public function unban($id)
	{
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        
		$result = $this->user->unBan($id);

        if( $result['success'] )
        {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('users');
        }
	}

	public function accountpage(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}

		$userAlertEmail = new UserAlertEmail();		
		
		$data_model = array(
			'user_id' 			=> Sentry::getUser()->id,
			'first_name' 		=> Sentry::getUser()->first_name,
			'last_name' 		=> Sentry::getUser()->last_name,
			'email' 			=> Sentry::getUser()->email,
			'usealertemail' 	=> $userAlertEmail->getDataByUserId( Sentry::getUser()->id ),
			'useremail' 		=> Sentry::getUser()->email
		);
			
		return View::make('dashboard.account', $data_model);
	}
	
	public function accountpageupdate_personal(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
				'err' => 1,
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
		
		try{
			$user_id = Input::get( 'userid' );
			$user = Sentry::findUserById( $user_id );
			
			$user->first_name = Input::get( 'firstname' );
			$user->last_name = Input::get( 'lastname' );
			$user->email = Input::get( 'email' );
			
			if ( $user->save() ){
				Session::flash('success', '<strong>Successfully</strong> Updated.');
			} else {
				Session::flash('error', '<strong>Error</strong> happen.');
			}
		} catch (Cartalyst\Sentry\Users\UserExistsException $e) {
			Session::flash('duplicateemail', '<strong>' . Input::get( 'email' ) . '</strong> already exists.');
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			echo 'User was not found.';
		}
		
		return Redirect::to('account');
	}
	
	public function accountpageupdate_password(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
				'err' => 1,
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
		
		try{			
			$current_password = Input::get( 'currentpassword' );
			$user_email = Sentry::getUser()->email;
			
			try{
				$credentials = array(
					'email' => $user_email,
					'password' => $current_password
				);
		
				$user = Sentry::authenticate( $credentials );
				
				// $user_id = Input::get( 'userid' );
				// $user = Sentry::findUserById( $user_id );
				
				if( Input::get( 'newpassword' ) != '' ) {
					$user->password = Input::get( 'newpassword' );
				}
				
				if ( $user->save() ){
					Session::flash('success', '<strong>Successfully</strong> Updated.');
				} else {
					Session::flash('error', '<strong>Error</strong> happen.');
				}
			} catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
				Session::flash('error', '<strong>Current Password</strong> does not match.');
			} catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
				Session::flash('error', '<strong>Current Password</strong> does not match.');
			} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
				Session::flash('error', '<strong>Current Password</strong> does not match.');
			} catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
				Session::flash('error', '<strong>Current Password</strong> does not match.');
			} catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
				Session::flash('error', '<strong>Current Password</strong> does not match.');
			}
		} catch (Cartalyst\Sentry\Users\UserExistsException $e) {
			Session::flash('duplicateemail', '<strong>' . Input::get( 'email' ) . '</strong> already exists.');
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			echo 'User was not found.';
		}
		
		return Redirect::to('account');
	}
	
	public function addAccountAlertEmail(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
				'err' => 1,
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
		
		$user_id = Input::get( 'userid' );
		$alert_email = Input::get( 'alertemail' );
		
		$userAlertEmail = new UserAlertEmail();
		$userAlertEmail->insert( $user_id, $alert_email );
		$confirm_id = $userAlertEmail->getMaxId();
		$alertEmailData = $userAlertEmail->getDataByAlertEmailId( $confirm_id );
		
		$email = $alertEmailData->alertemail;
		$subject = 'Confirm your alert email';
		$view = 'emails.auth.confirmalertemail';
		$data = array();
		$data['alertEmailId'] = $alertEmailData->id;
		$data['activationCode'] = $alertEmailData->activation_code;
		$data['email'] = $alertEmailData->alertemail;
		
		Mail::queue($view, $data, function($message) use($email, $subject)
		{
			$message->to($email)
					->subject($subject);
		});
		
		return Redirect::to('account');
	}
	
	public function deleteAccountAlertEmail(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
				'err' => 1,
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
		
		$delid = Input::get( 'delid' );
		
		$userAlertEmail = new UserAlertEmail();
		$userAlertEmail->deleteById( $delid );
		
		return Redirect::to('account');
	}
	
	public function contactSupport(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		$data_model = array(
			'user_id' 			=> Sentry::getUser()->id,
			'first_name' 		=> Sentry::getUser()->first_name,
			'last_name' 		=> Sentry::getUser()->last_name,
			'email' 			=> Sentry::getUser()->email
		);
			
		return View::make('dashboard.contact-support', $data_model);
	}
	
	public function sendConfirmAccountAlertEmail(){
		if( !Sentry::check() ) {
			return Redirect::to('login');
		}
		
		if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
				'err' => 1,
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
		
		$userAlertEmail = new UserAlertEmail();
		$alertEmailData = $userAlertEmail->getDataByAlertEmailId( Input::get( 'confirm_id' ) );
		
		$email = $alertEmailData->alertemail;
		$subject = 'Confirm your alert email';
		$view = 'emails.auth.confirmalertemail';
		$data = array();
		$data['alertEmailId'] = $alertEmailData->id;
		$data['activationCode'] = $alertEmailData->activation_code;
		$data['email'] = $alertEmailData->alertemail;
		
		Mail::queue($view, $data, function($message) use($email, $subject)
		{
			$message->to($email)
					->subject($subject);
		});
	}
	
	function activateAlertEmail($id, $code){
        if(!is_numeric($id))
        {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
		
		$userAlertEmail = new UserAlertEmail();
		$result = $userAlertEmail->activate( $id, $code );

        if( $result['success'] ){
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::route('home');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::route('home');
        }
	}
}

	
