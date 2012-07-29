$(document).ready(function() {
  // this is just here to fix the whole slug thing
  $('#CollectionSlug').keyup(function(e) {
    var str = $(this).val();
    str = str.toLowerCase();
    str = str.replace(/ /g, '_').replace(/-/g, '_');
    str = str.replace(/\W+/g, '');
    str = str.replace(/_+/g, '-');
    $(this).val(str);
  });
});
