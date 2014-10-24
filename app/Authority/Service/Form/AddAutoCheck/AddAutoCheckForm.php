<?php namespace Authority\Service\Form\AddAutoCheck;

use Authority\Service\Validation\ValidableInterface;

class AddAutoCheckForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \Cesario\Service\Form\ValidableInterface 
	 */
	protected $validator;

	/**
	 * Session Repository
	 *
	 * @var \Cesario\Repo\Session\SessionInterface 
	 */
	protected $user;

	public function __construct(ValidableInterface $validator)
	{
		$this->validator = $validator;
	}

	public function isValidAdd($input)
	{
		return $this->valid($input);
	}

	/**
	 * Return any validation errors
	 *
	 * @return array 
	 */
	public function errors()
	{
		return $this->validator->errors();
	}

	/**
	 * Test if form validator passes
	 *
	 * @return boolean 
	 */
	protected function valid(array $input)
	{
		return $this->validator->with($input)->passes();
		
	}



}