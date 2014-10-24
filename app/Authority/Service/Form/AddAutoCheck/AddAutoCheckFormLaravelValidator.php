<?php namespace Authority\Service\Form\AddAutoCheck;

use Authority\Service\Validation\AbstractLaravelValidator;
use Authority\Repo\User\UserInterface;
use Illuminate\Validation\Factory;
class AddAutoCheckFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'http' => 'required|http_exists|in_database',
		'https' => 'https_exists|in_database',
		'dns' =>'ip|ip_exists|in_database'
	);

	protected $messages = array(
		'dns.ip'=>'Could not resolve an IP from provided hostname.',
		'http.in_database' =>'This HTTP address currently exists in database.',
		'https.in_database' => 'This HTTPS address currently exists in database.',
		'dns.in_database' =>'This DNS address currently exists in database.'

		);
	public function __construct(Factory $validator,\UserSiteInfo $siteInfo,UserInterface $user){
		parent::__construct($validator);
		$this->user = $user;
		$this->siteInfo = $siteInfo;
		$this->registerCustomValidators();
	}
	/**
	 * three validators added to check for each type of connection
	 * @return void
	 */
	public function registerCustomValidators()
	{
		$this->validator->extend('http_exists', function($attribute,$value,$parameters) {
			return !in_array($this->sendCurlRequest($value),array(404,0));
		});
		$this->validator->extend('https_exists',function($attribute,$value,$parameters){
			return !in_array($this->sendCurlRequest($value,true),array(404,0));
		});
		$this->validator->extend('ip_exists',function($attribute,$value,$parameters){
				return !in_array($this->sendCurlRequest($value),array(404,0));
		});
		$siteInfo = $this->siteInfo;
		$user = $this->user;
		$this->validator->extend('in_database',function($attribute,$value,$parameters){
			if($attribute == 'dns'){
				return $this->siteInfo->isExistUserSiteInfoByHost($this->user->getCurrentUser()->id,$attribute,$value) === null;
			}
			return $this->siteInfo->isExistUserSiteInfo($this->user->getCurrentUser()->id,$attribute,$value) === -1;
		});
	}

	protected function sendCurlRequest($url,$ssl=false){
       $curlInit = curl_init($url);
       curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,5);
       curl_setopt($curlInit,CURLOPT_HEADER,true);
       curl_setopt($curlInit,CURLOPT_NOBODY,true);
       curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
       if($ssl){
       	curl_setopt($curlInit,CURLOPT_SSL_VERIFYPEER,false);
       }
       curl_exec($curlInit);
       $http_status = curl_getinfo($curlInit,CURLINFO_HTTP_CODE);
       curl_close($curlInit);
       return $http_status;
	}
}