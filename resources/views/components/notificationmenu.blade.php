<!-- Update the HTML markup -->
<li class="nav-item dropdown bootstrap-things">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        @if ($unread > 0)
            <span id="unread" class="notification-numbers">{{ $unread }}</span>
        @endif
        <img src="/assets/images/notifications.png" alt="notifications">
    </a>
    <ul class="dropdown-menu">
        <li>
            <div id="notifications" class="notification-scroll">
                <div class="notification-container">
                    <!-- Render the existing notifications using your server-side code -->
                    @foreach ($notifications as $notification)
                        <a class="dropdown-item" href="{{ route('notifications.read', $notification->id) }}">
                            <div class="notification-row d-flex align-items-center">
                                {!! $notification->data['title'] !!}
                                <div class="notification-info">
                                    <p class="notification d-flex flex-wrap">
                                        @if ($notification->unread()) <b>*</b> @endif
                                        {{ $notification->data['body'] }}
                                    </p>
                                    <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </li>
    </ul>
</li>
