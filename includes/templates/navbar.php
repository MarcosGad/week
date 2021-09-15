<?php 

//check if user coming from http post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(isset($_POST['login'])) {
	
	$email=$_POST['email'];
	$pass=$_POST['password'];
	$hashpass=sha1($pass);
	//echo $hashpass;
 
	//check if the user exist in database
	$stmt=$con->prepare("select 
							            userid,email,password,username
								from
										users 
							    where 
										email=? 
								and 
										password=?
										
								and
								
										groupid	= 0
							
										limit 1");
	                          
	$stmt->execute(array($email,$hashpass));
	$row=$stmt->fetch();
	$count=$stmt->rowCount();
	//if count>0 this mean the database contain record about this username

	
	if($count>0){
		//print_r($row);
		$_SESSION['user']=$email;//register session name
		$_SESSION['id']=$row['userid'];//register session id
		$_SESSION['name']=$row['username'];//register session id
		header('location:index.php');//redirect to dashboard page
		exit();		
	}
		
	} // end if login 
}

?> 

<?php 

//check if user coming from http post request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if(isset($_POST['login'])) {
	
	$email=$_POST['email'];
	$pass=$_POST['password'];
	$hashpass=sha1($pass);
	//echo $hashpass;
 
	//check if the user exist in database
	$stmt=$con->prepare("select 
							            userid,email,password,username
								from
										users 
							    where 
										email=? 
								and 
										password=?
							
							    and 
								 
								 		groupid	= 1 
										
										limit 1");
	                          
	$stmt->execute(array($email,$hashpass));
	$row=$stmt->fetch();
	$count=$stmt->rowCount();
	//if count>0 this mean the database contain record about this username

	
	if($count>0){
		//print_r($row);
		$_SESSION['useradmin']=$email;//register session name
		$_SESSION['idadmin']=$row['userid'];//register session id
		$_SESSION['nameadmin']=$row['username'];//register session id
		header('location:indexadmin.php');//redirect to dashboard page
		exit();		
	}
		
	} // end if login 
}

?>

<div class="upper-bar">
			 
     <div class="container">
		 
            <div class="row">
				  
		         <div class="brand col-md-6">
                    <p class="header-d wow bounceIn" data-wow-duration="2s" data-wow-offset="200" data-wow-iteration="3">وجه الأسبوع</p>
					<p class="header-b">Face Of The Week</p>
				</div>
				
				<?php 
                if(isset($_SESSION['user'])){
	            
					echo'<div class="user-login">' . '<a class=" btn user-btn" href="logout.php">تسجيل الخروج</a>' . ' ' . $_SESSION['name']. '<span class="user-login-span"> مـــرحـبـا </span>'.'</div>'; 

				}else{
				
				?> 
				
			   	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
					
					<div class="col-md-2"> 
						 <div class="input-login-text">
							<input type="email" class="form-control" name="email" placeholder="البريد الألكتروني" autocomplete="off"> 
						</div>
					</div>
					<div class="col-md-2"> 
						  <div class="input-login-pass">
							<input type="password" class="form-control" name="password" placeholder="كلمة السر" autocomplete="new-password">
						  </div>
					</div>
						<div class="col-md-1">
						<div class="input-login-su1">
							<input type="submit" name="login" class="form-control btn btn-suc" value="دخول">
						</div>
					    </div>
					<div class="col-md-1"> 
						  <div class="input-login-su2">
							 <a href="signup.php" class="form-control btn btn-dan"> الأشتراك </a>
						</div>
					</div>
					
				</form>
				
				<?php } ?> 
				
		     </div>
	  </div>
	 
</div>
                
    
  <!-- end upper-bar -->

<!-- start navbar --> 

<nav class="navbar navbar-inverse">
  <div class="container">
    
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" >
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <!-- <a class="navbar-brand hvr-pop" href="#"><span class="fa-stack fa-lg">
           <i class="fa fa-circle fa-stack-2x"></i>
           <i class="fa fa fa-facebook fa-stack-1x fa-inverse"></i>
       </span></i>
      </a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <li><a class="hvr-push" href="index.php">الرئيسية<span class="sr-only">(current)</span></a></li>
       <li><a class="hvr-push" href="prof.php"> بيانات المتسابق</a></li>
       <li><a class="hvr-push" href="#">تعليمات </a></li>
     </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	
	
 

<!-- end navbar --> 
