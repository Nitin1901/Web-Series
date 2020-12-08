<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
        <style>
            a,
            a:hover,
            a:focus {
                color: inherit;
            }
            .page-header {
                margin: 50px;
                text-align: center;
            }
            td{
                padding:16px;
            }
            .profile-card-2 {
                width: 250px;
                height: 370px;
                background-color: #FFF;
                box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.1);
                background-position: center;
                overflow: hidden;
                position: relative;
                margin: 30px auto;
                cursor: pointer;
                border-radius: 10px;
            }
            .profile-card-2:hover {
                transform: scale(1.1);
            }
            .profile-card-2 img {
                transition: all linear 0.25s;
                width: 100%;
                height: 100%;
            }
            .profile-card-2 .profile-name {
                position: absolute;
                left: 30px;
                bottom: 70px;
                font-size: 30px;
                color: #FFF;
                text-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
                font-weight: bold;
                transition: all linear 0.25s;
            }
            .profile-card-2 .profile-icons {
                position: absolute;
                bottom: 30px;
                right: 30px;
                color: #FFF;
                transition: all linear 0.25s;
            }
            .profile-card-2 .profile-username {
                position: absolute;
                bottom: 50px;
                left: 30px;
                color: #FFF;
                font-size: 13px;
                transition: all linear 0.25s;
            }
            .profile-card-2 .profile-icons .fa {
                margin: 5px;
            }
            .profile-card-2:hover .profile-name {
                bottom: 80px;
            }
            .profile-card-2:hover .profile-username {
                bottom: 60px;
            }
            .profile-card-2:hover .profile-icons {
                right: 40px;
            }
        </style>  
    </head>
    <body>
        <div class="page-header">
            <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
            <p>
                <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
                <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
            </p>
        </div>
        <?php
            // Include files
            include("connection.php");
            $sql = "SELECT * FROM $table_webseries";
            $out = mysqli_query($conn, $sql);
            $j = 1;
            if(mysqli_num_rows($out) > 0){
                // Displaying data
                echo "<div class='container'><table><tr>";
                while($row = $out->fetch_assoc()){
                    if($row['seasons']!=null){
                        echo '<td>
                            <div class="profile-card-2" onclick="play('.$row['id'].')">
                                <img src="'.$row['image'].'" class="img img-responsive">
                            </div>
                            <div class="font-weight-bold">
                                Seasons: '.$row['seasons'].'
                                <br>
                                Rating: '.$row['rating'].'/5
                                <br>';
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
                        echo '</div>
                        </td>';
                        if(($j)%4==0){
                            echo "</tr><tr>";
                        }
                        $j++;
                    }
                }
                echo "</table></div>";
            }        
        ?>
        <script>
            function play(id){
                window.location.href = "play.php?id=" + id;
            }
        </script>
    </body>
</html>