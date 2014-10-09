<!DOCTYPE html>
<html>
    <?php
        
session_start();
    ?>
<head>
    <title>Index</title>
   <style>
       body {
            background-color: #ABCDEF;
     }
        h1 {
            font-size: 50px;
            margin-left: 20px;
            font-weight: bold;
            color: #4EB1BA;
        }
        span {
            font-size: 70px;
            color: #4EB1BA;
            
        }
        label {
            color: #E9E9E9;
            font-size: 20px;
        }
        form {
            position: absolute;
            left: 400px;
        }
        
   </style>
   
   
   
</head>
<body>
    <br><br><br><br>
    <h1>Welcome to my world!!!</h1>
    <form name="fileupload" method="post" action="RealProcessUpload.php">
        <label>Title</label><input type="text" name="title">
        <label>Url</label><input type="text" name="url">
        <br>
        <textarea name="story"></textarea>
        <input type="hidden" name="token1" value="<?php echo $_SESSION['token1'];?>" />
        <input type="submit" name="submit3" value="Upload">
    </form>
    <h2>
        <span><a href="logout.php">Logout</a></span>
    </h2>
    
<?php
require 'connectionToMySQL.php';

 
$stmt = $mysqli->prepare("select username,title,url,story from file order by username");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
//$result = $stmt->get_result();
$stmt->bind_result($username, $title, $url, $story);
echo "<ul>\n";
while($stmt->fetch()){
    echo '<a href=http://',htmlspecialchars($url),'>'.htmlspecialchars($url).'</a>';
    if(htmlentities($username)==$_SESSION['user_id']){
        echo sprintf('<form action="Update_Delete.php" method="POST">
                         <b>%s&nbsp&nbsp&nbsp</b><b>%s</b>
                         <input type="hidden" value=%s name="Oldtitle" />
                         <input type="submit" name="submitCommentHost" value="Comment"/> 
                         <input type="submit" name="submitUpdate" value="Update"/>
                         <input type="submit" name="submitDelete" value="Delete"/>
                         </form>',
                         htmlentities($username), htmlentities($title),htmlentities($title));
    printf("<article>%s</article>",htmlspecialchars($story));
    }
    else{
        echo sprintf('<form action="Update_Delete.php" method="POST">
                         <b>%s&nbsp&nbsp&nbsp</b><b>%s</b>
                         <input type="submit" name="submitCommentClient" value="Comment"/> 
                         </form>',
                         htmlentities($username), htmlentities($title));
    printf("<article>%s</article>",htmlspecialchars($story));
    }  
}
echo "</ul>\n";
 
$stmt->close();
?>
</body>
</html>