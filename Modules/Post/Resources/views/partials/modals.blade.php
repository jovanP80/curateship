<!-- 👇 Full Screen Modal -->
<div class="custom-modal modal modal--animate-translate-down flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal custom-modal-hide-body-scroll" id="modal-add-article">
  <div class="modal__content height-100% tabs js-tabs width-100% max-width-sm bg radius-md shadow-md flex flex-column">
    <form action="{{ url('admin/posts/store') }}" id="modal-form-add-post" class="modal-form flex flex-column height-100%" method="POST" enctype="multipart/form-data">
      @csrf
      <header class="bg-contrast-lower padding-y-sm padding-x-md flex items-center justify-between">
        <!-- 👇 Tabs -->
        <nav class="tabs">
          <ul class="flex flex-wrap gap-xl js-tabs__controls" aria-label="Tabs Interface">
            <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Add</a></li>
            <li><a href="#tab1Panel2" class="tabs__control">Images</a></li>
            <li><a href="#tab1Panel3" class="tabs__control">Settings</a></li>
          </ul>
        </nav>
        <!-- End Tabs -->

        <button class="reset modal__close-btn modal__close-btn--inner js-modal__close js-tab-focus">
          <svg class="icon" viewBox="0 0 20 20">
            <title>Close modal window</title>
            <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2">
              <line x1="3" y1="3" x2="17" y2="17" />
              <line x1="17" y1="3" x2="3" y2="17" />
            </g>
          </svg>
        </button>
      </header>

      <!--Tab1 Content-->
      <div class="padding-y-sm padding-x-md flex-grow overflow-auto">
        <div class="js-tabs__panels">
          <section id="tab1Panel1" class="padding-top-md js-tabs__panel">
            <div>

              <div class="grid gap-sm">
                <label class="form-label margin-bottom-xxs" for="input-name">Enter Your Title</label>
                <input class="form-control width-100%" type="text" name="title" id="title">
                <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
              <div>

              <div id="editorjs" class="form-control"></div><!-- /#ajax-add-blog-form -->
              <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
            </div>
          </section>

        <!--Tab2 Content-->
          <section id="tab1Panel2" class="padding-top-md js-tabs__panel">
            <div class="ddf">
              <div class="ddf__area padding-y-xl padding-x-md js-ddf__area">
                <input class="ddf__input sr-only js-ddf__input" type="file" id="upload-file" multiple name="file[]">

                <label class="ddf__label js-ddf__label" for="upload-file">
                  <i class="ddf__label-inner">
                    <svg class="icon icon--xl color-contrast-higher ddf__icon-cloud" viewBox="0 0 64 64" aria-hidden="true"><path fill="currentColor" d="M51,27c-.374,0-.742.025-1.109.056a18,18,0,0,0-35.782,0C13.742,27.025,13.374,27,13,27a13,13,0,0,0,0,26H51a13,13,0,0,0,0-26Z"/><path d="M43.764,41.354l-11-13a1.033,1.033,0,0,0-1.526,0l-11,13A1,1,0,0,0,21,43h7V59h8V43h7a1,1,0,0,0,.764-1.646Z" fill="var(--color-bg)"/></svg>

                    <span class="text-md text-bold color-contrast-higher">Drag and drop your files here</span>

                    <span class="color-contrast-medium padding-top-xxxs inline-block">or click to browse your files</span>
                  </i>
                </label>

                <span class="ddf__label-end">
                  <i class="ddf__label-end-inner">
                    <svg class="icon icon--xl color-contrast-higher ddf__icon-file" viewBox="0 0 64 64" aria-hidden="true"><path fill="currentColor" d="M1.4,16.868,7,15.636,18.972,13A1.783,1.783,0,0,1,21.1,14.359L28.21,46.683a1.783,1.783,0,0,1-1.358,2.124L9.28,52.675a1.784,1.784,0,0,1-2.124-1.358L.042,18.993A1.783,1.783,0,0,1,1.4,16.868Z" opacity="0.69"/><path fill="currentColor" d="M62.6,16.868,57,15.636,45.028,13A1.783,1.783,0,0,0,42.9,14.359L35.79,46.683a1.783,1.783,0,0,0,1.358,2.124L54.72,52.675a1.784,1.784,0,0,0,2.124-1.358l7.114-32.324A1.783,1.783,0,0,0,62.6,16.868Z" opacity="0.69"/><rect fill="currentColor" x="13" y="9" width="38" height="46" rx="2"/><path d="M42.941,41.664l-5-14a1,1,0,0,0-1.624-.4l-15,14A1,1,0,0,0,22,43H42a1,1,0,0,0,.941-1.336Z" fill="#fff"/><circle cx="24" cy="26" r="3" fill="var(--color-bg)"/></svg>

                    <!-- {n} will be replaced by the total number of files -->
                    <!-- use % symbol for singular/plural - only one will be shown  -->
                    <span class="js-ddf__files-counter">{n} selected %file%files%</span>

                    <div class="ddf__progress c-progress-bar is-hidden margin-x-auto margin-top-xxs js-ddf__progress" data-progress="0%">
                      <p class="sr-only" aria-live="polite" aria-atomic="true">Progress value is <span class="js-c-progress-bar__aria-value">0%</span></p>

                      <div class="c-progress-bar__shape" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round">
                          <g> <!-- check + circle bg -->
                            <circle class="ddf__progress-circle" cx="12" cy="12" r="11" stroke-width="2"></circle>
                            <circle class="ddf__progress-circle-mask" cx="12" cy="12" r="11" stroke-width="2"></circle>
                            <polyline class="ddf__progress-check" points="6 12 10 16 18 8" fill="none" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                          </g>

                          <g> <!-- progress loader -->
                            <circle class="c-progress-bar__bg" cx="12" cy="12" r="11" stroke-width="2"></circle>
                            <circle class="c-progress-bar__fill" cx="12" cy="12" r="11" stroke-width="2"></circle>
                          </g>
                        </svg>
                      </div>
                    </div>
                  </i>
                </span>
              </div>
            </div>
          </section>

          <!--Tab3 Content-->
          <section id="tab1Panel3" class="padding-top-md js-tabs__panel">
            <fieldset class="margin-bottom-md">
              <legend class="form-legend">Form Legend</legend>

              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">SEO Page Title</label>
                  <input class="form-control width-100%" type="text" name="seo" id="seo">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">Small Image Width</label>
                  <input class="form-control width-100%" type="text" name="small_width" id="small_width">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">Small Image Height</label>
                  <input class="form-control width-100%" type="text" name="small_height" id="small_height">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">Medium Image Width</label>
                  <input class="form-control width-100%" type="text" name="medium_width" id="medium_width">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">Medium Image Height</label>
                  <input class="form-control width-100%" type="text" name="medium_height" id="medium_height">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">Large Image Width</label>
                  <input class="form-control width-100%" type="text" name="large_width" id="large_width">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">Large Image Width</label>
                  <input class="form-control width-100%" type="text" name="large_height" id="large_height">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
            </fieldset>
          </section>
        </div>

        <!-- 👇 End Tab Panels -->
      </div><!-- /.padding-y-sm padding-x-md flex-grow overflow-auto -->

      <footer class="padding-y-sm padding-x-md bg shadow-md flex-shrink-0">
        <div class="flex justify-end gap-xs">
          <button type="button" class="btn btn--subtle js-modal__close">Cancel</button>
          <button type="submit" class="btn btn--primary" data-savetype="save">Save</button>
          <button type="submit" class="btn btn--primary" data-savetype="publish">Publish</button>
        </div>
      </footer>
    </form>
  </div><!-- /.modal__content -->

