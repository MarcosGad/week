<?php 
// connect to database
//$conn = mysqli_connect('localhost', 'root', '', 'likedislike');
include'connect.php'; 
// lets assume a user is logged in with id $user_id

$user_id = $_SESSION['id'] ;


// if user clicks like or dislike button
if (isset($_POST['action'])) {
  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'like':
         $stmt=$con->prepare("INSERT INTO rating_info (user_id, post_id, rating_action) 
         	   VALUES ($user_id, $post_id, 'like') 
         	   ON DUPLICATE KEY UPDATE rating_action='like'");
        //$stmt->execute();
         break;
  	case 'dislike':
          $stmt=$con->prepare("INSERT INTO rating_info (user_id, post_id, rating_action) 
               VALUES ($user_id, $post_id, 'dislike') 
         	   ON DUPLICATE KEY UPDATE rating_action='dislike'");
          //$stmt->execute();
         break;
  	case 'unlike':
	      $stmt=$con->prepare("DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id");
          //$stmt->execute();
	      break;
  	case 'undislike':
      	  $stmt=$con->prepare("DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id");
          //$stmt->execute();
      break;
  	default:
  		break;
  }

  // execute query to effect changes in the database ...
  $stmt->execute();
  echo getRating($post_id);
  exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
  global $con;
  $stmt=$con->prepare("SELECT COUNT(*) FROM rating_info 
  		  WHERE post_id = $id AND rating_action='like'");
  $rs = $stmt->execute();
  $result = $stmt->fetch();
  return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{
  global $con;
  $stmt=$con->prepare("SELECT COUNT(*) FROM rating_info 
  		  WHERE post_id = $id AND rating_action='dislike'");
  $rs = $stmt->execute();
  $result = $stmt->fetch();
  return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
  global $con;
  $rating = array();
  $likes_query = $stmt=$con->prepare("SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'");
  $likes_rs = $stmt->execute();
  $likes = $stmt->fetch();
    
  $dislikes_query = $stmt=$con->prepare("SELECT COUNT(*) FROM rating_info 
		  			WHERE post_id = $id AND rating_action='dislike'");
  $dislikes_rs = $stmt->execute();
  $dislikes = $stmt->fetch();
    
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  global $con;
  global $user_id;
  $stmt=$con->prepare("SELECT * FROM rating_info WHERE user_id=$user_id 
  		  AND post_id=$post_id AND rating_action='like'");
  $result = $stmt->execute();
  if ($stmt->rowCount($result) > 0) { 
  	return true;
  }else{
  	return false;
  }
}

// Check if user already dislikes post or not
function userDisliked($post_id)
{
  global $con;
  global $user_id;
  $stmt=$con->prepare("SELECT * FROM rating_info WHERE user_id=$user_id 
  		  AND post_id=$post_id AND rating_action='dislike'");
  $result = $stmt->execute();
  if ($stmt->rowCount($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}

$stmt=$con->prepare("SELECT * FROM tbl_users where sendid=1");
$result =$stmt->execute();
// fetch all posts from database
// return them as an associative array called $posts
$posts = $stmt->fetchall();
	
