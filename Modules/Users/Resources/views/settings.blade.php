@extends('site1.layouts.app')

@section('content')
  <section class="padding-y-md">
    <div class="container max-width-lg">
      <div class="grid gap-md@md">
        <div class="col-7@md offset-4@md">
          <h1 class="margin-bottom-sm">Account Info</h1>
          @if($alert = session()->get('alert'))
            <div class="alert alert--is-visible js-alert margin-bottom-lg {{ $alert['class'] }}" role="alert">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <svg aria-hidden="true" class="icon margin-right-xxxs" viewBox="0 0 32 32" ><title>info icon</title><g><path d="M16,0C7.178,0,0,7.178,0,16s7.178,16,16,16s16-7.178,16-16S24.822,0,16,0z M18,7c1.105,0,2,0.895,2,2 s-0.895,2-2,2s-2-0.895-2-2S16.895,7,18,7z M19.763,24.046C17.944,24.762,17.413,25,16.245,25c-0.954,0-1.696-0.233-2.225-0.698 c-1.045-0.92-0.869-2.248-0.542-3.608l0.984-3.483c0.19-0.717,0.575-2.182,0.036-2.696c-0.539-0.514-1.794-0.189-2.524,0.083 l0.263-1.073c1.054-0.429,2.386-0.954,3.523-0.954c1.71,0,2.961,0.855,2.961,2.469c0,0.151-0.018,0.417-0.053,0.799 c-0.066,0.701-0.086,0.655-1.178,4.521c-0.122,0.425-0.311,1.328-0.311,1.765c0,1.683,1.957,1.267,2.847,0.847L19.763,24.046z"></path></g></svg>
                  <div>
                    {!! $alert['message'] !!}
                  </div>
                </div>

                <button class="reset alert__close-btn js-alert__close-btn">
                  <svg class="icon" viewBox="0 0 24 24"><title>Close alert</title><g stroke-linecap="square" stroke-linejoin="miter" stroke-width="3" stroke="currentColor" fill="none" stroke-miterlimit="10"><line x1="19" y1="5" x2="5" y2="19"></line><line fill="none" x1="19" y1="19" x2="5" y2="5"></line></g></svg>
                </button>
              </div>
            </div><!-- /.alert -->
          @endif
          <form action="{{ url('users/settings/save') }}" method="post" enctype="multipart/form-data">@csrf
            <input type="hidden" name="delete_avatar" />
            <div class="author margin-bottom-md">
              <a href="#0" class="author__img-wrapper bg-primary-dark">
                @if(Auth::user()->getMedia('avatars')->last())
                  <img src="{{ Auth::user()->getMedia('avatars')->last()->getFullUrl() }}" alt="Author picture" id="settings-avatar">
                @else
                  <img alt="Author picture" id="settings-avatar" style="display: none;">
                @endif
              </a>
              <div class="author__content text-component padding-top-sm padding-left-xs">
                <div class="flex flex-wrap gap-sm">
                  <div class="file-upload inline-block">
                    <label for="avatar" class="file-upload__label btn btn--subtle">
                      <span class="file-upload__text file-upload__text--has-max-width" data-default-text="Upload a file">Upload a file</span>
                    </label>

                    <input type="file" class="file-upload__input" data-custom-image-file-preview="#settings-avatar" data-custom-image-file-resetter="#settings-avatar-delete" name="avatar" id="avatar" accept="image/*">
                  </div><!-- /.file-upload inline-block -->
                  <button type="button"
                    id="settings-avatar-delete"
                    data-custom-image-file-reset-file="#avatar"
                    @if(Auth::user()->getMedia('avatars')->last())
                      class="btn btn--subtle"
                    @else
                      class="btn btn--subtle btn--disabled"
                      disabled
                    @endif
                  >Delete</button><!-- /.btn btn--subtle -->
                </div><!-- /.flex flex-wrap -->
              </div><!-- /.author__content -->
            </div><!-- /.author -->
            <div class="margin-bottom-sm">
              <div class="grid gap-sm">
                <div class="col@md">
                  <label for="name" class="form-label">Name</label><!-- /.form-label -->
                  <input type="text" class="form-control width-100%" id="name" name="name" value="{{ $user->name }}">
                </div><!-- /.col@md -->
                <div class="col@md">
                  <label for="email" class="form-label">Email</label><!-- /.form-label -->
                  <input type="email" class="form-control width-100%" id="email" name="email" value="{{ $user->email }}">
                </div><!-- /.col@md -->
              </div><!-- /.grid gap-sm -->
            </div><!-- /.margin-bottom-sm -->
            <div class="margin-bottom-sm">
              <label for="password" class="form-label">Password</label><!-- /.form-label -->
              <div class="password js-password ">
                <input class="password__input form-control width-100% js-password__input" type="password" name="password" id="password">

                <button class="password__btn flex flex-center js-password__btn js-tab-focus">
                  <span class="password__btn-label" aria-label="Show password" title="Show password">
                    <svg class="icon block" viewBox="0 0 32 32"><g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none"><path d="M1.409,17.182a1.936,1.936,0,0,1-.008-2.37C3.422,12.162,8.886,6,16,6c7.02,0,12.536,6.158,14.585,8.81a1.937,1.937,0,0,1,0,2.38C28.536,19.842,23.02,26,16,26S3.453,19.828,1.409,17.182Z" stroke-miterlimit="10"></path><circle cx="16" cy="16" r="6" stroke-miterlimit="10"></circle></g></svg>
                  </span>
                  <span class="password__btn-label" aria-label="Hide password" title="Hide password">
                    <svg class="icon block" viewBox="0 0 32 32"><g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none"><path data-cap="butt" d="M8.373,23.627a27.659,27.659,0,0,1-6.958-6.445,1.938,1.938,0,0,1-.008-2.37C3.428,12.162,8.892,6,16.006,6a14.545,14.545,0,0,1,7.626,2.368" stroke-miterlimit="10" stroke-linecap="butt"></path><path d="M27,10.923a30.256,30.256,0,0,1,3.591,3.887,1.937,1.937,0,0,1,0,2.38C28.542,19.842,23.026,26,16.006,26A12.843,12.843,0,0,1,12,25.341" stroke-miterlimit="10"></path><path data-cap="butt" d="M11.764,20.243a6,6,0,0,1,8.482-8.489" stroke-miterlimit="10" stroke-linecap="butt"></path><path d="M21.923,15a6.005,6.005,0,0,1-5.917,7A6.061,6.061,0,0,1,15,21.916" stroke-miterlimit="10"></path><line x1="2" y1="30" x2="30" y2="2" fill="none" stroke-miterlimit="10"></line></g></svg>
                  </span>
                </button>
              </div>
            </div><!-- /.margin-bottom-sm -->
            <h1 class="margin-bottom-sm">Personal Info</h1>
            <div class="margin-bottom-sm">
              <label for="bio" class="form-label">Bio</label><!-- /.form-label -->
                  {{-- <input type="text" class="form-control width-100%" id="bio" name="bio" value=""> --}}
                  <textarea class="form-control width-100%" id="bio" name="bio" rows="5"></textarea>
            </div>
            <div class="margin-bottom-sm">
              <label for="facebook_link" class="form-label">Facebook Link</label><!-- /.form-label -->
                  <input type="text" class="form-control width-100%" id="facebook_link" placeholder="https://facebook.com/userSample" name="facebook_link" value="">
            </div>
            <div class="margin-bottom-sm">
              <label for="instagram_link" class="form-label">Instagra Link</label><!-- /.form-label -->
                  <input type="text" class="form-control width-100%" id="instagram_link" placeholder="https://instagram.com/userSample" name="instagram_link" value="">
            </div>
            <div class="margin-bottom-sm">
              <label for="twitter_link" class="form-label">Twitter Link</label><!-- /.form-label -->
                  <input type="text" class="form-control width-100%" id="twitter_link" placeholder="https://twitter.com/userSample" name="twitter_link" value="">
            </div>
            <div class="margin-bottom-sm text-right">
              <button type="submit" class="btn btn--primary">Save</button><!-- /.btn btn--primary -->
            </div><!-- /.margin-bottom-sm -->
          </form>
        </div><!-- /.col-1 -->
      </div><!-- /.grid gap-md@md -->
    </div><!-- /.container max-width-lg -->
  </section><!-- /.padding-y-md -->
@endsection

@push('module-scripts')
<!-- MODULE'S CUSTOM SCRIPT -->
  @include('users::partials.script-js')
@endpush