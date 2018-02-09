<?php
class Done {
	private $_db,
			$_data;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function create($fields = array()) {
		if(!$this->_db->insert('done', $fields)) {
			throw new Exception('Gabim ne regjistrim te dhenash!');
		}
	}

	public function find() {
		$user = new User();

		$data = $this->_db->get('done', array('user_id', '=', $user->data()->id));

		if($data->count()) {
			$this->_data = $data->results();
			return true;
		}
		return false;
	}

	public function delete($fields = array()) {
		if(!$this->_db->delete('done', $fields)) {
			die('Gabim ne regjistrim');
		}
		return true;
	}

	public function exists() {
		return (!empty($this->find())) ? true : false;
	}

	public function data() {
		return $this->_data;
	}
}