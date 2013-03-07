<?php

/**
 * Wrapper for PHP's Hash Message Digest Framework.
 */
class Hash {

	/**
	 * Creates a salted hash.
	 * 
	 * @param String $algo Algorithm to use for hashing.
	 * @param String $data Data to hash.
	 * @param String $salt Salt to add to the hash.
	 * @return String A hashed string of $data.
	 */
	public static function create($data, $salt = SALT, $algo = ALGO) {
		$context = hash_init($algo, HASH_HMAC, $salt);
		hash_update($context, $data);

		return hash_final($context);
	}

}
