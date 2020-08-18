<!-- 👇 Full Screen Modal -->
<div class="custom-modal modal modal--animate-translate-down flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal custom-modal-hide-body-scroll" id="modal-add-user">
  <div class="modal__content height-100% tabs js-tabs width-100% max-width-xs bg radius-md shadow-md flex flex-column" role="alertdialog" aria-labelledby="modal-add-user-title" aria-describedby="modal-description-4">
    <form action="{{ url('admin/users/store') }}" id="modal-form-add-user" class="modal-form flex flex-column height-100%" method="post"> @csrf
      <header class="bg-contrast-lower padding-y-sm padding-x-md flex items-center justify-between">
        <!-- 👇 Tabs -->
        <nav class="">
          <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
            <li><a href="#tab1Panel1" class="tabs__control" aria-selected="true">User</a></li>
            <li><a href="#tab1Panel2" class="tabs__control">Images</a></li>
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

      <div class="padding-y-sm padding-x-md flex-grow overflow-auto">
        <div class="js-tabs__panels">
          <section id="tab1Panel1" class="padding-top-md js-tabs__panel">
            <div class="text-component">
              <h1 class="text-lg">New user</h1>
              <div id="ajax-add-user-form">Loading...</div><!-- /#ajax-add-user-form -->
            </div>
          </section>

          <section id="tab1Panel2" class="padding-top-md js-tabs__panel">
            <div class="text-component">
              <h1 class="text-lg">Panel 2</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
            </div>
          </section>

        </div>
        <!-- 👇 End Tab Panels -->
      </div><!-- /.padding-y-sm padding-x-md flex-grow overflow-auto -->

      <footer class="padding-y-sm padding-x-md bg shadow-md flex-shrink-0">
        <div class="flex justify-end gap-xs">
          <button type="button" class="btn btn--subtle js-modal__close">Cancel</button>
          <button type="submit" class="btn btn--primary">Save</button>
        </div>
      </footer>
    </form>
  </div><!-- /.modal__content -->

</div><!-- /.modal -->
<!-- Full Screen Modal End -->

<!-- 👇 Full Screen Modal -->
<div class="custom-modal modal modal--animate-translate-down flex flex-center bg-contrast-higher bg-opacity-90% padding-md js-modal custom-modal-hide-body-scroll" id="modal-edit-user">
  <div class="modal__content height-100% tabs js-tabs width-100% max-width-xs bg radius-md shadow-md flex flex-column" role="alertdialog" aria-labelledby="modal-edit-user-title" aria-describedby="modal-description-4">
    <form action="#" method="POST" id="modal-edit-user-form" class="modal-form  flex flex-column height-100%"> @csrf
      <header class="bg-contrast-lower padding-y-sm padding-x-md flex items-center justify-between">
        <!-- 👇 Tabs -->
        <nav class="">
          <ul class="flex flex-wrap gap-sm js-tabs__controls" aria-label="Tabs Interface">
            <li><a href="#tab2Panel1" class="tabs__control" aria-selected="true">User</a></li>
            <li><a href="#tab2Panel2" class="tabs__control">Images</a></li>
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

      <div class="padding-y-sm padding-x-md flex-grow overflow-auto">
        <div class="js-tabs__panels">
          <section id="tab2Panel1" class="padding-top-md js-tabs__panel">
            <div class="text-component">
              <h1 class="text-lg">Edit user</h1>
              <div id="ajax-edit-user-form">Loading...</div><!-- /#ajax-edit-user-form -->
            </div>
          </section>

          <section id="tab2Panel2" class="padding-top-md js-tabs__panel">
            <div class="text-component">
              <h1 class="text-lg">Edit Images</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, nobis! Vitae quis minus accusantium qui atque? Officiis sunt exercitationem natus, minus sapiente debitis eum animi porro. Ut cupiditate amet expedita!</p>
            </div>
          </section>

        </div>
        <!-- 👇 End Tab Panels -->
      </div><!-- /.padding-y-sm padding-x-md flex-grow overflow-auto -->

      <footer class="padding-y-sm padding-x-md bg shadow-md flex-shrink-0">
        <div class="flex justify-end gap-xs">
          <button type="button" class="btn btn--subtle js-modal__close">Cancel</button>
          <button type="submit" class="btn btn--primary">Save</button>
        </div>
      </footer>
    </form>
  </div><!-- /.modal__content -->
</div><!-- /.modal -->
<!-- Full Screen Modal End -->

<!-- Search users modal -->
<div class="modal modal--search modal--animate-fade flex flex-center padding-md js-modal" id="modal-search">
  <div class="modal__content width-100% max-width-sm" role="alertdialog" aria-labelledby="modal-search-title" aria-describedby="">
    <form class="full-screen-search">
      <label for="search-input-x" id="modal-search-title" class="sr-only">Search</label>
      <input class="reset full-screen-search__input" type="search" name="search-input-x" id="search-input-x" placeholder="Search...">
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
</div>