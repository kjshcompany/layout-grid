<?php
	class Functions {

		public static function redirectUrl($location = null, $seconds = 0) {
			if(!headers_sent()) {
				header('refresh: ' . $seconds . '; url=' . $location . '');
			} else {
				echo '<noscript><meta http-equiv="refresh" content="' . $seconds . ';url=' . $location . '" /></noscript>';
				echo '<script>setTimeout(function() {window.location.href= "' . $location . '";},' . $seconds . '*' . 1000 . ');</script>';
			}
		}

		public static function redirectScheme($string, $url) {
			if($string != $_SERVER['REQUEST_SCHEME']) {
				self::redirectUrl($url);
			}
		}

		public static function formatUrl() {
			if (strstr($_SERVER['REQUEST_URI'], '.')) {
				self::redirectUrl(Config::get('web_url'));
			} else if (strcmp($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_URI'])) != 0) {
				self::redirectUrl(strtolower($_SERVER['REQUEST_URI']));
			} else if (substr($_SERVER['REQUEST_URI'], -1) != DS) {
				self::redirectUrl($_SERVER['REQUEST_URI'] . DS);
			} else if (strstr($_SERVER['REQUEST_URI'], DS . DS)) {
				self::redirectUrl(Config::get('web_url'));
			}
		}

		public static function getPath() {
			if (isset($_GET['path'])) {
				$path = rtrim($_GET['path'], DS);
				$path = filter_var($path, FILTER_SANITIZE_URL);
				$path = explode(DS, $path);

				return $path;
			}
		}

		public static function timeZone($data) {
			return date_default_timezone_set($data);
		}

		public static function getIpPublic() {
			$external_content = file_get_contents('http://checkip.dyndns.com/');
			preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $external_content, $m);
			$external_ip = $m[1];
			return $external_ip;
		}

		public static function writeLog($option, $data) {
			$handle = fopen(ROOT_LOG . 'log_' . date('d-m-Y') . '.log', 'a+');
			$text = '[' . $option . '] [' . self::getIpPublic() . '] [' . date('d-m-Y') . '] [' . date('h:i:s A') . '] [' . $data . ']' . PHP_EOL;
			fwrite($handle, $text);
			fclose($handle);
		}

		public static function encrypt($data) {
			$encryption_key = base64_decode(Config::get('key'));
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::get('cod')));
			$encrypted = openssl_encrypt($data, Config::get('cod'), $encryption_key, 0, $iv);
			return base64_encode($encrypted . '::' . $iv);
		}

		public static function decrypt($data) {
			$encryption_key = base64_decode(Config::get('key'));
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::get('cod')));
			list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
			return openssl_decrypt($encrypted_data, Config::get('cod'), $encryption_key, 0, $iv);
		}

		public static function browserOs() {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$nt_name = '';
			$nt_version = '';
			$nt_architecture = '';
			$browser_name = '';
			$browser_version = '';

			if (preg_match('/Windows/i', $user_agent)) {
				$nt_name = 'Windows';
			}

			if (preg_match('/NT 6.1/i', $user_agent)) {
				$nt_version = '7';
			} elseif (preg_match('/NT 6.2/i', $user_agent)) {
				$nt_version = '8';
			} elseif (preg_match('/NT 6.3/i', $user_agent)) {
				$nt_version = '8.1';
			} elseif (preg_match('/NT 10.0/i', $user_agent)) {
				$nt_version = '10';
			}

			if (preg_match('/Win32/i', $user_agent)) {
				$nt_architecture = '32';
			} elseif (preg_match('/Win64/i', $user_agent)) {
				$nt_architecture = '64';
			} elseif (preg_match('/wow64/i', $user_agent)) {
				$nt_architecture	=	'64';
			}

			if (preg_match('/Firefox/i', $user_agent)) {
				$browser_name		=	'Firefox';
				$ub					=	'Firefox';
			} elseif (preg_match('/Maxthon/i', $user_agent)) {
				$browser_name		=	'Maxthon';
				$ub					=	'Maxthon';
			} elseif (preg_match('/Opera/i', $user_agent)) {
				$browser_name		=	'Opera';
				$ub					=	'Opera';
			} elseif (preg_match('/OPR/i', $user_agent)) {
				$browser_name		=	'Opera';
				$ub					=	'OPR';
			} elseif (preg_match('/Edge/i', $user_agent)) {
				$browser_name		=	'Edge';
				$ub					=	'Edge';
			} elseif (preg_match('/brave/i', $user_agent)) {
				$browser_name		=	'Brave';
				$ub					=	'brave';
			} elseif (preg_match('/Edg/i', $user_agent)) {
				$browser_name		=	'Edge';
				$ub					=	'Edg';
			} elseif (preg_match('/Chrome/i', $user_agent)) {
				$browser_name		=	'Chrome';
				$ub					=	'Chrome';
			} elseif (preg_match('/Version/i', $user_agent)) {
				$browser_name		=	'Safari';
				$ub					=	'Version';
			} elseif (preg_match('/MSIE/i', $user_agent)) {
				$browser_name		=	'Explorer';
				$ub					=	'MSIE';
			} elseif (preg_match('/rv/i', $user_agent)) {
				$browser_name		=	'Explorer';
				$ub					=	'rv';
			}

			@$known = array('browser_version', $ub, 'other');
			$pattern 				=	'#(?<browser>'.join('|', $known).')[/|:]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all($pattern, $user_agent, $matches)) {
			}
		
			$i 						=	count($matches['browser']);
			if ($i != 1) {
				if (strripos($user_agent,'browser_version') < @strripos($user_agent,$ub)){
					$browser_version	=	@$matches['version'][0];
				} else {
					$browser_version	=	@$matches['version'][1];
				}
			} else {
				$browser_version		=	$matches['version'][0];
			}
		
			if ($browser_version == null || $browser_version == '') {
				$browser_version	=	'';
			}

			return [
				'user_agent' => $user_agent,
				'nt_name' => $nt_name,
				'nt_version' => $nt_version,
				'nt_architecture' => $nt_architecture,
				'browser_name' => $browser_name,
				'browser_version' => $browser_version
			];
		}

		public static function checkBrowserOs() {
			$browserOs = self::browserOs();
			if ($browserOs['nt_name'] != Config::get('system_name_compatible')) {
				self::redirectUrl(Config::get('web_url') . 'errors' . DS . 'noos' . DS);
			} else if ($browserOs['nt_version'] < Config::get('system_version_minimum_compatible')) {
				self::redirectUrl(Config::get('web_url') . 'errors' . DS . 'noos' . DS);
			} else if ($browserOs['nt_architecture'] != Config::get('system_architecture_compatible')) {
				self::redirectUrl(Config::get('web_url') . 'errors' . DS . 'noos' . DS);
			} else if ($browserOs['browser_name'] != Config::get('name_browser_compatible')) {
					self::redirectUrl(Config::get('web_url') . 'errors' . DS . 'nobrowser' . DS);
			} else if ($browserOs['browser_version'] < Config::get('version_browser_minimum_compatible')) {
				self::redirectUrl(Config::get('web_url') . 'errors' . DS . 'nobrowser' . DS);
			}
		}

		public static function checkCookie() {
			Cookie::set('detect_cookie', 1, 1, 'year');
			if (count($_COOKIE) > 0) {
			} else {
				self::redirectUrl(Config::get('web_url') . 'errors' . DS . 'nocookie' . DS);
			}
		}

		public static function checkResolution() {
			echo '
				<script>
					var w = document.documentElement.clientWidth;
					if (w < "' . Config::get('resolution_minimum_width') . '") {
						window.location.href= "' . Config::get('web_url') . 'errors' . DS . 'noresolution' . DS . '";
					}
					function checkResolution() {
						var w = document.documentElement.clientWidth;
						if (w < "' . Config::get('resolution_minimum_width') . '") {
							window.location.href= "' . Config::get('web_url') . 'errors' . DS . 'noresolution' . DS . '";
						}
					}
					window.addEventListener("resize", checkResolution);
					checkResolution();
				</script>
			';
		}

		public static function showPreload() {
			if (Config::get('show_preload')) {
				echo PHP_EOL;
				foreach (Config::get('preload') as $value) {
					echo $value . PHP_EOL;
				}
				self::preloadImg('./assets/img');
				self::preloadImg('themes/' . Config::get('default_theme',) . '/img');
			}
		}

		public static function showAssets() {
			echo PHP_EOL;
			if (Config::get('show_assets')) {
				foreach (Config::get('assets') as $value) {
					echo $value . PHP_EOL;
				}
			}
		}

		public static function preloadImg($directory) {
			$thefolder = $directory;
			if ($handler = opendir($thefolder)) {
				while (false !== ($file = readdir($handler))) {
					$ext = pathinfo($file);
					if ($ext['extension'] != 'ico') {
						$files = $file;
					}
					if (is_file($directory . '/' . $files)) {
						echo '	<link rel="prefetch" href="' . Config::get('web_url') . $directory . '/' . $files . '" as="image">' . PHP_EOL;
					}
				}
			}
			closedir($handler);
		}

		public static function hideSwitchErrors() {
			echo "
				<style>
					.switch-audio {
						visibility: hidden;
					}

					.switch-full-screen {
						visibility: hidden;
					}

					.switch-dark-light {
						visibility: hidden;
					}

					.switch-lang {
						visibility: hidden;
					}
				</style>
			";
		}
	}

?>