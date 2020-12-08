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
                padding: 10px;
            }
            .profile-card-2 {
                width: 250px;
                height: 350px;
                margin: 30px;
                overflow: hidden;
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
            .info {
                text-align: center;
            }
        </style>  
    </head>
    <body>
        <div class="page-header">
            <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
            <p>
                <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
                <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
                <?php 
                if ($_SESSION["type"] == 'A') {
                    echo '<button class="btn btn-dark" onclick="admin()">Admin Page</button>';
                }
                ?>
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
                            <h3 class="info">'.$row['name'].'</h3>
                            <div class="font-weight-bold info">
                                Seasons: '.$row['seasons'].'
                                <br>
                                Rating: ';
                                for($i=0; $i<$row['rating']; $i++) {
                                    echo '⭐ ';
                                }
                                echo '<br>';
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
            function admin() {
                // logout.php file removes the stored cookie.
                window.location.href = "admin.php";
            }
        </script>
    </body>
</html>