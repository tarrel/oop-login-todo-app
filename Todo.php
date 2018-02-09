<?php
class Todo {
	private $_db,
			$_data;

	public function __construct(){
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
	}

	public function create($fields = array()) {
		if(!$this->_db->insert('todo', $fields)) {
			throw new Exception("Gabim gjate transferimit te te dhenave!");
		}
	}

	public function find() {
		$user = new User();

		$data = $this->_db->get('todo', array('user_id', '=', $user->data()->id));

		if($data->count()) {
			return $data->results();
		}
		return false;
	}

	public function get($tab, $fields) {
		$data = $this->_db->action("SELECT " . $tab, 'todo', $fields);

		if($data->count()) {
			$array = json_encode($data->first());
			$array = json_decode($array, true);

			return $array[$tab];
		}
		return false;
	}

	public function delete($fields = array()) {
		if(!$this->_db->delete('todo', $fields)) {
			die('Gabim ne regjistrim');
		}
		return true;
	}

	public function exists() {
		if($this->find()) {
			//
			$this->_data = $this->find();
		} else {
			
		}
		return (!empty($this->_data)) ? true : false;
	}

	public function data() {
		return $this->_data;
	}
}