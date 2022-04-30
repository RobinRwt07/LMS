<?php
session_start();
if(!isset($_SESSION['USER_TYPE']) || $_SESSION['login']!=true )
{
    header("location:User_login.php");
    exit();
}
require 'connect_database.php';
$showResult=false;
$showError=false;
$table="Books";
$ImgFolder="Book_image/";
$PDF_Folder="Books_PDF/";
if(isset($_GET['catid']))
{
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if( isset($_POST['title']) && isset($_POST['author']) && isset($_FILES['PDF']) && isset($_FILES['Cover']) )
        {
            if($_FILES['Cover']['size']==0)
            {
                $_FILES['Cover']['name']="default_image.jpg";
            }
            $PDF_Name= $PDF_Folder.basename($_FILES['PDF']['name']);
            $ImageName=$ImgFolder.basename($_FILES['Cover']['name']);

            #checking  book already exist or not

            $quer1="SELECT * FROM $table WHERE Book_pdf = '$PDF_Name' ";
            $result=mysqli_query($connection,$quer1);
            $rows=mysqli_num_rows($result);
            if($rows>0)
            {
                $showError="Book Already Exist";
            }
            else
            {    
                $result1=move_uploaded_file($_FILES['PDF']['tmp_name'],$PDF_Name);
                $result2=move_uploaded_file($_FILES['Cover']['tmp_name'],$ImageName);
                if($result1 || $result2)
                {
                   $query2="INSERT INTO $table(Book_category,Book_title,Book_author,Book_pdf,Book_image) VALUES(?,?,?,?,?)";
                   $stmt=mysqli_prepare($connection,$query2);
                   $success=mysqli_stmt_bind_param($stmt,"issss",$Book_category_id,$Book_title,$Book_author,$Book_pdf,$Book_image);
                   if($success)
                   {
                      $Book_category_id=$_GET['catid'];
                      $Book_title=$_POST['title'];
                      $Book_author=$_POST['author'];
                      $Book_pdf=$PDF_Name;
                      $Book_image=$ImageName;
                      $result3=mysqli_stmt_execute($stmt);
                      if($result3)
                      {
                          $showResult="Successfully added.";
                      }
                      else
                      {
                          $showError="Unable to add Book.";
                      }
                   }
                   else
                   {
                       $showError="Unable to add Book.";
                   }
                }
            }
           
        }
    }   
   
}
else
{
  $showError="Page Not Found!";
}
// <!-- deleting books from BookList --> 
 if(isset($_GET['BookID']))
 {
     $query4="DELETE FROM $table WHERE Book_id=? ";
     $stmt2=mysqli_prepare($connection,$query4);
     if($stmt2)
     {
         if(mysqli_stmt_bind_param($stmt2,"i",$Delete_Book_id))
         {
            $Delete_Book_id=$_GET['BookID'];
            $Deleted=mysqli_stmt_execute($stmt2);
           
         }
     }
 }
?>
<!-- ******************* -->

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
    <title>Academic section </title>
</head>
<body style="background-color:#F6F4F2;">

<!-- navigation section  -->
<nav class="flex navigation">
       <div class="title flex">  
        <a href="Home_page.php"><img src="Project_Images/logo.png" alt="LOGO" class="logo"></a>
        <h1 class="h1 heading">Library Management system</h1>
       </div>
    <ul class="navigation_links h4 flex l_s_1" >
        <li><a href="Home_page.php">Home</a></li>
        <li><a href="#add_book">Add Book</a></li>
        <li><a href="Book_List.php">About</a></li>
        <li><a href="logout.php">Log-Out</a></li>
    </ul>
</nav>

<!-- display message -->
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

<?php
    #display all books using loop
    $showBook=false;
    $Book_category_id=$_GET['catid'];
    $category_Name=$_GET['catname'];
    $query3="SELECT * FROM $table WHERE Book_category = '$Book_category_id'";
    $result4=mysqli_query($connection,$query3);
    $Books=mysqli_num_rows($result4);
    $url=$_SERVER['REQUEST_URI']; 
    if($Books==0)
    {
        $showBook=true;
    }
    else
    {
    
        echo <<<title
        <div style="background-color:#FAF0DC" class="book_title">
        <h2> $category_Name Books </h2>
        </div> 
        title;
        echo '<section class="book_shelf flex">';
        echo '<section class="grid booksgrid">';
        while($data=mysqli_fetch_assoc($result4))
        {
            $cat_id=$data['Book_category'];
            $title=$data['Book_title'];
            $author=$data['Book_author'];
            $image=$data['Book_image'];
            $PDF=$data['Book_pdf'];
            $Id=$data['Book_id'];
            
            if($_SESSION['USER_TYPE']=="User")
            {
                echo <<<Books
                <div class="books flex">
                <div class="cover_page"><img src="$image" width="100%" height="100%" ></div>
                <div class="book_details">
                <p class="h5">$title</p>
                <p class="h4">By - $author</p>
                <div class="flex admin_control">
                <a style="padding:.2em 1em;" class="h4" href="$PDF" download="$PDF">Download</a>
                <a style="padding:.2em 1em;" class="h4" href="$PDF">Read</a>    
                </div>
                </div>
                </div>
                Books;
            }
            if($_SESSION['USER_TYPE']=="Admin")
            {
                echo <<<Books
                <div class="books flex">
                <div class="cover_page"><img src="$image" width="100%" height="100%" ></div>
                <div class="book_details">
                <p class="h5" style="word-break:break-word;">$title</p>
                <p class="h4">By - $author</p>
                <div class="flex admin_control">
                <a style="padding:.2em 1em;font-weight:normal" class="h4" href="$PDF" download="$PDF" >Download</a>
                <a style="padding:.2em 1em;font-weight:normal" class="h4" href="$url&&BookID=$Id">Delete</a>
                </div>
                </div>
                </div>
                Books;
            }
        } 
    }
    ?>     
  </section>
</section>
<?php
if($showBook==true)
{
    
echo <<<Msg
     <section class="error_msg flex">
     <div>
     <h1> $category_Name Books Not Available</h1>
     </div>
     </section>
     Msg;
}    
?>
 
<!-- input form  -->
<?php
if($_SESSION['USER_TYPE']=="Admin")
{   
    echo <<<addbook
    <form id="add_book" class="flex addbook" action="$url" method="POST" enctype="multipart/form-data">
    
    <h1 class="user_login" style="font-size:3em;">Add Book</h1>
    
    <div class="Book_details flex">
    <label for="book_title" class="h4">Book Title</label>
    <input class="input" type="text" id="book_title" name="title" placeholder="Book Name" required>
    </div>
    
    <div class="Book_details flex">
    <label for="author_name" class="h4">Author Name</label>
    <input class="input" type="text" id="author_name" name="author" placeholder="Author Name" required>
    </div>
    
    <div class="Book_details flex">
    <label for="Book_Cover" class="h4">Book Cover</label>
    <input class="input_file" type="file" id="Book_Cover" name="Cover" accept="image/* " >
    </div>
    
    <div class="Book_details flex">
    <label for="Book_PDF" class="h4">Book PDF</label>
    <input class="input_file" type="file" id="Book_PDF" name="PDF" accept=".pdf" required>
    </div>
    
    <input class="add_book_btn h2" type="submit" value="Add Book">
    </form>
    addbook;
} 
?>
<?php  require 'footer.php' ?>

</body>
</html>