{{--styled by resources/css/components/nav.css--}}
<nav class="nav">
    <img class="nav-logo" src="{{asset('png/ecore-v4.png')}}" alt="Ecore logo">
    <ul class="">
        <li><x-nav-link href="{{route('home')}}" :active="request()->is('home')">Home</x-nav-link></li>
    </ul>
{{--    TODO: change the icons and the style--}}
    <div class="flex items-center gap-4">
        <a href=""><i class="flex justify-center items-center text-2xl text-blue-600 bi bi-bell"></i></a>
        <x-profile-dropdown
            name="{{auth()->user()->name}}"
            image="{{asset('png/dead.jpg')}}"
            email="{{auth()->user()->email}}"
            :items="[
            ['image' => asset('png/profile-icon.jpg'), 'text' => 'profile', 'url' => route('Profile')],
            'divider',
            ['image' => asset('png/logout-icon.jpg'), 'text' => 'logout' , 'url' => route('logout'), 'method' => 'POST']
            ]" />
    </div>
</nav>
