<?php include "../accessDB.php"?>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Corey Schultz's Student Portal</title>
</head>

<body>
	<h1>Schultz University</h1>
	<h2>Login</h2> </br> </br>

<?php
//Show login form by default, then hide login form after user presses "submit" button
if (!isset($_POST['submit']))
{
?>

<form action="login.php" method="post">
	Enter ID: <input type="number" size="8" max="99999999" name="id" required="required" /> <br/> <br/>
	Enter password: <input type="password" name="password" max="100" required="required" /> <br/> <br/>
	<input type="submit" name="submit" value="Login"/>
</form>
</br></br>

<?php
}

//Check if user has submitted something other than blank boxes
if(isset($_POST['submit']) && !empty($_POST['id']) && !empty($_POST['password']))
{
	//store submitted ID and pass
	$id = $_POST['id'];
	$password = $_POST['password'];

	//connect to DB
	$accessDB = new accessDB();
	$con = $accessDB->connectDB();

	//search  DB for matching info
	$sql = "SELECT * FROM tblLogin WHERE id='$id' AND password='$password'";
	$query = $accessDB->executeSelectQuery($con, $sql);

	//Return number of rows where info matches. Which should be 1 row only.
	$numrows = mysqli_num_rows($query);
	if($numrows == 1)
	{
		$_SESSION['id'] = $id;
		$_SESSION['password'] = $password;
		$_SESSION['success'] = "You are now logged in! <br> <br> <br>";
		echo $_SESSION['success'];
		$accessDB->closeConnect($con);  
	}
	else
	{
		echo "Login failed. Please try again </br> </br> </br>";
	}
}

//Output default footer, then output shortened footer when user logs in
if(isset($_SESSION['id']))
{
	echo makeLogFooter();
}
else
{
	echo makeDefFooter();
}
//generate default footer
function makeDefFooter()
{
	$html = "<a href='../index.php'>Home</a></br>";
	$html .= "<a href='./login.php'>Login</a></br>";
	$html .= "<a href='./registration.php'>Registration</a></br>";
	return $html;
}
//generate logged-in footer
function makeLogFooter()
{
	$html = "<a href='./profile.php'>Profile</a></br>";
	$html .= "<a href='./classreg.php'>Course Registration</a></br>";
	$html .= "<a href='../logout.php'>Log Out</a></br>";
	return $html;
}	
?>
</body>
</html>