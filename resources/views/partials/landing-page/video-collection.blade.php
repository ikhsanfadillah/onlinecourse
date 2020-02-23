<div class="container mb-5">
    <div class="video-collection">
        <h1>Belajar Dari Ahlinya</h1>
        <div class="row justify-content-md-center">
            <p class="body-2 col col-md-8 mb-5">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.</p>
        </div>
        <div class="row mb-4">
            @foreach($mentors as $mentor)
            <div class="col-md-4 video-collection__item mb-4">
                <div class="position-relative">
                    <img class="mb-1" src="{{$mentor->getFirstMediaUrl('primary-photo') ?: asset('/img/mentor-img/mentor-image-small.png')}}" alt="tatler-class-mentor-image" style="height: 220px; object-fit: cover">
                    <div class="position-absolute d-flex" style="bottom: -35px;right: 0px">
                        <button class="btn btn-link" onclick="event.preventDefault(); addToCart('{{$mentor->mentor_id}}','{{\App\Wishlist::TYPE_MENTOR}}')" style="color: #FFAE04;"><i class="fas fa-shopping-cart"></i></button>
                        <form action="{{ route('wishlists.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="wishable_id" value="{{$mentor->mentor_id}}">
                            <input type="hidden" name="wishable_type" value="{{ \App\Wishlist::TYPE_MENTOR }}">
                            <button type="submit" class="btn btn-link" style="color: #FFAE04;"><i class="fas fa-heart"></i></button>
                        </form>
                    </div>
                </div>
                <a href="{{ url('/mentors',$mentor->user->username) }}" class="body-3">{{ $mentor->user->name }}</a>
                <label class="label-1">{{ $mentor->profesi }}</label>
            </div>
            @endforeach
        </div>
    </div>
</div>
