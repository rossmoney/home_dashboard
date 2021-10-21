var prevDashboard = 0;
var maxDashboards = $('.slider').length;

function loopSlider(){
  var xx= setInterval(function(){

    nextDashboard();
  
  }, 30000);
}

$(window).ready(function(){
  $(".slider").hide();

  nextDashboard();
  loopSlider();
});

function nextDashboard()
{
    if(prevDashboard == maxDashboards) {
      $("#slider-" + maxDashboards).fadeOut(400);
      prevDashboard = 0;
    }

    $("#slider-" + prevDashboard).fadeOut(400);
    $("#slider-" + (prevDashboard + 1)).delay(400).fadeIn(400);

    prevDashboard++;
}
