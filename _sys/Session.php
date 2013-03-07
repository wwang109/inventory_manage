<?php

/**
 * Wrapper for PHP Sessions.
 */
class Session {

	/**
	 * Calls @session_start().
	 */
	public static function init() {
		@session_start();
	}

	/**
	 * Sets $_SESSION key/value pair.
	 * 
	 * @param String $key Key for $_SESSION.
	 * @param String $value Value to store in $_SESSION.
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * Gets $_SESSION value.
	 * 
	 * @param String $key Key for $_SESSION.
	 * @return Varies Usually a String.
	 */
	public static function get($key) {
		if (Session::timeout() || !Session::validFingerprint()) {
			Session::destroy();
			return NULL;
		}
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return NULL;
	}

	/**
	 * Calls session_destroy().
	 */
	public static function destroy() {
		@session_destroy();
	}
	
	/**
	 * Checks if timed out.
	 * 
	 * @return True if timeout, false otherwise.
	 */
	public static function timeout() {
		if(TIMEOUT <= 0) {
			return false;
		}
		if (!isset($_SESSION['timeout'])) {
			Session::setTimeout();
		}
		return $_SESSION['timeout'] + TIMEOUT * 60 < time();
	}
	
	/**
	 * Sets timeout.
	 * 
	 * @param Integer $value Int for $_SESSION['timeout']
	 */
	public static function setTimeout($value = NULL) {
		$_SESSION['timeout'] = $value ? $value : time();
	}
	
	public static function setFingerprint() {
		if(!isset($_SESSION['fingerprint'])) {
			$_SESSION['fingerprint'] = Hash::create($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
		}
		return $_SESSION['fingerprint'];
	}
	
	public static function validFingerprint() {
		if(!isset($_SESSION['fingerprint'])) {
			Session::setFingerprint();
		}
		return $_SESSION['fingerprint'] === Hash::create($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
	}

}