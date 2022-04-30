<?php
$table="LMS_Admin";
$showError=false;
$Admin_login=false;
if($_SERVER['REQUEST_METHOD']=="POST")
{
   require 'connect_database.php';
   if(  isset($_POST['Admin_email']) && isset($_POST['Admin_password'])  )
   {
     #preparing sql statement
     $query="SELECT * FROM $table WHERE Admin_email  = ?";
     $stmt=mysqli_prepare($connection,$query);
     #bind variable to statement parameter
     $b=mysqli_stmt_bind_param($stmt,"s",$Adminemail);
     if($b)
     {
       $Adminemail=$_POST['Admin_email'];
       $Adminpassword=$_POST['Admin_password'];
       #execute sql statement
       $result1=mysqli_stmt_execute($stmt);
       if($result1)
       { 
         $result2=mysqli_stmt_get_result($stmt);
         #checking number of matched rows
         $rows=mysqli_num_rows($result2);
         if($rows==1)
         {
            while($data=mysqli_fetch_assoc($result2)  )
            { 
              if($Adminpassword==$data['Admin_Password'])
              {
                $Admin_login="You are logged In";
                session_start();
                $_SESSION['USER_TYPE']="Admin";
                $_SESSION['Name']=$data['Full_name'];
                $_SESSION['login']=true;
                header("refresh:1.2; url =Home_page.php");
              }
              else
              {
                $showError="Invalid Password";
              }
            }
         }
         else
         {
           $showError="Invalid Credential.";
         }
       }
     }
   }
}    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="author" name="shekhar,hritik ,anchal,robin">
  <meta content="keyword" name="html,css,javascript,LMS,project">
  <meta content="description" name="Library management system">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- adding favicon to title -->
  <link rel="icon" href="Project_Images/e_book.png" type="image/x-icon">
  <!-- linking stylesheet -->
  <link rel="stylesheet" href="Style sheets/style_sheet_one.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <title>Admin login page</title>
</head>

<body class="body">
  <nav class="flex navigation">
    <div class="title flex">
      <img src="Project_Images/logo.png" alt="LOGO" class="logo">
      <h1 class="h1 heading">Library Management system</h1>
    </div>
    <ul class="navigation_links h4 flex">
      <li><a href="Admin_login.php">Admin Login</a></li>
      <li><a href="User_login.php">User login</a></li>
    </ul>
  </nav>

<?php
    if($Admin_login==TRUE)
    {
      echo  "<div class='alert_message'>
                <p class='h2'>$Admin_login</p>
                <div class='cross' onclick='this.parentNode.remove();'>&times;</div>
            </div>";
      $Admin_login=false; 
    }     
    if($showError==TRUE)
    {
      echo  "<div class='warning_message'>
                <p class='h2'>$showError</p>
                <div class='cross' onclick='this.parentNode.remove();'>&times;</div>
            </div>";
      $showError=false; 
    }     
?>

<!-- admin  login form -->
  <div class="container flex" style="padding-top:5em;">
    <form class="flex login" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" target="_blank" method="POST" autocomplete="off">
      <h1 class="h1 user_login">Admin Log-In</h1>
      <div class="User_input flex">
        <label for="email" class="h4">Email id</label>
        <input class="input" type="email" id="email" name="Admin_email" placeholder="Email Id" required>
      </div>
      <div class="User_input flex">
        <label for="password" class="h4">Password</label>
        <input class="input" type="password" id="password" name="Admin_password" placeholder="Password" required>
      </div>
      <input class="submit_btn h3" type="submit" value="Log-In">
      <!-- <a href="#" target="_blank" class="h2" style="align-self: center;color:white;">forgot password</a> -->
    </form>
  </div>
  <!-- *********** -->
</body>
</html>