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

    {{--    nav bar --}}
    <x-nav/>

    {{--    header --}}
    @if(auth()->user())
        <x-header :userrole="auth()->user()->role" :username="auth()->user()->name" :background_url="'png/header-banner.jpg'"/>
    @endif

    {{--    main --}}
    <main class="p-2">
        <section class="tools-section">
            {{--    TODO: make h2 and p dynamic depending on the user--}}
            <h2 class=" m-2 text-2xl font-semibold mb-2 text-gray-800">Academic Management Tools</h2>
            <p class=" m-2 text-gray-600 mb-6">
                Manage key academic operations including teaching units, contractual staff, and schedule planning.
            </p>
            <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-2">
            {{--   ========================================================    --}}
            {{--    admin section    --}}
            {{--   ========================================================    --}}
            @if(auth()->user()->role == "admin")
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'E-Core Users'" :card_link="'UserManagement.search'">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                    </x-card>
                </div>
                <div class="flex justify-center">
                <x-card :card_img="'png/dead.jpg'" :card_title="'E-Core Logs'" :card_link="'logs.sort'">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                </x-card>
                </div>
            {{--   ========================================================    --}}
            {{--    department_head section    --}}
            {{--   ========================================================    --}}
            @elseif(auth()->user()->role == "department_head")
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'ECore Professors'" :card_link="'department-head.professors.index'">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'ECore units request'" :card_link="'department-head.professors.unit.requests'">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'E-core workload'" :card_link="'department-head.workload.overview'">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'E-core Professors'" :card_link="'department-head.professors.index'">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium, voluptates, voluptatibus.
                    </x-card>
                </div>
            {{--   ========================================================    --}}
            {{--    coordinator section    --}}
            {{--   ========================================================    --}}
            @elseif(auth()->user()->role == "coordinator")
                <div class="flex justify-center">
                    <x-card :card_img="'png/units.jpg'" :card_title="'Teaching Unit Management'" :card_link="'Coordinator.teachingUnits'">
                        Teaching Unit Management helps coordinators handle course content, assign instructors, and keep everything on schedule in one place.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/part-time.jpg'" :card_title="'Vacatire Management'" :card_link="'VacataireAccount'">
                        Manage part-time instructors, their assignments, and teaching hours with ease.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/schedule.jpg'" :card_title="'Schedule Management'" :card_link="'Coordinator.ScheduleManagement'">
                        Easily plan and manage course schedules, classrooms, and instructor availability.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'he is dead'" :card_link="'Coordinator.ScheduleManagement'">
                        Don't revive him X_X
                    </x-card>
                </div>
            {{--   ========================================================    --}}
            {{--    vacataire section    --}}
            {{--   ========================================================    --}}
            @elseif(auth()->user()->role == "vacataire")
                <div class="flex justify-center">
                    <x-card :card_img="'png/schedule.jpg'" :card_title="'Assigned Units'" :card_link="'Vacataire.assignedUnit'">
                        Easily plan and manage course schedules, classrooms, and instructor availability.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/schedule.jpg'" :card_title="'Assessments '" :card_link="'Vacataire.assessments'">
                        Easily plan and manage course schedules, classrooms, and instructor availability.
                    </x-card>
                </div>
            @endif
            </div>
        </section>
    </main>

</x-layout>
