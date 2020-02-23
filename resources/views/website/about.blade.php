@extends('layouts.app')

@section('content')
  
    <div class="about">
        <img src="{{URL::asset('/img/decoration/header-decoration.png')}}" class="header-decoration">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="overline">Tentang Tatler Class</p>
                    <h1>Tatler Class</h1>
                    <p class="body-2">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>
                </div>
            </div>
        </div>
    </div>

    @include('../partials/landing-page/summary-desc',['mentors' => $data['mentorCount'],'lessons' => $data['lessonCount'], 'minutes' => 15])

    @include('../partials/landing-page/video-preview')

    <div class="mentor-request">
        <div class="container">
            <div class="row">
                <div class="col-md-7 d-flex flex-column align-self-center">
                    <h1>Tidak Menemukan Mentor Favoritmu?</h1>
                    <p class="body-2">
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.
                    </p>
                </div>
                <div class="col-md-5">
                    <div class="mentor-request__img">
                        <img class="mentor-request__img__main" src="{{URL::asset('/img/decoration/mentor-req-img.png')}}">
                        <img class="mentor-request__img__decor" src="{{URL::asset('/img/decoration/decoration-2.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('../partials/landing-page/try-trial')

@endsection
