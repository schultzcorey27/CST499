

<?php
$host = "localhost";
$username = "root";
$password = "";
$databasename = "studentPortal";

//Create the connection
$conn = mysqli_connect($host, $username, $password);

//Check the connection
if (!$conn)
  {
    die("Connection failed. Here's why: " . mysqli_connect());
  }

//Initiate the database
$sql = "CREATE DATABASE IF NOT EXISTS $databasename";
if (!mysqli_query($conn, $sql))
  {
	echo "Sorry, there was an error in creating the database: " . mysqli_error($conn);
  }

//Select the DB
mysqli_select_db($conn, $databasename);

//Make the user table
$sql2 = "CREATE TABLE IF NOT EXISTS studentPortal.tblUser
  (
	id INT(8) UNSIGNED PRIMARY KEY,
	email VARCHAR(100) NOT NULL,
	password VARCHAR(100) NOT NULL,
	firstName VARCHAR(100) NOT NULL,
	lastName VARCHAR(100) NOT NULL,
	address VARCHAR(100) NOT NULL,
	phone VARCHAR(15) NOT NULL
  )";
if (!mysqli_query($conn, $sql2))
  {
	echo 'Error creating table:' . mysqli_error($conn);
  } 

//Make the login table
$sql3 = "CREATE TABLE IF NOT EXISTS tblLogin
  (
	id INT(8) UNSIGNED PRIMARY KEY,
	password VARCHAR(100) NOT NULL
  )";
 if (!mysqli_query($conn, $sql3))
  {
	echo 'Error creating table:' . mysqli_error($conn);
  } 

//Make the enrollment table

$sql4 = "CREATE TABLE IF NOT EXISTS tblEnroll
  (
    pkey INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sid INT(8),
    cid INT(4)
  )";

 if (!mysqli_query($conn, $sql4))
  {
	echo 'Error creating table:' . mysqli_error($conn);
  } 

//Create the course table
$sql5 = "CREATE TABLE IF NOT EXISTS tblCourse
(
cid INT(4) UNSIGNED PRIMARY KEY,
cname VARCHAR(100) NOT NULL,
cdesc VARCHAR(100) NOT NULL,
pname VARCHAR(50) NOT NULL,
csem VARCHAR(20) NOT NULL,
numenroll INT(3) NOT NULL,
numwait INT(3) NOT NULL
)";
 if (!mysqli_query($conn, $sql5))
  {
	echo 'Error creating table:' . mysqli_error($conn);
  } 

//Populate the course table with data
$sql6 = "INSERT IGNORE INTO studentPortal.tblCourse(cid, cname, cdesc, pname, csem, numenroll, numwait) VALUES 
(1001, 'Intro to Computer Science', 'An introductory look at object-oriented principles and practices.', 'Jacob Teacher', 'Fall', 16, 0),
(1002, 'Data Structures and Algorithms', 'An analysis of the data structures and algorithms typically used in OOP.', 'Leeroy Haidt', 'Spring', 25, 0),
(1003, 'Data Security', 'A breakdown of the best practices and common techniques in data security.', 'Jonathan Lock', 'Summer', 17, 0),
(2001, 'History of the World', 'An introduction to world history, starting with early human development.', 'Bron Zage', 'Fall', 10, 0),
(2014, 'History of the US', 'The entire history of the United States, from the Revolutionary War to modern times.', 'Benjamin Flankrin', 'Spring', 30, 9), 
(2055, 'History of Australia', 'An analysis of the complete history of Australia since the country was founded.', 'Kang Wallaby', 'Summer', 11, 0) 
"; 
  if (!mysqli_query($conn, $sql6))
  {
	echo 'Error populating table:' . mysqli_error($conn);
  } 
  

//connection is closed
mysqli_close($conn);
?>