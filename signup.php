<?php
session_start(); 
$pagetitle='صفحة الأشتراك';
include'init.php';
include 'includes/templates/navbar.php'; 

if(isset($_SESSION['user'])){

	
	

}else {
	
	

//check if user coming from http post request

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(isset($_POST['signup'])) {
		
		$formerrors = array(); 
		
		$username  = filter_var($_POST['username'] , FILTER_SANITIZE_STRING); 
		$password  = $_POST['password']; 
		$password2 = $_POST['password2']; 
		$email     = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL); 
		
		
			
			
	   if(strlen($username) < 4) {
			
		   $formerrors[] = 'برجاء كتابة 4 حروف للأسم';
				
		}
		
		if(isset($password) && isset($password2)) {
			
			
			if (empty($password)) {
				
				$formerrors[] = 'برجاء كتابة كلمة السر';
			}
			
			//$pass1 = sha1($password); 
			//$pass2 = sha1($password2); 
			
			if(  sha1($password) !== sha1($password2) ) {
				
				$formerrors[] = 'برجاء التأكد ان كلمة السر الأول تساوي كلمة السر الثانية';
			}

		}
		
			
			if(filter_var($email , FILTER_VALIDATE_EMAIL) != true ) {
				
			
				$formerrors[] = 'برجاء كتابة البريد الألكتروني بشكل صحيح'; 
				
			}			
		
		
		//check if there's no error proceed the user add 
		if(empty($formerrors)){
		
			
		// check if user exist in database 
			
		$check = checkItem("email" , "users" , $email); 
			
		if($check == 1 ) {
			
			$formerrors[] = 'هذا الأيميل موجود برجاء كتابة اسم اخر'; 
			
		}else {
		
		//insert user info in database
		$stmt=$con->prepare("insert into 
		users (username,password,email)
		values(:zuser, :zpass, :zmail)");
		$stmt->execute(array(
		'zuser'=>$username,
		'zpass'=> sha1($password),
		'zmail'=>$email,
		));
		//echo success message

			$succesMsg = 'تم التسجيل بنجاح'; 
			header("refresh:3;url=index.php");
		}
		
		}
	
        }
		
	}


?> 

<div class="container sign">
	
<form class="my-form wow bounceIn" data-wow-duration="2s" data-wow-offset="200" data-wow-iteration="1" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		
		<!--start username-->
		<div class="form-group form-group-lg">
		<div class="col-sm-10 col-md-12">
			<input pattern=".{4,}" title="username must be 4 chars" type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="الأسم" />
		</div>
		</div>
		<!--end username-->
	
		<!--start email-->
		<div class="form-group form-group-lg">
		<div class="col-sm-10 col-md-12">
			<input type="email" name="email" class="form-control" autocomplete="off" required="required" placeholder="البريد الألكتروني" />
		</div>
		</div>
		<!--end email-->
		
		<!--start pass-->
		<div class="form-group form-group-lg">
		<div class="col-sm-10 col-md-12">
			<input  minlength="4"  type="password" name="password" class="form-control" autocomplete="off" required="required" placeholder="كلمة السر" />
		</div>
		</div>
		<!--end pass-->
	
		<!--start r-pass-->
		<div class="form-group form-group-lg">
		<div class="col-sm-10 col-md-12">
			<input minlength="4" type="password" name="password2" class="form-control" autocomplete="off" required="required" placeholder="اعادة كلمة السر " />
		</div>
		</div>
		<!--end r-pass-->	
		<!--start submit field-->
			<div class="form-group form-group-lg">
			<div class="col-sm-10 col-md-12">
				<input type="submit" name="signup" value="أشتـــــــــــــرك" class=" btn-lg btn-block btn-sign"/>
				</div>
			</div>
	    <!--end submit field-->
	 
</form>
	
	   <div class="the-errors col-md-12">
		 	
		   <?php 
		   		if(!empty($formerrors)) {
					
					foreach ($formerrors as  $error ) {
						
						echo '<div class="msg error"> '. $error . '</div>'; 
						
					}
				}
	  
	  			if(isset($succesMsg)) {
					
					echo '<div class="msg success"> '. $succesMsg . '</div>'; 
						
				}
		   ?>
		
	   </div>
	
	        

</div>






<?php  }  // end else $_SESSION['user'] 

?> 































<!-- start footer --> 

<?php 

include $tpl.'footer.php';

?> 

<!-- end footer --> 
        