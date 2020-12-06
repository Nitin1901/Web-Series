<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header text-center m-5">
                <form method="post"> 
                    <input type="submit" class="btn btn-success" name="addseries" value="Add New Webseries" />
                    <input type="submit" class="btn btn-primary" name="addseason" value="Add New season" />
                    <a href="logout.php" class="btn btn-danger">Log Out</a>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="form-1">
                <h1 class="display-2 text-center">Webseries</h1>
                <form name="series-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
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
                        <input type="submit" name="login" value="Add Webseries" class="btn btn-outline-success btn-block create-account">
                    </div>
                </form>
            </div>
        </div>
        <div class="container mt-4">
            <div class="form-1">
                <h1 class="display-4">Season</h1>
                <form name="season-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
                        <input type="submit" name="login" value="Add New Season" class="btn btn-outline-dark btn-block create-account">
                    </div>
                </form>
            </div>
        </div>
        <script>
            document.querySelector(".custom-file-input").addEventListener("change",function(e){
                var fileName = document.getElementById("webimg").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            });
            document.querySelector(".custom-file-input").addEventListener("change",function(e){
                var fileName = document.getElementById("webvideo").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            });
            $(document).ready(function () {
                $("#birth-date").mask("0000-00-00");
                $("#phone-number").mask("0000-000-000");
            })
        </script>
    </body>
</html>
