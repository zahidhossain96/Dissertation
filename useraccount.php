<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
        <link href ="css/profilepic.css" rel ="stylesheet" type="text/css"/>
        <?php
    include('classes/DB.php');
    include('classes/Login.php');
    include('classes/Image.php');

    if (Login::isLoggedIn()) {
            $userid = Login::isLoggedIn();
            $username = DB::query('SELECT * FROM users WHERE users.id=:userid', array(':userid'=>$userid));
    }
    else {
            die('not logged in');
    }
    ?>


    <title>Change profile picture</title>
  </head>
  <body>
    <div id="bar">
      <ul id="nav">
        <li id="logo"><a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a></li>
        <li id= "feed"><h1>Settings</h1></li>
        <li id="notification"><a href="notify.php"><img id="noti" src="images/notification.png" alt="Notifications"></a></li>
        <li id="placeholder"><a href="mealplan.php?username=<?php foreach ($username as $u){echo $u['username']; }?>"><img id="shareplanlogo" src="images/pen.png" alt="Share a mealplan"></a></li>
        <li id="profile"><a href="profile.php?username=<?php foreach ($username as $u){echo $u['username']; }?>"><?php foreach ($username as $u){echo $u['username']; }?></a>
             <ul>
                 <li class = "profileLinks"><a href = "fav.php">My favourites</a></li>
      			     <li class = "profileLinks"><a href = "useraccount.php">Settings</a></li>
      			     <li class = "profileLinks"><a href = "logout.php">Logout</a></li>
             </ul>
         </li>
      </ul>
    </div>
    <br>
    <div id = "content">

      <div class="content2">
        <h2>Change picture</h2>
        <form action="useraccount.php" method="post" enctype="multipart/form-data">
                Upload a new profile image:
                <input type="file" name="profileimg">
                <input type="submit" name="uploadprofileimg" value="Upload Image">
        </form>
        <?php
        if (isset($_POST['uploadprofileimg'])) {
          $image = base64_encode(file_get_contents($_FILES['profileimg']['tmp_name']));
                 $options = array('http'=>array(
                         'method'=>"POST",
                         'header'=>"Authorization: Bearer 4ce43d0ec261e5607494a949932e7dca0599e9da\n".
                         "Content-Type: application/x-www-form-urlencoded",
                         'content'=>$image
                 ));
                 $context = stream_context_create($options);
                 $imgurURL = "https://api.imgur.com/3/image/";
                 $response = file_get_contents($imgurURL, false, $context);
                 $response = json_decode($response);
              //  echo '<pre>';
              //  print_r($response);
              //  echo "</pre>";
               DB::query("UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':profileimg'=>$response->data->link, ':userid'=>$userid));

        }


         ?>
      </div>
      <div class="content3">
        <p><a href="change-password.php">Change password</a></p>
      </div>



    </div>

  </body>
</html>
