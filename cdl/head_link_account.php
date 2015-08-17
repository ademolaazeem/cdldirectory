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
  <li><a href="man_contractor_account.php?con_id=<?php echo $rs['contractor_id'];?>">Check  Current Balance</a>  </li>
  <li><a href="_update_contractor_account.php?con_id=<?php echo $rs['contractor_id'];?>">Edit Account
  </br></a></li>
  

<?php
if($acc_level == 3 || $acc_level == 1)
{
?>
  <li><a href="_new_contractor_account.php?con_id=<?php echo $rs['contractor_id'];?>">Add New Payment</a></li>
<?php
}
?>
  <li><a href="account_history.php?con_id=<?php echo $rs['contractor_id'];?>">Account History</a></li>
   <li><a href="print_contractor_account.php?con_id=<?php echo $rs['contractor_id'];?>" target="_blank">Print Contractor's Account Info</a></li>

<!--  <li><a href="man_contractor.php?con_id=<?php //echo $rs['contractor_id'];?>&amp;&amp;remove=yes">Remove</a></li>-->
</ul>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
