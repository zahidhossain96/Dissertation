<!DOCTYPE html>
<html>
  <head>
    <link href ="css/login.css" rel ="stylesheet" type="text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<?php
include('classes/DB.php');
?>



    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <div id="bar">
      <a href="login.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
    </div>
    <h1 id="login">Login</h1>
    <div id="loginbox">
      <form action="login.php" method="post">
        Username:
        <input type="text" id="username" name="username" value="" placeholder=" Username"><p />
        Password:
        <input type="password" id="password" name="password" value="" placeholder=" Password"><p />
        <p><a id="forgot" href="forgot-password.php">Forgot my password</a></p>
      <input type="submit" name="login" value="Login">
      </form>

      <?php if (isset($_POST['login'])) {
              $username = $_POST['username'];
              $password = $_POST['password'];

              if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                      if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                              // echo 'Logged in!';

                              $cstrong = True;
                              $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                              $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                              DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

                              setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                              setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                              header('Location: index.php');

                      } else {
                              echo '<p class="Incorrect">Incorrect username or password!</p>';
                      }

              } else {
                      echo '<p class ="Incorrect">Incorrect username or password!</p>';
              }

      } ?>

    </div>
    <div class="">

    </div>
    <div class="move">
      <a href="create-account.php">
          <div class="w3-content" style="max-width:400px">
            <div class="mySlides w3-container w3-white w3-card-4">
              <h1><b>Haven't got an account yet?</b></h1>
              <h2>Get one now and start getting fitter with the FlanBasket community!</h2>
              <p>New delicious recipes and meal plans shared everyday by the community!<a id="r" href="create-account.php">Register Now</a></p>
            </div>

            <!--image from bbcgoodfood.com, url https://www.bbcgoodfood.com/recipes/collection/52 -->
            <img class="mySlides" src="images/mulligatawny.jpg" style="width:100%">

            <div class="mySlides w3-container w3-white w3-card-4">
              <br>
              <h1><a href="create-account.php"><b>Sign up now!</b></a></h1>
              <br><br>
              <p>Know a meal plan that would help people improve their diets?</p>
              <p>Share it now to the flan basket community<br>
              <br><br><br><br></p>
            </div>

              <!--image from bbcgoodfood.com, url https://www.bbcgoodfood.com/recipes/10117/superhealthy-pizza -->
            <img class="mySlides" src="images/recipe-image-legacy-id--193739_12.jpg" style="width:100%">
            <!--image from bbcgoodfood.com, url https://www.bbcgoodfood.com/recipes/collection/dairy-free-dinner -->
            <img class="mySlides" src="images/zesty-lamb-chops-with-crushed-kiney-beans.jpg" style="width:100%">
          </div>
          </a>
      </div>

    <script src="Scripts/login.js"></script>
  </body>
</html>
