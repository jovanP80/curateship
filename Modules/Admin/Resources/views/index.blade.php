@extends('admin::layouts.master')
@section('content')
<section>
  <div class="container max-width-lg margin-top-xl">
      <main class="flex items-center grid gap-sm z-index-1 col-15@md">
        @include('admin::widgets.users')
        @include('admin::widgets.visitors')
        @include('admin::widgets.posts')
        @include('admin::widgets.visitors')
        @include('admin::widgets.posts')
      </main>
  </div><!-- /.container -->
</section>
@endsection
@push('module-scripts')
<!-- MODULE'S CUSTOM SCRIPT -->
  @include('users::partials.script-js')
@endpush