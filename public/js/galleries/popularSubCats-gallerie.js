$(function(){

  $('.related-subcategory').hide();
  $('.related-subcategory').first().show().addClass('showing-related-subCat');

  $('img[data-related-subCat], div[data-related-subCat]').mouseover(function(){

    var id = $(this).data(),
        element = $('#subCat'+id.relatedSubcat);

    if (!element.hasClass('showing-related-subCat')) {
      $('.showing-related-subCat').fadeOut(300);
      element.addClass('showing-related-subCat');
      $('.related-subcategory').not(element).removeClass('showing-related-subCat');
      element.delay(300).fadeIn(300);
    }
  });
});
