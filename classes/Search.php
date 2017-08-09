<?php


/**
* 
*
**/
class Search
{
  //$_POST['searchbox']

  public static function searchElements($input,$userid)
  {
      echo "<h2>My Search Results</h2>";
      if(!DB::query("SELECT username FROM users WHERE username =:input",array(":input"=>$input))){
         $query = DB::query("SELECT * FROM mealplan WHERE
           mealplan.title LIKE :input OR
           mealplan.recipe1 LIKE :input OR mealplan.ingredient1 LIKE :input OR mealplan.instruction1 LIKE :input OR
           mealplan.recipe2 LIKE :input OR mealplan.ingredient2 LIKE :input OR mealplan.instruction2 LIKE :input OR
           mealplan.recipe3 LIKE :input OR mealplan.ingredient3 LIKE :input OR mealplan.instruction3 LIKE :input OR
           mealplan.recipe4 LIKE :input OR mealplan.ingredient4 LIKE :input OR mealplan.instruction4 LIKE :input OR
           mealplan.recipe5 LIKE :input OR mealplan.ingredient5 LIKE :input OR mealplan.instruction5 LIKE :input OR mealplan.description LIKE :input", array(":input"=>$input)
         );


         echo "<h3>Mealplans found:</h3>";
         if (count($query) == 0) {
           echo "<p class='noSearch'>Sorry, it seems like there is no matching mealplans at the moment.</p>";
         }
         else {

           foreach($query as $row) {
             $username = DB::query("SELECT * FROM users WHERE id =:input",array(":input"=>$row['user_id']));
            //  $usrname = DB::query('SELECT users.username FROM users, mealplan WHERE users.id = :row', array(':row'=>$row['user_id']));
             $title=$row['title'];
             $recipe1=$row['recipe1'];
             $ingredient1=$row['ingredient1'];
             $instruction1=$row['instruction1'];

             $recipe2=$row['recipe2'];
             $ingredient2=$row['ingredient2'];
             $instruction2=$row['instruction2'];

             $recipe3=$row['recipe3'];
             $ingredient3=$row['ingredient3'];
             $instruction3=$row['instruction3'];

             $recipe4=$row['recipe4'];
             $ingredient4=$row['ingredient4'];
             $instruction4=$row['instruction4'];

             $recipe5=$row['recipe5'];
             $ingredient5=$row['ingredient5'];
             $instruction5=$row['instruction5'];

             $id = $row['id'];

             echo "<div class=post>";
             echo "<div class= 'profileimg'><a href='profile.php?username="; foreach($username as $img){ echo $img['username'];} echo "'><img class='profileimg2' src= '"; foreach($username as $img){ echo $img['profileimg'];} echo "' alt='Profile Image'style= 'width:60px;height:50px;'></a></div>";
             echo '<div class = "usr"><p id = "username"><a href="profile.php?username='; foreach($username as $u){ echo $u['username']; } echo '">@'; foreach($username as $u){echo $u['username'];} echo'</a></p></div>';
             echo '<p class = "title">'.$title.'</p></br><div class = "bodypost"><p class = "rlable"><b>Meal 1 Recipe:</b><br>'.$recipe1.'</p></br><p class = "ilable">Ingredinets:</p><p>'.$ingredient1.'</p></br><p class = "inlable"><b>Instructions:</b><br>'.$instruction1.
             '</p><hr></br></br><p class = "rlable"><b>Meal 2 Recipe:</b></p><br><p>'.$recipe2.'</p></b></br><p class = "ilable"><b>Ingredients:</b><br><p>'.$ingredient2.'</p></br><p class = "inlable"><b>Instructions:</b></p><br><p>'.$instruction2.
             '</p><hr></br></br><p class = "rlable"><b>Meal 3 Recipe:</b></p><br><p>'.$recipe3.'</p></b></br><p class = "ilable"><b>Ingredients:</b><br><p>'.$ingredient3.'</p></br><p class = "inlable"><b>Instructions:</b></p><br><p>'.$instruction3.
             '</p><hr></br></br><p class = "rlable"><b>Meal 4 Recipe:</b></p><br><p>'.$recipe4.'</p></b></br><p class = "ilable"><b>Ingredients:</b><br><p>'.$ingredient4.'</p></br><p class = "inlable"><b>Instructions:</b></p><br><p>'.$instruction4.
             '</p><hr></br></br><p class = "rlable"><b>Meal 5 Recipe:</b></p><br><p>'.$recipe5.'</p></b></br><p class = "ilable"><b>Ingredients:</b><br><p>'.$ingredient5.'</p></br><p class = "inlable"><b>Instructions:</b></p><br><p>'.$instruction5.'</p></hr></br></br></div>';


             echo "<div id='favouriteButton'>
             <form action='index.php?postid=".$row['id']."' method='post'>";
             if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$row['id'], ':userid'=>$userid))) {
               echo "<input type='submit' class='favourite' name='favourite' value='Favourite'>";
             } else {
               echo "<input type='submit' class = 'unfavourite' name='unlike' value='Favourite'>";
             }
             echo "<span>".$row['likes']." liked it</span>
             </form>

             </div>";
             echo "<div id = 'commentbox'><form action='index.php?postid=".$row['id']."' method='post'>
             <textarea name='commentbody' class = 'commentbody' rows='3' cols='50'></textarea>
             <input type='submit' class='commentbtn' name='comment' value='Comment'>
             </form></div>";

             Comment::displayComments($row['id']);

            echo "</div><br>";
         }

       }
       echo "<hr>";
     }
      if(DB::query("SELECT username FROM users WHERE username LIKE :input",array(":input"=>$input))){

        $query = DB::query("SELECT * FROM users WHERE username LIKE :input", array(":input"=>$input));
        echo"<h3>Users found:</h3>";
        if (count($query) == 0) {
          echo "<p class='noSearch'>Sorry, it seems like there is no matching mealplans at the moment.</p>";
        }
        else {
          foreach($query as $row)
          {
              $usr=$row['username'];
              $img=$row['profileimg'];
              //$id = $row['id'];
              echo "<div class=post>";
              echo "<div class= 'profileimg' ><a href='profile.php?username="; echo $usr; echo "'><img class='profileimg2' src= '".$img."' alt='Profile Image'style= 'width:60px;height:50px;'></a></div>";

              echo "<div id='searchuser'><p class = 'username' ><a href='profile.php?username="; echo $usr; echo "' class = 'stylelink'>@".$usr."</a></p></div><br>";
              echo "</div> <br>";

          }
          echo "<br>";
      }



    }
    // Search::searchElements($input);
  }

}





 ?>
