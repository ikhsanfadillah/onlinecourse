@extends('layouts.app')

@section('content')
    <div class="header">
        <img src="{{URL::asset('/img/decoration/header-decoration.png')}}" class="header-decoration">
        <div class="container">
            <div class="header__left">
                <h1>
                    Belajar Dari Ahlinya
                </h1>
                <p class="body-2">
                    At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.
                </p>
                <span class="body-3">
                    2 classes for Rp 500.000 (45% off)
                </span>
                <div class="header__signup">
                    <input type="email" class="header__input" placeholder="Email">
                    <input type="password" class="header__input" placeholder="Password">
                    <button class="btn--large">Daftar Sekarang</button>
                </div>
                <div class="header__terms">
                    <a href="" class="link--button">Syarat & Ketentuan</a>
                    <span>|</span>
                    <a href="" class="link--button">Kebijakan Privasi</a>
                </div>
            </div>
            <div class="header__scroll">
                <div class="header__scroll-icon">
                    <span>BROWSE CLASS</span>
                    <img src="{{URL::asset('/img/icon/scroll-mouse.png')}}">
                </div>
            </div>
        </div>
    </div>
    
    @include('../partials/landing-page/summary-desc',['mentors' => $data['mentorCount'],'lessons' => $data['lessonCount'], 'minutes' => 15])
    
    @include('../partials/landing-page/video-preview')

    @include('../partials/landing-page/video-collection',['mentors' => $data['mentors']])

    <div class="row justify-content-md-center">
        <a href="{{ url('/mentors') }}" class="btn--medium">Lihat Semua Mentor</a>
    </div>
    <div class="testimonial mt-5 mb-5 pb-5">
        <h1 class="mb-4 text-center pt-5">What They Feel & Learn</h1>
        <div class="container-fluid">
            <div class="row">
                @php $testimonials = [['img'=>'comment-avatar-dummy.png','sortDesc' => 'Awesome','nama' => 'Ikhsan Fadillah','testimonial' => 'Saya pernah mengikuti kelas online lainnya, tapi cenderung membosankan dan monoton seperti melihat vlog biasa. tapi kelas.com menawarkan hal yang berbeda. praktek yang Riomotret lakukan dan disertai hasil jepretannya dan kualitas videonya sangat bagus.'],
                ['img'=>'mentor-image-small.png','sortDesc' => 'Menarik!','nama' => 'Imam Pras','testimonial' => 'Setelah menonton kelas ini saya sadar bahwa proses tidak akan menghianati hasil. Perjuangan Chef Juna untuk menjadi seorang chef dan advice yang diberikan sangat inspiratif. Teknik memasak yang diajarkan juga sangat beragam dan eksklusif.'],
                ['img'=>'mentor-testimonial-1.png','sortDesc' => 'Bagus sekali','nama' => 'Hanif Han','testimonial' => "Pelajaran make up dari Ryan membuka pengetahuan saya tentang makeup. makeup itu tidak harus berlebihan. Saya suka sekali cara Ryan menjelaskan bagaimana memilih makeup yang tepat sesuai kebutuhan kita. Sangat berguna bagi para pemula maupun yang sudah menjadi makeup artist."]
                ]; @endphp
                @foreach ($testimonials as $testimonial)
                <div class="col-md-4 testimonial__item">
                    <img class="mb-1" src="{{URL::asset('/img/mentor-img/mentor-image-small.png')}}" alt="tatler-class-mentor-image">
                    <div class="testimonial__text__container">
                        <div class="testimonial__item__text">
                            <h4>{{ $testimonial['sortDesc'] }}</h4>
                            <p>{{ $testimonial['testimonial'] }}</p>
                            <div class="testimonial__item__mentor">
                                <img class="mr-3" src="{{URL::asset('/img/mentor-img/'.$testimonial['img'])}}" alt="tatler-class-mentor-image">
                                <span>{{ $testimonial['nama'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('../partials/landing-page/try-trial')


    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tetler Class</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        This is landing page
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
