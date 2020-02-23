@extends('layouts.app')

@section('content')

<div class="mentor">
   <img src="{{ asset('/img/decoration/header-decoration.png')}}" class="header-decoration">
   <div class="container">
       <div class="row">
           <div class="col-md-7">
               <label class="overline">Featured Mentor</label>
               <h1>{{ $mentors[0]->user->name }}</h1>
               <p class="body-2">{{ $mentors[0]->desc }}</p>
               <a href="{{ url("/mentors/".$mentors[0]->user->username) }}" class="btn--large">Learn Now</a>
           </div>
       </div>
   </div>
</div>

@include('../partials/landing-page/video-preview')

@include('../partials/landing-page/video-collection',['mentors' => $mentors])

<div class="video-preview">
   <div class="container">
       <div class="row">
            <div class="col-md-6">
               <img class="mentor-request__img__main" src="{{ asset('/img/decoration/mentor-req-img.png')}}">
            </div>
            <div class="col-md-6 d-flex flex-column align-self-center">
               <h1>Tidak Menemukan Mentor Favoritmu?</h1>
               <p class="body-2">
                   At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.
               </p>
           </div>
       </div>
   </div>
</div>

@include('../partials/landing-page/try-trial')

@endsection
@section('script')
<script>
    function addToCart(cartable_id, cartable_type) {
        $.ajax({
            url : "{{ route('carts.store') }}",
            type : "POST",
            data : {
                _token: "{{ csrf_token() }}",
                cartable_id,
                cartable_type
            },
            success(res){
                $('#cartCounter').html();
                showToast(res.type, res.message);
            },
            error(){
                showToast('error','Oops, Terjadi kesalahan. Silahkan coba beberapa saat lagi')
            }
        });
    }
</script>
@endsection
