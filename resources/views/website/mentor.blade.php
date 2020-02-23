@extends('layouts.app')

@section('content')

    <div class="mentor-show">
        <div class="container">
            <div class="row">
                <div class="mentor-show__video-preview col-md-7">
                    <video width="100%" height="" controls>
                        <source src="{{ $mentor->getFirstMediaUrl('highlight-video') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="container">
                        <div class="summary-desc">
                            <div class="summary-desc__item">
                                <img src="{{URL::asset('/img/icon/summary-desc-class.png')}}" alt="tatler-class">
                                <div class="summary-desc__item__text">
                                    <h2>{{ count($lessons) }} Chapters</h2>
                                    <span class="body-2">from the mentors</span>
                                </div>
                            </div>
                            <div class="summary-desc__item">
                                <img src="{{URL::asset('/img/icon/summary-desc-lesson.png')}}" alt="tatler-lesson">
                                <div class="summary-desc__item__text">
                                    <h2>{{ count($lessons) }} Minutes</h2>
                                    <span class="body-2">average per video</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mentor-show__video-desc col-md-5">
                    <label class="overline">{{ $mentor->profesi }}</label>
                    <h1>{{ $mentor->user->name }}</h1>
                    <span>4.583 student enrolled</span>
                    <p class="body-2">{{ $mentor->desc }}</p>
                    <div class="mentor-show__price">
                        <span>{{ 'Rp '.number_format($mentor->price,2,',','.') }}</span>/kelas
                    </div>
                    <form action="{{ route('main.comment.enroll',$mentor->user->username) }}" method="POST">
                        @csrf
                        <button class="btn--large">Beli Kelas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php //$comment = $mentor->getBestComment() ?>
    {{--@if(!empty($comment))
        <div class="mentor__fetured-comments mb-5">
        <div class="container">
            <h1 class="mb-3">Featured Comment</h1>
            <div class="mentor__fetured-comments__comment">
                <div class="mentor__fetured-comments__avatar">
                    <img src="{{ $comment->getAvatar() ?: asset('/img/mentor-img/comment-avatar-dummy.png')}}" alt="Best Comment" style="max-height: 400px; max-width: 400px; object-fit: cover">
                </div>
                <div class="mentor__fetured-comments__text">
                    <h4 class="mb-1">{{ $comment->user->name }}</h4>
                    <div class="mentor__fetured-comments__text__rating mb-1">
                        @for ($i = 1; $i <= intval($comment->rating); $i++)
                            <img src="{{URL::asset('/img/icon/rating-icon.png')}}" alt="tatler-lesson">
                        @endfor
                    </div>
                    <span class="mentor__fetured-comments__text__time">
                    2 months ago
                </span>
                    <p class="body-2 mt-2">{{$comment->testimonial}}</p>
                </div>
            </div>
        </div>
    </div>
    @endif --}}

    <div class="mentor__fetured-comments mb-5">
        <div class="container">
            <h1 class="mb-3">Rating Paling Membantu</h1>
            <div class="mentor__fetured-comments__comment">
                <div class="mentor__fetured-comments__avatar">
                    <img src="{{ asset('/img/mentor-img/comment-avatar-dummy.png')}}" alt="Best Comment" style="max-height: 400px; max-width: 400px; object-fit: cover">
                </div>
                <div class="mentor__fetured-comments__text">
                    <h4 class="mb-1">Ikhsan Fadillah</h4>
                    <div class="mentor__fetured-comments__text__rating mb-1">
                        @for ($i = 1; $i <= 4; $i++)
                            <img src="{{URL::asset('/img/icon/rating-icon.png')}}" alt="tatler-lesson">
                        @endfor
                    </div>
                    <span class="mentor__fetured-comments__text__time">
                    2 months ago
                </span>
                    <p class="body-2 mt-2">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="lesson-plan mt-5">
        <div class="container">
            <h1 class="mb-3">Lesson Plan</h1>
            <div class="lesson-plan__box">
                @foreach($lessons as $i => $lesson)
                    <a href="{{ route('main.mentors.lessons.show',[$mentor->user->username,$lesson->slug]) }}">
                        <div class="lesson-plan__box__list__wrapper">
                            <div class="lesson-plan__box__list">
                                <div class="lesson-plan__box__list__number">{{$i+1}}</div>
                                <div class="lesson-plan__box__list__text">
                                    <h5>{{ $lesson->title }}</h5>
                                    <p class="body-2">
                                        {{ $lesson->desc }}
                                    </p>
                                </div>
                            </div>
                            <div class="lesson-plan__box__list__divider"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mentor__comment-form mt-5 mb-5">
        <div class="container">
          <form action="#" method="post">
            @csrf
            <textarea class="mb-2" name="comment" id="txtComment"></textarea>
            <button id="btnSendComment" class="btn btn-secondary">SUBMIT</button>
          </form>
        </div>
      </div>

    <div class="share-course mt-5">
        <div class="container">
            <h6>Share Course</h6>
            <div class="d-flex justify-center">
              <div class="share-course__icons">
                  <a href="#">
                      <div class="footer__socmed__icon"><i class="fab fa-twitter"></i></div>
                  </a>
                  <a href="#">
                      <div class="footer__socmed__icon"><i class="fab fa-facebook"></i></div>
                  </a>
                  <a href="#">
                      <div class="footer__socmed__icon"><i class="fab fa-linkedin"></i></div>
                  </a>
                  <a href="#">
                      <div class="footer__socmed__icon"><i class="fab fa-whatsapp"></i></div>
                  </a>
              </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="video-collection">
            <h1>Rekomendasi Mentor untuk Anda</h1>
            <div class="row justify-content-md-center">
                <p class="body-2 col col-md-8 mb-5">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.</p>
            </div>
            <div class="row mb-4">
                @for ($i = 1; $i <= 3; $i++)
                <div class="col-md-4 video-collection__item mb-4">
                    <img class="mb-1" src="{{ asset('/img/mentor-img/mentor-image-small.png') }}" alt="tatler-class-mentor-image" style="height: 220px; object-fit: cover">
                    <a href="#" class="body-3">Username</a>
                    <label class="label-1">DEVELOPER</label>
                </div>
                @endfor
            </div>
            <div class="row justify-content-md-center">
                <a href="{{ url('/mentors') }}" class="btn--medium">Lihat Semua Mentor</a>
            </div>
        </div>
    </div>

    @guest
        @include('../partials/landing-page/try-trial')
    @endguest

    
@endsection

@section('script')
    <script >
        $(document).ready(function () {
            $("#btnSendComment").click(function (event) {
                event.preventDefault();
                $.ajax({
                    url : "{{ route('main.mentor.send-rating',[$mentor->user->username]) }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        parent_id : 0,
                        text : document.getElementById('txtComment').value,
                        mentor_id : "{{ $mentor->mentor_id }}",
                    },
                    dataType: "json",
                }).done(function(msg) {
                    console.log(msg);
                }).fail(function( jqXHR, textStatus ) {
                    alert( "Request failed: " + textStatus );
                });
            })
        })
    </script>
@endsection

