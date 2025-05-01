{{--styled by resources/css/components/nav.css--}}
<nav class="nav">
    <img class="nav-logo" src="{{asset('png/ecore-v4.png')}}" alt="Ecore logo">
    <ul class="">
        <li><x-nav-link href="{{route('home')}}" :active="request()->is('home')">Home</x-nav-link></li>
        <li><x-nav-link href="courses" :active="request()->is('courses')">Courses</x-nav-link></li>
        <li><x-nav-link href="re-enrollment"  :active="request()->is('re-enrollment')">Re-Enrollment</x-nav-link></li>
        <li><x-nav-link href="requests" :active="request()->is('requests')">Requests</x-nav-link></li>
        <li><x-nav-link href="grades" :active="request()->is('grades')">Grades</x-nav-link></li>
        <li><x-nav-link href="prof-details" :active="request()->is('prof-details')">Professor Details</x-nav-link></li>
    </ul>
{{--    TODO: change the icons and the style--}}
    <div class="flex gap-4">
        <a href=""><i class="flex justify-center items-center text-2xl text-blue-600 bi bi-bell"></i></a>
        <a href="profile"><i class="flex justify-center items-center text-2xl text-blue-600 bi bi-person-circle "></i></a>
    </div>
</nav>
