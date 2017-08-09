<!DOCTYPE html>
<html>
  <head>
      <link href ="css/logout.css" rel ="stylesheet" type="text/css"/>
    <meta charset="utf-8">
<?php
include('./classes/DB.php');
include('./classes/Login.php');

if (!Login::isLoggedIn()) {
        die("Not logged in.");
        header('Location: login.php');
}

if (isset($_POST['confirm'])) {

        if (isset($_POST['alldevices'])) {

                DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
                header('Location: login.php');
        } else {
                if (isset($_COOKIE['SNID'])) {
                        DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
                        header('Location: login.php');
                }
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);

        }

}

?>

    <title>LOGOUT</title>
  </head>
  <body>
    <div id="bar">
      <a href="index.php"><img id="logoimg" src="images/logo copy.png" alt="FlanBasket"></a>
    </div>

    <div class="content">
      <h1>Logout of your Account?</h1>
        <p>Are you sure you'd like to logout?</p>
        <form action="logout.php" method="post">
                <p id="checked"><input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices</p><br />
                <input type="submit" name="confirm" value="Confirm">
        </form>
    </div>
  </body>
</html>
