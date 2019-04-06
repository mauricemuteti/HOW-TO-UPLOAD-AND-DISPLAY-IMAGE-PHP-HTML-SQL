<?php
//Start connection to the localhost server
$conn = mysqli_connect("localhost", "root", "");
if ($conn) {
echo "<br />connected to server......";
} else  {
die("Failed to connect ". mysqli_connect_error());
}
//Select Database
$selectalreadycreateddatabase = mysqli_select_db($conn, "uploaddisplay"); 
if ($selectalreadycreateddatabase) {
echo "<br /> Existing database selected successfully";
} else {
echo "<br /> Selected Database Not Found";
$createNewDb = "CREATE DATABASE IF NOT EXISTS `uploaddisplay`";
if (mysqli_query($conn, $createNewDb)) {
echo "<br />New Database Created Successfullly";
$selectCreatedDatabase = mysqli_select_db($conn, "uploaddisplay");
if ($selectCreatedDatabase) {
echo "<br />Created Database Selected Successfullly";
// Creating new table 
$sqlcreatetable = "
CREATE TABLE IF NOT EXISTS `updis` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";

if (mysqli_query($conn, $sqlcreatetable)) {
echo "<br />New table Created";
} else {
echo "<br /> Unable to create new table.";
}
}
} else {
echo "<br />Unable to create database";
}
}
//If submit button is clicked
if(isset($_POST['fileuploadsubmit'])) {
$fileupload = $_FILES['fileupload']['name'];
$fileuploadTMP = $_FILES['fileupload']['tmp_name'];
//This is the folder where images will be saved.
$folder = "images/";
move_uploaded_file($fileuploadTMP, $folder.$fileupload);
//Insert image details into `updis` table
$sql = "INSERT INTO `updis`(`name`) VALUES ('$fileupload')";
$qry = mysqli_query($conn, $sql);

if ($qry) {
echo "<br />uploaded";
}
}
//Select all data from `updis` table
$select = " SELECT * FROM `updis` " ;
$query = mysqli_query($conn, $select) ;
while($row = mysqli_fetch_array($query)) {
$image = $row['name'];
//Display image from the database
echo '<img src="images/'.$image.'" height="150" width="150" >';
}
//close connection
if (mysqli_close($conn)) {
echo "<br />Connection closed.........";
}
?>
<!DOCTYPE html>
<html>
<body>
<form method="post" action="" enctype="multipart/form-data">
<input type="file" name="fileupload" />
<input type="submit" name="fileuploadsubmit" value="Upload" />
</form>
</body>
</html>