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
	<h2>Course Registration</h2> </br>
    
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

//Header for course reg
echo "Hello, $firstname! Welcome to course registration.";
?>

<!--Output user's info-->
<h3>Course Information</h3>
<p>

<?php
//Take the information for each aspect of the course from the tblCourse database
$courseList = '';
$sql2 = "SELECT * FROM tblCourse ORDER BY cid ASC";
$result = $accessDB->executeQuery($con, $sql2);
while($row = mysqli_fetch_array($result)) {
     $courseList .= '<tr><td style="text-align: center;">' . $row['cid'] . '</td><td style="text-align: center;">' . htmlentities($row['cname'])
	  . '</td><td style="text-align: center;">' . htmlentities($row['cdesc']) . '</td><td style="text-align: center;">' . htmlentities($row['pname']) 
	  . '</td><td>' . htmlentities($row['csem']) . '</td><td style="text-align: center;">'. $row['numenroll'] . '/30' . '</td>
	<td style="text-align: center;">' . $row['numwait'] . '</td><tr>';
}
//Display the list of courses
print '<table cellpadding="3" cellspacing="1" border="1">';
print '<tr>';
print '<th scope="col">Course ID</th>';
print '<th scope="col">Course Name</th>';
print '<th scope="col">Course Description</th>';
print '<th scope="col">Professor Name</th>';
print '<th scope="col">Course Semester</th>';
print '<th scope="col">Number of Enrolled Students</th>';
print '<th scope="col">Number of Students on Waitlist</th>';
print '</tr>';
print $courseList;
print '</table>';
?>

<h3>Register for a Course</h3>
<form action="classreg.php" method="post">
	Enter Course ID: <input type="number" size="4" max="9999" name="cid" required="required" /> <br/> <br/>
	<input type="submit" name="submit" value="Add Course"/>
</form>
</br></br>

<?php

//Check if user has submitted something other than blank boxes
if(isset($_POST['submit']) && !empty($_POST['cid']))
{
	//store submitted Course ID
	$cid = $_POST['cid'];

	//connect to DB
	$accessDB = new accessDB();
	$con = $accessDB->connectDB();

	//Check if numenroll <30, AKA class isn't full
	$enrollcheck = "SELECT numenroll FROM studentPortal.tblCourse WHERE cid=$cid";
	$encheckresult = $accessDB->executeSelectQuery($con,$enrollcheck);
	$getrow2 = mysqli_fetch_array($encheckresult);
	$enrollnum = $getrow2[0];
	if ($enrollnum < 30)
	{
		$sqltest = "INSERT INTO studentPortal.tblEnroll(sid, cid) VALUES($id, $cid)";  
		$query = $accessDB->executeSelectQuery($con, $sqltest);

		if($query)
		{
			$sqlincr = "UPDATE studentPortal.tblCourse SET numenroll = numenroll + 1 WHERE cid=$cid";
			$accessDB->executeQuery($con, $sqlincr);
			$_SESSION['success'] = "You have registered for the class! <br> <br> <br>";
			echo $_SESSION['success'];
			unset($_POST);		//clear $_POST info so a new class can be added or dropped
			$accessDB->closeConnect($con);  
		}
		else
		{
			echo "Course registration failed. Please try again </br> </br> </br>";
		}
	}
	else
	{
		$sqlincr = "UPDATE studentPortal.tblCourse SET numwait = numwait + 1 WHERE cid=$cid";
		echo "Course full, but you have been added to the waitlist! </br> </br> </br>";
	
	}
}
?>

<h3>Drop a Course</h3>
<form action="classreg.php" method="post">
	Enter Course ID: <input type="number" size="4" max="9999" name="cid" required="required" /> <br/> <br/>
	<input type="submit" name="submit2" value="Drop Course"/>
</form>
</br></br>

<?php

//Check if user has submitted something other than blank boxes
if(isset($_POST['submit2']) && !empty($_POST['cid']))
{
	//store submitted Course ID
	$cid = $_POST['cid'];

	//connect to DB
	$accessDB = new accessDB();
	$con = $accessDB->connectDB();

	$sqltest = "DELETE FROM studentPortal.tblEnroll WHERE (cid=$cid AND sid=$id)";  


	$query = $accessDB->executeSelectQuery($con, $sqltest);


	if($query)
	{
		$sqldecr = "UPDATE studentPortal.tblCourse SET numenroll = numenroll - 1 WHERE cid=$cid";
		$accessDB->executeQuery($con, $sqldecr);
		$_SESSION['success'] = "You have successfully dropped this course. <br> <br> <br>";
		echo $_SESSION['success'];
		unset($_POST);		//clear $_POST info so a new class can be added or dropped
		$accessDB->closeConnect($con);  
	}
	else
	{
		echo "Course registration failed. Please try again </br> </br> </br>";
	}
}

?>


</p>
</br></br>
<a href='./profile.php'>Profile</a></br>
<a href='./classreg.php'>Course Registration</a></br>
<a href='../logout.php'>Log Out</a></br>

</body>
</html>