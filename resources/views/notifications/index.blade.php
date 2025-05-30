<x-layout title="Notifications">

    <x-slot:head>
        @vite([
            'resources/css/notifications/index.css',
        ])
    </x-slot:head>

    <x-nav/>

    <div class="main-container">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Notifications') }}
                </h2>

                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.mark-all-as-read') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Mark all as read') }}
                        </button>
                    </form>
                @endif
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if(session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif

                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Unread Notifications') }}</h3>
                                <div class="space-y-4">
                                    @foreach(auth()->user()->unreadNotifications as $notification)
                                        <x-notification :notification="$notification"/>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('All Notifications') }}</h3>
                        @if($notifications->count() > 0)
                            <div class="space-y-4">
                                @foreach($notifications as $notification)
                                    <x-notification :notification="$notification"/>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                {{ $notifications->links() }}
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No notifications') }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ __('You don\'t have any notifications at the moment.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
