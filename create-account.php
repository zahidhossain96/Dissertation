<!DOCTYPE html>
  <html>
  <link href ="css/register.css" rel ="stylesheet" type="text/css"/>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div id="bar">
      <a href="login.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
    </div>


    <div class="content">
      <div class="registration">

          <h1 id = "id">Register</h1>

        <form action="create-account.php" method="post">
        <input type="text" name="username" value="" placeholder="Username"><p />
        <input type="password" name="password" value="" placeholder="Password"><p />
        <input type="email" name="email" value="" placeholder="Email"><p />
        <input type="submit" name="createaccount" value="Create Account">
        </form>
        <?php
        /**
        * Similar code can be found at: https://github.com/howCodeORG/Social-Network/tree/Part34
        *
        **/
        include('classes/DB.php');
        include('classes/Mail.php');

        if (isset($_POST['createaccount'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                        if (strlen($username) >= 3 && strlen($username) <= 32) {

                                if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

                                        if (strlen($password) >= 6 && strlen($password) <= 60) {

                                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                                if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {
                                                        $image="http://i.imgur.com/ClOuGSe.png";
                                                        DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email, :image)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email, ':image'=>$image));
                                                        // echo "Success!";
                                                        // header('Location: login.php');
                                                        $cstrong = True;
                                                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                                        $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                                                        DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

                                                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                                                        Mail::sendMail('Welcome to our FlanBasket', '<h1>Your account has been created!</h1><br>Start finding the perfect plan for you at <a href="http://Localhost/Project/index.php"> Flanbasket</a>', $email);
                                                        header('Location: index.php');
                                                } else {
                                                        echo 'Email in use!';
                                                }
                                              } else {
                                                    echo 'Invalid email!';
                                            }
                                          } else {
                                        echo 'Invalid password!';
                                      }
                                }
                                else {
                                        echo 'Invalid username';
                                      }
                        } else {
                                echo 'Invalid username';
                        }

                } else {
                        echo 'User already exists!';
                }
        }
        ?>
      </div>

    </div>

  </body>
</html>
