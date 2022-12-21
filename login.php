<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "sp_project";
session_start();
 
// Unset all of the session variables
$_SESSION = array();

// Create connection
global $conn;
$conn = new mysqli($servername, $username, $password,$dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // collect value of input field
    $name = $_REQUEST['myName'];
	$pass = $_REQUEST['myPass'];
	$disc = $_REQUEST['disc'];
	if (!empty($disc)) {
		disconnect();
	}else{
		if (empty($name) or empty($pass)) {
        	echo "Empty name or password";
	    } else {
	        login($name, $pass, $conn);
	    }
	}
    
}

function login($myName, $pass, $connec){
	$sql = "Select * from users where name = '"  . $myName."' AND password = '". $pass ."';";
	if (!$connec->query($sql)) {
		echo "Error in the query";
	}else{
		$res = $connec->query($sql);
		if ($res->num_rows > 0) {
		 while($row = $res->fetch_assoc()) {
		 	if ($row["id"] == 0) {
		 		echo "Welcome back " . $row["Name"] . " " . $row["Surname"] . "<br>";
		 		$sql = "Select * from users where id = 2";
		 		$res = $connec->query($sql);
		 		$row = $res->fetch_assoc();
		 		echo "<b>" . $row["Password"] . "</b>";
		 		$_SESSION["loggedin"] = True;
		 		echo '<form action="login.php" method="post">';
				echo '<input type="submit" name="disc" value="Disconnect">';
				echo '</form>';
 		 		break;
		 	}else{
		 		echo "Welcome back " . $row["Name"] . " " . $row["Surname"];
		 		$_SESSION["loggedin"] = True;
		 		echo '<form action="login.php" method="post">';
				echo '<input type="submit" name="disc" value="Disconnect">';
				echo '</form>';


		 	}
		  }
		} else {
		  echo "Error while trying to log in";
		}
	}
}

function disconnect(){
	$_SESSION["loggedin"] = False;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>My Secure Login</title>
</head>
<body>

<?php 
if (!isset($_SESSION["loggedin"]) OR $_SESSION["loggedin"] != True) {
	echo '<form action="login.php" method="post">';
	echo 'Name : <input type="text" name="myName"><br>';
	echo 'Password : <input type="password" name="myPass"><br>';
	echo '<input type="submit">';
	echo '</form>';
}
?>

	
</form>

</body>
</html>