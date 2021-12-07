

var button=document.getElementById('botonmenu');


function boton(){
  button.hover(function mouseentra(){
    button.addClass("gradient-border");
    button.removeClass("neon2");
  },
  function mousesale(){
    button.removeClass("gradient-border");
    button.addClass("neon2");
  });
}
 
