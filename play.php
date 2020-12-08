<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

include("connection.php");
$id = $_GET['id'];
$sql = "SELECT video FROM $table_webseries WHERE id=$id";
$out = mysqli_query($con, $sql);
if(mysqli_num_rows($out) > 0){
    $row = mysqli_fetch_assoc($out);
    echo '<video width="100%" height="500px" controls>
    <source src="'.$row['video'].'" type="video/mp4">
    Your browser does not support the video tag.
    </video>';
}

?>
    
</body>
</html>