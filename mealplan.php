<html>
  <head>
    <link href ="css/mealplan.css" rel ="stylesheet" type="text/css"/>

    <?php
    include('./classes/DB.php');
    include('./classes/Login.php');
    include('./classes/Notification.php');
    include('./classes/Post.php');

    $username = "";
    $verified = False;
    $isFollowing = False;
    if (isset($_GET['username'])) {
            if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {

                    $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                    $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];

                    $followerid = Login::isLoggedIn();

                    if (isset($_POST['post'])) {
                            $title = $_POST['title'];
                            $recipe1 = $_POST['recipe1'];
                            $ingredient1 = $_POST['ingredient1'];
                            $instruction1= $_POST['instruction1'];

                            $recipe2 = $_POST['recipe2'];
                            $ingredient2 = $_POST['ingredient2'];
                            $instruction2= $_POST['instruction2'];

                            $recipe3 = $_POST['recipe3'];
                            $ingredient3 = $_POST['ingredient3'];
                            $instruction3= $_POST['instruction3'];

                            $recipe4 = $_POST['recipe4'];
                            $ingredient4 = $_POST['ingredient4'];
                            $instruction4= $_POST['instruction4'];

                            $recipe5 = $_POST['recipe5'];
                            $ingredient5 = $_POST['ingredient5'];
                            $instruction5= $_POST['instruction5'];

                            $desc= $_POST['desc'];

                            $loggedInUserId = Login::isLoggedIn();

                            if (strlen($title) > 55 || strlen($title) < 1) {
                              die('
                              <div id="bar">
                                <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
                              </div>
                            <div class = "die">  Incorrect Title Length!</div>');
                            }
                            if (strlen($recipe1) > 80 || strlen($recipe2) > 80 || strlen($recipe3) > 80 || strlen($recipe4) > 80 || strlen($recipe5) > 80) {
                                    die('
                                    <div id="bar">
                                      <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
                                    </div>
                                  <div class = "die">  Recipe name too long!</div>');
                            }
                            if (strlen($ingredient1) > 8000 || strlen($ingredient2) > 8000 || strlen($ingredient3) > 8000 || strlen($ingredient4) > 8000 || strlen($ingredient5) > 8000) {
                              die('
                              <div id="bar">
                                <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
                              </div>
                            <div class = "die">  Ingredients too long!</div>');
                            }

                            if (strlen($instruction1) > 15000 || strlen($instruction2) > 15000 || strlen($instruction3) > 15000 || strlen($instruction4) > 15000 || strlen($instruction5) > 15000) {
                              die('
                              <div id="bar">
                                <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
                              </div>
                            <div class = "die">  Instructions too long!</div>');
                            }

                            if ($desc > 160) {
                              die('
                              <div id="bar">
                                <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
                              </div>
                            <div class = "die">  Description is too long!</div>');
                            }


                            if ($loggedInUserId == $userid) {

                                    DB::query('INSERT INTO mealplan VALUES (\'\', :title, :recipe1, :ingredient1, :instruction1, :recipe2, :ingredient2, :instruction2,
                                      :recipe3, :ingredient3, :instruction3, :recipe4, :ingredient4, :instruction4, :recipe5, :ingredient5, :instruction5, NOW(), :userid, 0, :description)',
                                      array(':title'=>$title,
                                      'recipe1'=>$recipe1, 'ingredient1' => $ingredient1, 'instruction1'=>$instruction1,
                                      'recipe2'=>$recipe2, 'ingredient2' => $ingredient2, 'instruction2'=>$instruction2,
                                      'recipe3'=>$recipe3, 'ingredient3' => $ingredient3, 'instruction3'=>$instruction3,
                                      'recipe4'=>$recipe4, 'ingredient4' => $ingredient4, 'instruction4'=>$instruction4,
                                      'recipe5'=>$recipe5, 'ingredient5' => $ingredient5, 'instruction5'=>$instruction5, ':userid'=>$userid, ':description'=>$desc));
                                      header('Location: index.php');
                            } else {
                                    die('Incorrect user!');
                            }
                    }



            } else {
                    die('User not found!');
            }
    }

    ?>


<!DOCTYPE html>

    <meta charset="utf-8">
    <title>Create a Plan</title>
  </head>
  <body>
    <div id="bar">
      <ul id="nav">
        <li id="logo"><a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a></li>
        <li id= "feed"><h1>Create a mealplan</h1></li>
        <li id="notification"><a href="notify.php"><img id="noti" src="images/notification.png" alt="Notifications"></a></li>
        <li id="placeholder"><a href="mealplan.php?username=<?php echo $username;?>"><img id="shareplanlogo" src="images/pen.png" alt="Share a mealplan"></a></li>
        <li id="profile"><a href="profile.php?username=<?php echo  $username;?>"><?php echo $username; ?></a>
             <ul>
                 <li class = "profileLinks"><a href = "fav.php">My favourites</a></li>
                 <li class = "profileLinks"><a href = "useraccount.php">Settings</a></li>
                 <li class = "profileLinks"><a href = "logout.php">Logout</a></li>
             </ul>
         </li>
      </ul>
    </div>
    <div id="content">
        <div class=form>

            <form action="mealplan.php?username=<?php echo $username; ?>" method="post">
                    <p id="title">Title of meal plan:</p>
                    <input type="text" id="titletext" name="title" value="" placeholder="Title"><br><br>
                    <p>Short Description of meal plan</p>
                    <textarea name="desc" id="desc" rows="4" cols="40"></textarea>
                    <hr>

                    <p><b>1st</b> meal recipe name:</p>
                    <input type="text" name="recipe1" value="" placeholder="Recipe name"><br><br>
                    <p>Ingredients required for recipe: </p>
                    <textarea name="ingredient1" rows="8" cols="80"></textarea><br><br>
                    <p>Recipe Instructions: </p>
                    <textarea name="instruction1" rows="8" cols="80"></textarea><br><br><br><br>
                    <hr>

                    <p><b>2nd</b> meal recipe name: </p>
                    <input type="text" name="recipe2" value="" placeholder="Recipe name"><br><br>
                    <p>Ingredients required for recipe: </p>
                    <textarea name="ingredient2" rows="8" cols="80"></textarea><br><br>
                    <p>Recipe Instructions: </p>
                    <textarea name="instruction2" rows="8" cols="80"></textarea><br><br><br><br>
                    <hr>

                    <p><b>3rd</b> meal recipe name: </p>
                    <input type="text" name="recipe3" value="" placeholder="Recipe name"><br><br>
                    <p>Ingredients required for recipe: </p>
                    <textarea name="ingredient3" rows="8" cols="80"></textarea><br><br>
                    <p>Recipe Instructions: </p>
                    <textarea name="instruction3" rows="8" cols="80"></textarea><br><br><br><br>
                    <hr>

                    <p><b>4th</b> meal recipe name: </p>
                    <input type="text" name="recipe4" value="" placeholder="Recipe name"><br><br>
                    <p>Ingredients required for recipe: </p>
                    <textarea name="ingredient4" rows="8" cols="80"></textarea><br><br>
                    <p>Recipe Instructions: <p>
                    <textarea name="instruction4" rows="8" cols="80"></textarea><br><br><br><br>
                    <hr>

                    <p><b>5th</b> meal recipe name: </p>
                    <input type="text" name="recipe5" value="" placeholder="Recipe name"><br><br>
                    <p>Ingredients required for recipe: </p>
                    <textarea name="ingredient5" rows="8" cols="80"></textarea><br><br>
                    <p>Recipe Instructions: </p>
                    <textarea name="instruction5" rows="8" cols="80"></textarea><br><br>
                    <input type="submit" id = "submitbtn" name="post" value="Create">
              </form>
            </div>
    </div>
  </body>
</html>
