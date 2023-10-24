<?php include "../accessDB.php"?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Corey Schultz's Student Portal</title>
</head>

<body>
	<h1>Schultz University</h1>
	<h2>Registration</h2>
	<br/><br/>
	<!--Get info from user -->
	<form action="registration.php" method="POST">
		Enter an 8-digit ID number: <input type="number" size="8" max="99999999" name="id" required="required" /> <br/> <br/>
		Enter e-mail: <input type="email" size="45" max="100" name="email" required="required" /> <br/> <br/>
		Enter password: <input type="password" name="password" required="required" /> <br/> <br/>
		First Name: <input type="text" name="firstName" size="50" max="100" required="required"/> <br/> <br/>
		Last Name: <input type="text" name="lastName" size="50" max="100" required="required"/> <br/> <br/>
		Address: <input type="text" name="address" size="60" max="100" required="required" /> <br/> <br/>
		Phone Number:<input type="text" max="15" name="phone" required="required" /> <br/> <br/>
		<input type="submit" value="Register"/>
	</form>
	<!--show links in footer-->
	</br></br>
	<a href="../index.php">Home</a></br>
	<a href="./login.php">Login</a></br>
	<a href="./registration.php">Registration</a></br>

</body>
</html>

<?php
$accessDB = new accessDB();
$con = $accessDB->connectDB();

//If user has submitted the form, the values that were submitted are stored as variables
if($_POST)
{
	$id = $_REQUEST['id'];
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$firstName = $_REQUEST['firstName'];
	$lastName = $_REQUEST['lastName'];
	$address = $_REQUEST['address'];
	$phone = $_REQUEST['phone'];


	//Variables' values get inserted into main user database
	$sql = "INSERT INTO studentPortal.tblUser(id, email, password, firstName, lastName, address, phone) VALUES ('$id', '$email', '$password', '$firstName', '$lastName', '$address', '$phone')";

	if($accessDB->executeQuery($con, $sql))
	  {
		echo "<h4>Thank you for registering!";
	  }
	else
	  {
		echo "Error: " . mysqli_error($con);
	  }

	//The ID and password values also get inserted into the login database
	$sql2 = "INSERT INTO studentPortal.tblLogin(id, password) VALUES ('$id', '$password')";
	if($accessDB->executeQuery($con, $sql2))
	  {
	  echo "<h4>Login information saved.";
	  }
 	else
	  {
	  echo "Error: " . mysqli_error($con);
	  }

}
//close connection
  $accessDB->closeConnect($con);
?>