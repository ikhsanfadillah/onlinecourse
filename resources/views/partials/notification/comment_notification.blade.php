@php
    $data = $notification->data;
@endphp
<li class="nav-dropdown__menu">class="nav-dropdown__menu"
    <a href="{{ $data['action_url'] }}">{{ $notification->type }}</a>
</li>
