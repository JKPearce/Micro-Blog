<?php
session_start();
require_once "include/config.php";
require_once "include/utils.php";

//tests if the form has been sent, if not then display blank form
if ($_SERVER["REQUEST_METHOD"] == "POST") {


	$username = test_input($_POST["username"]);
	$password = test_input($_POST["password"]);
	echo "$username <br />";
	echo "$password<br />";

	//Check for empty input
	if(empty($username) || empty($password)){
		echo "input is empty";
		exit();
	}else{ //test database connection
		if (!$conn){
			$error = mysqli_connect_error();
			$errno = mysqli_connect_errno();
			print "$errno: $error\n";
			exit();
		}else{//execute code

			//prep query
			$query = 'SELECT `id`, `name`, `password` FROM `user` WHERE `name`=?'; 
			$stmt = mysqli_prepare($conn, $query);

			//Check prepare
			if(!mysqli_stmt_prepare($stmt, $query)){
				print "Failed to prepare statement\n";
			}

			//bind
			mysqli_stmt_bind_param($stmt, "s", $username);

			//execute query
			if(mysqli_stmt_execute($stmt)){
			// Get the results
				$result = mysqli_stmt_get_result($stmt);

			// Grab the first row
				$row = mysqli_fetch_array($result);
				

			// If the row exists
				if($row) {
				// Get the stored password
					$db_password = $row['password'];
					
					$verify = password_verify($password, $db_password);
					
				  //test the password
					if ($verify) {
						login($username);
						$_SESSION['id'] = $row['id'];
						header("Location: index.php");
					}else{
						echo "Password incorrect.";
					}
				}
			}
		}
		mysqli_stmt_close($stmt);
	}
}else{
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php include_once "include/nav.php";?>
	<section>
		<div class="main-wrapper">
			<h1>Log In</h1>
			<?php if (isset($_GET['login'])) {
				echo '<h1 class="error">You need to be logged in to view this page!</h1>';
			}?>
			<div class="signup-form">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="text" name="username" placeholder="Username">
					<br><input type="password" name="password" placeholder="Password">
					<br><button type="submit" name="submit">Log In</button>
				</form>
			</div>
		</div>
	</section>
</body>
</html>