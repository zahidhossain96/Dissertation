<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href ="css/forgot-password.css" rel ="stylesheet" type="text/css"/>



    <title>Forgot Password</title>
  </head>
  <body>
    <div id="bar">
      <a href="login.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
    </div>
    <div class="content">
      <h1>Forgot Password</h1>

      <form action="forgot-password.php" method="post">
               Enter E-mail:
              <input type="text" name="email" value="" placeholder="Email"><p />
              <input type="submit" name="resetpassword" value="Reset Password">
      </form>
      <?php
      include('./classes/DB.php');
      include('./classes/Mail.php');

      if (isset($_POST['resetpassword'])) {

              $cstrong = True;
              $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
              $email = $_POST['email'];
              $user_id = DB::query('SELECT id FROM users WHERE email=:email', array(':email'=>$email))[0]['id'];

              if ($user_id==0) {
                echo('email address does not exist!');
              }

              if (strlen($email) > 55 || strlen($email) < 1) {
                      echo('Incorrect length!');
              }

              DB::query('INSERT INTO password_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
              echo 'Email sent!';
              echo '<br />';
              Mail::sendMail('Forgot Password!', "To change password click on the link below <a href='http://localhost/Project/change-password.php?token=$token'>Change my password</a>", $email);
      }

      ?>
    </div>


  </body>
</html>
