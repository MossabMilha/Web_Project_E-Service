<x-layout title="Home">
{{--    here to add head element like scripts, links, metas, etc.. (inside x-slot:head)--}}
    <x-slot:head>
        @vite([
            // css files
            'resources/css/components/header.css',
            'resources/css/components/card.css',
            // js files
            'resources/js/components/user-role-styling.js'
        ])
    </x-slot:head>

{{--    here to include nav bar --}}
    <x-nav/>

{{--    here to include content --}}
    {{--    header --}}
    @if(auth()->user())
        <x-header :userrole="auth()->user()->role" :username="auth()->user()->name" :background_url="'png/3566.jpg'"/>
    @endif
    {{--    main --}}
    <main class="p-2">
        <section class="tools-section">
            {{--    TODO: make h2 and p dynamic depending on the user--}}
            <h2 class=" m-4 text-2xl font-semibold mb-2 text-gray-800">Academic Management Tools</h2>
            <p class=" m-4 text-gray-600 mb-6">
                Manage key academic operations including teaching units, contractual staff, and schedule planning.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @if(auth()->user()->role == "admin")
                <x-card :card_title="'E-Core Users'" :card_link="route('UserManagement.search')">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                </x-card>
                {{-- I Add This --}}{{--(X_X)--}}
                <x-card :card_title="'E-Core Logs'" :card_link="route('logs.sort')">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                </x-card>
            @elseif(auth()->user()->role == "department_head")
                <x-card :card_title="'E-core Professors'" :card_link="route('department-head.professors.index')">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                </x-card>
            @elseif(auth()->user()->role == "coordinator")
                <x-card :card_title="'Teaching Unit Management'" :card_link="route('Coordinator.teachingUnits')">
                    Teaching Unit Management helps coordinators handle course content, assign instructors, and keep everything on schedule in one place.
                </x-card>
                <x-card :card_title="'Vacatire Management'" :card_link="route('VacataireAccount')">
                    Manage part-time instructors, their assignments, and teaching hours with ease.
                </x-card>
                <x-card :card_title="'Schedule Management'" :card_link="route('Coordinator.ScheduleManagement')">
                    Easily plan and manage course schedules, classrooms, and instructor availability.
                </x-card>
            @endif
            </div>
        </section>
    </main>

</x-layout>
