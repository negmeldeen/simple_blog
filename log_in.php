<html>
<?php
$page_title = "Login";
include_once('blog.php');
if (loggedin()) {
	header("location:index.php");
}

if (isset($_POST['login'])){
	$remeber_me=false;
	$username=$_POST['username'];
	$password=$_POST['password'];
	if(isset($_POST['remeber_me']))
		$remeber_me=$_POST['remeber_me'];
if ($username && $password) {
$login=mysql_query("SELECT * FROM user_data WHERE name='$username'");
while ($row=mysql_fetch_assoc($login)) {
	$db_password=$row['password'];
	if(md5($password)==$db_password){
		$loginok=TRUE;
	}
	else{
		$loginok=FALSE;
	}
	if ($loginok==TRUE) {
		

		if ($remeber_me=="on"){
			setcookie("username",$username,time()+7200);
			
		}
		else if($remeber_me==""){
			$_SESSION['username']=$username;
		}
		header("location:index.php");
	}
	else{
		die("incorrect username /password");
	}
}
}
else 
	die("please enter username and password");
}

?>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-push-2">
<form action="log_in.php" method="post">
	<div class="input-group">
  <span class="input-group-addon">Username</span>
<input id="username" type="text" name="username" class="form-control">
</div>
</br>
	<div class="input-group">
  <span class="input-group-addon">Password</span>
<input id="password" type="password" name="password" class="form-control">
</div>
</br>
	<div class="input-group">
<input type="checkbox" name="remeber_me"> <label>Remember me</label>
</div>
<input type="submit"name="login" value="log in" class="btn btn-default">
</form>
</div></div></div>
</body>
</html>