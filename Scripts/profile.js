$(document).ready(function(){


  $('.count').click(function(){
      $('.comment').toggle(500);
  });



  $(".post").mouseover(function(){
      $(".del").show(100);
  });
  $(".post").mouseout(function(){
      $(".del").hide(1000);
  });

  $(".bodypost").mouseover(function(){
      $(".del").show(100);
  });
  $(".bodypost").mouseout(function(){
      $(".del").hide(1000);
  });

  $(".del").mouseover(function(){
      $(".del").show(100);
  });

});
