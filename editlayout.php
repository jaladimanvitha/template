<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<title>Assignment</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles/layout.css" type="text/css">
<style>
img {
	height :50px;
	width : 80px;
}
input[type=text],input[type=password],select,textarea{
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
#logo {
top : 20%
width:200px;
height:80px;
}
table{
	width:100%; 
	border-collapse:collapse; 
    display: table;
}
td, th {
padding:7px; border:#010101 1px solid;
display: table-cell;
color :black;

}
th {
	background-color : grey;
}
tr:nth-child(odd){ 
	background: grey;
}
	
tr:nth-child(even){
	background: white;
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
	$query='select * from admin where user_name="'.$login.'"' or die("Connection failed: " . mysqli_connect_error());
    $search = mysqli_query($conn,$query);
	$array = mysqli_fetch_row($search);
	$sql1 = 'select * from control';
	$result = mysqli_query($conn,$sql1);
	$headfoo = mysqli_fetch_row($result);
}
?>
</head>
<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <div align="center" id="hgroup">
		<h1><span><a href="#"><?php echo $headfoo[0]; ?></a></span> </h1>
	<br>
	<h2><span><a href="#"><?php echo $headfoo[1]; ?></a></span><br><span><a href="#"><?php echo '<img src="data:image/png;base64,'.base64_encode( $headfoo[2] ).'"/>'; ?></a></span></h2>
    </div>
    <nav>
      <ul>
	    <li><a href="adminhome.php">Home</a></li>
		<li><a href="adminedit.php">Edit Profile</a></li>
		<li><a href="editlayout.php">Edit Header and Footer</a></li>
        <li class="last"><a href="index.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</div>
<div class="wrapper row2">
<br><br>
<h1><a style="font-size:23px">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;Welcome  <?php echo $array[0]; ?><a></h1>
  <div id="container" class="clear">
  <h2>Profile Details</h2>
  <p style="color:black"><b>Email: </b> <?php echo $array[2]; ?><p>
  <p style="color:black"><b>Phone: </b>  <?php echo $array[3]; ?><p>
  <p style="color:black"><b>Location: </b><?php echo $array[5]; ?><p>
  <?php 
	if(isset($_POST['submit'])) {
	$newheader = $_POST['header'];
	$newheadercontent = $_POST['headercontent'];
	 $header_img = $_FILES['header_img']['tmp_name'];
	 $headerimgContent = addslashes(file_get_contents($header_img));
	$newfooter = $_POST['footer'];
	$newfootercontent = $_POST['footercontent'];
	$footer_img = $_FILES['footer_img']['tmp_name'];
	$footerimgContent = addslashes(file_get_contents($footer_img));
	if(empty($newheader)){
		$message="Please Enter the new Header";	
	} else if(empty($newfooter)) {
		$message="Please enter the new Footer";
	} else {
		Try {
		$sql = "UPDATE control SET header='".$newheader."',footer='".$newfooter."',header_content='".$newheadercontent."',footer_content='".$newfootercontent."',header_img='".$headerimgContent."',footer_img='".$footerimgContent."'";
		
		$bool=mysqli_query($conn, $sql);
		
		if (mysqli_query($conn, $sql)) {
				$message="Header and Footer updated successfully";
		} else {
				$message="Error updating record: " . mysqli_error($conn);
		}
	}catch(Exception $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}
	}
	} 
 mysqli_close($conn);
	?>
<div class="editheader-footer">
<form method="POST" enctype="multipart/form-data">
<p><b>New Header</b></br>
				<textarea " name="header" placeholder="Please Enter the new header" required></textarea></p>
<p><b>New Header Content</b></br>
				<textarea " name="headercontent" placeholder="Please Enter the new header content" required></textarea></p>
<p><b> Select Header image to upload:</b><br/><br>
        <input type="file" name="header_img"/></p>

<p><b>New Footer</b></br>
				<textarea name="footer" placeholder="Please Enter the new footer" required></textarea></p>
				
<p><b>New Footer Content</b></br>
				<textarea " name="footercontent" placeholder="Please Enter the new footer content" required></textarea></p>
<p><b> Select footer Image to upload:</b><br/><br>
        <input type="file" name="footer_img"/></p>
<p><input type="submit" name="submit" id="sub" value="Update"/><span><input type="reset" name="reset" id="res" value="Cancel"/></p></span>
</form>
<p style="color:red"> <?php 
      if(isset($message)){
		  echo "<script type='text/javascript'>alert('$message');</script>";
		  
      }
	  
    ?></p>
</div>
  </div>
</div>

<div class="wrapper row3">
  <footer id="footer" class="clear">
  <p class="fl_left"><?php echo $headfoo[3]; ?></p>
	<br>
    <p class="fl_left"><span><a href="#"><?php echo $headfoo[4]; ?></a></span><br><span><a href="#"><?php echo '<img src="data:image/png;base64,'.base64_encode( $headfoo[5] ).'"/>';  ?></a></span></p>
    <p class="fl_right"><a href="#">Tech Mahindra</a></p>
  </footer>
</div>
</body>
</html>