<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Video</title>
        <style>
            .container {
                text-align: center;
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <?php
        include("connection.php");
        $id = $_GET['id'];
        $sql = "SELECT * FROM $table_webseries WHERE id=$id";
        $out = mysqli_query($conn, $sql);
        if(mysqli_num_rows($out) > 0){
            $row = mysqli_fetch_assoc($out);
            echo '<div class="container">
                        <h1 class="display-3">'.$row['name'].'</h1>
                        <div class="container">
                            <video controls>
                                <source src="'.$row['video'].'" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>';
        }
        ?>
    </body>
</html>