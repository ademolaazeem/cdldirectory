<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">
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
	<?php session_start();
	$fuName = "";
	if(isset($_SESSION['username']))
	{
		$fuName= $_SESSION['username'];
	}

	?>
<!-- header -->
<div class="bg">
  <div class="main">

    <header>
      <div class="row-1">
        <h1> <a class="logo" href="index.php">Consolidated Discounts Limited</a> <strong class="slog">The Directory Portal for CDL Staff</strong> </h1>
        <form id="search-form" action="#" method="post" enctype="multipart/form-data">
          <fieldset>
            <div class="search-form">
              <input type="text" name="search" value="Type Keyword Here" onBlur="if(this.value=='') this.value='Type Keyword Here'" onFocus="if(this.value =='Type Keyword Here' ) this.value=''" />
              <a href="#">Search</a> </div>
          </fieldset>
        </form>
      </div>

<div class="row-2">
        <nav>
          <ul class="menu">
            <li><a class="active" href="dashboard.php">Home Page</a></li>
           <li>
                    <?php
                    if($fuName)
                    {
                    echo ' <a href="logout.php?a=t">Logout</a>';
                    }
                    else
                    {
                    echo '<a href="index.php" title="">Login</a>';
                    }
                    ?>
           </li>
            <li><a href="#" title="">Welcome <?php echo $fuName;?></a></li>
          </ul>
</nav>
      </div>
    </header>

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
<br/>
<br />
<table width="824" height="65" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td width="326" align="center"><img src="../images/attention.jpg" width="246" height="205"></td>
    <td width="463" align="center" valign="middle"><b>You do not have sufficient permissions to access that page.</b></td>
   
  </tr
  >
  <tr>
    <td colspan="2">&nbsp;</td>
    
  </tr>
  </table>
<br /><br /><br /><br />
      </div>
    </section>
    <!-- footer -->
    <?php 
	include('../footer.php');
	?>
  </div>
</div>
<script type="text/javascript">Cufon.now();</script>
<script type="text/javascript">
$("#whom_to_see").change(function() {
	$("#floor").load("getter.php?whom_to_see=" + $("#whom_to_see").val());
	$("#extension").load("exGetter.php?whom_to_see=" + $("#whom_to_see").val());
});
</script>
</body>
</html>