

<?php 
ob_start();
session_start();
$pagetitle='صفحة التحكم';
include'init.php';
include 'includes/templates/navbaradmin.php';


if(isset($_SESSION['idadmin'])){ 

$do=isset($_GET['do'])?$_GET['do']:'manage';

	if($do == 'manage'){//manage photo page
	$stmt=$con->prepare("select * from tbl_users where sendid =0");
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
		
		<td>التحكم</td>
		<td>رقم الصور</td>
		<td>الصور</td>
		<td>رقم المستخدم</td>
		<td>اسم المستخدم</td>
	<?php
	foreach($rows as $row ){
		$iduser = $row['client_id'];
		
		
		echo "<tr>";
		
		echo "<td>
		<a href='indexadmin.php?do=update&id=".$row['id']."'class='btn btn-success'><i class='fa fa-edit'></i> قبول</a>
		<a href='indexadmin.php?do=delete&id=".$row['id']."'class='btn btn-danger confirm'><i class='fa fa-close'></i> رفض</a>
		</td>";
		
		echo "<td>".$row['id']."</td>";
		echo "<td><img src='user_images/". $row['userPic'] ."' class='img-rounded' width='250px'' height='250px' /></td>";
		
		
		
		echo "<td>".$row['client_id']."</td>";
		
				//$stmt=$con->prepare("SELECT * FROM users JOIN tbl_users on tbl_users.client_id = users.userid WHERE userid= ? ");
                 $stmt=$con->prepare("select username from users where userid = ?");
				
				//execute the statment
				$stmt->execute(array($iduser));
				//assign to variable
				$row=$stmt->fetch();
		
				if($stmt->rowCount()>0){


				$count=$stmt->rowCount();
		
				
				

					echo "<td>".$row['username']."</td>";

				}
		
		
		
	}
		
				echo "</tr>";

				?>
	
	
	
	</table>
</div>

	</div>

<?php
	
	
	
}elseif($do == 'update'){
		
		
	echo "<h1 class='text-center'>قبول الصورة</h1>";
	echo "<div class='container'>";
		
$id=isset($_GET['id'])&& is_numeric($_GET['id'])? intval($_GET['id']):0;


$stmt=$con->prepare("select * from tbl_users where id=?");


$stmt->execute(array($id));


$row=$stmt->fetch();

$count=$stmt->rowCount();

	if($stmt->rowCount()>0){
		//get variable from the form
		$id=$row['id'];
		$userPic=$row['userPic'];
		$client_id=$row['client_id'];

		
		$stmt=$con->prepare("update tbl_users set sendid=1, userPic=?, client_id=?  where id=?");
		$stmt->execute(array($userPic,$client_id,$id));
		//echo success message
		echo "<div class='alert alert-success'>".$stmt->rowcount().' تم قبول الصورة </div>';
		header("refresh:3;url=indexadmin.php");
	
	    echo "</div>";
		
	}
	
}elseif($do == 'delete'){//delete member page
	echo "<h1 class='text-center'>رفض الصورة</h1>";
	echo "<div class='container'>";
//check if get request userid is numeric & get the integer value of it
$id=isset($_GET['id'])&& is_numeric($_GET['id'])? intval($_GET['id']):0;
//select all data depend on this id
$stmt=$con->prepare("select * from tbl_users where id=? limit 1");
//execute query
$stmt->execute(array($id));
//the row count
$count=$stmt->rowCount();
//if there's such id show the form
	if($stmt->rowCount()>0){
	$stmt=$con->prepare("delete from tbl_users where id=:zid");
	$stmt->bindparam(":zid",$id);
	$stmt->execute();
		echo"<div class='alert alert-danger'>".$stmt->rowcount().' تم رفض الصورة بنجاح  </div>';
		header("refresh:3;url=indexadmin.php");
}else{
		echo 'this id is not exist';
}
	echo '</div>';
}
	
	















}else{

	
	






}
include $tpl.'footer.php';

ob_end_flush();

?> 
 
<!-- end footer --> 


