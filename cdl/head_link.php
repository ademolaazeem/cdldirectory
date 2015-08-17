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
	if(confirm("Do you want to remove this Contractor\nProceed?")){
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
  <li><a href="man_staff_directory.php?id=<?php echo $rs['id'];?>">Staff Directory Details</a>  </li>
  <li><a href="_update_staff_directory.php?id=<?php echo $rs['id'];?>">Update Staff Directory</a></li>


  <li><a href="upload_staff_picture.php?id=<?php echo $rs['id'];?>">Upload Staff Picture</a></li>
   <li><a href="print_staff_directory.php?id=<?php echo $rs['id'];?>" target="_blank">Print This Staff Directory</a></li>

<!--  <li><a href="man_contractor.php?con_id=<?php //echo $rs['id'];?>&amp;&amp;remove=yes">Remove</a></li>-->
</ul>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
