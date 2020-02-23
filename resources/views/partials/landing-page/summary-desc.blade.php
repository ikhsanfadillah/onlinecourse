<div class="container">
    <div class="summary-desc">
        <div class="summary-desc__item">
            <img src="{{asset('/img/icon/summary-desc-class.png')}}" alt="tatler-class">
            <div class="summary-desc__item__text">
                <h2>{{ $mentors > 50 ? '50+' : $mentors }} Mentors</h2>
                <span class="body-2">profesional mentors</span>
            </div>
        </div>
        <div class="summary-desc__item">
            <img src="{{asset('/img/icon/summary-desc-lesson.png')}}" alt="tatler-lesson">
            <div class="summary-desc__item__text">
                <h2>{{ $lessons > 50 ? '50+' : $lessons }} Lessons</h2>
                <span class="body-2">average per class</span>
            </div>
        </div>
        <div class="summary-desc__item">
            <img src="{{asset('/img/icon/summary-desc-duration.png')}}" alt="tatler-duration">
            <div class="summary-desc__item__text">
                <h2>{{ $minutes > 20 ? '20+' : $minutes }} Minutes</h2>
                <span class="body-2">average per lesson</span>
            </div>
        </div>
    </div>
</div>