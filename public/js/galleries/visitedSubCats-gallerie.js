$(function(){

  $('.related-subcategory').hide();
  $('.related-subcategory').first().show().addClass('showing-related-subCat');

  $('img[data-related-subCat-visits], div[data-related-subCat-visits]').mouseover(function(){

    var id = $(this).data(),
        element = $('#subCat-visits-'+id.relatedSubcat);
        console.log(id);
    if (!element.hasClass('showing-related-subCat')) {
      $('.showing-related-subCat').fadeOut(300);
      element.addClass('showing-related-subCat');
      $('.related-subcategory').not(element).removeClass('showing-related-subCat');
      element.delay(300).fadeIn(300);
    }
  });
});
