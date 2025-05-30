<div class="notification-dropdown">
    <button class="notification-button" id="notificationDropdownButton">
        <i class="bi bi-bell" id="outlineBellIcon"></i>
        <i class="bi bi-bell-fill" id="filledBellIcon" style="display: none;"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </button>
    <div class="dropdown-menu notification-menu" id="notificationDropdownMenu">
        <div class="dropdown-header">
            <h6>Notifications</h6>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="mark-read-btn">Mark all as read</button>
                </form>
            @endif
        </div>

        <div class="notification-list">
            @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                    <div class="notification-content">
                        <p class="notification-text">
                            @if($notification->type === 'App\\Notifications\\LowWorkloadNotification')
                                Your current workload ({{ $notification->data['current_workload'] }} hours) is below the required minimum ({{ $notification->data['minimum_required'] }} hours).
                            @else
                                {{ $notification->data['message'] ?? 'New notification' }}
                            @endif
                        </p>
                        <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="mark-read-single-btn">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="empty-notifications">
                    <p>No notifications found</p>
                </div>
            @endforelse
        </div>

        <div class="dropdown-footer">
            <a href="{{ route('notifications.index') }}" class="view-all-link">View all notifications</a>
        </div>
    </div>
</div>
