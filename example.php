<?php
/**
 * DDB Example file
 * To get you started using draft DB
 *
 * @author  	Alek Mlynek
 * @copyright	Copyright (C) 2012 - 2014 Alek Mlynek
 * @license		All Rights Reserved
 * @link			http://www.alekmlynek.com
 * @since			Version 1.0
 */

include 'DDB.php';

$db 			= new DDB;		// Init the DB
$prefix		=	'users';		// Prefix the type of data you are storing for cleaner DB structure
$user;									// Create user object

// Fill user object
$user = array(
	'username' 		=> 'example',
	'realname'		=> 'full nane',
	'created'			=> time(),
	);

// Merge key with prefix
$key = $prefix . $user['username'];

// Insert object into DB
$db->set($key, $user);

// Retreive object from DB
$object = $db->get($key);

// Display object to screen
print "Here is your DB object";
print '<br>';

var_dump($object);

?>
