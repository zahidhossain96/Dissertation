<!DOCTYPE html>
<html>
  <head>
    <link href ="css/forgot-password.css" rel ="stylesheet" type="text/css"/>
    <meta charset="utf-8">

<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Mail.php');

$tokenIsValid = False;
if (Login::isLoggedIn()) {

        if (isset($_POST['changepassword'])) {

                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
                $userid = Login::isLoggedIn();

                if (password_verify($oldpassword, DB::query('SELECT password FROM users WHERE id=:userid', array(':userid'=>$userid))[0]['password'])) {

                        if ($newpassword == $newpasswordrepeat) {

                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                        DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                        echo 'Password changed successfully!';
                                        Mail::sendMail('Password Changed!', "Your password has been changed, please log in again at <a href='http://localhost/Project/login.php'>Login</a>", $email);
                                        header('Location: index.php');
                                }

                        } else {
                                echo '<p>Passwords don\'t match. please enter matching passwords</p>';
                        }

                } else {
                        echo '<p>Old password is incorrect, please try again</p>';
                }

        }

} else {
        if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))) {
                $userid = DB::query('SELECT user_id FROM password_tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                $tokenIsValid = True;
                if (isset($_POST['changepassword'])) {

                        $newpassword = $_POST['newpassword'];
                        $newpasswordrepeat = $_POST['newpasswordrepeat'];

                                if ($newpassword == $newpasswordrepeat) {

                                        if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                                DB::query('UPDATE users SET password=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));

                                                DB::query('DELETE FROM password_tokens WHERE user_id=:userid', array(':userid'=>$userid));

                                                header('Location: index.php');

                                        }

                                } else {

                                }

                        }


        } else {
                echo 'Token invalid';
        }
} else {
        echo 'Not logged in';
}
}

?>


    <title>Change password</title>
  </head>
  <body>
    <div id="bar">
      <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
    </div>
    <div class="content">
      <h1>Change your Password</h1>
      <form action="<?php if (!$tokenIsValid) { echo 'change-password.php'; } else { echo 'change-password.php?token='.$token.''; } ?>" method="post">
              <?php if (!$tokenIsValid) { echo '<p>Old password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type="password" name="oldpassword" value="" placeholder="Current Password ..."></p>'; } ?>
              <p>Enter Your New Password&nbsp;&nbsp;
              <input type="password" name="newpassword" value="" placeholder="New Password"></p>
              Repeat your password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password"></br>
              <input type="submit" name="changepassword" value="Change Password">
      </form>
    </div>

  </body>
</html>
