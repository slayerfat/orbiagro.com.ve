$(function(){

  $('.related-subcategory-product').hide();
  $('.related-subcategory-product').first().show().addClass('showing-related-product');

  $('img[data-related-product], div[data-related-product]').mouseover(function(){

    var id = $(this).data(),
        element = $('#relatedProduct'+id.relatedProduct);

    if (!element.hasClass('showing-related-product')) {
      $('.showing-related-product').fadeOut(300);
      element.addClass('showing-related-product');
      $('.related-subcategory-product')
        .not(element)
        .removeClass('showing-related-product');
      element.delay(300).fadeIn(300);
    }
  });
});
