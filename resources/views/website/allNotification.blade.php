@extends('layouts.app')

@section('content')
  <div class="notification container d-flex flex-column">
    <div class="page-title">
      <h5>NOTIFICATION</h5>
    </div>
    <div class="d-flex flex-column">
      @php
      @endphp
      @forelse($notifications as $notification)
        <a href="{{ $notification->data['action_url'] }}" class="notification-item">
          <p class="notification-text">
              <b>{{ $notification->data['user']['name'] }} </b>
          </p>
          <p>{{ $notification->data['comment']['text'] }}</p>
        </a>
        @empty
          <div class="notification-item">
            <p class="notification-text">
                Tidak ada notifikasi
            </p>
          </div>
      @endforelse
    </div>
  </div>
@endsection