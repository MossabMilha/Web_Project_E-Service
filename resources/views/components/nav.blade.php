{{--styled by resources/css/components/nav.css--}}
<nav class="nav">
    <div class="logo-wrapper"><img class="nav-logo" src="{{asset('png/ecore-v4.png')}}" alt="Ecore logo"></div>
    <div class="desktop-menu">
        <ul class="nav-links">
            <li>
                <x-nav-link href="{{route('home')}}" :active="request()->is('home')">Home</x-nav-link>
            </li>
            @if(auth()->user()->role == 'admin')
                <li>
                    <x-nav-link href="{{route('UserManagement.search')}}"
                                :active="request()->routeIs('UserManagement.search')">Users
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('logs.sort')}}" :active="request()->routeIs('logs.sort')">logs
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'department_head')
                <li>
                    <x-nav-link href="{{route('department-head.teaching-units.index')}}"
                                :active="request()->routeIs('department-head.teaching-units.index')">Units
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('department-head.professors.index')}}"
                                :active="request()->routeIs('department-head.professors.index')">Professors
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('department-head.professors.unit.requests')}}"
                                :active="request()->routeIs('department-head.professors.unit.requests')">
                        Requests
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('department-head.workload.overview')}}"
                                :active="request()->routeIs('department-head.workload.overview')">Workload
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'coordinator')
                <li>
                    <x-nav-link href="{{route('Coordinator.teachingUnits')}}"
                                :active="request()->routeIs('Coordinator.teachingUnits')">Units
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('Coordinator.VacataireAccount.index')}}" :active="request()->routeIs('Coordinator.VacataireAccount.index')">
                        Vacataires
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('Coordinator.ScheduleManagement')}}"
                                :active="request()->routeIs('Coordinator.ScheduleManagement')">Schedules
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'professor')
                <li>
                    <x-nav-link href="{{route('professor.units.request', auth()->user()->id)}}"
                                :active="request()->routeIs('professor.units.request')">Units Requests
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'vacataire')
                <li>
                    <x-nav-link href="{{route('Vacataire.assignedUnit')}}"
                                :active="request()->routeIs('Vacataire.assignedUnit')">Units
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('Vacataire.assessments')}}"
                                :active="request()->routeIs('Vacataire.assessments')">Assessments
                    </x-nav-link>
                </li>
            @endif
        </ul>
    </div>

    <!-- Mobile navigation -->
    <div id="mobile-menu" class="mobile-menu">
        <ul class="">
            <li>
                <x-nav-link href="{{route('home')}}" :active="request()->is('home')">Home</x-nav-link>
            </li>
            @if(auth()->user()->role == 'admin')
                <li>
                    <x-nav-link href="{{route('UserManagement.search')}}"
                                :active="request()->routeIs('UserManagement.search')">Users
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('logs.sort')}}" :active="request()->routeIs('logs.sort')">logs
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'department_head')
                <li>
                    <x-nav-link href="{{route('department-head.teaching-units.index')}}"
                                :active="request()->routeIs('department-head.teaching-units.index')">Units
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('department-head.professors.index')}}"
                                :active="request()->routeIs('department-head.professors.index')">Professors
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('department-head.professors.unit.requests')}}"
                                :active="request()->routeIs('department-head.professors.unit.requests')">Requests
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('department-head.workload.overview')}}"
                                :active="request()->routeIs('department-head.workload.overview')">Workload
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'coordinator')
                <li>
                    <x-nav-link href="{{route('Coordinator.teachingUnits')}}"
                                :active="request()->routeIs('Coordinator.teachingUnits')">Units
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('Coordinator.VacataireAccount.index')}}" :active="request()->routeIs('Coordinator.VacataireAccount.index')">
                        Vacataires
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('Coordinator.ScheduleManagement')}}"
                                :active="request()->routeIs('Coordinator.ScheduleManagement')">Schedules
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'professor')
                <li>
                    <x-nav-link href="{{route('professor.units.request', auth()->user()->id)}}"
                                :active="request()->routeIs('professor.units.request')">Units Requests
                    </x-nav-link>
                </li>
            @elseif(auth()->user()->role == 'vacataire')
                <li>
                    <x-nav-link href="{{route('Vacataire.assignedUnit')}}"
                                :active="request()->routeIs('Vacataire.assignedUnit')">Units
                    </x-nav-link>
                </li>
                <li>
                    <x-nav-link href="{{route('Vacataire.assessments')}}"
                                :active="request()->routeIs('Vacataire.assessments')">Assessments
                    </x-nav-link>
                </li>
            @endif
        </ul>

    </div>


    {{--    TODO: change the icons and the style--}}
    <div class="user-navigation-wrapper">
        <button class="mobile-menu-button">
            <svg class="w-6 h-6" fill="none" stroke="var(--color-primary)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg class="hidden w-6 h-6" fill="none" stroke="var(--color-primary)" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <a href=""><i class="flex justify-center items-center text-2xl text-blue-600 bi bi-bell"></i></a>
        <x-profile-dropdown
            name="{{auth()->user()->name}}"
            image="{{asset('png/dead.jpg')}}"
            email="{{auth()->user()->email}}"
            :items="[
            ['image' => asset('png/profile-icon.jpg'), 'text' => 'profile', 'url' => route('Profile')],
            'divider',
            ['image' => asset('png/logout-icon.jpg'), 'text' => 'logout' , 'url' => route('logout'), 'method' => 'POST']
            ]"/>
    </div>
</nav>
