<?php include "../accessDB.php"?>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Corey's Student Portal</title>
</head>

<body>
	<h1>Schultz University</h1>
	<h2>Edit Profile</h2> </br>
    
<?php
//connect to database
$accessDB = new accessDB();
$con = $accessDB->connectDB();
$id = $_SESSION['id'];
$password = $_SESSION['password'];

//gather all of the user's info
$sql = "SELECT * FROM tblUser WHERE id='$id' AND password='$password'";
$query = mysqli_query($con, $sql);

//create an array filled with user info
$getrow = mysqli_fetch_array($query, MYSQLI_BOTH);

$id = $getrow[0];
$email = $getrow[1];
$password = $getrow[2];
$firstname = $getrow[3];
$lastname = $getrow[4];
$address = $getrow[5];
$phone = $getrow[6];

//Test to see if info was assigned successfully. Also be friendly.
echo "Hello, $firstname! You can edit your account information on this page.";
?>

<br/><br/>
	<!--Get info from user -->
	<form action="editprof.php" method="POST">
		<label> Your ID is <?php echo $id ?>. This cannot be changed </label>
		Enter e-mail: <input type="email" size="45" max="100" name="email" placeholder="<?php echo $email ?>" required="required" /> <br/> <br/>
		Enter password: <input type="password" name="password" required="required" /> <br/> <br/>
		First Name: <input type="text" name="firstName" size="50" max="100" required="required"/> <br/> <br/>
		Last Name: <input type="text" name="lastName" size="50" max="100" required="required"/> <br/> <br/>
		Address: <input type="text" name="address" size="60" max="100" required="required" /> <br/> <br/>
		Phone Number:<input type="text" max="15" name="phone" required="required" /> <br/> <br/>
		<input type="submit" value="Change Information"/>
	</form>




	
</p>
</br></br>
<a href='./profile.php'>Profile</a></br>
<a href='./classreg.php'>Course Registration</a></br>
<a href='../logout.php'>Log Out</a></br>

</body>
</html>