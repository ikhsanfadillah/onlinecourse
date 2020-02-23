@extends('layouts.app')

@section('content')

<div class="mentor-show">
    <div class="container">
        <div class="row">
            <div class="mentor-show__video-preview col-md-7">
                <video width="100%" height="" controls>
                    <source src="{{URL::asset("/images/upload/")}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="container">
                    <div class="summary-desc">
                        <div class="summary-desc__item">
                            <img src="{{URL::asset('/img/icon/summary-desc-class.png')}}" alt="tatler-class">
                            <div class="summary-desc__item__text">
                                <h2>12 Chapters</h2>
                                <span class="body-2">from the mentors</span>
                            </div>
                        </div>
                        <div class="summary-desc__item">
                            <img src="{{URL::asset('/img/icon/summary-desc-lesson.png')}}" alt="tatler-lesson">
                            <div class="summary-desc__item__text">
                                <h2>24 Videos</h2>
                                <span class="body-2">average per class</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mentor-show__video-desc col-md-5">
                <label class="overline">Designer</label>
                <h1>Ivanka Sarapova</h1>
                <span>4.583 student enrolled</span>
                <p class="body-2">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi.</p>
                <div class="mentor-show__price">
                    <span>Rp 256.000</span>/kelas
                </div>
                <a class="btn--large" href="#">Beli Kelas</a>
            </div>
        </div>
    </div>
</div>

<div class="mentor__fetured-comments mb-5">
    <div class="container">
        <h1 class="mb-3">Featured Comment</h1>
        <div class="mentor__fetured-comments__comment">
            <div class="mentor__fetured-comments__avatar">
                <img src="{{URL::asset('/img/mentor-img/comment-avatar-dummy.png')}}" alt="tatler-lesson">
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
                <p class="body-2 mt-2">
                    Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="lesson-plan mt-5">
    <div class="container">
        <h1 class="mb-3">Lesson Plan</h1>
        <div class="lesson-plan__box">
            @for ($i = 1; $i <= 9; $i++)
                <a href="#">
                    <div class="lesson-plan__box__list__wrapper">
                        <div class="lesson-plan__box__list">
                            <div class="lesson-plan__box__list__number">{{$i}}</div>
                            <div class="lesson-plan__box__list__text">
                                <h5>Design 101</h5>
                                <p class="body-2">
                                    Bobbi shares her beauty philosophy: Makeup should be quick and natural, and it should enhance who you are. She explains what her class will cover and why she’ll be demonstrating on models of different ages and with a range of skin tones.
                                </p>
                            </div>
                        </div>
                        <div class="lesson-plan__box__list__divider"></div>
                    </div>
                </a>
            @endfor
        </div>
    </div>
</div>

<div class="share-course">
    <div class="container">
        <h6>Share Course</h6>
        <div class="share-course__icons">
            <a href="#">
                <div class="footer__socmed__icon"><i class="fab fa-twitter"></i></div>
            </a>
            <a href="#">
                <div class="footer__socmed__icon"><i class="fab fa-twitter"></i></div>
            </a>
            <a href="#">
                <div class="footer__socmed__icon"><i class="fab fa-twitter"></i></div>
            </a>
        </div>
    </div>

</div>

@include('../partials/landing-page/try-trial')

@endsection
