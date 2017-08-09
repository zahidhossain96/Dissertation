<?php
/**
* Similar code can be found at: https://github.com/howCodeORG/Social-Network/tree/Part34
*
**/
class Notification
{
  public static function notifycomment($postid)
  {
    if ($postid != 0) {
      $temp = DB::query('SELECT mealplan.user_id AS receiver, comments.user_id AS sender FROM mealplan, comments WHERE mealplan.id = comments.post_id AND mealplan.id=:postid', array(':postid'=>$postid));
      $r = $temp[0]["receiver"];
      $s = $temp[0]["sender"];
      DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, NOW(), :post_id)', array(':type'=>1, ':receiver'=>$r, ':sender'=>$s, ':post_id'=>$postid));
    }
  }



  public static function notifylike($postid)
  {

    if ($postid != 0)
    {
        $temp = DB::query('SELECT mealplan.user_id AS receiver, post_likes.user_id AS sender FROM mealplan, post_likes WHERE mealplan.id = post_likes.post_id AND mealplan.id=:postid', array(':postid'=>$postid));
        $r = $temp[0]["receiver"];
        $s = $temp[0]["sender"];
        DB::query('INSERT INTO notifications VALUES (\'\', :type, :receiver, :sender, NOW(), :post_id)', array(':type'=>2, ':receiver'=>$r, ':sender'=>$s, ':post_id'=>$postid));
    }
  }

}





 ?>
