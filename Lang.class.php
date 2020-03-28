<?php

	class Lang {
		protected static $data;

		public static function load($lang_code) {
			$lang_file_path = './langs/' . ucfirst($lang_code) . '.lang.php';

			if (file_exists($lang_file_path) ) {
				self::$data = require_once($lang_file_path);
			}
		}

		public static function get($key, $sub_key = NULL, $default = NULL) {
			return (self::$data[$key][$sub_key] ?? $default);
		}
	}

?>