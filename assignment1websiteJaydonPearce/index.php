<?php
session_start();
require_once "include/config.php"; //database connection
require_once "include/utils.php"; //useful functions
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php include_once "include/nav.php";?>

	<section>
		<div class="main-wrapper">
			<?php if(isset($_SESSION['username'])): ?>
				<h1>Welcome Home <?php echo $_SESSION['username']; ?></h1>
			<?php else: ?>
				<h1>Welcome Home Guest</h1>
			<?php endif;
			//Display posts made in last 24 hours
			$query = 'SELECT COUNT(*) as posts 
			FROM post
			WHERE post.post_date > DATE_SUB(NOW(), INTERVAL 24 HOUR)';

					//test db connection
			if (!$conn){
				$error = mysqli_connect_error();
				$errno = mysqli_connect_errno();
				print "$errno: $error\n";
				exit();
			}else{
						//
				if($result = mysqli_query($conn, $query)){
							//get results
					if($row = mysqli_fetch_assoc($result)){
						echo '<h2>Posts in last 24 hours: ' . $row['posts'] . '</h2>';

					}
				}
			}

			?>

			<div class="post-wrapper">
				<?php
				//Display 10 most recent posts by date if user is not logged in
				if(!isset($_SESSION['username'])){	
					if (!$conn){
						$error = mysqli_connect_error();
						$errno = mysqli_connect_errno();
						print "$errno: $error\n";
						exit();
					}else{//execute code	
							//create query
						$query = 'SELECT p.post_date, u.name, p.text, p.in_reply_to, p.id, 
						(SELECT COUNT(*) FROM post p2 WHERE p2.in_reply_to = p.id ) AS replies
						FROM post p 
						INNER JOIN
						user u
						ON
						p.user_id = u.id
						ORDER BY p.post_date DESC LIMIT 10';
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

								//display reply count on a post if there is any
								if($row['replies'] > 0){
									echo '<span class="replyCount">Replies: '. $row['replies'] . '</span>';
								}
								//check to see if post was a reply
								if(!empty($row['in_reply_to'])){
												//make a anchor link to the div with same id
									echo '<a href="#', $row['in_reply_to'],'"><span>Replying To post #',$row['in_reply_to'],'</span></a>';
								}
								echo '</div>';
							}
						}else{
							echo "failed to set result";
						}
					}
				}else{// if the user is logged in execute this code
					if (!$conn){
						$error = mysqli_connect_error();
						$errno = mysqli_connect_errno();
						print "$errno: $error\n";
						exit();
					}else{//execute code	
							//set logged in user
						$userid = $_SESSION['id'];

						//create query
						$query = 'SELECT p.post_date, u.name, p.text, p.in_reply_to, f.follower_id, p.id,
						(SELECT COUNT(*) FROM post p2 WHERE p2.in_reply_to = p.id ) AS replies
						FROM post p 
						INNER JOIN
						user u
						ON
						p.user_id = u.id
						INNER JOIN
						follow f
						ON 
						f.follower_id = u.id
						WHERE f.user_id=?
						ORDER BY p.post_date DESC LIMIT 10';

						$stmt = mysqli_prepare($conn, $query);

						mysqli_stmt_bind_param($stmt, "i", $userid);
						mysqli_stmt_execute($stmt);

						if($result = mysqli_stmt_get_result($stmt)){
										//get data out of query and save to $row as as assoc array
							while($row = mysqli_fetch_assoc($result)){
											//creates a new div with uniqe ids but same class
								echo '<div class="post-content" id="', $row['id'],'">';
											//display post data
								echo '<h3 class="post-name">', $row['name'], '</h3>';
											//display post id and date posted
								echo '<span>Post#', $row['id'],'  &sdot;', $row['post_date'],'</span>';
								echo '<span><a href="createpost.php?pid=', $row['id'], '">Reply</a></span>';
											//display post text
								echo '<p class="post-text">', $row['text'], '</p>';

								//display reply count on a post if there is any
								if($row['replies'] > 0){
									echo '<span class="replyCount">Replies: '. $row['replies'] . '</span>';
								}
											//check to see if post was a reply
								if(!empty($row['in_reply_to'])){
												//make a anchor link to the div with same id
									echo '<a href="#', $row['in_reply_to'],'"><span>Replying To post #',$row['in_reply_to'],'</span></a>';
								}
								echo '</div>';
							}
						}else{
							echo "failed to set result";
						}

					}
				} ?>
			</div>
		</div>
	</section>
</body>
</html>