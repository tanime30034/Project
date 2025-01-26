<?php
$servername="localhost";
$username="root";
$password="";
$dbname="mypet";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if(mysqli_connect_errno())
{
    echo'Connection Error'. mysqli_connect_error();
}
?>