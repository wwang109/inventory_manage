<?php

/**
 * Header redirect.
 * 
 * @param String $location Location to redirect to.
 */
if (!function_exists('_redirect')) {

	function _redirect($location) {
		header('Location: ' . $location);
	}

}

/**
 * Remove Invisible Characters
 *
 * This prevents sandwiching null characters
 * between ascii characters, like Java\0script.
 *
 * @param   String $str String to remove invisible characters from.
 * @return  String String without invisible characters.
 */
if (!function_exists('_removeInvisibleCharacters')) {

	function _removeInvisibleCharacters($str, $url_encoded = TRUE) {

		$non_displayables = array();

		// every control character except newline (dec 10)
		// carriage return (dec 13), and horizontal tab (dec 09)

		if ($url_encoded) {
			$non_displayables[] = '/%0[0-8bcef]/'; // url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/';  // url encoded 16-31
		}

		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';  // 00-08, 11, 12, 14-31, 127

		do {
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		} while ($count);

		return $str;
	}

}

/**
 * htmlspecialchars, specifying document's encoding.
 * 
 * @param String $s String to htmlspecialchars().
 * @return String $s Return of htmlspecialchars().
 */
if (!function_exists('_htmlEncode')) {

	function _htmlEncode($s) {
		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
	}

}

/**
 * Sanitizes data so cross scripting hacks can be prevented.
 * Some of the snippets came from CodeIgniter's xss_clean().
 * Though not as thorough, will do it along the development.
 * 
 * @param String/Array String or Array to sanitize.
 * @return String Sanitized string.
 */
if (!function_exists('_xssClean')) {

	function _xssClean($str) {

		/*
		 * Recursive if array.
		 *
		 */
		if (is_array($str)) {

			while (list($key) = each($str)) {

				$str[$key] = $this->_xssClean($str[$key]);
			}

			return $str;
		}


		$str = _removeInvisibleCharacters($str);
		$str = _htmlEncode($str);
		$str = filter_var($str, FILTER_SANITIZE_STRING);

		return $str;
	}

}

/**
 * Displays the error page correspond to the error code.
 * 
 * @param Int $errorCode Error codes such as 404, 403, 500, etc.
 */
if (!function_exists('_showError')) {

	function _showError($errorCode) {
		$controller = new Error(); // Should have a default error controller in case it's missing
		$controller->index($errorCode);
		exit();
	}

}

/**
 * Sets alert message of View object.
 * 
 * @param &View $view Reference to the View object to use.
 * @param String $val Value to set for _alert of View object.
 * @param String $msg Value to set for _alertMsg of View object.
 */
if (!function_exists('_alert')) {

	function _alert(&$view, $val, $msg = '') {
		$view->_alert = $val;
		$view->_alertMsg = $msg;
	}

}

/**
 * Checks if class method is public.
 * 
 * @param Class $class Class of the method.
 * @param String $method Name of method to check.
 * @return Boolean True if public, false otherwise.
 */
if (!function_exists('_isPublic')) {

	function _isPublic($class, $method) {
		$reflection = new ReflectionMethod($class, $method);
		return $reflection->isPublic();
	}

}

/**
 * Checks if class is abstract.
 * 
 * @param Class $class Class to check.
 * @return Boolean True if abstract, false otherwise.
 */
if (!function_exists('_isAbstract')) {

	function _isAbstract($class) {
		$reflection = new ReflectionClass($class);
		return $reflection->isAbstract();
	}

}

/**
 * Short form of echo.
 * 
 * @param String $str String to echo
 */
if (!function_exists('_e')) {

	function _e($str, $toHtml = FALSE) {
		if ($toHtml) {
			$str = str_replace("\n", '<br>', $str);
		}
		echo $str;
	}

}

/**
 * Checks if string are the same.
 * 
 * @param String $str1 First string.
 * @param String $str2 Second string.
 * @return Boolean Is the same or not.
 */
if (!function_exists('_isSame')) {

	function _isSame($str1, $str2) {
		return strcmp($str1, $str2) == 0;
	}

}

/**
 * Partial check.
 * 
 * @param String $haystack Haystack string.
 * @param String $needle Needle string.
 * @return True if found, false otherwise.
 */
