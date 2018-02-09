<?php
class Validate {
	private  $_passed = false,
			 $_errors = array(),
			 $_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {

				/**
				*	$source = $_POST ose $_GET
				*	, merr vleren nga inputi i
				*	perdoruesit ... $_POST[$item]
				*	dhe e ruan ne variablin
				*	$value;
				*/

				$value = trim($source[$item]);


				/**
				*	Kontrollon nese ne rregullat 
				*	e vendosura ekziston fusha
				*	required => true dhe vlera
				*	nga inputi i perdoruesit nuk
				*	eshte vendosur => Atehere
				*	do kthejme nje error !
				*/
				if($rule === 'required' && empty($value)) {
					$this->addError("{$rules['name']} duhet te plotesohet !");
				} else if(!empty($value)) {
					/**
					*	Nqs fusha e inputit nuk eshte bosh
					*	do kontrollojme nese ploteson te gjitha
					*	kushtet qe kemi vendosur me pare.
					*/
					switch($rule) {

						/**
						*	Kushti i minimumit te karaktereve !
						*/
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$rules['name']} duhet te kete me teper se {$rule_value} karaktere!");
							}
						break;

						/**
						*	Kushti i perputhshmerise te fjalekalimeve !
						*/
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$rules['name']} duhet te perputhet !");
							}
						break;

						/**
						*	Kushti i maksimumit te karaktereve !
						*/
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$rules['name']} duhet te kete me pak se {$rule_value} karaktere!");
							}
						break;

						/**
						*	Kushti nqs emri i perdoruesit eshte unik ose jo.
						*/
						case 'unique':
							$check = $this->_db->get($rule_value, array(
									$item,
									'=',
									$value
							));

							if($check->count()) {
								$this->addError("{$rules['name']} ekziston ne databaze !");
							}
						break;
					}
				}
			} 
		}

		/**
		*	Kontrollon nese mbas foreach()...
		*	eshte regjistruar ndonje error ne
		*	array _errors.
		*/
		if(empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}

	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}