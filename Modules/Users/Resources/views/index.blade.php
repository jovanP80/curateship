@extends('admin::layouts.master')

@section('content')
  <section>
    <div class="container max-width-lg">
      <div class="grid">
        @include('admin::partials.sidebar')
        <main class="position-relative z-index-1 col-12@md">
          @include('users::partials.index')
        </main>
      </div><!-- /.grid -->

  </section>
@endsection

@push('module-scripts')
<!-- MODULE'S CUSTOM SCRIPT -->
  @include('users::partials.script-js')
  @include('custom-scripts.custom-script')
@endpush
