<?php
class Doing {
	private $_db,
			$_data;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function create($fields = array()) {
		if(!$this->_db->insert('doing', $fields)) {
			throw new Exception('Gabim ne regjistrim te dhenash!');
		}
	}

	public function find() {
		$user = new User();

		$data = $this->_db->get('doing', array('user_id', '=', $user->data()->id));

		if($data->count()) {
			$this->_data = $data->results();
			return true;
		}
		return false;
	}

	public function get($key, $field = array()) {
		if($this->_data = $this->_db->query("SELECT " . $key, 'todo', $field)) {
			return $this->_data;
		}
	}

	public function getDoing($tab, $fields) {
		$data = $this->_db->action("SELECT " . $tab, 'doing', $fields);

		if($data->count()) {
			$array = json_encode($data->first());
			$array = json_decode($array, true);

			return $array[$tab];
		}
		return false;
	}

	public function delete($fields = array()) {
		if(!$this->_db->delete('doing', $fields)) {
			die('Gabim ne regjistrim');
		}
		return true;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function data() {
		return $this->_data;
	}
}