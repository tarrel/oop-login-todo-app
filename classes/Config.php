<?php
class Config {
	public function get($path = null) {
		if($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);

			// Config::get('mysql/host');
			// ['mysql', 'host'];

			// $path = mysql
			// $bit = $path
			// $config['mysql'] = $GLOBALS['config'];
			// $config = $GLOBALS['config']['mysql'];
			// $config['host'] = $GLOBALS['config']['mysql'];
			// $config = $GLOBALS['config']['mysql']['host'];



			foreach($path as $bit) {
				if($config[$bit]) {
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return false;
	}
}
