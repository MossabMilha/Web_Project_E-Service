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
                    <x-card :card_img="'png/users.jpg'" :card_title="'Users'" :card_link="'UserManagement.search'">
                        Manage user accounts, roles, and access permissions to ensure secure and organized system usage.
                    </x-card>
                </div>
                <div class="flex justify-center">
                <x-card :card_img="'png/logs.jpg'" :card_title="'Logs'" :card_link="'logs.sort'">
                    Track and review system activity logs to maintain transparency, accountability, and troubleshoot issues efficiently.
                </x-card>
                </div>
            {{--   ========================================================    --}}
            {{--    department_head section    --}}
            {{--   ========================================================    --}}
            @elseif(auth()->user()->role == "department_head")
                <div class="flex justify-center">
                    <x-card :card_img="'png/units.jpg'" :card_title="'Professors Units'" :card_link="'department-head.professors.index'">
                        Oversee and assign academic units to professors, ensuring optimal distribution and alignment with their expertise.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/requests.jpg'" :card_title="'Units Requests'" :card_link="'department-head.professors.unit.requests'">
                        Handle unit requests submitted by professors, streamlining approvals and maintaining clear academic workflows.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/workload.jpg'" :card_title="'workload'" :card_link="'department-head.workload.overview'">
                        Monitor and balance professors’ teaching workloads for fair distribution and effective academic planning.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'he is dead'" :card_link="'department-head.professors.index'">
                        Don't revive him X_X
                    </x-card>
                </div>
            {{--   ========================================================    --}}
            {{--    coordinator section    --}}
            {{--   ========================================================    --}}
            @elseif(auth()->user()->role == "coordinator")
                <div class="flex justify-center">
                    <x-card :card_img="'png/units.jpg'" :card_title="'Teaching Unit Management'" :card_link="'Coordinator.teachingUnits'">
                        Handle course content, assign instructors, and keep everything on schedule in one place.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/part-time.jpg'" :card_title="'Vacatire Management'" :card_link="'VacataireAccount'">
                        Manage part-time instructors, their assignments, and teaching hours with ease.
                    </x-card>
                </div>2
                <div class="flex justify-center">
                    <x-card :card_img="'png/schedule.jpg'" :card_title="'Schedule Management'" :card_link="'Coordinator.ScheduleManagement'">
                        plan and manage course schedules, classrooms, and instructor availability.
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
                {{--   ========================================================    --}}
                {{--    professor section    --}}
                {{--   ========================================================    --}}
            @elseif(auth()->user()->role == "professor")
                <div class="flex justify-center">
                    <x-card :card_img="'png/dead.jpg'" :card_title="'requests'" :card_link="'professor.units.request'" :link_param="['id' => auth()->user()->id]" >
                        Easily plan and manage course schedules, classrooms, and instructor availability.
                    </x-card>
                </div>
            @endif
            </div>
        </section>
    </main>

</x-layout>
