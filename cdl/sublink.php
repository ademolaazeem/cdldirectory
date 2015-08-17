<script language="javascript">
function confirmReset()
{
	if(confirm("Do you want to reset this password\nProceed?")){
		if(confirm("Are you sure?")){
			return true;
		}
		else{
			return false;
		}
	}
	else
	{
		return false;
	}	
}
</script>
<script language="javascript">
function confirmRemove()
{
	if(confirm("Do you want to remove this staff\nProceed?")){
		if(confirm("Are you sure?")){
			return true;
		}
		else{
			return false;
		}
	}
	else
	{
		return false;
	}	
}
</script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a href="../tcn/perstaff.php?staffid=<?php echo $rs['staff_id'];?>">Staff Profle</a>  </li>
  <li><a href="../tcn/adminupdatestaff.php?staffid=<?php echo $rs['staff_id'];?>">Update Biodata</a></li>
  <li><a href="../tcn/staffsubject.php?staffid=<?php echo $rs['staff_id'];?>">Subjects</a></li>
  <li><a href="../tcn/chapassword.php?staffid=<?php echo $rs['staff_id'];?>">Change Password</a></li>
  <li><a href="../tcn/resetpassword.php?staffid=<?php echo $rs['staff_id'];?>&amp;&amp;reset=yes">Reset Password</a></li>
  <li><a href="../tcn/staffuploadpix.php?staffid=<?php echo $rs['staff_id'];?>">Upload Picture</a></li>
  <li><a href="#">Send Message</a></li>
  <li><a href="../tcn/managestaffs.php?staffid=<?php echo $rs['staff_id'];?>&amp;&amp;remove=yes">Remove</a></li>
</ul>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