if (!function_exists('_partialFound')) {

	function _partialFound($haystack, $needle) {
		return strpos($haystack, $needle) !== FALSE;
	}

}

/**
 * Generates random string.
 * 
 * @param Integer $length Length of generated string.
 * @return String Randomly generated string.
 */
if (!function_exists('_randomStrings')) {

	function _randomStrings($length = 6) {
		$str = '';
		$possible = '2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ';

		$maxlength = strlen($possible);

		if ($length > $maxlength) {
			$length = $maxlength;
		}

		$i = 0;
		while ($i < $length) {
			$char = substr($possible, mt_rand(0, $maxlength - 1), 1);
			if (!strstr($str, $char)) {
				$str .= $char;
				$i++;
			}
		}
		return $str;
	}

}

/**
 * Formats a given date time.
 * 
 * @param String $datetime Generic datetime string.
 * @param String $format Format.
 * @return String Formatted datetime.
 */
if (!function_exists('_formatDateTime')) {

	function _formatDateTime($datetime, $format = 'l jS \of F Y h:i:s A') {
		$datetime = explode(' ', $datetime);
		$date = explode('-', $datetime[0]);
		$time = explode(':', $datetime[1]);
		return date($format, mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]));
	}

}

/**
 * Formats a given datetime stamp.
 * 
 * @param String|Integer $timestamp Generic datetime stamp.
 * @param String $format Format.
 * @return String Formatted datetime stamp.
 */
if (!function_exists('_formatDateTimestamp')) {

	function _formatDateTimestamp($timestamp, $format = 'Y-m-d h:i:s') {
		try {
			$date = new DateTime("@$timestamp");
			return $date->format($format);
		} catch (Exception $ex) {
			return 'N/A';
		}
	}

}

/**
 * Checks if IP or current is a spammer or not.
 * Check out: http://www.stopforumspam.com/
 * 
 * @param String $ip The IP to check. Defaults to current.
 * @return Boolean True if spammer, false otherwise.
 */
if (!function_exists('_isForumSpammer')) {

	function _isForumSpammer($ip = '') {
		if (empty($ip)) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$forumSpam = file_get_contents("http://www.stopforumspam.com/api?ip={$ip}");
		return preg_match('/yes/i', $forumSpam);
	}

}

/**
 * Debug function. Uses print_r by default.
 * 
 * @param Any $var Variable to debug.
 * @param Boolean $tostring Return the debug data instead of printing it.
 * @param String $method Method to use for debugging. print_r by default.
 * @return String if $tostring. None otherwise.
 */
if (!function_exists('_debug')) {

	function _debug($var, $tostring = FALSE, $method = 'print_r') {
		if ($tostring) {
			ob_start();
			$method($var);
			$result = ob_get_clean();
			return $result;
		} else {
			_e('<pre>');
			$method($var);
			_e('</pre>');
		}
	}

}

/**
 * Returns current IP.
 * 
 * @return String Current IP.
 */
if (!function_exists('_getIP')) {

	function _getIP() {
		return $_SERVER['REMOTE_ADDR'];
	}

}

/**
 * Logs by sending it to a log email.
 * 
 * @param String $severity Brief info of what is log's severity -- HIGH, NOTICE, LOW, etc.
 * @param String $mes The actual message to log.
 */
if (!function_exists('_log')) {

	function _log($severity, $mes) {
		$ip = _getIP();
		$datetime = date("D M j G:i:s T Y");
		$mes = _debug($mes, TRUE, 'var_dump');
		$logMessage = <<<END

Severity: {$severity}
IP logged: {$ip}
Date/time: {$datetime}
Message log:

{$mes}

===========================================
END;

		if (EMAIL_LOGGER) {
			Mailer::send('notice@rainulf.ca', EMAIL_LOG, 'LOG: ' . $severity, $logMessage);
		}

		if (FILE_LOGGER) {
			$fHandler = fopen(FILE_LOG, 'a') or die('Can\'t open log file. Please contact administrator!');
			fwrite($fHandler, $logMessage);
			fclose($fHandler);
		}
	}

}

/**
 * Wrapped array_key_exists with is_array check.
 * 
 * @param String $key Key to check if exist.
 * @param String $var Array -- checks if it's not. Returns FALSE if it's not.
 * @return Boolean If key exists in array.
 */
