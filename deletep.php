
<?php
include("config.php");
$id=$_REQUEST['id'];
$query = "DELETE FROM tbl_product WHERE id=$id"; 
$result = mysqli_query($connect,$query) or die ( mysqli_error());
header("Location: adminPage.php"); 
?>