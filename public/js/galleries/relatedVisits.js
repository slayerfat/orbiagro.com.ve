$(function(){

  $('.related-subcategory-product').hide();
  $('.related-subcategory-product').first().show().addClass('showing-related');

  $('img[data-related], div[data-related]').mouseover(function(){

    var id = $(this).data();

    var element = $('#'+id.related);

    if (!element.hasClass('showing-related')) {
      $('.showing-related').fadeOut(300);
      element.addClass('showing-related');
      $('.related-subcategory-product').not(element).removeClass('showing-related');
      element.delay(300).fadeIn(300);
    }
  });
});
