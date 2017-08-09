<?php

/**
* Similar code can be found at: https://github.com/howCodeORG/Social-Network/tree/Part34
*
**/
class Post
{

  public static function likePost($postId, $likerId)
  {
    if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId))) {
                           DB::query('UPDATE mealplan SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postId));
                           DB::query('INSERT INTO post_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$postId, ':userid'=>$likerId));
                           Notification::notifylike($postId);
                   }
                   else {
                           DB::query('UPDATE mealplan SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postId));
                           DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$postId, ':userid'=>$likerId));
                   }
  }

  // public static function redirectToPostProfile(){
  //   if (DB::post('SELECT user_id FROM mealplan WHERE user_id=:user_id AND id=:postid')array(':user_id'=>$user, ':postid'=:$postid)) {
  //
  //   }
  //
  // }
  public static function displayPosts($userid, $username, $loggedInUserId) {
                  $dbposts = DB::query('SELECT * FROM mealplan WHERE user_id=:userid ORDER BY posted_at DESC', array(':userid'=>$userid));
                  $img = DB::query('SELECT * FROM users WHERE users.id=:userid', array(':userid'=>$userid));
                  $posts = "";
                  if (Login::isLoggedIn()) {
                          $userid = Login::isLoggedIn();
                          if (isset($_POST['x'])) {
                              if (DB::query('SELECT id FROM mealplan WHERE id=:postid AND user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$userid))) {
                                  DB::query('DELETE FROM post_likes WHERE post_id=:postid', array(':postid'=>$_GET['postid']));
                                  DB::query('DELETE FROM mealplan WHERE id=:postid and user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$userid));
                                  echo 'Post deleted!';
                              }
                            }
                  }

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

                  foreach ($dbposts as $post) {

                          echo "<div class = 'post'>";
                          if (DB::query('SELECT id FROM mealplan WHERE user_id=:userid AND user_id=:user_id', array(':userid'=>$post['user_id'], ':user_id'=>$userid))) {
                              echo "<div id='deletediv'>
                              <form action='profile.php?username="; echo $username; echo "&postid=".$post['id']."' method='post'>
                              <input type='submit' class='del' name='x' value='x'>
                              </form>
                              </div>";
                          }
                          echo "<div class= 'profileimg'><a href='profile.php?username="; echo $username; echo "'><img class='profileimg2' src= '"; foreach($img as $i){echo $i['profileimg'];} echo"' alt='Profile Image'style= 'width:60px;height:50px;'></a></div>";

                          echo "<div class = 'usr'><p class = 'username'><a href='profile.php?username="; echo $username; echo "' class = 'stylelink'>@".$username."</a></p></div><p class ='title'>".$post['title']."</p><br>
                          <div class='desc'><p>".$post['description']."</p></div>
                          <div class = 'bodypost'><p class= 'rlable'>Recipe Name: </p><p>".$post['recipe1']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient1']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction1'].
                          "</p><br><hr>"."<br><p class= 'rlable'>Recipe Name:</p><p id='recipe2'><p>".$post['recipe2']."</p><br><p class='ilable'>Ingredients: </p><p id='ingredient2'>".$post['ingredient2']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction2'].
                          "</p><br><hr>"."<br><p class= 'rlable'>Recipe Name: </p><p>".$post['recipe3']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient3']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction3'].
                          "</p><br><hr>"."<br><p class= 'rlable'>Recipe Name: </p><p>".$post['recipe4']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient4']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction4'].
                          "</p><br><hr>"."<br><p class= 'rlable'>Recipe Name: </p><p>".$post['recipe5']."</p><br><p class='ilable'>Ingredients: </p><p>".$post['ingredient5']."</p><br><p class='inlable'>Instructions: </p><p>".$post['instruction5'];
                          echo "</p></div>";

                          echo "<div class='move'>";
                          echo "<div id='favouriteButton'>
                          <form action='profile.php?username="; echo $username; echo "&postid=".$post['id']."' method='post'>";
                          if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$post['id'], ':userid'=>$userid))) {
                            echo "<input type='submit' class='favourite' name='favourite' value='Favourite'>";
                          } else {
                            echo "<input type='submit' class = 'unfavourite' name='unlike' value='Favourite'>";
                          }
                          echo "<span>".$post['likes']." favorited it</span>
                          </form>

                          </div>";



                          echo "<div id = 'commentbox'><form action='profile.php?username="; echo $username; echo "&postid=".$post['id']."' method='post'>
                          <textarea name='commentbody' class = 'commentbody' rows='3' cols='50'></textarea>
                          <input type='submit' class='commentbtn' name='comment' value='Comment'>
                          </form></div>";

                          Comment::displayComments($post['id']);

                          echo "
                          </div></div><br>";
                  }

                return $posts;
  }

public static function postid($postid){
  return $postid;
}


}

?>
