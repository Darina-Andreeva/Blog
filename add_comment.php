<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <title>IT BLOG</title>

</head>
<body>
<div id="img">
    <img  id ="myIMG" src="css/102045_12.jpg">
    <button class="center" onclick="myFunction()">Click me</button>
</div>



<?php
  if(!isset($_POST['add'])){
      $id=strip_tags($_GET['id']);
      echo " <h2>Add comment</h2>
          <p><form method='post'>
          <input type='hidden' name='id' value=$id>
          <p>Name:<input type='text' name='uname' >
             Email:<input type='text' name='email'>
          <p><textarea name='txt' rows='10' cols='50'></textarea>
          <p><input type='submit' name='add' value='Add comment'></p>
                </form>";

  }else{
      $id = strip_tags($_POST['id']);
      $txt =strip_tags($_POST['txt']);
      $uname =strip_tags($_POST['uname']) ;
      $email = strip_tags($_POST['email']);
      $dt = time();
      include "config.php";


      $connection=mysqli_connect($server, $username, $password, $db);
      mysqli_query($connection,"insert into comments value (0,$id,$dt,\"$uname\",\"$email\",\"$txt\")");


      echo "<h2>Thanks for your comment!</h2><p><a href='index.php'>Go back to main page</a>";


  }





include "footer.html";
?>
<script type="text/javascript" src="js/test.js"></script>
</body>
    </html>