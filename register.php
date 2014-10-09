<?php
    if(isset($_POST['submit2'])) {
      // This is a *good* example of how you can implement password-based user authentication in your web application.
 
require 'connectionToMySQL.php';
 
// Use a prepared statement
$stmt = $mysqli->prepare("insert into account (username, password) values (?,?)");
 
// Bind the parameter
$username = $_POST['userName2'];
$password = $_POST['passWord2'];

$password = crypt($password);

$stmt->bind_param('ss', $username,$password);

$stmt->execute();
header("Location:login.php");
    }
?>