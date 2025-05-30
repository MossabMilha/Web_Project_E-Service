
<div class="notification-card {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} rounded-lg shadow-sm p-4 border border-gray-100">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center mb-1">
                <div class="bg-blue-100 rounded-full p-2 mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">{{ $notification->created_at->format('M d, Y · H:i') }}</span>
                
                @if(!$notification->read_at)
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        New
                    </span>
                @endif
            </div>
            
            <div class="notification-content mt-1">
                @if($notification->type === 'App\\Notifications\\LowWorkloadNotification')
                    <h4 class="text-gray-800 font-medium mb-1">Workload Alert</h4>
                    <p class="text-gray-600 text-sm">
                        Your current teaching workload is <span class="font-medium">{{ $notification->data['current_workload'] }} hours</span>.
                        The minimum required workload is <span class="font-medium">{{ $notification->data['minimum_required'] }} hours</span>.
                    </p>
                    <div class="mt-3">
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                            Review Assignments
                            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                @else
                    <h4 class="text-gray-800 font-medium mb-1">{{ $notification->data['title'] ?? 'Notification' }}</h4>
                    <p class="text-gray-600 text-sm">{{ $notification->data['message'] ?? 'You have a new notification.' }}</p>
                @endif
            </div>
        </div>
        
        @if(!$notification->read_at)
            <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-gray-600 focus:outline-none ml-3" title="Mark as read">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </form>
        @endif
    </div>
</div>