</div><!-- /.modal -->
<!-- Full Screen Modal End -->

<!-- 👇 Full Screen Modal -->
<div class="custom-modal modal modal--animate-translate-down flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal custom-modal-hide-body-scroll" id="modal-edit-article">
  <div class="modal__content height-100% tabs js-tabs width-100% max-width-sm bg radius-md shadow-md flex flex-column" aria-labelledby="modal-edit-post-title">
    <form action="#" id="modal-form-edit-post" class="modal-form flex flex-column height-100%" method="POST" enctype="multipart/form-data">
      @csrf
      <header class="bg-contrast-lower padding-y-sm padding-x-md flex items-center justify-between">
        <!-- 👇 Tabs -->
        <nav class="tabs">
          <ul class="flex flex-wrap gap-xl js-tabs__controls" aria-label="Tabs Interface">
            <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">Add</a></li>
            <li><a href="#tab1Panel2" class="tabs__control">Images</a></li>
            <li><a href="#tab1Panel3" class="tabs__control">Settings</a></li>
          </ul>
        </nav>
        <!-- End Tabs -->

        <button class="reset modal__close-btn modal__close-btn--inner js-modal__close js-tab-focus">
          <svg class="icon" viewBox="0 0 20 20">
            <title>Close modal window</title>
            <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2">
              <line x1="3" y1="3" x2="17" y2="17" />
              <line x1="17" y1="3" x2="3" y2="17" />
            </g>
          </svg>
        </button>
      </header>

      <!--Tab1 Content-->
      <div class="padding-y-sm padding-x-md flex-grow overflow-auto">
        <div class="js-tabs__panels">
          <section id="tab1Panel1" class="padding-top-md js-tabs__panel">
            <div>

              <div class="grid gap-sm">
                <label class="form-label margin-bottom-xxs" for="input-name">Enter Your Title</label>
                <input class="form-control width-100%" type="text" name="title" id="title">
                <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
              <div>

              <div id="editorjs-edit" class="form-control"></div><!-- /#ajax-add-blog-form -->
              <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
            </div>
          </section>

        <!--Tab2 Content-->
          <section id="tab1Panel2" class="padding-top-md js-tabs__panel">
            <div class="ddf">
              <div class="ddf__area padding-y-xl padding-x-md js-ddf__area">
                <input class="ddf__input sr-only js-ddf__input" type="file" id="upload-file" multiple name="file[]">

                <label class="ddf__label js-ddf__label" for="upload-file">
                  <i class="ddf__label-inner">
                    <svg class="icon icon--xl color-contrast-higher ddf__icon-cloud" viewBox="0 0 64 64" aria-hidden="true"><path fill="currentColor" d="M51,27c-.374,0-.742.025-1.109.056a18,18,0,0,0-35.782,0C13.742,27.025,13.374,27,13,27a13,13,0,0,0,0,26H51a13,13,0,0,0,0-26Z"/><path d="M43.764,41.354l-11-13a1.033,1.033,0,0,0-1.526,0l-11,13A1,1,0,0,0,21,43h7V59h8V43h7a1,1,0,0,0,.764-1.646Z" fill="var(--color-bg)"/></svg>

                    <span class="text-md text-bold color-contrast-higher">Drag and drop your files here</span>

                    <span class="color-contrast-medium padding-top-xxxs inline-block">or click to browse your files</span>
                  </i>
                </label>

                <span class="ddf__label-end">
                  <i class="ddf__label-end-inner">
                    <svg class="icon icon--xl color-contrast-higher ddf__icon-file" viewBox="0 0 64 64" aria-hidden="true"><path fill="currentColor" d="M1.4,16.868,7,15.636,18.972,13A1.783,1.783,0,0,1,21.1,14.359L28.21,46.683a1.783,1.783,0,0,1-1.358,2.124L9.28,52.675a1.784,1.784,0,0,1-2.124-1.358L.042,18.993A1.783,1.783,0,0,1,1.4,16.868Z" opacity="0.69"/><path fill="currentColor" d="M62.6,16.868,57,15.636,45.028,13A1.783,1.783,0,0,0,42.9,14.359L35.79,46.683a1.783,1.783,0,0,0,1.358,2.124L54.72,52.675a1.784,1.784,0,0,0,2.124-1.358l7.114-32.324A1.783,1.783,0,0,0,62.6,16.868Z" opacity="0.69"/><rect fill="currentColor" x="13" y="9" width="38" height="46" rx="2"/><path d="M42.941,41.664l-5-14a1,1,0,0,0-1.624-.4l-15,14A1,1,0,0,0,22,43H42a1,1,0,0,0,.941-1.336Z" fill="#fff"/><circle cx="24" cy="26" r="3" fill="var(--color-bg)"/></svg>

                    <!-- {n} will be replaced by the total number of files -->
                    <!-- use % symbol for singular/plural - only one will be shown  -->
                    <span class="js-ddf__files-counter">{n} selected %file%files%</span>

                    <div class="ddf__progress c-progress-bar is-hidden margin-x-auto margin-top-xxs js-ddf__progress" data-progress="0%">
                      <p class="sr-only" aria-live="polite" aria-atomic="true">Progress value is <span class="js-c-progress-bar__aria-value">0%</span></p>

                      <div class="c-progress-bar__shape" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round">
                          <g> <!-- check + circle bg -->
                            <circle class="ddf__progress-circle" cx="12" cy="12" r="11" stroke-width="2"></circle>
                            <circle class="ddf__progress-circle-mask" cx="12" cy="12" r="11" stroke-width="2"></circle>
                            <polyline class="ddf__progress-check" points="6 12 10 16 18 8" fill="none" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                          </g>

                          <g> <!-- progress loader -->
                            <circle class="c-progress-bar__bg" cx="12" cy="12" r="11" stroke-width="2"></circle>
                            <circle class="c-progress-bar__fill" cx="12" cy="12" r="11" stroke-width="2"></circle>
                          </g>
                        </svg>
                      </div>
                    </div>
                  </i>
                </span>
              </div>
            </div>
          </section>

          <!--Tab3 Content-->
          <section id="tab1Panel3" class="padding-top-md js-tabs__panel">
            <fieldset class="margin-bottom-md">
              <legend class="form-legend">Form Legend</legend>

              <div class="grid gap-sm">
                  <label class="form-label margin-bottom-xxs" for="input-name">SEO Page Title</label>
                  <input class="form-control width-100%" type="text" name="seo" id="seo">
                  <div role="alert" class="form-error-msg"></div> <!-- /.form-error-msg--is-visible -->
                <div>

                </div>
              </div>
            </fieldset>
          </section>
        </div>

        <!-- 👇 End Tab Panels -->
      </div><!-- /.padding-y-sm padding-x-md flex-grow overflow-auto -->

      <footer class="padding-y-sm padding-x-md bg shadow-md flex-shrink-0">
        <div class="flex justify-end gap-xs">
          <button type="button" class="btn btn--subtle js-modal__close">Cancel</button>
          <button type="submit" class="btn btn--primary" data-savetype="save">Save</button>
          <button type="submit" class="btn btn--primary" data-savetype="publish">Publish</button>
        </div>
      </footer>
    </form>
  </div><!-- /.modal__content -->

