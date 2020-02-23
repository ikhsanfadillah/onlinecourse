@extends('layouts.app')

@section('content')

  <div class="wishlist container">
    <h1 class="text-center">Wishlist</h1>

    <div class="row justify-content-md-center">
      <div class="col-md-10">
        @forelse ($wishlists as $item)
          <div class="wishlist__card mb-5 flex-column flex-md-row">
            <div class="wishlist__card__img position-relative">
              <div class="d-flex position-absolute d-md-none" style="right: 0; top: 0;">
                <a class="btn btn-link text-danger btn-lg" href="{{ route('wishlists.remove',$item->id) }}"><i class="fas fa-heart-broken"></i></a>
              </div>
              <img src="{{$item->wishable->getFirstMediaUrl('primary-photo') ?: asset('/img/mentor-img/mentor-image-small.png')}}" alt="">
            </div>
            <div class="wishlist__card__text position-relative">
              <div class="d-none d-md-flex position-absolute" style="right: 0; top: 0;">
                <a class="btn btn-link text-danger btn-lg" href="{{ route('wishlists.remove',$item->id) }}"><i class="fas fa-heart-broken"></i></a>
              </div>
              <div class="wishlist__card__text__top">
                <h2 class="color__black_primary">{{$item->wishable->user->name}}</h2>
                <span class="color__black_secondary">{{$item->wishable->profesi}}</span>
                <p class="body-2 color__black_primary" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">{{$item->wishable->desc}}</p>
              </div>
              <div class="wishlist__card__text__bottom">
                <button class="btn btn--medium text-white" onclick="event.preventDefault(); addToCart('{{$item->wishable->mentor_id}}','{{\App\Wishlist::TYPE_MENTOR}}')" style="color: #FFAE04;">Masukan Ke Keranjang</button>
              </div>
            </div>
          </div>
          @empty
          <p class="body-2 text-center mb-5">Wishlist anda masih kosong <i class="fas fa-heart-broken"></i></p>
        @endforelse
      </div>
    </div>
  </div>

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
          console.log(res.type, res.message);
          $('#cartCounter').html()
          showToast(res.type, res.message);
        },
        error(){
          showToast('error','Oops, Terjadi kesalahan. Silahkan coba beberapa saat lagi')
        }
      });
    }
  </script>
@endsection
