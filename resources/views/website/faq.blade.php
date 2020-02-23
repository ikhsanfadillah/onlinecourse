@extends('layouts.app')

@section('content')
    <div class="notification container d-flex flex-column">
        <div class="page-title">
            <h5>FAQ</h5>
        </div>
        <div class="d-flex flex-column">
            @foreach($faqs as $faq)
                <a href="{{ $notification->data['action_url'] }}" class="notification-item">
                    <p class="notification-text">
                        <b>{{ $notification->data['user']['name'] }} </b>
                    </p>
                    <p>{{ $notification->data['comment']['text'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection