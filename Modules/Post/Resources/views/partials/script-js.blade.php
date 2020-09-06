@auth

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@editorjs/raw@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@editorjs/image@latest"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>

<script>
  (function() {

    $("input[name=title]").keyup(function() {
      var slug, post_title;
      post_title = $(this).val();
      slug = post_title.replace(' ','-');
      $("input[name=seo]").val(slug);
    });

    // trigger to submit modal form
    $(".modal-form").on('submit', function(){

      
      var $this = $(this);

      var url = $this.attr('action');
      var method = $this.attr('method');
      var dataType = 'JSON';
      var data = $this.serialize();

      // var savetype = $("input[type=submit][clicked=true]").data('savetype');
      var savetype = $(document.activeElement).data('savetype');
      
      var currentURL = $('meta[name="current-url"]').attr('content');

      $this.find('.form-error-msg').removeClass('form-error-msg--is-visible').html('');

      
      $.ajax({
        url: url,
        method: method,
        dataType: dataType,
        data: data,
        success : function(response) {
          // console.log('Response', response);

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
          // console.log(response);

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
  })();
</script>

<script>
  (function(){
    var editor = new EditorJS({
      /**
      * Id of Element that should contain Editor instance
      */
      holder: 'editorjs',
      tools: {
        // header: Header,
        raw: RawTool,
        image: SimpleImage,
        embed: Embed,
        quote: Quote,
        checklist: {
          class: Checklist,
          inlineToolbar: true,
        },
        /*list: {
          class: List,
          inlineToolbar: true,
        }*/
      }
    });

    editor.save().then((outputData) => {
      console.log('Article data: ', outputData)
    }).catch((error) => {
      console.log('Saving failed: ', error)
    });
  })();
</script>

<script>
  (function(){

    // load content when user clicked on sidebar links
    $(document).on('click', '.site-load-content a', function (e) {
      e.preventDefault();
      var $this = $(this);
      var url = $this.attr('href');

      $('meta[name="current-url"]').attr('content', url);
      console.log(url);

      // loads page content inside this element
      $('#site-table-with-pagination-container').load(url);
    });

    console.log('loaded ???');
  })();
</script>


@endauth