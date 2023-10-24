<?php
session_start();
unset($_SESSION['id']);
session_destroy();

//set location to reroute to after logout
header("location:http://localhost/student-portal/index.php");
?>