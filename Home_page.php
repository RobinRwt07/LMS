<?php
#check session started or not.
session_start();
if(!isset($_SESSION['USER_TYPE']) || $_SESSION['login']!=true )
{
    header("location:User_login.php");
    exit();
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
    <title>E-Library</title>
</head>


<body>

<!-- navigation section  -->

  <nav class="flex navigation">
       <div class="title flex">  
        <a href="Home_page.php"><img src="Project_Images/logo.png" alt="LOGO" class="logo"></a> 
        <h1 class="h1 heading">DIGI-LIBRARY</h1>
       </div>
    <ul class="navigation_links h4 flex l_s_1" >
        <li><a href="Home_page.php">Home</a></li>
        <li><a href="#Categories">Categories</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="logout.php">Log-Out</a></li>
    </ul>
  </nav>

<!-- welcome section -->
  <section class="flex" style="position:relative; width: 100%; height: 90vh;">

    <div class="background_image">

    </div>
    <div class="overlay">
        <?php echo "<h2 class='h1 Ta-c transition_1'>Hello ".$_SESSION['Name']."</h2>"; ?>
        <h1 class="h6 Ta-c font2  transition_1">WELCOME TO DIGITAL LIBRARY</h1>
        <h2 class="h1 Ta-c transition_1">Get The Best Free E-Books</h2>
        <p class="h5 transition_1" style="text-align: justify;">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit adipisci ipsa in laboriosam rem cupiditate dolores voluptates aliquam doloremque nam! Cupiditate culpa nostrum veritatis commodi a nulla facilis tenetur consequatur.
        </p>
    </div>
    
  </section>

 <!-- collection section -->
  
 <section class="grid description "style="min-height:35vmax;">
    <div class="pic">
        <img src="Project_Images\clip-library-2.png" alt="image">
    </div>
    <div class=" flex content">
         <q class="h5" >
         The content of a book holds the power of education and it is with this power that we can shape our future and change lives.
         </q>
        <p class="h5">— Malala Yousafzai</p>
        <a class="h2" href="#">VIEW MORE</a> 
    </div>

 </section>


  <!--circle section -->

  <section class=" flex element_section">

    <div class="flex container_circle" >

     <h2 class="h1 font3" style="text-align:center; margin-top:1em; letter-spacing:.1em;">FIND YOUR FAVORITE BOOKS HERE</h2>   

     <div class="flex card" >
         <h1 class="h1" style="text-align:center;">Diverse Book Collection</h1>
         <p class="h5"  style="text-align: center;font-weight: bold;" >
            From applied literature to educational resources, we have a lot of textbooks to offer you. We provide only the best books
         </p> 
     
         <!-- <a class="h2" href="">VIEW CATALOG</a>  -->
     </div>
    </div>

    <div class="element_container">
        <div class="circle_one"><img src="Project_Images\circle1.png" alt="circle1" ></div>
        <div class="circle_picture"></div>
        <div class="circle_two"><img src="Project_Images\circle2.png" alt="circle2" ></div>
        <div class="circle_three"><img src="Project_Images\circle3.svg" alt="circle3" ></div>
    </div>
</section>


    <!-- books section -->
 <section id="Categories" class="flex top_category" >
    <div class="h1 Ta-c font2"><h2> Top Categories</h2></div>
    <!-- <div class="h4 Ta-c " ><h2>Lorem ipsum dolor sit amet consectetur.</h2></div> -->
   
    <div class="grid sections">
        <a class="sections_items" href="Book_List.php?catid=1&&catname=ACADEMICS" target="_self"><img src="Project_Images\academics.png" width="90px" height="90px"><p class="h5">ACADEMICS</p></a>

        <a class="sections_items" href="Book_List.php?catid=2&&catname=NOVELS" target="_self"><img src="Project_Images\fiction.png"><p class="h5">NOVELS</p></a>

        <a class="sections_items" href="Book_List.php?catid=3&&catname=BIOGRAPHY" target="_self"><img src="Project_Images\biography-64.png" width="90px" height="90px"><p class="h5">BIOGRAPHY</p></a>

        <a class="sections_items" href="Book_List.php?catid=4&&catname=BUSINESS" target="_self"><img src="Project_Images\business_.png" width="90px" height="90px"><p class="h5">BUSINESS</p></a>
        
        <a class="sections_items" href="Book_List.php?catid=5&&catname=INFORMATION TECHNOLOGY" target="_self"><img src="Project_Images\coding.png" width="90px" height="90px"><p class="h5">INFORMATION TECHNOLOGY</p></a>

        <a class="sections_items" href="Book_List.php?catid=6&&catname=HISTORY" target="_self"><img src="Project_Images\history.png" width="90px" height="90px"><p class="h5">HISTORY</p></a>

        <a class="sections_items" href="Book_List.php?catid=7&&catname=POETRY" target="_self"><img src="Project_Images\comic.png"
        width="90px" height="90px"><p class="h5">POETRY</p></a>

        <a class="sections_items" href="Book_List.php?catid=8&&catname=SELF-HELP" target="_self"><img src="Project_Images\self_help.png" width="90px" height="90px"><p class="h5">SELF-HELP</p></a>

        <a class="sections_items" href="Book_List.php?catid=9&&catname=ROMANCE" target="_self"><img src="Project_Images\romance.png" width="90px" height="90px"><p class="h5">ROMANCE</p></a>

    </div>
  </section>

  <!-- Recommended books -->
  <section class="flex recommended_books">
     <h1 class="h6 Ta-c">Latest Books</h1>
     <?php
        if(isset($_SESSION['USER_TYPE']) || $_SESSION['login']==true )
        {
            require 'connect_database.php';
            $table="Books";
            $query="SELECT * FROM $table ORDER BY RAND() LIMIT 6";
            $result=mysqli_query($connection,$query);
            $rows=mysqli_num_rows($result);
            if($rows>0)
            {
                while( $data=mysqli_fetch_assoc($result) )
                {
                    $BookName=$data['Book_title'];
                    $Book_author=$data['Book_author'];
                    $BookContent=$data['Book_pdf'];
                    echo <<<A
                    <div class="recommended h5 flex ">
                    <a href="$BookContent"> &#9654;&nbsp;&nbsp;$BookName</a>
                    <p>By - $Book_author </p>
                    </div>
                    A;
                }
            }
            else
            {
               echo <<<B
               <div class="recommended h5 flex" style="justify-content:center !important">
               No Books Available
               </div>
               B;
            }
        }
    ?>
 </section>

 <!-- about section -->
  <?php  require 'footer.php' ?>
 <!-- about section -->
</body>
</html>