<?php

	class Session {
		public static function start() {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
		}

		public static function set($key, $value) {
			if (session_status() == PHP_SESSION_ACTIVE) {
				return $_SESSION[$key] = $value;
			}
		}

		public static function get($key) {
			if (session_status() == PHP_SESSION_ACTIVE) {
				if (isset($_SESSION[$key])) {
					return $_SESSION[$key];
				}
			}
		}

		public static function delete($key) {
			if (session_status() == PHP_SESSION_ACTIVE) {
				if (isset($_SESSION[$key])) {
					unset($_SESSION[$key]);
				}
			}
		}

		public static function destroy() {
			if (session_status() == PHP_SESSION_ACTIVE) {
				session_destroy();
			}
		}
	}

?>