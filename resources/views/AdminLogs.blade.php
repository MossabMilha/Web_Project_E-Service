<x-layout :title="'logs'">
    <x-slot:head>
        @vite([
            'resources/css/AdminLogs.css',
            'resources/css/components/filter-select.css',

            //'resources/js/AdminLogs.js'
            'resources/js/components/user-role-styling.js',
            'resources/js/components/filter-select.js',
        ])
    </x-slot:head>

    <x-nav/>

    {{--  body  --}}
    <div class="main-container">
        <form method="GET" action="{{ route('logs.sort') }}" id="filters-form">
            <button class="log-export-button" type="submit" formaction="{{ route('logs.export') }}">
                <img src="{{asset('png/excel.png')}}" alt="excel image">
                <span>Export current logs</span>
            </button>
            <div class="desktop">
                <x-table>
                    <table>
                        <thead>
                        <tr>
                            <th>
                                <div class="th-wrapper">
                                    <span>Log ID</span>
                                    <div class="sort-buttons">
                                        <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => 'asc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                        <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'id', 'sort_order' => 'desc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <x-filter-select
                                        name="role"
                                        :options="[
                                                    'all' => 'All',
                                                    'admin' => 'admin',
                                                    'department_head' => 'department head',
                                                    'coordinator' => 'coordinator',
                                                    'vacataire' => 'vacataire'
                                                    ]"
                                        label="Role"
                                        default="all"
                                        formId="filters-form"
                                    />
                                </div>
                            </th>
                            <th>
                                <div class="th-wrapper">User Name</div>
                            </th>
                            <th>
                                <div class="th-wrapper">Action</div>
                            </th>
                            <th>
                                <div class="th-wrapper">Description</div>
                            </th>
                            <th>
                                <div class="th-wrapper">
                                    <span>Created At</span>
                                    <div class="sort-buttons">
                                        <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => 'asc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                        <a href="{{ route('logs.sort', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => 'desc'])) }}"><img
                                                src="{{asset('png/arrow up 2.png')}}" alt=""></a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    <div class="td-wrapper"> {{ $log->id }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper">
                                        <div class="role">{{$log->user->role}}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="td-wrapper"> {{ $log->user->name }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper"> {{ $log->action }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper"> {{ $log->description }}</div>
                                </td>
                                <td>
                                    <div class="td-wrapper"> {{ $log->created_at }}</div>
                                </td>
                            </tr>
                        @endforeach
                        @if(!$logs || $logs->isEmpty())
                            <tr>
                                <td class="colspan-all">
                                    <div class="empty-table">
                                        <img src="{{asset('png/no-data-found.jpg')}}" alt="no data found img">
                                        <p><span><strong>Oops,</strong></span><br>No Data Found!</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </x-table>
            </div>
            <div class="mobile">
                <div class="cards-grid">
                    @foreach($logs as $log)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-id">#{{ $log->id }}</div>
                                <div class="user-role">
                                    <div class="role">{{$log->user->role}}</div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="info-row">
                                    <span class="label">User:</span>
                                    <span class="value">{{ $log->user->name }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Action:</span>
                                    <span class="value">{{ $log->action }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Description:</span>
                                    <span class="value">{{ $log->description }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Created:</span>
                                    <span class="value">{{ $log->created_at }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="card">
                        <div class="card-body">
                            @if(!$logs || $logs->isEmpty())
                                <div class="empty-table">
                                    <img src="{{asset('png/no-data-found.jpg')}}" alt="no data found img">
                                    <p><span><strong>Oops,</strong></span><br>No Data Found!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if ($logs->hasPages())
                <div class="pagination">
                    <a href="{{ $logs->previousPageUrl() }}"
                       class="prev-btn {{ $logs->onFirstPage() ? 'disabled' : '' }}">< previous</a>
                    <span class="page-info">{{ $logs->currentPage() }} | {{ $logs->lastPage() }}</span>
                    <a href="{{ $logs->nextPageUrl() }}"
                       class="next-btn {{ $logs->hasMorePages() ? '' : 'disabled' }}">next ></a>
                </div>
            @endif

        </form>
    </div>
</x-layout>
