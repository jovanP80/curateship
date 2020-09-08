@auth
<script>
  (function(){
    // trigger to show edit user modal form
    $(document).on('click', '.modal-trigger-edit-user', function(e){
      e.preventDefault();

      var $this = $(this);
      var url = $this.attr('href');
      var updateURL = $this.data('update-url');

      $('#modal-edit-user-form').attr('action', updateURL);
      var $element = $('#ajax-edit-user-form');
      $element.load( url, function(response, status, xhr) {
      });
    });

    // trigger to show add user modal form
    $(document).on('click', '.modal-trigger-add-user', function(e){
      e.preventDefault();

      var $this = $(this);
      var url = $this.data('href');

      // console.log(url);

      var $element = $('#ajax-add-user-form');
      $element.load( url, function(response, status, xhr) {
      });
    });

    // trigger to submit modal form
    $('.modal-form').on('submit', function(){
      var $this = $(this);

      var url = $this.attr('action');
      var method = $this.attr('method');
      var dataType = 'JSON';
      var data = $this.serialize();

      var currentURL = $('meta[name="current-url"]').attr('content');

      $this.find('.form-error-msg').removeClass('form-error-msg--is-visible').html('');

      $.ajax({
        url: url,
        method: method,
        dataType: dataType,
        data: data,
        success : function(response) {
          if (response.status == 'success') {
            // remove error messages
            $this.find('.form-error-msg').removeClass('form-error-msg--is-visible').html('');
            $this.find('.alert').addClass('alert--is-visible').find('.alert-message').html(response.message);
            $('#site-table-with-pagination-container').load(currentURL);
          }

          if (response.clear) {
            $this.get(0).reset();
          }
        },
        error: function(response, textStatus) {
          var jsonResponse = response.responseJSON;
          var errors = jsonResponse.errors;

          $.each( errors, function( key, value ) {
            $this.find('[name="'+key+'"]' + ' + .form-error-msg').addClass('form-error-msg--is-visible').html(value[0]);
          });
        },
        always: function(response){
          // console.log(response);
        },
      });

      return false;
    });

    $('[data-custom-image-file-preview]').on('change', function() {
      readURL(this);
    });

    $('[data-custom-image-file-reset-file]').on('click', function() {
      var $this = $(this);
      var targetFile = $this.data('custom-image-file-reset-file');
      var $targetFileLabel = $(targetFile).prev('.file-upload__label').find('.file-upload__text');
      var targetImage = $(targetFile).data('custom-image-file-preview');

      $targetFileLabel.text($targetFileLabel.data('default-text'));

      $(targetImage).hide();

      $this.prop('disabled', true).addClass('btn--disabled');

      $this.closest('form').find('[name="delete_avatar"]').val(true);

    });

    function readURL(input) {
      var $this = $(input);
      var target = $this.data('custom-image-file-preview');
      var resetter = $this.data('custom-image-file-resetter');
      console.log(target);

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $(target).attr('src', e.target.result).show();
          $(resetter).prop('disabled', false).removeClass('btn--disabled');
          $this.closest('form').find('[name="delete_avatar"]').val('');
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }
  })();
</script>
@endauth