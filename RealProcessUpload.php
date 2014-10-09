<?php
if(isset($_POST['submit3'])) {
session_start();
if($_SESSION['token1'] !== $_POST['token1']){
    die("Request forgery detected");
    }
else{
require 'connectionToMySQL.php';
$username=$_SESSION['user_id'];
$title = $_POST['title'];
$url = $_POST['url'];
$story = $_POST['story'];
 
$stmt1 = $mysqli->prepare("insert into file (username, title, url, story) values(?,?,?,?)");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt1->bind_param('ssss', $_SESSION['user_id'],$title, $url, $story);
 
$stmt1->execute();
$stmt2 = $mysqli->prepare("insert into comment (title, username, comment) values(?,?,'Hi,welcome to my world!')");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt2->bind_param('ss', $title, $_SESSION['user_id']);
$stmt2->execute();
$stmt1->close();
$stmt2->close();

header("Location:upload.php");  
}
}
?>