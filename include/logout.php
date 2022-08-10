<?php
//check if the page has been accessed by the submit button
if (isset($_POST['submit'])) {
	//kill session and everything to do with it and return to home page
	session_start();
	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}
?>