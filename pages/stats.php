<?php
session_start();
require_once "../include/config.php";
require_once "../include/utils.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stats Page</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<?php include_once "../include/nav.php";?>
	<section>
		<div class="main-wrapper">
			<h1>Top 10 users by number of follows</h1>
			<div class="statslist">
				<table>
					<tr>
						<th>Rank</th>
						<th>Name</th>
						<th>Followers</th>
					</tr>
					
					<?php 
					if (!$conn){
						$error = mysqli_connect_error();
						$errno = mysqli_connect_errno();
						print "$errno: $error\n";
						exit();
					}else{

						$query = 'SELECT f.user_id, u.name, COUNT(f.follower_id) AS followers
						FROM follow f
						RIGHT JOIN
						user AS u
						ON f.user_id = u.id
						GROUP BY u.id
						ORDER BY followers DESC LIMIT 10';

						if($result = mysqli_query($conn, $query)){
										//get data out of query and save to $row as as assoc array
							$number = 1; //init counter
							while($row = mysqli_fetch_assoc($result)){
								$name = $row['name'];
								$followers = $row['followers'];

								echo '<tr id="', $number, '">'; // set row id to rank number
								echo '<td id="rank">', $number, '</td>'; //display rank number
								echo '<td id="name">', $name, '     </td>'; //display users name
								echo '<td id="followers">   ', $followers,'</td>';  //display amount of followers
								echo '</tr>'; //end table row
								$number++; //increment counter
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