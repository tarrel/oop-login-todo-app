	<?php
class DB {
	private static $_instance = null;

	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0;

	private function __construct() {
		/**
		*	Vendosim lidhjen ne try-catch block;
		*/
		try {
			$this->_pdo = new PDO('mysql:host='. Config::get('mysql/host') .';dbname='. Config::get('mysql/db'), Config::get('mysql/username'), '');
			// $this->_pdo = new PDO('mysql:host=localhost;dbname=logreg', 'root', '');
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}

	/**
	*	Marrim konstruktorin private dhe
	*	e vendosim ne instancen statike
	*	==> Singleton Pattern
	*/
	public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	/**
	* Merr Query nga DB, ne menyr me te kuptueshme
	* dhe shpejtesi me te madhe.
	*/
	public function query($sql, $params = array()) {
		/**
		* Vendosim variablin _error = false
		* sepse mund te kemi disa errore qe
		* mund te jene = true per query te
		* meparshem.
		*/
		$this->_error = false;

		/**
		* if($this->_query = $this->_pdo->prepare($sql))
		* Eshte e njejt me :
		* $this->_query = $this->_pdo->prepare->($sql);
		* if($this->_query)
		*/
		if($this->_query = $this->_pdo->prepare($sql)) {
			/**
			* Kontrollojme nese parametrat jane te sakte
			*/
			$x = 1;
			if(count($params)) {
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			//	Ekzekuton query-in e vendosur
			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);

				//	Variabli _count tregon nese nga databaza jane marre te dhena ose jo.
				// Vlera default eshte 0;
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		// Kthen objektin.
		return $this;
	}

	public function action($action, $table, $where = array()) {
		/**
		*	Kontrollojme nese array $where === 3
		*	nqs ekzistojn 3 parametra te domosdoshem
		*	1. fusha ne DB
		*	2. operatori veprimit (=, >, >=, <, <=)
		*	3. vlera
		*/
		if(count($where) === 3) {
			//	Operatoret e vlefshem.
			$operators = array('=', '>', '>=', '<', '<=');

			$field 		= $where[0];	//	Fusha ne databaze
			$operator 	= $where[1];	//	Operatori i perdorur
			$value 		= $where[2];	//	vlera qe kerkohet

			/**
			*	Kontrollon nese operatori i veprimit
			*	eshte i vlefshem apo jo.
			*/
			if(in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}

	/**
	*	Merr te dhenat nga databaza !
	*/
	public function get($table, $where) {
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}

	public function insert($table, $fields = array()) {
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;

			foreach($fields as $field) {
				$values .= '?';
				if($x < count($fields)) {
					$values .= ', ';
				}
				$x++;
			}

			$sql = "INSERT INTO {$table} (`". implode('`, `', $keys) ."`) VALUES ({$values})";
			if(!$this->query($sql, $fields)->error()) {
				return true;
			}
		}
		return false;
	}


	public function update($table, $id, $fields) {
		$set = '';
		$x = 1;

		foreach($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)) {
				$set .= ", ";
			}
			$x++;
		}


		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	public function results() {
		return $this->_results;
	}

	// Kthen rezultatin e pare te gjendur ne Databaze.
	public function first() {
		return $this->results()[0];
	}

	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}
}
