$(function(){

  $('.visited-subcategory').hide();
  $('.visited-subcategory').first().show().addClass('showing-related-subCat-visits');

  $('img[data-related-subCat-visits], div[data-related-subCat-visits]').mouseover(function(){

    var id = $(this).data(),
        element = $('#subCat-visits-'+id.relatedSubcatVisits);

    if (!element.hasClass('showing-related-subCat-visits')) {
      $('.showing-related-subCat-visits').fadeOut(300);
      element.addClass('showing-related-subCat-visits');
      $('.visited-subcategory').not(element).removeClass('showing-related-subCat-visits');
      element.delay(300).fadeIn(300);
    }
  });
});
