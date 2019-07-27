/*
 * Processes
 * ------------------------------------------------------------------------------------------------ */
$(function()
{
  generatePermalink();
  checkSlug();

  // Check slug
  var delay = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();
  $('#slug').keyup(function()
  {
    delay(function(){
      generatePermalink();
      checkSlug();
      runValidOneCommon($('#slug'), $('#save_post'), $('#publish_post'));
    }, 500 );
  });
  $('#slug, #publish_datetime, input[name="categories[]"]').change(function()
  {
    generatePermalink();
    checkSlug();
  });
});


/*
 * Functions
 * ------------------------------------------------------------------------------------------------ */
function checkSlug()
{
  var $target             = $('#slug');
  var $submit_button      = $('#publish_post');
  var $target_wrapper     = $('#input_wrapper_slug');
  var $target_table       = $target_wrapper.attr('data-target_table');
  var $this_site_id       = $('#site_id').val();
  var $this_posttype_id   = $('#posttype_id').val();
  var $this_permalink_uri = $('#permalink_uri').val();
  var $this_id            = ($target_wrapper.hasAttr('data-this_id')) ? $target_wrapper.attr('data-this_id') : null;

  $.ajax({
    type : 'GET',
    url  : './ajax/validation/check_post_slug.php',
    data : {
      target_table       : $target_table,
      this_site_id       : $this_site_id,
      this_posttype_id   : $this_posttype_id,
      this_permalink_uri : $this_permalink_uri,
      this_id            : $this_id,
    },
    dataType : 'json',
    success  : function(data)
    {
      if (data.result == 1)
      {
        if($('p.inputAlert').length)
        {
          $('p.inputAlert').remove();
          $target.parent().addClass('has-success');
          $target.parent().removeClass('has-error');
          $target.closest('.form-group').find('.validIcon').removeClass('hidden');
          $target.closest('.form-group').find('.invalidIcon').addClass('hidden');
          $submit_button.removeClass('invalid');
        }
      }
      if (data.result == 8)
      {
        $('.inputAlert').remove();
        $('div#input_wrapper_slug').after('<p class="alert alert-danger inputAlert">' + TXT_CHECKSLUG_WAR_OVERLAPSLUG + '</p>');
        $target.parent().removeClass('has-success');
        $target.parent().addClass('has-error');
        $target.closest('.form-group').find('.validIcon').addClass('hidden');
        $target.closest('.form-group').find('.invalidIcon').removeClass('hidden');
        $submit_button.addClass('invalid');
      }
    }
  });
}

