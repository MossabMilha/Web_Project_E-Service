<nav class="border-b-blue-400 border-b-2 h-20 p-4 flex justify-between items-center">
    <img class="w-16" src="{{asset('svg/e-service-logo.svg')}}" alt="e-service-logo">
    <ul class="flex gap-4">
        <li><x-nav-link href="home" :active="request()->is('home')">Home</x-nav-link></li>
        <li><x-nav-link href="courses" :active="request()->is('courses')">Courses</x-nav-link></li>
        <li><x-nav-link href="re-enrollment"  :active="request()->is('re-enrollment')">Re-Enrollment</x-nav-link></li>
        <li><x-nav-link href="requests" :active="request()->is('requests')">Requests</x-nav-link></li>
        <li><x-nav-link href="grades" :active="request()->is('grades')">Grades</x-nav-link></li>
        <li><x-nav-link href="prof-details" :active="request()->is('prof-details')">Professor Details</x-nav-link></li>
    </ul>
    <div class="flex gap-6 items-center">
        <a href=""><i class="flex justify-center items-center text-2xl text-blue-600 bi bi-bell"></i></a>
        <a href="profile"><i class="flex justify-center items-center text-2xl text-blue-600 bi bi-person-circle "></i></a>
    </div>
</nav>
