<?php
session_start();
require 'connectionToMySQL.php';

//This is Update Host function
if(isset($_POST['submitUpdate'])) {
    $oldTitle=$_POST['Oldtitle'];
    echo sprintf(
        '<form name="Update" method="post" action="Update_Delete.php">
        <label>NewTitle</label><input type="text" name="NewTitle">
        <label>NewUrl</label><input type="text" name="NewUrl">
        <label>NewStory</label><input type="text" name="NewStory">
        <input type="hidden" value='.$oldTitle.' name="Oldtitle" />
        <input type="submit" name="UpdateHost" value="Change!!"/>
        </form>
        ');
}
//This is Delete funtion
if(isset($_POST['submitDelete'])){
    $stmt = $mysqli->prepare("delete FROM file WHERE title=?");
    $title= $_POST['Oldtitle'];
    $stmt->bind_param('s',$title);

$stmt->execute();
header("Location:upload.php");

}

//This is Change function
if(isset($_POST['UpdateHost'])) {
    $stmt = $mysqli->prepare("SELECT ID FROM file WHERE title=?");
    $title= $_POST['Oldtitle'];
    $stmt->bind_param('s',$title);
    

    $stmt->execute();
    // Bind the results
    $stmt->bind_result($ID);
 while($stmt->fetch()){
    $stmt->fetch();
    $stmt = $mysqli->prepare("update file set title=?,url=?,story=? where ID=?");
    $title= $_POST['NewTitle'];
    $url= $_POST['NewUrl'];
    $story= $_POST['NewStory'];
    $stmt->bind_param('ssss',$title,$url,$story,$ID);
    
    $stmt->execute();
 }
 header("Location:upload.php");
}


//This is host change comments funtion
if(isset($_POST['submitCommentHost'])){
    $title3= $_POST['Oldtitle'];
    
    echo sprintf(
        '<form name="Update" method="post" action="Comment.php">
        <label>NewComment</label><input type="text" name="NewComment1">
        <input type="hidden" value=%s name="Oldtitle" />
        <input type="submit" name="AddComment" value="Say something???"/>
        </form>', $title3
        );
    
    
    
    $stmt = $mysqli->prepare("select  title,username,comment from comment where title=? order by username");
     $stmt->bind_param('s',$title3);
$stmt->execute();
$stmt->bind_result($title, $username, $comment);
echo "<ul>\n";
while($stmt->fetch()){
    if(htmlentities($username)==$_SESSION['user_id']){
        echo sprintf('<form action="Comment.php" method="POST">
                         <b>%s&nbsp&nbsp&nbsp</b><b>%s&nbsp&nbsp&nbsp</b><b>%s</b>
                         <input type="hidden" value=%s name="title" />
                         <input type="hidden" value=%s name="comment" />
                         <input type="submit" name="HostCommentEdit" value="Edit"/>
                         <input type="submit" name="HostCommentDeleteOwn" value="Delete"/>
                         </form>',
                         htmlentities($title), htmlentities($username),htmlentities($comment),htmlentities($title),htmlentities($comment));
    }
    else{
        echo sprintf('<b>%s&nbsp&nbsp&nbsp</b><b>%s&nbsp&nbsp&nbsp</b><b>%s</b>',
                         htmlentities($title), htmlentities($username),htmlentities($comment));
    }
}
}

?>