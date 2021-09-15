

<?php 
ob_start();
session_start();
$pagetitle='الصفحة الرئيسية';

if(isset($_SESSION['id'])){ 

include('server.php');
include'init.php';
include 'includes/templates/navbar.php';

?>

<!-- start slider --> 

<div class="slider">
	
	<div class="owl-carousel owl-theme">
		        <div class="item"><img src="img/1.jpg"></div>
				<div class="item"><img src="img/2.jpg"></div>
				<div class="item"><img src="img/3.jpg"></div>
		        <div class="item"><img src="img/4.jpg"></div>
		        <div class="item"><img src="img/5.jpg"></div>
		        <div class="item"><img src="img/6.jpg"></div>
		        <div class="item"><img src="img/7.jpg"></div>
				<div class="item"><img src="img/8.jpg"></div>
				<div class="item"><img src="img/9.jpg"></div>
		        <div class="item"><img src="img/10.jpg"></div>
		        <div class="item"><img src="img/11.jpg"></div>
		        <div class="item"><img src="img/12.jpg"></div>
    </div>
	
</div>
	
	
	
<!-- end slider --> 
<div class="container">
<div class="row">
<div class="posts-wrapper">
   <?php foreach ($posts as $post): ?>
   	<div class="post">
	<div class="col-md-3 col-sm-6 col-xs-12" style="margin-top: 25px;">
	<img src="user_images/<?php echo $post['userPic']; ?>" class="img-rounded" width="250px" height="250px" />

      <?php //echo $post['text']; ?>
      <div class="post-info">
	    <!-- if user likes post, style button differently -->
      	<i <?php if (userLiked($post['id'])): ?>
      		  class="fa fa-thumbs-up like-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $post['id'] ?>"></i>
      	<span class="likes"><?php echo getLikes($post['id']); ?></span>
      	
      	&nbsp;&nbsp;&nbsp;&nbsp;

	    <!-- if user dislikes post, style button differently -->
      	<i 
      	  <?php if (userDisliked($post['id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-down dislike-btn"
      	  <?php endif ?>
      	  data-id="<?php echo $post['id'] ?>"></i>
      	<span class="dislikes"><?php echo getDislikes($post['id']); ?></span>
      </div>
		</div>
   	</div>
   <?php endforeach ?>
  </div>
</div>
</div>


<?php

}else{

	
	
include'init.php';
include 'includes/templates/navbar.php';




?>

<!-- start slider --> 

<div class="slider">
	
	<div class="owl-carousel owl-theme">
		        <div class="item"><img src="img/1.jpg"></div>
				<div class="item"><img src="img/2.jpg"></div>
				<div class="item"><img src="img/3.jpg"></div>
		        <div class="item"><img src="img/4.jpg"></div>
		        <div class="item"><img src="img/5.jpg"></div>
		        <div class="item"><img src="img/6.jpg"></div>
		        <div class="item"><img src="img/7.jpg"></div>
				<div class="item"><img src="img/8.jpg"></div>
				<div class="item"><img src="img/9.jpg"></div>
		        <div class="item"><img src="img/10.jpg"></div>
		        <div class="item"><img src="img/11.jpg"></div>
		        <div class="item"><img src="img/12.jpg"></div>
    </div>
	
</div>
	
	
	
<!-- end slider --> 
	
	
 
<!-- start photo --> 

<div class="container">
<div class="row">

<?php



	$stmt = $con->prepare('SELECT * FROM tbl_users where sendid=1');
	$stmt->execute();

	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
			<div class="col-md-3 col-sm-6 col-xs-12" style="margin-top: 25px;">
				<img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
				
				<div class="input-login-su2" style="text-align: center;">
					<a href="signup.php" class="form-control btn like"> التصويت هنا </a>
				</div>
				
			</div>       
			<?php
		}
	}
	else 
	{
		?>
      
        <?php
	}
	
?>
</div>	
</div>
<!-- end photo --> 
	




<?php 

}
include $tpl.'footer.php';

ob_end_flush();

?> 
 
<!-- end footer --> 


<!-- start ajax --> 



<script>
$(document).ready(function(){

// if the user clicks on the like button ...
$('.like-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
  	action = 'like';
  } else if($clicked_btn.hasClass('fa-thumbs-up')){
  	action = 'unlike';
  }
  $.ajax({
  	url: 'index.php',
  	type: 'post',
  	data: {
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  		res = JSON.parse(data);
  		if (action == "like") {
  			$clicked_btn.removeClass('fa-thumbs-o-up');
  			$clicked_btn.addClass('fa-thumbs-up');
  		} else if(action == "unlike") {
  			$clicked_btn.removeClass('fa-thumbs-up');
  			$clicked_btn.addClass('fa-thumbs-o-up');
  		}
  		// display the number of likes and dislikes
  		$clicked_btn.siblings('span.likes').text(res.likes);
  		$clicked_btn.siblings('span.dislikes').text(res.dislikes);

  		// change button styling of the other button if user is reacting the second time to post
  		$clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
  	}
  });		

});

// if the user clicks on the dislike button ...
$('.dislike-btn').on('click', function(){
  var post_id = $(this).data('id');
  $clicked_btn = $(this);
  if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
  	action = 'dislike';
  } else if($clicked_btn.hasClass('fa-thumbs-down')){
  	action = 'undislike';
  }
  $.ajax({
  	url: 'index.php',
  	type: 'post',
  	data: {
  		'action': action,
  		'post_id': post_id
  	},
  	success: function(data){
  		res = JSON.parse(data);
  		if (action == "dislike") {
  			$clicked_btn.removeClass('fa-thumbs-o-down');
  			$clicked_btn.addClass('fa-thumbs-down');
  		} else if(action == "undislike") {
  			$clicked_btn.removeClass('fa-thumbs-down');
  			$clicked_btn.addClass('fa-thumbs-o-down');
  		}
  		// display the number of likes and dislikes
  		$clicked_btn.siblings('span.likes').text(res.likes);
  		$clicked_btn.siblings('span.dislikes').text(res.dislikes);
  		
  		// change button styling of the other button if user is reacting the second time to post
  		$clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
  	}
  });	

});

});


</script>
        
