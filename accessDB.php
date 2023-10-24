<?php include "../createDB.php"?>

<?php
class AccessDB
  {
	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $databasename = "studentPortal";

	
	public function executeSelectQuery($con, $sql)
	  {
		$result = mysqli_query($con, $sql);
		if (!$result)
		  {
			die('Error using that SELECT query: ' . mysqli_error($con));
		  }
		return $result;
	  }

	public function executeQuery($con, $sql)
	  {
		$result = mysqli_query($con, $sql);
		if (!$result)
		  {
			die("Error executing query: " . mysqli_error($con));
		  }
		  return $result;
	  }

	public function connectDB()
	  {
		$con = mysqli_connect($this->host, $this->username, $this->password, $this->databasename);
		if (!$con)
		  {
			die("Error connecting to database: " . mysqli_error($con));
		  }
		return $con;
	  }

	public function closeConnect($con)
	  {
		mysqli_close($con);
	  }

  }

?>