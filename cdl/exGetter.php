<?php 
require_once("../ClassesController/DBDirect.php");
$db = new DBConnecting();

	$whom_to_see = mysql_real_escape_string($_GET['whom_to_see']);
	//echo $whom_to_see;
	$query = "SELECT * FROM tbl_directory WHERE id=$whom_to_see";
	
	$result = mysql_query($query);
		
	while ($row = mysql_fetch_array($result)) {
   	echo "<option value=".$row['extension'].">" . $row['extension'] . "</option>";
		//echo "value="."".$row{'floor'}."";
		//echo $row{'floor'};
	}
?>
</body>
</html>