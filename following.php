<!DOCTYPE html>
<html>
  <head>
    <link href ="css/following.css" rel ="stylesheet" type="text/css"/>

<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Notification.php');
include('./classes/Post.php');
include('./classes/Comment.php');
// error_reporting(0);
$username = "";

$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {

                $followerid = Login::isLoggedIn();
                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $user=DB::query('SELECT username FROM users WHERE id =:userid', array(':userid'=>$followerid));

                $following = DB::query('SELECT follower_id FROM followers WHERE follower_id =:userid', array(':userid'=>$userid));
                $followers = DB::query('SELECT user_id FROM followers WHERE user_id =:userid', array(':userid'=>$userid));



                if (isset($_POST['follow'])) {

                        if ($userid != $followerid) {

                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {

                                        DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
                                } else {
                                        echo 'Already following!';

                                }
                                $isFollowing = True;
                        }
                }
                if (isset($_POST['unfollow'])) {

                        if ($userid != $followerid) {

                                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {

                                        DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
                                }
                                $isFollowing = False;
                        }
                }
                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                        //echo 'Already following!';
                        $isFollowing = True;
                }

                $image=DB::query('SELECT profileimg FROM users WHERE id=:userid', array(':userid'=>$userid));

        } else {
                die('User not found!');
        }
}

?>
    <meta charset="utf-8">
    <title>Profile</title>
  </head>
  <body>
    <div id="bar">
      <ul id="nav">
        <li id="logo"><a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a></li>
        <li id= "feed"><div id = "profileinfo"><img id="profileimg" src="<?php  foreach($image as $i){echo $i['profileimg'];}?>" alt="profile img"><h1> <?php echo $username; ?></h1>
        <p class="follow"><a href="followers.php?username=<?php echo $username;?>"><?php echo count($followers); ?> followers</a> &nbsp;&nbsp;&nbsp; <?php echo count($following); ?> following</p></div></li>
        <li class="connection">
          <div class="connectionbtn">
              <form action="profile.php?username=<?php echo $username; ?>" method="post">
                    <?php
                    if ($userid != $followerid) {
                            if ($isFollowing) {
                                    echo '<input type="submit" class="connect" id="disconnect" name="unfollow" value="Disconnect">';
                            } else {
                                    echo '<input type="submit" class="connect" name="follow" value="Connect">';
                            }
                    }



                    ?>
                </form>
          </div>
        </li>

        <li id="notification"><a href="notify.php"><img id="noti" src="images/notification.png" alt="Notifications"></a></li>
        <li id="placeholder"><a href="mealplan.php?username=<?php echo $username;?>"><img id="shareplanlogo" src="images/pen.png" alt="Share a mealplan"></a></li>
        <li id="profile"><a href="profile.php?username=<?php foreach($user as $u){echo  $u['username'];}?>">Profile</a>
             <ul>
                 <li class = "profileLinks"><a href = "fav.php">My favourites</a></li>
                 <li class = "profileLinks"><a href = "useraccount.php">Settings</a></li>
                 <li class = "profileLinks"><a href = "logout.php">Logout</a></li>
             </ul>
         </li>
      </ul>
    </div>

    <div id = "content">
      <div class="border">
        <?php
        error_reporting(0);
        for ($i=0; $i <=count($following); $i++) {
          $followings = DB::query('SELECT follower_id FROM followers WHERE follower_id =:userid', array(':userid'=>$userid))[$i]['follower_id'];
          $peopleIfollow = DB::query('SELECT user_id FROM followers WHERE follower_id =:userid', array(':userid'=>$followings))[$i]['user_id'];

          $friends = DB::query('SELECT * FROM users WHERE id =:userid', array(':userid'=>$peopleIfollow));
          foreach ($friends as $friend) {
            echo "<div class ='contain'><div class ='followers'><a href='profile.php?username=";echo $friend['username']; echo "'><img src='".$friend['profileimg']."' alt='Profile Image' height=50 width=50>";
            echo "<p class = 'users'><a href='profile.php?username=";echo $friend['username']; echo "'>".$friend['username']."</a></p></div><hr><div>";

          }

        }

         ?>
      </div>

    </div>


</body>
</html>
