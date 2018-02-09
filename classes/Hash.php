<?php
class Hash {
	// Klasa Hash perdoret per siguri aplikacioni

	public static function make($string, $salt = '') {
		// $salt improvizon privatesin e fjalekalimit
		// funksioni make() krijon ne menyr te enkriptuar fjalekalimin

		return hash('sha256', $string . $salt);
	}

	public static function salt($length) {
		return mcrypt_create_iv($length);
	}

	public static function unique() {
		return self::make(uniqid());
	}
}