</div><!-- /.modal -->
<!-- Full Screen Modal End -->

<div class="modal modal--search modal--animate-fade flex flex-center padding-md js-modal" id="modal-search">
  <div class="modal__content width-100% max-width-sm" role="alertdialog" aria-labelledby="modal-search-title" aria-describedby="">
    <form class="full-screen-search" action="{{ url('admin/posts') }}" method="GET">
      <label for="search-input-x" id="modal-search-title" class="sr-only">Search</label>
      <input class="reset full-screen-search__input" type="search" name="q" id="search-input-x" value="{{ $q ?? '' }}" placeholder="Search...">
      <button class="reset full-screen-search__btn">
        <svg class="icon" viewBox="0 0 24 24">
          <title>Search</title>
          <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none" stroke-miterlimit="10">
            <line x1="22" y1="22" x2="15.656" y2="15.656"></line>
            <circle cx="10" cy="10" r="8"></circle>
          </g>
        </svg>
      </button>
    </form>
  </div>

  <button class="reset modal__close-btn modal__close-btn--outer  js-modal__close js-tab-focus">
    <svg class="icon icon--sm" viewBox="0 0 24 24">
      <title>Close modal window</title>
      <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2">
        <line x1="3" y1="3" x2="21" y2="21" />
        <line x1="21" y1="3" x2="3" y2="21" />
      </g>
    </svg>
  </button>
</div><!-- /.modal -->