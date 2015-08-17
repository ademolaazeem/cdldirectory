<?php 
error_reporting(0);
//page permission id = 1, permission name =  add contractors
$page_permission_id = 9;
?>
<?php
	require_once('authenticate.php');
	$db = new DBConnecting();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">

<link rel="shortcut icon" href="images/favicon.ico">

<link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="../js/jquery-1.6.min.js"></script>
<script src="../js/cufon-yui.js" type="text/javascript"></script>
<script src="../js/cufon-replace.js" type="text/javascript"></script>
<script src="../js/Open_Sans_400.font.js" type="text/javascript"></script>
<script src="../js/Open_Sans_Light_300.font.js" type="text/javascript"></script>
<script src="../js/Open_Sans_Semibold_600.font.js" type="text/javascript"></script>
<script src="../js/FF-cash.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
<![endif]-->
</head>
<body id="page3">
<!-- header -->
<div class="bg">
  <div class="main">

<?php 
include('header_in.php');
?>

<?php
//get user access level
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
}
?>
    <!-- content -->
    <section id="content">
      <div class="padding">
        <div class="indent">
          <h2><?php echo $fuName;?> Dashboard</h2>
          
 <?php
$permission_id = 24; //administer contractor
$result = mysql_query("select *from tbl_user_permission WHERE username='".$_SESSION['username']."' && permission_id='$permission_id'");
$has_permission = mysql_num_rows($result);
if($has_permission > 0)  
{ 

?>
       
         
    
          
          
<div class="wrapper indent-bot">
            <div class="col-3">
              <div class="wrapper">
                <figure class="img-indent4"><span class="img-indent"><a href="_new_staff_directory.php"><img src="../images/page3-img6.png" alt="" /></a></span></figure>
                <div class="extra-wrap">
                  <h6><a href="_new_staff_directory.php">New Staff Directory</a></h6>
                  You can add new Staff directory with other all other details including the extension and the email as well as the phone number of the staff
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="wrapper">
                <figure class="img-indent3"><a href="view_staff_directory.php"><img src="../images/page3-img5.png" alt="" /></a></figure>
                <div class="extra-wrap">
                  <h6><a href="view_staff_directory.php">Administer Staff Directory</a></h6>
                  Edit Existing Staff Directory, you can change staff name, or the department or the extension of the staff. </div>
              </div>
            </div>
          </div>
          <div class="wrapper indent-bot2">
            <div class="col-3">
              <div class="wrapper">
                <figure class="img-indent3"><a href="view_staff_directory_view.php"><img src="../images/page3-img3.png" alt="" /></a></figure>
                <div class="extra-wrap">
                  <h6><a href="view_staff_directory_view.php">View Directory</a></h6>
                  Here you can view list of all the staff in the organization as well as their departments, extension, email address among others. </div>
              </div>
            </div>
            <div class="col-4">
              <div class="wrapper">
                <figure class="img-indent"><a href="show_staff_directory.php"><img src="../images/page4-img1.png" alt="" /></a></figure>
                <div class="extra-wrap">
                  <h6><a href="show_staff_directory.php">Staff Directory Report</a></h6>
                  You can either view or print this the list of all the staff in the organization or some staff of your interest.. </div>
              </div>
            </div>
          </div>
          
    <?php 
}


$permission_id = 25; //administer contractor
$result = mysql_query("select *from tbl_user_permission WHERE username='".$_SESSION['username']."' && permission_id='$permission_id'");
$has_permission = mysql_num_rows($result);
if($has_permission > 0)  
{ 	
	?>
    
    
          
          <div class="wrapper indent-bot2">
            <div class="col-3">
              <div class="wrapper">
                <figure class="img-indent3"><a href="new_visitor.php"><img src="../images/visitor.png" alt="" width="151" height="92" /></a></figure>
                <div class="extra-wrap">
                  <h6><a href="new_visitor.php">New Visitor</a></h6>
                  Click here to add new visitor, get the visitor's details including the name, address, the floor, etc.</div>
              </div>
            </div>
            <div class="col-4">
            
           
            
            
            
             <div class="wrapper">
                <figure class="img-indent"><a href="view_signed_in_visitors.php"><img src="../images/report-tools-icon.png" alt="" width="120" height="100" /></a></figure>
                <div class="extra-wrap">
                  <h6><a href="visitors_reports.php"> Visitors Reports</a></h6>
                  One can is allowed to view all the signed in visitors who has not signed out. </div>
              </div>
            
            
       
              
            </div>
          </div>
          
          
          
          
          <?php 
	 }
	 
	 ?>
          
        <?php
$permission_id = 26; //administer contractor
$result = mysql_query("select *from tbl_user_permission WHERE username='".$_SESSION['username']."' && permission_id='$permission_id'");
$has_permission = mysql_num_rows($result);
if($has_permission > 0)  
{ 	
			?>    
          
          
          
   <div class="wrapper indent-bot2">
            <div class="col-3">
              <div class="wrapper">
                <figure class="img-indent3"><a href="new_visitor.php"><img src="../images/view_signed_out.jpg" alt="" width="109" height="100" /></a></figure>
                <div class="extra-wrap">
<h6><a href="view_signed_out_visitors.php">View Signed out  Visitors</a></h6>
                  Click here to view visitor that have been signed out</div>
              </div>
            </div>
            
               
            
           
     <div class="col-4">        
            
             
             
            
            
              <div class="wrapper">
                <figure class="img-indent"><a href="view_signed_in_visitors.php"><img src="../images/view visitor.jpg" alt="" width="131" height="78" /></a></figure>
                <div class="extra-wrap">
                  <h6><a href="view_signed_in_visitors.php">View Signed in Visitors</a></h6>
                  One can is allowed to view all the signed in visitors who has not signed out. </div>
              </div>
              

             
           
             
             
      <?php     
        }      
        ?>     
             
         </div>      
      </div>
         
         
         
         
         
         
         
         
         
          
       
        </div>
        
      </div>
    </section>
    <!-- footer -->
    <?php 
	include('../footer.php');
	?>
  </div>
</div>
<script type="text/javascript">Cufon.now();</script>
</body>
</html>