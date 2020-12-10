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
            .order {
                text-align: center;
                margin-bottom: 20px;
            }
            #all {
                display: none;
            }
            #rating {
                display: none;
            }
            #seasons {
                display: none;
            }
        </style> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    </head>
    <body>
        <div class="page-header">
            <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>! 👋</h2>
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
        <div class="container order">
            <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="search()" method="get">
            <div class="form-group col-sm-8">
                <input type="text" class="form-control" placeholder="Title" name="search">
            </div>
            <button type="submit" class="btn btn-success col-sm-2">Search</button>
            <form>
            <div class="dropdown col-sm-2">
                <button type="text" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Order By
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" onclick="rating()">Rating</a>
                    <a class="dropdown-item" onclick="seasons()">Seasons</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" onclick="none()">None</a>
                </div>
            </div>
        </div>
        <?php
            // Include files
            include("connection.php");
            echo "<div class='container' id='all'><table><tr>";
            $sql = "SELECT * FROM $table_webseries";
            $out = mysqli_query($conn, $sql);
            $j = 1;
            if(mysqli_num_rows($out) > 0){
                // Displaying data
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

            //By rating
            echo "<div class='container' id='rating'><table><tr>";
            $sql = "SELECT * FROM $table_webseries ORDER BY rating DESC";
            $out = mysqli_query($conn, $sql);
            $j = 1;
            if(mysqli_num_rows($out) > 0){
                // Displaying data
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

            //By seasons
            echo "<div class='container' id='seasons'><table><tr>";
            $sql = "SELECT * FROM $table_webseries ORDER BY seasons DESC";
            $out = mysqli_query($conn, $sql);
            $j = 1;
            if(mysqli_num_rows($out) > 0){
                // Displaying data
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

            //Search
            echo "<div class='container' id='searched'><table><tr>";
            $s = "";
            if(isset($_GET['search'])) {
                $s = $_GET['search'];
            }
            $sql = "SELECT * FROM $table_webseries WHERE name LIKE '%".$s."%'";
            $out = mysqli_query($conn, $sql);
            $j = 1;
            if(mysqli_num_rows($out) > 0){
                // Displaying data
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
            } else {
                echo "<div class=\"container\"><div class=\"alert alert-danger\" role=\"alert\"> 0 results. </div></div>";
            }
        ?>
        <script>
            function play(id){
                window.location.href = "play.php?id=" + id;
            }
            function admin() {
                window.location.href = "admin.php";
            }
            function rating() {
                document.getElementById('rating').style.display = 'block';
                document.getElementById('all').style.display = 'none';
                document.getElementById('seasons').style.display = 'none';
                document.getElementById('searched').style.display = 'none';
            }
            function seasons() {
                document.getElementById('seasons').style.display = 'block';
                document.getElementById('rating').style.display = 'none';
                document.getElementById('all').style.display = 'none';
                document.getElementById('searched').style.display = 'none';
            }
            function none() {
                document.getElementById('all').style.display = 'block';
                document.getElementById('rating').style.display = 'none';
                document.getElementById('seasons').style.display = 'none';
                document.getElementById('searched').style.display = 'none';
            }
            function search() {
                document.getElementById('all').style.display = 'none';
                document.getElementById('rating').style.display = 'none';
                document.getElementById('seasons').style.display = 'none';
                document.getElementById('searched').style.display = 'block';
            }
        </script>
    </body>
</html>