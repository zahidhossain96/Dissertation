<!DOCTYPE html>
<html>
  <head>
    <link href ="css/profile.css" rel ="stylesheet" type="text/css"/>
    <script src="Scripts/jquery-1.11.2.min.js"></script>
    <script src="Scripts/profile.js"></script>

<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Notification.php');
include('./classes/Post.php');
include('./classes/Comment.php');

$username = "";

$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {

                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $followerid = Login::isLoggedIn();
                $user=DB::query('SELECT username FROM users WHERE id =:userid', array(':userid'=>$followerid));
                $following = DB::query('SELECT follower_id FROM followers WHERE follower_id =:userid', array(':userid'=>$userid));
                $followers = DB::query('SELECT user_id FROM followers WHERE user_id =:userid', array(':userid'=>$userid));
                if (isset($_POST['follow'])) {

                        if ($userid != $followerid) {

                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {

                                        DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
                                } else {

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

                $image=DB::query('SELECT profileimg FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['profileimg'];

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
        <li id= "feed"><div id = "profileinfo"><img id="profileimg" src="<?php  echo $image; ?>" alt="profile img"><h1> <?php echo $username; ?></h1>
        <p class="follow"><a href="followers.php?username=<?php echo $username;?>"><?php echo count($followers); ?> followers</a>&nbsp;&nbsp;&nbsp;<a href="following.php?username=<?php echo $username;?>"><?php echo count($following); ?> following</a></p></div></li>
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
        <li id="placeholder"><a href="mealplan.php?username=<?php foreach($user as $u){echo  $u['username'];}?>"><img id="shareplanlogo" src="images/pen.png" alt="Share a mealplan"></a></li>
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


      <?php   $posts = Post::displayPosts($userid, $username, $followerid); ?>

    </div>


</body>
</html>
