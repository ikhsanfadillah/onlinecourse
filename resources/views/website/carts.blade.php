@extends('layouts.app')

@section('content')

  <div class="cart container">
    <h1>Keranjang</h1>
    @if(count($cart['items']) > 0)
      <p class="body-2 mb-4">Daftar semua kelas yang ingin Anda beli. Beli kelas Anda sekarang</p>
      <span class="cart__counter color__orange_primary">2 kelas di keranjang</span>
      <div class="row">
        <div class="col-md-8 cart__items">
          @foreach ($cart['items'] as $item)
            <div class="cart__items__item mb-4" id="cart{{$item->id}}">
              <div class="cart__items__item__img">
                <img src="{{asset('/img/mentor-img/mentor-image-small.png')}}" alt="">
              </div>
              <div class="cart__items__item__details">
                <div class="cart__items__item__details__top">
                  <h2>{{ $item->name }}</h2>
                </div>
                <div class="cart__items__item__details__btm">
                  <div class="cart__items__item__details__btm__left flex-row">
                    <button class="btn btn-link btnRemoveItem" data-id="{{$item->id}}" style="color: #FFAE04;"><i class="fas fa-trash"></i></button>
                  </div>
                  <div class="cart__items__item__details__btm__right">
                    <div class="cart__items__item__details__price">{{ \App\Helper::IDR($item->price) }}</div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="col-md-4">
          <div class="cart__total">
            <div class="cart__total__title color__black-primary">Ringkasan belanja</div>
            <div class="cart__total__divider"></div>
            <div class="cart__total__price mb-2">
              <div class="cart__total__price__left color__black-secondary">Total Harga</div>
              <div class="cart__total__price__right color__black-primary" id="txtTotal">{{ \App\Helper::IDR($cart['total']) }}</div>
            </div>
            <form action="{{ route('cart.checkout') }}" method="POST">
              @csrf
              <button class="btn--large btn-block">Check Out</button>
            </form>
            <a class="btn--large" href="{{ url('/mentors') }}">Kembali Belanja</a>
          </div>
        </div>
      </div>
    @else
      <p class="body-2 mb-4">Tidak ada kelas dialam keranjang</p>
    @endif
  </div>

@endsection

@section('script')
  <script>
    var _destroyUrl = '{{route('carts.destroy',"__ID__")}}';
      $(document).ready(function () {
        $('.btnRemoveItem').click(function () {
          console.log('asd');
          var jThis = $(this);
          var _id = jThis.data('id');
          var _url = _destroyUrl.replace('__ID__',_id)
          $.ajax({
            url : _url,
            type : 'POST',
            data : {
              _token: "{{ csrf_token() }}",
              _method: "DELETE"
            },
            success(res){
              showToast(res.type, res.message);
              $('#txtTotal').html(res.data.total);
              $('#cart'+_id).remove();
            }
          })
        })
      })
  </script>
@endsection