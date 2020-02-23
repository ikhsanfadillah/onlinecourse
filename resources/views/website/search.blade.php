@extends('layouts.app')

@section('content')
    <div class="search container d-flex flex-row flex-wrap">
      @for ($i = 0; $i < 9; $i++)
          <div class="card col-sm-6 col-md-4 col-lg-4 mb-3">
            <img src="https://via.placeholder.com/100" alt="Image" class="card-img-top">
            <div class="card-body">
              <a href="#"><h5 class="card-title m-0">Course Name</h5></a>
              <a href="#"><small>Mentor Name</small></a>
              <p class="card-text text-truncate">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab sit culpa porro blanditiis fuga, eius dolore tempore laudantium fugiat vitae fugit, quaerat mollitia optio eos suscipit, corrupti modi id tenetur.</p>
            </div>
          </div>
      @endfor
    </div>
@endsection