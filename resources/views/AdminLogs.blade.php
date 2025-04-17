<x-layout :title="'logs'">
    <x-slot:head>
        @vite([
            'resources/css/AdminLogs.css',
            'resources/js/components/user-role-styling.js'
//            'resources/js/AdminLogs.js'
        ])
    </x-slot:head>

    <x-nav/>

    {{--  body  --}}
    <div class="main-container">
        <form method="GET" action="{{ route('logs.sort') }}">
            <button type="submit" formaction="{{ route('logs.export') }}">
                <img src="{{asset('png/excel.png')}}" alt="excel image">
                <span>Export current logs</span>
            </button>
            <x-table>
                <table>
                    <thead>
                    <tr>
                        <th>
                            Log ID
                            <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => 'asc'])) }}">↑</a>
                            <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => 'desc'])) }}">↓</a>
                        </th>
                        <th>
                            User Role
                            <select name="role" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>admin</option>
                                <option value="department_head" {{ request('role') == 'department_head' ? 'selected' : '' }}>department_head</option>
                                <option value="coordinator" {{ request('role') == 'coordinator' ? 'selected' : '' }}>coordinator</option>
                                <option value="professor" {{ request('role') == 'professor' ? 'selected' : '' }}>professor</option>
                                <option value="vacataire" {{ request('role') == 'vacataire' ? 'selected' : '' }}>vacataire</option>
                            </select>
                        </th>
                        <th>User Name</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>
                            Created At
                            <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => 'asc'])) }}">↑</a>
                            <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => 'desc'])) }}">↓</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td><div class="role">{{$log->user->role}}</div></td>
                            <td>{{ $log->user->name }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if ($logs->hasPages())
                    <div class="pagination">
                        <a href="{{ $logs->previousPageUrl() }}" class="prev-btn {{ $logs->onFirstPage() ? 'disabled' : '' }}">< previous</a>
                        <span class="page-info">{{ $logs->currentPage() }} | {{ $logs->lastPage() }}</span>
                        <a href="{{ $logs->nextPageUrl() }}" class="next-btn {{ $logs->hasMorePages() ? '' : 'disabled' }}">next ></a>
                    </div>
                @endif
            </x-table>
        </form>
    </div>
</x-layout>
