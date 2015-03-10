$(function() {
  var alto  = $(window).height();
  var ancho = $(window).width();

  var navbar = $('.navbar').height() +
                parseInt($('.navbar').css('padding-bottom')) + 2;

  alto = alto - navbar;

  if($(".full").height() < alto){
    $(".full").height(alto);
    $('.full').css({
      'margin-top': parseInt($('.navbar').css('margin-bottom'))*-1,
      'margin-bottom': 0,
    });
    $('.status').css({
      'margin-top': ($(".full").height()/2)-($('.status').height()/2)
    });
  }
});
