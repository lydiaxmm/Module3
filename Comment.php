<?php
session_start();
require 'connectionToMySQL.php'; 
if(isset($_POST['HostCommentEdit'])){
    $oldTitle=$_POST['title'];
    $oldComment=$_POST['comment'];
    echo sprintf(
        '<form name="Update" method="post" action="Comment.php">
        <label>NewTitle</label><input type="text" name="NewTitle">
        <label>NewComment</label><input type="text" name="NewComment">
        <input type="hidden" value=%s name="Oldtitle" />
        <input type="hidden" value=%s name="Oldcomment" />
        <input type="submit" name="UpdateHostComment" value="Change!!"/>
        </form>', $oldTitle, $oldComment
        );
    }
if(isset($_POST['UpdateHostComment'])){
    $stmt = $mysqli->prepare("update comment set title=?,comment=? where title=? and comment=?");
    $title= $_POST['NewTitle'];
    $comment= $_POST['NewComment'];
    $oldTitle=$_POST['Oldtitle'];
    $oldcomment=$_POST['Oldcomment'];
    $stmt->bind_param('ssss',$title, $comment,$oldTitle,$oldcomment);
    $stmt->execute();
    header("Location:upload.php");
    
}

 
if(isset($_POST['HostCommentDeleteOwn'])){
    $stmt = $mysqli->prepare("delete FROM comment WHERE title=? and comment=?");
    $title= $_POST['title'];
    $comment= $_POST['comment'];
    $stmt->bind_param('ss',$title,$comment);

$stmt->execute();
header("Location:upload.php");
}

if(isset($_POST['AddComment'])){
    $stmt = $mysqli->prepare("insert into comment (title,username, comment) values (?,?,?)");
    $title= $_POST['Oldtitle'];
    $username=$_SESSION['user_id'];
    $comment= $_POST['NewComment1'];
    $stmt->bind_param('sss',$title,$username,$comment);

$stmt->execute();
header("Location:upload.php");
}



?>