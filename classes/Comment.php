<?php
/**
 *
 */

 /**
 * Similar code can be found at: https://github.com/howCodeORG/Social-Network/tree/Part34
 *
 **/
 class Comment {
         public static function createComment($commentBody, $postId, $userId) {

                 if (!DB::query('SELECT id FROM mealplan WHERE id=:postid', array(':postid'=>$postId))) {
                         echo 'Invalid post ID';
                 } else {
                         DB::query('INSERT INTO comments VALUES (\'\', :comment, :userid, NOW(), :postid)', array(':comment'=>$commentBody, ':userid'=>$userId, ':postid'=>$postId));
                         Notification::notifycomment($postId);
                 }
         }

         public static function displayComments($postId) {
                $comments = DB::query('SELECT comments.id, comments.comment, users.username, users.profileimg FROM comments, users WHERE post_id = :postid AND comments.user_id = users.id', array(':postid'=>$postId));

                echo "<div class='commentcount'><p class='count'>".count($comments)."&nbsp commented on this post</p></div>";
                foreach($comments as $comment) {
                        echo "<div class='comment'>
                        <div class= 'cprofileimg'><a href='profile.php?username="; echo $comment['username']; echo "'><img src= '".$comment['profileimg']."' alt='Profile Image'style= 'width:40px;height:30px;'></a></div> <p id='textcomment'><a href='profile.php?username="; echo $comment['username'];echo "'>@".$comment['username']."</a> - ".$comment['comment']."</p><hr /></div>";


                }



        }
 }


 ?>