if (!function_exists('_betterKeyExists')) {

	function _betterKeyExists($key, $var) {
		if (!is_array($var)) {
			return FALSE;
		}

		return array_key_exists($key, $var);
	}

}

/**
 * PHP's http_response_code: http://www.php.net/manual/en/function.http-response-code.php
 * 
 * @param Int $code Response code.
 * @return Response code.
 */
if (!function_exists('http_response_code')) {

	function http_response_code($code = NULL) {

		if ($code !== NULL) {

			switch ($code) {
				case 100: $text = 'Continue';
					break;
				case 101: $text = 'Switching Protocols';
					break;
				case 200: $text = 'OK';
					break;
				case 201: $text = 'Created';
					break;
				case 202: $text = 'Accepted';
					break;
				case 203: $text = 'Non-Authoritative Information';
					break;
				case 204: $text = 'No Content';
					break;
				case 205: $text = 'Reset Content';
					break;
				case 206: $text = 'Partial Content';
					break;
				case 300: $text = 'Multiple Choices';
					break;
				case 301: $text = 'Moved Permanently';
					break;
				case 302: $text = 'Moved Temporarily';
					break;
				case 303: $text = 'See Other';
					break;
				case 304: $text = 'Not Modified';
					break;
				case 305: $text = 'Use Proxy';
					break;
				case 400: $text = 'Bad Request';
					break;
				case 401: $text = 'Unauthorized';
					break;
				case 402: $text = 'Payment Required';
					break;
				case 403: $text = 'Forbidden';
					break;
				case 404: $text = 'Not Found';
					break;
				case 405: $text = 'Method Not Allowed';
					break;
				case 406: $text = 'Not Acceptable';
					break;
				case 407: $text = 'Proxy Authentication Required';
					break;
				case 408: $text = 'Request Time-out';
					break;
				case 409: $text = 'Conflict';
					break;
				case 410: $text = 'Gone';
					break;
				case 411: $text = 'Length Required';
					break;
				case 412: $text = 'Precondition Failed';
					break;
				case 413: $text = 'Request Entity Too Large';
					break;
				case 414: $text = 'Request-URI Too Large';
					break;
				case 415: $text = 'Unsupported Media Type';
					break;
				case 500: $text = 'Internal Server Error';
					break;
				case 501: $text = 'Not Implemented';
					break;
				case 502: $text = 'Bad Gateway';
					break;
				case 503: $text = 'Service Unavailable';
					break;
				case 504: $text = 'Gateway Time-out';
					break;
				case 505: $text = 'HTTP Version not supported';
					break;
				default:
					exit('Unknown http status code "' . htmlentities($code) . '"');
					break;
			}

			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

			header($protocol . ' ' . $code . ' ' . $text);

			$GLOBALS['http_response_code'] = $code;
		} else {

			$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
		}

		return $code;
	}

}

/**
 * Loader function for classes.
 * 
 * @param String $class Name of class to load.
 */
if (!function_exists('_loader')) {

	function _loader($class) {
		if (file_exists(SYS . $class . '.php')) {
			require SYS . $class . '.php';
		} else if (file_exists(LIBS . $class . '.php')) { // use loadLibrary() to load libraries!
			require LIBS . $class . '.php';
		} else if (file_exists(CONTROLLERS . strtolower($class) . '.php')) { // use loadController() to load controllers!
			$class = strtolower($class);
			require CONTROLLERS . $class . '.php';
		} else if (file_exists(MODELS . strtolower($class) . '.php')) { // use loadModel() to load models!
			$class = strtolower($class);
			require MODELS . $class . '.php';
		}
	}

}

/**
 * Callback for ob_start().
 * 
 * @param String $buffer The buffer to process.
 * @return Cleaned buffer
 */
if (!function_exists('_cleanOutput')) {

	function _cleanOutput($buffer) {
		$search = array(
			 '/\>[^\S ]+/s', //strip whitespaces after tags, except space
			 '/[^\S ]+\</s', //strip whitespaces before tags, except space
			 '/(\s)+/s'  // shorten multiple whitespace sequences
		);
		$replace = array(
			 '>',
			 '<',
			 '\\1'
		);
		$buffer = preg_replace($search, $replace, $buffer);

		return $buffer;
	}

}