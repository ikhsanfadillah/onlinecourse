@extends('layouts.app')

@section('content')

<div class="mentor">
   <img src="{{URL::asset('/img/decoration/header-decoration.png')}}" class="header-decoration">
   <div class="container">
       <div class="row">
           <div class="col-md-7">
               <label class="overline">Featured Mentor</label>
               <h1>Ivanka Sarapova</h1>
               <p class="body-2">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.</p>
               <a href="#" class="btn--large">Learn Now</a>
           </div>
       </div>
   </div>
</div>

@include('../partials/landing-page/video-preview')

@include('../partials/landing-page/video-collection')

@include('../partials/landing-page/request-mentor')

@include('../partials/landing-page/try-trial')

@endsection
