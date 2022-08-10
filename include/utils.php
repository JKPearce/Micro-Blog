<?php
//hashes a password
//function found in week 5 lecture example
function hash_password($input){    
$output = password_hash($input,PASSWORD_DEFAULT);
return $output;
}
//prevent illegal chars and hacking attempts
//trim removes spaces tab and newlines
//stripslashes removes \ from input 
//htmlspecialchars removes html code from input like <  > returns it as &lt & gt
//this function was found on w3schools as an example on how to escape input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/**
 * Log in a particular user
 *function found in week 5 tutorial code
 */
function login($username) {
	$_SESSION['username'] = $username;
}

?>