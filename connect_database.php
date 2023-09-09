<!-- connect to database -->
<?php
$sever="localhost";
$user="root";
$database="LMS_Project";
$connection=mysqli_connect($sever,$user,"*******",$database);
if(mysqli_connect_errno())
{
    die("Failed to connect Database. Error: ".mysqli_connect_error());
}
?>
