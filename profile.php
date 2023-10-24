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
	<h2>Profile</h2> </br>
    
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

//Test to see if info was assigned successfully
echo "Hello, $firstname! Welcome to your profile page.";
?>

<!--Output user's info-->
<h3>User Information</h3>
<p>
ID: <?php echo $id ?> </br> 
Email: <?php echo $email ?> </br>
Password: <?php echo $password ?> </br>
First Name: <?php echo $firstname ?> </br>
Last Name: <?php echo $lastname ?> </br>
Address: <?php echo $address ?> </br>
Phone Number: <?php echo $phone ?> </br>
</p>

<h3>Class Schedule</h3>
<p>

<?php

//Take the information for each course to which the student is registered and display it
$stuList = '';
$sql2 = "SELECT * FROM tblCourse WHERE cid IN (SELECT cid FROM tblEnroll WHERE sid=$id)";
$result = $accessDB->executeQuery($con, $sql2);
while($row = mysqli_fetch_array($result)) {
     $stuList .= '<tr><td style="text-align: center;">' . $row['cid'] . '</td><td style="text-align: center;">' . htmlentities($row['cname']) 
	 . '</td><td style="text-align: center;">' . htmlentities($row['cdesc']) . '</td><td style="text-align: center;">' . htmlentities($row['pname']) 
	 . '</td><td style="text-align: center;">' . htmlentities($row['csem']) . '</td><td style="text-align: center;">'. $row['numenroll'] . '</td>
	 <td style="text-align: center;">' . $row['numwait'] . '</td><tr>';
}

//Display the list of the student's courses
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
print $stuList;
print '</table>';
?>
</p>
</br></br>
<a href='./profile.php'>Profile</a></br>
<a href='./classreg.php'>Course Registration</a></br>
<a href='../logout.php'>Log Out</a></br>

</body>
</html>