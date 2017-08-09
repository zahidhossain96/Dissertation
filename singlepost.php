
<!DOCTYPE html>
<html>
  <head>
    <link href ="css/index.css" rel ="stylesheet" type="text/css"/>
    <script src="Scripts/jquery-1.11.2.min.js"></script>
    <script src="Scripts/index.js"></script>
    <?php

    include('./classes/DB.php');
    include('./classes/Login.php');
    include('./classes/Post.php');
    include('./classes/Comment.php');
    include('./classes/Notification.php');
    include('./classes/Search.php');
    $showTimeline = False;
    $username="";
    if (Login::isLoggedIn()) {
            $userid = Login::isLoggedIn();
            $showTimeline = True;
            $username = DB::query('SELECT * FROM users WHERE users.id=:userid', array(':userid'=>$userid));
            if (isset($_POST['x'])) {
                if (DB::query('SELECT id FROM mealplan WHERE id=:postid AND user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$userid))) {
                    DB::query('DELETE FROM post_likes WHERE post_id=:postid', array(':postid'=>$_GET['postid']));
                    DB::query('DELETE FROM mealplan WHERE id=:postid and user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$userid));
                    echo 'Post deleted!';
                }
              }
    } else {
            header('Location: login.php');
            // $showTimeline = False;
    }

    $username = DB::query('SELECT users.username FROM users WHERE users.id=:userid', array(':userid'=>$userid));

    if (isset($_GET['postid'])) {
      if (isset($_POST['favourite'])) {
            Post::likePost($_GET['postid'], $userid);
          }
          if (isset($_POST['unlike'])) {
            Post::likePost($_GET['postid'], $userid);
          }
    }

    if (isset($_POST['comment'])) {
            Comment::createComment($_POST['commentbody'], $_GET['postid'], $userid);
    }

    $followingposts = DB::query('SELECT * FROM users, mealplan
      WHERE users.id = mealplan.user_id AND mealplan.id = :postid
      ORDER BY mealplan.posted_at DESC;', array(':postid'=>$_GET['postid'])); //WHERE mealplan.user_id = followers.user_id
      //AND users.id = mealplan.user_id

     ?>
    <meta charset="utf-8">
    <title>Newsfeed</title>
  </head>
  <body>
    <div id="bar">
      <ul id="nav">
        <li id="logo"><a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a></li>
        <li id= "feed"><h1>Post</h1></li>
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
    <div id="searchdiv">
    <form action="index.php" method="post">
      <input type="text" id="searchbx"name="searchbox" value="" placeholder="Search">
      <input type="submit" id="searchbtn" name="search" value="Search">
    </form>
    </div>


         <?php
         if (isset($_POST['searchbox'])) {
                 $input = '%'.$_POST['searchbox'].'%';
                 Search::searchElements($input,$userid);
        }
        echo "<h2>Global Meal Plans</h2>";
        foreach ($followingposts as $post) {

                // error_reporting(0);


                echo "<div class = 'post'>";
                if (DB::query('SELECT id FROM mealplan WHERE user_id=:userid AND user_id=:user_id', array(':userid'=>$post['user_id'], ':user_id'=>$userid))) {
                    echo "<div id='deletediv'>
                    <form action='singlepost.php?postid=".$post['id']."' method='post'>
                    <input type='submit' class='del' name='x' value='x'>
                    </form>
                    </div>";
                }
                echo "<div class= 'profileimg'><a href='profile.php?username="; echo $post['username']; echo "'><img class='profileimg2' src= '".$post['profileimg']."' alt='Profile Image'style= 'width:60px;height:50px;'></a></div>";

                echo "<div class = 'usr'><p class = 'username'><a href='profile.php?username="; echo $post['username']; echo "' class = 'stylelink'>@".$post['username']."</a></p></div><p class ='title'>".$post['title']."</p><br>
                <div class='desc'><p>".$post['description']."</p></div>
                <div class = 'bodypost'><p class= 'rlable'>Meal 1 Recipe: </p><p>".$post['recipe1']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient1']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction1'].
                "</p><br><hr>"."<br><p class= 'rlable'>Meal 2 Recipe:</p><p id='recipe2'><p>".$post['recipe2']."</p><br><p class='ilable'>Ingredients: </p><p id='ingredient2'>".$post['ingredient2']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction2'].
                "</p><br><hr>"."<br><p class= 'rlable'>Meal 3 Recipe: </p><p>".$post['recipe3']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient3']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction3'].
                "</p><br><hr>"."<br><p class= 'rlable'>Meal 4 Reacipe: </p><p>".$post['recipe4']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient4']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction4'].
                "</p><br><hr>"."<br><p class= 'rlable'>Meal 5 Recipe: </p><p>".$post['recipe5']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient5']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction5'];
                echo "</p></div>";
                ?>


            <?php

                echo "<div class='move'>";
                echo "<div id='favouriteButton'>
                <form action='singlepost.php?postid=".$post['id']."' method='post'>";
                if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$post['id'], ':userid'=>$userid))) {
                  echo "<input type='submit' class='favourite' name='favourite' value='Favourite'>";

                } else {
                  echo "<input type='submit' class = 'unfavourite' name='unlike' value='Favourited'>";

                }
                echo " ".$post['likes']." favorited it</span>
                </form>

                </div>";



                echo "<div id = 'commentbox'><form action='singlepost.php?postid=".$post['id']."' method='post'>
                <textarea name='commentbody' class = 'commentbody' rows='3' cols='50'></textarea>
                <input type='submit' class='commentbtn' name='comment' value='Comment'>
                </form></div>";

                Comment::displayComments($post['id']);

                echo "
                </div></div><br>";
        }
    ?>
    </div>
  </body>
</html>
