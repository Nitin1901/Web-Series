<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["type"]=='user'){
    header("location: user.php");
    exit;
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/formstyle.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .alert-box{
            top:100px;
            width: 35%;
            position: relative;
            margin: auto;
        }
        body {
            background: #7F7FD5;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

            font-family: "Comic Sans MS", "Comic Sans", cursive;
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="page-header">
            <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
            <p>
                <a href="logout.php" class="btn btn-danger">Log Out</a>
            </p>
            <form method="post"> 
                <input type="submit" class="btn btn-warning" name="addseries" value="Add New Webseries" />
                <input type="submit" class="btn btn-warning" name="addseason" value="Add New season" />
            </form>
        </div>
    </div>
        

    <div class="form-1">
        <h1 class='center'>Add New Webseries</h1>
        <form name="series-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <p class="help-block error"><?php echo $websiteErr; ?></p>
            <div class="form-group">
                <input type="text" class="form-control" name="wsname" id="wsname" placeholder="Name" required>
            </div>
            <div class="form-group">
                <select class="form-control" id="rating" name="rating">
                    <option selected disabled>Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="webimg" name="webimg">
                    <label class="custom-file-label" for="webimg">Choose image for Webseries</label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="webvideo" name="webvideo">
                    <label class="custom-file-label" for="webvideo">Choose a trailer video for Webseries</label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Add Webseries" class="btn btn-block create-account">
            </div>
        </form>

    </div>

    <div class="form-1">
        <h1 class='center'>Add New Season</h1>
        <form name="season-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <p class="help-block error"><?php echo $websiteErr; ?></p>
            <div class="form-group">
                <input type="text" class="form-control" name="wsname" id="wsname" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="season_num" id="season_num" placeholder="Season number" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="episode_cnt" id="episode_cnt" placeholder="Number of Episodes" required>
            </div>
            <div class="form-group">
                <input type="time" class="form-control" name="time" id="time" placeholder="Approx time of each episode" required>
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Add New Season" class="btn btn-block create-account">
            </div>
        </form>

    </div>
 
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        document.querySelector('.custom-file-input').addEventListener('change',function(e){
            var fileName = document.getElementById("webimg").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })

        document.querySelector('.custom-file-input').addEventListener('change',function(e){
            var fileName = document.getElementById("webvideo").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })

        function logOut() {
            // logout.php file removes the stored cookie.
            window.location.href = "logout.php";
        }

        function searchAmazon() {
            // logout.php file removes the stored cookie.
            window.location.href = "user.php";
        }

        $(document).ready(function () {
            // writing the format of DOB and phine number
            $('#birth-date').mask('0000-00-00');
            $('#phone-number').mask('0000-000-000');
        })

    </script>
</body>
</html>
