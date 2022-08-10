<?php
session_start();
require_once "include/config.php";
require_once "include/utils.php";



?>

<!DOCTYPE html>
<html>
<head>
		<title>Top 20 Posts</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php include_once "include/nav.php";?>
		<section>
			<div class="main-wrapper">
				<h1>Top 20 Posts</h1>
				<div class="post-wrapper">
				<?php
				
					if (!$conn){
						$error = mysqli_connect_error();
						$errno = mysqli_connect_errno();
						print "$errno: $error\n";
						exit();
					}else{//execute code	
							//create query
						$query = 'SELECT p2.post_date, u.name, p2.text, COUNT(p.in_reply_to) AS replies, p2.id
						FROM post p 
                        INNER JOIN
                        post p2
                        ON
                        p.in_reply_to = p2.id 
						INNER JOIN
						user u
						ON
						p2.user_id = u.id
						GROUP BY p.in_reply_to
						ORDER BY replies DESC LIMIT 20';
									//test if query was success
						if($result = mysqli_query($conn, $query)){
										//get data out of query and save to $row as as assoc array
							while($row = mysqli_fetch_assoc($result)){
											//creates a new div with uniqe ids but same class
								echo '<div class="post-content" id="', $row['id'],'">';
											//display post data
								echo '<h3 class="post-name">', $row['name'], '</h3>';
											//display post id and date posted
								echo '<span>Post#', $row['id'],'  &sdot;', $row['post_date'],'</span>';
											//display post text
								echo '<p class="post-text">', $row['text'], '</p>';
								echo '<span class="replyCount">Replies: '. $row['replies'] . '</span>';
								echo '</div>';
							}
						}else{
							echo "failed to set result";
						}
					}
					?>
			</div>
		</section>
</body>
</html>