<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Video</title>
        <style>
            h1 {
                text-align: center;
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
            echo '<h1 class="display-1">'.$row['name'].'</h1>';
            echo '<div class="form-group row">
                    <video controls class="col-sm-9">
                        <source src="'.$row['video'].'" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>';
            echo '<div class="col-sm-3">';
            $inner_sql = "SELECT * FROM $table_seasons WHERE ".$row['id']." = id";
            $inner_out = mysqli_query($conn, $inner_sql);
            while($inner_row = $inner_out->fetch_assoc()) {
                echo 'Season '.$inner_row['season_num'].': '.$inner_row['episode_cnt'].' episodes ('.$inner_row['time_ep'].') min each<br>';
            }
            $inner_sql = "SELECT genre FROM $table_genre WHERE ".$row['id']." = id";
            $inner_out = mysqli_query($conn, $inner_sql);
            while($inner_row = $inner_out->fetch_assoc()) {
                echo '- '.$inner_row['genre'].'<br>';
            }
            echo '</div></div>';
        }
        ?>
    </body>
</html>