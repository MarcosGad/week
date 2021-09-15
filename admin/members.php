<?php
/*
========================================================
==manage members page
==you can add|edit|delete members from here
========================================================
*/
session_start();
$pagetitle='members';
if(isset($_SESSION['username'])){
	include 'init.php';
$do=isset($_GET['do'])?$_GET['do']:'manage';
//start manage page
//select all users except admin
if($do == 'manage'){//manage members page
	$value="sameh";
	$check=checkitem("username","users",$value);
	if($check==1){
		echo 'cool';
	}
	$stmt=$con->prepare("select * from users where groupid !=1");
	//execute the statment
	$stmt->execute();
	//assign to variable
	$rows=$stmt->fetchall();
?>

<h1 class="text-center">ادارة الاعضاء </h1>
<div class="container">
<div class="table-responsive">
<table class="main-table text-center table table-bordered ">
	<tr>
		<td>الرقم</td>
		<td>الاسم</td>
		<td>البريد الألكتروني</td>
		<td>الاسم بالكامل </td>
		<td>التحكم</td>
	<?php
	foreach($rows as $row ){
		echo "<tr>";
		echo "<td>".$row['userid']."</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td>".$row['email']."</td>";
		echo "<td>".$row['fullname']."</td>";
		echo "<td></td>";
		echo "<td>
		<a href='members.php?do=edit&userid=".$row['userid']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
		<a href='members.php?do=delete&userid=".$row['userid']."'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>
		</td>";
		echo "</tr>";
	}
	?>
	
	
	
	</table>
</div>
		<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> أضافة عضو جديد </a>

	</div>

<?php
	}elseif($do == 'add'){//add members page?>
	<h1 class="text-center">اضافة عضو جديد</h1>;
	<div class="container">
	<form class="form-horizontal" action="?do=insert" method="POST">
		<!--start username field-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">الأسم</label>
		<div class="col-sm-10 col-md-6">
			<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="" />
		</div>
		</div>
		<!--end username field-->
		<!--start password field-->
		<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">كلمة السر</label>
			<div class="col-sm-10 col-md-6">
			<input type="password" name="password" class="password form-control" autocomplete="new-password" required="required"  placeholder="" />
			<i class="show-pass fa fa-eye fa-2x"></i>
			</div>
		</div>
		<!--end password field-->
		<!--start email field-->
	<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">الأيميل الألكتروني</label>
		<div class="col-sm-10 col-md-6">
			<input type="email" name="email" class="form-control" required="required"  placeholder=""/>
		</div>
	</div>
	<!--end email field-->
	<!--start fullname field-->
	<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">الأسم بالكامل</label>
		<div class="col-sm-10 col-md-6">
			<input type="text" name="full" class="form-control" required="required" placeholder=""/>
		</div>
	</div>
	<!--end fullname field-->
	<!--start submit field-->
	<div class="form-group form-group-lg">
	<div class="col-sm-offset-2 col-sm-10">
		<input type="submit" value="أضافة عضو" class="btn btn-primary btn-lg"/>
		</div>
	</div>
	<!--end submit field-->
		</form>

</div>
<?php 
}elseif($do=='insert'){
	//insert member page
	if($_SERVER['REQUEST_METHOD']=='POST'){
		echo "<h1 class='text-center'>Insert Member</h1>";
		echo "<div class='container'>";
		//get variables from the form
		$user=$_POST['username'];
		$pass=$_POST['password'];
		$email=$_POST['email'];
		$name=$_POST['full'];
		$hashpass=sha1($_POST['password']);
		//validate the form
		$formerrors=array();
		if(strlen($user) < 4){
			$formerrors[]='username cant be less than <strong>4 characters</strong>';
		}
		if(strlen($user)>20){
			$formerrors[]='username cant be more than <strong>20 characters</strong>';
		}
		if(empty($user)){
			$formerrors[]='username cant be <strong>empty</strong>';
		}
		if(empty($name)){
			$formerrors[]='fullname cant be <strong>empty</strong>';
		}
		if(empty($email)){
			$formerrors[]='email cant be <strong>empty</strong>';
		}
		//loop into errors array and echo it
		foreach($formerrors as $error){
			echo '<div class="alert alert-danger">'.$error.'</div>';
		}
		//check if there's no error proceed the insert operation
		if(empty($formerrors)){
			
		// check if user exist in datebase
		
			$check = checkItem("username" , "users" , $user); 
			
			if ($check == 1){
				
				$theMsg='<div class="alert alert-danger">Sorry This User Is Exist</div>';
				
				redirctHome($theMsg , 'back'); 
			
				
			}else{
			
		//insert user info in database
		$stmt=$con->prepare("insert into 
		users (username,password,email,fullname)
		values(:zuser, :zpass, :zmail, :zname)");
		$stmt->execute(array(
		'zuser'=>$user,
		'zpass'=>$hashpass,
		'zmail'=>$email,
		'zname'=>$name
		));
		//echo success message
		echo "<div class='alert alert-success'>".$stmt->rowcount().' record inserted</div>';
		}
		}else{
		$errormsg='sorry you cant browse this page directly';
		redirecthome($errormsg);
	}
	
	echo "</div>";
	}
		
	}


elseif($do == 'edit'){//edit page 
//check if get request userid is numeric & get the integer value of it
$userid=isset($_GET['userid'])&& is_numeric($_GET['userid'])? intval($_GET['userid']):0;
//select all data depend on this id
$stmt=$con->prepare("select * from users where userid=? limit 1");
//execute query
$stmt->execute(array($userid));
//fetch the data
$row=$stmt->fetch();
//the row count
$count=$stmt->rowCount();
//if there's such id show the form
	if($stmt->rowCount()>0){
?>

<h1 class="text-center">تعديل الأعضاء</h1>
<div class="container">
<form class="form-horizontal" action="?do=update" method="POST">
	<input type="hidden" name="userid" value="<?php echo $row['userid']?>"/>
	<!--start username field-->
	<div class="form-group form-group-lg">
	<label class="col-sm-2 control-label">الاسم</label>
		<div class="col-sm-10 col-md-6">
		<input type="text" name="username" class="form-control" value="<?php echo $row['username']?>" autocomplete="off" required="required"/>
		</div>
	</div>
	<!--end username field-->
	<!--start password field-->
	<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">كلمة السر</label>
		<div class="col-sm-10 col-md-6">
		<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder=""/>
		<input type="hidden" name="oldpassword" value="<?php echo $row['password']?>" />
		</div>
	</div>
	<!--end password field-->
	<!--start email field-->
	<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">الأيميل الألكتروني</label>
		<div class="col-sm-10 col-md-6">
			<input type="email" name="email" value="<?php echo $row['email']?>" class="form-control" required="required" />
		</div>
	</div>
	<!--end email field-->
	<!--start fullname field-->
	<div class="form-group form-group-lg">
		<label class="col-sm-2 control-label">الأسم بالكامل</label>
		<div class="col-sm-10 col-md-6">
			<input type="text" name="full" value="<?php echo $row['fullname']?>" class="form-control" required="required"/>
		</div>
	</div>
	<!--end fullname field-->
	<!--start submit field-->
	<div class="form-group form-group-lg">
	<div class="col-sm-offset-2 col-sm-10">
		<input type="submit" value="تعديل العضو" class="btn btn-primary btn-lg"/>
		</div>
	</div>
	<!--end submit field-->
	</form>
</div>

<?php
//if there's no such id show error message
}else{
		echo 'theres no such id';
	}
	
}elseif($do == 'update'){//update page
	echo "<h1 class='text-center'>تعديل العضو</h1>";
	echo "<div class='container'>";
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//get variable from the form
		$id=$_POST['userid'];
		$user=$_POST['username'];
		$email=$_POST['email'];
		$name=$_POST['full'];
		//password trick
		//condition ? true:false
		$pass=empty($_POST['newpassword']) ? $_POST['oldpassword']:sha1($_POST['newpassword']);
		//validate the form
		$formerrors=array();
		if(strlen($user) < 4){
			$formerrors[]='username cant be less than <strong>4 characters</strong>';
		}
		if(strlen($user)>20){
			$formerrors[]='username cant be more than <strong>20 characters</strong>';
		}
		if(empty($user)){
			$formerrors[]='username cant be <strong>empty</strong>';
		}
		if(empty($name)){
			$formerrors[]='fullname cant be <strong>empty</strong>';
		}
		if(empty($email)){
			$formerrors[]='email cant be <strong>empty</strong>';
		}
		//loop into errors array and echo it
		foreach($formerrors as $error){
			echo '<div class="alert alert-danger">'.$error.'</div>';
		}
		//check if there's no error proceed the update operation
		if(empty($formerrors)){
		//update the database with this info
		$stmt=$con->prepare("update users set username=?,email=?,fullname=?,password=? where userid=?");
		$stmt->execute(array($user,$email,$name,$pass,$id));
		//echo success message
		echo "<div class='alert alert-success'>".$stmt->rowcount().' record updated</div>';
		}
		
		
	}else{
		echo 'sorry you cant browse this page directly';
	}
	
	echo "</div>";
}elseif($do == 'delete'){//delete member page
	echo "<h1 class='text-center'>Delete Member</h1>";
	echo "<div class='container'>";
//check if get request userid is numeric & get the integer value of it
$userid=isset($_GET['userid'])&& is_numeric($_GET['userid'])? intval($_GET['userid']):0;
//select all data depend on this id
$stmt=$con->prepare("select * from users where userid=? limit 1");
//execute query
$stmt->execute(array($userid));
//the row count
$count=$stmt->rowCount();
//if there's such id show the form
	if($stmt->rowCount()>0){
	$stmt=$con->prepare("delete from users where userid=:zuser");
	$stmt->bindparam(":zuser",$userid);
	$stmt->execute();
		echo"<div class='alert alert-success'>".$stmt->rowcount().' Record Deleted</div>';
}else{
		echo 'this id is not exist';
}
	echo '</div>';
}
include $tpl.'footer.php';
	
}else{
	header('location:index.php');
	exit();
}
