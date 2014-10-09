<!DOCTYPE html>

<html>
<head>
    <title>Index</title>
   <style>
       body {
            background-color: #222930;
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
    
    <h1>File<span>Sharing</span></h1>
     

    <form name="frmUser" method="post" action="login.php">
        <label>Username</label><input type="text" name="userName">
        <label>Password</label><input type="text" name="passWord">
        <input type="hidden" name="token1" value="<?php echo $_SESSION['token1'];?>" />
        <input type="submit" name="submit" value="LOGIN">
    </form>
    <br><br><br>
    <form name="Register" method="post" action="register.php">
        <label>Username</label><input type="text" name="userName2">
        <label>Password</label><input type="text" name="passWord2">
        <input type="submit" name="submit2" value="Register">
    </form>
    
<?php

    if(isset($_POST['submit'])) {
      // This is a *good* example of how you can implement password-based user authentication in your web application.
session_start();
require 'connectionToMySQL.php';
 
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT password FROM account WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $username);
$username = $_POST['userName'];
$stmt->execute();
// Bind the results
$stmt->bind_result($pwd_hash);
$stmt->fetch();
 
 //guess is original password
$pwd_guess = $_POST['passWord'];



if( crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	// Login succeeded!
	$_SESSION['user_id'] = $username;
        $_SESSION['token1'] = substr(md5(rand()), 0, 10);
        header("Location:upload.php");
}
else{
    echo"shit";
	// Login failed; redirect back to the login screen
}
$stmt->close();
}
         
    
?>
   

</body>
</html>
