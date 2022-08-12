<?php
session_start();
require_once "../include/config.php";
require_once "../include/utils.php";

//define variables and set empty values
$name = $password = $email = $passwordErr = $nameErr = "";

//tests if the form has been sent, if not then display blank form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$password = test_input($_POST["password"]); //run the input password through test_input function to make it a valid input
	//test to see if password is => 5 chars if yes then hash the password, if no then display error msg
	if(strlen($password) >= 5){
		$password = hash_password($password); //hash the password from user input and save hash to password hash_password function comes from utils.php
	}else{
		$passwordErr = "Password must be at least 5 chars.";
	}
	$name = test_input($_POST["username"]);
	$email = test_input($_POST["email"]);
	
	//test connection
	if (!$conn){
		$error = mysqli_connect_error();
		$errno = mysqli_connect_errno();
		print "$errno: $error\n";
		exit();
	}else{
		if($result = mysqli_query($conn, "SELECT * from user WHERE name = '$name' ")){
			if(mysqli_num_rows($result) > 0){
				header("Location: signup.php?name=taken");
		}else if($passwordErr === "" && $nameErr === ""){ //test the error values have not been set
			$query = 'INSERT INTO `user`(`id`, `name`, `email`, `password`) VALUES (NULL,?,?,?)';
			$stmt = mysqli_prepare($conn, $query);

				//test if the statement prepared
			if(!mysqli_stmt_prepare($stmt, $query)){
				print "Failed to prepare statement\n";
			}else{

				mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

				mysqli_stmt_execute($stmt);
				echo "User $name has been successfully created in the database";
			}
		}else{
			header("Location: signup.php?error=true");
			exit();
		}
	}

	mysqli_close($conn);
}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<?php include_once "../include/nav.php";?>
	<section>
		<div class="main-wrapper">
			<div class="signup-form">
				<h1>Sign up</h1>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="text" name="username" placeholder="Username">
					<span class="error"><?php echo $nameErr;?></span>
					<br><input type="text" name="email" placeholder="E-Mail">
					<br><input type="password" name="password" placeholder="Password">
					<span class="error"><?php echo $passwordErr;?></span>
					<br><button type="submit" name="submit">Sign Up</button>
				</form>
			</div>
		</div>
	</section>
</body>
</html>