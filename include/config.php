<?php

// database config file

$DB_HOST = getenv("DB_HOST") ?: "localhost";
$DB_USER = getenv("DB_USER") ?: "assignment1User"; 
$DB_PASSWORD = getenv("DB_PASSWORD") ?: "uXURCyzZaHHrm7f0";
$DB_NAME = getenv("DB_NAME") ?: "assignment1";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
?>