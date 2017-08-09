$(document).ready(function(){


  $('.count').click(function(){
      $('.comment').toggle(500);
  });


  $(".title").click(function(){
      $(".bodypost").toggle(500);
      $('move').animate({
        marginLeft: '45' //bring nav back on screen
      }, 0);
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

  $(".title").click(function(){
      $(".desc").toggle(300);
  });

});
