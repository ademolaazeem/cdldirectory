<?php session_start();

if(!(isset($_SESSION['username'])))
{
   header("location:no_permissions.php?r=");
}
?>
