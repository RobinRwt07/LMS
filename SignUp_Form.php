<?php
$table="LMS_User";
$showError=false;
$showResult=false;
if($_SERVER['REQUEST_METHOD']=="POST")
{
   require 'connect_database.php';
   if( isset($_POST['UserName']) && isset($_POST['UserEmail']) && isset($_POST['password']) && isset($_POST['cpassword']) )
   {
     $username=$_POST['UserName'];
     $useremail=$_POST['UserEmail'];
     $password=$_POST['password'];
     $cpassword=$_POST['cpassword'];
     #checking user record already exist in database or not.
     $query="SELECT Email FROM $table WHERE Email= '$useremail'";
     $result=mysqli_query($connection,$query);
     $UserExist=mysqli_num_rows($result);
      if($UserExist>0)
      {
        $showError="User already Exist.Please log-In.<br>";
      }
      else
      { 
        #checking both password are same
        if($password==$cpassword)
        {
          $hashPassword=password_hash($password,PASSWORD_DEFAULT);
          $query2="INSERT INTO $table(Name,Email,Password) VALUES('$username','$useremail','$hashPassword')";
          $result2=mysqli_query($connection,$query2);
          if(mysqli_errno($connection))
          {
            $showError="Sorry.Unable to create account.please try again.<br>";
          }
          else
          {
            $showResult="Congratulations!You have successfully created your account.Now you can log-In into the system.";
          }
        }
        else
        {
          $showError="Password and confirmation Password do not match.";
        }
      }
   }
   else
   {
     die();
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
    <link rel="icon" href="Project_Images\e_book.png" type="image/x-icon">
    <!-- linking stylesheet -->
    <link rel="stylesheet" href="Style sheets\style_sheet_one.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <title>User sign-up</title>
</head>
<body class="body">
  <nav class="flex navigation">
    <div class="title flex">  
     <img src="Project_Images\logo.png" alt="LOGO" class="logo">  
     <h1 class="h1 heading">Library Management system</h1>
    </div>
 <ul class="navigation_links h4 flex">
     <li><a href="Admin_login.php">Admin Login</a></li>
     <li><a href="User_login.php">User login</a></li>
     <li><a href="SignUp_Form.php">Sign-Up </a></li>
     <li><a href="">About</a></li>
 </ul>
</nav>
<!--alert message  -->
<?php
if($showResult==TRUE)
{
  echo  "<div class='alert_message'>
            <p class='h2'>$showResult</p>
            <div class='cross' onclick='this.parentNode.remove();'>&times;</div>
        </div>";
  $showResult=false; 
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

<div class="container flex" style="padding:3em 1em;">

  <form class="flex login" action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
    
    <h1 class="user_login" style="font-size:3em;">Sign Up</h1>

    <div class="User_input flex">
    <label for="name" class="h4">Full Name</label>
    <input class="input" type="text" id="name" name="UserName" placeholder="User Name" required>
    </div>

    <div class="User_input flex">
    <label for="email" class="h4">Email</label>
    <input class="input" type="email" id="email" name="UserEmail" placeholder="Your Email">
    </div>

    <div class="User_input flex">
    <label for="password "  class="h4">Password</label>
    <input class="input" type="password" id="password" name="password" placeholder="Password" minlength="6" required>
    </div>

    <div class="User_input flex">
    <label for="cpassword " class="h4">Confirm Password</label>
    <input class="input" type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" minlength="6" required>
    </div>

    <input class="submit_btn h3" type="submit" value="SIGN UP">
    <a href="User_login.php" class="h2" style="align-self: center;color:white; ">Already have an account? Log-In</a>
  </form>
</div> 
</body>
</html>