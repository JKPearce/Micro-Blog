<?php
session_start();
require_once "../include/config.php"; //database connection
require_once "../include/utils.php"; //useful functions

if(isset($_GET['pid'])){//check to see if the user clicked the reply button
	$_SESSION['reply'] = $_GET['pid'];//save the variable in session
}


if (!isset($_SESSION['username'])) {
	header("Location: login.php?login=false");
}else {
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	date_default_timezone_set("Australia/Sydney"); //set time zone to au
	$text = test_input($_POST['text']); //save the text after testing for illegal input and save to $text
	$mysqltime = date("Y-m-d H:i:s"); // save the datetime in correct format that sql can read 
	$userid = $_SESSION['id']; //save user id
	$reply = $_SESSION['reply']; //save reply id

	if (!is_null($reply)) { //output this if reply is not null
		print "in reply to post $reply ";
	}
	
	if(strlen($text) > 160){
		header("Location: createpost.php?text=error");
		exit();
	//connect to database, test if connection if no, quit
	}elseif (!$conn){
		$error = mysqli_connect_error();
		$errno = mysqli_connect_errno();
		print "$errno: $error\n";
		exit();
	}else{

		$query = 'INSERT INTO `post`(`user_id`, `post_date`, `text`, `in_reply_to` ) 
		VALUES (?,?,?,?)';

		$stmt = mysqli_prepare($conn, $query);

		if(!mysqli_stmt_prepare($stmt, $query)){
			print "Failed to prepare statement\n";
		}elseif(!mysqli_stmt_bind_param($stmt, "issi", $userid, $mysqltime, $text, $reply)){
			echo "failed to bind param";
		}elseif(!mysqli_stmt_execute($stmt)){
			echo"failed to execute stmt";
		}else{
			print "'$text' added to database as userid $userid";
		}	
	}
	$_SESSION['reply'] = null; //reset to null after reply has been posted
}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Post Page</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<?php include_once "../include/nav.php";?>
	<section>
		<div class="main-wrapper">
			<h1>Create a post as user <?php echo $_SESSION['username']; ?></h1>
			<?php if (isset($_GET['text'])) {
				echo '<h1 class="error">Max Char limit is 160! post did not send!</h1>';
			}?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="textarea" name="text" id="textbox" placeholder="What would you like to post today?"><span id='remainingC'></span>
				<br><button type="submit" name="submit">Create Post</button>
			</form>
		</div>
	</section>
	<script type="text/javascript" src="script/validate.js"></script>
</body>
</html>