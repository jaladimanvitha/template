<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<title>Assignment</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles/layout.css" type="text/css">
<style>
input[type=text],input[type=password],select{
    width: 40%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid grey;
    border-radius: 4px;
    box-sizing: border-box;
}
input:hover{border: 1px solid black;}
select:hover{border: 1px solid black;}
input[type=submit],input[type=reset] {
background-color:grey;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius : 5px;	
}
input[type=submit]:hover,input[type=reset]:hover {
background-color:#424851;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;    
}
.login {

border-radius : 20px;
padding-left : 60px;
margin-right : 50px;
padding-top : 5%;
padding-bottom : 11%;

}

</style>
<?php
session_start();
$login=$_SESSION['user'];

?>
<?php

	$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}else {
	$query='select * from customer where user_name="'.$login.'"' or die("Connection failed: " . mysqli_connect_error());
    $search = mysqli_query($conn,$query);
	$array = mysqli_fetch_row($search);
}
?>
</head>
<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <div align="center" id="hgroup">
	<h1>Welcome  <?php echo $array[0]; ?></h1>
    </div>
    <nav>
      <ul>
	    <li><a href="edit.php">Home</a></li>
        <li class="last"><a href="index.html">Logout</a></li>
      </ul>
    </nav>
  </header>
</div>
<div class="wrapper row2">
  <div id="container" class="clear">
  <p style="color:black"><b>Email: </b> <?php echo $array[2]; ?><p>
  <p style="color:black"><b>Phone: </b>  <?php echo $array[3]; ?><p>
  <p style="color:black"><b>Location: </b><?php echo $array[5]; ?><p>
  <h1><a href="edit.php" style="font-size:22px">Edit Info</a></h1>
    <div class="edit">
	<?php 
	if(isset($_POST['submit'])) {
		$newpass = $_POST['pass'];
	$newpass1 = $_POST['pass1'];
	$email=$_POST['email'];
	$contact=$_POST['contact'];
	$location=$_POST['location'];
	if($newpass!=$newpass1){
		$message="Password mismatch";
	} else if(empty($location)){
		$message="Please Select the location";	
	} else if(strlen($contact) !=10) {
		$message="Mobile number length mismatch";
	} else {
		Try {
		$sql = "UPDATE customer SET password='".$newpass."',Email='".$email."',Phone='".$contact."',Location='".$location."' WHERE user_name='".$login."'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		if ($stmt->execute()) {
				$message="Record updated successfully";
		} else {
				$message="Error updating record: " . $conn1->error;
		}
	}catch(Exception $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}
	} 
 mysqli_close($conn);
	?>
	<form action="" method="POST">
			<p><b>Enter the New Password</b></br>
				<input type="password" name="pass" placeholder="Please choose a password" required/></p>
<p><b>Confirm Password</b></br>
				<input type="password" name="pass1" placeholder="Please confirm the password" required/></p>
<p><b>Updated Email Address</b></br>
<input type="text" name="email" placeholder="example@gmail.com" required/><p>

<p><b>Updated Mobile Number</b></br>
<input type="text" name="contact" placeholder="Mobile No." required/></p>

<p><b>Enter the new Location</b></br>
<select name="location" required>
 <option value="">Select</option>
 <option value="Bangalore">Bangalore</option>
 <option value="Chennai">Chennai</option>
 <option value="Delhi">Delhi</option>
 <option value="Pune">Pune</option>
 <option value="Mumbai">Mumbai</option>
</select></p>

<p><input type="submit" name="submit" id="sub" value="Edit Info"/><span><input type="reset" name="reset" id="res" value="Cancel"/></p></span>
</form>
	<p style="color:red"> <?php 
      if(isset($message)){
		  header("Refresh:0");
        echo $message;
      }
    ?></p>
	</div>
  </div>
</div>

<div class="wrapper row3">
  <footer id="footer" class="clear">
    <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Manvitha</a></p>
    <p class="fl_right"><a href="#">Tech Mahindra</a></p>
  </footer>
</div>
</body>
</html>
