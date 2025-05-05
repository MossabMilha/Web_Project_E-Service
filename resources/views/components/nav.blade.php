{{--styled by resources/css/components/nav.css--}}
<nav class="nav">
    <img class="nav-logo" src="{{asset('png/ecore-v4.png')}}" alt="Ecore logo">
    <ul class="">
        <li><x-nav-link href="{{route('home')}}" :active="request()->is('home')">Home</x-nav-link></li>
        @if(auth()->user()->role == 'admin')
            <li><x-nav-link href="{{route('UserManagement.search')}}" :active="request()->routeIs('UserManagement.search')">Users</x-nav-link></li>
            <li><x-nav-link href="{{route('logs.sort')}}" :active="request()->routeIs('logs.sort')">logs</x-nav-link></li>
        @elseif(auth()->user()->role == 'department_head')
            <li><x-nav-link href="{{route('department-head.professors.index')}}" :active="request()->routeIs('department-head.professors.index')">Professors Units</x-nav-link></li>
            <li><x-nav-link href="{{route('department-head.professors.unit.requests')}}" :active="request()->routeIs('department-head.professors.unit.requests')">Professors Requests</x-nav-link></li>
            <li><x-nav-link href="{{route('department-head.workload.overview')}}" :active="request()->routeIs('department-head.workload.overview')">Workload</x-nav-link></li>
        @elseif(auth()->user()->role == 'coordinator')
            <li><x-nav-link href="{{route('Coordinator.teachingUnits')}}" :active="request()->routeIs('Coordinator.teachingUnits')">Units</x-nav-link></li>
            <li><x-nav-link href="{{route('VacataireAccount')}}" :active="request()->routeIs('VacataireAccount')">Vacataires</x-nav-link></li>
            <li><x-nav-link href="{{route('Coordinator.ScheduleManagement')}}" :active="request()->routeIs('Coordinator.ScheduleManagement')">Schedules</x-nav-link></li>
        @elseif(auth()->user()->role == 'professor')
            <li><x-nav-link href="{{route('professor.units.request', auth()->user()->id)}}" :active="request()->routeIs('professor.units.request')">Units Requests</x-nav-link></li>
        @elseif(auth()->user()->role == 'vacataire')
            <li><x-nav-link href="{{route('Vacataire.assignedUnit')}}" :active="request()->routeIs('Vacataire.assignedUnit')">Units</x-nav-link></li>
            <li><x-nav-link href="{{route('Vacataire.assessments')}}" :active="request()->routeIs('Vacataire.assessments')">Assessments</x-nav-link></li>
        @endif
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
