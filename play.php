<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Video</title>
        <style>
            .heading {
                text-align: center;
                margin: 20px;
            }
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
    </head>
    <body>
        <?php
        include("connection.php");
        $id = $_GET['id'];
        $sql = "SELECT * FROM $table_webseries WHERE id=$id";
        $out = mysqli_query($conn, $sql);
        if(mysqli_num_rows($out) > 0){
            $row = mysqli_fetch_assoc($out);
            echo '<p class="display-4 heading">'.$row['name'].'</p>';
            echo '<div class="form-group row">
                    <video controls class="col-md-9">
                        <source src="'.$row['video'].'" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>';
            echo '<div class="col-md-3 font-weight-bold align-middle">';
            echo '<p class="display-4 text-center text-primary">Details 📊</p>';
            $inner_sql = "SELECT * FROM $table_seasons WHERE ".$row['id']." = id";
            $inner_out = mysqli_query($conn, $inner_sql);
            echo '<table class="table table-hover table-bordered"><thead class="text-danger"><tr><th>Season</th><th>Episodes</th><th>Time</th></tr></thead>';
            while($inner_row = $inner_out->fetch_assoc()) {
                echo '<tr><td>'.$inner_row['season_num'].'</td><td>'.$inner_row['episode_cnt'].'</td><td>'.$inner_row['time_ep'].'</td></tr>';
            }
            echo '</table><br>';
            $inner_sql = "SELECT genre FROM $table_genre WHERE ".$row['id']." = id";
            $inner_out = mysqli_query($conn, $inner_sql);
            while($inner_row = $inner_out->fetch_assoc()) {
                if ($inner_row['genre'] == 'Action') {
                    echo '<h2><small>⚔️ '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Adventure') {
                    echo '<h2><small>🎡 '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Comedy') {
                    echo '<h2><small>😂 '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Crime') {
                    echo '<h2><small>🕵️ '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Fantasy') {
                    echo '<h2><small>🐉 '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Horror') {
                    echo '<h2><small>👻 '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Mystery') {
                    echo '<h2><small>🎭 '.$inner_row['genre'].'</small></h2><br><br>';
                } else if ($inner_row['genre'] == 'Thriller') {
                    echo '<h2><small>🔥 '.$inner_row['genre'].'</small></h2><br><br>';
                }
            }
            echo '</div></div>';
        }
        ?>
    </body>
</html>