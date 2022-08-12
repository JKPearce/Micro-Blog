<?php
session_start();
require_once "../include/config.php";
require_once "../include/utils.php";

$userid = $followid = ""; //init variables

if (isset($_GET['id'])) {//check to see if a follow link has been clicked
	if(isset($_SESSION['id'])){//check user is logged in (cant follow useres if not logged in)
		$followid = $_GET['id']; //save the id the user clicked on
		$userid = $_SESSION['id'];//save users id

		if (!$conn){//test database connection
			$error = mysqli_connect_error();
			$errno = mysqli_connect_errno();
			print "$errno: $error\n";
			exit();
		}else{

			//when a user clicks the follow link execute query to insert the ids into table
			$query = 'INSERT INTO `follow`(`user_id`, `follower_id`) 
			VALUES (?,?)';

			$stmt = mysqli_prepare($conn, $query);

			if(!mysqli_stmt_prepare($stmt, $query)){//if returns false display error msg
				print "Failed to prepare statement\n";
			}elseif(!mysqli_stmt_bind_param($stmt, "ii", $userid, $followid)){//if returns false display error msg
				print "failed to bind param";
			}elseif(!mysqli_stmt_execute($stmt)){//if returns false display error msg
				print "Already following that user";
			}else{
				header("Location: memberlist.php?follow=$followid"); //display success msg
			}	
		}
	}else{
			header("Location: memberlist.php?login=false"); //user is not logged in, display error link
		}
	}

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Members Page</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
	<body>
		<?php include_once "../include/nav.php";?>
		<section>
			<div class="main-wrapper">
				<h1>Members list</h1>
			<?php if (isset($_GET['login'])) { //display error msgs 
				echo '<h1 class="error">You must be logged in to follow users</h1>';
			}
			if (isset($_GET['follow'])) {
				echo '<h1 class="success">Successfully followed user ', $_GET['follow'], '</h1>';			
			}
			?>
			<div class="memberlist">
				<table id="membertable">
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Follow</th>
					</tr>
					
					<?php 
					if (!$conn){
						$error = mysqli_connect_error();
						$errno = mysqli_connect_errno();
						print "$errno: $error\n";
						exit();
					}else{
						//display table of users.
						$query = 'SELECT id, name
						FROM user
						ORDER BY id ASC';

						if($result = mysqli_query($conn, $query)){
										//get data out of query and save to $row as as assoc array
							while($row = mysqli_fetch_assoc($result)){
								//creates a new list with user id as the list id and displays ID
								echo '<tr id="', $row['id'],'">';
								echo '<td id="id"> ',$row['id'], '</td>';
								echo '<td id="name">  ', $row['name'], '   </td>';
								echo '<td id="follow"><a href="memberlist.php?id=', $row['id'], '" name="link">Follow</a></td>'; //link if clicked sends to same page with a ?ID in the link which is used to determine which user was clicked on to follow.
								echo '</tr>';
							}
						}else{
							echo "failed to set result";
						}
						
					}
					?>

				</table>
			</div>
		</div>
	</section>
</body>
</html>