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
        
<?php
include('connection.php');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$series_name = $rating = $season_num = $episode_cnt = $time = '';

if(isset($_POST['addnewseries'])){
    $series_name = test_input($_POST['wsname']);
    $rating = test_input($_POST['rating']);

    $sql = "SELECT * FROM $table_webseries where name = '$series_name'";
    $out = mysqli_query($con,$sql);
    if(mysqli_num_rows($out) == 0){
        if(empty($_POST['genre'])){
            echo "Select genre";
        }
        else{
            $maxsize_video = 20971520; // 20MB
     
            $name_video = $_FILES['webvideo']['name'];
            $name_img = $_FILES['webimg']['name'];
            // Set you path
            $target_dir_vid = "videos/";
            $target_dir_img = "images/";
            $temp_video = explode(".", $_FILES["webvideo"]["name"]);
            $newvideoname = round(microtime(true)) . '.' . end($temp_video);
            $target_videofile = $target_dir_vid . $newvideoname;
            $temp_img = explode(".",$_FILES["webimg"]["name"]);
            $newimgname = round(microtime(true)) . '.' . end($temp_img);
            $target_imgfile = $target_dir_img . $newimgname;
    
            // Select file type
            $videoFileType = strtolower(pathinfo($target_videofile,PATHINFO_EXTENSION));
            $imgFileType = strtolower(pathinfo($target_imgfile,PATHINFO_EXTENSION));
            // Valid file extensions
            $extensions_arr_video = array("mp4","avi","3gp","mov","mpeg");
            $extensions_arr_img = array("jpeg","png","gif","psd","raw");
            // Check extension
            if( in_array($videoFileType,$extensions_arr_video) && in_array($imgFileType, $extensions_arr_img)){
        
                // Check file size
                if(($_FILES['webvideo']['size'] >= $maxsize_video) || ($_FILES["webvideo"]["size"] == 0) || 
                ($_FILES['webimg']['size'] == 0)) {
                    echo "File too large. File must be less than 20MB.";
                }
                else{
                    // Upload
                    if(move_uploaded_file($_FILES['webvideo']['tmp_name'],$target_videofile)){
                        if(move_uploaded_file($_FILES['webimg']['tmp_name'], $target_imgfile)){
                            $sql = "INSERT INTO $table_webseries(name, rating, image, video) values ('$series_name', '$rating', 'images/$newimgname', 'videos/$newvideoname')";
                            if(mysqli_query($con, $sql) === TRUE){
                                $sql = "SELECT id FROM $table_webseries where name='$series_name'";
                                $out = mysqli_query($con, $sql);
                                $row = mysqli_fetch_assoc($out);
                                $id = $row['id'];
                                echo $id;
                                foreach($_POST['genre'] as $check) {
                                    $sql = "INSERT INTO $table_genre(id, genre) VALUES ('$id', '$check')";
                                    // mysqli_query($con, $sql);
                                    if (!mysqli_query($con, $sql)) {
                                        echo "<br>Error add genre: " . mysqli_error($con);
                                    }
                                }
                                echo "Upload successfully.";
                            }
                            else{
                                // Set your path
                                $path1 = $_SERVER['DOCUMENT_ROOT'].'/dbms/videos/'. $newvideoname;
                                $path2 = $_SERVER['DOCUMENT_ROOT'].'/dbms/images/'. $newimgname;
                                unlink($path1);
                                unlink($path2);
                            }
                        }
                        else{
                            // Set your path
                            $path = $_SERVER['DOCUMENT_ROOT'].'/dbms/videos/'. $newvideoname;
                            unlink($path);
                        }         
                    }
                }
            }
            else{
                echo "Invalid file extension.";
            }
        }
    }
    else{
        echo "This webseries already exists.";
    }  
}

if(isset($_POST['addnewseason'])){
    $series_name = test_input($_POST['wsname']);
    $season_num = test_input($_POST['season_num']);
    $episode_cnt = test_input($_POST['episode_cnt']);
    $time = test_input($_POST['time']);

    $sql = "SELECT * FROM $table_webseries where name = '$series_name'";
    $out = mysqli_query($con,$sql);
    if(mysqli_num_rows($out) == 0){
        echo "There is no season with than name";
    }
    else{
        $row = mysqli_fetch_assoc($out);            
        $id = $row['id'];
        if($row['seasons']==null && $season_num==1){
            $sql = "INSERT INTO $table_seasons(id, season_num, episode_cnt, time_ep) VALUES ('$id', '$season_num', '$episode_cnt', '$time')";
            if(mysqli_query($con, $sql)){
                $sql = "UPDATE $table_webseries SET seasons=1 WHERE id=$id";
                if(!mysqli_query($con, $sql)){
                    echo mysqli_error($con);
                }
                echo "Season add successfully";
            }
            else{
                echo $id;
                echo "Error adding season" . mysqli_error($con);
            }
        }
        elseif ($row['seasons'] + 1 == $season_num) {
            $sql = "INSERT INTO $table_seasons(id, season_num, episode_cnt, time_ep) VALUES ('$id', '$season_num', '$episode_cnt', '$time')";
            if(mysqli_query($con, $sql)){
                $sql = "UPDATE $table_webseries SET seasons=". (int)($row['seasons']+1)." WHERE id=$id";
                if(!mysqli_query($con, $sql)){
                    echo mysqli_error($con);
                }
                echo "Season add successfully";
            }
            else{
                echo $id;
                echo "Error adding season" . mysqli_error($con);
            }
        }
        else{
            echo "season number should be " . (int)($row['seasons']+1) ;
        }
    }

}

if(isset($_POST['addseries'])){
    echo '<div class="container">
        <h1 class="display-2 text-center">Webseries</h1>
        <form name="series-form" enctype="multipart/form-data" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="wsname" id="wsname" placeholder="Name" required>
            </div>
            <div class="form-group">
                <select class="form-control" id="rating" name="rating" required>
                    <option selected disabled>Rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <label>Genre</label></br>
            <div class="form-check form-group" required>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Action" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Action</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Adventure" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Adventure</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Comedy" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Comedy</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Crime" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Crime</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Fantasy" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Fantasy</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Horror" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Horror</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Mystery" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Mystery</label></br>
                <input class="form-check-input" type="checkbox" name="genre[]" value="Triller" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">Triller</label></br>
            </div> 
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="webimg" name="webimg" required>
                    <label class="custom-file-label" for="webimg">Choose image for Webseries</label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="webvideo" name="webvideo" required>
                    <label class="custom-file-label" for="webvideo">Choose a trailer video for Webseries</label>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" name="addnewseries" value="Add Webseries" class="btn btn-outline-success btn-block">
            </div>
        </form>
    </div>';
}

if(isset($_POST['addseason'])){
    echo '<div class="container mt-4">
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
                <input type="submit" name="addnewseason" value="Add New Season" class="btn btn-outline-dark btn-block">
            </div>
        </form>
    </div>';
}
?>
        <script>
            document.querySelector('.file1').addEventListener('change',function(e){
                var fileName = document.getElementById("webimg").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            })

            document.querySelector('.file2').addEventListener('change',function(e){
                var fileName = document.getElementById("webvideo").files[0].name;
                var nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            })
        </script>
    </body>
</html>
