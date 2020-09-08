<div class="container-justified-gal">
    <div class="flexbin flexbin-margin">
      @foreach($posts as $post)
        @php
          $getMedia = \Modules\Post\Entities\Post::find($post->id)->getFirstMedia('post');
        @endphp

        @if(!empty($getMedia) && $getMedia->hasGeneratedConversion('medium'))
          <a href="#">
            <img src="{{ $getMedia->getFullURL('medium') }}" class="card-v2"/>
          </a>
        @endif
      @endforeach

      <!-- Commented for reference -->
      {{-- <a href="http://127.0.0.1:8000/site1/post">
        <img src="../../assets/img/team-img-1.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-2.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-3.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-4.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-5.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-6.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-7.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-8.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-9.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-10.jpg" class="card-v2"/>
      </a>
      <a href="#">
        <img src="../../assets/img/team-img-11.jpg" class="card-v2"/>
      </a> --}}
    </div>
  </div>
  <footer class="footer-v4 padding-y-lg">