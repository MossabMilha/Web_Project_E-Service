<x-layout title="Home">
{{--    here to add head element like scripts, links, metas, etc.. (inside x-slot:head)--}}
    <x-slot:head>
        @vite([
            // css files
            'resources/css/components/header.css',
            'resources/css/components/card.css',
            // js files
            'resources/js/home.js',
            'resources/js/components/user-role-styling.js',
        ])
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            @if(auth()->user()->role == "admin")
                @php
                    $totalUsers = App\Models\User::count();
                    $activeSessions = DB::table('sessions')->count();
                    $totalLogs = App\Models\LogModel::count();
                    $loginData = App\Models\LogModel::where('action', 'login_success')
                                            ->where('created_at', '>=', now()->subDays(8))
                                            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                            ->groupBy('date')
                                            ->pluck('count')
                @endphp
                <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-2 mb-2">
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/5 flex flex-col justify-around text-blue-600">
                            <h5 class="text-2xl">Total Users</h5>
                            <span class="text-4xl">{{ $totalUsers ?? 'N/A' }}</span>
                        </div>
                        <div class="flex-2/5 flex items-end justify-end"><img style="height: 48px;" src="{{asset('png/total-users.png')}}" alt="dead image"></div>
                    </div>
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/5 flex flex-col gap-y-1.5 justify-around text-blue-600">
                            <h5 class="text-2xl">Active Sessions</h5>
                            <span class="text-4xl">{{ $activeSessions ?? 'N/A' }}</span>
                        </div>
                        <div class="flex-2/5 flex items-end justify-end"><img style="height: 48px;" src="{{asset('png/sessions.png')}}" alt="dead image"></div>
                    </div>
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/5 flex flex-col justify-around text-blue-600">
                            <h5 class="text-2xl">Total Logs</h5>
                            <span class="text-4xl">{{ $totalLogs ?? 'N/A' }}</span>
                        </div>
                        <div class="flex-2/5 flex items-end justify-end"><img style="height: 48px;" src="{{asset('png/log.png')}}" alt="dead image"></div>
                    </div>
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/5 flex flex-col justify-around text-blue-600">
                            <h5 class="text-2xl">Error Reports</h5>
                            <span class="text-4xl">{{ $errorReports ?? 'N/A' }}</span>
                        </div>
                        <div class="flex-2/5 flex items-end justify-end"><img style="height: 48px;" src="{{asset('png/dead-v2.png')}}" alt="dead image"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mb-4">
                    <div class="flex flex-col p-4 rounded-lg" style="background-color: var(--color-primary);">
                        <h5 class="text-2xl text-white mb-4">Daily Login Activity</h5>
                        <canvas class="rounded-md p-4" style="background-color: var(--color-white)" id="loginChart"></canvas>
                        <script>
                            const loginData = @json($loginData);
                        </script>
                    </div>
                    <div class="p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <h5 class="text-2xl text-blue-600 mb-4">Recent Logs</h5>
                        <div class="space-y-2">
                            @foreach(App\Models\LogModel::latest()->take(7)->get() as $log)
                                <div class="flex items-center justify-between p-2 bg-white rounded">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-600">{{ $log->created_at }}</span>
                                        <span class="text-gray-800">{{ $log->action }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif(auth()->user()->role == 'department_head')
                @php
                    // New query for weekly request trend data using reviewed_at column
                    $weeklyRequestsData = [];
                    $weeksToShow = 6; // Show data for last 6 weeks

                    for ($i = $weeksToShow - 1; $i >= 0; $i--) {
                        $weekStart = now()->subWeeks($i)->startOfWeek();
                        $weekEnd = now()->subWeeks($i)->endOfWeek();

                        // Using reviewed_at as the timestamp for when the request was approved/rejected
                        $weeklyApproved = App\Models\UnitsRequest::where('status', 'approved')
                            ->whereBetween('reviewed_at', [$weekStart, $weekEnd])
                            ->count();

                        $weeklyRejected = App\Models\UnitsRequest::where('status', 'rejected')
                            ->whereBetween('reviewed_at', [$weekStart, $weekEnd])
                            ->count();

                        $weeklyRequestsData[] = [
                            'week' => $weekStart->format('M d') . ' - ' . $weekEnd->format('M d'),
                            'approved' => $weeklyApproved,
                            'rejected' => $weeklyRejected
                        ];
                    }
                @endphp
                @php
                    // Existing queries
                    $totalTUs = App\Models\TeachingUnit::count() ?? 'N/A';
                    $assignedTUs = App\Models\TeachingUnit::whereHas('assignments')->count() ?? 'N/A';
                    $totalProfs = App\Models\User::where('role', 'professor')->count() ?? 'N/A';
                    $flaggedCount = DB::table('users as p')
                        ->join('workload_profiles as wp', 'wp.type', '=', 'p.role')
                        ->leftJoin('assignments as a', 'a.professor_id', '=', 'p.id')
                        ->leftJoin('teaching_units as u', 'u.id', '=', 'a.unit_id')
                        ->where('p.role', 'professor')
                        ->selectRaw("p.id, COALESCE(SUM(u.hours),0) as total_hours, wp.min_hours, wp.max_hours")
                        ->groupBy('p.id', 'wp.min_hours', 'wp.max_hours')
                        ->havingRaw('total_hours < wp.min_hours OR total_hours > wp.max_hours')
                        ->count();

                    // New query for request statistics
                    $approvedRequests = App\Models\UnitsRequest::where('status', 'approved')->count();
                    $rejectedRequests = App\Models\UnitsRequest::where('status', 'rejected')->count();
                    $pendingRequests = App\Models\UnitsRequest::where('status', 'pending')->count();
                    $requestStats = [
                        'approved' => $approvedRequests,
                        'rejected' => $rejectedRequests,
                        'pending' => $pendingRequests
                    ];
                @endphp

                {{-- Statistics cards showing teaching units and professors overview --}}
                <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-2 mb-2">
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/4 flex flex-col justify-around text-blue-600">
                            <h5 class="text-2xl">Total Units</h5>
                            <span class="text-4xl">{{$totalTUs}}</span>
                        </div>
                        <div class="flex-1/4 flex items-end justify-end">
                            <img style="height: 48px;" src="{{asset('png/units.png')}}" alt="dead image">
                        </div>
                    </div>
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/4 flex flex-col gap-y-1.5 justify-around text-blue-600">
                            <h5 class="text-2xl">Assigned Units</h5>
                            <span class="text-4xl">{{$assignedTUs}}</span>
                        </div>
                        <div class="flex-1/4 flex items-end justify-end">
                            <img style="height: 52px;" src="{{asset('png/assigned-unit.png')}}" alt="dead image">
                        </div>
                    </div>
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/4 flex flex-col justify-around text-blue-600">
                            <h5 class="text-2xl">Total Professors</h5>
                            <span class="text-4xl">{{$totalProfs}}</span>
                        </div>
                        <div class="flex-1/4 flex items-end justify-end">
                            <img style="height: 48px;" src="{{asset('png/total-users.png')}}" alt="dead image">
                        </div>
                    </div>
                    <div class="flex p-4 rounded-lg" style="background-color: var(--color-secondary);">
                        <div class="flex-3/4 flex flex-col justify-around text-blue-600">
                            <h5 class="text-2xl">Flagged Professors</h5>
                            <span class="text-4xl">{{$flaggedCount}}</span>
                        </div>
                        <div class="flex-1/4 flex items-end justify-end">
                             <img style="height: 48px;" src="{{asset('png/flagged-person.png')}}" alt="dead image">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-2 mb-2">
                    <div class="lg:col-span-1 md:col-span-2 sm:col-span-4 col-span-4 flex flex-col rounded-lg shadow-lg border border-blue-100">
                        <h5 class="text-2xl text-white rounded-t-lg p-4 " style="background-color: var(--color-primary);">Unit Request Status</h5>
                        <div class="flex items-center justify-center">
                            <canvas class="bg-white rounded-b-md p-4" id="requestsChart"></canvas>
                        </div>
                        <script>
                            const requestStats = @json($requestStats);
                        </script>
                    </div>
                    <div class="lg:col-span-3 md:col-span-2 sm:col-span-4 col-span-4 flex flex-col rounded-lg shadow-lg border border-blue-100">
                        <h5 class="text-2xl text-white rounded-t-lg p-4 " style="background-color: var(--color-primary);">Recent Unit Requests</h5>
                        <div class="flex flex-col gap-y-2 p-2 justify-between rounded">
                            @foreach(App\Models\UnitsRequest::orderBy('requested_at', 'desc')->take(7)->get() as $request)
                                <div class="flex items-center justify-between p-2 rounded ">
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-gray-600">{{ \Carbon\Carbon::parse($request->requested_at)->format('M d, Y') }}</span>
                                        <span class="text-gray-800">{{ $request->unit->name ?? 'Unknown Unit' }}</span>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded" style="background-color:
                                        @if($request->status === 'approved') var(--color-success-lighter)
                                        @elseif($request->status === 'rejected') var(--color-danger-lighter)
                                        @else var(--color-warning-lighter)
                                        @endif;
                                        color:
                                        @if($request->status === 'approved') var(--color-success-dark);
                                        @elseif($request->status === 'rejected') var(--color-danger-dark);
                                        @else var(--color-warning-dark);
                                        @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endif

            <div class="flex flex-col gap-0.5 py-2 px-3 rounded-md mb-2" style="background-color: var(--color-tertiary);">
                <h2 style="color: var(--color-white);" class="text-2xl font-semibold ">Academic Management Tools</h2>
                <p  style="color: var(--color-white);">
                    Explore the features and services tailored to your role to manage academic tasks efficiently.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-2">

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
                    <x-card :card_img="'png/units.jpg'" :card_title="'Professors Units'" :card_link="'department-head.teaching-units.index'">
                        Oversee and assign academic units to professors, ensuring optimal distribution and alignment with their expertise.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/units.jpg'" :card_title="'Professors List'" :card_link="'department-head.professors.index'">
                        Oversee and assign academic units to professors, ensuring optimal distribution and alignment with their expertise.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/requests.jpg'" :card_title="'Units Requests'" :card_link="'department-head.professors.unit.requests'">
                        Handle unit requests submitted by professors, streamlining approvals and maintaining clear academic workflows.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/workload.jpg'" :card_title="'Workload'" :card_link="'department-head.workload.overview'">
                        Monitor and balance professors’ teaching workloads for fair distribution and effective academic planning.
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
                    <x-card :card_img="'png/part-time.jpg'" :card_title="'Vacatire Management'" :card_link="'Coordinator.VacataireAccount.index'">
                        Manage part-time instructors, their assignments, and teaching hours with ease.
                    </x-card>
                </div>
                <div class="flex justify-center">
                    <x-card :card_img="'png/schedule.jpg'" :card_title="'Schedule Management'" :card_link="'Coordinator.ScheduleManagement'">
                        plan and manage course schedules, classrooms, and instructor availability.
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
                    <x-card :card_img="'png/request.jpg'" :card_title="'requests'" :card_link="'professor.units.request'" :link_param="['id' => auth()->user()->id]" >
                        Submit new requests and track the status of your existing ones with ease.
                    </x-card>
                </div>
            @endif
            </div>
        </section>
    </main>

</x-layout>
