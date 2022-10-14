<?php
require_once("config.php");
if(!empty($_POST["coutrycode"])) 
{
$query =mysqli_query($conn,"SELECT * FROM team WHERE countryid = '" . $_POST["coutrycode"] . "'");
?>
<option value="">Select Team</option>
<?php
while($row=mysqli_fetch_array($query))  
{
?>
<option value="<?php echo $row["TeamName"]; ?>"><?php echo $row["TeamName"]; ?></option>
<?php
}
}



?>
