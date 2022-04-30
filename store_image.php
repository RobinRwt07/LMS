
<?php
  if($_SERVER['REQUEST_METHOD']=="POST")
  {
      if(isset($_POST['name']) && isset($_FILES['image']))
      {
          require 'connect_database.php';
          echo $_POST['name'];
          $image = $_FILES['image']['tmp_name']; 
          $imgContent = addslashes(file_get_contents($image)); 
          $query =("INSERT into images (image, created) VALUES ('$imgContent', NOW())"); 
          $res=mysqli_query($connection,$query);
          if($res)
          {
              echo "success";
          }
          else
          {
              echo "error";
          }
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="Post" enctype="multipart/form-data">

        IMAGE NAME:
        <input type="text" name="name"><br>
        Image file:
        <input type="file" name="image"><br>
        <input type="submit" value="click">
    </form>
</body>
</html>
