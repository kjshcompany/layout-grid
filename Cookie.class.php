<?php

	class Cookie {

		public static function set($key, $value, $time, $option_time) {
			if ($option_time == 'second') {
				$time = $time;
			} elseif ($option_time == 'minute') {
				$time = ($time * 60);
			} elseif ($option_time == 'hour') {
				$time = ($time * 3600);
			} elseif ($option_time == 'day') {
				$time = ($time * 86400);
			} elseif ($option_time == 'week') {
				$time = ($time * 604800);
			} elseif ($option_time == 'month') {
				$time = ($time * 2.628e+6);
			} elseif ($option_time == 'year') {
				$time = ($time * 3.154e+7);
			}

			setcookie($key, $value, time() + $time, DS);

			if (!isset($_COOKIE[$key])) {
				Functions::redirectUrl();
			}
		}

		public static function get($key) {
			if (isset($_COOKIE[$key])) {
				return $_COOKIE[$key];
			}
		}

		public static function delete($key) {
			if (isset($_COOKIE[$key])) {
				setcookie($key, '', 1, DS);
				Functions::redirectUrl();
			}
		}
	}

?>