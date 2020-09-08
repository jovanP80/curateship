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
  var editor, editor2;
  (function(){
    editor = new EditorJS({
      /**
      * Id of Element that should contain Editor instance
      */
      holder: 'editorjs',
      tools: {
        header: Header,
        raw: RawTool,
        image: SimpleImage,
        embed: Embed,
        quote: Quote,
        checklist: {
          class: Checklist,
          inlineToolbar: true,
        },
        list: {
          class: List,
          inlineToolbar: true,
        }
      }
    });

    editor2 = new EditorJS({
      /**
      * Id of Element that should contain Editor instance
      */
      holder: 'editorjs-edit',
      tools: {
        header: Header,
        raw: RawTool,
        image: SimpleImage,
        embed: Embed,
        quote: Quote,
        checklist: {
          class: Checklist,
          inlineToolbar: true,
        },
        list: {
          class: List,
          inlineToolbar: true,
        }
      }
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

<script>
  var inlineBody;
  (function() {

    $("input[name=title]").keyup(function() {
      var slug, post_title;
      post_title = $(this).val();
      slug = post_title.replace(' ','-');
      $("input[name=seo]").val(slug);
    });

    $(document).on('click', '.modal-trigger-edit-post', function(e){
      // e.preventDefault();

      var $this = $(this);
      var url = $this.attr('href');
      var updateURL = $this.data('update-url');

      $('#modal-edit-user-form').attr('action', updateURL);

      $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
          var response = response.post;

          console.log(response);
          $("#modal-form-edit-post input[name=title]").val(response.title);
          $("#modal-form-edit-post input[name=seo]").val(response.slug);

          const newBlock = {
            data: {
                text: "sdsdadsd"
            }
          };
          // editor2.blocks.insert(newBlock);
          editor2.blocks.insert('paragraph',newBlock);
        }
      });
      /*var $element = $('#modal-form-edit-post');
      $element.load( url, function(response, status, xhr) {
        
      });*/
    });

    // trigger to submit modal form
    $(".modal-form").on('submit', function(){
      editor.save()
        .then((savedData) => {
          var body;
          body = [];

          for(var i in savedData) {
            if(i == 'blocks') {
              for(var c in savedData[i]) {
                body.push(savedData[i][c].data.text);
              }
            }
          }

          inlineBody = JSON.stringify(body);

          var $this = $(this);

          var url = $this.attr('action');
          var method = $this.attr('method');
          var dataType = 'JSON';
          var data = $this.serialize();
          var savetype = $(document.activeElement).data('savetype');

          var currentURL = $('meta[name="current-url"]').attr('content');

          $this.find('.form-error-msg').removeClass('form-error-msg--is-visible').html('');

          data = data + "&body=" + inlineBody + "&savetype=" + savetype;

          var form = $("#modal-form-add-post")[0];
          var datum = new FormData(form);
          datum.append('body',inlineBody);
          datum.append('savetype',savetype);
          console.log(datum);
          
          $.ajax({
            url: url,
            method: method,
            dataType: dataType,
            data: datum,
            processData: false,
            contentType: false,
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
      });

      return false;  
    });
  })();
</script>

@endauth