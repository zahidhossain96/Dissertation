
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>notifications</title>
    <link href ="css/notify.css" rel ="stylesheet" type="text/css"/>
    <?php
    include('./classes/DB.php');
    include('./classes/Login.php');
    include('./classes/Notification.php');
    $showTimeline = False;
    if (Login::isLoggedIn()) {
      $userid = Login::isLoggedIn();
      $username = DB::query('SELECT * FROM users WHERE users.id=:userid', array(':userid'=>$userid));
    ?>
  </head>
  <body>
    <div id="bar">
      <ul id="nav">
        <li id="logo"><a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a></li>
        <li id= "feed"><h1>Notifications</h1></li>
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

    <div id="content">
      <?php
                  $userid = Login::isLoggedIn();
                  if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', array(':userid'=>$userid))) {
                      $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid ORDER BY time desc', array(':userid'=>$userid));
                      foreach($notifications as $notify)
                      {
                        if ($notify['type'] == 2)
                        {
                                  $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$notify['sender']))[0]['username'];
                                  echo "<p id='not'><a href='profile.php?username=";echo $senderName; echo "'><span>".$senderName."</span></a> liked your <a href = 'singlepost.php?postid="; echo $notify['post_id'];echo "'>post</a>!</p><span class='time'>".$notify['time']."</span><hr />";
                          }
                          if ($notify['type'] == 1)
                          {
                                    $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$notify['sender']))[0]['username'];
                                    echo "<p id='not'><a href='profile.php?username=";echo $senderName; echo "'><span>".$senderName."</span></a> commented on your post <a href = 'singlepost.php?postid="; echo $notify['post_id'];echo "'>post</a>!</p><span class='time'>".$notify['time']."</span><hr />";
                            }
                      }
                    }

          }
          else
          {
              echo 'Not logged in';
          }


      ?>
    </div>


  </body>
</html>
