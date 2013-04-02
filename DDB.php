<?php
/**
 * Class DDB (Draft Database)
 * File database for easy storage and retrieval of JSON objects.
 *
 * @author  	Alek Mlynek
 * @copyright	Copyright (C) 2012 - 2014 Alek Mlynek
 * @license		All Rights Reserved
 * @link			http://www.alekmlynek.com
 * @since			Version 1.0
 */

/**

** PUBLIC FUNCTIONS **
get($key);															// Get document from DB
set($key, $value);		// Insert document indo DB
append($key, $value);										// Append key to end of file
touch($key);														// Touch document (for future use with expire)
unlink($key);														// Delete document from DB

** PRIVATE FUNCTIONS **
build_key_dir($key);										// Combine class settings and build directory structure for given key
build_key($key);												// Return a key based on class configuration
**/

class DDB
{
	public $db;


	//Private
	private $db_prefix	= '../db/';
	private $db_ext			= '.json';

	public function __construct()
	{		
	}

	/**
	* Put file into key
	* @param 		key (string), value (object)
	* @return 	success (BOOL)
	*/
	public function set($p_key, $p_value)
	{

		$this->build_key_dir($p_key);
		$key = $this->db_prefix . $p_key . $this->db_ext;

		$value = '';

		$value = json_encode($p_value);

		file_put_contents($key, $value);
		return TRUE;
	}

	/**
	* Append key to file
	* @param 		key (string), value (object)
	* @return 	success (BOOL)
	*/
	public function append($p_key, $p_value)
	{
		$file = $this->get($p_key);

		if(!isset($file) || $file === FALSE || $file == '')
			$file = array();

		$file[] = $p_value;

		$this->set($p_key, $file);
		
		return TRUE;

	}


	/** 
	* Get file from disk
	* @param 		key (string), asArray (BOOL)
	* @return 	result (string) / fail (bool)
	* @todo 		Finish decryption mechanism
	*/
	public function get($p_key, $p_asArray=TRUE)
	{
		$key = $this->build_key($p_key);

		if(file_exists($key))
			return json_decode(file_get_contents($key), $p_asArray);
		else
			return FALSE;
	}

	/** 
	* Touch database file
	* @param 		key (string)
	* @return 	success	(BOOL)
	*/
	public function touch($p_key)
	{
		$key = $this->build_key($p_key);

		if(file_exists($key))
			touch($key);
		else
			return FALSE;

		return TRUE;
	}

	/** 
	* Destroy database file
	* @param 		key (string)
	* @return 	success	(BOOL)
	*/
	public function unlink($p_key)
	{
		$key = $this->build_key($p_key);

		if(file_exists($key))
			unlink($key);
		else
			return FALSE;

		return TRUE;
	}


	/**
	* Build directory structure
	* @param 		String key
	* @return 	success (BOOL)
	* @todo 		Using iteration for performance. Theory: Recursion not needed, investigate in future if problem and eval performance.
	*/
	public function exists($p_key)
	{
		$key = $this->build_key($p_key);
		return file_exists($key);
	}


	/**
	* Build directory structure
	* @param 		String key
	* @return 	success (BOOL)
	* @todo 		Using iteration for performance. Theory: Recursion not needed, and will kill performance. Execute test in future to challenge this.
	*/
	private function build_key_dir($p_key)
	{
			//Don't check if true
			if(is_dir($p_key))
				return TRUE;

			//Dosn't exist, build it
			$dirs = explode('/', $p_key);

			//Iterate through values except last one as that is our file
			for($i = 0; $i < count($dirs)-1; $i++)
			{
				//Reset vars
				$dir_trail = '';
				$dir_build = '';

				//Trail loop
				for($j = 0; $j < $i; $j++ )
				{
					$dir_trail = $dir_trail . '/' . $dirs[$j];
				}
				$dir_build = $dir_trail . '/' . $dirs[$i];

				//If not directory, make it, rinse, repeat
				if(!is_dir($this->db_prefix . $dir_build))
					mkdir($this->db_prefix . $dir_build);
			}

			//Ok, cool - profit.
			return TRUE;
	}


	/**
	* Build key based on prefix and extension
	* @param 		key (string)
	* @return 	key (string)
	*/
	private function build_key($p_key)
	{
		return $this->db_prefix . $p_key . $this->db_ext;
	}
}


?>
